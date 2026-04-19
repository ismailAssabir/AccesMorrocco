<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function index(){
        $users = User::All();
        return view('AllUser' , compact("users"));
    }

public function store(Request $request) {
    

    $newUser = $request->validate([
        'firstName'     => 'required|string|max:50',
        'lastName'      => 'required|string|max:50',
        'email'         => 'required|email|unique:users,email',
        'password'      => 'required|min:8',
        'cin'           => 'required|string|unique:users,cin',
        'birthday'      => "required|date",
        'address'       => 'nullable|string|max:100',
        'phoneNumber'   => 'required|min:10|max:15',
        'typeContrat'   => 'nullable|in:CDI,CI,freelance',
        'salaire'       => 'required|numeric',
        'post'          => 'nullable|string|max:40',
        'dateEmb'       => 'nullable|date',
        'idDepartement' => 'nullable|exists:departements,idDepartement',
        'status'        => 'in:active,desactive,conge',
        'type'          => 'in:employee,admin,manager',
        'fichier'       => 'nullable|string',
        'rip'           => 'nullable|string',
    ]);
    $newUser['password'] = Hash::make($request->password);
    $user = User::create($newUser);
    return redirect()->back()->with('msg' , "L'utilisateur a été ajouté avec succès!");

}
public function show($id){
    $user = User::findOrFail($id);
    return view('show' , compact('user'));
}

public function edit($id){
    $user = User::findOrFail($id);
    return view('edit' , compact('user'));
}

public function update(Request $request ,$id){
    $user = User::findOrFail($id);
    $userUpdate = $request->validate([
        'firstName'    => 'required|string|max:50',
        'lastName'      => 'required|string|max:50',
        'email'         => 'required|email|unique:users,email,'.$id.',idUser',
        'password'      => 'nullable|min:8',
        'cin'           => 'required|string|unique:users,cin,'.$id.',idUser',
        'birthday'      => "required|date",
        'address'       => 'nullable|string|max:100',
        'phoneNumber'   => 'required|min:10|max:15',
        'typeContrat'   => 'nullable|in:CDI,CI,freelance',
        'salaire'       => 'required|numeric',
        'post'          => 'nullable|string|max:40',
        'dateEmb'       => 'nullable|date',
        'idDepartement' => 'nullable|exists:departements,idDepartement',
        'status'        => 'in:active,desactive,conge',
        'type'          => 'in:employee,admin,manager',
        'fichier'       => 'nullable|string',
        'rip'           => 'nullable|string',
    ]);
    if ($request->filled('password')) {
        $userUpdate['password'] = Hash::make($request->password);
    } else {
        unset($userUpdate['password']);
    }
    $user->update($userUpdate);
    return redirect()->back()->with('msg' , 'Les informations utilisateur ont été mises à jour avec succès');
}
}