<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Dossier;
use Illuminate\Support\Facades\Gate;


class PaimentController extends Controller
{
   
    public function index()
    {
        Gate::authorize('paiement.view');

        $paiements = Paiement::with('dossier.client')->latest()->get();
        $dossiers = Dossier::select('idDossier', 'reference')->get();

        // Stats Globales
        $stats = [
            'totalPaye'    => $paiements->sum('montantPaye'),
            'totalReste'   => $paiements->sum('montantReste'),
            'completCount' => $paiements->where('status', 'complet')->count(),
            'totalTransactions' => $paiements->count()
        ];

        return view('paiements.index', compact('paiements', 'dossiers', 'stats'));
    }

    
    public function store(Request $request)
    {       Gate::authorize('paiement.create');

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

        $dossier = Dossier::findOrFail($validatedData['idDossier']);
        
        if (!isset($validatedData['montantReste']) || is_null($validatedData['montantReste'])) {
            $totalDejaPaye = Paiement::where('idDossier', $dossier->idDossier)->sum('montantPaye');
            $validatedData['montantReste'] = max(0, $dossier->montant - ($totalDejaPaye + $validatedData['montantPaye']));
        }

        if (empty($validatedData['date'])) {
            $validatedData['date'] = now()->toDateString();
        }

        Paiement::create($validatedData);

        return redirect()->back()->with('msg', 'Paiement enregistré avec succès.');
    }

  
    public function update(Request $request, $id)
    {    Gate::authorize('paiement.edit');
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

        if (!isset($validatedData['montantReste']) || is_null($validatedData['montantReste'])) {
            $dossier = Dossier::findOrFail($validatedData['idDossier']);
            $totalDejaPaye = Paiement::where('idDossier', $dossier->idDossier)
                ->where('idPaiement', '!=', $id)
                ->sum('montantPaye');
            $validatedData['montantReste'] = max(0, $dossier->montant - ($totalDejaPaye + $validatedData['montantPaye']));
        }

        $paiement->update($validatedData);

        return redirect()->back()->with('msg', 'Paiement mis à jour avec succès.');
    }

    
    public function show($id)
    {           Gate::authorize('paiement.view');

        $paiement = Paiement::with('dossier')->findOrFail($id);
        return view('paiements.show', compact('paiement'));
    }

   
    public function destroy($id)
    {   Gate::authorize('paiement.delete');
        $paiement = Paiement::findOrFail($id);
        $paiement->delete();

        return redirect()->back()->with('msg', 'Paiement supprimé.');
    }
}