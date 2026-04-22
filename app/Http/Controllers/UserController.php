<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Departement;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        $users = User::with('departement')->get();
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
        'phoneNumber'   => 'required|digits:10',
        'typeContrat'   => 'nullable|in:CD,CI,freelance',
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

    DB::transaction(function () use ($newUser) {
        $user = User::create($newUser);

        // One Manager per Department Logic
        if ($user->type === 'manager' && $user->idDepartement) {
            $departement = Departement::find($user->idDepartement);
            
            if ($departement) {
                // If the department already has a different manager, demote them to employee
                if ($departement->idUser && $departement->idUser !== $user->idUser) {
                    User::where('idUser', $departement->idUser)->update(['type' => 'employee']);
                }
                
                // Set the new user as the manager of this department
                $departement->update(['idUser' => $user->idUser]);
            }
        }
    });

    return redirect()->back()->with('msg' , "L'utilisateur a été ajouté avec succès!");
}

public function show($id){
    if (request()->ajax()) {
        $user = User::with('departement')->findOrFail($id);
        return response()->json($user);
    }
    $users = User::with('departement')->get();
    $selectedUser = User::with('departement')->findOrFail($id);
    return view('AllUser' , compact('users', 'selectedUser'))->with('openModal', 'view');
}

public function edit($id){
    if (request()->ajax()) {
        $user = User::findOrFail($id);
        return response()->json($user);
    }
    $users = User::with('departement')->get();
    $selectedUser = User::with('departement')->findOrFail($id);
    return view('AllUser' , compact('users', 'selectedUser'))->with('openModal', 'edit');
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
            'phoneNumber'   => 'required|digits:10',
            'typeContrat'   => 'nullable|in:CD,CI,freelance',
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

        DB::transaction(function () use ($user, $userUpdate) {
            $user->update($userUpdate);

            // One Manager per Department Logic
            if ($user->type === 'manager' && $user->idDepartement) {
                $departement = Departement::find($user->idDepartement);
                
                if ($departement) {
                    // Remove the user from any other department they might be managing
                    Departement::where('idUser', $user->idUser)
                               ->where('idDepartement', '!=', $departement->idDepartement)
                               ->update(['idUser' => null]);

                    // If the department already has a different manager, demote them to employee
                    if ($departement->idUser && $departement->idUser !== $user->idUser) {
                        User::where('idUser', $departement->idUser)->update(['type' => 'employee']);
                    }
                    
                    // Set the new user as the manager of this department
                    $departement->update(['idUser' => $user->idUser]);
                }
            } else {
                // If the user is no longer a manager, or has no department, remove them from managing any dept
                Departement::where('idUser', $user->idUser)->update(['idUser' => null]);
            }
        });

        return redirect()->route('users.index')->with('msg' , 'Les informations utilisateur ont été mises à jour avec succès');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        DB::transaction(function () use ($user) {
            // Remove from department manager if applicable
            Departement::where('idUser', $user->idUser)->update(['idUser' => null]);
            $user->delete();
        });

        return redirect()->route('users.index')->with('msg', 'L\'utilisateur a été supprimé avec succès.');
    }
}