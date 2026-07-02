<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puzzles — Chess War</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- chessboardjs -->
    <link rel="stylesheet" href="css/chessboard-1.0.0.min.css">
    <script src="js/chessboard-1.0.0.min.js"></script>

    <!-- WukongJS chess engine -->
    <script src="js/wukong.js"></script>

    <link rel="stylesheet" href="css/puzzle.css">
</head>
<body class="puzzle-page">

    <!-- NAV -->
    <nav class="puzzle-nav">
        <a class="puzzle-nav-logo" href="/dashboard">Chess War</a>
        <a class="puzzle-nav-back" href="/dashboard">← Dashboard</a>
    </nav>

    <div class="puzzle-wrapper">

        <!-- SIDEBAR: Puzzle List -->
        <aside class="puzzle-sidebar">
            <div class="puzzle-sidebar-inner" id="puzzle-list">
                <h3 class="puzzle-sidebar-title">♟ Puzzles</h3>
                <p class="puzzle-sidebar-subtitle" id="puzzle-progress-text">Loading...</p>
                <!-- Dynamically populated -->
            </div>
        </aside>

        <!-- MAIN AREA -->
        <div class="puzzle-main" id="puzzle-main">
            <div class="puzzle-empty" id="puzzle-empty">
                <h2>Select a Puzzle</h2>
                <p>Choose a challenge from the sidebar to begin solving.</p>
            </div>

            <!-- Challenge Banner (hidden until puzzle selected) -->
            <div class="puzzle-challenge" id="puzzle-challenge" style="display: none;">
                <p class="puzzle-challenge-label">Puzzle Challenge</p>
                <h2 class="puzzle-challenge-title" id="puzzle-challenge-title">—</h2>
                <p class="puzzle-challenge-hint" id="puzzle-challenge-hint">—</p>
            </div>

            <!-- Board (hidden until puzzle selected) -->
            <div class="puzzle-board-shell" id="puzzle-board-shell" style="display: none;">
                <div id="puzzle-board" style="width: 400px; margin: 0 auto;"></div>
            </div>

            <!-- Feedback (hidden until puzzle selected) -->
            <div class="puzzle-feedback waiting" id="puzzle-feedback" style="display: none;">
                Your move...
            </div>

            <!-- Action Buttons (hidden until puzzle selected) -->
            <div class="puzzle-actions" id="puzzle-actions" style="display: none;">
                <button class="puzzle-btn puzzle-btn-ghost" id="puzzle-retry-btn">Retry</button>
                <button class="puzzle-btn puzzle-btn-primary" id="puzzle-next-btn">Next Puzzle →</button>
            </div>

            <!-- Progress Bar -->
            <div class="puzzle-progress" id="puzzle-progress-bar" style="display: none;">
                <span id="puzzle-progress-label">0 / 10 solved</span>
                <div class="puzzle-progress-bar-bg">
                    <div class="puzzle-progress-bar" id="puzzle-progress-fill" style="width: 0%;"></div>
                </div>
            </div>
        </div>
    </div>

<script>
// ═══════════════════════════════════════
// PUZZLE DATA — Pre-verified puzzles
// Each has a FEN, description, and solution line
// Solution format: [playerMove, opponentResponse, playerMove, ...]
// The final player move must deliver checkmate.
// ═══════════════════════════════════════

