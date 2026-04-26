<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reunion;
use App\Models\Departement;
use Illuminate\Support\Facades\Gate;


class ReunionController extends Controller
{
    public function index()
    {
        Gate::authorize('reunion.view');
        $user = auth()->user();
        
        if ($user->type === 'employee') {
            // Employees see meetings for "All" (idDepartement null), their department, or where they are specifically invited
            $reunions = Reunion::with(['departement', 'participants'])
                ->where(function($q) use ($user) {
                    $q->whereNull('idDepartement')
                      ->orWhere('idDepartement', $user->idDepartement)
                      ->orWhereHas('participants', function($sq) use ($user) {
                          $sq->where('reunion_participants.idUser', $user->idUser);
                      });
                })
                ->latest()
                ->get();
        } else {
            // Admins/Managers see everything
            $reunions = Reunion::with(['departement', 'participants'])->latest()->get();
        }

        $departements = Departement::all();
        $users = \App\Models\User::where('status', 'active')->orderBy('firstName')->get();
        
        return view('reunions.index', compact('reunions', 'departements', 'users'));
    }

    public function create()
    {
        Gate::authorize('reunion.create');
        $departements = Departement::all();
        $users = \App\Models\User::where('status', 'active')->orderBy('firstName')->get();
        return view('reunions.create', compact('departements', 'users'));
    }

    public function edit($id)
    {
        Gate::authorize('reunion.edit');
        $reunion = Reunion::with('participants')->findOrFail($id);
        $departements = Departement::all();
        $users = \App\Models\User::where('status', 'active')->orderBy('firstName')->get();
        return view('reunions.edit', compact('reunion', 'departements', 'users'));
    }

    public function store(Request $request)
    {
        Gate::authorize('reunion.create');

        $validated = $request->validate([
            'invitation_type' => 'required|in:all,department,individual',
            'idDepartement'   => 'nullable|required_if:invitation_type,department|exists:departements,idDepartement',
            'participant_ids' => 'nullable|required_if:invitation_type,individual|array',
            'participant_ids.*' => 'exists:users,idUser',
            'objectif'        => 'required|string|max:255',
            'titre'           => 'required|string|max:100',
            'description'     => 'nullable|string',
            'dateHeure'       => 'nullable|date',
            'heureFin'        => 'nullable', 
            'type'            => 'required|string',
            'lien'            => 'nullable|string',
            'lieu'            => 'nullable|string|max:100',
        ]);

        // If "all", idDepartement should be null
        if ($request->invitation_type === 'all') {
            $validated['idDepartement'] = null;
        }

        $reunion = Reunion::create($validated);

        if ($request->invitation_type === 'individual') {
            $reunion->participants()->sync($request->participant_ids);
        }

        // Send Emails
        $this->sendInvitations($reunion, $request->invitation_type, $request->participant_ids ?? []);

        return redirect('/reunions')->with('msg', 'La réunion a été ajoutée avec succès et les invitations ont été envoyées.');
    }

    private function sendInvitations($reunion, $invitationType, $participantIds = [])
    {
        $recipients = collect();

        if ($invitationType === 'individual') {
            $recipients = \App\Models\User::whereIn('idUser', $participantIds)->get();
        } elseif ($invitationType === 'department') {
            $recipients = \App\Models\User::where('idDepartement', $reunion->idDepartement)->get();
        } else {
            $recipients = \App\Models\User::where('status', 'active')->get();
        }

        foreach ($recipients as $recipient) {
            if ($recipient->email) {
                try {
                    \Illuminate\Support\Facades\Mail::to($recipient->email)->send(new \App\Mail\MeetingInvitation($reunion));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Failed to send meeting email to {$recipient->email}: " . $e->getMessage());
                }
            }
        }
    }

    public function show($id)
    {
        Gate::authorize('reunion.view');
        $reunion = Reunion::with(['departement', 'participants'])->findOrFail($id);

        if (auth()->user()->type === 'employee') {
            $user = auth()->user();
            $isParticipant = $reunion->participants->contains('idUser', $user->idUser);
            $isGlobal = $reunion->idDepartement === null;
            $isDeptMatch = $reunion->idDepartement === $user->idDepartement;

            if (!$isGlobal && !$isDeptMatch && !$isParticipant) {
                abort(403, "Vous n'êtes pas autorisé à voir cette réunion.");
            }
        }

        return view('reunions.show', compact('reunion'));
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('reunion.edit');
        $reunion = Reunion::findOrFail($id);
        
        $validated = $request->validate([
            'invitation_type' => 'required|in:all,department,individual',
            'idDepartement'   => 'nullable|required_if:invitation_type,department|exists:departements,idDepartement',
            'participant_ids' => 'nullable|required_if:invitation_type,individual|array',
            'participant_ids.*' => 'exists:users,idUser',
            'objectif'        => 'required|string|max:255',
            'titre'           => 'required|string|max:100',
            'description'     => 'nullable|string',
            'dateHeure'       => 'nullable|date',
            'heureFin'        => 'nullable',
            'type'            => 'required|string',
            'lien'            => 'nullable|string',
            'lieu'            => 'nullable|string|max:100',
        ]);

        if ($request->invitation_type === 'all') {
            $validated['idDepartement'] = null;
        }

        $reunion->update($validated);

        if ($request->invitation_type === 'individual') {
            $reunion->participants()->sync($request->participant_ids);
        } else {
            $reunion->participants()->detach();
        }

        // Send updated emails
        $this->sendInvitations($reunion, $request->invitation_type, $request->participant_ids ?? []);

        return redirect('/reunions')->with('msg', 'La réunion a été mise à jour et les invitations ont été renvoyées.');
    }

    public function destroy($id)
    {
        Gate::authorize('reunion.delete');
        $reunion = Reunion::findOrFail($id);
        $reunion->delete();
        return redirect('/reunions')->with('msg', 'Réunion supprimée avec succès');
    }
}