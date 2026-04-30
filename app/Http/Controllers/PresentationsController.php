<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use Illuminate\Http\Request;

class PresentationsController extends Controller
{
    public function index(Request $request)
    {
        $query = Presentation::with(['dossier']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('titre', 'LIKE', "%{$search}%")
                  ->orWhere('comment', 'LIKE', "%{$search}%")
                  ->orWhere('reponse', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('idDossier')) {
            $query->where('idDossier', $request->idDossier);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        return response()->json($query->latest('idPresentation')->paginate(10));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'idDossier' => 'required|exists:dossiers,idDossier',
            'titre'     => 'required|string|max:255',
            'date'      => 'nullable|date',
            'status'    => 'nullable|in:en_attente,validee,refusee',
            'comment'   => 'nullable|string',
            'reponse'   => 'nullable|string',
        ]);

        $presentation = Presentation::create($validated);

        return response()->json($presentation, 201);
    }

    public function show($id)
    {
        return response()->json(Presentation::with(['dossier', 'presentationItems'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $presentation = Presentation::findOrFail($id);

        $validated = $request->validate([
            'idDossier' => 'sometimes|required|exists:dossiers,idDossier',
            'titre'     => 'sometimes|required|string|max:255',
            'date'      => 'nullable|date',
            'status'    => 'sometimes|required|in:en_attente,validee,refusee',
            'comment'   => 'nullable|string',
            'reponse'   => 'nullable|string',
        ]);

        $presentation->update($validated);

        return response()->json($presentation);
    }

    public function destroy($id)
    {
        Presentation::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}