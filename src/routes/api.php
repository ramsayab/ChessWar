<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // 1. Leaderboard API
    Route::get('/leaderboard', function () {
        $leaderboard = \App\Models\User::select('users.id', 'users.name')
            ->selectRaw('count(matches.id) as total_matches')
            ->selectRaw('sum(case when matches.is_win = 1 then 1 else 0 end) as won_matches')
            ->join('matches', 'users.id', '=', 'matches.user_id')
            ->groupBy('users.id', 'users.name')
            ->orderByRaw('sum(case when matches.is_win = 1 then 1 else 0 end) desc')
            ->take(10)
            ->get()
            ->map(function ($player, $index) {
                $total = (int)$player->total_matches;
                $won = (int)$player->won_matches;
                return [
                    'rank' => $index + 1,
                    'name' => $player->name,
                    'total_matches' => $total,
                    'won_matches' => $won,
                    'winrate' => $total > 0 ? round(($won / $total) * 100) . '%' : '0%',
                ];
            });

        return response()->json([
            'success' => true,
            'leaderboard' => $leaderboard,
        ]);
    });

    // 2. Personal Stats API
    Route::get('/user/stats', function () {
        $user = auth()->user();
        $total = $user->matches()->count();
        $won = $user->matches()->where('is_win', true)->count();
        $avgSeconds = $user->matches()->avg('total_time') ?? 0;

        return response()->json([
            'success' => true,
            'stats' => [
                'name' => $user->name,
                'total_matches' => $total,
                'won_matches' => $won,
                'winrate' => $total > 0 ? round(($won / $total) * 100) : 0,
                'avg_duration_minutes' => round($avgSeconds / 60, 1),
            ]
        ]);
    });

    // 3. Powers API
    Route::get('/powers', function () {
        return response()->json([
            'success' => true,
            'powers' => [
                [
                    'value' => 'blink_knight',
                    'name' => 'Blink Knight',
                    'description' => 'Knight jumps with a longer reach, doubling the usual movement patterns.'
                ],
                [
                    'value' => 'super_rook',
                    'name' => 'Super Rook',
                    'description' => 'Rook keeps straight lines and gains one-step forward diagonals.'
                ],
                [
                    'value' => 'confused_pawn',
                    'name' => 'Confused Pawn',
                    'description' => 'Pawn can move backward too, making file control much more chaotic.'
                ],
                [
                    'value' => 'undying_king',
                    'name' => 'Undying King',
                    'description' => 'King has 2 lives. The enemy piece that captures the King dies, and the King is restored.'
                ],
                [
                    'value' => 'omni_queen',
                    'name' => 'Omni Queen',
                    'description' => 'Queen can move like a Queen and jump like a Knight.'
                ],
                [
                    'value' => 'grey_bishop',
                    'name' => 'Grey Bishop',
                    'description' => 'Bishop can shift 1 step left/right (changing square color) and then slide diagonally.'
                ]
            ]
        ]);
    });

    // 4. Save Game API
    Route::post('/game/save', function (Illuminate\Http\Request $request) {
        $request->validate([
            'fen' => 'required|string',
            'power_type' => 'nullable|string',
        ]);

        $savedGame = \App\Models\SavedGame::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'fen' => $request->fen,
                'power_type' => $request->power_type,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Game state saved successfully.',
            'saved_game' => $savedGame,
        ]);
    });

    // 5. Resume Game API
    Route::get('/game/resume', function () {
        $savedGame = auth()->user()->savedGame;

        if (!$savedGame) {
            return response()->json([
                'success' => false,
                'message' => 'No saved game found for this user.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'saved_game' => $savedGame,
        ]);
    });

    // 6. Chess Analysis - Move Evaluation
    Route::post('/game/evaluate-move', function (Illuminate\Http\Request $request, \App\Services\ChessAnalysisService $chessAnalysisService) {
        $request->validate([
            'fen_before' => 'required|string',
            'fen_after' => 'required|string',
            'is_white_turn' => 'required|boolean',
            'move' => 'nullable|string',
        ]);

        $result = $chessAnalysisService->evaluateMove(
            $request->fen_before,
            $request->fen_after,
            $request->is_white_turn,
            $request->move
        );

        if (!$result['success']) {
            return response()->json($result, 400);
        }

        return response()->json($result);
    });

    // 7. Chess Analysis - Position Evaluation
    Route::post('/game/evaluate-position', function (Illuminate\Http\Request $request, \App\Services\ChessAnalysisService $chessAnalysisService) {
        $request->validate([
            'fen' => 'required|string',
            'depth' => 'nullable|integer|min:1|max:18',
        ]);

        $result = $chessAnalysisService->evaluatePosition(
            $request->fen,
            $request->input('depth', 12)
        );

        if (!$result['success']) {
            return response()->json($result, 400);
        }

        return response()->json($result);
    });
});
