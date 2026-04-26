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

   
    public function index()
    {
        Gate::authorize('pointage.view');

        $pointages = Pointage::with('user')->orderBy('date', 'desc')->orderBy('heureEntree', 'desc')->get();
        $settings = Company::first();
        return view('Adminpointage', compact('pointages', 'settings'));
    }

    public function userPointage()
    {           Gate::authorize('pointage.view');

        $idUser = auth()->id();
        $today  = now()->toDateString();

        $todayPointage = Pointage::where('idUser', $idUser)
            ->where('date', $today)
            ->first();

        $query = Pointage::query();
        if (auth()->user()->type === 'employee') {
            $query->where('idUser', $idUser);
        }
        
        $recentPointages = $query->with('user')
            ->orderBy('date', 'desc')
            ->orderBy('heureEntree', 'desc')
            ->take(15)
            ->get();

        $settings = Company::first();
        return view('pointages.index', compact('todayPointage', 'recentPointages', 'settings'));
    }

    /**
     * JSON endpoint — returns today's check-in/out state for AJAX.
     */
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

        $idUser = auth()->id();
        $today = now()->toDateString();

        
        $userLoc = $this->parseGps($request->gps);
        $compLoc = $this->parseGps($companyGps);
        $distance = $this->calculateDistance($userLoc[0], $userLoc[1], $compLoc[0], $compLoc[1]);

        if ($distance > $maxDistance) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => "Trop loin de l'entreprise. Distance: " . round($distance) . "m."], 422);
            }
            return redirect()->route('pointages.index')->with('error', "Trop loin de l'entreprise.");
        }

        
        $already = Pointage::where('idUser', $idUser)->where('date', $today)->whereNotNull('heureEntree')->exists();
        if ($already) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => "Vous avez déjà pointé votre arrivée aujourd'hui."], 422);
            }
            return redirect()->route('pointages.index')->with('error', 'Déjà pointé aujourd\'hui.');
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

        $heureFormatted = $currentTime->format('H:i');
        $statusLabel = $status === 'retard' ? 'Retard' : 'Présent';

        if ($request->expectsJson()) {
            return response()->json([
                'success'     => true,
                'message'     => 'Entrée enregistrée avec succès.',
                'heureEntree' => $heureFormatted,
                'status'      => $status,
                'statusLabel' => $statusLabel,
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
        ], [
            'gps.regex' => 'Le format GPS doit être: latitude,longitude'
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
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Trop loin pour la sortie. Distance: ' . round($distance) . 'm.'], 422);
            }
            return redirect()->route('pointages.index')->with('error', "Trop loin pour la sortie.");
        }

        $pointage = Pointage::where('idUser', $idUser)->where('date', $today)->whereNull('heureSortie')->first();

        if (!$pointage) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => "Aucun pointage d'entrée actif trouvé pour aujourd'hui."], 422);
            }
            return redirect()->route('pointages.index')->with('error', 'Aucun pointage actif trouvé.');
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

        $heureFormatted = $currentTime->format('H:i');

        if ($request->expectsJson()) {
            return response()->json([
                'success'     => true,
                'message'     => $msg,
                'heureSortie' => $heureFormatted,
                'status'      => $pointage->status,
            ]);
        }
        return redirect()->route('pointages.index')->with('success', $msg);
    }


    private function parseGps($gpsString)
    {
        if (empty($gpsString)) return [0, 0];
        $parts = explode(',', $gpsString);
        return [
            (float)($parts[0] ?? 0),
            (float)($parts[1] ?? 0)
        ];
    }

    
    
    
    public function submitJustification(Request $request)
    {    Gate::authorize('pointage.edit');
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
        Gate::authorize('role:admin'); // Only admins can validate

        $request->validate([
            'action' => 'required|in:accepte,refuse',
        ]);

        $pointage = Pointage::findOrFail($id);
        $pointage->justification_status = $request->action;

        if ($request->action === 'accepte') {
            $pointage->status = 'present'; // Clear the infraction if accepted
        }

        $pointage->save();

        return redirect()->back()->with('msg', 'Justification ' . ($request->action === 'accepte' ? 'acceptée' : 'refusée') . '.');
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
            'companyGps'       => 'nullable|string|regex:/^-?\d+(\.\d+)?,-?\d+(\.\d+)?$/',
            'companyEntryTime' => 'nullable',
            'companyExitTime'  => 'nullable',
            'distance'         => 'nullable|integer',
            'maxDelay'         => 'nullable|integer|min:0',
            'absenceTime'      => 'nullable',
        ], [
            'companyGps.regex' => 'Le format GPS doit être: latitude,longitude (ex: 32.93,-6.02)'
        ]);

        $updateData = array_filter($validatedData, function($val) {
            return !is_null($val);
        });

        Company::updateOrCreate(['id' => 1], $updateData);
        return redirect()->back()->with('msg', 'Paramètres mis à jour.');
    }
}