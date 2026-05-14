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
  @php
    $user = auth()->user();
    $displayName = $user?->username ?: ($user?->name ?: 'Player');
    $initial = strtoupper(substr($displayName, 0, 1));
  @endphp

  <nav class="dash-nav">
    <a class="dash-logo" href="/dashboard">Chess War</a>
    <div class="dash-nav-center">
      <div class="dash-nav-item active">Overview</div>
    </div>
    <div class="dash-nav-right">
      <div class="user-badge">
        <div class="user-avatar">{{ $initial }}</div>
        <span>{{ $displayName }}</span>
      </div>
      <form action="/logout" method="POST">
        @csrf
        <button class="logout-link" type="submit">Log out</button>
      </form>
    </div>
  </nav>

  <div class="dash-wrapper">
    <main class="dash-main">
      <section class="dash-hero animate animate-1" id="play">
        <p class="dash-kicker">Dashboard</p>
        <h1>Welcome, {{ $displayName }}</h1>
        <p>Ready for your next match? Jump in and start playing now.</p>
        <a class="play-now-btn" href="#">Play Now</a>
      </section>

      <section class="quick-section animate animate-2">
        <div class="quick-card">
          <h2>Quick Match</h2>
          <p>Start a fast game and get paired instantly.</p>
          <a class="quick-link" href="#">Start Match</a>
        </div>
        <div class="quick-card">
          <h2>Continue Playing</h2>
          <p>Open your active game from the last session.</p>
          <a class="quick-link" href="#">Open Game</a>
        </div>
      </section>
    </main>
  </div>

  <script src="js/main.js"></script>
</body>
</html>
