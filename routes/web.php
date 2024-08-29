<?php
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\ScoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LeaderboardController::class, 'showHomePage'])->name('home');

Route::group(['prefix' => 'en', 'middleware' => 'setlocale:en'], function () {
    Route::get('/', [LeaderboardController::class, 'showHomePage'])->name('home.en');
    Route::get('/leaderboard', [LeaderboardController::class, 'showLeaderboardPage'])->name('leaderboard.en');
    Route::get('/levels', [GameController::class, 'index'])->name('levels.index.en');
    Route::get('/levels/{level}', [GameController::class, 'showLevel'])->name('levels.show.en');
    Route::get('/cookies', [StaticController::class, 'cookies'])->name('cookies.en');
    Route::get('/privacy', [StaticController::class, 'privacy'])->name('privacy.en');
    Route::get('/legal', [StaticController::class, 'legal'])->name('legal.en');
    Route::get('/terms', [StaticController::class, 'terms'])->name('terms.en');
    Route::get('/contact', [StaticController::class, 'contact'])->name('contact.en');
});

Route::get('/leaderboard', [LeaderboardController::class, 'showLeaderboardPage'])->name('leaderboard');
Route::get('/leaderboard/data/{level?}', [LeaderboardController::class, 'getLeaderboard'])->name('leaderboard.data');

Route::get('/levels', [GameController::class, 'index'])->name('levels.index');
Route::get('/levels/{level}', [GameController::class, 'showLevel'])->name('levels.show');

Route::get('/play', [PlayerController::class, 'play'])->name('play');
Route::get('/enter-pseudo', [PlayerController::class, 'showPseudoForm'])->name('pseudo.form');
Route::post('/enter-pseudo', [PlayerController::class, 'storePseudo'])->name('pseudo.store');

Route::get('/cookies', [StaticController::class, 'cookies'])->name('cookies');
Route::get('/privacy', [StaticController::class, 'privacy'])->name('privacy');
Route::get('/legal', [StaticController::class, 'legal'])->name('legal');
Route::get('/terms', [StaticController::class, 'terms'])->name('terms');
Route::get('/contact', [StaticController::class, 'contact'])->name('contact');

Route::get('/game/level/{level}/question/{question}', [GameController::class, 'fetchQuestion'])->name('game.fetchQuestion');
Route::post('/levels/{level}/questions/{question}/verify', [GameController::class, 'verifyAnswer'])->name('questions.verify');

Route::get('/api/get_emoji_data', [GameController::class, 'getEmojiData'])->name('emoji.data');
Route::post('/api/tmdb', [ApiController::class, 'searchMovie'])->name('tmdb.api');
Route::post('/levels/2/check-answer', [GameController::class, 'checkLevel2Answer'])->name('level2.check');

Route::post('/scores/{level}', [ScoreController::class, 'store'])->name('scores.store');

Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/set-locale/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'fr'])) {
        abort(400);
    }

    $previousUrl = url()->previous();
    $path = parse_url($previousUrl, PHP_URL_PATH);

    if ($locale === 'en') {
        $newUrl = str_replace('/fr', '/en', $path);
        if (!str_contains($newUrl, '/en')) {
            $newUrl = '/en' . $newUrl;
        }
    } else {
        $newUrl = str_replace('/en', '', $path);
    }

    return redirect($newUrl);
})->name('set-locale');