const PUZZLES = [
    {
        id: 'puzzle_1',
        name: 'Scholar\'s Mate',
        difficulty: 'easy',
        diffLabel: 'Mate in 1',
        fen: 'r1bqkb1r/pppp1ppp/2n2n2/4p2Q/2B1P3/8/PPPP1PPP/RNB1K1NR w KQkq - 4 4',
        description: 'White to move. Deliver checkmate in 1.',
        sideToMove: 'white',
        solution: ['h5f7'],
        movesLimit: 1
    },
    {
        id: 'puzzle_2',
        name: 'Back Rank Mate',
        difficulty: 'easy',
        diffLabel: 'Mate in 1',
        fen: '6k1/5ppp/8/8/8/8/8/4R1K1 w - - 0 1',
        description: 'White to move. Back rank mate in 1.',
        sideToMove: 'white',
        solution: ['e1e8'],
        movesLimit: 1
    },
    {
        id: 'puzzle_3',
        name: 'Queen Infiltration',
        difficulty: 'easy',
        diffLabel: 'Mate in 2',
        fen: 'r1b2r1k/pp3p1p/2n2P1p/4p2Q/8/8/PPP2PPP/R3K2R w KQ - 0 1',
        description: 'White to move. Find checkmate in 2.',
        sideToMove: 'white',
        solution: ['h5h6', 'h8g8', 'h6g7'],
        movesLimit: 2
    },
    {
        id: 'puzzle_4',
        name: 'Queen Mate',
        difficulty: 'easy',
        diffLabel: 'Mate in 1',
        fen: 'k7/8/2K5/8/8/8/1Q6/8 w - - 0 1',
        description: 'White to move. Deliver checkmate.',
        sideToMove: 'white',
        solution: ['b2b7'],
        movesLimit: 1
    },
    {
        id: 'puzzle_5',
        name: 'Bishop Mate',
        difficulty: 'easy',
        diffLabel: 'Mate in 1',
        fen: 'k7/P7/1K6/8/8/8/8/1B6 w - - 0 1',
        description: 'White to move. Checkmate in 1.',
        sideToMove: 'white',
        solution: ['b1e4'],
        movesLimit: 1
    },
    {
        id: 'puzzle_6',
        name: 'Rook Ladder',
        difficulty: 'medium',
        diffLabel: 'Mate in 2',
        fen: '4k3/8/8/8/8/8/1R6/R3K3 w - - 0 1',
        description: 'White to move. Checkmate in 2 moves.',
        sideToMove: 'white',
        solution: ['a1a7', 'e8d8', 'b2b8'],
        movesLimit: 2
    },
    {
        id: 'puzzle_7',
        name: 'Queen & King Dance',
        difficulty: 'medium',
        diffLabel: 'Mate in 2',
        fen: 'k7/8/1K6/8/8/8/8/1Q6 w - - 0 1',
        description: 'White to move. Deliver mate in 2.',
        sideToMove: 'white',
        solution: ['b1h7', 'a8b8', 'h7b7'],
        movesLimit: 2
    },
    {
        id: 'puzzle_8',
        name: 'Rook Roller',
        difficulty: 'medium',
        diffLabel: 'Mate in 2',
        fen: 'k7/p7/2K5/8/8/8/1R6/8 w - - 0 1',
        description: 'White to move. Find mate in 2.',
        sideToMove: 'white',
        solution: ['b2h2', 'a8b8', 'h2h8'],
        movesLimit: 2
    },
    {
        id: 'puzzle_9',
        name: 'Rook Rollercoaster',
        difficulty: 'hard',
        diffLabel: 'Mate in 3',
        fen: 'k7/8/2K5/8/8/8/8/B3R3 w - - 0 1',
        description: 'White to move. Deliver mate in 3.',
        sideToMove: 'white',
        solution: ['e1e8', 'a8a7', 'a1d4', 'a7a6', 'e8a8'],
        movesLimit: 3
    },
    {
        id: 'puzzle_10',
        name: 'Royal Zugzwang',
        difficulty: 'hard',
        diffLabel: 'Mate in 3',
        fen: 'k7/8/2K5/8/8/8/8/R7 w - - 0 1',
        description: 'White to move. Move the rook to mate in 3.',
        sideToMove: 'white',
        solution: ['a1h1', 'a8b8', 'h1h7', 'b8c8', 'h7h8'],
        movesLimit: 3
    }
];

// ═══════════════════════════════════════
// ENGINE & STATE
// ═══════════════════════════════════════

