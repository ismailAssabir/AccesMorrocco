<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pointage;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PointageController extends Controller
{
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        return $earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    private function buildPointageQuery(Request $request)
    {
        $query = Pointage::with(['user', 'user.departement']);

        // Filter: search by name
        if ($search = $request->get('search')) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('firstName', 'like', "%{$search}%")
                  ->orWhere('lastName',  'like', "%{$search}%");
            });
        }

        // Period Filtering
        $period = $request->get('period');
        $start = null;
        $end = null;

        if ($period === 'today') {
            $start = now()->startOfDay();
            $end = now()->endOfDay();
        } elseif ($period === 'week') {
            $start = now()->startOfWeek();
            $end = now()->endOfWeek();
        } elseif ($period === 'month') {
            $start = now()->startOfMonth();
            $end = now()->endOfMonth();
        } elseif ($period === 'custom') {
            $start = $request->filled('start_date') ? Carbon::parse($request->start_date)->startOfDay() : null;
            $end = $request->filled('end_date') ? Carbon::parse($request->end_date)->endOfDay() : null;
        }

        if ($start && $end) {
            $query->whereBetween('date', [$start->toDateString(), $end->toDateString()]);
        } elseif ($start) {
            $query->where('date', '>=', $start->toDateString());
        } elseif ($end) {
            $query->where('date', '<=', $end->toDateString());
        }

        // Filter: status
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        // Filter: role
        if ($role = $request->get('role')) {
            $query->whereHas('user', fn($q) => $q->where('type', $role));
        }

        // Filter: departement
        if ($dept = $request->get('departement')) {
            $query->whereHas('user.departement', fn($q) => $q->where('title', 'like', "%{$dept}%"));
        }

        // Filter: user_id
        if ($idUser = $request->get('user_id')) {
            $query->where('idUser', $idUser);
        }

        // Filter: justification
        if ($request->has('has_justification') && $request->get('has_justification') !== '') {
            if ($request->get('has_justification') === '1' || $request->get('has_justification') === 'yes') {
                $query->whereNotNull('justification');
            } else {
                $query->whereNull('justification');
            }
        }

        return $query;
    }

    public function index(Request $request)
    {
        Gate::authorize('pointage.view');

        $query = $this->buildPointageQuery($request);

        $pointages = $query->orderBy('date', 'desc')
            ->orderBy('heureEntree', 'desc')
            ->paginate(10)
            ->withQueryString();
            
        $statsQuery = clone $query;
        $stats = [
            'total' => $statsQuery->count(),
            'presents' => (clone $statsQuery)->where('status', 'present')->count(),
            'retards' => (clone $statsQuery)->where('status', 'retard')->count(),
            'absents' => (clone $statsQuery)->where('status', 'absent')->count(),
            'withJustif' => (clone $statsQuery)->whereNotNull('justification')->count(),
        ];
            
        $settings = Company::first();
        $users = \App\Models\User::orderBy('firstName')->get();
        $departements = \App\Models\Departement::orderBy('title')->get();
        $roles = \App\Models\User::distinct()->pluck('type');

        return view('Adminpointage', compact('pointages', 'settings', 'stats', 'users', 'departements', 'roles'));
    }

    public function userPointage()
    {
        Gate::authorize('pointage.view');

        $user   = auth()->user();
        $idUser = auth()->id();
        $today  = now()->toDateString();
        $settings = Company::first();
        $isAdmin  = $user->can('view_all_attendance');

        // ── Today's personal pointage (for clock-in status) ──────────────────
        $todayPointage = Pointage::where('idUser', $idUser)
            ->where('date', $today)
            ->first();

        // ── Departments and unique Posts for filter dropdowns ────────────────
        $departements = \App\Models\Departement::orderBy('title')->get();
        $uniquePosts  = \App\Models\User::whereNotNull('post')->distinct()->pluck('post');

        $isRealAdmin = ($user->type === 'admin');

        // ── AUTO-MARK ABSENCES (Lazy Cron) ──────────────────────────────
        if ($settings && $settings->absenceTime) {
            $now = now()->format('H:i');
            $deadline = \Carbon\Carbon::parse($settings->absenceTime)->format('H:i');
            
            if ($now >= $deadline) {
                \Illuminate\Support\Facades\Artisan::call('pointage:mark-absents');
            }
        }

        if ($isRealAdmin) {
            // ── ADMIN GLOBAL VIEW ─────────────────────────────────────────────
            $query = Pointage::with(['user.departement'])
                ->where('date', $today)
                ->orderBy('heureEntree', 'desc');

            // Filter: search by name
            if ($search = request('search')) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('firstName', 'like', "%{$search}%")
                      ->orWhere('lastName',  'like', "%{$search}%");
                });
            }

            // Filter: department
            if ($dept = request('departement')) {
                $query->whereHas('user', fn($q) => $q->where('idDepartement', $dept));
            }

            // Filter: post (Job Title)
            if ($post = request('post')) {
                $query->whereHas('user', fn($q) => $q->where('post', $post));
            }

            // Filter: role/type
            if ($role = request('role')) {
                $query->whereHas('user', fn($q) => $q->where('type', $role));
            }

            // Filter: attendance status
            if ($status = request('status')) {
                $query->where('status', $status);
            }

            $recentPointages = $query->paginate(10)->withQueryString();

            // Stats for today (Global)
            $statsQuery = Pointage::where('date', $today);
            $totalToday    = $statsQuery->count();
            $presentsToday = (clone $statsQuery)->where('status', 'present')->count();
            $retardsToday  = (clone $statsQuery)->where('status', 'retard')->count();
            $absentsToday  = (clone $statsQuery)->where('status', 'absent')->count();
        } else {
            // ── MANAGER / EMPLOYEE PERSONAL VIEW ──────────────────────────────
            $recentPointages = Pointage::where('idUser', $idUser)
                ->with('user')
                ->orderBy('date', 'desc')
                ->orderBy('heureEntree', 'desc')
                ->paginate(10);

            $totalToday    = Pointage::where('idUser', $idUser)->where('date', $today)->count();
            $presentsToday = Pointage::where('idUser', $idUser)->where('date', $today)->where('status', 'present')->count();
            $retardsToday  = Pointage::where('idUser', $idUser)->where('date', $today)->where('status', 'retard')->count();
            $absentsToday  = Pointage::where('idUser', $idUser)->where('date', $today)->where('status', 'absent')->count();
        }

        $isAdmin = $isRealAdmin; // Pass to blade

        return view('pointages.index', compact(
            'todayPointage',
            'recentPointages',
            'settings',
            'isAdmin',
            'departements',
            'uniquePosts',
            'totalToday',
            'presentsToday',
            'retardsToday',
            'absentsToday'
        ));
    }

    public function status()
    {
        $idUser = auth()->id();
        $today  = now()->toDateString();

        $pointage = Pointage::where('idUser', $idUser)
            ->where('date', $today)
            ->first();

        return response()->json([
            'checked_in'  => (bool) $pointage?->heureEntree,
            'checked_out' => (bool) $pointage?->heureSortie,
            'heureEntree' => $pointage?->heureEntree
                ? \Carbon\Carbon::parse($pointage->heureEntree)->format('H:i')
                : null,
            'heureSortie' => $pointage?->heureSortie
                ? \Carbon\Carbon::parse($pointage->heureSortie)->format('H:i')
                : null,
            'status'      => $pointage?->status,
            'idPointage'  => $pointage?->idPointage,
        ]);
    }


    public function checkIn(Request $request)
    {
        Gate::authorize('pointage.create');


        if ($request->has('gps') && !empty($request->gps)) {
            $gps = str_replace(' ', '', $request->gps);
            $parts = explode(',', $gps);
            if (count($parts) === 2 && is_numeric($parts[0]) && is_numeric($parts[1])) {
                $gps = round((float)$parts[0], 8) . ',' . round((float)$parts[1], 8);
            }
            $request->merge(['gps' => $gps]);
        }

        $request->validate([
            'gps' => 'required|string|regex:/^-?\d+(\.\d+)?,-?\d+(\.\d+)?$/'
        ], [
            'gps.regex' => 'Le format GPS doit être: latitude,longitude'
        ]);

        $settings = Company::first();
        $companyGps = $settings->companyGps ?? "32.9348,-6.0234";
        $companyEntryTime = $settings->companyEntryTime ?? "08:00:00";
        $maxDistance = $settings->distance ?? 200;
        $graceMinutes = $settings->maxDelay ?? 15;
        $idUser = auth()->id();
        $today = now()->toDateString();

        $userLoc = $this->parseGps($request->gps);
        $compLoc = $this->parseGps($companyGps);
        $distance = $this->calculateDistance($userLoc[0], $userLoc[1], $compLoc[0], $compLoc[1]);

        if ($distance > $maxDistance) {
            $msg = "Trop loin de l'entreprise. Distance: " . round($distance) . "m.";
            return $request->expectsJson() 
                ? response()->json(['success' => false, 'message' => $msg], 422) 
                : redirect()->route('pointages.index')->with('error', $msg);
        }

        $already = Pointage::where('idUser', $idUser)->where('date', $today)->whereNotNull('heureEntree')->exists();
        if ($already) {
            $msg = "Vous avez déjà pointé votre arrivée aujourd'hui.";
            return $request->expectsJson() 
                ? response()->json(['success' => false, 'message' => $msg], 422) 
                : redirect()->route('pointages.index')->with('error', $msg);
        }

        $currentTime = now();
        $officialTime = Carbon::createFromTimeString($companyEntryTime);
        $graceMinutes = $settings->maxDelay ?? 15;
        $status = $currentTime->gt($officialTime->addMinutes($graceMinutes)) ? 'retard' : 'present';

        Pointage::create([
            'idUser'      => $idUser,
            'date'        => $today,
            'heureEntree' => $currentTime->toTimeString(),
            'status'      => $status,
            'gps'         => $request->gps,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success'     => true,
                'message'     => 'Entrée enregistrée avec succès.',
                'heureEntree' => $currentTime->format('H:i'),
                'status'      => $status,
                'statusLabel' => $status === 'retard' ? 'Retard' : 'Présent',
            ]);
        }
        return redirect()->route('pointages.index')->with('success', 'Entrée enregistrée avec succès.');
    }

    public function checkOut(Request $request) 
    {
        Gate::authorize('pointage.edit');

        if ($request->has('gps') && !empty($request->gps)) {
            $gps = str_replace(' ', '', $request->gps);
            $parts = explode(',', $gps);
            if (count($parts) === 2 && is_numeric($parts[0]) && is_numeric($parts[1])) {
                $gps = round((float)$parts[0], 8) . ',' . round((float)$parts[1], 8);
            }
            $request->merge(['gps' => $gps]);
        }

        $request->validate([
            'gps' => 'required|string|regex:/^-?\d+(\.\d+)?,-?\d+(\.\d+)?$/'
        ]);

        $settings = Company::first();
        $companyGps = $settings->companyGps ?? "32.9348,-6.0234";
        $exitTimeOfficial = $settings->companyExitTime ?? "17:00:00";
        $maxDistance = $settings->distance ?? 200;

        $idUser = auth()->id();
        $today = now()->toDateString();

        $userLoc = $this->parseGps($request->gps);
        $compLoc = $this->parseGps($companyGps);
        $distance = $this->calculateDistance($userLoc[0], $userLoc[1], $compLoc[0], $compLoc[1]);

        if ($distance > $maxDistance) {
            $msg = 'Trop loin pour la sortie. Distance: ' . round($distance) . 'm.';
            return $request->expectsJson() 
                ? response()->json(['success' => false, 'message' => $msg], 422) 
                : redirect()->route('pointages.index')->with('error', $msg);
        }

        $pointage = Pointage::where('idUser', $idUser)->where('date', $today)->whereNull('heureSortie')->first();

        if (!$pointage) {
            $msg = "Aucun pointage d'entrée actif trouvé.";
            return $request->expectsJson() 
                ? response()->json(['success' => false, 'message' => $msg], 422) 
                : redirect()->route('pointages.index')->with('error', $msg);
        }

        $currentTime = now();
        $officialExit = Carbon::createFromTimeString($exitTimeOfficial);
        
        $updateData = [
            'heureSortie' => $currentTime->toTimeString(),
            'gps'         => $request->gps,
        ];
        
        $msg = 'Sortie enregistrée.';
        if ($currentTime->lt($officialExit)) {
            $updateData['status'] = 'retard';
            $msg = 'Sortie enregistrée (Retard : sortie anticipée).';
        }

        $pointage->update($updateData);

        if ($request->expectsJson()) {
            return response()->json([
                'success'     => true,
                'message'     => $msg,
                'heureSortie' => $currentTime->format('H:i'),
                'status'      => $pointage->status,
            ]);
        }
        return redirect()->route('pointages.index')->with('success', $msg);
    }

    private function parseGps($gpsString)
    {
        if (empty($gpsString)) return [0, 0];
        $parts = explode(',', $gpsString);
        return [(float)($parts[0] ?? 0), (float)($parts[1] ?? 0)];
    }

    public function submitJustification(Request $request)
    {
        Gate::authorize('pointage.edit');
        $validatedData = $request->validate([
            'idPointage'    => 'required|exists:pointages,idPointage',
            'justification' => 'required|string|max:500',
            'typejustif'    => 'required|string|max:100',
            'fichier'       => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048', 
        ]);

        $pointage = Pointage::findOrFail($validatedData['idPointage']);

        if ($request->hasFile('fichier')) {        
            $validatedData['fichier'] = $request->file('fichier')->store('Justifpointages', 'public');
        }

        $validatedData['justification_status'] = 'en_attente';

        $pointage->update($validatedData);
        return redirect()->back()->with('msg', 'Justification envoyée.');
    }

    public function validateJustification(Request $request, $id)
    {
        Gate::authorize('view_all_attendance');

        $request->validate([
            'action'      => 'required|in:accepte,refuse',
            'motif_refus' => 'nullable|string|max:500',
        ]);

        $pointage = Pointage::findOrFail($id);
        $pointage->justification_status = $request->action;

        if ($request->action === 'accepte') {
            $pointage->status      = 'present';
            $pointage->motif_refus = null;
        }

        if ($request->action === 'refuse' && $request->filled('motif_refus')) {
            $pointage->motif_refus = $request->motif_refus;
        }

        $pointage->save();

        $label = $request->action === 'accepte' ? 'acceptée' : 'refusée';
        return redirect()->back()->with('msg', "Justification {$label}.");
    }
    public function updateSettings(Request $request)
    {
        Gate::authorize('pointage.create');

        if ($request->has('companyGps') && !empty($request->companyGps)) {
            $gps = str_replace(' ', '', $request->companyGps);
            $parts = explode(',', $gps);
            if (count($parts) === 2 && is_numeric($parts[0]) && is_numeric($parts[1])) {
                $gps = round((float)$parts[0], 8) . ',' . round((float)$parts[1], 8);
            }
            $request->merge(['companyGps' => $gps]);
        }

        $validatedData = $request->validate([
            'companyGps'       => 'nullable|string',
            'companyEntryTime' => 'nullable',
            'companyExitTime'  => 'nullable',
            'distance'         => 'nullable|integer',
            'maxDelay'         => 'nullable|integer|min:0',
            'absenceTime'      => 'nullable',
        ], [
            'companyGps.regex' => 'Le format GPS doit être: latitude,longitude'
        ]);

        $updateData = array_filter($validatedData, fn($val) => !is_null($val));

        Company::updateOrCreate(['id' => 1], $updateData);
        return redirect()->back()->with('msg', 'Paramètres mis à jour.');
    }
    public function exportPdf(Request $request)
    {
        Gate::authorize('view_all_attendance');

        $query = $this->buildPointageQuery($request);

        $pointages = $query->orderBy('date', 'desc')
            ->orderBy('heureEntree', 'desc')
            ->get();

        $stats = [
            'total' => $pointages->count(),
            'presents' => $pointages->where('status', 'present')->count(),
            'retards' => $pointages->where('status', 'retard')->count(),
            'absents' => $pointages->where('status', 'absent')->count(),
        ];

        $company = Company::first();
        
        $data = [
            'pointages' => $pointages,
            'stats' => $stats,
            'company' => $company,
            'filters' => [
                'period' => $request->get('period', 'Toutes les dates'),
                'start' => $request->get('start_date') ? Carbon::parse($request->get('start_date'))->format('d/m/Y') : null,
                'end' => $request->get('end_date') ? Carbon::parse($request->get('end_date'))->format('d/m/Y') : null,
                'role' => $request->get('role', 'Tous'),
                'status' => $request->get('status', 'Tous'),
                'justified' => $request->has('has_justification') && $request->get('has_justification') !== '' ? ($request->get('has_justification') === 'yes' || $request->get('has_justification') === '1' ? 'Oui' : 'Non') : 'Tous',
            ],
            'logo' => public_path('images/logo.png'),
            'date' => now()->format('d/m/Y H:i')
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pointages.pdf', $data)
            ->setPaper('a4', 'landscape')
            ->setOptions(['isRemoteEnabled' => true]);
        
        $filename = 'Rapport_Pointage_' . now()->format('Ymd_His') . '.pdf';
        return $pdf->download($filename);
    }
}