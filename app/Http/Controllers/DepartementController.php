<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departement;
use App\Models\User;
use App\Models\Pointage;
use Carbon\Carbon;
class DepartementController extends Controller
{
    private function getJoursOuvrables()
    {
        $debut = Carbon::now()->startOfMonth();
        $fin   = Carbon::now()->endOfMonth();
        $jours = 0;

        while ($debut<=$fin) {
            if ($debut->isWeekday()) {
                $jours++;
            }
            $debut->addDay();
        }

        return $jours;
    }
    public function index(){

        $state=[];
        $joursOuvrables = $this->getJoursOuvrables();
        $depts =  Departement::with('manager')->get();
        foreach($depts as $dept){
             $employes= User::where('idDepartement', $dept->idDepartement)->get();
             $employeIds = $employes->map(function($emp){return $emp->idUser;})->toArray();

            if (empty($employeIds) || $joursOuvrables === 0) {
                $dept->presencePourcentage = 0;
            } else {
                $totalPourcentages = 0;

            foreach ($employes as $employe) {
                $presences = Pointage::where('idUser', $employe->idUser)
                    ->where('status', 'present')
                    ->whereMonth('date', now()->month)
                    ->whereYear('date', now()->year)
                    ->count();
                     $totalPourcentages += round(($presences / $joursOuvrables) * 100);
            }
                $dept->presencePourcentage = round($totalPourcentages / count($employeIds));
            }
        }
       $state =[
            'totalDepartements' => $depts->count(),
            'totalEmployes'     => User::whereNotNull('idDepartement')->count(),
            'presenceMoyenne'   => round($depts->avg('presencePourcentage')),
       ];
        return view('departements.index' , ['departements'=>$depts, 'state'=> $state] );

    }

public function store(Request $request) {
    

    $newDepartement = $request->validate([
        'title'     => 'required|string|max:55',
        'description'    => 'nullable|string|max:255',
        'idUser'  =>  'nullable|exists:users,idUser'
       
    ]);
    $departement = Departement::create($newDepartement);
    return redirect()->back()->with('msg' , "Le département a été ajouté avec succès");

}
public function show($id){
    $departement = Departement::with('manager')->findOrFail($id);
    return view('showDepartement' , compact('departement'));
}
public function destroy($id)
{   $departement = Departement::findOrFail($id);
    $departement->delete();
    return redirect()->back()->with('msg', 'Le département a été supprimée');
}

public function edit($id){
    $departement = Departement::with('manager')->findOrFail($id);
    return view('editDepartement' , compact('departement'));
}

public function update(Request $request ,$id){
    
    $departementUpdate = $request->validate([
        'title'     => 'required|string|max:55',
        'description'    => 'nullable|string|max:255',
        'idUser'  =>  'nullable|exists:users,idUser'
    ]);
    $departement = Departement::findOrFail($id);
   $departement->update($departementUpdate);
    return redirect()->back()->with('msg' , 'Le département été mises à jour avec succès');
}
}