let puzzleEngine = null;
let puzzleBoard = null;
let currentPuzzle = null;
let currentStep = 0;        // index into solution array (0 = player's 1st move)
let puzzleAttempts = 0;
let playerMovesCount = 0;   // track player's moves in the current run
let solvedPuzzles = [];      // loaded from API
let puzzleLocked = false;    // prevent moves after solve / during opponent move

// ═══════════════════════════════════════
// INITIALIZATION
// ═══════════════════════════════════════

$(document).ready(function() {
    // Create engine (same as game page)
    puzzleEngine = new Engine(400, 'rgb(240, 217, 181)', 'rgb(181, 136, 99)', 'rgba(201, 168, 76, 0.45)');

    // Load solved puzzles from API
    $.ajax({
        url: '/api/puzzle/progress',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                solvedPuzzles = response.solved_puzzles || [];
            }
            renderPuzzleList();
        },
        error: function() {
            renderPuzzleList();
        }
    });
});

// ═══════════════════════════════════════
// RENDER PUZZLE LIST
// ═══════════════════════════════════════

function renderPuzzleList() {
    const list = $('#puzzle-list');
    // Keep title and subtitle
    list.find('.puzzle-item').remove();

    const solvedCount = solvedPuzzles.length;
    $('#puzzle-progress-text').text(`${solvedCount} / ${PUZZLES.length} solved`);

    PUZZLES.forEach((p, i) => {
        const isSolved = solvedPuzzles.includes(p.id);
        const isActive = currentPuzzle && currentPuzzle.id === p.id;

        const diffClass = p.difficulty;
        const checkMark = isSolved ? '<span class="puzzle-item-check">✓</span>' : '';

        const item = $(`
            <div class="puzzle-item ${isActive ? 'active' : ''} ${isSolved ? 'solved' : ''}" data-index="${i}">
                <span class="puzzle-item-num">${i + 1}</span>
                <div class="puzzle-item-info">
                    <span class="puzzle-item-name">${p.name}</span>
                    <span class="puzzle-item-diff ${diffClass}">${p.diffLabel}</span>
                </div>
                ${checkMark}
            </div>
        `);

        item.on('click', function() {
            loadPuzzle(i);
        });

        list.append(item);
    });

    // Update progress bar
    updateProgressBar();
}

function updateProgressBar() {
    const solvedCount = solvedPuzzles.length;
    const pct = Math.round((solvedCount / PUZZLES.length) * 100);
    $('#puzzle-progress-label').text(`${solvedCount} / ${PUZZLES.length} solved`);
    $('#puzzle-progress-fill').css('width', pct + '%');
    $('#puzzle-progress-bar').show();
}

// ═══════════════════════════════════════
// LOAD A PUZZLE
// ═══════════════════════════════════════

function loadPuzzle(index) {
    currentPuzzle = PUZZLES[index];
    currentStep = 0;
    puzzleAttempts = 0;
    playerMovesCount = 0;
    puzzleLocked = false;

    // Set engine position
    puzzleEngine.setBoard(currentPuzzle.fen);

    // Show UI
    $('#puzzle-empty').hide();
    $('#puzzle-challenge').show();
    $('#puzzle-board-shell').show();
    $('#puzzle-feedback').show();
    $('#puzzle-actions').show();

    // Update challenge banner
    $('#puzzle-challenge-title').text(currentPuzzle.diffLabel);
    $('#puzzle-challenge-hint').text(currentPuzzle.description);

    // Reset feedback
    setFeedback('waiting', 'Your move... 🤔');

    // Initialize / update board
    if (!puzzleBoard) {
        puzzleBoard = Chessboard('puzzle-board', {
            draggable: true,
            position: currentPuzzle.fen,
            onDrop: onPuzzleDrop,
            onMouseoverSquare: onPuzzleMouseover,
            onMouseoutSquare: onPuzzleMouseout,
            pieceTheme: 'img/chesspieces/wikipedia/{piece}.png'
        });
    } else {
        puzzleBoard.position(currentPuzzle.fen);
    }

    // Mark active in sidebar
    renderPuzzleList();
}

// ═══════════════════════════════════════
// BOARD INTERACTION
// ═══════════════════════════════════════

