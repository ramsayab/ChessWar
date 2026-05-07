<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — Chess War</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

  <!-- ── DASHBOARD NAV ── -->
  <nav class="dash-nav">
    <a class="dash-logo" href="index.html">Chess War</a>
    <div class="dash-nav-center">
      <div class="dash-nav-item active">Overview</div>
      <div class="dash-nav-item">Play</div>
      <div class="dash-nav-item">Tournaments</div>
      <div class="dash-nav-item">Analysis</div>
      <div class="dash-nav-item">Puzzles</div>
    </div>
    <div class="dash-nav-right">
      <div class="rating-badge">ELO 1842</div>
      <div class="user-badge">
        <div class="user-avatar">M</div>
        <span>Magnus</span>
      </div>
      <a class="logout-link" href="index.html">Log out</a>
    </div>
  </nav>

  <div class="dash-wrapper">
    <div class="dash-body">

      <!-- ── SIDEBAR ── -->
      <aside class="dash-sidebar">
        <div class="sidebar-section">
          <div class="sidebar-label">Menu</div>
          <div class="sidebar-item active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <rect x="3" y="3" width="7" height="7" rx="1"/>
              <rect x="14" y="3" width="7" height="7" rx="1"/>
              <rect x="3" y="14" width="7" height="7" rx="1"/>
              <rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>
            Dashboard
          </div>
          <div class="sidebar-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <circle cx="12" cy="12" r="9"/>
              <text y="17" x="6" font-size="12" font-family="serif" fill="currentColor" stroke="none">♟</text>
            </svg>
            Play Now
          </div>
          <div class="sidebar-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="12 6 12 12 16 14"/>
            </svg>
            Tournaments
          </div>
          <div class="sidebar-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
            Analysis
          </div>
          <div class="sidebar-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
            Puzzles
          </div>
        </div>

        <div class="sidebar-section">
          <div class="sidebar-label">Account</div>
          <div class="sidebar-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
            Profile
          </div>
          <div class="sidebar-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <circle cx="12" cy="12" r="3"/>
              <path d="M19.07 4.93L17.66 6.34M4.93 4.93l1.41 1.41M2 12h2m16 0h2M4.93 19.07l1.41-1.41M17.66 17.66l1.41 1.41M12 2v2m0 16v2"/>
            </svg>
            Settings
          </div>
        </div>

        <div class="sidebar-quick-play">
          <h4>Ready to play?</h4>
          <p>Find a match in seconds.</p>
          <button class="btn-full" style="padding:0.65rem;font-size:0.75rem;">Find Opponent</button>
        </div>
      </aside>

      <!-- ── MAIN CONTENT ── -->
      <main class="dash-main">

        <div class="dash-welcome animate animate-1">
          <h1>Good morning, Magnus ♟</h1>
          <p>You have 2 active tournament games and 5 new puzzle challenges.</p>
        </div>

        <!-- Metrics -->
        <div class="metrics-row animate animate-2">
          <div class="metric-card">
            <div class="metric-value">1842</div>
            <div class="metric-label">ELO Rating</div>
            <div class="metric-delta">▲ +24 this month</div>
          </div>
          <div class="metric-card">
            <div class="metric-value">68%</div>
            <div class="metric-label">Win Rate</div>
            <div class="metric-delta">▲ +3% vs last month</div>
          </div>
          <div class="metric-card">
            <div class="metric-value">247</div>
            <div class="metric-label">Games Played</div>
            <div class="metric-delta">▲ 18 this week</div>
          </div>
          <div class="metric-card">
            <div class="metric-value">1,840</div>
            <div class="metric-label">Puzzle Score</div>
            <div class="metric-delta neg">▼ −12 today</div>
          </div>
        </div>

        <!-- Mid row -->
        <div class="dash-mid animate animate-3">

          <!-- Recent games -->
          <div class="card">
            <div class="card-title">Recent Games <span class="card-action">View All</span></div>
            <div class="game-item">
              <div class="game-result result-w">W</div>
              <div class="game-info">
                <div class="game-opponent">vs. DragonSlayer99</div>
                <div class="game-meta">Blitz · 5+3 · 42 moves</div>
              </div>
              <div class="game-rating-change rating-up">+12</div>
            </div>
            <div class="game-item">
              <div class="game-result result-l">L</div>
              <div class="game-info">
                <div class="game-opponent">vs. KnightRider_GM</div>
                <div class="game-meta">Rapid · 10+0 · 31 moves</div>
              </div>
              <div class="game-rating-change rating-down">−8</div>
            </div>
            <div class="game-item">
              <div class="game-result result-w">W</div>
              <div class="game-info">
                <div class="game-opponent">vs. SilentPawn</div>
                <div class="game-meta">Blitz · 5+3 · 56 moves</div>
              </div>
              <div class="game-rating-change rating-up">+14</div>
            </div>
            <div class="game-item">
              <div class="game-result result-d">D</div>
              <div class="game-info">
                <div class="game-opponent">vs. EloHunter</div>
                <div class="game-meta">Classical · 15+10 · 72 moves</div>
              </div>
              <div class="game-rating-change" style="color:var(--muted)">+0</div>
            </div>
            <div class="game-item">
              <div class="game-result result-w">W</div>
              <div class="game-info">
                <div class="game-opponent">vs. RookMaster_2200</div>
                <div class="game-meta">Blitz · 5+3 · 38 moves</div>
              </div>
              <div class="game-rating-change rating-up">+18</div>
            </div>
          </div>

          <!-- Activity + mini board -->
          <div class="dash-mid-col">
            <div class="card">
              <div class="card-title">Weekly Activity</div>
              <div class="bar-chart" id="activityChart"></div>
              <div class="bar-labels">
                <span class="bar-label">Mon</span>
                <span class="bar-label">Tue</span>
                <span class="bar-label">Wed</span>
                <span class="bar-label">Thu</span>
                <span class="bar-label">Fri</span>
                <span class="bar-label">Sat</span>
                <span class="bar-label">Sun</span>
              </div>
            </div>
            <div class="card">
              <div class="card-title">Last Position <span class="card-action">Analyze</span></div>
              <div class="mini-board" id="miniBoard"></div>
            </div>
          </div>

        </div>
      </main>

      <!-- ── RIGHT PANEL ── -->
      <aside class="dash-right animate animate-2">

        <div class="panel-section">
          <div class="panel-title">Top Players</div>
          <div class="lb-item"><span class="lb-rank top">1</span><div class="lb-avatar">A</div><span class="lb-name">ArtemBolt</span><span class="lb-rating">2841</span></div>
          <div class="lb-item"><span class="lb-rank top">2</span><div class="lb-avatar">V</div><span class="lb-name">ViperGrand</span><span class="lb-rating">2804</span></div>
          <div class="lb-item"><span class="lb-rank top">3</span><div class="lb-avatar">Z</div><span class="lb-name">ZenMaster</span><span class="lb-rating">2791</span></div>
          <div class="lb-item"><span class="lb-rank">4</span><div class="lb-avatar">K</div><span class="lb-name">KingSide_K</span><span class="lb-rating">2744</span></div>
          <div class="lb-item"><span class="lb-rank">5</span><div class="lb-avatar you">M</div><span class="lb-name you">You</span><span class="lb-rating">1842</span></div>
        </div>

        <div class="panel-section">
          <div class="panel-title">Online Now <span class="online-count">● 1,284</span></div>
          <div class="lb-item"><div class="online-dot"></div><div class="lb-avatar">S</div><span class="lb-name">SilentPawn</span><span class="lb-rating-muted">1650</span></div>
          <div class="lb-item"><div class="online-dot"></div><div class="lb-avatar">R</div><span class="lb-name">RookMaster</span><span class="lb-rating-muted">2100</span></div>
          <div class="lb-item"><div class="online-dot"></div><div class="lb-avatar">D</div><span class="lb-name">DragonSlayer</span><span class="lb-rating-muted">1920</span></div>
        </div>

        <div class="panel-section">
          <div class="panel-title">Upcoming</div>
          <div class="upcoming-item">
            <div class="upcoming-name">Sunday Rapid Open</div>
            <div class="upcoming-time">Today · 18:00 WIB</div>
            <span class="upcoming-type">Rapid</span>
          </div>
          <div class="upcoming-item">
            <div class="upcoming-name">Diamond League R3</div>
            <div class="upcoming-time">Mon · 20:00 WIB</div>
            <span class="upcoming-type">Blitz</span>
          </div>
          <div class="upcoming-item">
            <div class="upcoming-name">Classical Championship</div>
            <div class="upcoming-time">Wed · 14:00 WIB</div>
            <span class="upcoming-type">Classical</span>
          </div>
        </div>

        <div class="cta-card">
          <h3>Upgrade to Premium</h3>
          <p>Unlock unlimited analysis, advanced stats, and exclusive tournaments.</p>
          <button class="btn-cta">Upgrade Now</button>
        </div>

      </aside>

    </div>
  </div>

  <script src="js/main.js"></script>
  <script src="js/dashboard.js"></script>
</body>
</html>
