<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Dossier;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Gate;

class ClientController extends Controller
{
    public function index(){
        Gate::authorize('client.view');
        $clients = Client::All();
        $leads = Lead::All();
        return view('AllClients' , compact("clients", 'leads'));
    }

public function store(Request $request) {
    Gate::authorize('client.create');

    $newClient = $request->validate([
        'firstName'     => 'required|string|max:50',
        'lastName'      => 'required|string|max:50',
        'email'         => 'required|email',
        'password'      => 'string|required|min:8',
        'CNE'           => 'required|string',
        'dateNaissance' => "required|date",
        'address'       => 'nullable|string|max:100',
        'phoneNumber'   => 'nullable|min:10|max:15',
        'idLead'        => 'nullable|exists:leads,idlead',
        'status'        => 'in:actif,inactif',
        'type'          => 'nullable',
        'nationalite'   => 'max:40|string|nullable',
        'note'          => 'string|nullable'
    ]);

    $newClient['password'] = Hash::make($request->password);

    $client = Client::create($newClient);

    // Créer le dossier par défaut
    Dossier::create([
        'idClient'        => $client->idClient,
        'idDepartement'   => null,
        'reference'       => 'DOS-' . strtoupper(Str::random(8)),
        'dateCreation'    => now(),
        'nombrePersonnes' => 1,
        'montant'         => 0,
        'nombreJours'     => 0,
        'status'          => 'ouvert',
        'commentaire'     => 'Dossier créé automatiquement à l\'inscription du client.',
    ]);

    return redirect()->back()->with('msg', 'Le client a été ajouté avec succès!');
}
public function show($id){
            Gate::authorize('client.view');

    $client = Client::findOrFail($id);
    return view('showClient' , compact('client'));
}

public function edit($id){
     Gate::authorize('client.edit');
    $client = Client::findOrFail($id);
    return view('editClient' , compact('client'));
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
        'phoneNumber'   => 'required|min:10|max:15|unique:clients,phoneNumber,'.$id.',idClient',
        'idLead'        => 'required|exists:leads,idlead',
        'type'          => 'nullable|string',
        'status'        => 'in:actif,inactif',
        'nationalite'   => 'nullable|string',
        'note'          => 'string|nullable'

    ]);
    if ($request->filled('password')) {
        $clientUpdate['password'] = Hash::make($request->password);
    } else {
        unset($clientUpdate['password']);
    }
    $client->update($clientUpdate);
    return redirect()->back()->with('msg' , 'Les informations utilisateur ont été mises à jour avec succès');
}
}