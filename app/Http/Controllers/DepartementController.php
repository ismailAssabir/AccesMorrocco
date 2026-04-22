<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departement;
use App\Models\User;
use App\Models\Pointage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DepartementController extends Controller
{
    private function getJoursOuvrables()
    {
        $debut = Carbon::now()->startOfMonth();
        $fin   = Carbon::now()->endOfMonth();
        $jours = 0;

        while ($debut<=$fin) {
            if ($debut->isWeekday()) {
                $jours++;
            }
            $debut->addDay();
        }

        return $jours;
    }
    public function index(){
        $depts = Departement::with(['manager', 'employes'])
            ->withCount([
                'employes as users_count', 
                'taches as tasks_count', 
                'taches as completed_tasks_count' => function ($query) {
                    $query->where('status', 'termine'); // Status exact dans la BDD
                }
            ])->get();

        foreach($depts as $dept){
            // 1. Tâches Moyenne
            $dept->tasks_completion = $dept->tasks_count > 0 
                ? round(($dept->completed_tasks_count / $dept->tasks_count) * 100) 
                : 0;

            // 2. Présence Moyenne (pour aujourd'hui)
            $employeIds = $dept->employes->pluck('idUser')->toArray();

            if (empty($employeIds)) {
                $dept->avg_presence = 0; // Fallback pour les départements vides
            } else {
                $presentCount = Pointage::whereIn('idUser', $employeIds)
                    ->whereIn('status', ['present', 'Present', 'présent', 'Présent']) // Gère les variations de casse
                    ->whereDate('date', now()->toDateString())
                    ->count();
                
                $dept->avg_presence = round(($presentCount / count($employeIds)) * 100);
            }
        }
        
       $state =[
            'totalDepartements' => $depts->count(),
            'totalEmployes'     => $depts->sum('users_count'),
            'presenceMoyenne'   => $depts->count() > 0 ? round($depts->avg('avg_presence')) : 0,
            'tachesMoyenne'     => $depts->count() > 0 ? round($depts->avg('tasks_completion')) : 0,
       ];

        return view('departements.index' , ['departements'=>$depts, 'state'=> $state] );
    }

public function store(Request $request) {
    

    $newDepartement = $request->validate([
        'title'     => 'required|string|max:55',
        'description'    => 'nullable|string|max:255',
        'idUser'  =>  'nullable|exists:users,idUser'
       
    ]);
    
    DB::transaction(function () use ($newDepartement) {
        $departement = Departement::create($newDepartement);
        
        // Ensure new manager is updated
        if ($departement->idUser) {
            // Remove them from any other department they were managing
            Departement::where('idUser', $departement->idUser)
                       ->where('idDepartement', '!=', $departement->idDepartement)
                       ->update(['idUser' => null]);

            User::where('idUser', $departement->idUser)->update([
                'type' => 'manager',
                'idDepartement' => $departement->idDepartement
            ]);
        }
    });
    
    return redirect()->back()->with('msg' , "Le département a été ajouté avec succès");

}
public function show($id){
    $departement = Departement::with(['manager', 'taches', 'taches.users'])->findOrFail($id);
    return view('showDepartement' , compact('departement'));
}
public function destroy($id)
{   $departement = Departement::findOrFail($id);
    $departement->delete();
    return redirect()->back()->with('msg', 'Le département a été supprimée');
}

    public function edit(Request $request, $id)
    {
        $departement = Departement::with('manager')->findOrFail($id);
        
        if ($request->ajax()) {
            return response()->json($departement);
        }

        return view('editDepartement', compact('departement'));
    }

public function update(Request $request ,$id){
    
    $departementUpdate = $request->validate([
        'title'     => 'required|string|max:55',
        'description'    => 'nullable|string|max:255',
        'idUser'  =>  'nullable|exists:users,idUser'
    ]);
    
    DB::transaction(function () use ($request, $id, $departementUpdate) {
        $departement = Departement::findOrFail($id);
        $oldManagerId = $departement->idUser;
        $newManagerId = $request->idUser;

        $departement->update($departementUpdate);

        // One Manager per Department Logic
        if ($oldManagerId !== $newManagerId) {
            // Demote old manager to employee
            if ($oldManagerId) {
                User::where('idUser', $oldManagerId)->update(['type' => 'employee']);
            }
            
            // Promote new manager and assign them to this department
            if ($newManagerId) {
                // Remove new manager from any other department they might be managing
                Departement::where('idUser', $newManagerId)
                           ->where('idDepartement', '!=', $id)
                           ->update(['idUser' => null]);

                User::where('idUser', $newManagerId)->update([
                    'type' => 'manager',
                    'idDepartement' => $id
                ]);
            }
        }
    });

    return redirect()->back()->with('msg' , 'Le département été mises à jour avec succès');
}
}
