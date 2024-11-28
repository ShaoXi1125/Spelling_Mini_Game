<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Score;

class GameController extends Controller
{
    public function showGame()
    {
        return view('game');
    }

    public function startGame(Request $request)
    {
        $request->validate(['nickname' => 'required|string|max:255']);

        // Create or fetch the player based on nickname
        $player = Player::firstOrCreate(['nickname' => $request->nickname]);

        return response()->json(['player' => $player]);
    }

    public function submitScore(Request $request)
    {
        $request->validate([
            'player_id' => 'required|exists:players,id',
            'score' => 'required|integer',
        ]);

        $score = Score::create([
            'player_id' => $request->player_id,
            'score' => $request->score,
        ]);

        return response()->json(['score' => $score]);
    }

    public function leaderboard()
    {
        $scores = Score::with('player')->orderBy('score', 'desc')->take(10)->get();
        return view('leaderboard', compact('scores'));
    }
}
