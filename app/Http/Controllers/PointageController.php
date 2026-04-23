<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pointage;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PointageController extends Controller
{
    
    public function index()
    {
        $today = now()->toDateString();
        $pointages = Pointage::with('user')->get();

        return view('Adminpointage', compact('pointages'));
    }

   
    public function userPointage()
    {
        $idUser = auth()->id();
        $infractions = Pointage::where('idUser', $idUser)
            ->whereIn('status', ['retard', 'absent'])
            ->orderBy('date', 'desc')
            ->get();

        return view('user_infractions', compact('infractions'));
    }
    
    public function checkIn(Request $request)
    {
        $validatedData = $request->validate([
            'gps' => 'required|string',
        ]);

        $idUser = auth()->id();
        $companyGps = "32.9348,-6.0234"; 
        $companyEntryTime = "08:00:00";  
        $maxDistance = 200;              

        $userLoc = explode(',', $validatedData['gps']);
        $compLoc = explode(',', $companyGps);
        
        $distance = $this->calculateDistance($userLoc[0], $userLoc[1], $compLoc[0], $compLoc[1]);

        if ($distance > $maxDistance) {
            return redirect()->back()->with('error', "Trop loin de l'entreprise.");
        }

        $today = now()->toDateString();
        $currentTime = now();
        $officialTime = Carbon::createFromTimeString($companyEntryTime);

        
        $alreadyPointed = Pointage::where('idUser', $idUser)
            ->where('date', $today)
            ->whereNotNull('heureEntree') 
            ->exists();

        if ($alreadyPointed) {
            return redirect()->back()->with('error', 'Déjà pointé aujourd\'hui.');
        }

        $status = 'present';
        if ($currentTime->gt($officialTime->addMinutes(15))) {
            $status = 'retard';
        }

        Pointage::create([
            'idUser'      => $idUser,
            'date'        => $today,
            'heureEntree' => $currentTime->toTimeString(),
            'status'      => $status,
            'gps'         => $validatedData['gps'],
        ]);

        return redirect()->back()->with('msg', 'Entrée enregistrée.');
    }

    public function checkOut(Request $request) 
    {
        $request->validate(['gps' => 'required|string']);

        $idUser = auth()->id();
        $today = now()->toDateString();
        $companyGps = "32.9348,-6.0234"; 

        $userLoc = explode(',', $request->gps);
        $compLoc = explode(',', $companyGps);
        
        $distance = $this->calculateDistance($userLoc[0], $userLoc[1], $compLoc[0], $compLoc[1]);

        if ($distance > 200) {
            return redirect()->back()->with('error', "Trop loin pour la sortie.");
        }

       
        $pointage = Pointage::where('idUser', $idUser)
            ->where('date', $today)
            ->whereNull('heureSortie') 
            ->first();

        if (!$pointage) {
            return redirect()->back()->with('error', 'Aucun pointage actif trouvé.');
        }

        $pointage->update(['heureSortie' => now()->toTimeString()]);

        return redirect()->back()->with('msg', 'Sortie enregistrée.');
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        return $earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    public function submitJustification(Request $request)
    {
        $validatedData = $request->validate([
            'idPointage'    => 'required|exists:pointages,idPointage',
            'justification' => 'required|string|max:500',
            'typejustif'    => 'required|string|max:100',
            'fichier'       => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048', 
        ]);

        if ($request->hasFile('fichier')) {        
            $validatedData['fichier'] = $request->file('fichier')->store('pointages', 'public');
        }

        $pointage->update($validatedData);

        return redirect()->back()->with('msg', 'Justification envoyée.');
    }
}