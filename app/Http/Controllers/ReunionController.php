<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reunion;
use App\Models\Departement;

class ReunionController extends Controller
{
    public function index()
    {
        $reunions = Reunion::with('departement')->get();
        $departements = Departement::all();
        return view('reunions.index', compact('reunions', 'departements'));
    }

    public function create()
    {
        $departements = Departement::all();
        return view('reunions.create', compact('departements'));
    }

    public function edit($id)
    {
        $reunion = Reunion::findOrFail($id);
        $departements = Departement::all();
        return view('reunions.edit', compact('reunion', 'departements'));
    }

    public function store(Request $request)
    {
        $newReunion = $request->validate([
            'idDepartement' => 'nullable|exists:departements,idDepartement',
            'objectif'      => 'required|string|max:255',
            'titre'         => 'required|string|max:100',
            'description'   => 'nullable|string',
            'dateHeure'     => 'nullable|date',
            'heureFin'      => 'nullable', 
            'type'          => 'required|string',
            'lien'          => 'nullable|url',
            'lieu'          => 'nullable|string|max:100',
        ]);

        Reunion::create($newReunion);

        return redirect('/reunions')->with('msg', 'La réunion a été ajoutée avec succès');
    }

    public function show($id)
    {
        $reunion = Reunion::with('departement')->findOrFail($id);
        return view('reunions.show', compact('reunion'));
    }

    public function update(Request $request, $id)
    {
        $reunion = Reunion::findOrFail($id);
        
        $updatedData = $request->validate([
            'idDepartement' => 'nullable|exists:departements,idDepartement',
            'objectif'      => 'required|string|max:255',
            'titre'         => 'required|string|max:100',
            'description'   => 'nullable|string',
            'dateHeure'     => 'nullable|date',
            'heureFin'      => 'nullable',
            'type'          => 'required|string',
            'lien'          => 'nullable|url',
            'lieu'          => 'nullable|string|max:100',
        ]);

        $reunion->update($updatedData);

        return redirect('/reunions')->with('msg', 'La réunion a été mise à jour');
    }

    public function destroy($id)
    {
        $reunion = Reunion::findOrFail($id);
        $reunion->delete();
        return redirect('/reunions')->with('msg', 'Réunion supprimée avec succès');
    }
}