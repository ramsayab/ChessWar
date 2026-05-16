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
    </style>
    
  </head>
  <body class="game-page">
    <div class="col mt-5 game-scene">
      <div class="row">
        <div align="center" class="col game-shell">
          <p class="game-kicker">Chess War</p>
          <h1 class="game-title">Battle Arena</h1>

          <!-- chess board view -->
          <div id="chessboard" class=" mb-2 mt-5" style="width: 400px;"></div>
      
          <!-- game controls -->
          <div class="row game-controls">                    
            <!-- -buttons -->
            <div class="col btn-group">
              <button id="newgame" class="btn btn-outline-secondary">New</button>
              <button id="makemove" class="btn btn-outline-secondary">Move</button>
              <button id="takeback" class="btn btn-outline-secondary">Undo</button>
              <button id="flipboard" class="btn btn-outline-secondary">Flip</button>
            </div>
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
  
  
  // handle new game button click
  $('#newgame').on('click', function() {
    // reset engine
    engine.setBoard(engine.START_FEN);
    
    // set initial board position
    board.position('start');
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

  // chess board configuration
  var config = {
    draggable: true,
    position: 'start',
    //onDragStart: onDragStart,
    onDrop: onDrop,
    onSnapEnd: onSnapEnd
  }
  
  // create chess board widget instance
  var board = Chessboard('chessboard', config)
  
  // create WukongJS engine instance
  const engine = new Engine();
</script>