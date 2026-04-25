<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\User;
use App\Models\Departement;
use App\Models\Client;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('lead.view');

        $query = Lead::with(['user', 'client', 'departements']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('firstName', 'like', "%{$search}%")
                  ->orWhere('lastName', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phoneNumber', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('source', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $leads = $query->latest()->paginate(10)->withQueryString();

        $types = Lead::select('type')->distinct()->pluck('type');

        return view('leads.index', compact('leads', 'types'));
    }

    public function store(Request $request)
    {
        Gate::authorize('lead.create');

        $validatedData = $request->validate([
            'firstName'     => 'required|string|max:25',
            'lastName'      => 'required|string|max:25',
            'email'         => 'nullable|email|unique:leads,email',
            'adresse'       => 'nullable|string',
            'CNE'           => 'nullable|string',
            'phoneNumber'   => 'nullable|string',
            'nationalite'   => 'nullable|string',
            'source'        => 'nullable|string',
            'note'          => 'nullable|string',
            'type'          => 'required|string|max:20',
            'idUser'        => 'nullable|exists:users,idUser',
            'idClient'      => 'nullable|exists:clients,idClient',
            'idDepartement' => 'nullable|exists:departements,idDepartement',
        ]);

        $validatedData['dateCreation'] = now()->toDateString();

        Lead::create($validatedData);

        return redirect()->back()->with('msg', 'Lead ajouté avec succès !');
    }

    public function show($id)
    {
        Gate::authorize('lead.view');

        $lead = Lead::with(['user', 'client', 'departements'])->findOrFail($id);
        $users = User::all();
        $departements = Departement::all();

        return view('leads.show', compact('lead', 'users', 'departements'));
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('lead.edit');

        $lead = Lead::findOrFail($id);

        $validatedData = $request->validate([
            'firstName'     => 'required|string|max:25',
            'lastName'      => 'required|string|max:25',
            'email'         => 'nullable|email|unique:leads,email,' . $id . ',idLead',
            'adresse'       => 'nullable|string',
            'CNE'           => 'nullable|string',
            'phoneNumber'   => 'nullable|string',
            'nationalite'   => 'nullable|string',
            'source'        => 'nullable|string',
            'note'          => 'nullable|string',
            'type'          => 'required|string|max:20',
            'idUser'        => 'nullable|exists:users,idUser',
            'idClient'      => 'nullable|exists:clients,idClient',
            'idDepartement' => 'nullable|exists:departements,idDepartement',
        ]);

        $lead->update($validatedData);

        return redirect()->back()->with('msg', 'Lead mis à jour avec succès !');
    }

    public function destroy($id)
    {
        Gate::authorize('lead.delete');

        $lead = Lead::findOrFail($id);
        $lead->delete();

        return redirect()->back()->with('msg', 'Lead supprimé avec succès !');
    }

    public function exportPdf(Request $request)
    {
        Gate::authorize('lead.view');

        $query = Lead::with(['user', 'client', 'departements']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('firstName', 'like', "%{$search}%")
                  ->orWhere('lastName', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $leads = $query->latest()->get();

        $pdf = Pdf::loadView('leads.pdf', compact('leads'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('leads-' . now()->format('Y-m-d') . '.pdf');
    }
}