<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conge;
use Illuminate\Support\Facades\Gate;


class CongeController extends Controller
{
    public function index()
    {   
                Gate::authorize('conge.view');

        $conges = Conge::with('user')->get();
        return view('conges.index', compact('conges'));
    }


public function store(Request $request)
{        Gate::authorize('conge.create');

    // Auto-assign the authenticated user if not provided
    if (!$request->has('idUser') && auth()->check()) {
        $request->merge(['idUser' => auth()->user()->idUser ?? auth()->id()]);
    }

    $newConge = $request->validate([
        'idUser'        => 'required|exists:users,idUser',
        'sold'          => 'nullable|integer',
        'type'          => 'required|in:annuel,maladie,sans_solde',
        'justification' => 'nullable|string',
        'motif'         => 'nullable|string|max:255',
        'dateDebut'     => 'nullable|date',
        'dateFin'       => 'nullable|date',
    ]);

    $newConge['dateDemande'] = now()->toDateString(); 
    $newConge['status'] = "en_attente"; 

    Conge::create($newConge);

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
        ]);

        $conge->update($validated);

        return redirect()->back()->with('msg', 'La demande a été modifiée avec succès.');
    }

    public function destroy($id)
    {   Gate::authorize('conge.delete');
        $conge = Conge::findOrFail($id);
        $conge->delete();
        return redirect()->back()->with('msg', 'Demande supprimée');
    }
}