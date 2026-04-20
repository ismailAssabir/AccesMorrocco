<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departement;

class DepartementController extends Controller
{
    public function index(){
        $departements = Departement::with(['manager', 'taches'])->get();
        return view('departements.index' , compact('departements') );
    }

public function store(Request $request) {
    

    $newDepartement = $request->validate([
        'title'     => 'required|string|max:55',
        'description'    => 'nullable|string|max:255',
        'idUser'  =>  'nullable|exists:users,idUser'
       
    ]);
    $departement = Departement::create($newDepartement);
    return redirect()->back()->with('msg' , "Le département a été ajouté avec succès");

}
public function show($id){
    $departement = Departement::with(['manager', 'taches', 'taches.users'])->findOrFail($id);
    return view('showDepartement' , compact('departement'));
}
public function destroy($id)
{   $departement = Departement::findOrFail($id);
    $departement->delete();
    return redirect()->back()->with('msg', 'Le département a été supprimée');
}

    public function edit(Request $request, $id)
    {
        $departement = Departement::with('manager')->findOrFail($id);
        
        if ($request->ajax()) {
            return response()->json($departement);
        }

        return view('editDepartement', compact('departement'));
    }

public function update(Request $request ,$id){
    
    $departementUpdate = $request->validate([
        'title'     => 'required|string|max:55',
        'description'    => 'nullable|string|max:255',
        'idUser'  =>  'nullable|exists:users,idUser'
    ]);
    $departement = Departement::findOrFail($id);
   $departement->update($departementUpdate);
    return redirect()->back()->with('msg' , 'Le département été mises à jour avec succès');
}
}
