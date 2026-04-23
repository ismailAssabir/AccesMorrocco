<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tache;
use App\Models\Reunion;
use App\Models\Reclamation;
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
                ->take(5)
                ->get();

            return view('dashboard', compact('stats', 'myRecentTasks', 'myRecentReclamations', 'upcomingReunions'));
        }

        $stats = [
            'totalEmployees' => User::count(),
            'totalTasks' => Tache::count(),
            'upcomingMeetings' => Reunion::where('dateHeure', '>=', now())->count(),
            'pendingReclamations' => Reclamation::whereIn('status', ['ouverte', 'en_cours'])->count(),
        ];

        $recentReclamations = Reclamation::with('user')
            ->latest()
            ->take(5)
            ->get();

        $upcomingReunions = Reunion::where('dateHeure', '>=', now())
            ->orderBy('dateHeure', 'asc')
            ->take(5)
            ->get();

        $managers = User::where('type', 'manager')
            ->take(6)
            ->get();

        return view('dashboard', compact('stats', 'recentReclamations', 'upcomingReunions', 'managers'));
    }
}
