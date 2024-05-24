<?php

use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/history', [StaticController::class, 'history'])->name('history');
Route::get('/leaderboard', [StaticController::class, 'leaderboard'])->name('leaderboard');
Route::get('/faq', [StaticController::class, 'faq'])->name('faq');
Route::get('/contact', [StaticController::class, 'contact'])->name('contact');
Route::get('/cookies', [StaticController::class, 'cookies'])->name('cookies');
Route::get('/privacy', [StaticController::class, 'privacy'])->name('privacy');
Route::get('/legal', [StaticController::class, 'legal'])->name('legal');
Route::get('/terms', [StaticController::class, 'terms'])->name('terms');


Route::get('/levels', [LevelController::class, 'index'])->name('levels.index');
Route::get('/levels/{level}', [LevelController::class, 'show'])->name('levels.show');

Route::get('/game/level/{level}/question/{question}', [GameController::class, 'fetchQuestion'])->name('game.fetchQuestion');

Route::post('/levels/{levelId}/questions/{questionId}/verify', [LevelController::class, 'verifyAnswer'])->name('questions.verify');

Route::post('/level/{level_id}/score', [ScoreController::class, 'store'])->middleware('auth');

Route::fallback(function () {
    return redirect()->route('/');
});

require __DIR__ . '/auth.php';
