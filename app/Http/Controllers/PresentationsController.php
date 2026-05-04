<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewPresentationMail;

class PresentationsController extends Controller
{
    public function index(Request $request)
    {
        $query = Presentation::with(['dossier', 'presentationItems']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('titre', 'LIKE', "%{$search}%")
                  ->orWhere('comment', 'LIKE', "%{$search}%")
                  ->orWhere('reponse', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('idDossier')) {
            $query->where('idDossier', $request->idDossier);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        return response()->json($query->latest('idPresentation')->paginate(10));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'idDossier' => 'required|exists:dossiers,idDossier',
            'titre'     => 'required|string|max:255',
            'date'      => 'nullable|date',
            'status'    => 'nullable|in:en_attente,validee,refusee',
            'comment'   => 'nullable|string',
            'reponse'   => 'nullable|string',
            'items'     => 'nullable|array',
            'items.*.idCategory'   => 'nullable|exists:categories,idCategory',
            'items.*.nom'          => 'required|string|max:255',
            'items.*.prixUnitaire' => 'required|numeric',
            'items.*.quantity'     => 'required|integer|min:1',
        ]);

        return \DB::transaction(function() use ($validated) {
            $presentation = Presentation::create($validated);

            if (!empty($validated['items'])) {
                foreach ($validated['items'] as $itemData) {
                    $presentation->presentationItems()->create([
                        'idCategory'   => $itemData['idCategory'] ?? null,
                        'nom'          => $itemData['nom'],
                        'prixUnitaire' => $itemData['prixUnitaire'],
                        'quantity'     => $itemData['quantity'],
                        'totale'       => $itemData['prixUnitaire'] * $itemData['quantity'],
                    ]);
                }
            }

            // Send Email to Client
            try {
                $presentation->load('dossier.client');
                if ($presentation->dossier && $presentation->dossier->client && $presentation->dossier->client->email) {
                    Mail::to($presentation->dossier->client->email)->send(new NewPresentationMail($presentation));
                }
            } catch (\Exception $e) {
                // Log error or ignore if mail fails (don't break the transaction for mail)
                \Log::error('Failed to send presentation email: ' . $e->getMessage());
            }

            return response()->json($presentation->load('presentationItems'), 201);
        });
    }

    public function show($id)
    {
        return response()->json(Presentation::with(['dossier', 'presentationItems.category'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $presentation = Presentation::findOrFail($id);

        $validated = $request->validate([
            'idDossier' => 'sometimes|required|exists:dossiers,idDossier',
            'titre'     => 'sometimes|required|string|max:255',
            'date'      => 'nullable|date',
            'status'    => 'sometimes|required|in:en_attente,validee,refusee',
            'comment'   => 'nullable|string',
            'reponse'   => 'nullable|string',
            'items'     => 'nullable|array',
            'items.*.idItems'      => 'nullable|exists:presentation_items,idItems',
            'items.*.nom'          => 'required|string|max:255',
            'items.*.idCategory'   => 'nullable|exists:categories,idCategory',
            'items.*.prixUnitaire' => 'required|numeric',
            'items.*.quantity'     => 'required|integer|min:1',
        ]);

        return \DB::transaction(function() use ($presentation, $validated) {
            $presentation->update($validated);

            if (isset($validated['items'])) {
                $sentItemIds = collect($validated['items'])->pluck('idItems')->filter()->toArray();
                $presentation->presentationItems()->whereNotIn('idItems', $sentItemIds)->delete();

                foreach ($validated['items'] as $itemData) {
                    if (!empty($itemData['idItems'])) {
                        $item = $presentation->presentationItems()->where('idItems', $itemData['idItems'])->first();
                        if ($item) {
                            $item->update([
                                'idCategory' => $itemData['idCategory'] ?? null,
                                'nom' => $itemData['nom'] ?? 'Article',
                                'prixUnitaire' => $itemData['prixUnitaire'],
                                'quantity' => $itemData['quantity'],
                                'totale' => $itemData['prixUnitaire'] * $itemData['quantity'],
                            ]);
                        }
                    } else {
                        $presentation->presentationItems()->create([
                            'idCategory' => $itemData['idCategory'] ?? null,
                            'nom' => $itemData['nom'] ?? 'Article',
                            'prixUnitaire' => $itemData['prixUnitaire'],
                            'quantity' => $itemData['quantity'],
                            'totale' => $itemData['prixUnitaire'] * $itemData['quantity'],
                        ]);
                    }
                }
            }

            return response()->json($presentation->load('presentationItems'));
        });
    }

    public function destroy($id)
    {
        Presentation::findOrFail($id)->delete();
        return response()->json(['message' => 'Presentation deleted successfully'], 200);
    }

    public function duplicate($id)
    {
        return \DB::transaction(function() use ($id) {
            $original = Presentation::with('presentationItems')->findOrFail($id);
            
            // Clean up title to find base name (remove existing - V followed by numbers)
            $baseTitle = preg_replace('/ - V\d+$/', '', $original->titre);
            
            // Count how many versions already exist for this base title in this dossier
            $count = Presentation::where('idDossier', $original->idDossier)
                ->where('titre', 'LIKE', $baseTitle . '%')
                ->count();
            
            $nextVersion = $count + 1;

            // Create the new version
            $new = $original->replicate();
            $new->titre = $baseTitle . ' - V' . $nextVersion;
            $new->status = 'en_attente';
            $new->reponse = null;
            $new->save();

            // Replicate items
            foreach ($original->presentationItems as $item) {
                $newItem = $item->replicate();
                $newItem->idPresentation = $new->idPresentation;
                $newItem->status = 'en_attente'; // Reset status for new version
                $newItem->save();
            }

            // Send Email to Client for the new version
            try {
                $new->load('dossier.client');
                if ($new->dossier && $new->dossier->client && $new->dossier->client->email) {
                    Mail::to($new->dossier->client->email)->send(new NewPresentationMail($new));
                }
            } catch (\Exception $e) {
                \Log::error('Failed to send duplicated presentation email: ' . $e->getMessage());
            }

            return response()->json($new->load('presentationItems'), 201);
        });
    }
}