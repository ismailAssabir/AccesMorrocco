<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientDashboardController extends Controller
{
    public function index()
    {
        $client = Auth::guard('client')->user();

        $dossiers = $client->dossiers()
            ->latest()
            ->paginate(10);

        $souvenirsCount = \App\Models\Souvenir::where('idClient', $client->idClient)->count();

        return view('clients.dashboard', compact('client', 'dossiers', 'souvenirsCount'));
    }
}
