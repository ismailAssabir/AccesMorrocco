<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departement;

class DepartementController extends Controller
{
    public function index(){
        $Departements = Departement::with('manager')->get();
        return view('departements.index' , compact('Departements') );
    }

public function store(Request $request) {
    

    $newDepartement = $request->validate([
        'title'     => 'required|string|max:55',
        'description'    => 'nullable|string|max:255',
        'idUser'  =>  'nullable|exists:users,idUser'
       
    ]);
    $Departement = Departement::create($newDepartement);
    return redirect()->back()->with('msg' , "Le département a été ajouté avec succès");

}
public function show($id){
    $Departement = Departement::with('manager')->findOrFail($id);
    return view('showDepartement' , compact('Departement'));
}
public function destroy($id)
{   $Departement = Departement::findOrFail($id);
    $Departement->delete();
    return redirect()->back()->with('msg', 'Le département a été supprimée');
}

public function edit($id){
    $Departement = Departement::with('manager')->findOrFail($id);
    return view('editDepartement' , compact('Departement'));
}

public function update(Request $request ,$id){
    
    $DepartementUpdate = $request->validate([
        'title'     => 'required|string|max:55',
        'description'    => 'nullable|string|max:255',
        'idUser'  =>  'nullable|exists:users,idUser'
    ]);
    $Departement = Departement::findOrFail($id);
   $Departement->update($DepartementUpdate);
    return redirect()->back()->with('msg' , 'Le département été mises à jour avec succès');
}
}
