<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\DocumentDemande;

class DemandeController extends Controller
{
   
    public function index(){
        $docs = DocumentDemande::with('user')->get();
        return view('demande.index', compact('docs'));
    }
    
    public function create(){
        return view('demande.create');
    }
    public function store(Request $request){
        $data = $request->validate([
            'title' => 'required|string|max:55',
            'description' => 'nullable|string|max:255',
            'idUser' => 'nullable|exists:users,idUser',
            'status' => 'nullable|string',
            'type' => 'required|string',
            'fichier' => 'nullable|string|max:255',
        ]);

        DocumentDemande::create($data);

        return redirect()->back()->with('msg', "La demande a été ajoutée avec succès");
    }
    public function show($id){
        $demande = DocumentDemande::with('user')->findOrFail($id);
        return view('demande.show', compact('demande'));
    }
    public function edit($id){
        $doc = DocumentDemande::with('user')->findOrFail($id);
        return view('demande.update' , compact('doc'));
    }
    public function update(Request $request ,$id){
    
   $UpdatedDemande = $request->validate([
        'title'     => 'required|string|max:55',
        'description'    => 'nullable|string|max:255',
        'idUser'  =>  'nullable|exists:users,idUser',
        'status'=>'nullable|string',
        'type' => 'required|string',
        'fichier'=> 'nullable|string|max:255',
       
        ]);
    $doc = DocumentDemande::findOrFail($id);
    $doc->update($UpdatedDemande);
    return redirect()->back()->with('msg' , 'La demande été mises à jour avec succès');
    }
    public function destroy($id)
        {   $doc = DocumentDemande::findOrFail($id);
            $doc->delete();
            return redirect()->back()->with('msg', 'La demande a été supprimée');
        }
}
