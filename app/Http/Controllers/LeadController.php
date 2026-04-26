<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Lead;
use App\Models\User;
use App\Models\Departement;
use App\Models\Client;
use App\Models\Dossier;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('lead.view');

        $query = Lead::with(['user', 'client', 'departements']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('firstName', 'like', "%{$search}%")
                  ->orWhere('lastName', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phoneNumber', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('source', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $leads  = $query->latest()->paginate(10)->withQueryString();
        $types  = Lead::select('type')->distinct()->pluck('type');
        $departements = Departement::all();

        return view('leads.index', compact('leads', 'types', 'departements'));
    }

    public function store(Request $request)
    {
        Gate::authorize('lead.create');

        $validatedData = $request->validate([
            'firstName'     => 'required|string|max:25',
            'lastName'      => 'required|string|max:25',
            'email'         => 'nullable|email|unique:leads,email',
            'address'       => 'nullable|string',
            'CNE'           => 'nullable|string',
            'phoneNumber'   => 'nullable|string',
            'nationalite'   => 'nullable|string',
            'source'        => 'nullable|string',
            'note'          => 'nullable|string',
            'type'          => 'required|string|max:20',
            'idUser'        => 'nullable|exists:users,idUser',
            'idClient'      => 'nullable|exists:clients,idClient',
            'idDepartement' => 'nullable|exists:departements,idDepartement',
        ]);

        $validatedData['dateCreation'] = now()->toDateString();
        $validatedData['statut']       = 'nouveau';

        Lead::create($validatedData);

        return redirect()->back()->with('msg', 'Lead ajouté avec succès !');
    }

    public function show($id)
    {
        Gate::authorize('lead.view');

        $lead        = Lead::with(['user', 'client', 'departements'])->findOrFail($id);
        $users       = User::all();
        $departements = Departement::all();

        return view('leads.show', compact('lead', 'users', 'departements'));
    }

    public function edit($id)
    {
        Gate::authorize('lead.edit');

        $lead         = Lead::findOrFail($id);
        $users        = User::all();
        $departements = Departement::all();

        return view('leads.edit', compact('lead', 'users', 'departements'));
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('lead.edit');

        $lead = Lead::findOrFail($id);

        $validatedData = $request->validate([
            'firstName'     => 'required|string|max:25',
            'lastName'      => 'required|string|max:25',
            'email'         => 'nullable|email|unique:leads,email,' . $id . ',idLead',
            'address'       => 'nullable|string',
            'CNE'           => 'nullable|string',
            'phoneNumber'   => 'nullable|string',
            'nationalite'   => 'nullable|string',
            'source'        => 'nullable|string',
            'note'          => 'nullable|string',
            'type'          => 'required|string|max:20',
            'idUser'        => 'nullable|exists:users,idUser',
            'idClient'      => 'nullable|exists:clients,idClient',
            'idDepartement' => 'nullable|exists:departements,idDepartement',
        ]);

        $lead->update($validatedData);

        return redirect()->route('leads.show', $id)->with('msg', 'Lead mis à jour avec succès !');
    }

    public function updateStatut(Request $request, $id)
{
    Gate::authorize('lead.edit');

    $lead = Lead::findOrFail($id);

    $request->validate([
        'statut'        => 'required|in:1er_appel,2eme_appel,lost,promis,ok',
        'idDepartement' => 'nullable|exists:departements,idDepartement',
        'idUser'        => 'nullable|exists:users,idUser',
        'password'      => 'nullable|required_if:statut,ok|min:6',
    ]);

    $statut = $request->statut;

    if ($statut === '1er_appel' && $lead->statut === 'nouveau') {
        $lead->statut = '1er_appel';

    } elseif ($statut === '2eme_appel' && $lead->statut === '1er_appel') {
        $lead->statut = '2eme_appel';

    } elseif ($statut === 'lost') {
        $lead->statut = 'lost';

    } elseif ($statut === 'promis') {
        $lead->statut = 'promis';

    } elseif ($statut === 'ok') {

        $lead->statut = 'ok';

        if ($request->filled('idDepartement')) {
            $lead->idDepartement = $request->idDepartement;
        }

        if ($request->filled('idUser')) {
            $lead->idUser = $request->idUser;
        }
        $client = Client::where('email', $lead->email)->first();

        if (!$client) {
            $client = Client::create([
                'firstName'     => $lead->firstName,
                'lastName'      => $lead->lastName,
                'email'         => $lead->email,
                'phoneNumber'   => $lead->phoneNumber,
                'address'       => $lead->address,
                'CNE'           => $lead->CNE,
                'nationalite'   => $lead->nationalite,
                'idDepartement' => $request->idDepartement ?? $lead->idDepartement,
                'idUser'        => $request->idUser ?? $lead->idUser,
                'dateCreation'  => now()->toDateString(),
                'password'      => Hash::make($request->password ?? '123456'),
            ]);
        }

        Dossier::create([
            'idClient'        => $client->idClient,
            'idDepartement'   => $request->idDepartement ?? $lead->idDepartement,
            'reference'       => 'DOS-' . strtoupper(Str::random(8)),
            'dateCreation'    => now(),
            'nombrePersonnes' => 1,
            'montant'         => 0,
            'nombreJours'     => 0,
            'status'          => 'ouvert',
            'commentaire'     => 'Dossier créé automatiquement depuis la conversion du lead #' . $lead->idLead . '.',
        ]);

    } else {
        return redirect()->back()->with('error', 'Transition de statut non autorisée.');
    }

    $lead->save();

    $messages = [
        '1er_appel'  => '1er appel enregistré.',
        '2eme_appel' => '2ème appel enregistré.',
        'lost'       => 'Lead marqué comme perdu.',
        'promis'     => 'Lead marqué comme promis.',
        'ok'         => 'Lead converti en client avec succès !',
    ];

    return redirect()
        ->route('leads.show', $id)
        ->with('msg', $messages[$statut]);
}

    public function destroy($id)
    {
        Gate::authorize('lead.delete');

        Lead::findOrFail($id)->delete();

        return redirect()->route('leads.index')->with('msg', 'Lead supprimé avec succès !');
    }

    public function exportPdf(Request $request)
    {
        Gate::authorize('lead.view');

        $query = Lead::with(['user', 'client', 'departements']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('firstName', 'like', "%{$search}%")
                  ->orWhere('lastName', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type'))   $query->where('type', $request->type);
        if ($request->filled('statut')) $query->where('statut', $request->statut);

        $leads = $query->latest()->get();

        $pdf = Pdf::loadView('leads.pdf', compact('leads'))->setPaper('a4', 'landscape');

        return $pdf->download('leads-' . now()->format('Y-m-d') . '.pdf');
    }
}