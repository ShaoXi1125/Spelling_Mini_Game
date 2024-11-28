<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::get('/',[GameController::class,'showGame'])->name('game');
Route::get('/leaderboard',[GameController::class,'leaderboard'])->name('leaderboard');

Route::post('/start-game',[GameController::class,'startGame']);
Route::post('/submit_score', [GameController::class, 'submitScore']);
