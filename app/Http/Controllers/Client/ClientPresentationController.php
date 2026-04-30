<?php

namespace App\Http\Controllers\Client;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presentation;

class ClientPresentationController extends Controller
{
    /**
     * Display the client presentations page.
     */
    public function index()
{
    $client = Auth::guard('client')->user();

    $presentations = Presentation::whereHas('dossier', function ($query) use ($client) {
        $query->where('idClient', $client->idClient);
    })->latest()->get();

    return view('clients.presentations.index', compact('presentations'));
}
}
