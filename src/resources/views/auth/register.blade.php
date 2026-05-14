<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account — Chess War</title>
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
          "Every master was once a beginner."
        </blockquote>
        <p class="auth-quote-attr">— Cecep Carlos</p>
        <div class="auth-benefits">
          <div class="benefit-item">
            <span class="benefit-check">✓</span>
            <span class="benefit-text">Free account</span>
          </div>
          <div class="benefit-item">
            <span class="benefit-check">✓</span>
            <span class="benefit-text">Unlimited games</span>
          </div>
          <div class="benefit-item">
            <span class="benefit-check">✓</span>
            <span class="benefit-text">Be Unique</span>
          </div>
          <div class="benefit-item">
            <span class="benefit-check">✓</span>
            <span class="benefit-text">Access to funny Gameplay</span>
          </div>
        </div>
      </div>
    </div>

    <!-- ── RIGHT PANEL ── -->
  <div class="auth-right">
  <div class="auth-form-wrap">
  <h1 class="auth-title animate animate-1">Create account.</h1>
  <p class="auth-sub animate animate-2">
  Already have an account? <a href="/login">Sign in</a>
  </p>

  <form action="/register" method="POST">
    @csrf

    <div class="form-group animate animate-2">
        <label class="form-label" for="name">Name</label>
        <input name="name" id="firstName" type="text" class="form-input" placeholder="CECEP" autocomplete="given-name">
    </div>


        <div class="form-group animate animate-2">
          <label class="form-label" for="username">Username</label>
          <input name="username" id="username" type="text" class="form-input" placeholder="LUNATIC GRANDMASTER" autocomplete="username">
        </div>

        <div class="form-group animate animate-3">
          <label class="form-label" for="email">Email Address</label>
          <input name="email" id="email" type="email" class="form-input" placeholder="example@gmail.com" autocomplete="email">
        </div>

        <div class="form-group animate animate-3">
          <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input name="password" id="password" type="password" class="form-input" placeholder="••••••••" autocomplete="new-password">
          </div>
        </div>

        <div class="form-group animate animate-3">
          <div class="form-group">
            <label class="form-label" for="password_confirmation">Confirm Password</label>
            <input name="password_confirmation" id="password_confirmation" type="password" class="form-input" placeholder="••••••••" autocomplete="new-password">
          </div>
        </div>

        <button class="btn-full animate animate-4" type="submit">
          Create Account
        </button>
  </form>

  <script src="js/main.js"></script>
</body>
</html>
