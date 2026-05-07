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
          "Every chess master was once a beginner."
        </blockquote>
        <p class="auth-quote-attr">— Irving Chernev</p>
        <div class="auth-benefits">
          <div class="benefit-item">
            <span class="benefit-check">✓</span>
            <span class="benefit-text">Free account, no credit card required</span>
          </div>
          <div class="benefit-item">
            <span class="benefit-check">✓</span>
            <span class="benefit-text">Unlimited games and puzzles</span>
          </div>
          <div class="benefit-item">
            <span class="benefit-check">✓</span>
            <span class="benefit-text">Official ELO rating from day one</span>
          </div>
          <div class="benefit-item">
            <span class="benefit-check">✓</span>
            <span class="benefit-text">Access to 10,000+ training puzzles</span>
          </div>
        </div>
      </div>
    </div>

    <!-- ── RIGHT PANEL ── -->

    <div class="auth-right">
      <div class="auth-form-wrap">
        <form action="/mantap" method="POST">
        @csrf
        <h1 class="auth-title animate animate-1">Create account.</h1>
        <p class="auth-sub animate animate-2">
          Already have an account? <a href="login.html">Sign in</a>
        </p>

        <div class="form-row animate animate-2">
          <div class="form-group">
            <label class="form-label" for="firstName">First Name</label>
            <input name="firstname" id="firstName" type="text" class="form-input" placeholder="Magnus" autocomplete="given-name">
          </div>
          <div class="form-group">
            <label class="form-label" for="lastName">Last Name</label>
            <input name="lastname" id="lastName" type="text" class="form-input" placeholder="Carlsen" autocomplete="family-name">
          </div>
        </div>

        <div class="form-group animate animate-2">
          <label class="form-label" for="username">Username</label>
          <input name="username" id="username" type="text" class="form-input" placeholder="@grandmaster" autocomplete="username">
        </div>

        <div class="form-group animate animate-3">
          <label class="form-label" for="email">Email Address</label>
          <input name="email" id="email" type="email" class="form-input" placeholder="you@example.com" autocomplete="email">
        </div>

        <div class="form-row animate animate-3">
          <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input name="password" id="password" type="password" class="form-input" placeholder="••••••••" autocomplete="new-password">
          </div>
          <div class="form-group">
            <label class="form-label" for="confirm">Confirm</label>
            <input name="confirm" id="confirm" type="password" class="form-input" placeholder="••••••••" autocomplete="new-password">
          </div>
        </div>

        <div class="form-group animate animate-3">
          <label class="form-label" for="level">Skill Level</label>
          <select name="level" id="level" class="form-input">
            <option value="">Select your level</option>
            <option value="beginner">Beginner (below 800)</option>
            <option value="intermediate">Intermediate (800–1400)</option>
            <option value="advanced">Advanced (1400–1800)</option>
            <option value="expert">Expert (1800–2200)</option>
            <option value="master">Master (2200+)</option>
          </select>
        </div>

        <label class="form-check animate animate-4">
          <input type="checkbox" id="agreeTerms">
          I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
        </label>

        <button class="btn-full animate animate-4" onclick="window.location.href='dashboard.html'">
          Create Account
        </button>

        <div class="divider animate animate-4">or sign up with</div>

        <button class="oauth-btn animate animate-4">
          <svg width="16" height="16" viewBox="0 0 24 24" aria-hidden="true">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
          </svg>
          Continue with Google
        </button>
        </form>
      </div>
    </div>

  </div>

  <script src="js/main.js"></script>
</body>
</html>
