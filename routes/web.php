<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\TacheController;

use App\Models\Reclamation;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Entry Point & Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return app(AuthenticatedSessionController::class)->create(request());
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



#user Routes
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::get('/users/edit/{id}', [UserController::class, 'edit']);
Route::put('/users/edit/{id}', [UserController::class, 'update']);

#Client Routes
Route::get('/clients', [ClientController::class, 'index']);
Route::post('/clients', [ClientController::class, 'store']);
Route::get('/clients/{id}', [ClientController::class, 'show']);
Route::get('/clients/edit/{id}', [ClientController::class, 'edit']);
Route::put('/clients/edit/{id}', [ClientController::class, 'update']);

#Category Routes
Route::get('/category', [CategoryController::class, 'index']);
Route::post('/category', [CategoryController::class, 'store']);
// Route::get('/category/{id}' , [CategoryController::class , 'show' ]); 
Route::get('/category/edit/{id}' , [CategoryController::class , 'edit' ]);
Route::put('/category/edit/{id}' , [CategoryController::class , 'update' ]);
Route::delete('/category/delete/{id}' , [CategoryController::class , 'destroy' ]);

#Reclamation Routes
Route::get('/reclamations' , [ReclamationController::class , 'index' ]);
Route::post('/reclamations', [ReclamationController::class, 'store']);
Route::get('/reclamation/{id}' , [ReclamationController::class , 'show' ]); 
// Route::get('/category/edit/{id}' , [ReclamationController::class , 'edit' ]);
// Route::put('/category/edit/{id}' , [ReclamationController::class , 'update' ]);

Route::delete('/reclamation/delete/{id}' , [ReclamationController::class , 'destroy' ]);
#Departement Routes
Route::get('/departements', [DepartementController::class, 'index']);
Route::post('/departements', [DepartementController::class, 'store']);
Route::get('/departements/{id}', [DepartementController::class, 'show']);
Route::get('/departements/edit/{id}', [DepartementController::class, 'edit']);
Route::put('/departements/edit/{id}', [DepartementController::class, 'update']);
Route::delete('/departements/delete/{id}', [DepartementController::class, 'destroy']);
// demandeDocument Routes 
Route::get('/demandeDocuments', [DemandeController::class, 'index']);
Route::post('/demandeDocuments', [DemandeController::class, 'store']);
Route::get('/demandeDocuments/{id}', [DemandeController::class, 'show']);
Route::get('/demandeDocuments/edit/{id}', [DemandeController::class, 'edit']);
Route::put('/demandeDocuments/edit/{id}', [DemandeController::class, 'update']);
Route::delete('/demandeDocuments/delete/{id}', [DemandeController::class, 'destroy']);

// Objectif Routes
Route::get('/objectifs', [DemandeController::class, 'index']);
Route::post('/objectifs', [DemandeController::class, 'store']);
Route::get('/objectifs/{id}', [DemandeController::class, 'show']);
Route::get('/objectifs/edit/{id}', [DemandeController::class, 'edit']);
Route::put('/objectifs/edit/{id}', [DemandeController::class, 'update']);
Route::delete('/objectifs/delete/{id}', [DemandeController::class, 'destroy']);






/*
|--------------------------------------------------------------------------
| Départements Routes
|--------------------------------------------------------------------------
*/
// Route::middleware('auth')->group(function () {
//     Route::get('/departements', function () {
//         $departements = collect([
//             (object) ['idDepartement' => 1, 'title' => 'Technologie & IT', 'manager_name' => 'Youssef Amrani', 'presence' => 99, 'tasks' => 78, 'count' => 14],
//             (object) ['idDepartement' => 2, 'title' => 'Marketing Digital', 'manager_name' => 'Sara Bennis', 'presence' => 69, 'tasks' => 65, 'count' => 8],
//             (object) ['idDepartement' => 3, 'title' => 'Ressources Humaines', 'manager_name' => null, 'presence' => 30, 'tasks' => 90, 'count' => 5],
//         ]);

//         $users = \App\Models\User::orderBy('firstName')->get();
//         return view('departements.index', compact('departements', 'users'));
//     })->name('departements.index');

    Route::post('/departements', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'nullable|string',
            'idUser' => 'nullable',
        ]);
        \App\Models\Departement::create($validated);
        return redirect()->route('departements.index')->with('success', 'Département créé avec succès !');
    })->name('departements.store');

Route::delete('/reclamation/delete/{id}', function ($id) {
    $reclamation = Reclamation::findOrFail($id);
    $reclamation->delete();
    return redirect('/reclamations')->with('msg', 'La réclamation a été supprimée avec succès.');

});

