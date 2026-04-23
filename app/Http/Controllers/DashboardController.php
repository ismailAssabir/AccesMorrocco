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
