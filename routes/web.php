<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReclamationController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| HOME = LOGIN (entry point)
|--------------------------------------------------------------------------
| A single / route handles both guests and authenticated users cleanly.
| - Guest        → shows the login page (AuthenticatedSessionController@create)
| - Authenticated → redirects to /dashboard
*/
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return app(AuthenticatedSessionController::class)->create(request());
})->name('home');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
#user Routes
Route::get('/users' , [UserController::class , 'index' ]);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{id}' , [UserController::class , 'show' ]);
Route::get('/users/edit/{id}' , [UserController::class , 'edit' ]);
Route::put('/users/edit/{id}' , [UserController::class , 'update' ]);
#Client Routes
Route::get('/clients' , [ClientController::class , 'index' ]);
Route::post('/clients', [ClientController::class, 'store']);
Route::get('/clients/{id}' , [ClientController::class , 'show' ]);
Route::get('/clients/edit/{id}' , [ClientController::class , 'edit' ]);
Route::put('/clients/edit/{id}' , [ClientController::class , 'update' ]);
#Category Routes
Route::get('/category' , [CategoryController::class , 'index' ]);
Route::post('/category', [CategoryController::class, 'store']);
// Route::get('/category/{id}' , [CategoryController::class , 'show' ]);
Route::get('/category/edit/{id}' , [CategoryController::class , 'edit' ]);
Route::put('/category/edit/{id}' , [CategoryController::class , 'update' ]);
Route::delete('/category/delete/{id}' , [CategoryController::class , 'destroy' ]);
#Reclamation Routes
Route::get('/reclamations' , [ReclamationController::class , 'index' ]);
Route::post('/reclamations', [ReclamationController::class, 'store']);
Route::get('/reclamation/{id}' , [CategoryController::class , 'show' ]);
// Route::get('/category/edit/{id}' , [ReclamationController::class , 'edit' ]);
// Route::put('/category/edit/{id}' , [ReclamationController::class , 'update' ]);
Route::delete('/reclamation/delete/{id}' , [ReclamationController::class , 'destroy' ]);
require __DIR__.'/auth.php';
