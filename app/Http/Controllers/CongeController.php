<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conge;


class CongeController extends Controller
{
    public function index()
    {
        $conges = Conge::with('user')->get();
        return view('conges.index', compact('conges'));
    }


public function store(Request $request)
{
    $newConge = $request->validate([
        'idUser'        => 'required|exists:users,idUser',
        'sold'          => 'nullable|integer',
        'type'          => 'required|in:annuel,maladie,sans_solde',
        'justification' => 'nullable|string',
        'motif'         => 'nullable|string|max:255',
        'dateDebut'     => 'nullable|date',
        'dateFin'       => 'nullable|date',
    ]);

      $newConge['dateDemande'] = now()->toDateString(); 
    //   $newConge['status'] = "en_attente"; 

    Conge::create($newConge);

    return redirect()->back()->with('msg', 'Le congé a été ajouté avec succès');
}
    
    public function show($id)
    {
        $conge = Conge::with('user')->findOrFail($id);
        return view('conges.show', compact('conge'));
    }

    public function update(Request $request, $id)
    {
        $conge = Conge::findOrFail($id);
        $request->validate([
            'status' => 'required|in:en_attente,approuve,refuse'
        ]);
        $conge->update(['status' => $request->status]);

        return redirect()->back()->with('msg', 'Le statut a été mis à jour');
    }

    public function destroy($id)
    {
        $conge = Conge::findOrFail($id);
        $conge->delete();
        return redirect()->back()->with('msg', 'Demande supprimée');
    }
}