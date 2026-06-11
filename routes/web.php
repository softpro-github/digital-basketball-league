<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Coach;
use App\Http\Controllers\Player;
use Illuminate\Support\Facades\Route;

// Public landing
Route::get('/', fn() => view('welcome'))->name('home');

// Auth (guests only)
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('leagues', Admin\LeagueController::class);
    Route::resource('teams',   Admin\TeamController::class);
    Route::resource('players', Admin\PlayerController::class);
    Route::resource('users',   Admin\UserController::class);
    Route::resource('matches', Admin\MatchController::class);
    Route::get ('matches/{match}/result',  [Admin\MatchController::class, 'recordResult'])->name('matches.result');
    Route::post('matches/{match}/result',  [Admin\MatchController::class, 'storeResult'])->name('matches.storeResult');
});

// Coach routes
Route::middleware(['auth', 'role:coach'])->prefix('coach')->name('coach.')->group(function () {
    Route::get('/',            [Coach\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/team/{team}', [Coach\DashboardController::class, 'team'])->name('team');
});

// Player routes
Route::middleware(['auth', 'role:player'])->prefix('player')->name('player.')->group(function () {
    Route::get('/',          [Player\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/fixtures',  [Player\DashboardController::class, 'fixtures'])->name('fixtures');
    Route::get('/standings', [Player\DashboardController::class, 'standings'])->name('standings');
});
