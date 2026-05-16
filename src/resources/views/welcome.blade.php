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
      <a href="#mode">Mode</a>
      <a href="#powers">Powers</a>
      <a href="/login">Sign In</a>
      <a href="/register"><button class="btn-nav">Join Free</button></a>
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
      <p class="hero-label animate animate-1">Random Power Draft Chess</p>
      <h1 class="hero-title animate animate-2">
        Pick 1 of 4<br><em>Hidden Cards.</em><br>Break the Board.
      </h1>
      <p class="hero-sub animate animate-3">
        Setiap awal match kamu mendapat 4 kartu power tertutup. Pilih satu, lalu power itu langsung aktif di game yang kamu mainkan.
      </p>
      <div class="hero-btns animate animate-4">
        <a href="/register"><button class="btn-primary">Start Draft</button></a>
        <a href="#powers"><button class="btn-ghost">See Powers</button></a>
      </div>
    </div>
  </section>

  <!-- ── FEATURES ── -->
  <div class="features-section" id="powers">
    <div class="section">
      <p class="section-label">Power Pool</p>
      <h2 class="section-title">6 power yang bisa mengubah jalannya match.</h2>
      <div class="features-grid">

        <div class="feature-card">
          <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M12 2L8 7H3l3.5 3-1.5 5 5-2.5L15 15l-1.5-5L17 7h-5L12 2z"/>
          </svg>
          <div class="feature-title">Blink Knight</div>
          <p class="feature-desc">Knight punya jangkauan dua kali lebih jauh dari biasanya.</p>
        </div>

        <div class="feature-card">
          <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
            <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
          </svg>
          <div class="feature-title">Super Rook</div>
          <p class="feature-desc">Rook tetap lurus, plus bisa gerak diagonal ke depan kiri dan depan kanan.</p>
        </div>

        <div class="feature-card">
          <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
          </svg>
          <div class="feature-title">Undying King</div>
          <p class="feature-desc">King punya double life. Bidak lawan yang meng-kill King akan mati.</p>
        </div>

        <div class="feature-card">
          <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
          <div class="feature-title">Confused Pawn</div>
          <p class="feature-desc">Pawn bisa bergerak mundur juga, jadi kontrol file jadi lebih liar.</p>
        </div>

        <div class="feature-card">
          <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
          </svg>
          <div class="feature-title">Omni Queen</div>
          <p class="feature-desc">Queen bisa jalan ke segala arah (benar-benar semua arah) tanpa batasan diagonal atau lurus.</p>
        </div>

        <div class="feature-card">
          <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
          </svg>
          <div class="feature-title">Grey Bishop</div>
          <p class="feature-desc">Bishop bisa geser 1 langkah kiri/kanan lalu lanjut diagonal, membuat jalur putih-hitam sama-sama bisa ditembus.</p>
        </div>

      </div>
    </div>
  </div>

  <section class="flow-section" id="mode">
    <div class="section">
      <p class="section-label">Match Flow</p>
      <h2 class="section-title">Satu match dimulai dari 4 kartu tersembunyi.</h2>
      <div class="flow-grid">
        <div class="flow-item">
          <span class="flow-step">01</span>
          <h3>Shuffle</h3>
          <p>Sistem menyiapkan 4 kartu random dan semuanya tertutup.</p>
        </div>
        <div class="flow-item">
          <span class="flow-step">02</span>
          <h3>Pick One</h3>
          <p>Kamu pilih satu kartu tanpa tahu isinya, jadi momen draft selalu tegang.</p>
        </div>
        <div class="flow-item">
          <span class="flow-step">03</span>
          <h3>Power Active</h3>
          <p>Power yang terpilih langsung nempel ke game dan mengubah cara bermainmu.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="mode-section">
    <div class="section">
      <p class="section-label">Why It Works</p>
      <h2 class="section-title">Skill tetap penting, tapi tiap match punya cerita baru.</h2>
      <div class="mode-grid">
        <div class="mode-card">
          <h3>High Replayability</h3>
          <p>Kombinasi power dan posisi papan bikin match tidak monoton.</p>
        </div>
        <div class="mode-card">
          <h3>Easy To Learn</h3>
          <p>Aturan draft simpel, tapi keputusan saat main tetap dalam.</p>
        </div>
        <div class="mode-card">
          <h3>Streamer Friendly</h3>
          <p>Momen buka kartu dan efek power bikin penonton betah nonton.</p>
        </div>
      </div>
    </div>
  </section>

  <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