Route::patch('/reclamation/reponse/{id}', function (Illuminate\Http\Request $request, $id) {
    $request->validate([
        'reponse' => 'required|string|max:1000',
    ]);

    $reclamation = Reclamation::findOrFail($id);
    $reclamation->update([
        'reponse' => $request->reponse,
        'status' => 'resolue',
    ]);

    return redirect()->back()->with('msg', 'Votre réponse a été envoyée et la réclamation est marquée comme résolue.');
});
#Departement Routes
Route::get('/departements', [DepartementController::class, 'index'])->name('departements.index');
Route::post('/departements', [DepartementController::class, 'store'])->name('departements.store');
Route::get('/departements/{id}', [DepartementController::class, 'show'])->name('departements.show');
Route::get('/departements/edit/{id}', [DepartementController::class, 'edit'])->name('departements.edit');
Route::put('/departements/edit/{id}', [DepartementController::class, 'update'])->name('departements.update');
Route::delete('/departements/delete/{id}', [DepartementController::class, 'destroy'])->name('departements.destroy');



# Pointage Route
Route::get('/pointage', function () {
    $pointages = collect([
        ['id' => 1, 'employe' => 'Karim Benali', 'checkin' => '08:00', 'checkout' => '17:00', 'status' => 'Présent'],
        ['id' => 2, 'employe' => 'Sara Alaoui', 'checkin' => '08:15', 'checkout' => '17:05', 'status' => 'En retard'],
        ['id' => 3, 'employe' => 'Youssef Nouri', 'checkin' => '--:--', 'checkout' => '--:--', 'status' => 'Absent'],
        ['id' => 4, 'employe' => 'Hassan IDRISSI', 'checkin' => '07:55', 'checkout' => '16:50', 'status' => 'Présent']
    ]);
    return view('pointages.index', compact('pointages'));
})->middleware(['auth', 'verified'])->name('pointages.index');

# Tasks Route
Route::get('/tasks', [TacheController::class, 'index'])->middleware(['auth', 'verified'])->name('tasks.index');
Route::post('/tasks', [TacheController::class, 'store'])->middleware(['auth', 'verified'])->name('tasks.store');
Route::delete('/tasks/{id}', [TacheController::class, 'destroy'])->middleware(['auth', 'verified'])->name('tasks.destroy');
Route::post('/tasks/assign', [TacheController::class, 'assignUser'])->middleware(['auth', 'verified'])->name('tasks.assign');
Route::post('/tasks/unassign', [TacheController::class, 'unassignUser'])->middleware(['auth', 'verified'])->name('tasks.unassign');
Route::put('/tasks/{id}', [TacheController::class, 'update'])->middleware(['auth', 'verified'])->name('tasks.update');
Route::patch('/tasks/{id}/status', function (Illuminate\Http\Request $request, $id) {
    $tache = App\Models\Tache::findOrFail($id);
    $tache->update(['status' => $request->status]);
    return redirect()->back();
})->middleware(['auth', 'verified'])->name('tasks.updateStatus');

# Meetings Route
Route::get('/meetings', function () {
    $meetings = collect([
        ['id' => 1, 'title' => 'Sync Hebdomadaire', 'date' => '2026-04-21 10:00', 'type' => 'Interne'],
        ['id' => 2, 'title' => 'Présentation Client', 'date' => '2026-04-22 14:30', 'type' => 'Externe'],
        ['id' => 3, 'title' => 'Revue Stratégique', 'date' => '2026-04-24 09:00', 'type' => 'Direction'],
    ]);
    return view('reunions.index', compact('meetings'));
})->middleware(['auth', 'verified'])->name('meetings.index');

# Goals Route
Route::get('/goals', function () {
    $goals = collect([
        ['id' => 1, 'title' => 'Augmenter le CA de 20%', 'progress' => 65, 'status' => 'En cours'],
        ['id' => 2, 'title' => 'Lancer la nouvelle app', 'progress' => 90, 'status' => 'Presque terminé'],
        ['id' => 3, 'title' => 'Réduire le taux de churn', 'progress' => 30, 'status' => 'En retard'],
    ]);
    return view('objectifs.index', compact('goals'));
})->middleware(['auth', 'verified'])->name('goals.index');

# Leaves Route
Route::get('/leaves', function () {
    $leaves = collect([
        ['id' => 1, 'employe' => 'Mounia Zaid', 'start' => '2026-05-01', 'end' => '2026-05-15', 'type' => 'Annuel', 'status' => 'Approuvé'],
        ['id' => 2, 'employe' => 'Tariq Naji', 'start' => '2026-04-22', 'end' => '2026-04-24', 'type' => 'Maladie', 'status' => 'En attente'],
        ['id' => 3, 'employe' => 'Salma Radi', 'start' => '2026-06-10', 'end' => '2026-06-12', 'type' => 'Exceptionnel', 'status' => 'Refusé'],
    ]);
    return view('conges.index', compact('leaves'));
})->middleware(['auth', 'verified'])->name('leaves.index');

require __DIR__.'/auth.php';