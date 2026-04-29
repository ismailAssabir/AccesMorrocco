<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Client\ClientAuthController;
use App\Http\Controllers\Client\ClientDashboardController;
use App\Http\Controllers\Client\ClientDossierController;
use App\Http\Controllers\Client\ClientPresentationController;
use App\Http\Controllers\Client\ClientPaiementController;
use App\Http\Controllers\Client\ClientProfileController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\ObjectifController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\ReunionController;
use App\Http\Controllers\CongeController;
use App\Http\Controllers\PointageController;
use App\Http\Controllers\PaimentController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\DossierController;

use App\Models\Reclamation;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : app(AuthenticatedSessionController::class)->create(request());
})->name('home');

/*
|--------------------------------------------------------------------------
| CLIENT (MULTI AUTH)
|--------------------------------------------------------------------------
*/
Route::prefix('clients')->name('clients.')->group(function () {

    // 🔓 Public
    Route::get('/login', [ClientAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [ClientAuthController::class, 'login'])->name('login.post');

    // 🔒 Protected
    Route::middleware('auth.client')->group(function () {

        Route::post('/logout', [ClientAuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');

        Route::get('/dossiers', [ClientDossierController::class, 'index'])->name('dossiers');
        Route::get('/dossiers/{id}', [ClientDossierController::class, 'show'])->name('dossiers.show');

        Route::get('/presentations', [ClientPresentationController::class, 'index'])->name('presentations');

        Route::get('/paiements', [ClientPaiementController::class, 'index'])->name('paiements');

        Route::get('/profile', [ClientProfileController::class, 'index'])->name('profile');

    });

});

/*
|--------------------------------------------------------------------------
| USER AUTH (DEFAULT)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {

    // Users
    Route::resource('users', UserController::class);

    // Categories
    Route::get('categories/export-pdf', [CategoryController::class, 'exportPdf'])->name('categories.export-pdf');
    Route::resource('categories', CategoryController::class);

    // Permissions
    Route::resource('permissions', PermissionController::class)->except(['show', 'create', 'store']);
});

/*
|--------------------------------------------------------------------------
| CLIENT MANAGEMENT (ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('clients/export-pdf', [ClientController::class, 'exportPdf'])->name('clients.export-pdf');
    Route::resource('clients', ClientController::class);
});

/*
|--------------------------------------------------------------------------
| ADMIN + MANAGER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:admin|manager'])->group(function () {

    Route::resource('departements', DepartementController::class);
    
    Route::get('/departements/{id}/export-pdf', [DepartementController::class, 'exportPdf'])->name('departements.export-pdf');

    Route::resource('objectifs', ObjectifController::class)->except(['index', 'show']);

    Route::get('/demandeDocuments/edit/{id}', [DemandeController::class, 'edit']);
    Route::put('/demandeDocuments/edit/{id}', [DemandeController::class, 'update']);
    Route::delete('/demandeDocuments/delete/{id}', [DemandeController::class, 'destroy']);

    // Reclamation response
    Route::patch('/reclamation/reponse/{id}', function (Request $request, $id) {
        $request->validate(['reponse' => 'required|string|max:1000']);
        $rec = Reclamation::findOrFail($id);
        $rec->update(['reponse' => $request->reponse, 'status' => 'resolue']);
        return back()->with('msg', 'Réponse envoyée.');
    });
});

/*
|--------------------------------------------------------------------------
| COMMON AUTH USER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Objectifs
    Route::resource('objectifs', ObjectifController::class)->only(['index', 'show']);

    // Reclamations
    Route::resource('reclamations', ReclamationController::class)->except(['create', 'edit']);

    // Congés
    Route::resource('conge', CongeController::class);

    // Demandes
    Route::resource('demandeDocuments', DemandeController::class)->only(['index', 'store', 'show']);

    // Tasks
    Route::resource('tasks', TacheController::class)->except(['create', 'edit', 'show']);

    // Meetings
    Route::resource('reunions', ReunionController::class);

    // Primes
    Route::resource('primes', \App\Http\Controllers\PrimeController::class);
});

/*
|--------------------------------------------------------------------------
| POINTAGE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/pointage', [PointageController::class, 'userPointage'])->name('pointages.index');
    Route::post('/pointage/check-in', [PointageController::class, 'checkIn'])->name('pointage.checkin');
    Route::post('/pointage/check-out', [PointageController::class, 'checkOut'])->name('pointage.checkout');

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/pointages', [PointageController::class, 'index'])->name('admin.pointages.index');
        Route::get('/admin/pointages/export', [PointageController::class, 'exportPdf'])->name('admin.pointages.export');
        Route::get('/pointage/status', [PointageController::class, 'status'])
        ->name('pointage.status');
    });
});

/*
|--------------------------------------------------------------------------
| PAIEMENTS
|--------------------------------------------------------------------------
*/
Route::resource('paiements', PaimentController::class);

/*
|--------------------------------------------------------------------------
| LEADS
|--------------------------------------------------------------------------
*/
Route::resource('leads', LeadController::class);
Route::get('/leads/export-pdf', [LeadController::class, 'exportPdf'])->name('leads.export-pdf');

/*
|--------------------------------------------------------------------------
| DOSSIERS
|--------------------------------------------------------------------------
*/
Route::resource('dossiers', DossierController::class);
Route::get('/dossiers/export-pdf', [DossierController::class, 'exportPdf'])->name('dossiers.export-pdf');
Route::get('/departements/{id}/users', [DossierController::class, 'getEmployes'])->name('departements.users');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';