function onPuzzleMouseover(square) {
    if (puzzleLocked) return;
    // Show legal move hints
    const srcSq = square[0].charCodeAt() - 'a'.charCodeAt() + (8 - (square[1].charCodeAt() - '0'.charCodeAt())) * 16;
    const pc = puzzleEngine.getPiece(srcSq);
    if (pc === 0) return;

    const activeSide = puzzleEngine.getSide();
    const isPlayerPiece = (activeSide === 0 && pc >= 1 && pc <= 6) || (activeSide === 1 && pc >= 7 && pc <= 12);
    if (!isPlayerPiece) return;

    const legalMoves = puzzleEngine.generateLegalMoves();
    legalMoves.forEach(lm => {
        const mv = lm.move;
        if (puzzleEngine.getMoveSource(mv) === srcSq) {
            const tgtSq = puzzleEngine.getMoveTarget(mv);
            const tgtStr = puzzleEngine.squareToString(tgtSq);
            const tgtEl = $('.square-' + tgtStr);
            tgtEl.addClass('highlight-puzzle-hint');
        }
    });
}

function onPuzzleMouseout() {
    $('.square-55d63').removeClass('highlight-puzzle-hint highlight-puzzle-wrong');
}

function checkPuzzleStatus() {
    const legalMoves = puzzleEngine.generateLegalMoves();
    const side = puzzleEngine.getSide(); // 0 = white, 1 = black
    const inCheck = puzzleEngine.inCheck(side);

    if (legalMoves.length === 0) {
        if (inCheck) {
            if (side === 1) {
                puzzleSolved();
                return true;
            } else {
                setFeedback('incorrect', 'Checkmate! You lost. Try again! ❌');
                return true;
            }
        } else {
            setFeedback('incorrect', 'Draw by Stalemate. Try again! ⚠️');
            return true;
        }
    } else if (puzzleEngine.isMaterialDraw()) {
        setFeedback('incorrect', 'Draw by Insufficient Material. Try again! ⚠️');
        return true;
    } else if (puzzleEngine.isRepetition()) {
        setFeedback('incorrect', 'Draw by Repetition. Try again! ⚠️');
        return true;
    } else if (puzzleEngine.getFifty() >= 100) {
        setFeedback('incorrect', 'Draw by 50-move rule. Try again! ⚠️');
        return true;
    }
    return false;
}

