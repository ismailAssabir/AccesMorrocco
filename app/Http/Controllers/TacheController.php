<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tache;
use App\Models\User;
use App\Models\Objectif;
use App\Models\Departement;
use Illuminate\Support\Facades\Gate;

class TacheController extends Controller
{
    public function index()
    {   Gate::authorize('tache.view');

        $query = Tache::with(['users', 'objectif', 'departement']);

        if (auth()->user()->type === 'employee') {
            $user = auth()->user();
            $query->where(function($q) use ($user) {
                $q->whereNull('idDepartement')
                  ->orWhere('idDepartement', $user->idDepartement);
            });
        }

        $Taches = $query->get();
        $users = User::all();
        $objectifs = Objectif::all();
        $departements = Departement::all();
        return view('taches.index', compact('Taches', 'users', 'objectifs', 'departements'));
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

    $data = $request->all();
    
    // Parse dates with Carbon
    $start = $request->filled('start_date') ? \Carbon\Carbon::parse($request->start_date) : null;
    $end = $request->filled('end_date') ? \Carbon\Carbon::parse($request->end_date) : null;

    // Precise Human-Readable Duration Logic
    $formattedDuration = '0 min';
    if ($start && $end) {
        if ($start->equalTo($end)) {
            $formattedDuration = 'Short Task';
        } else {
            $totalMinutes = $start->diffInMinutes($end);
            
            if ($totalMinutes >= 1440) {
                // Scenario A: More than 24 hours (Multiple Days)
                $days = floor($totalMinutes / 1440);
                $remMins = $totalMinutes % 1440;
                $hours = floor($remMins / 60);
                $formattedDuration = $hours > 0 ? "{$days}j {$hours}h" : "{$days} " . ($days > 1 ? 'Jours' : 'Jour');
            } else {
                // Scenario B: Less than 24 hours (Hours/Minutes)
                if ($totalMinutes < 60) {
                    $formattedDuration = $totalMinutes . ' min';
                } else {
                    $hours = floor($totalMinutes / 60);
                    $mins = $totalMinutes % 60;
                    $formattedDuration = $mins > 0 ? "{$hours}h {$mins}min" : "{$hours}h";
                }
            }
        }
    }

    // Prepare model data
    $tacheData = [
        'titre'         => $request->titre,
        'dateDebut'     => $start,
        'duree'         => $end, // duree stores the end date/time
        'typeDuree'     => $request->typeDuree,
        'priorite'      => $request->priorite,
        'status'        => $request->status,
        'idDepartement' => $request->idDepartement,
        'idObjectif'    => $request->idObjectif,
        'description'   => $request->description,
    ];

    $tache = Tache::create($tacheData);

    if ($request->filled('idUser')) {
        $tache->users()->attach($request->idUser);
    }

    return redirect()->back()->with('msg', "La tâche a été ajoutée avec succès");
}
    public function show($id)
    {
        $Tache = Tache::with(['users', 'objectif'])->findOrFail($id);

        if (auth()->user()->type === 'employee') {
            $user = auth()->user();
            if ($Tache->idDepartement !== null && $Tache->idDepartement !== $user->idDepartement) {
                abort(403, "Vous n'êtes pas autorisé à voir cette tâche.");
            }
        }

        return view('showTache', compact('Tache'));
    }
public function destroy($id)

{   
    Gate::authorize('tache.delete');
    $Tache = Tache::findOrFail($id);
    $Tache->delete();
    return redirect()->back()->with('msg', 'La tache a été supprimée');
}

public function edit($id){
    Gate::authorize('tache.edit');
    $Tache = Tache::with('user')->findOrFail($id);
    return view('editTache' , compact('Tache'));
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
    
    // Parse dates with Carbon
    $start = $request->filled('start_date') ? \Carbon\Carbon::parse($request->start_date) : null;
    $end = $request->filled('end_date') ? \Carbon\Carbon::parse($request->end_date) : null;

    // Precise Human-Readable Duration Logic (Consistency)
    $formattedDuration = '0 min';
    if ($start && $end) {
        if ($start->equalTo($end)) {
            $formattedDuration = 'Short Task';
        } else {
            $totalMinutes = $start->diffInMinutes($end);
            if ($totalMinutes >= 1440) {
                // Scenario A: More than 24 hours (Multiple Days)
                $days = floor($totalMinutes / 1440);
                $remMins = $totalMinutes % 1440;
                $hours = floor($remMins / 60);
                $formattedDuration = $hours > 0 ? "{$days}j {$hours}h" : "{$days} " . ($days > 1 ? 'Jours' : 'Jour');
            } else {
                // Scenario B: Less than 24 hours (Hours/Minutes)
                if ($totalMinutes < 60) {
                    $formattedDuration = $totalMinutes . ' min';
                } else {
                    $hours = floor($totalMinutes / 60);
                    $mins = $totalMinutes % 60;
                    $formattedDuration = $mins > 0 ? "{$hours}h {$mins}min" : "{$hours}h";
                }
            }
        }
    }

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

public function assignUser(Request $request) {
    Gate::authorize('tache.edit');
    $request->validate([
        'idTache' => 'required|exists:taches,idTache',
        'idUser'  => 'required|exists:users,idUser'
    ]);

    $tache = Tache::findOrFail($request->idTache);
    $tache->users()->syncWithoutDetaching([$request->idUser]);

    return redirect()->back()->with('msg', 'Employé assigné à la tâche avec succès');
}

public function unassignUser(Request $request) {
    Gate::authorize('tache.edit');
    $request->validate([
        'idTache' => 'required|exists:taches,idTache',
        'idUser'  => 'required|exists:users,idUser'
    ]);

    $tache = Tache::findOrFail($request->idTache);
    $tache->users()->detach($request->idUser);

    return redirect()->back()->with('msg', 'Employé retiré de la tâche');
}
}
