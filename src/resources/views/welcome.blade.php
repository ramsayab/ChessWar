<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chess War</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

  <!-- ── NAVIGATION ── -->
  <nav class="main-nav">
    <a class="nav-logo" href="/">Chess<span>War</span></a>
    <div class="nav-links">
      <a href="#">Play</a>
      <a href="#">Tournaments</a>
      <a href="#">Analysis</a>
      <a href="#">Learn</a>
      <a href="login">Sign In</a>
      <a href="register"><button class="btn-nav">Join Free</button></a>
    </div>
  </nav>

  <!-- ── HERO ── -->
  <section class="hero">
    <div class="hero-bg"></div>

    <!-- Decorative board grid -->
    <div class="board-deco" id="heroBoardDeco"></div>

    <!-- Large king watermark -->
    <svg class="piece-deco" viewBox="0 0 100 100" fill="currentColor" color="#C9A84C">
      <text y="85" font-size="90" font-family="serif" opacity="0.4">♚</text>
    </svg>

    <div class="hero-content">
      <p class="hero-label animate animate-1">The Art of the Game</p>
      <h1 class="hero-title animate animate-2">
        Master Every<br><em>Move.</em><br>Conquer Every<br>Board.
      </h1>
      <p class="hero-sub animate animate-3">
        An elite platform for serious chess players. Compete, analyze, and refine your game with world-class tools and a community that shares your passion.
      </p>
      <div class="hero-btns animate animate-4">
        <a href="/register"><button class="btn-primary">Start Playing</button></a>
        <button class="btn-ghost">Watch Live</button>
      </div>
    </div>

    <div class="hero-stats">
      <div class="stat-item">
        <div class="stat-num">84K</div>
        <div class="stat-label">Active Players</div>
      </div>
      <div class="stat-item">
        <div class="stat-num">2.1M</div>
        <div class="stat-label">Games Played</div>
      </div>
      <div class="stat-item">
        <div class="stat-num">340</div>
        <div class="stat-label">Daily Tournaments</div>
      </div>
      <div class="stat-item">
        <div class="stat-num">98%</div>
        <div class="stat-label">Fair Play Rate</div>
      </div>
    </div>
  </section>

  <!-- ── FEATURES ── -->
  <div class="features-section">
    <div class="section">
      <p class="section-label">Why Chess War</p>
      <h2 class="section-title">Built for the serious player.</h2>
      <div class="features-grid">

        <div class="feature-card">
          <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M12 2L8 7H3l3.5 3-1.5 5 5-2.5L15 15l-1.5-5L17 7h-5L12 2z"/>
          </svg>
          <div class="feature-title">Ranked Competitions</div>
          <p class="feature-desc">Compete in daily ranked matches with a globally recognized ELO rating system calibrated for accuracy and fairness.</p>
        </div>

        <div class="feature-card">
          <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
            <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
          </svg>
          <div class="feature-title">Deep Analysis</div>
          <p class="feature-desc">Post-game engine analysis with up to 30 ply depth. Identify mistakes, blunders, and brilliancies in every game you play.</p>
        </div>

        <div class="feature-card">
          <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
          </svg>
          <div class="feature-title">Time Controls</div>
          <p class="feature-desc">From ultra-bullet to classical — choose your tempo. All formats meticulously balanced for competitive integrity.</p>
        </div>

        <div class="feature-card">
          <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
          <div class="feature-title">Elite Community</div>
          <p class="feature-desc">Join clubs, follow titled players, and engage in a community that values sportsmanship and intellectual rigor.</p>
        </div>

        <div class="feature-card">
          <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
          </svg>
          <div class="feature-title">Live Tournaments</div>
          <p class="feature-desc">Hundreds of daily and weekly tournaments with prize pools, spectator mode, and live commentary.</p>
        </div>

        <div class="feature-card">
          <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
          </svg>
          <div class="feature-title">Puzzle Trainer</div>
          <p class="feature-desc">Thousands of curated tactical puzzles adapting to your skill level. Train pattern recognition the grandmaster way.</p>
        </div>

      </div>
    </div>
  </div>

  <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
