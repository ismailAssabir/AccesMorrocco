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

    return view('clients.dashboard', compact('client', 'dossiers'));
}
}
