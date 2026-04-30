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
    public function index(Request $request)
    {
        Gate::authorize('objectif.view');
        
        $query = Objectif::with(['taches', 'departement.manager']);

        // Filtering logic
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('titre', 'LIKE', "%$s%")
                  ->orWhere('description', 'LIKE', "%$s%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('idDepartement')) {
            $query->where('idDepartement', $request->idDepartement);
        }

        $objs = $query->latest()->get();
        $departements = \App\Models\Departement::all();

        if ($request->ajax()) {
            return view('objectifs.partials.cards', compact('objs'))->render();
        }

        return view('objectifs.index', compact('objs', 'departements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('objectif.create');
        $departements = \App\Models\Departement::all();
        return view('objectifs.create', compact('departements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('objectif.create');
        
        if (!$request->filled('idDepartement')) {
            $request->merge(['idDepartement' => null]);
        }

        $data = $request->validate([
            'titre' => 'required|string|max:55',
            'description' => 'nullable|string|max:255',
            'dateFin' => 'nullable|date',
            'status' => 'nullable|string',
            'avancement' => 'nullable|integer|min:0|max:100',
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
        return view('objectifs.show', compact('obj'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('objectif.edit');
        $obj = Objectif::findOrFail($id);
        
        // If it's an AJAX request (for the modal), return prepared JSON
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'idObjectif'    => $obj->idObjectif,
                'titre'         => $obj->titre,
                'description'   => $obj->description,
                'dateDebut'     => $obj->dateDebut ? $obj->dateDebut->format('Y-m-d') : '',
                'dateFin'       => $obj->dateFin ? $obj->dateFin->format('Y-m-d') : '',
                'status'        => $obj->status,
                'avancement'    => $obj->avancement,
                'idDepartement' => $obj->idDepartement,
                'status_config' => $obj->status_config,
                'calculated_progress' => $obj->calculated_progress
            ]);
        }

        $departements = \App\Models\Departement::all();
        return view('objectifs.edit' , compact('obj', 'departements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('objectif.edit');
        
        if (!$request->filled('idDepartement')) {
            $request->merge(['idDepartement' => null]);
        }
        
        $data = $request->validate([
            'titre'         => 'required|string|max:55',
            'description'   => 'nullable|string|max:500',
            'dateFin'       => 'nullable|date',
            'dateDebut'     => 'nullable|date',
            'status'        => 'required|string|in:en_cours,atteint,echoue',
            'avancement'    => 'nullable|integer|min:0|max:100',
            'idDepartement' => 'nullable|exists:departements,idDepartement'
        ]);

        $obj = Objectif::findOrFail($id);
        $obj->update($data);

        return redirect()->route('objectifs.index')->with('msg', "L'objectif stratégique a été mis à jour avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('objectif.delete');
        $obj = Objectif::findOrFail($id);
        $obj->delete();
        return redirect()->route('objectifs.index')->with('msg', "L'objectif a été supprimé");
    }
}
