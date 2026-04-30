<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Paiement;

class ClientPaiementController extends Controller
{
    public function index()
    {
        /** @var \App\Models\Client $client */
        $client = Auth::guard('client')->user();

        // Get all payments associated with the client's dossiers
        $paiements = Paiement::whereIn('idDossier', $client->dossiers()->pluck('idDossier'))
            ->with('dossier')
            ->latest()
            ->paginate(10);

        return view('clients.paiements.index', compact('paiements', 'client'));
    }
}
