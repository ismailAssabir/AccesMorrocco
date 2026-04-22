<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\CongeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ObjectifController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\ReunionController;

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
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/edit/{id}', [UserController::class, 'update'])->name('users.update');

#Client Routes
Route::get('/clients', [ClientController::class, 'index']);
Route::post('/clients', [ClientController::class, 'store']);
Route::get('/clients/{id}', [ClientController::class, 'show']);
Route::get('/clients/edit/{id}', [ClientController::class, 'edit']);
Route::put('/clients/edit/{id}', [ClientController::class, 'update']);

#Category Routes
Route::get('/category', [CategoryController::class, 'index']);
Route::post('/category', [CategoryController::class, 'store']);
Route::get('/category/{id}' , [CategoryController::class , 'show' ]); 
Route::get('/category/edit/{id}' , [CategoryController::class , 'edit' ]);
Route::put('/category/edit/{id}' , [CategoryController::class , 'update' ]);
Route::delete('/category/delete/{id}' , [CategoryController::class , 'destroy' ]);

#Reclamation Routes
Route::get('/reclamations' , [ReclamationController::class , 'index' ]);
Route::post('/reclamations', [ReclamationController::class, 'store']);
Route::get('/reclamation/{id}' , [ReclamationController::class , 'show' ]); 
// Route::get('/category/edit/{id}' , [ReclamationController::class , 'edit' ]);
// Route::put('/category/edit/{id}' , [ReclamationController::class , 'update' ]);
Route::delete('/reclamation/delete/{id}', function ($id) {
    $reclamation = Reclamation::findOrFail($id);
    $reclamation->delete();
    return redirect('/reclamations')->with('msg', 'La réclamation a été supprimée avec succès.');
});

#Conge Routes
Route::get('/conge', [CongeController::class, 'index'])->name('conge.index');
Route::post('/conge', [CongeController::class, 'store'])->name('conge.store');
Route::get('/conge/{id}', [CongeController::class, 'show'])->name('conge.show');
Route::put('/conge/update/{id}', [CongeController::class, 'update'])->name('conge.update');
Route::delete('/conge/delete/{id}', [CongeController::class, 'destroy'])->name('conge.destroy');

#Departement Routes
Route::get('/departements', [DepartementController::class, 'index'])->name('departements.index');
Route::post('/departements', [DepartementController::class, 'store'])->name('departements.store');
Route::get('/departements/{id}', [DepartementController::class, 'show'])->name('departements.show');
Route::get('/departements/edit/{id}', [DepartementController::class, 'edit'])->name('departements.edit');
Route::put('/departements/edit/{id}', [DepartementController::class, 'update'])->name('departements.update');
Route::delete('/departements/delete/{id}', [DepartementController::class, 'destroy'])->name('departements.destroy');

#Demande Routes
Route::get('/demandeDocuments', [DemandeController::class, 'index']);
Route::post('/demandeDocuments', [DemandeController::class, 'store']);
Route::get('/demandeDocuments/{id}', [DemandeController::class, 'show']);
Route::get('/demandeDocuments/edit/{id}', [DemandeController::class, 'edit']);
Route::put('/demandeDocuments/edit/{id}', [DemandeController::class, 'update']);
Route::delete('/demandeDocuments/delete/{id}', [DemandeController::class, 'destroy']);

#Objectif Routes
Route::get('/objectifs', [ObjectifController::class, 'index'])->name('goals.index');
Route::get('/objectifs/create', [ObjectifController::class, 'create'])->name('goals.create');
Route::post('/objectifs', [ObjectifController::class, 'store'])->name('goals.store');
Route::get('/objectifs/{id}', [ObjectifController::class, 'show'])->name('goals.show');
Route::get('/objectifs/edit/{id}', [ObjectifController::class, 'edit'])->name('goals.edit');
Route::put('/objectifs/edit/{id}', [ObjectifController::class, 'update'])->name('goals.update');
Route::delete('/objectifs/delete/{id}', [ObjectifController::class, 'destroy'])->name('goals.destroy');

#Permission Routes
Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
Route::put('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');

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
Route::get('/meetings', [ReunionController::class, 'index'])->middleware(['auth', 'verified'])->name('meetings.index');

# Reunion Routes (mapping to the same controller but using /reunions prefix as per views)
Route::get('/reunions', [ReunionController::class, 'index'])->middleware(['auth', 'verified'])->name('reunions.index');
Route::get('/reunions/create', [ReunionController::class, 'create'])->middleware(['auth', 'verified'])->name('reunions.create');
Route::post('/reunions', [ReunionController::class, 'store'])->middleware(['auth', 'verified'])->name('reunions.store');
Route::get('/reunions/edit/{id}', [ReunionController::class, 'edit'])->middleware(['auth', 'verified'])->name('reunions.edit');
Route::put('/reunions/edit/{id}', [ReunionController::class, 'update'])->middleware(['auth', 'verified'])->name('reunions.update');
Route::delete('/reunions/delete/{id}', [ReunionController::class, 'destroy'])->middleware(['auth', 'verified'])->name('reunions.destroy');

# Goals Route
Route::get('/goals', [ObjectifController::class, 'index'])->middleware(['auth', 'verified'])->name('goals.index');



require __DIR__.'/auth.php';