<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Dossier;
use Illuminate\Support\Facades\Gate;


class PaimentController extends Controller
{
   
    public function index()
    {           Gate::authorize('paiment.view');

        $paiements = Paiement::with('dossier')->latest()->get();
        return view('paiements.index', compact('paiements'));
    }

    
    public function store(Request $request)
    {       Gate::authorize('paiment.create');

        $validatedData = $request->validate([
            'idDossier'    => 'required|exists:dossiers,idDossier',
            'montantPaye'  => 'required|numeric|min:0',
            'montantReste' => 'nullable|numeric|min:0',
            'modePaiement' => 'nullable|string',
            'date'         => 'nullable|date',
            'ref'          => 'nullable|string',
            'status'       => 'nullable|in:partiel,complet,annule',
            'note'         => 'nullable|string',
        ]);

        
        if (empty($validatedData['date'])) {
            $validatedData['date'] = now()->toDateString();
        }

        Paiement::create($validatedData);

        return redirect()->back()->with('msg', 'Paiement enregistré avec succès.');
    }

  
    public function update(Request $request, $id)
    {    Gate::authorize('paiment.edit');
        $paiement = Paiement::findOrFail($id);

        $validatedData = $request->validate([
            'idDossier'    => 'required|exists:dossiers,idDossier',
            'montantPaye'  => 'required|numeric|min:0',
            'montantReste' => 'nullable|numeric|min:0',
            'modePaiement' => 'nullable|string',
            'date'         => 'nullable|date',
            'ref'          => 'nullable|string',
            'status'       => 'nullable|in:partiel,complet,annule',
            'note'         => 'nullable|string',
        ]);

        $paiement->update($validatedData);

        return redirect()->back()->with('msg', 'Paiement mis à jour avec succès.');
    }

    
    public function show($id)
    {           Gate::authorize('paiment.view');

        $paiement = Paiement::with('dossier')->findOrFail($id);
        return view('paiements.show', compact('paiement'));
    }

   
    public function destroy($id)
    {   Gate::authorize('paiment.delete');
        $paiement = Paiement::findOrFail($id);
        $paiement->delete();

        return redirect()->back()->with('msg', 'Paiement supprimé.');
    }
}