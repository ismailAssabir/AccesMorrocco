<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conge;
use Illuminate\Support\Facades\Gate;


class CongeController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('conge.view');

        $query = Conge::with('user');

        // Role-based filtering: employees only see their own requests
        if (auth()->user()->type === 'employee') {
            $query->where('idUser', auth()->user()->idUser);
        }

        // Search logic
        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('user', function($q) use ($s) {
                $q->where('firstName', 'LIKE', "%$s%")
                  ->orWhere('lastName', 'LIKE', "%$s%");
            });
        }

        // Status logic
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Type logic
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $conges = $query->latest()->get();

        if ($request->ajax()) {
            return view('conges.partials.table', compact('conges'))->render();
        }

        return view('conges.index', compact('conges'));
    }


public function store(Request $request)
{        Gate::authorize('conge.create');

    // Auto-assign the authenticated user if not provided
    if (!$request->has('idUser') && auth()->check()) {
        $request->merge(['idUser' => auth()->user()->idUser ?? auth()->id()]);
    }

        $request->validate([
            'idUser'        => 'required|exists:users,idUser',
            'sold'          => 'nullable|integer',
            'type'          => 'required|in:annuel,maladie,sans_solde',
            'justification' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:5120',
            'motif'         => 'nullable|string|max:255',
            'dateDebut'     => 'nullable|date',
            'dateFin'       => 'nullable|date',
        ]);

        $data = $request->only(['idUser', 'sold', 'type', 'motif', 'dateDebut', 'dateFin']);

        if ($request->hasFile('justification')) {
            $data['justification'] = $request->file('justification')->store('conges', 'public');
        }

        $data['dateDemande'] = now()->toDateString(); 
        $data['status'] = "en_attente"; 

        Conge::create($data);

    return redirect()->back()->with('msg', 'La demande de congé a été ajoutée avec succès');
}
    
    public function show($id)
    {
        Gate::authorize('conge.view');
        $conge = Conge::with('user')->findOrFail($id);
        return view('conges.show', compact('conge'));
    }

    public function update(Request $request, $id)
    {   
        Gate::authorize('conge.edit');

        $conge = Conge::findOrFail($id);

        // Check if this is an admin status update
        if ($request->has('status')) {
            $request->validate([
                'status' => 'required|in:en_attente,approuve,refuse'
            ]);
            $conge->update(['status' => $request->status]);
            return redirect()->back()->with('msg', 'Le statut a été mis à jour');
        }

        // Otherwise, it's an owner edit request
        // 1. Verify ownership (handling both possible auth ID keys)
        if (!auth()->check() || ($conge->idUser != auth()->id() && $conge->idUser != optional(auth()->user())->idUser)) {
            return redirect()->back()->withErrors(['Modification non autorisée.']);
        }

        // 2. Block if already approved
        if ($conge->status == 'approuve') {
            return redirect()->back()->withErrors(['Impossible de modifier une demande déjà approuvée.']);
        }

        // 3. Validate and Update
        $validated = $request->validate([
            'type'          => 'required|in:annuel,maladie,sans_solde',
            'motif'         => 'nullable|string|max:255',
            'dateDebut'     => 'required|date',
            'dateFin'       => 'required|date',
            'justification' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:5120',
        ]);

        $data = $request->only(['type', 'motif', 'dateDebut', 'dateFin']);

        if ($request->hasFile('justification')) {
            // Optional: delete old file if it exists
            if ($conge->justification && \Illuminate\Support\Facades\Storage::disk('public')->exists($conge->justification)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($conge->justification);
            }
            $data['justification'] = $request->file('justification')->store('conges', 'public');
        }

        $conge->update($data);

        return redirect()->back()->with('msg', 'La demande a été modifiée avec succès.');
    }

    public function destroy($id)
    {   Gate::authorize('conge.delete');
        $conge = Conge::findOrFail($id);
        $conge->delete();
        return redirect()->back()->with('msg', 'Demande supprimée');
    }
}