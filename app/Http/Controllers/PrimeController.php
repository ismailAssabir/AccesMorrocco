<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prime;
use App\Models\User;
use App\Models\Tache;
use App\Models\Pointage;
use App\Models\Objectif;
use App\Models\Departement;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Mail\PrimeValidatedNotification;
use App\Mail\PrimePaidNotification;

class PrimeController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('prime.view');
        
        $query = Prime::with(['user', 'tache', 'pointage', 'objectif']);

        // ── FILTERS ───────────────────────────────────────────────────
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($qu) use ($search) {
                    $qu->where('firstName', 'like', "%{$search}%")
                      ->orWhere('lastName', 'like', "%{$search}%");
                })
                ->orWhere('motif', 'like', "%{$search}%")
                ->orWhere('montant', 'like', "%{$search}%")
                ->orWhere('dateAttribution', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('user_id')) {
            $query->where('idUser', $request->input('user_id'));
        }

        if ($request->filled('role')) {
            $query->whereHas('user', fn($q) => $q->where('type', $request->role));
        }

        if ($request->filled('departement')) {
            $query->whereHas('user', fn($q) => $q->where('idDepartement', $request->departement));
        }

        if ($request->filled('post')) {
            $query->whereHas('user', fn($q) => $q->where('post', $request->post));
        }

        $primes = $query->orderBy('created_at', 'desc')->get();
            
        $users = User::orderBy('firstName')->get();
        $departements = Departement::orderBy('title')->get();
        $posts = User::whereNotNull('post')->distinct()->pluck('post');
        $taches = Tache::all();
        $objectifs = Objectif::all();
        
        if ($request->ajax()) {
            return view('primes.partials.table', compact('primes'))->render();
        }
        
        return view('primes.index', compact('primes', 'users', 'departements', 'posts', 'taches', 'objectifs'));
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

        // Envoyer l'email approprié selon le statut
        if ($prime->user && $prime->user->email) {
            if ($validated['status'] === 'validee') {
                Mail::to($prime->user->email)->send(new PrimeValidatedNotification($prime));
            } elseif ($validated['status'] === 'payee') {
                Mail::to($prime->user->email)->send(new PrimePaidNotification($prime));
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

        // Envoyer l'email si le statut change vers Validée ou Payée
        if ($prime->user && $prime->user->email) {
            if ($oldStatus !== 'validee' && $validated['status'] === 'validee') {
                Mail::to($prime->user->email)->send(new PrimeValidatedNotification($prime));
            } elseif ($oldStatus !== 'payee' && $validated['status'] === 'payee') {
                Mail::to($prime->user->email)->send(new PrimePaidNotification($prime));
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