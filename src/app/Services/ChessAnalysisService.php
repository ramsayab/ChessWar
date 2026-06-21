<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ChessAnalysisService
{
    protected string $url;

    public function __construct()
    {
        $this->url = config('services.chess_api.url') ?? 'https://chess-api.com/v1';
    }

    /**
     * Get Stockfish evaluation for a given FEN position.
     *
     * @param string $fen
     * @param int $depth
     * @return array
     */
    public function evaluatePosition(string $fen, int $depth = 12): array
    {
        $cacheKey = 'chess_eval_' . md5($fen . '_' . $depth);
        return Cache::remember($cacheKey, now()->addHours(24), function () use ($fen, $depth) {
            try {
                $response = Http::withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->post($this->url, [
                    'fen' => $fen,
                    'depth' => $depth,
                ]);

                if ($response->failed()) {
                    Log::error('Chess-API position evaluation failed', [
                        'status' => $response->status(),
                        'body' => $response->body(),
                    ]);

                    return [
                        'success' => false,
                        'error' => 'Failed to retrieve position evaluation.'
                    ];
                }

                $data = $response->json() ?? [];
                if (isset($data['type']) && $data['type'] === 'error') {
                    Log::error('Chess-API returned error body', $data);
                    return [
                        'success' => false,
                        'error' => $data['text'] ?? ($data['error'] ?? 'API error')
                    ];
                }

                return array_merge(['success' => true], $data);
            } catch (\Exception $e) {
                Log::error('Chess-API request error: ' . $e->getMessage());
                return [
                    'success' => false,
                    'error' => 'An unexpected error occurred: ' . $e->getMessage()
                ];
            }
        });
    }

    /**
     * Evaluate the played move by comparing positions before and after.
     *
     * @param string $fenBefore
     * @param string $fenAfter
     * @param bool $isWhiteTurn
     * @param string|null $playedMove (UCI format, e.g. "e2e4")
     * @return array
     */
    public function evaluateMove(string $fenBefore, string $fenAfter, bool $isWhiteTurn, ?string $playedMove = null): array
    {
        Log::debug('evaluateMove called', [
            'fen_before' => $fenBefore,
            'fen_after' => $fenAfter,
            'is_white_turn' => $isWhiteTurn,
            'played_move' => $playedMove
        ]);

        $depth = 12;
        $cacheKeyBefore = 'chess_eval_' . md5($fenBefore . '_' . $depth);
        $cacheKeyAfter = 'chess_eval_' . md5($fenAfter . '_' . $depth);

        $hasBefore = Cache::has($cacheKeyBefore);
        $hasAfter = Cache::has($cacheKeyAfter);

        if (!$hasBefore && !$hasAfter) {
            // Fetch both in parallel
            try {
                $responses = Http::pool(fn (\Illuminate\Http\Client\Pool $pool) => [
                    $pool->as('before')->withHeaders([
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                    ])->post($this->url, [
                        'fen' => $fenBefore,
                        'depth' => $depth,
                    ]),
                    $pool->as('after')->withHeaders([
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                    ])->post($this->url, [
                        'fen' => $fenAfter,
                        'depth' => $depth,
                    ]),
                ]);

                $beforeResp = $responses['before'];
                $afterResp = $responses['after'];

                if ($beforeResp->failed() || $afterResp->failed()) {
                    Log::error('Chess-API parallel request failed', [
                        'before_status' => $beforeResp->status(),
                        'after_status' => $afterResp->status(),
                    ]);
                    return [
                        'success' => false,
                        'error' => 'Failed to retrieve evaluations.'
                    ];
                }

                $beforeData = $beforeResp->json() ?? [];
                if (isset($beforeData['type']) && $beforeData['type'] === 'error') {
                    return [
                        'success' => false,
                        'error' => $beforeData['text'] ?? ($beforeData['error'] ?? 'API error')
                    ];
                }

                $afterData = $afterResp->json() ?? [];
                if (isset($afterData['type']) && $afterData['type'] === 'error') {
                    return [
                        'success' => false,
                        'error' => $afterData['text'] ?? ($afterData['error'] ?? 'API error')
                    ];
                }

                $beforeEval = array_merge(['success' => true], $beforeData);
                $afterEval = array_merge(['success' => true], $afterData);

                Cache::put($cacheKeyBefore, $beforeEval, now()->addHours(24));
                Cache::put($cacheKeyAfter, $afterEval, now()->addHours(24));
            } catch (\Exception $e) {
                Log::error('Chess-API parallel request exception: ' . $e->getMessage());
                return [
                    'success' => false,
                    'error' => 'An error occurred during parallel evaluation: ' . $e->getMessage()
                ];
            }
        } else {
            // Fetch individually using cached evaluatePosition
            $beforeEval = $this->evaluatePosition($fenBefore, $depth);
            if (!$beforeEval['success']) {
                Log::error('Could not evaluate the position before the move', ['error' => $beforeEval['error'] ?? '']);
                return [
                    'success' => false,
                    'error' => 'Could not evaluate the position before the move: ' . ($beforeEval['error'] ?? '')
                ];
            }

            $afterEval = $this->evaluatePosition($fenAfter, $depth);
            if (!$afterEval['success']) {
                Log::error('Could not evaluate the position after the move', ['error' => $afterEval['error'] ?? '']);
                return [
                    'success' => false,
                    'error' => 'Could not evaluate the position after the move: ' . ($afterEval['error'] ?? '')
                ];
            }
        }

        // 3. Extract standardized scores (in pawns/centipawns)
        $scoreBefore = $this->getStandardizedScore($beforeEval);
        $scoreAfter = $this->getStandardizedScore($afterEval);

        // 4. Calculate the delta/loss in centipawns (1 pawn = 100 centipawns)
        $delta = $isWhiteTurn ? ($scoreBefore - $scoreAfter) : ($scoreAfter - $scoreBefore);
        $deltaCp = round($delta * 100);

        // 5. Determine move classification
        $classification = 'Good';
        
        // If playedMove matches the recommended best move from the before position
        $bestMoveRecommended = $beforeEval['move'] ?? null;
        $isBestMove = $playedMove && $bestMoveRecommended && (strtolower($playedMove) === strtolower($bestMoveRecommended));

        if ($isBestMove) {
            $classification = 'Best Move';
        } elseif ($deltaCp <= 20) {
            $classification = 'Excellent';
        } elseif ($deltaCp <= 50) {
            $classification = 'Good';
        } elseif ($deltaCp <= 100) {
            $classification = 'Inaccuracy';
        } elseif ($deltaCp <= 200) {
            $classification = 'Mistake';
        } else {
            $classification = 'Blunder';
        }

        Log::info('evaluateMove details:', [
            'is_white_turn' => $isWhiteTurn,
            'played_move' => $playedMove,
            'best_move_rec' => $bestMoveRecommended,
            'is_best_move_check' => $isBestMove,
            'score_before' => $scoreBefore,
            'score_after' => $scoreAfter,
            'delta_cp' => $deltaCp,
            'classification' => $classification,
            'before_raw' => $beforeEval,
            'after_raw' => $afterEval,
        ]);

        return [
            'success' => true,
            'classification' => $classification,
            'delta_centipawns' => $deltaCp,
            'best_move' => $bestMoveRecommended,
            'eval_before' => $beforeEval['eval'] ?? 0.0,
            'eval_after' => $afterEval['eval'] ?? 0.0,
            'mate_before' => $beforeEval['mate'] ?? null,
            'mate_after' => $afterEval['mate'] ?? null,
            'win_chance_before' => $beforeEval['winChance'] ?? null,
            'win_chance_after' => $afterEval['winChance'] ?? null,
        ];
    }

    /**
     * Convert raw eval/mate response to a standardized numerical pawn value.
     *
     * @param array $result
     * @return float
     */
    protected function getStandardizedScore(array $result): float
    {
        // Handle forced mates
        if (isset($result['mate']) && $result['mate'] !== null) {
            $mate = (int)$result['mate'];
            if ($mate === 0) {
                return 0.0;
            }
            // Mate score is represented as 100.0 pawns (10000 cp) offset by the number of moves to mate.
            // A positive mate value means White mates Black (highly favorable to White).
            // A negative mate value means Black mates White (highly favorable to Black).
            return $mate > 0 ? (100.0 - ($mate / 100)) : (-100.0 - ($mate / 100));
        }

        // Use standard engine evaluation (in pawns, e.g. 1.36)
        return (float)($result['eval'] ?? 0.0);
    }
}
