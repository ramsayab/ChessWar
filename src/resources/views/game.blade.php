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
    </style>
    
  </head>
  <body class="game-page">
    <div class="col mt-5 game-scene">
      <div class="row">
        <div align="center" class="col game-shell">
          <p class="game-kicker">Chess War</p>
          <h1 class="game-title">Battle Arena</h1>
          <p class="game-subtitle">Choose one user power before the match starts. The bot stays standard.</p>

          <div class="power-panel">
            <div class="power-panel__header">
              <p class="power-panel__label">User privilege</p>
              <h2 class="power-panel__title">Select 1 Active Power</h2>
              <p class="power-panel__hint">Choose one card to reveal your secret power. The bot stays standard.</p>
            </div>

            <div class="power-grid" id="power-grid" role="radiogroup" aria-label="Choose active power">
              <!-- Dynamically populated and shuffled mystery cards -->
            </div>

            <div class="power-state">
              Active power: <strong id="active-power-label">None (Select a card first)</strong>
            </div>
          </div>

          <!-- chess board view -->
          <div id="chessboard" class=" mb-2 mt-5" style="width: 400px;"></div>
      
          <!-- game controls -->
          <div class="row game-controls">                    
            <!-- -buttons -->
            @if(auth()->user()->is_admin || auth()->user()->hasRole('super_admin'))
            <div class="col btn-group">
              <button id="newgame" class="btn btn-outline-secondary">New</button>
              <button id="makemove" class="btn btn-outline-secondary">Move</button>
              <button id="takeback" class="btn btn-outline-secondary">Undo</button>
              <button id="flipboard" class="btn btn-outline-secondary">Flip</button>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>    
  </body>
</html>

<script>

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
    
    // set initial board position
    board.position('start');

    // Reset power selection
    window.powerSelected = false;
    window.activePlayerPower = '';
    $('#active-power-label').text('None (Select a card first)');
    renderPowers();
  });

  window.powerSelected = false;

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
    }
  ];

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

  // Shuffle and render
  const shuffledPowers = shuffle([...powersList]);
  
  function renderPowers() {
    const grid = $('#power-grid');
    grid.empty();
    shuffledPowers.forEach((power, index) => {
      grid.append(`
        <label class="power-card mystery" data-power="${power.value}" data-index="${index}">
          <input class="power-card__radio" type="radio" name="active_power" value="${power.value}" style="position: absolute; opacity: 0; pointer-events: none;">
          <span class="power-card__badge">Mystery Card</span>
          <span class="power-card__name">???</span>
          <span class="power-card__desc">Click to select and reveal this power.</span>
        </label>
      `);
    });
  }

  renderPowers();

  $('#power-grid').on('click', '.power-card', function() {
    if (window.powerSelected) return; // Only allow selecting once

    window.powerSelected = true;
    startTimer(); // Start the game timer
    const selectedCard = $(this);
    const chosenIndex = selectedCard.data('index');
    
    // Reveal all cards but highlight the selected one
    $('.power-card').each(function() {
      const card = $(this);
      const idx = card.data('index');
      const power = shuffledPowers[idx];
      
      card.removeClass('mystery').addClass('revealed');
      card.find('.power-card__badge').text('User only');
      card.find('.power-card__name').text(power.name);
      card.find('.power-card__desc').text(power.desc);
      
      if (idx === chosenIndex) {
        card.addClass('active');
        card.find('input[name="active_power"]').prop('checked', true);
        $('#active-power-label').text(power.name);
        window.activePlayerPower = power.value;
        if (window.engine && typeof window.engine.setPlayerPower === 'function') {
          window.engine.setPlayerPower(power.value);
        }
      } else {
        card.css('opacity', '0.65');
      }
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
      let fen = engine.generateFen();
      board.position(fen);

      // Check if engine's move ended the game
      checkGameStatus();
    }, 300);
  }

  // on dropping piece
  function onDrop (source, target) {
    let promotedPiece = (engine.getSide() ? (5 + 6): 5) // queen promotion only for now
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
  }

  // chess board configuration
  var config = {
    draggable: true,
    position: 'start',
    onDragStart: onDragStart,
    onDrop: onDrop,
    onSnapEnd: onSnapEnd
  }
  
  // create chess board widget instance
  var board = Chessboard('chessboard', config)
  
  // create WukongJS engine instance
  const engine = new Engine();
  window.engine = engine;
  // Initialize with no power active until one is selected
  window.activePlayerPower = '';
</script>
