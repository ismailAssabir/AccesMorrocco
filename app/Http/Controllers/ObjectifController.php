<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Objectif;

class ObjectifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('objectif.view');
        $objs = Objectif::with('taches')->get();
        return view('objectif.index', compact('objs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('objectif.create');
        return view('objectif.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('objectif.create');
        $data = $request->validate([
            'titre' => 'required|string|max:55',
            'description' => 'nullable|string|max:255',
            'dateFin' => 'nullable|date',
            'status' => 'nullable|string',
            'avancement' => 'required|string',
            'dateDebut' => 'nullable|date',
            'idDepartement'=> 'nullable|exists:departements,idDepartement'
        ]);

        Objectif::create($data);

        return redirect()->back()->with('msg', "L'objectif a été ajouté avec succès");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize('objectif.view');
        $obj = Objectif::with('taches')->findOrFail($id);
        return view('objectif.show', compact('obj'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('objectif.edit');
        $obj = Objectif::with('taches')->findOrFail($id);
        return view('objectif.update' , compact('obj'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            Gate::authorize('objectif.edit');
            $data = $request->validate([
                'titre' => 'required|string|max:55',
                'description' => 'nullable|string|max:255',
                'dateFin' => 'nullable|date',
                'status' => 'nullable|string',
                'avancement' => 'required|string',
                'dateDebut' => 'nullable|date',
                'idDepartement'=> 'nullable|exists:departements,idDepartement'
            ]);
        $obj = Objectif::findOrFail($id);
        $obj->update($data);
        return redirect()->back()->with('msg' , "l'objectf  été mises à jour avec succès");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('objectif.delete');
        $obj = Objectif::findOrFail($id);
        $obj->delete();
        return redirect()->back()->with('msg', "L'objectif a été supprimée");
    }
}
