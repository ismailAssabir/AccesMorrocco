<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prime;
use App\Models\User;
use App\Models\Tache;
use App\Models\Pointage;
use App\Models\Objectif;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Mail\PrimeValidatedNotification;

class PrimeController extends Controller
{
    public function index()
    {
        Gate::authorize('prime.view');
        
        $primes = Prime::with(['user', 'tache', 'pointage', 'objectif'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        $users = User::all();
        $taches = Tache::all();
        $objectifs = Objectif::all();
        
        return view('primes.index', compact('primes', 'users', 'taches', 'objectifs'));
    }

    public function store(Request $request)
    {
        Gate::authorize('prime.create');

        $validated = $request->validate([
            'idUser'          => 'required|exists:users,idUser',
            'idTache'         => 'nullable|exists:taches,idTache',
            'idPointage'      => 'nullable|exists:pointages,idPointage',
            'idObjectif'      => 'nullable|exists:objectifs,idObjectif',
            'montant'         => 'required|numeric|min:0',
            'motif'           => 'nullable|string|max:255',
            'status'          => 'required|in:en_attente,validee,payee',
        ]);

        $validated['dateAttribution'] = now()->toDateString();

        $prime = Prime::create($validated);

        // Envoyer l'email si créé directement en tant que "validee"
        if ($validated['status'] === 'validee') {
            if ($prime->user && $prime->user->email) {
                Mail::to($prime->user->email)->send(new PrimeValidatedNotification($prime));
            }
        }

        return redirect()->back()->with('msg', 'La prime a été attribuée avec succès');
    }



    public function update(Request $request, $id)
    {
        Gate::authorize('prime.edit');
        $prime = Prime::findOrFail($id);
        $oldStatus = $prime->status;
        
        $validated = $request->validate([
            'idUser'          => 'required|exists:users,idUser',
            'idTache'         => 'nullable|exists:taches,idTache',
            'idPointage'      => 'nullable|exists:pointages,idPointage',
            'idObjectif'      => 'nullable|exists:objectifs,idObjectif',
            'montant'         => 'required|numeric|min:0',
            'motif'           => 'nullable|string|max:255',
            'dateAttribution' => 'nullable|date',
            'status'          => 'required|in:en_attente,validee,payee',
        ]);

        $prime->update($validated);

        // Envoyer l'email si le statut devient "validee"
        if ($oldStatus !== 'validee' && $validated['status'] === 'validee') {
            if ($prime->user && $prime->user->email) {
                Mail::to($prime->user->email)->send(new PrimeValidatedNotification($prime));
            }
        }

        return redirect()->back()->with('msg', 'La prime a été mise à jour');
    }

    public function destroy($id)
    {
        Gate::authorize('prime.delete');
        $prime = Prime::findOrFail($id);
        $prime->delete();
        return redirect()->back()->with('msg', 'Prime supprimée avec succès');
    }
}