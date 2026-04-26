<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\ReunionController;
use App\Http\Controllers\CongeController;
use App\Http\Controllers\PointageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ObjectifController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\PaimentController;
use App\Http\Controllers\LeadController;
use App\Models\Reclamation;
use App\Http\Controllers\DashboardController;
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

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

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

/*
|--------------------------------------------------------------------------
| ADMIN ONLY ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    #user Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/edit/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    #Client Routes
    Route::get('/clients',[ClientController::class, 'index'])->name('clients.index');
Route::post('/clients',[ClientController::class, 'store'])->name('clients.store');
Route::get('/clients/{id}',[ClientController::class, 'show'])->name('clients.show');
Route::get('/clients/{id}/edit',[ClientController::class, 'edit'])->name('clients.edit');
Route::put('/clients/{id}',[ClientController::class, 'update'])->name('clients.update');

    #Category Routes
    Route::get('/category', [CategoryController::class, 'index']);
    Route::post('/category', [CategoryController::class, 'store']);
    Route::get('/category/{id}' , [CategoryController::class , 'show' ]); 
    Route::get('/category/edit/{id}' , [CategoryController::class , 'edit' ]);
    Route::put('/category/edit/{id}' , [CategoryController::class , 'update' ]);
    Route::delete('/category/delete/{id}' , [CategoryController::class , 'destroy' ]);

    #Permission Routes
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');
});

/*
|--------------------------------------------------------------------------
| ADMIN & MANAGER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:admin|manager'])->group(function () {

    #Departement Routes
    Route::get('/departements', [DepartementController::class, 'index'])->name('departements.index');
    Route::post('/departements', [DepartementController::class, 'store'])->name('departements.store');
    Route::get('/departements/{id}', [DepartementController::class, 'show'])->name('departements.show');
    Route::get('/departements/{id}/export-pdf', [DepartementController::class, 'exportPdf'])->name('departements.export-pdf');
    Route::get('/departements/edit/{id}', [DepartementController::class, 'edit'])->name('departements.edit');
    Route::put('/departements/edit/{id}', [DepartementController::class, 'update'])->name('departements.update');
    Route::delete('/departements/delete/{id}', [DepartementController::class, 'destroy'])->name('departements.destroy');

    #Objectif Routes (Management)
    Route::get('/objectifs/create', [ObjectifController::class, 'create'])->name('goals.create');
    Route::post('/objectifs', [ObjectifController::class, 'store'])->name('goals.store');
    Route::get('/objectifs/edit/{id}', [ObjectifController::class, 'edit'])->name('goals.edit');
    Route::put('/objectifs/edit/{id}', [ObjectifController::class, 'update'])->name('goals.update');
    Route::delete('/objectifs/delete/{id}', [ObjectifController::class, 'destroy'])->name('goals.destroy');

    #Demande Routes (Manage)
    Route::get('/demandeDocuments/edit/{id}', [DemandeController::class, 'edit']);
    Route::put('/demandeDocuments/edit/{id}', [DemandeController::class, 'update']);
    Route::delete('/demandeDocuments/delete/{id}', [DemandeController::class, 'destroy']);
    
    # Reclamation Reponse
    Route::patch('/reclamation/reponse/{id}', function (Illuminate\Http\Request $request, $id) {
        $request->validate(['reponse' => 'required|string|max:1000']);
        $reclamation = Reclamation::findOrFail($id);
        $reclamation->update(['reponse' => $request->reponse, 'status' => 'resolue']);
        return redirect()->back()->with('msg', 'Réponse envoyée avec succès.');
    });
});

/*
|--------------------------------------------------------------------------
| COMMON AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    #Objectif Routes (View only for all)
    Route::get('/objectifs', [ObjectifController::class, 'index'])->name('goals.index');
    Route::get('/objectifs/{id}', [ObjectifController::class, 'show'])->name('goals.show');

    #Reclamation Routes
    Route::get('/reclamations' , [ReclamationController::class , 'index' ]);
    Route::post('/reclamations', [ReclamationController::class, 'store']);
    Route::get('/reclamation/{id}' , [ReclamationController::class , 'show' ]); 
    Route::delete('/reclamation/delete/{id}', function ($id) {
        $reclamation = Reclamation::findOrFail($id);
        if (auth()->user()->isAdmin() || $reclamation->idUser === auth()->id()) {
            $reclamation->delete();
            return redirect('/reclamations')->with('msg', 'Supprimée.');
        }
        abort(403);
    });

    #Conge Routes
    Route::get('/conge', [CongeController::class, 'index'])->name('conge.index');
    Route::post('/conge', [CongeController::class, 'store'])->name('conge.store');
    Route::get('/conge/{id}', [CongeController::class, 'show'])->name('conge.show');
    Route::put('/conge/update/{id}', [CongeController::class, 'update'])->name('conge.update');
    Route::delete('/conge/delete/{id}', [CongeController::class, 'destroy'])->name('conge.destroy');

    #Demande Routes (Basic)
    Route::get('/demandeDocuments', [DemandeController::class, 'index']);
    Route::post('/demandeDocuments', [DemandeController::class, 'store']);
    Route::get('/demandeDocuments/{id}', [DemandeController::class, 'show']);


    # Tasks Route
    Route::get('/tasks', [TacheController::class, 'index'])->name('tasks.index');
    Route::patch('/tasks/{id}/status', function (Illuminate\Http\Request $request, $id) {
        $tache = App\Models\Tache::findOrFail($id);
        $tache->update(['status' => $request->status]);
        return redirect()->back();
    })->name('tasks.updateStatus');

    Route::middleware('role:admin|manager')->group(function() {
        Route::post('/tasks', [TacheController::class, 'store'])->name('tasks.store');
        Route::delete('/tasks/{id}', [TacheController::class, 'destroy'])->name('tasks.destroy');
        Route::post('/tasks/assign', [TacheController::class, 'assignUser'])->name('tasks.assign');
        Route::post('/tasks/unassign', [TacheController::class, 'unassignUser'])->name('tasks.unassign');
        Route::put('/tasks/{id}', [TacheController::class, 'update'])->name('tasks.update');
    });

    # Meetings & Reunion Routes
    Route::get('/meetings', [ReunionController::class, 'index'])->name('meetings.index');
    Route::get('/reunions', [ReunionController::class, 'index'])->name('reunions.index');
    Route::get('/reunions/{id}', [ReunionController::class, 'show'])->name('reunions.show');
    
    Route::middleware('role:admin|manager')->group(function() {
        Route::get('/reunions/create', [ReunionController::class, 'create'])->name('reunions.create');
        Route::post('/reunions', [ReunionController::class, 'store'])->name('reunions.store');
        Route::get('/reunions/edit/{id}', [ReunionController::class, 'edit'])->name('reunions.edit');
        Route::put('/reunions/edit/{id}', [ReunionController::class, 'update'])->name('reunions.update');
        Route::delete('/reunions/delete/{id}', [ReunionController::class, 'destroy'])->name('reunions.destroy');
    });
});


#Pointage Routes 
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/pointage', [PointageController::class, 'userPointage'])->name('pointages.index');
    Route::get('/pointage/status', [PointageController::class, 'status'])->name('pointage.status');
    Route::post('/pointage/check-in', [PointageController::class, 'checkIn'])->name('pointage.checkin');
    Route::post('/pointage/check-out', [PointageController::class, 'checkOut'])->name('pointage.checkout');
    Route::get('/my-infractions', [PointageController::class, 'userPointage'])->name('user.infractions');
    Route::post('/justification/submit', [PointageController::class, 'submitJustification'])->name('justification.submit');
    
    Route::middleware('role:admin')->group(function() {
        Route::get('/admin/pointages', [PointageController::class, 'index'])->name('admin.pointages.index');
        Route::post('/admin/settings/update', [PointageController::class, 'updateSettings'])->name('admin.settings.update');
    });
});
#Paiment Routes
Route::get('/paiements', [PaimentController::class, 'index'])->name('paiements.index');
Route::post('/paiements/store', [PaimentController::class, 'store'])->name('paiements.store');
Route::get('/paiements/{id}', [PaimentController::class, 'show'])->name('paiements.show');
Route::get('/paiements/{id}/edit', [PaimentController::class, 'edit'])->name('paiements.edit');
Route::put('/paiements/{id}', [PaimentController::class, 'update'])->name('paiements.update');
Route::delete('/paiements/{id}', [PaimentController::class, 'destroy'])->name('paiements.destroy');



// Lead Routes
Route::get('/leads',[LeadController::class, 'index'])->name('leads.index');
Route::post('/leads',[LeadController::class, 'store'])->name('leads.store');
Route::get('/leads/export-pdf',[LeadController::class, 'exportPdf'])->name('leads.export-pdf');
Route::get('/leads/{id}',[LeadController::class, 'show'])->name('leads.show');
Route::get('/leads/{id}/edit',[LeadController::class, 'edit'])->name('leads.edit');
Route::put('/leads/{id}',[LeadController::class, 'update'])->name('leads.update');
Route::post('/leads/{id}/statut',[LeadController::class, 'updateStatut'])->name('leads.statut');
Route::delete('/leads/{id}',[LeadController::class, 'destroy'])->name('leads.destroy');
Route::get('/departements/{id}/users', function ($id) {
    $users = App\Models\User::where('idDepartement', $id)
                ->where('type', 'employee')
                ->get(['idUser', 'firstName', 'lastName']);
    return response()->json($users);
})->name('departements.users');



require __DIR__.'/auth.php';