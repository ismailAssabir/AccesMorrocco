<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prime;
use Illuminate\Support\Facades\Gate;

class PrimeController extends Controller
{
    public function index()
    {    Gate::authorize('prime.view');
        $primes = Prime::with(['tache', 'pointage'])->get();
        return view('primes.index', compact('primes'));
    }

    public function store(Request $request)
    {           Gate::authorize('prime.create');

        $newPrime = $request->validate([
            'idTache'         => 'nullable|exists:taches,idTache',
            'idPointage'      => 'nullable|exists:pointages,idPointage',
            'idObjectif'      => 'nullable|exists:objectifs,idObjectif',
            'montant'         => 'required|numeric|min:0',
            'motif'           => 'nullable|string|max:255',
            'status'          => 'in:en_attente,validee,payee',
        ]);

        
            $newPrime['dateAttribution'] = now()->toDateString();
       

        Prime::create($newPrime);

        return redirect()->back()->with('msg', 'La prime a été ajoutée avec succès');
    }

    public function show($id)
    {           Gate::authorize('prime.view');

        $prime = Prime::with(['tache', 'pointage'])->findOrFail($id);
        return view('primes.show', compact('prime'));
    }

    public function update(Request $request, $id)
    {   Gate::authorize('prime.edit');
        $prime = Prime::findOrFail($id);
        
        $updatedData = $request->validate([
            'idTache'         => 'nullable|exists:taches,idTache',
            'idPointage'      => 'nullable|exists:pointages,idPointage',
            'idObjectif'      => 'nullable|exists:objectifs,idObjectif',
            'montant'         => 'required|numeric|min:0',
            'motif'           => 'nullable|string|max:255',
            'dateAttribution' => 'nullable|date',
            'status'          => 'required|in:en_attente,validee,payee',
        ]);

        $prime->update($updatedData);

        return redirect()->back()->with('msg', 'La prime a été mise à jour');
    }

    public function destroy($id)
    {   Gate::authorize('prime.delete');
        $prime = Prime::findOrFail($id);
        $prime->delete();
        return redirect()->back()->with('msg', 'Prime supprimée avec succès');
    }
}