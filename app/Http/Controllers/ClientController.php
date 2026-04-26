<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Dossier;
use App\Models\Departement;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Gate;

class ClientController extends Controller
{
    public function assign(Request $request, $id)
{
    $user = auth()->user();
    $client = Client::findOrFail($id);

    if ($user->hasRole('admin')) {
        // Admin assigne un département
        $request->validate([
            'idDepartement' => 'required|exists:departements,idDepartement',
        ]);
        $client->update([
            'idDepartement' => $request->idDepartement,
            'idUser'        => null, // reset l'employé si département change
        ]);

    } elseif ($user->hasRole('manager')) {
        // Manager assigne un employé de son département
        abort_if($client->idDepartement !== $user->idDepartement, 403);
        $request->validate([
            'idUser' => 'nullable|exists:users,idUser',
        ]);
        $client->update([
            'idUser' => $request->idUser ?: null,
        ]);
    }

    return redirect()->route('clients.index')->with('msg', 'Client assigné avec succès!');
}
    public function index()
    {
        Gate::authorize('client.view');
        $user = auth()->user();
        $leads = Lead::all();
        $departements = Departement::all();

        if ($user->hasRole('admin')) {
            $clients = Client::with('departement')->get();

        } elseif ($user->hasRole('manager')) {
            // Manager voit tous les clients de son département
            $clients = Client::with('departement')
                ->where('idDepartement', $user->idDepartement)
                ->get();

        } elseif ($user->hasRole('employee')) {
            // Employee voit seulement les clients qui lui sont assignés
            $clients = Client::with('departement')
                ->where('idUser', $user->idUser)
                ->get();

        } else {
            $clients = collect();
        }

        // Les employés du département du manager (pour l'assignation)
        $employees = collect();
        if ($user->hasRole('manager')) {
            $employees = \App\Models\User::where('idDepartement', $user->idDepartement)
                ->whereHas('roles', fn($q) => $q->where('name', 'employee'))
                ->get(['idUser', 'firstName', 'lastName']);
        }

        return view('AllClients', compact('clients', 'leads', 'departements', 'employees'));
    }

public function store(Request $request)
    {
        Gate::authorize('client.create');

        $newClient = $request->validate([
            'firstName'      => 'required|string|max:50',
            'lastName'       => 'required|string|max:50',
            'email'          => 'required|email',
            'password'       => 'required|string|min:8',
            'CNE'            => 'required|string',
            'dateNaissance'  => 'required|date',
            'address'        => 'nullable|string|max:100',
            'phoneNumber'    => 'nullable|min:10|max:15',
            'idLead'         => 'nullable|exists:leads,idLead',
            'idDepartement'  => 'nullable|exists:departements,idDepartement',
            'idUser'         => 'nullable|exists:users,idUser',
            'status'         => 'in:actif,inactif',
            'type'           => 'nullable',
            'nationalite'    => 'nullable|string|max:40',
            'note'           => 'nullable|string',
        ]);

        $newClient['password'] = Hash::make($request->password);

        // Si manager crée → forcer son département
        $user = auth()->user();
        if ($user->hasRole('manager')) {
            $newClient['idDepartement'] = $user->idDepartement;
        }

        $client = Client::create($newClient);

        Dossier::create([
            'idClient'        => $client->idClient,
            'idDepartement'   => $client->idDepartement,
            'reference'       => 'DOS-' . strtoupper(Str::random(8)),
            'dateCreation'    => now(),
            'nombrePersonnes' => 1,
            'montant'         => 0,
            'nombreJours'     => 0,
            'status'          => 'ouvert',
            'commentaire'     => 'Dossier créé automatiquement à l\'inscription du client.',
        ]);

        return redirect()->route('clients.index')->with('msg', 'Le client a été ajouté avec succès!');
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
        'idLead'        => 'required|exists:leads,idLead',
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