<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dossier;
use App\Models\Client;
use App\Models\Departement;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class DossierController extends Controller
{
    public function assign(Request $request, $id)
    {
        $request->validate([
            'idUser' => 'required|exists:users,idUser', 
        ]);
        $dossier = Dossier::findOrFail($id);
        $dossier->update([
            'idUser' => $request->idUser
        ]);

        return redirect()->back()->with('msg', 'Dossier assigné avec succès !');
    }


    public function getEmployes($id)
{
    $employes = User::where('idDepartement', $id)
        ->whereHas('roles', function ($q) {
            $q->where('name', 'employee');
        })
        ->select('idUser', 'firstName', 'lastName')
        ->get();

    return response()->json($employes);
        }
    public function index(Request $request)
    {
    Gate::authorize('dossier.view');

    $user = auth()->user();

    $query = Dossier::with(['client', 'departement', 'user']);

    // 🔥 FILTRAGE PAR ROLE
    if ($user->hasRole('manager')) {
        // manager voit seulement dossiers de son département
        $query->where('idDepartement', $user->idDepartement);
    }

    if ($user->hasRole('employee')) {
        // employé voit seulement ses dossiers assignés
        $query->where('idUser', $user->idUser);
    }

    // 🔍 filtres existants
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('reference', 'like', "%{$search}%")
              ->orWhere('distination', 'like', "%{$search}%")
              ->orWhere('commentaire', 'like', "%{$search}%");
        });
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('idDepartement') && !$user->hasRole('manager')) {
        // manager ne doit pas filtrer par autre département
        $query->where('idDepartement', $request->idDepartement);
    }

    $dossiers     = $query->latest()->paginate(10)->withQueryString();
    $departements = Departement::all();
    $clients      = Client::all();

    return view('dossiers.index', compact('dossiers', 'departements', 'clients'));
}

    public function store(Request $request)
    {
        Gate::authorize('dossier.create');

        $validated = $request->validate([
            'idClient'       => 'required|exists:clients,idClient',
            'idDepartement'  => 'nullable|exists:departements,idDepartement',
            'distination'    => 'nullable|string|max:255',
            'dateVoyage'     => 'nullable|date',
            'nombrePersonnes'=> 'required|integer|min:1',
            'montant'        => 'required|numeric|min:0',
            'commentaire'    => 'nullable|string',
            'nombreJours'    => 'required|integer|min:0',
            'titreDocument'  => 'nullable|string|max:255',
            'status'         => 'in:ouvert,en_cours,ferme',
        ]);

        $validated['reference']    = 'DOS-' . strtoupper(Str::random(8));
        $validated['dateCreation'] = now();

        Dossier::create($validated);

        return redirect()->back()->with('msg', 'Dossier créé avec succès !');
    }

    public function show($id)
    {
        Gate::authorize('dossier.view');

        $dossier = Dossier::with(['client', 'departement', 'presentations', 'paiements'])
                          ->findOrFail($id);

        return view('dossiers.show', compact('dossier'));
    }

    public function edit($id)
    {
        Gate::authorize('dossier.edit');

        $dossier      = Dossier::findOrFail($id);
        $clients      = Client::all();
        $departements = Departement::all();

        return view('dossiers.edit', compact('dossier', 'clients', 'departements'));
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('dossier.edit');

        $dossier = Dossier::findOrFail($id);

        $validated = $request->validate([
            'idClient'       => 'required|exists:clients,idClient',
            'idDepartement'  => 'nullable|exists:departements,idDepartement',
            'distination'    => 'nullable|string|max:255',
            'dateVoyage'     => 'nullable|date',
            'nombrePersonnes'=> 'required|integer|min:1',
            'montant'        => 'required|numeric|min:0',
            'commentaire'    => 'nullable|string',
            'reponse'        => 'nullable|string',
            'nombreJours'    => 'required|integer|min:0',
            'titreDocument'  => 'nullable|string|max:255',
            'status'         => 'in:ouvert,en_cours,ferme',
        ]);

        $dossier->update($validated);

        return redirect()->route('dossiers.show', $id)->with('msg', 'Dossier mis à jour avec succès !');
    }

    public function destroy($id)
    {
        Gate::authorize('dossier.delete');

        Dossier::findOrFail($id)->delete();

        return redirect()->route('dossiers.index')->with('msg', 'Dossier supprimé avec succès !');
    }

    public function exportPdf(Request $request)
    {
        Gate::authorize('dossier.view');

        $query = Dossier::with(['client', 'departement']);

        if ($request->filled('status'))        $query->where('status', $request->status);
        if ($request->filled('idDepartement')) $query->where('idDepartement', $request->idDepartement);

        $dossiers = $query->latest()->get();

        $pdf = Pdf::loadView('dossiers.pdf', compact('dossiers'))->setPaper('a4', 'landscape');

        return $pdf->download('dossiers-' . now()->format('Y-m-d') . '.pdf');
    }
}