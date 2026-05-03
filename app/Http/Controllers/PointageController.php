<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pointage;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Departement;
use Illuminate\Support\Facades\Artisan;

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

    private function getMergedPointageList(Request $request, string $sort = 'desc')
    {
        $period = $request->input('period');
        $start = null;
        $end = null;

        // Date Period Filtering
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

        // Base Query starting from Pointage (Strictly real records only)
        $query = Pointage::with(['user', 'user.departement']);

        // 1. Date Filtering
        if ($start && $end) {
            $query->whereBetween('date', [$start->toDateString(), $end->toDateString()]);
        } elseif ($start) {
            $query->where('date', '>=', $start->toDateString());
        } elseif ($end) {
            $query->where('date', '<=', $end->toDateString());
        }

        // 2. User Relationship Filters (Search, Role, Department)
        if ($request->filled('search') || $request->filled('role') || $request->filled('departement') || $request->filled('user_id')) {
            $query->whereHas('user', function ($q) use ($request) {
                if ($search = $request->input('search')) {
                    $q->where(function($sq) use ($search) {
                        $sq->where('firstName', 'like', "%{$search}%")
                           ->orWhere('lastName', 'like', "%{$search}%");
                    });
                }
                if ($role = $request->input('role')) {
                    $q->where('type', $role);
                }
                if ($dept = $request->input('departement')) {
                    $q->whereHas('departement', fn($sq) => $sq->where('title', 'like', "%{$dept}%"));
                }
                if ($idUser = $request->input('user_id')) {
                    $q->where('idUser', $idUser);
                }
            });
        }

        // 3. Status Filter (Applied directly to Pointage)
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // 4. Justification Filter (Applied directly to Pointage)
        if ($request->filled('has_justification')) {
            $justifFilter = $request->input('has_justification');
            $wantsJustif = in_array($justifFilter, ['1', 'yes']);
            if ($wantsJustif) {
                $query->whereNotNull('justification')->where('justification', '!=', '');
            } else {
                $query->where(function($q) {
                    $q->whereNull('justification')->orWhere('justification', '');
                });
            }
        }

        // 5. Ordering (Chronological order)
        return $query->orderBy('date', $sort)
                     ->orderBy('heureEntree', $sort)
                     ->get();
    }

    public function destroyAll()
    {
        Gate::authorize('pointage.view');
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        try {
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Pointage::truncate();
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            return redirect()->back()->with('success', 'Historique de pointage vidé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    public function index(Request $request)
    {
        Gate::authorize('pointage.view');

        $merged = $this->getMergedPointageList($request);

        $perPage = 10;
        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $pointages = new \Illuminate\Pagination\LengthAwarePaginator(
            $merged->forPage($page, $perPage),
            $merged->count(),
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(), 'query' => $request->query()]
        );
            
        $stats = [
            'total' => $merged->count(),
            'presents' => $merged->where('status', 'present')->count(),
            'retards' => $merged->where('status', 'retard')->count(),
            'absents' => $merged->where('status', 'absent')->count(),
            'withJustif' => $merged->where('justification', '!=', null)->count(),
        ];
            
        $settings = Company::first();
        $users = User::orderBy('firstName')->get();
        $departements = Departement::orderBy('title')->get();
        $roles = User::distinct()->pluck('type');

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
        $departements = Departement::orderBy('title')->get();
        $uniquePosts  = User::whereNotNull('post')->distinct()->pluck('post');

        $isRealAdmin = ($user->type === 'admin');

        // ── AUTO-MARK ABSENCES (Lazy Cron) ──────────────────────────────
        if ($settings && $settings->absenceTime) {
            $now = now()->format('H:i');
            $deadline = Carbon::parse($settings->absenceTime)->format('H:i');
            
            if ($now >= $deadline) {
                Artisan::call('pointage:mark-absents');
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
                ? Carbon::parse($pointage->heureEntree)->format('H:i')
                : null,
            'heureSortie' => $pointage?->heureSortie
                ? Carbon::parse($pointage->heureSortie)->format('H:i')
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

        // 1. Check for any existing record for today (including automated absences)
        $pointage = Pointage::where('idUser', $idUser)->where('date', $today)->first();

        // 2. If already checked in (has heureEntree), prevent duplicate
        if ($pointage && $pointage->heureEntree) {
            $msg = "Vous avez déjà pointé votre arrivée aujourd'hui.";
            return $request->expectsJson() 
                ? response()->json(['success' => false, 'message' => $msg], 422) 
                : redirect()->route('pointages.index')->with('error', $msg);
        }

        $currentTime = now();
        $officialTime = Carbon::createFromTimeString($companyEntryTime);
        $graceMinutes = $settings->maxDelay ?? 15;
        $status = $currentTime->gt($officialTime->addMinutes($graceMinutes)) ? 'retard' : 'present';

        $pointageData = [
            'idUser'      => $idUser,
            'date'        => $today,
            'heureEntree' => $currentTime->toTimeString(),
            'status'      => $status,
            'gps'         => $request->gps,
        ];

        // 3. Update existing record (e.g. 'absent' placeholder) or create new one
        if ($pointage) {
            $pointage->update($pointageData);
        } else {
            Pointage::create($pointageData);
        }

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

        $pointages = $this->getMergedPointageList($request, 'asc');

        $stats = [
            'total' => $pointages->count(),
            'presents' => $pointages->where('status', 'present')->count(),
            'retards' => $pointages->where('status', 'retard')->count(),
            'absents' => $pointages->where('status', 'absent')->count(),
        ];

        $company = Company::first();
        
        $minDate = $pointages->min('date');
        $maxDate = $pointages->max('date');

        $periodTrans = [
            'today' => "Aujourd'hui",
            'yesterday' => 'Hier',
            'week' => 'Cette semaine',
            'last_week' => 'Semaine dernière',
            'last_7_days' => '7 derniers jours',
            'last_30_days' => '30 derniers jours',
            'month' => 'Ce mois-ci',
            'last_month' => 'Mois dernier',
            'custom' => 'Personnalisé'
        ];
        $periodValue = strtolower($request->input('period', ''));
        
        // Reverse mapping to handle case where label might be passed instead of value
        $reverseTrans = array_flip($periodTrans);
        $normalizedPeriod = $reverseTrans[$request->input('period')] ?? $periodValue;

        if (!$normalizedPeriod && ($request->filled('start_date') || $request->filled('end_date'))) {
            $displayPeriod = 'Personnalisé';
        } else {
            $displayPeriod = $periodTrans[$normalizedPeriod] ?? ($request->filled('period') ? $request->input('period') : 'Toutes les dates');
        }

        $data = [
            'pointages' => $pointages,
            'stats' => $stats,
            'company' => $company,
            'filters' => [
                'period' => $displayPeriod,
                'start' => $request->input('start_date') 
                    ? Carbon::parse($request->input('start_date'))->format('d/m/Y') 
                    : ($minDate ? Carbon::parse($minDate)->format('d/m/Y') : null),
                'end' => $request->input('end_date') 
                    ? Carbon::parse($request->input('end_date'))->format('d/m/Y') 
                    : ($maxDate ? Carbon::parse($maxDate)->format('d/m/Y') : null),
                'role' => $request->filled('role') ? $request->input('role') : 'Tous',
                'status' => $request->filled('status') ? $request->input('status') : 'Tous',
                'employee' => $request->filled('user_id') ? (User::find($request->user_id)?->firstName . ' ' . User::find($request->user_id)?->lastName) : 'Tous',
                'justified' => $request->has('has_justification') && $request->input('has_justification') !== '' ? ($request->input('has_justification') === 'yes' || $request->input('has_justification') === '1' ? 'Oui' : 'Non') : 'Tous',
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

    /**
     * Clear all pointage history (admin only).
     */
    public function clearHistory(Request $request)
    {
        Gate::authorize('pointage.delete');

        Pointage::query()->delete();

        return redirect()->route('admin.pointages.index')
            ->with('msg', 'Tout l\'historique de pointage a été supprimé.');
    }
}