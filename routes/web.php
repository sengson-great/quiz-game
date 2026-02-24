<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::post('/games', [GameController::class, 'start']);
Route::get('/games/{game}/next-question', [GameController::class, 'nextQuestion']);
Route::post('/games/{game}/answer', [GameController::class, 'submitAnswer']);
Route::post('/games/{game}/finish', [GameController::class, 'finish']);
Route::get('/games/{game}', [GameController::class, 'show']);

Route::get('/leaderboard', [GameController::class, 'leaderboard']);
Route::get('/leaderboard/me', [GameController::class, 'myPosition']);
