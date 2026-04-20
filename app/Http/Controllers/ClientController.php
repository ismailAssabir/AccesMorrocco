<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Client;
class ClientController extends Controller
{
    public function index(){
        $clients = Client::All();
        return view('AllClients' , compact("clients"));
    }

public function store(Request $request) {
    

    $newClient = $request->validate([
        'firstName'     => 'required|string|max:50',
        'lastName'      => 'required|string|max:50',
        'email'         => 'required|email|unique:clients,email',
        'password'      => 'string|required|min:8',
        'CNE'           => 'required|string|unique:clients,CNE',
        'dateNaissance' => "required|date",
        'address'       => 'nullable|string|max:100',
        'phoneNumber'   => 'required|min:10|max:15|unique:clients,phoneNumber',
        'idLead'        => 'required|exists:leads,idlead',
        'status'        => 'in:actif,inactif',
        'type'          => 'nullable',
        'nationalite'   => 'max:40|string|nullable',
        'note'          => 'string|nullable'
    ]);
    $newClient['password'] = Hash::make($request->password);
    $client = Client::create($newClient);
    return redirect()->back()->with('msg' , "Le client a été ajouté avec succès!");

}
public function show($id){
    $client = Client::findOrFail($id);
    return view('showClient' , compact('client'));
}

public function edit($id){
    $client = Client::findOrFail($id);
    return view('editClient' , compact('client'));
}

public function update(Request $request ,$id){
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