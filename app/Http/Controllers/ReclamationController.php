<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Reclamation;
use Illuminate\Support\Facades\Auth;

class ReclamationController extends Controller
{
     public function index(){
        $Reclamations = Reclamation::with('user')->get();
        return view('AllReclamations' , compact("Reclamations"));
    }

public function store(Request $request) {
    

    $newReclamation = $request->validate([
        'idUser'     => 'required|exists:users,idUser',
        'description'    => 'nullable|string|min:10|max:255',
        'status'  => 'in:ouverte,en_cours,resolue',
        'priorite' => 'in:basse,moyenne,haute',
        'titre' => 'string|min:2|max:20',
        'fichier' =>'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
        'reponse' => 'string|max:255|nullable'
    ]);
    if($request->hasFile('fichier')) {
        $path = request->file('fichier')->store('Reclamations' , 'public');
        $newReclamation['fichier'] = $path;
    }
    
    $Reclamation = Reclamation::create($newReclamation);
    return redirect()->back()->with('msg' , "La Reclamation a été ajoutée avec succès");

}
    public function show($id){
        $Reclamation = Reclamation::with('user')->findOrFail($id);
        return view('showReclamation' , compact('Reclamation'));
    }


// public function destroy($id)
// {   $Reclamation = Reclamation::findOrFail($id);
//     $Reclamation->delete();
//     return redirect()->back()->with('msg', 'La Reclamation a été supprimée');
// }

// public function edit($id){
//     $Reclamation = Reclamation::findOrFail($id);
//     return view('editReclamation' , compact('Reclamation'));
// }

// public function update(Request $request ,$id){
//     $Reclamation = Reclamation::findOrFail($id);
//     $ReclamationUpdate = $request->validate([
//         'idUser'     => 'required|exists:users,idUser',
//         'description'    => 'nullable|string|min:10|max:255',
//         'status'  => 'in:ouverte,en_cours,resolue',
//         'priorite' => 'in:basse,moyenne,haute',
//         'titre' => 'string|min:2|max:20',
//         'fichier' =>'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
//         'reponse' => 'string|max:255|nullable'
//     ]);

//    $Reclamation->update($ReclamationUpdate);
//     return redirect()->back()->with('msg' , 'La Reclamation été mises à jour avec succès');
// }
}
