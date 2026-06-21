<?php

use App\Models\User;
use App\Services\ChessAnalysisService;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('chess analysis service can evaluate position', function () {
    Http::fake([
        'chess-api.com/v1' => Http::response([
            'eval' => 1.36,
            'move' => 'b2b6',
            'winChance' => 60.5,
            'mate' => null,
        ], 200),
    ]);

    $service = new ChessAnalysisService();
    $result = $service->evaluatePosition('rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1');

    expect($result)->toBeArray()
        ->and($result['success'])->toBeTrue()
        ->and($result['eval'])->toBe(1.36)
        ->and($result['move'])->toBe('b2b6');
});

test('chess analysis service can evaluate move quality correctly', function (
    float $evalBefore,
    float $evalAfter,
    bool $isWhite,
    string $expectedClassification
) {
    Http::fake([
        'chess-api.com/v1' => Http::sequence([
            Http::response(['eval' => $evalBefore, 'mate' => null, 'move' => 'e2e4'], 200),
            Http::response(['eval' => $evalAfter, 'mate' => null, 'move' => 'd7d5'], 200),
        ]),
    ]);

    $service = new ChessAnalysisService();
    $result = $service->evaluateMove('fen_before', 'fen_after', $isWhite, 'other_move');

    expect($result['classification'])->toBe($expectedClassification);
})->with([
    // [evalBefore, evalAfter, isWhite, expectedClassification]
    
    // White turn
    [1.50, 1.60, true, 'Excellent'],     // Delta <= 0 (improved position, but not the recommended best move)
    [1.50, 1.40, true, 'Excellent'],     // Delta = 10cp (<= 20)
    [1.50, 1.10, true, 'Good'],          // Delta = 40cp (<= 50)
    [1.50, 0.70, true, 'Inaccuracy'],    // Delta = 80cp (<= 100)
    [1.50, -0.30, true, 'Mistake'],      // Delta = 180cp (<= 200)
    [1.50, -1.00, true, 'Blunder'],      // Delta = 250cp (> 200)

    // Black turn
    [-1.50, -1.60, false, 'Excellent'],  // Delta <= 0 (improved position, but not the recommended best move)
    [-1.50, -1.40, false, 'Excellent'],  // Delta = 10cp (<= 20)
    [-1.50, -1.10, false, 'Good'],       // Delta = 40cp (<= 50)
    [-1.50, -0.70, false, 'Inaccuracy'], // Delta = 80cp (<= 100)
    [-1.50, 0.30, false, 'Mistake'],     // Delta = 180cp (<= 200)
    [-1.50, 1.00, false, 'Blunder'],     // Delta = 250cp (> 200)
]);

test('evaluate-move route is protected and validates input', function () {
    // Guest cannot access
    $this->postJson('/api/game/evaluate-move', [
        'fen_before' => 'fen1',
        'fen_after' => 'fen2',
        'is_white_turn' => true,
    ])->assertStatus(401);

    $user = User::factory()->create();

    // Authenticated but invalid input
    $this->actingAs($user)
        ->postJson('/api/game/evaluate-move', [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['fen_before', 'fen_after', 'is_white_turn']);
});

test('evaluate-move route successfully calls service and returns response', function () {
    $user = User::factory()->create();

    Http::fake([
        'chess-api.com/v1' => Http::sequence([
            Http::response(['eval' => 1.50, 'mate' => null, 'move' => 'e2e4'], 200),
            Http::response(['eval' => -1.00, 'mate' => null, 'move' => 'd7d5'], 200),
        ]),
    ]);

    $this->actingAs($user)
        ->postJson('/api/game/evaluate-move', [
            'fen_before' => 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1',
            'fen_after' => 'r1bqkbnr/pppppppp/n7/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1',
            'is_white_turn' => true,
            'move' => 'Na6',
        ])
        ->assertStatus(200)
        ->assertJson([
            'success' => true,
            'classification' => 'Blunder',
            'delta_centipawns' => 250,
        ]);
});

test('evaluate-position route is protected and validates input', function () {
    // Guest cannot access
    $this->postJson('/api/game/evaluate-position', [
        'fen' => 'fen1',
    ])->assertStatus(401);

    $user = User::factory()->create();

    // Authenticated but invalid input
    $this->actingAs($user)
        ->postJson('/api/game/evaluate-position', [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['fen']);
});

test('evaluate-position route successfully calls service and returns response', function () {
    $user = User::factory()->create();

    Http::fake([
        'chess-api.com/v1' => Http::response([
            'eval' => 0.5,
            'move' => 'e2e4',
        ], 200),
    ]);

    $this->actingAs($user)
        ->postJson('/api/game/evaluate-position', [
            'fen' => 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1',
            'depth' => 10,
        ])
        ->assertStatus(200)
        ->assertJson([
            'success' => true,
            'eval' => 0.5,
            'move' => 'e2e4',
        ]);
});