function onPuzzleDrop(source, target) {
    if (puzzleLocked) return 'snapback';
    if (source === target) return 'snapback';

    const moveStr = source + target;

    // Check if promotion is needed (pawn reaching last rank)
    let fullMoveStr = moveStr;
    const srcSq = source[0].charCodeAt() - 'a'.charCodeAt() + (8 - (source[1].charCodeAt() - '0'.charCodeAt())) * 16;
    const pc = puzzleEngine.getPiece(srcSq);
    const tgtRank = target[1];
    if ((pc === 1 && tgtRank === '8') || (pc === 7 && tgtRank === '1')) {
        fullMoveStr = moveStr + 'q';
    }

    // Validate this is a legal move first
    const validMove = puzzleEngine.moveFromString(fullMoveStr);
    if (validMove === 0) return 'snapback';

    const legalMoves = puzzleEngine.generateLegalMoves();
    let isLegal = false;
    for (let i = 0; i < legalMoves.length; i++) {
        if (validMove === legalMoves[i].move) { isLegal = true; break; }
    }
    if (!isLegal) return 'snapback';

    // Increment attempts
    puzzleAttempts++;
    playerMovesCount++;

    // Make player's move on the engine
    puzzleEngine.makeMove(validMove);

    // Update board UI position
    setTimeout(function() {
        puzzleBoard.position(puzzleEngine.generateFen());
    }, 100);

    // Check if player's move solved the puzzle
    if (checkPuzzleStatus()) return;

    // Check if player has run out of moves
    if (playerMovesCount >= currentPuzzle.movesLimit) {
        setFeedback('incorrect', 'Failed to mate in ' + currentPuzzle.movesLimit + ' move(s). Try again! ❌');
        puzzleLocked = true;
        return;
    }

    // Check if we are on the solution path
    let onPath = false;
    if (currentStep < currentPuzzle.solution.length) {
        const expectedMove = currentPuzzle.solution[currentStep];
        const normalizedExpected = expectedMove.substring(0, 4);
        const normalizedPlayed = moveStr.substring(0, 4);
        if (normalizedPlayed === normalizedExpected) {
            onPath = true;
        }
    }

    if (onPath) {
        // Correct step!
        currentStep++;
        
        // If this was the last move in the solution, it should have been checkmate
        if (currentStep >= currentPuzzle.solution.length) {
            puzzleSolved();
            return;
        }

        // Show feedback and wait for predefined opponent move
        setFeedback('correct', 'Correct move! Opponent responding...');
        puzzleLocked = true;

        setTimeout(function() {
            const opponentMoveStr = currentPuzzle.solution[currentStep];
            const oppValidMove = puzzleEngine.moveFromString(opponentMoveStr);
            if (oppValidMove !== 0) {
                puzzleEngine.makeMove(oppValidMove);
                puzzleBoard.position(puzzleEngine.generateFen());
                currentStep++;
            }
            puzzleLocked = false;
            setFeedback('waiting', 'Your move... 🤔');
            
            // Check if opponent's move ended the game
            checkPuzzleStatus();
        }, 800);
    } else {
        // Sub-optimal or wrong move, but we let it play!
        currentStep = 999; // Off path
        setFeedback('incorrect', 'Sub-optimal move. Opponent thinking...');
        puzzleLocked = true;

        setTimeout(function() {
            // Use engine to calculate the best move dynamically
            const bestMove = puzzleEngine.searchTime(800);
            if (bestMove !== 0) {
                puzzleEngine.makeMove(bestMove);
                puzzleBoard.position(puzzleEngine.generateFen());
            }
            puzzleLocked = false;
            setFeedback('waiting', 'Your move... 🤔');

            // Check if opponent's move ended the game
            checkPuzzleStatus();
        }, 800);
    }
}

// ═══════════════════════════════════════
// PUZZLE SOLVED
// ═══════════════════════════════════════

function puzzleSolved() {
    puzzleLocked = true;
    setFeedback('solved', '🎉 Puzzle Solved! Well done!');

    // Record to API if not already solved
    if (!solvedPuzzles.includes(currentPuzzle.id)) {
        solvedPuzzles.push(currentPuzzle.id);

        $.ajax({
            url: '/api/puzzle/complete',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                puzzle_id: currentPuzzle.id,
                attempts: puzzleAttempts
            },
            success: function(response) {
                console.log('Puzzle completion saved:', response);
            },
            error: function(xhr) {
                console.error('Failed to save puzzle completion:', xhr.responseText);
            }
        });
    }

    // Update sidebar
    renderPuzzleList();
}

// ═══════════════════════════════════════
// UI HELPERS
// ═══════════════════════════════════════

function setFeedback(type, message) {
    const el = $('#puzzle-feedback');
    el.removeClass('waiting correct incorrect solved animate');
    el.addClass(type);
    el.text(message);

    // Trigger animation
    void el[0].offsetWidth;
    el.addClass('animate');
}

// ═══════════════════════════════════════
// BUTTON HANDLERS
// ═══════════════════════════════════════

$('#puzzle-retry-btn').on('click', function() {
    if (!currentPuzzle) return;
    const idx = PUZZLES.findIndex(p => p.id === currentPuzzle.id);
    if (idx >= 0) loadPuzzle(idx);
});

$('#puzzle-next-btn').on('click', function() {
    if (!currentPuzzle) { loadPuzzle(0); return; }
    const idx = PUZZLES.findIndex(p => p.id === currentPuzzle.id);
    const nextIdx = (idx + 1) % PUZZLES.length;
    loadPuzzle(nextIdx);
});

</script>
</body>
</html>
