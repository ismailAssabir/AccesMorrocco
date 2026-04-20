<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tache;
use App\Models\User;
use App\Models\Objectif;
use App\Models\Departement;

class TacheController extends Controller
{
    public function index(){
        $Taches = Tache::with(['users', 'objectif', 'departement'])->get();
        $users = User::all();
        $objectifs = Objectif::all();
        $departements = Departement::all();
        return view('taches.index' , compact('Taches', 'users', 'objectifs', 'departements') );
    }

public function store(Request $request) {
    

    $newTache = $request->validate([
        'idObjectif'  => 'nullable|exists:objectifs,idObjectif', 
        'titre'       => 'required|max:30', 
        'dateDebut'   => 'nullable|date',
        'duree'       => 'nullable|date', 
        'typeDuree'   => 'required|in:h,jours,mois', 
        'heureDebut'  => 'nullable', 
        'priorite'    => 'required|in:basse,moyenne,haute', 
        'status'      => 'required|in:todo,en_cours,termine',
        'description' => 'nullable',
        'idUser'      => 'nullable|exists:users,idUser',
        'idDepartement' => 'nullable|exists:departements,idDepartement'
    ]);

    unset($newTache['idUser']);
    $Tache = Tache::create($newTache);


    if ($request->filled('idUser')) {
    $Tache->users()->attach($request->idUser);
}
    return redirect()->back()->with('msg' , "La tache a été ajouté avec succès");

}
public function show($id){
    $Tache = Tache::with(['users', 'objectif'])->findOrFail($id);
    return view('showTache' , compact('Tache'));
}
public function destroy($id)
{   $Tache = Tache::findOrFail($id);
    $Tache->delete();
    return redirect()->back()->with('msg', 'La tache a été supprimée');
}

public function edit($id){
    $Tache = Tache::with('user')->findOrFail($id);
    return view('editTache' , compact('Tache'));
}

public function update(Request $request ,$id){
    
    $TacheUpdate = $request->validate([
       'idObjectif'  => 'nullable|exists:objectifs,idObjectif', 
        'titre'       => 'required|max:30', 
        'dateDebut'   => 'nullable|date',
        'duree'       => 'nullable|date', 
        'typeDuree'   => 'required|in:h,jours,mois', 
        'heureDebut'  => 'nullable', 
        'priorite'    => 'required|in:basse,moyenne,haute', 
        'status'      => 'required|in:todo,en_cours,termine',
        'description' => 'nullable',
        'idUser'      => 'nullable|exists:users,idUser',
        'idDepartement' => 'nullable|exists:departements,idDepartement'
    ]);
    unset($TacheUpdate['idUser']);

    $Tache = Tache::findOrFail($id);
    
    
   $Tache->update($TacheUpdate);
   if ($request->filled('idUser')) {
    $Tache->users()->sync($request->idUser);}


    return redirect()->back()->with('msg' , 'La tache été mises à jour avec succès');
}

public function assignUser(Request $request) {
    $request->validate([
        'idTache' => 'required|exists:taches,idTache',
        'idUser'  => 'required|exists:users,idUser'
    ]);

    $tache = Tache::findOrFail($request->idTache);
    $tache->users()->syncWithoutDetaching([$request->idUser]);

    return redirect()->back()->with('msg', 'Employé assigné à la tâche avec succès');
}

public function unassignUser(Request $request) {
    $request->validate([
        'idTache' => 'required|exists:taches,idTache',
        'idUser'  => 'required|exists:users,idUser'
    ]);

    $tache = Tache::findOrFail($request->idTache);
    $tache->users()->detach($request->idUser);

    return redirect()->back()->with('msg', 'Employé retiré de la tâche');
}
}
