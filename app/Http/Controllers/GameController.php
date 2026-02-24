<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameSession;
use App\Models\Question;
use App\Models\GameAnswer;

class GameController extends Controller
{
    public function start(Request $request)
    {
        $game = GameSession::create([
            'user_id' => $request->user()->id,
            'started_at' => now(),
            'max_possible' => 15,
        ]);

        return response()->json([
            'game_id' => $game->id,
            'started_at' => $game->started_at,
            'message' => 'Game started – good luck!'
        ]);
    }

    public function show(GameSession $game)
    {
        return response()->json($this->getGameResult($game));
    }

    public function nextQuestion(GameSession $game)
    {
        if ($game->isFinished()) {
            return response()->json(['error' => 'Game already finished'], 410);
        }

        if ($game->user_id !== auth()->id) {
            abort(403);
        }

        $qNumber = $game->currentQuestionNumber();

        if ($qNumber > 15) {
            $game->update(['finished_at' => now()]);
            return response()->json($this->getGameResult($game));
        }

        $question = Question::query()
            ->orderBy('order')
            ->orWhere('difficulty', $qNumber)   // or any progression logic
            ->skip($qNumber - 1)
            ->firstOrFail();

        return response()->json([
            'question_number' => $qNumber,
            'question' => $question->question,
            'options' => [
                'A' => $question->option_a,
                'B' => $question->option_b,
                'C' => $question->option_c,
                'D' => $question->option_d,
            ],
            'seconds' => 30,
        ]);
    }

    public function submitAnswer(Request $request, GameSession $game)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer' => 'required|in:A,B,C,D',
            'time_left' => 'nullable|integer|min:0|max:30', // optional
        ]);

        if ($game->isFinished() || $game->user_id !== auth()->id) {
            abort(403);
        }

        $question = Question::findOrFail($request->question_id);

        $correct = $request->answer === $question->correct;

        // Optional: save answer
        GameAnswer::create([
            'game_session_id' => $game->id,
            'question_id' => $question->id,
            'chosen' => $request->answer,
            'is_correct' => $correct,
            'answered_at' => now(),
        ]);

        if ($correct) {
            $game->increment('score', 10);      // example: +10 points
            $game->increment('correct_count');
        }

        $finished = $game->correct_count >= 15;

        if ($finished) {
            $game->update(['finished_at' => now()]);
        }

        return response()->json([
            'correct' => $correct,
            'score' => $game->score,
            'finished' => $finished,
            'next' => !$finished,
        ]);
    }

    public function finish(GameSession $game)
    {
        if ($game->user_id !== auth()->id)
            abort(403);

        if (!$game->isFinished()) {
            $game->update(['finished_at' => now()]);
        }

        return response()->json($this->getGameResult($game));
    }

    private function getGameResult(GameSession $game)
    {
        return [
            'game_id' => $game->id,
            'score' => $game->score,
            'correct' => $game->correct_count,
            'max' => 15,
            'percentage' => $game->max_possible ? round($game->score / ($game->max_possible * 10) * 100, 1) : 0,
            'finished_at' => $game->finished_at,
        ];
    }

    public function leaderboard()
    {
        $top = GameSession::query()
            ->selectRaw('user_id, MAX(score) as best_score, COUNT(*) as games_played')
            ->with('user:id,name')
            ->groupBy('user_id')
            ->orderByDesc('best_score')
            ->limit(50)
            ->get();

        return response()->json($top);
    }
}
