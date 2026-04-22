<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\DocumentDemande;

class DemandeController extends Controller
{
    
    public function index(){
        Gate::authorize('document.view');
        $docs = DocumentDemande::with('user')->get();
        return view('demande.index', compact('docs'));
    }
    
    public function create(){
        Gate::authorize('document.create');
        return view('demande.create');
    }
    public function store(Request $request){
        Gate::authorize('document.create');
        $data = $request->validate([
            'titre' => 'required|string|max:55',
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
        Gate::authorize('document.view');
        $demande = DocumentDemande::with('user')->findOrFail($id);
        return view('demande.show', compact('demande'));
    }
    public function edit($id){
         Gate::authorize('document.edit');
        $doc = DocumentDemande::with('user')->findOrFail($id);
        return view('demande.update' , compact('doc'));
    }
    public function update(Request $request ,$id){
        Gate::authorize('document.edit');
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
        {   
             Gate::authorize('document.delete');
            $doc = DocumentDemande::findOrFail($id);
            $doc->delete();
            return redirect()->back()->with('msg', 'La demande a été supprimée');
        }
}
