<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\ScoreController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', [LeaderboardController::class, 'showHomePage'])->name('home');
Route::get('/leaderboard', [LeaderboardController::class, 'showLeaderboardPage'])->name('leaderboard');

Route::get('/play', [PlayerController::class, 'play'])->name('play');
Route::get('/enter-pseudo', [PlayerController::class, 'showPseudoForm'])->name('pseudo.form');
Route::post('/enter-pseudo', [PlayerController::class, 'storePseudo'])->name('pseudo.store');

Route::get('/cookies', [StaticController::class, 'cookies'])->name('cookies');
Route::get('/privacy', [StaticController::class, 'privacy'])->name('privacy');
Route::get('/legal', [StaticController::class, 'legal'])->name('legal');
Route::get('/terms', [StaticController::class, 'terms'])->name('terms');

Route::get('/levels', [GameController::class, 'index'])->name('levels.index');
Route::get('/levels/{level}', [GameController::class, 'showLevel'])->name('levels.show');
Route::get('/game/level/{level}/question/{question}', [GameController::class, 'fetchQuestion'])->name('game.fetchQuestion');
Route::post('/levels/{level}/questions/{question}/verify', [GameController::class, 'verifyAnswer'])->name('questions.verify');

Route::get('/api/get_emoji_data', [GameController::class, 'getEmojiData'])->name('emoji.data');
Route::post('/api/tmdb', [ApiController::class, 'searchMovie'])->name('tmdb.api');
Route::post('/levels/2/check-answer', [GameController::class, 'checkLevel2Answer'])->name('level2.check');

Route::post('/scores/{level}', [ScoreController::class, 'store'])->name('scores.store');

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
