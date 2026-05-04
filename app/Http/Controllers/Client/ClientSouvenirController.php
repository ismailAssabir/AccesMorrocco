<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Souvenir;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClientSouvenirController extends Controller
{
    public function index()
    {
        $client = Auth::guard('client')->user();
        $souvenirs = Souvenir::where('idClient', $client->idClient)
            ->with('dossier')
            ->latest()
            ->paginate(12);

        $dossiers = $client->dossiers;

        return view('clients.souvenirs.index', compact('souvenirs', 'dossiers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'date' => 'nullable|date',
            'mood' => 'nullable|string',
            'location' => 'nullable|string',
            'idDossier' => 'nullable|exists:dossiers,idDossier'
        ]);

        $client = Auth::guard('client')->user();
        $data = $request->all();
        $data['idClient'] = $client->idClient;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('souvenirs', 'public');
            $data['image'] = $path;
        }

        Souvenir::create($data);

        return redirect()->back()->with('msg', 'Votre souvenir a été enregistré !');
    }

    public function update(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        $souvenir = Souvenir::where('idClient', $client->idClient)->findOrFail($id);

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'date' => 'nullable|date',
            'mood' => 'nullable|string',
            'location' => 'nullable|string',
            'idDossier' => 'nullable|exists:dossiers,idDossier'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($souvenir->image) {
                Storage::disk('public')->delete($souvenir->image);
            }
            $path = $request->file('image')->store('souvenirs', 'public');
            $data['image'] = $path;
        }

        $souvenir->update($data);

        return redirect()->back()->with('msg', 'Votre souvenir a été mis à jour !');
    }

    public function destroy($id)
    {
        $client = Auth::guard('client')->user();
        $souvenir = Souvenir::where('idClient', $client->idClient)->findOrFail($id);

        if ($souvenir->image) {
            Storage::disk('public')->delete($souvenir->image);
        }

        $souvenir->delete();

        return redirect()->back()->with('msg', 'Souvenir supprimé.');
    }
}
