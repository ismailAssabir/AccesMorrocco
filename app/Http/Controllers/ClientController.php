<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Departement;
use App\Models\Dossier;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClientWelcomeMail;

class ClientController extends Controller
{
    public function exportPdf()
    {
        Gate::authorize('client.view');

        $clients = Client::orderBy('idClient', 'desc')->get();

        $pdf = Pdf::loadView('clients.pdf', compact('clients'))
                    ->setPaper('a4', 'landscape');

        return $pdf->download('clients-' . now()->format('Y-m-d') . '.pdf');
    }
    public function index(){
        Gate::authorize('client.view');
        $clients = Client::orderBy('idClient', 'desc')->get();
        $departements = Departement::all();
        return view('AllClients' , compact("clients", 'departements'));
    }

public function store(Request $request)
{
    Gate::authorize('client.create');

    $validated = $request->validate([
        'firstName'     => 'required|string|max:50',
        'lastName'      => 'required|string|max:50',
        'email'         => 'required|email|unique:clients,email',
        'CNE'           => 'required|string',
        'dateNaissance' => "required|date",
        'phoneNumber'   => 'nullable|min:10|max:15',
        'status'        => 'in:actif,inactif',
        'type_select'   => 'nullable|string',
        'type'          => 'nullable|string|max:50',
        'nationalite'   => 'nullable|string|max:40',
    ]);

    // 🔥 générer password
    $plainPassword = Str::random(10);

    $validated['password'] = Hash::make($plainPassword);

    $validated['type'] = $request->type_select === 'autre'
        ? $request->type
        : $request->type_select;

    $client = Client::create($validated);

    // dossier auto
    Dossier::create([
        'idClient' => $client->idClient,
        'reference' => 'DOS-' . strtoupper(Str::random(8)),
        'dateCreation' => now(),
        'nombrePersonnes' => 1,
        'montant' => 0,
        'nombreJours' => 0,
        'status' => 'ouvert',
    ]);

    // 📧 envoi email
    Mail::to($client->email)->send(
        new ClientWelcomeMail($client, $plainPassword)
    );

    return redirect()->route('clients.index')
        ->with('msg', 'Client créé + email envoyé avec succès');
}
public function show(Request $request, $id)
{
    Gate::authorize('client.view');

    // 🔥 client
    $client = Client::findOrFail($id);

    // 🔥 IMPORTANT : on crée query ici
    $query = Dossier::with(['user', 'departement'])
        ->where('idClient', $id);

    // 🔥 filtre status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // 🔥 pagination
    $dossiers = $query->orderBy('idDossier', 'desc')->paginate(5);

    return view('showClient', compact('client', 'dossiers'));
}

public function edit($id){
     Gate::authorize('client.edit');
    $client = Client::findOrFail($id);
    $departements = Departement::all();
    return view('editClient' , compact('client', 'departements'));
}

public function update(Request $request ,$id){
     Gate::authorize('client.edit');
    $client = Client::findOrFail($id);
    $clientUpdate = $request->validate([
        'firstName'    => 'required|string|max:50',
        'lastName'      => 'required|string|max:50',
        'email'         => 'required|email|unique:clients,email,'.$id.',idClient',
        'password'      => 'nullable|min:8',
        'CNE'           => 'required|string|unique:clients,CNE,'.$id.',idClient',
        'dateNaissance' => "required|date",
        'address'       => 'nullable|string|max:100',
        'phoneNumber'   => 'required|min:10|max:15',
        'idLead'        => 'nullable|exists:leads,idLead',
        'status'        => 'in:actif,inactif',
        'nationalite'   => 'nullable|string',
        'note'          => 'string|nullable',
        'type_select' => 'required|string',
        'type'        => 'nullable|string|max:50',
    ]);
    if ($request->type_select === 'autre') {
    if (empty($request->type)) {
        return back()->withErrors(['type' => 'Veuillez préciser le type']);
    }
        $clientUpdate['type'] = $request->type;
    } else {
        $clientUpdate['type'] = $request->type_select;
    }
    if ($request->filled('password')) {
        $clientUpdate['password'] = Hash::make($request->password);
    } else {
        unset($clientUpdate['password']);
    }
    $client->update($clientUpdate);
return redirect()->route('clients.index')
    ->with('msg', 'Client modifié avec succès');}
}