<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In — Chess War</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/auth.css">
</head>
<body>

  <div class="auth-page">

    <!-- ── LEFT PANEL ── -->
    <div class="auth-left">
      <div class="auth-board" id="authBoard"></div>
      <div class="auth-left-content">
        <a class="auth-brand" href="index.html">Chess War</a>
        <blockquote class="auth-quote">
          "Chess is the art of analysis."
        </blockquote>
        <p class="auth-quote-attr">— Mikhail Botvinnik</p>
        <div class="auth-stats">
          <div>
            <div class="stat-num">Play</div>
            <div class="stat-label">Now</div>
          </div>
          <div>
            <div class="stat-num">Card</div>
            <div class="stat-label">Chess</div>
          </div>
          <div>
            <div class="stat-num">Unique</div>
            <div class="stat-label">Gameplay</div>
          </div>
        </div>
      </div>
    </div>

    <!-- ── RIGHT PANEL ── -->
    <div class="auth-right">
      <div class="auth-form-wrap">

        <h1 class="auth-title animate animate-1">Welcome back.</h1>
        <p class="auth-sub animate animate-2">
          Don't have an account? <a href="/register">Create one</a>
        </p>

        
      <form method="POST" action="/login">
      @csrf
        <div class="form-group animate animate-2">
          <label class="form-label" for="email">Email Address</label>
          <input name="email" id="email" type="email" class="form-input" placeholder="you@example.com" autocomplete="email">
        </div>
        <div class="form-group animate animate-3">
          <label class="form-label" for="password">Password</label>
          <input name="password" id="password" type="password" class="form-input" placeholder="••••••••" autocomplete="current-password">
        </div>

        <button class="btn-full animate animate-4" type="submit">
          Login
        </button>

      </form>





      </div>
    </div>

  </div>

  <script src="js/main.js"></script>
</body>
</html>
