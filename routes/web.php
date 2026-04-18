<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
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


require __DIR__.'/auth.php';
