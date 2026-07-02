<html>
  <head>
    <title>WukongJS + Chessboardjs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    
    <!-- chessboardjs -->
    <link rel="stylesheet" href="css/chessboard-1.0.0.min.css">
    <script src="js/chessboard-1.0.0.min.js"></script>
    
    <!-- WukongJS chess engine -->
    <script src="js/wukong.js"></script>

    <style>
      :root {
        --game-bg: #09111f;
        --game-bg-alt: #111c2d;
        --game-panel: rgba(10, 16, 28, 0.82);
        --game-border: rgba(201, 168, 76, 0.28);
        --game-gold: #c9a84c;
        --game-text: #f4efe3;
      }

      * {
        box-sizing: border-box;
      }

      html, body {
        min-height: 100%;
      }

      body.game-page {
        margin: 0;
        font-family: 'Jost', sans-serif;
        color: var(--game-text);
        background:
          radial-gradient(circle at 20% 20%, rgba(201, 168, 76, 0.18), transparent 30%),
          radial-gradient(circle at 85% 10%, rgba(105, 131, 191, 0.16), transparent 24%),
          linear-gradient(180deg, var(--game-bg) 0%, var(--game-bg-alt) 48%, #060b14 100%);
        overflow-x: hidden;
      }

      body.game-page::before {
        content: '';
        position: fixed;
        inset: 0;
        pointer-events: none;
        opacity: 0.15;
        background-image:
          linear-gradient(45deg, rgba(255,255,255,0.06) 25%, transparent 25%, transparent 75%, rgba(255,255,255,0.06) 75%, rgba(255,255,255,0.06)),
          linear-gradient(45deg, rgba(255,255,255,0.06) 25%, transparent 25%, transparent 75%, rgba(255,255,255,0.06) 75%, rgba(255,255,255,0.06));
        background-position: 0 0, 18px 18px;
        background-size: 36px 36px;
      }

      body.game-page::after {
        content: '';
        position: fixed;
        inset: auto -12% -18% auto;
        width: 360px;
        height: 360px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(201, 168, 76, 0.22), transparent 68%);
        filter: blur(10px);
        pointer-events: none;
      }

      .game-scene {
        position: relative;
        min-height: 100vh;
        padding: 40px 16px 28px;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .game-scene::before,
      .game-scene::after {
        content: '';
        position: absolute;
        width: 180px;
        height: 180px;
        border: 1px solid rgba(201, 168, 76, 0.18);
        border-radius: 28px;
        transform: rotate(12deg);
        pointer-events: none;
      }

      .game-scene::before {
        top: 36px;
        left: 18px;
        box-shadow: 0 0 0 1px rgba(201, 168, 76, 0.08) inset;
      }

      .game-scene::after {
        right: 24px;
        bottom: 34px;
        transform: rotate(-10deg);
      }

      .game-shell {
        position: relative;
        width: min(820px, 100%);
        padding: 30px 22px 24px;
        border: 1px solid var(--game-border);
        border-radius: 30px;
        background: var(--game-panel);
        box-shadow: 0 22px 60px rgba(0, 0, 0, 0.45);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
      }

      .game-shell::before {
        content: '';
        position: absolute;
        inset: 12px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 22px;
        pointer-events: none;
      }

      .game-kicker {
        margin: 0 0 6px;
        letter-spacing: 0.24em;
        text-transform: uppercase;
        font-size: 0.74rem;
        color: rgba(201, 168, 76, 0.88);
      }

      .game-title {
        margin: 0;
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2rem, 4vw, 3rem);
        line-height: 0.95;
        color: #fff7e4;
      }

      .game-subtitle {
        margin: 10px auto 0;
        max-width: 520px;
        color: rgba(244, 239, 227, 0.74);
      }

      .power-panel {
        width: min(640px, 100%);
        margin: 22px auto 10px;
        padding: 16px;
        border: 1px solid rgba(201, 168, 76, 0.18);
        border-radius: 22px;
        background: rgba(6, 10, 18, 0.55);
        box-shadow: 0 14px 32px rgba(0, 0, 0, 0.22);
      }

      .power-panel__header {
        margin-bottom: 12px;
      }

      .power-panel__label {
        margin: 0;
        font-size: 0.74rem;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: rgba(201, 168, 76, 0.82);
      }

      .power-panel__title {
        margin: 4px 0 0;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.55rem;
        line-height: 1;
        color: #fff7e4;
      }

      .power-panel__hint {
        margin: 6px 0 0;
        color: rgba(244, 239, 227, 0.72);
        font-size: 0.95rem;
      }

      .power-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
      }

      .power-card {
        position: relative;
        display: block;
        margin: 0;
        padding: 14px 14px 13px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 18px;
        background:
          linear-gradient(180deg, rgba(255,255,255,0.05), rgba(255,255,255,0.02)),
          rgba(14, 21, 34, 0.92);
        color: var(--game-text);
        text-align: left;
        cursor: pointer;
        transition: transform 160ms ease, border-color 160ms ease, box-shadow 160ms ease, background 160ms ease;
      }

      .power-card:hover {
        transform: translateY(-2px);
        border-color: rgba(201, 168, 76, 0.32);
        box-shadow: 0 14px 26px rgba(0, 0, 0, 0.24);
      }

      .power-card.active {
        border-color: rgba(201, 168, 76, 0.75);
        background:
          linear-gradient(180deg, rgba(201, 168, 76, 0.18), rgba(201, 168, 76, 0.05)),
          rgba(14, 21, 34, 0.96);
        box-shadow: 0 0 0 1px rgba(201, 168, 76, 0.18) inset, 0 18px 34px rgba(0, 0, 0, 0.28);
      }

      .power-card__radio {
        position: absolute;
        opacity: 0;
        pointer-events: none;
      }

      .power-card__badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 54px;
        padding: 0.2rem 0.55rem;
        border-radius: 999px;
        font-size: 0.7rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #111;
        background: var(--game-gold);
      }

      .power-card__name {
        display: block;
        margin-top: 12px;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.6rem;
        line-height: 1;
        color: #fff7e4;
      }

      .power-card__desc {
        display: block;
        margin-top: 8px;
        color: rgba(244, 239, 227, 0.72);
        font-size: 0.92rem;
        line-height: 1.45;
      }

      .power-state {
        margin-top: 10px;
        color: rgba(244, 239, 227, 0.62);
        font-size: 0.9rem;
      }

      .power-state strong {
        color: #fff7e4;
      }

      #chessboard {
        width: min(400px, 100%);
        margin: 26px auto 14px;
        border: 1px solid rgba(201, 168, 76, 0.3);
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
      }

      .game-controls {
        width: min(427px, 100%);
        margin: 0 auto;
      }

      .game-controls .btn {
        border-radius: 999px;
        padding: 0.45rem 1rem;
        color: #f5f1e8;
        border-color: rgba(201, 168, 76, 0.35);
      }

      .game-controls .btn:hover,
      .game-controls .btn:focus {
        color: #111;
        background: var(--game-gold);
        border-color: var(--game-gold);
        box-shadow: none;
      }

      .game-controls .btn-group {
        gap: 0.5rem;
        flex-wrap: wrap;
        justify-content: center;
      }

      .game-controls .btn-group > .btn {
        flex: 1 1 90px;
      }

      @media (max-width: 768px) {
        .power-grid {
          grid-template-columns: repeat(2, minmax(0, 1fr));
        }
      }

      @media (max-width: 576px) {
        .game-scene {
          padding: 20px 12px;
        }

        .game-shell {
          padding: 22px 14px 18px;
          border-radius: 24px;
        }

        .game-controls .btn-group > .btn {
          flex-basis: calc(50% - 0.5rem);
        }

        .power-grid {
          grid-template-columns: 1fr;
        }
      }

      .power-card.mystery {
        border-color: rgba(201, 168, 76, 0.45);
        background: linear-gradient(135deg, rgba(16, 26, 43, 0.95) 0%, rgba(8, 14, 24, 0.98) 100%);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      }
      
      .power-card.mystery:hover {
        transform: translateY(-4px);
        border-color: var(--game-gold);
        box-shadow: 0 12px 28px rgba(201, 168, 76, 0.25);
      }

      .power-card.revealed {
        animation: cardFlip 0.5s ease-out;
      }

      @keyframes cardFlip {
        0% { transform: scale(0.9) rotateY(90deg); opacity: 0; }
        100% { transform: scale(1) rotateY(0deg); opacity: 1; }
      }

      /* Square highlight guides for valid moves */
      .square-55d63.highlight-hint::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: rgba(201, 168, 76, 0.65);
        pointer-events: none;
        z-index: 99;
        box-shadow: 0 0 8px rgba(201, 168, 76, 0.4);
      }

      /* Capture guide (ring surrounding piece) */
      .square-55d63.highlight-hint.has-piece::after {
        width: 84%;
        height: 84%;
        border-radius: 50%;
        border: 4px solid rgba(201, 168, 76, 0.8);
        background: transparent;
        box-shadow: 0 0 10px rgba(201, 168, 76, 0.3);
      }

      /* Highlight for selected square */
      .square-55d63.selected-square {
        box-shadow: inset 0 0 3px 3px var(--game-gold) !important;
      }

      .power-card.mystery {
        border: 1px dashed rgba(201, 168, 76, 0.4) !important;
        background: radial-gradient(circle at center, rgba(201, 168, 76, 0.15) 0%, rgba(9, 17, 31, 0.95) 100%) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4) !important;
      }
      .power-card.mystery .power-card__badge {
        background: linear-gradient(135deg, #e2c97e 0%, #c9a84c 100%) !important;
        color: #0c0f16 !important;
        font-weight: 600 !important;
      }
      .power-card.mystery .power-card__name {
        color: #e2c97e !important;
        font-size: 2.2rem !important;
        text-align: center !important;
        margin: 18px 0 !important;
      }
      .power-card.mystery .power-card__desc {
        text-align: center !important;
        color: rgba(244, 239, 227, 0.5) !important;
        font-size: 0.82rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.08em !important;
      }

      .shuffle-status-banner {
        font-size: 0.85rem;
        color: var(--game-gold);
        letter-spacing: 0.15em;
        text-transform: uppercase;
        margin-top: 15px;
        font-weight: 500;
      }

      .game-shell-compact {
        width: min(440px, 100%) !important;
        padding: 24px 22px !important;
        margin: 0 !important;
      }

      .game-arena-grid {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 24px;
        margin: 15px auto;
        width: 100%;
        max-width: 440px;
      }

    </style>
    
  </head>
  <body class="game-page">
    <div class="col mt-4 game-scene">
      <div class="row justify-content-center" style="width: 100%; max-width: 900px; margin: 0 auto;">
        
        <!-- ==================== PRE-GAME AREA (Header + Cards) ==================== -->
        <div align="center" class="col-12 game-shell" id="game-pre-area">
          <p class="game-kicker">Chess War</p>
          <h1 class="game-title">Battle Arena</h1>
          <p class="game-subtitle">Choose one user power before the match starts. The bot stays standard.</p>

          <div class="power-panel" id="power-panel">
            <div class="power-panel__header">
              <p class="power-panel__label">User privilege</p>
              <h2 class="power-panel__title">Select 1 Active Power</h2>
              <p class="power-panel__hint">Choose one card to reveal your secret power. The bot stays standard.</p>
            </div>

            <div class="power-grid" id="power-grid" role="radiogroup" aria-label="Choose active power">
              <!-- Dynamically populated and shuffled mystery cards -->
            </div>

            <div id="shuffle-status" class="shuffle-status-banner">
              Select a card to draw your power.
            </div>
          </div>
        </div>

        <!-- ==================== ACTIVE GAMEPLAY AREA ==================== -->
        <div class="col-12" id="game-arena-wrapper" style="display: none; text-align: center; width: 100%;">
          
          <!-- 1. Active Power Header (Outside Board Box) -->
          <div id="active-power-header" style="display: none; margin-bottom: 24px; padding: 12px 24px; border-radius: 16px; background: rgba(201, 168, 76, 0.08); border: 1px solid rgba(201, 168, 76, 0.18); text-align: center; max-width: 400px; margin-left: auto; margin-right: auto;">
              <span style="font-size: 0.75rem; letter-spacing: 0.22em; text-transform: uppercase; color: var(--game-gold); display: block; margin-bottom: 4px;">Active Power</span>
              <h2 id="active-power-title" style="font-family: 'Cormorant Garamond', serif; font-size: 2.1rem; color: #fff7e4; margin: 0; line-height: 1.1;">-</h2>
              <p id="active-power-desc" style="color: rgba(244, 239, 227, 0.74); font-size: 0.95rem; margin: 6px 0 0;"></p>
              <div id="king-lives-indicator" style="display: none; margin-top: 8px; font-size: 0.9rem; color: #ff5252; font-weight: 500;"></div>
          </div>

          <!-- 3. Side-by-Side Flex Layout (Board Box) -->
          <div class="game-arena-grid">
              
              <!-- Left side: The Board Box (Compact game-shell) -->
              <div class="game-shell game-shell-compact">
                  <!-- chessboard -->
                  <div id="chessboard" style="width: 400px;"></div>
                  
                  <!-- controls inside board box -->
                  <div class="row game-controls mt-4">
                      @if(auth()->user()->is_admin || auth()->user()->hasRole('super_admin'))
                      <div class="col btn-group">
                        <button id="newgame" class="btn btn-outline-secondary">New</button>
                        <button id="makemove" class="btn btn-outline-secondary">Move</button>
                        <button id="takeback" class="btn btn-outline-secondary">Undo</button>
                        <button id="flipboard" class="btn btn-outline-secondary">Flip</button>
                      </div>
                      @endif

                      <div class="col btn-group mt-3" style="width: 100%; display: flex; justify-content: center; gap: 0.5rem;">
                        <button id="save-game-btn" class="btn btn-outline-secondary" style="background: rgba(40, 167, 69, 0.12); border-color: rgba(40, 167, 69, 0.35); color: #fff;">Save Game</button>
                        <a href="/dashboard" class="btn btn-outline-secondary">Exit to Dashboard</a>
                      </div>
                  </div>
              </div>

          </div>

        </div>

      </div>
    </div>    
  </body>
</html>

<script>
  window.isAdmin = {{ (auth()->user()?->is_admin || auth()->user()?->hasRole('super_admin')) ? 'true' : 'false' }};
  let selectedSquare = null;

  function removeHighlights() {
    $('.square-55d63').removeClass('highlight-hint has-piece selected-square');
  }

  function highlightSquareMoves(square) {
    removeHighlights();
    
    if (!window.powerSelected) return;
    
    // Convert algebraic (e.g. 'e2') to 0x88 index
    const srcSq = square[0].charCodeAt() - "a".charCodeAt() + (8 - (square[1].charCodeAt() - "0".charCodeAt())) * 16;
    const pc = engine.getPiece(srcSq);
    if (pc === 0) return;
    
    const activeSide = engine.getSide();
    const isPlayerPiece = (activeSide === 0 && pc >= 1 && pc <= 6) || (activeSide === 1 && pc >= 7 && pc <= 12);
    if (!isPlayerPiece) return;
    
    const legalMoves = engine.generateLegalMoves();
    legalMoves.forEach(lm => {
      const mv = lm.move;
      if (engine.getMoveSource(mv) === srcSq) {
        const tgtSq = engine.getMoveTarget(mv);
        const tgtStr = engine.squareToString(tgtSq);
        
        const tgtEl = $('.square-' + tgtStr);
        tgtEl.addClass('highlight-hint');
        
        if (engine.getPiece(tgtSq) !== 0) {
          tgtEl.addClass('has-piece');
        }
      }
    });
  }

  function onMouseoverSquare (square, piece) {
    if (selectedSquare) return;
    highlightSquareMoves(square);
  }

  function onMouseoutSquare (square, piece) {
    if (selectedSquare) return;
    removeHighlights();
  }

  /****************************\
   ============================
   
        USER INPUT HANDLERS

   ============================              
  \****************************/
  
  
  let gameStartTime = null;

  function startTimer() {
    gameStartTime = Date.now();
  }

  function saveMatchResult(isWin, duration) {
    $.ajax({
      url: '/matches',
      type: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        is_win: isWin ? 1 : 0,
        total_time: duration,
        power_type: window.activePlayerPower
      },
      success: function(response) {
        console.log('Match history saved successfully:', response);
      },
      error: function(xhr) {
        console.error('Failed to save match history:', xhr.responseText);
      }
    });
  }

  function checkGameStatus() {
    if (!window.engine) return false;
    
    const legalMoves = engine.generateLegalMoves();
    const side = engine.getSide(); // 0 = white, 1 = black
    const inCheck = engine.inCheck(side);
    
    let isGameOver = false;
    let userWon = false;
    let draw = false;
    let reason = "";

    if (legalMoves.length === 0) {
      isGameOver = true;
      if (inCheck) {
        // Checkmate! The side to move has no moves and is in check.
        if (side === 0) {
          // User is checkmated (user lost)
          userWon = false;
          reason = "Checkmate! Bot wins.";
        } else {
          // Bot is checkmated (user won)
          userWon = true;
          reason = "Checkmate! You win!";
        }
      } else {
        // Stalemate
        draw = true;
        reason = "Draw by Stalemate.";
      }
    } else if (engine.isMaterialDraw()) {
      isGameOver = true;
      draw = true;
      reason = "Draw by Insufficient Material.";
    } else if (engine.isRepetition()) {
      isGameOver = true;
      draw = true;
      reason = "Draw by Repetition.";
    } else if (engine.getFifty() >= 100) {
      isGameOver = true;
      draw = true;
      reason = "Draw by 50-move rule.";
    }

    if (isGameOver) {
      const endTime = Date.now();
      const duration = gameStartTime ? Math.round((endTime - gameStartTime) / 1000) : 0;
      
      alert("Game Over: " + reason);
      
      // Save to database
      saveMatchResult(userWon && !draw, duration);
      return true;
    }
    return false;
  }

  // handle new game button click
  $('#newgame').on('click', function() {
    // reset engine
    engine.setBoard(engine.START_FEN);
    
    // Reset power selection
    window.powerSelected = false;
    window.activePlayerPower = '';
    window.moveCounter = 0;
    


    // Hide gameplay arena wrapper
    $('#game-arena-wrapper').hide();
    $('#active-power-header').hide();
    
    // Show pre-game area
    $('#game-pre-area').fadeIn(300);
    $('#power-panel').show();

    // Start shuffling animation again!
    runShufflingAnimation();
  });

  window.powerSelected = false;
  window.isShuffling = true;
  window.currentShuffledPowers = [];

  const powersList = [
    {
      value: 'confused_pawn',
      name: 'Confused Pawn',
      desc: 'Pawn can move backward too, making file control much more chaotic.'
    },
    {
      value: 'blink_knight',
      name: 'Blink Knight',
      desc: 'Knight jumps with a longer reach, doubling the usual movement patterns.'
    },
    {
      value: 'super_rook',
      name: 'Super Rook',
      desc: 'Rook keeps straight lines and gains one-step forward diagonals.'
    },
    {
      value: 'undying_king',
      name: 'Undying King',
      desc: 'King has 2 lives. The enemy piece that captures the King dies, and the King is restored.'
    },
    {
      value: 'omni_queen',
      name: 'Omni Queen',
      desc: 'Queen can move like a Queen and jump like a Knight.'
    },
    {
      value: 'grey_bishop',
      name: 'Grey Bishop',
      desc: 'Bishop can shift 1 step left/right (changing square color) and then slide diagonally.'
    }
  ];

  let lastKingLives = 2;
  function updateKingLivesUI() {
    if (window.engine && typeof window.engine.getKingLives === 'function') {
      const lives = window.engine.getKingLives();
      if (window.activePlayerPower === 'undying_king') {
        $('#king-lives-indicator').show().text(`Lives remaining: ${lives} / 2`);
        if (lives === 1 && lastKingLives === 2) {
          alert("Your Undying King lost a life! The attacking piece has been destroyed.");
        }
      } else {
        $('#king-lives-indicator').hide();
      }
      lastKingLives = lives;
    }
  }

  // Shuffle function
  function shuffle(array) {
    let currentIndex = array.length, randomIndex;
    while (currentIndex != 0) {
      randomIndex = Math.floor(Math.random() * currentIndex);
      currentIndex--;
      [array[currentIndex], array[randomIndex]] = [array[randomIndex], array[currentIndex]];
    }
    return array;
  }

  function runShufflingAnimation() {
    window.isShuffling = false;
    const grid = $('#power-grid');
    grid.empty();
    
    if (window.isAdmin) {
      // Admin flow: show all 6 powers with their actual names and descriptions
      window.currentShuffledPowers = [...powersList];
      
      window.currentShuffledPowers.forEach((power, index) => {
        grid.append(`
          <label class="power-card" data-power="${power.value}" data-index="${index}">
            <input class="power-card__radio" type="radio" name="active_power" value="${power.value}" style="position: absolute; opacity: 0; pointer-events: none;">
            <span class="power-card__badge" style="background: linear-gradient(135deg, #e2c97e 0%, #c9a84c 100%) !important; color: #0c0f16 !important; font-weight: 600 !important;">Power</span>
            <span class="power-card__name" style="margin-top: 12px !important; font-family: 'Cormorant Garamond', serif !important; font-size: 1.6rem !important; line-height: 1 !important; color: #fff7e4 !important; text-align: left !important; font-weight: normal !important;">${power.name}</span>
            <span class="power-card__desc" style="margin-top: 8px !important; color: rgba(244, 239, 227, 0.72) !important; font-size: 0.92rem !important; line-height: 1.45 !important; text-transform: none !important; letter-spacing: normal !important; text-align: left !important;">${power.desc}</span>
          </label>
        `);
      });
      
      $('#shuffle-status').text('Admin Privilege: Choose any power to activate.');
    } else {
      // Normal user flow: show 3 secret cards
      const shuffled = shuffle([...powersList]);
      window.currentShuffledPowers = shuffled.slice(0, 3);
      
      const romanNumerals = ['I', 'II', 'III'];
      
      window.currentShuffledPowers.forEach((power, index) => {
        grid.append(`
          <label class="power-card mystery" data-power="${power.value}" data-index="${index}">
            <input class="power-card__radio" type="radio" name="active_power" value="${power.value}" style="position: absolute; opacity: 0; pointer-events: none;">
            <span class="power-card__badge">Secret</span>
            <span class="power-card__name">CARD ${romanNumerals[index]}</span>
            <span class="power-card__desc">Select to reveal</span>
          </label>
        `);
      });

      $('#shuffle-status').text('Choose one card to select your power.');
    }
  }

  $('#power-grid').on('click', '.power-card', function() {
    if (window.isShuffling) return; // Prevent selection while shuffling
    if (window.powerSelected) return; // Only allow selecting once

    window.powerSelected = true;
    startTimer(); // Start the game timer
    
    const selectedCard = $(this);
    const chosenIndex = selectedCard.data('index');
    const power = window.currentShuffledPowers[chosenIndex];
    if (!power) return;

    window.activePlayerPower = power.value;
    if (window.engine && typeof window.engine.setPlayerPower === 'function') {
      window.engine.setPlayerPower(power.value);
    }
    
    lastKingLives = 2;

    // Populate active header details
    $('#active-power-title').text(power.name);
    $('#active-power-desc').text(power.desc);
    updateKingLivesUI();

    // Hide pre-game area and show gameplay arena wrapper
    $('#game-pre-area').fadeOut(300, function() {
      $('#active-power-header').show();
      $('#game-arena-wrapper').fadeIn(300, function() {
        if (!board) {
          board = Chessboard('chessboard', config);
        } else {
          board.position('start');
        }
        engine.setBoard(engine.START_FEN);
      });
    });
  });
  
  // handle make move button click
  $('#makemove').on('click', function() {
    // make computer move
    makeMove();
  });
  
  // handle take back button click
  $('#takeback').on('click', function() {
    // take move back
    engine.takeBack();
    
    // update board position
    board.position(engine.generateFen());
  });
  
  // handle flip board button click
  $('#flipboard').on('click', function() {
    // flip board
    board.flip();
  });
  
  // handle select move time option
  $('#move_time').on('change', function() {
    // disable fixed depth
    $('#fixed_depth').val('0');
  });
  
  // handle select fixed depth option
  $('#fixed_depth').on('change', function() {
    // disable fixed depth
    $('#move_time').val('0');
  });
  
  // handle set FEN button click
  $('#set_fen').on('click', function() {
    // set user FEN
    
    // FEN parsed
    if (game.load($('#fen').val()))
      // set board position
      board.position(game.fen());
    
    // FEN is not parsed
    else
      alert('Illegal FEN!');
  });
  
  // prevent scrolling on touch devices
  $('#chessboard').on('scroll touchmove touchend touchstart contextmenu', function(e) {
    e.preventDefault();
  });


  /****************************\
   ============================
   
      USER CONTROL FUNCTIONS

   ============================              
  \****************************/

  // make engine move
  function makeMove() {
    // make computer move
    setTimeout(function() {
      let bestMove = engine.searchTime(1000); // search for 1 second
      engine.makeMove(bestMove);
      
      // Update King Lives UI if Undying King triggered
      updateKingLivesUI();
      
      let fen = engine.generateFen();
      board.position(fen);

      // Check if engine's move ended the game
      checkGameStatus();
    }, 300);
  }



  // on dropping piece
  function onDrop (source, target) {
    if (source === target) return 'snapback';

    removeHighlights();
    selectedSquare = null;

    let promotedPiece = (engine.getSide() ? (5 + 6): 5); // queen promotion only for now
    let move = source + target + engine.promotedToString(promotedPiece);
    let validMove = engine.moveFromString(move);

    console.log('user move', promotedPiece);
    
    // invalid move
    if (validMove == 0) return 'snapback';
    
    let legalMoves = engine.generateLegalMoves();
    let isLegal = 0;
    
    for (let count = 0; count < legalMoves.length; count++) {
      if (validMove == legalMoves[count].move) isLegal = 1;  
    }
    
    // illegal move
    if (isLegal == 0) return 'snapback';
    
    // make user move
    engine.makeMove(validMove);    
    engine.printBoard();

    // Check if user's move ended the game
    if (checkGameStatus()) return;
    
    // make engine move
    makeMove();
    
    // TODO: update game status
    // isGameOver();
  }

  // update the board position after the piece snap
  // for castling, en passant, pawn promotion
  function onSnapEnd () {
    board.position(engine.generateFen());
  }

  
  /****************************\
   ============================
   
           MAIN DRIVER

   ============================              
  \****************************/

  // on drag start
  function onDragStart (source, piece, position, orientation) {
    if (!window.powerSelected) {
      alert("Please select a mystery card first to unlock your secret power!");
      return false;
    }

    // Only allow dragging if it is White's turn (user's turn) and the piece is White
    if (engine.getSide() !== 0 || piece.search(/^w/) === -1) {
      return false;
    }

    selectedSquare = source;
    highlightSquareMoves(source);
    $('.square-' + source).addClass('selected-square');
  }

  // chess board configuration
  var config = {
    draggable: true,
    position: 'start',
    onDragStart: onDragStart,
    onDrop: onDrop,
    onSnapEnd: onSnapEnd,
    onMouseoverSquare: onMouseoverSquare,
    onMouseoutSquare: onMouseoutSquare
  }
  
  // create chess board widget instance
  // create chess board widget instance
  let board = null;

  // Bind pointerdown event for valid move highlights and click-to-move
  $('#chessboard').on('pointerdown', '.square-55d63', function(e) {
    if (!window.powerSelected) return;
    if (!board) return;
    
    // Only allow moves if it is White's turn (user's turn)
    if (engine.getSide() !== 0) return;
    
    const classList = $(this).attr('class').split(/\s+/);
    const squareClass = classList.find(c => c.startsWith('square-') && c !== 'square-55d63');
    if (!squareClass) return;
    
    const square = squareClass.substring(7); // e.g. 'e2'
    
    // If a piece is already selected, try to move to the clicked square
    if (selectedSquare && selectedSquare !== square) {
      let promotedPiece = (engine.getSide() ? (5 + 6): 5); // queen promotion only for now
      let move = selectedSquare + square + engine.promotedToString(promotedPiece);
      let validMove = engine.moveFromString(move);
      
      let isLegal = 0;
      if (validMove !== 0) {
        let legalMoves = engine.generateLegalMoves();
        for (let count = 0; count < legalMoves.length; count++) {
          if (validMove == legalMoves[count].move) {
            isLegal = 1;
            break;
          }
        }
      }
      
      if (isLegal) {
        // Make user move in engine
        engine.makeMove(validMove);    
        engine.printBoard();
        
        // Update UI board position
        board.position(engine.generateFen());

        selectedSquare = null;
        removeHighlights();

        // Check if user's move ended the game
        if (checkGameStatus()) return;
        
        // Make engine move
        makeMove();
        return;
      }
    }
    
    const srcSq = square[0].charCodeAt() - "a".charCodeAt() + (8 - (square[1].charCodeAt() - "0".charCodeAt())) * 16;
    const pc = engine.getPiece(srcSq);
    const activeSide = engine.getSide();
    const isPlayerPiece = (activeSide === 0 && pc >= 1 && pc <= 6) || (activeSide === 1 && pc >= 7 && pc <= 12);
    
    if (isPlayerPiece) {
      if (selectedSquare === square) {
        selectedSquare = null;
        removeHighlights();
      } else {
        selectedSquare = square;
        highlightSquareMoves(square);
        $('.square-' + square).addClass('selected-square');
      }
    } else {
      selectedSquare = null;
      removeHighlights();
    }
  });
  
  // create WukongJS engine instance
  const engine = new Engine();
  window.engine = engine;
  // Initialize with no power active until one is selected
  window.activePlayerPower = '';

  // Save Game Event Listener
  $('#save-game-btn').on('click', function() {
    if (!window.powerSelected) {
      alert('Please select a card first to start the game before saving.');
      return;
    }
    
    const lives = (engine.getKingLives && typeof engine.getKingLives === 'function') ? engine.getKingLives() : 2;
    const currentFen = engine.generateFen() + ' KQkq - 0 1 ' + lives;
    const currentPower = window.activePlayerPower;
    
    $.ajax({
      url: '/api/game/save',
      type: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        fen: currentFen,
        power_type: currentPower
      },
      success: function(response) {
        alert('Game state saved successfully! You can resume this match later from the dashboard.');
      },
      error: function(xhr) {
        alert('Failed to save game state: ' + xhr.responseText);
      }
    });
  });

  // Resume Game Logic on load
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('resume') === 'true') {
    $.ajax({
      url: '/api/game/resume',
      type: 'GET',
      success: function(response) {
        if (response.success && response.saved_game) {
          const savedGame = response.saved_game;
          
          // Set active player power
          window.activePlayerPower = savedGame.power_type;
          window.powerSelected = true;
          
          if (typeof engine.setPlayerPower === 'function') {
            engine.setPlayerPower(savedGame.power_type);
          }
          
          const power = powersList.find(p => p.value === savedGame.power_type);
          const powerName = power ? power.name : 'None';
          const powerDesc = power ? power.desc : '';
          
          // Populate active power header
          $('#active-power-title').text(powerName);
          $('#active-power-desc').text(powerDesc);
          
          const lives = (engine.getKingLives && typeof engine.getKingLives === 'function') ? engine.getKingLives() : 2;
          lastKingLives = lives;
          updateKingLivesUI();
          
          // Hide pre-game area immediately
          $('#game-pre-area').hide();
          
          // Show active power header and gameplay arena wrapper
          $('#active-power-header').show();
          $('#game-arena-wrapper').show();
          
          // Set board FEN in engine and board UI
          let fenToLoad = savedGame.fen;
          if (fenToLoad.split(' ').length < 6) {
            fenToLoad += ' KQkq - 0 1';
          }
          engine.setBoard(fenToLoad);
          
          // Initialize board widget since container is now visible
          board = Chessboard('chessboard', config);
          board.position(fenToLoad);
          
          // Start the play duration timer
          startTimer();
        }
      },
      error: function(xhr) {
        console.error('Failed to resume game:', xhr.responseText);
      }
    });
  } else {
    // New game flow
    runShufflingAnimation();
  }
</script>
