<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\DepartementController;

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





/*
|--------------------------------------------------------------------------
| Départements Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
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
});

require __DIR__.'/auth.php';