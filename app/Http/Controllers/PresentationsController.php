<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use Illuminate\Http\Request;

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
            'items.*.prixUnitaire' => 'required|numeric',
            'items.*.quantity'     => 'required|integer|min:1',
        ]);

        return \DB::transaction(function() use ($validated) {
            $presentation = Presentation::create($validated);

            if (!empty($validated['items'])) {
                foreach ($validated['items'] as $itemData) {
                    $presentation->presentationItems()->create([
                        'idCategory'   => $itemData['idCategory'] ?? null,
                        'prixUnitaire' => $itemData['prixUnitaire'],
                        'quantity'     => $itemData['quantity'],
                        'totale'       => $itemData['prixUnitaire'] * $itemData['quantity'],
                    ]);
                }
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
            'items.*.idCategory'   => 'nullable|exists:categories,idCategory',
            'items.*.prixUnitaire' => 'required|numeric',
            'items.*.quantity'     => 'required|integer|min:1',
        ]);

        return \DB::transaction(function() use ($presentation, $validated) {
            $presentation->update($validated);

            if (isset($validated['items'])) {
                // Get existing item IDs to know which ones to delete if they are missing in the request
                $sentItemIds = collect($validated['items'])->pluck('idItems')->filter()->toArray();
                $presentation->presentationItems()->whereNotIn('idItems', $sentItemIds)->delete();

                foreach ($validated['items'] as $itemData) {
                    $data = [
                        'idCategory'   => $itemData['idCategory'] ?? null,
                        'prixUnitaire' => $itemData['prixUnitaire'],
                        'quantity'     => $itemData['quantity'],
                        'totale'       => $itemData['prixUnitaire'] * $itemData['quantity'],
                    ];

                    if (!empty($itemData['idItems'])) {
                        $presentation->presentationItems()->where('idItems', $itemData['idItems'])->update($data);
                    } else {
                        $presentation->presentationItems()->create($data);
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
}