<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tache;
use App\Models\User;
use App\Models\Objectif;
use App\Models\Departement;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class TacheController extends Controller
{
    public function index(Request $request)
    {   
        Gate::authorize('tache.view');

        $search = $request->input('search');
        $status = $request->input('status');
        $priority = $request->input('priority');
        $idDept = $request->input('idDepartement');
        $idUser = $request->input('idUser');
        $view = $request->input('view', 'board');

        $query = Tache::with(['users:idUser,firstName,lastName', 'objectif:idObjectif,titre', 'departement:idDepartement,title']);

        // --- Basic Filtering ---
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($priority) {
            $query->where('priorite', $priority);
        }

        if ($idDept) {
            $query->where('idDepartement', $idDept);
        }

        if ($idUser) {
            $query->whereHas('users', function($q) use ($idUser) {
                $q->where('users.idUser', $idUser);
            });
        }

        // --- Default Visibility Logic ---
        if (!$search && $status !== 'termine') {
            $query->where(function($q) {
                $q->where('status', '!=', 'termine')
                  ->orWhere('updated_at', '>=', now()->subDays(30));
            });
        }

        // --- Permission logic ---
        if (auth()->user()->type === 'employee') {
            $user = auth()->user();
            $query->where(function($q) use ($user) {
                $q->whereNull('idDepartement')
                  ->orWhere('idDepartement', $user->idDepartement);
            });
        }

        if ($request->ajax()) {
            if ($view === 'table') {
                $taches = $query->latest()->paginate(10);
                return view('taches.partials.table', compact('taches'))->render();
            } else {
                $taches = $query->latest()->get();
                $todoTasks = $taches->where('status', 'todo');
                $enCoursTasks = $taches->where('status', 'en_cours');
                $termineTasks = $taches->where('status', 'termine');

                return view('taches.partials.board', compact('todoTasks', 'enCoursTasks', 'termineTasks'))->render();
            }
        }

        // Initial Load
        $allTasks = $query->latest()->get();
        $todoTasks = $allTasks->where('status', 'todo');
        $enCoursTasks = $allTasks->where('status', 'en_cours');
        $termineTasks = $allTasks->where('status', 'termine');
        
        $taches = $query->latest()->paginate(10); // Still need this for the Table view if switched

        $users = User::select('idUser', 'firstName', 'lastName')->get();
        $objectifs = Objectif::select('idObjectif', 'titre')->get();
        $departements = Departement::select('idDepartement', 'title')->get();
        
        return view('taches.index', compact('taches', 'todoTasks', 'enCoursTasks', 'termineTasks', 'users', 'objectifs', 'departements'));
    }

    public function store(Request $request) {
        Gate::authorize('tache.create');

        $request->validate([
            'titre'         => 'required|max:30',
            'start_date'    => 'nullable|date',
            'end_date'      => 'nullable|date|after_or_equal:start_date',
            'typeDuree'     => 'required|in:h,jours,mois',
            'priorite'      => 'required|in:basse,moyenne,haute',
            'status'        => 'required|in:todo,en_cours,termine',
            'idDepartement' => 'nullable|exists:departements,idDepartement',
            'idUser'        => 'nullable|exists:users,idUser',
            'idObjectif'    => 'nullable|exists:objectifs,idObjectif',
            'description'   => 'nullable',
        ]);

        $start = $request->filled('start_date') ? Carbon::parse($request->start_date) : null;
        $end = $request->filled('end_date') ? Carbon::parse($request->end_date) : null;

        $tache = Tache::create([
            'titre'         => $request->titre,
            'dateDebut'     => $start,
            'duree'         => $end,
            'typeDuree'     => $request->typeDuree,
            'priorite'      => $request->priorite,
            'status'        => $request->status,
            'idDepartement' => $request->idDepartement,
            'idObjectif'    => $request->idObjectif,
            'description'   => $request->description,
        ]);

        if ($request->filled('idUser')) {
            $tache->users()->attach($request->idUser);
        }

        return redirect()->back()->with('msg', "La tâche a été ajoutée avec succès");
    }

    public function destroy($id)
    {   
        Gate::authorize('tache.delete');
        $tache = Tache::findOrFail($id);
        $tache->delete();
        return redirect()->back()->with('msg', 'La tâche a été supprimée avec succès');
    }

    public function update(Request $request, $id) {
        Gate::authorize('tache.edit');
        $request->validate([
            'titre'         => 'required|max:30',
            'start_date'    => 'nullable|date',
            'end_date'      => 'nullable|date|after_or_equal:start_date',
            'typeDuree'     => 'required|in:h,jours,mois',
            'priorite'      => 'required|in:basse,moyenne,haute',
            'status'        => 'required|in:todo,en_cours,termine',
            'idDepartement' => 'nullable|exists:departements,idDepartement',
            'idUser'        => 'nullable|exists:users,idUser',
            'idObjectif'    => 'nullable|exists:objectifs,idObjectif',
            'description'   => 'nullable',
        ]);

        $tache = Tache::findOrFail($id);
        
        $start = $request->filled('start_date') ? Carbon::parse($request->start_date) : null;
        $end = $request->filled('end_date') ? Carbon::parse($request->end_date) : null;

        $tache->update([
            'titre'         => $request->titre,
            'dateDebut'     => $start,
            'duree'         => $end,
            'typeDuree'     => $request->typeDuree,
            'priorite'      => $request->priorite,
            'status'        => $request->status,
            'idDepartement' => $request->idDepartement,
            'idObjectif'    => $request->idObjectif,
            'description'   => $request->description,
        ]);

        if ($request->filled('idUser')) {
            $tache->users()->sync($request->idUser);
        }

        return redirect()->back()->with('msg', 'La tâche a été mise à jour avec succès');
    }

    public function status(Request $request, $id) {
        $tache = Tache::findOrFail($id);
        $tache->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }

    public function assignUser(Request $request) {
        Gate::authorize('tache.edit');
        $request->validate([
            'idTache' => 'required|exists:taches,idTache',
            'idUser'  => 'required|exists:users,idUser',
        ]);
        $tache = Tache::findOrFail($request->idTache);
        $tache->users()->syncWithoutDetaching($request->idUser);
        return redirect()->back()->with('msg', 'Utilisateur assigné avec succès');
    }

    public function unassignUser(Request $request) {
        Gate::authorize('tache.edit');
        $request->validate([
            'idTache' => 'required|exists:taches,idTache',
            'idUser'  => 'required|exists:users,idUser',
        ]);
        $tache = Tache::findOrFail($request->idTache);
        $tache->users()->detach($request->idUser);
        return redirect()->back()->with('msg', 'Utilisateur désassigné avec succès');
    }
}
