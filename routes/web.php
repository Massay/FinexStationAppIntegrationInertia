<?php

use App\Http\Controllers\JournalVoucherController;
use App\Http\Controllers\ProcessJVPostingController;
use App\Http\Controllers\ProcessSivPostingController;
use App\Http\Controllers\SivController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/siv', [SivController::class,'create'])->name('siv');
    Route::post('/siv/process', ProcessSivPostingController::class)->name('siv.process');


    Route::get('/jv', [JournalVoucherController::class,'create'])->name('jv');
    Route::post('/jv/process', ProcessJVPostingController::class)->name('jv.process');


});
