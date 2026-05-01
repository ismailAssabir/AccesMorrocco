<?php

namespace App\Http\Controllers\Client;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presentation;
use App\Models\PresentationItem;

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
        })->latest()->paginate(10);

        return view('clients.presentations.index', compact('presentations'));
    }

    public function show($id)
    {
        $client = Auth::guard('client')->user();
        $presentation = Presentation::with(['dossier', 'presentationItems.category'])
            ->whereHas('dossier', function ($query) use ($client) {
                $query->where('idClient', $client->idClient);
            })->findOrFail($id);

        return view('clients.presentations.show', compact('presentation'));
    }

    public function suggest(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        $presentation = Presentation::whereHas('dossier', function ($query) use ($client) {
                $query->where('idClient', $client->idClient);
            })->findOrFail($id);

        $request->validate([
            'reponse' => 'required|string|max:2000'
        ]);

        $presentation->update([
            'reponse' => $request->reponse,
            'status' => 'en_attente' // Or a specific status like 'modifications_demandees'
        ]);

        return redirect()->route('clients.presentations.show', $id)->with('msg', 'Votre suggestion a été envoyée avec succès.');
    }

    public function updateItemStatus(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        $item = PresentationItem::whereHas('presentation.dossier', function ($query) use ($client) {
            $query->where('idClient', $client->idClient);
        })->findOrFail($id);

        $request->validate([
            'status' => 'required|in:en_attente,validee,refusee'
        ]);

        $item->update(['status' => $request->status]);

        return response()->json(['message' => 'Statut mis à jour', 'status' => $item->status]);
    }
}
