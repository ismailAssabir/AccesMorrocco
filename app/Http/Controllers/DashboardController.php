<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tache;
use App\Models\Reunion;
use App\Models\Reclamation;
use App\Models\Departement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user->load('departement');

        if ($user->type === 'employee') {
            $stats = [
                'myTasks' => $user->taches()->count(),
                'myPendingReclamations' => $user->reclamations()->whereIn('status', ['ouverte', 'en_cours'])->count(),
                'myDepartmentMeetings' => Reunion::where('dateHeure', '>=', now())
                    ->where(function($q) use ($user) {
                        $q->whereNull('idDepartement')->orWhere('idDepartement', $user->idDepartement);
                    })->count(),
                'myPoints' => 0 // Mocking points for now if applicable
            ];

            $myRecentTasks = $user->taches()->latest()->take(5)->get();
            $myRecentReclamations = $user->reclamations()->latest()->take(5)->get();
            
            $upcomingReunions = Reunion::where('dateHeure', '>=', now())
                ->where(function($q) use ($user) {
                    $q->whereNull('idDepartement')->orWhere('idDepartement', $user->idDepartement);
                })
                ->orderBy('dateHeure', 'asc')
                ->take(6)
                ->get();

            if ($upcomingReunions->isEmpty()) {
                $upcomingReunions = Reunion::where(function($q) use ($user) {
                        $q->whereNull('idDepartement')->orWhere('idDepartement', $user->idDepartement);
                    })
                    ->latest('dateHeure')
                    ->take(6)
                    ->get();
            }

            return view('dashboard', compact('stats', 'myRecentTasks', 'myRecentReclamations', 'upcomingReunions'));
        }

        $totalTasks = Tache::count();
        $completedTasks = Tache::where('status', 'termine')->count();
        $completionPercentage = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

        $stats = [
            'totalEmployees' => User::count(),
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'completionPercentage' => round($completionPercentage),
            'upcomingMeetings' => Reunion::where('dateHeure', '>=', now())->count(),
            'pendingReclamations' => Reclamation::whereIn('status', ['ouverte', 'en_cours'])->count(),
        ];

        $recentReclamations = Reclamation::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Logic for Agenda Flash: Show up to 6 relevant meetings
        // 1. Get upcoming meetings (closest first)
        $upcomingReunions = Reunion::where('dateHeure', '>=', now())
            ->orderBy('dateHeure', 'asc')
            ->take(6)
            ->get();

        // 2. If less than 6, fill with recent past meetings
        if ($upcomingReunions->count() < 6) {
            $needed = 6 - $upcomingReunions->count();
            $pastReunions = Reunion::where('dateHeure', '<', now())
                ->latest('dateHeure')
                ->take($needed)
                ->get();
            
            // Merge them: Upcoming first, then past
            $upcomingReunions = $upcomingReunions->concat($pastReunions);
        }

        $managers = User::where('type', 'manager')
            ->take(6)
            ->get();

        // Chart Data
        $tasksByStatus = [
            'en_attente' => Tache::where('status', 'todo')->count(),
            'en_cours' => Tache::where('status', 'en_cours')->count(),
            'termine' => Tache::where('status', 'termine')->count(),
        ];

        $reclamationsByStatus = [
            'ouverte' => Reclamation::where('status', 'ouverte')->count(),
            'en_cours' => Reclamation::where('status', 'en_cours')->count(),
            'resolue' => Reclamation::where('status', 'resolue')->count(),
        ];

        $deptStats = Departement::withCount('employes')->get()->map(function($dept) {
            return [
                'name' => $dept->title,
                'count' => $dept->employes_count
            ];
        });

        // Registration Trend (Last 6 Months)
        $trendData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $trendData[] = [
                'month' => $date->translatedFormat('M'),
                'count' => User::whereMonth('created_at', $date->month)
                              ->whereYear('created_at', $date->year)
                              ->count()
            ];
        }

        return view('dashboard', compact(
            'stats', 
            'recentReclamations', 
            'upcomingReunions', 
            'managers',
            'tasksByStatus',
            'reclamationsByStatus',
            'deptStats',
            'trendData'
        ));
    }
}
