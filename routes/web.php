<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JournalVoucherController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProcessJVPostingController;
use App\Http\Controllers\ProcessSivPostingController;
use App\Http\Controllers\SivController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'appName' => config('app.name')
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {


    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    Route::get('/siv', [SivController::class,'create'])->name('siv');
    Route::post('/siv/process', ProcessSivPostingController::class)->name('siv.process');


    Route::get('/jv', [JournalVoucherController::class,'create'])->name('jv');
    Route::post('/process/jv', ProcessJVPostingController::class)->name('jv.process');


    Route::get('/users', [UserController::class,'index'])->name('users.index');
    Route::get('/users/create', [UserController::class,'create'])->name('users.create');
    Route::post('/users/store', [UserController::class,'store'])->name('users.store');
    Route::get('/users/edit/{user}', [UserController::class,'edit'])->name('users.edit');
    Route::post('/users/update/{user}', [UserController::class,'update'])->name('users.update');

    Route::get('/prices', [PriceController::class,'index'])->name('prices.index');
    Route::get('/prices/create', [PriceController::class,'create'])->name('prices.create');
    Route::post('/prices/store', [PriceController::class,'store'])->name('prices.store');
    Route::get('/prices/{id}', [PriceController::class,'edit'])->name('prices.edit');
    Route::post('/prices/{id}', [PriceController::class,'update'])->name('prices.update');





    Route::get('/stations', [StationController::class,'index'])->name('stations.index');
    Route::get('/stations/create', [StationController::class,'create'])->name('stations.create');
    Route::post('/stations/store', [StationController::class,'store'])->name('stations.store');
    Route::get('/stations/{id}', [StationController::class,'edit'])->name('stations.edit');
    Route::post('/stations/{id}', [StationController::class,'update'])->name('stations.update');








});
