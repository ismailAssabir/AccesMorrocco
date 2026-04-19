<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tache;
class TacheController extends Controller
{
    public function index(){
        $Taches = Tache::with(['users', 'objectif'])->get();
        return view('Taches' , compact('Taches') );
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
        'idUser'      => 'nullable|exists:users,idUser'
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
        'idUser'      => 'nullable|exists:users,idUser'
    ]);
    unset($TacheUpdate['idUser']);

    $Tache = Tache::findOrFail($id);
    
    
   $Tache->update($TacheUpdate);
   if ($request->filled('idUser')) {
    $Tache->users()->sync($request->idUser);}


    return redirect()->back()->with('msg' , 'La tache été mises à jour avec succès');
}
}
