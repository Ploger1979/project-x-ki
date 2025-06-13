<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketFrontendController;
use App\Http\Controllers\KundenFrontendController;
use App\Http\Controllers\Api\SettingsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// LandingPage (ohne Login nötig)
Route::get('/', function () {
    return Inertia::render('LandingPage', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

// Login & Register
Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');
Route::get('/register', function () {
    return Inertia::render('Auth/Register');
})->name('register');

// Dashboard ➜ TicketFrontendController@dashboard
Route::get('/dashboard', [TicketFrontendController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// *** ALLE Projektseiten nur für eingeloggte User ***
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Einstellungen **=> ده اللى يخلّى الصفحة تظهر لما تضغط فى الـ Sidebar**
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    
    // Tickets - List
    Route::get('/tickets/list', [TicketFrontendController::class, 'list'])->name('tickets.list');
    
    // Tickets - Search
    Route::get('/tickets/search', function () {
        return Inertia::render('Tickets/Search');
    })->name('tickets.search');
    
    // Tickets - Analyse
    Route::get('/tickets/analyse', [TicketFrontendController::class, 'analyse'])->name('tickets.analyse');
    
    // Kunden-Liste
    Route::get('/kunden/list', [KundenFrontendController::class, 'list'])->name('kunden.list');

    
});

require __DIR__ . '/auth.php';