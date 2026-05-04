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

        $query = Lead::with('client');

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

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        if ($request->filled('nationalite')) {
            $query->where('nationalite', 'like', "%{$request->nationalite}%");
        }

        $leads  = $query->latest()->get(); // Changed to get() to properly display Kanban columns
        $types  = Lead::select('type')->whereNotNull('type')->where('type', '!=', '')->distinct()->pluck('type');
        $sources = Lead::select('source')->whereNotNull('source')->where('source', '!=', '')->distinct()->pluck('source');
        $departements = Departement::all();

        return view('leads.index', compact('leads', 'types', 'sources', 'departements'));
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
            'type_select'   => 'required|string', 
            'type'          => 'nullable|string|max:50',
            'idUser'        => 'nullable|exists:users,idUser',
            'idClient'      => 'nullable|exists:clients,idClient',
            'idDepartement' => 'nullable|exists:departements,idDepartement',
        ]);

        $validatedData['dateCreation'] = now()->toDateString();
        $validatedData['statut']       = 'nouveau';
        $validatedData['type'] = $request->type_select === 'autre' ? $request->type : $request->type_select;
        Lead::create($validatedData);

        return redirect()->back()->with('msg', 'Lead ajouté avec succès !');
    }

   public function show($id)
{
    Gate::authorize('lead.view');

    $lead = Lead::with([
        'user',
        'client.dossiers',  // ✅ client مع dossiers ديالو
        'departements',
    ])->findOrFail($id);

    $users        = User::all();
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
            'idClient'      => 'nullable|exists:clients,idClient',
            'type_select'   => 'required|string',
            'type'          => 'nullable|string|max:50',
        ]);
        $validatedData['type'] = $request->type_select === 'autre' ? $request->type : $request->type_select;
        $lead->update($validatedData);
        return redirect()->route('leads.index', $id)->with('msg', 'Lead mis à jour avec succès !');
    }

  public function updateStatut(Request $request, $id)
{
    Gate::authorize('lead.edit');

    $lead = Lead::findOrFail($id);

    $request->validate([
        'statut'          => 'required|in:nouveau,1er_appel,2eme_appel,lost,promis,ok',
        'note'            => 'nullable|string',
        'pas_de_reponse'  => 'nullable|boolean',
        'duree'           => 'nullable|string',
        'contentAppel'    => 'nullable|string',
        'idDepartement'   => 'nullable|exists:departements,idDepartement',
    ]);

    $statut = $request->statut;

    // Appels : gérer pas_de_reponse + duree/contentAppel
    if (in_array($statut, ['1er_appel', '2eme_appel'])) {
        $pasDeReponse = $request->boolean('pas_de_reponse');
        $lead->pas_de_reponse = $pasDeReponse;

        if ($pasDeReponse) {
            // Client n'a pas répondu — on vide les champs d'appel
            $lead->duree        = null;
            $lead->contentAppel = null;
        } else {
            // Client a répondu — on enregistre durée et contenu
            $lead->duree        = $request->duree;
            $lead->contentAppel = $request->contentAppel;
        }
    } else {
        $lead->pas_de_reponse = false;
    }

    if ($request->filled('note')) {
        $lead->note = $request->note;
    }

    if ($statut === 'ok') {
        $lead->statut = 'ok';

        if ($request->filled('idDepartement')) {
            $lead->idDepartement = $request->idDepartement;
        }

        // ✅ generate password تلقائي
        $plainPassword = Str::random(10);

        $client = Client::where('email', $lead->email)->first();

        if (!$client) {
            $client = Client::create([
                'firstName'   => $lead->firstName,
                'lastName'    => $lead->lastName,
                'email'       => $lead->email,
                'phoneNumber' => $lead->phoneNumber,
                'address'     => $lead->address,
                'CNE'         => $lead->CNE,
                'nationalite' => $lead->nationalite,
                'dateCreation'=> now()->toDateString(),
                'password'    => Hash::make($plainPassword),
                'status'      => 'actif',
            ]);
            $lead->idClient = $client->idClient;
        } else {
            // reset password إلا كان موجود
            $client->password = Hash::make($plainPassword);
            $client->save();
        }

        // ✅ إرسال email
        \Mail::to($client->email)->send(
            new \App\Mail\ClientCreatedMail($client, $plainPassword)
        );

        $dossierExiste = Dossier::where('idClient', $client->idClient)->exists();

        if (!$dossierExiste) {
            Dossier::create([
                'idClient'      => $client->idClient,
                'idDepartement' => $request->idDepartement ?? $lead->idDepartement,
                'reference'     => 'DOS-' . strtoupper(Str::random(8)),
                'dateCreation'  => now(),
                'nombre_personne'=> 1,
                'montant'       => 0,
                'nombre_jours'  => 0,
                'status'        => 'ouvert',
                'commentaire'   => 'Dossier créé depuis le lead #' . $lead->idLead,
            ]);
        }

    } else {
        $lead->statut = $statut;
    }

    $lead->save();

    $messages = [
        'nouveau'    => 'Lead déplacé vers Nouveau.',
        '1er_appel'  => '1er appel enregistré.',
        '2eme_appel' => '2ème appel enregistré.',
        'lost'       => 'Lead marqué comme perdu.',
        'promis'     => 'Lead marqué comme promis.',
        'ok'         => 'Lead converti en client avec succès !',
    ];

    return redirect()->route('leads.index', $id)->with('msg', $messages[$statut] ?? 'Statut mis à jour.');
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