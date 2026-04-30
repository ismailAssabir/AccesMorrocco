<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Reclamation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class ReclamationController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('reclamation.view');

        $query = Reclamation::with('user');

        // Role-based filtering: employees only see their own requests
        if (auth()->user()->type === 'employee') {
            $query->where('idUser', auth()->id());
        }

        // Search logic
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('titre', 'LIKE', "%$s%")
                  ->orWhere('description', 'LIKE', "%$s%");
            });
        }

        // Status logic
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Priority logic
        if ($request->filled('priorite')) {
            $query->where('priorite', $request->priorite);
        }

        $Reclamations = $query->latest()->get();

        if ($request->ajax()) {
            return view('partials.reclamations-table', compact('Reclamations'))->render();
        }

        return view('AllReclamations', compact("Reclamations"));
    }

    public function store(Request $request)
    {        Gate::authorize('reclamation.create');

        $data = $request->validate([
            'description' => 'nullable|string|min:10|max:255',
            'status'      => 'in:ouverte,en_cours,resolue',
            'priorite'    => 'in:basse,moyenne,haute',
            'titre'       => 'string|min:2|max:20',
            'fichier'     => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'reponse'     => 'string|max:255|nullable'
        ]);

        // Force idUser to current user for employees
        $data['idUser'] = auth()->id();

        if ($request->hasFile('fichier')) {
            $path = $request->file('fichier')->store('Reclamations', 'public');
            $data['fichier'] = $path;
        }

        Reclamation::create($data);
        return redirect()->back()->with('msg', "La Réclamation a été ajoutée avec succès");
    }

    public function show($id)
    {    Gate::authorize('reclamation.edit');
        $Reclamation = Reclamation::with('user')->findOrFail($id);

        if (auth()->user()->type === 'employee' && $Reclamation->idUser !== auth()->id()) {
            abort(403, "Vous n'êtes pas autorisé à voir cette réclamation.");
        }

        return view('showReclamation', compact('Reclamation'));
    }




    public function destroy($id)
    {
        // Gate::authorize('reclamation.delete'); // Optional depending on permissions setup
        $Reclamation = Reclamation::findOrFail($id);
        
        // Only allow admins/managers or the owner to delete
        if (auth()->user()->type === 'employee' && $Reclamation->idUser !== auth()->id()) {
            abort(403, "Vous n'êtes pas autorisé à supprimer cette réclamation.");
        }

        $Reclamation->delete();
        return redirect()->back()->with('msg', 'La réclamation a été supprimée avec succès.');
    }

    public function reponse(Request $request, $id)
    {
        // Gate::authorize('reclamation.edit'); // Assuming edit permission is required to reply
        $Reclamation = Reclamation::findOrFail($id);
        
        $data = $request->validate([
            'reponse' => 'required|string|max:500'
        ]);

        $data['status'] = 'resolue'; // Automatically resolve as per UI

        $Reclamation->update($data);
        return redirect()->back()->with('msg', 'La réponse a été ajoutée et la réclamation est marquée comme résolue.');
    }
}
