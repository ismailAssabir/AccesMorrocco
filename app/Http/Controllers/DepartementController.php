<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departement;
use App\Models\User;
use App\Models\Pointage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


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
        Gate::authorize('departement.view');

        // ── AUTO-MARK ABSENCES (Lazy Cron) ──────────────────────────────
        $settings = \App\Models\Company::first();
        if ($settings && $settings->absenceTime) {
            if (now()->format('H:i') >= \Carbon\Carbon::parse($settings->absenceTime)->format('H:i')) {
                \Illuminate\Support\Facades\Artisan::call('pointage:mark-absents');
            }
        }

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
                $dept->avg_presence = 0;
            } else {
                $pointagesToday = Pointage::whereIn('idUser', $employeIds)
                    ->whereDate('date', now()->toDateString())
                    ->get()
                    ->keyBy('idUser');
                
                $totalScore = 0;
                foreach ($employeIds as $id) {
                    $p = $pointagesToday->get($id);
                    if ($p) {
                        if ($p->status === 'present') $totalScore += 100;
                        elseif ($p->status === 'retard') $totalScore += 50;
                    }
                }
                
                $dept->avg_presence = round($totalScore / count($employeIds));
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
     Gate::authorize('departement.create');

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
    public function show(Request $request, $id)
    {
        Gate::authorize('departement.view');

        // ── AUTO-MARK ABSENCES (Lazy Cron) ──────────────────────────────
        $settings = \App\Models\Company::first();
        if ($settings && $settings->absenceTime) {
            if (now()->format('H:i') >= \Carbon\Carbon::parse($settings->absenceTime)->format('H:i')) {
                \Illuminate\Support\Facades\Artisan::call('pointage:mark-absents');
            }
        }

        $period = $request->get('period', 'weekly');

        $departement = Departement::with(['manager', 'employes', 'taches', 'taches.users'])->findOrFail($id);
        $this->calculatePresence($departement, $period);

        return view('showDepartement', compact('departement', 'period'));
    }

    private function calculatePresence($departement, $period)
    {
        $today = now();
        $startDate = match ($period) {
            'today' => now()->startOfDay(),
            'monthly' => now()->startOfMonth(),
            default => now()->subDays(6)->startOfDay(), // last 7 days
        };

        $workingDaysCount = 0;
        $tempDate = $startDate->copy();
        while ($tempDate->startOfDay() <= $today->startOfDay()) {
            if ($tempDate->isWeekday()) {
                $workingDaysCount++;
            } elseif ($period === 'today') {
                // If we're specifically looking at today and it's a weekend, it's a working day if they're here
                $workingDaysCount = 1;
            }
            $tempDate->addDay();
        }

        // Final fallback: if today is a weekend and we're looking at a range, 
        // we should still have at least 1 day if we want to show any percentage.
        if ($workingDaysCount === 0 && $period === 'today') {
            $workingDaysCount = 1;
        }

        $employeIds = $departement->employes->pluck('idUser')->toArray();
        $pointages = Pointage::whereIn('idUser', $employeIds)
            ->whereDate('date', '>=', $startDate->toDateString())
            ->get()
            ->groupBy('idUser');

        $todayPointages = Pointage::whereIn('idUser', $employeIds)
            ->whereDate('date', now()->toDateString())
            ->get()
            ->keyBy('idUser');

        foreach ($departement->employes as $employee) {
            $userPointages = $pointages->get($employee->idUser) ?? collect();
            
            // Calculate weighted sum for the period
            $dailyScores = $userPointages->groupBy(fn($p) => \Carbon\Carbon::parse($p->date)->toDateString())
                ->map(function($group) {
                    $p = $group->first();
                    $status = strtolower($p->status);
                    if ($status === 'present') return 100;
                    if ($status === 'retard') return 50;
                    return 0; // absent = 0
                });
            
            $totalScore = $dailyScores->sum();
            
            $employee->presence_percentage = $workingDaysCount > 0 
                ? round($totalScore / $workingDaysCount) 
                : 0;

            $todayP = $todayPointages->get($employee->idUser);
            $employee->today_pointage = $todayP;
            $employee->is_here_today = $todayP && strtolower($todayP->status) !== 'absent';
            
            // Count total retards for the period
            $employee->total_retards = $userPointages->whereIn('status', ['retard', 'Retard'])->count();
        }

        $departement->avg_presence = count($employeIds) > 0 
            ? round($departement->employes->where('presence_percentage', '>', 0)->avg('presence_percentage') ?? 0)
            : 0;
            
        // If it's today, it's easier: just average everyone's today percentage
        if ($period === 'today' && count($employeIds) > 0) {
            $departement->avg_presence = round($departement->employes->avg('presence_percentage'));
        }
    }

    public function exportPdf(Request $request, $id)
    {
        Gate::authorize('departement.view');
        $period = $request->get('period', 'monthly');
        $departement = Departement::with(['manager', 'employes'])->findOrFail($id);
        
        $this->calculatePresence($departement, $period);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('departements.report-pdf', compact('departement', 'period'));
        
        $filename = 'Rapport_' . str_replace(' ', '_', $departement->title) . '_' . now()->format('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }
public function destroy($id)

{   
    Gate::authorize('departement.delete');
$departement = Departement::findOrFail($id);
    $departement->delete();
    return redirect()->back()->with('msg', 'Le département a été supprimée');
}

    public function edit(Request $request, $id)
    {        Gate::authorize('departement.edit');

        $departement = Departement::with('manager')->findOrFail($id);
        
        if ($request->ajax()) {
            return response()->json($departement);
        }

        return view('editDepartement', compact('departement'));
    }

public function update(Request $request ,$id){
         Gate::authorize('departement.edit');

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
