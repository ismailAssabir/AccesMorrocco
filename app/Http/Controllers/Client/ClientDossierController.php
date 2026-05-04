<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientDossierController extends Controller
{
    public function index()
    {
        $client = Auth::guard('client')->user();

        $dossiers = $client->dossiers()
            ->latest()
            ->paginate(10);

        return view('clients.dossiers.index', compact('dossiers'));
    }

    public function show($id)
    {
        $client = Auth::guard('client')->user();

        $dossier = $client->dossiers()
            ->where('idDossier', $id)
            ->firstOrFail();

        // Fetch the last validated presentation
        $presentation = $dossier->presentations()
            ->where('status', 'validee')
            ->latest()
            ->first();

        return view('clients.dossiers.show', compact('dossier', 'presentation'));
    }
}