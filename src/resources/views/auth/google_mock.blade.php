<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Google Accounts — Chess War Simulator</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg: #0b0f19;
      --panel: #131a26;
      --border: rgba(201, 168, 76, 0.2);
      --gold: #c9a84c;
      --text: #f4efe3;
      --text-muted: #9ba4b4;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Jost', sans-serif;
      background: radial-gradient(circle at 50% 50%, #151d30 0%, var(--bg) 100%);
      color: var(--text);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    .mock-container {
      width: min(440px, 100% - 32px);
      background: var(--panel);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 40px 30px;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
      box-sizing: border-box;
      text-align: center;
    }

    .google-logo {
      display: flex;
      justify-content: center;
      gap: 3px;
      margin-bottom: 24px;
    }

    .google-logo span {
      font-size: 2.2rem;
      font-weight: 600;
      letter-spacing: -1px;
    }

    .logo-g { color: #4285F4; }
    .logo-o1 { color: #EA4335; }
    .logo-o2 { color: #FBBC05; }
    .logo-g2 { color: #4285F4; }
    .logo-l { color: #34A853; }
    .logo-e { color: #EA4335; }

    h1 {
      font-size: 1.5rem;
      font-weight: 500;
      margin: 0 0 8px;
    }

    .subtitle {
      color: var(--text-muted);
      font-size: 0.95rem;
      margin: 0 0 32px;
    }

    .subtitle strong {
      color: var(--gold);
    }

    .account-list {
      display: flex;
      flex-direction: column;
      gap: 12px;
      margin-bottom: 28px;
    }

    .account-item {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 14px 18px;
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 10px;
      cursor: pointer;
      text-align: left;
      text-decoration: none;
      color: inherit;
      transition: all 0.2s ease;
    }

    .account-item:hover {
      background: rgba(201, 168, 76, 0.06);
      border-color: var(--gold);
      transform: translateY(-2px);
    }

    .avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: var(--gold);
      color: #111;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      font-size: 1.1rem;
    }

    .account-info {
      flex: 1;
    }

    .account-name {
      font-weight: 500;
      font-size: 0.95rem;
      margin-bottom: 2px;
    }

    .account-email {
      color: var(--text-muted);
      font-size: 0.82rem;
    }

    .divider {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin: 24px 0;
      color: var(--text-muted);
      font-size: 0.85rem;
    }

    .divider::before, .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: rgba(255, 255, 255, 0.08);
    }

    .custom-form {
      text-align: left;
      display: flex;
      flex-direction: column;
      gap: 14px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    label {
      font-size: 0.72rem;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--text-muted);
    }

    input {
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.15);
      border-radius: 6px;
      padding: 10px 14px;
      color: var(--text);
      font-family: inherit;
      outline: none;
      font-size: 0.9rem;
      transition: all 0.2s ease;
    }

    input:focus {
      border-color: var(--gold);
      background: rgba(201, 168, 76, 0.03);
    }

    .btn-submit {
      background: var(--gold);
      color: #111;
      border: none;
      border-radius: 6px;
      padding: 12px;
      font-weight: 600;
      cursor: pointer;
      font-family: inherit;
      font-size: 0.9rem;
      transition: all 0.2s ease;
      margin-top: 6px;
    }

    .btn-submit:hover {
      opacity: 0.9;
      transform: translateY(-1px);
    }
  </style>
</head>
<body>

  <div class="mock-container">
    <div class="google-logo">
      <span class="logo-g">G</span>
      <span class="logo-o1">o</span>
      <span class="logo-o2">o</span>
      <span class="logo-g2">g</span>
      <span class="logo-l">l</span>
      <span class="logo-e">e</span>
    </div>

    <h1>Sign in with Google</h1>
    <div class="subtitle">to continue to <strong>Chess War</strong></div>

    <div class="account-list">
      <!-- Account 1 -->
      <a href="{{ route('auth.google.callback', ['mock' => 'true', 'name' => 'Cecep Carlos', 'email' => 'cecep@gmail.com', 'avatar_url' => 'https://www.gravatar.com/avatar/' . md5('cecep@gmail.com') . '?d=mp&s=250']) }}" class="account-item">
        <div class="avatar" style="background-color: #4285F4; color: white;">C</div>
        <div class="account-info">
          <div class="account-name">Cecep Carlos</div>
          <div class="account-email">cecep@gmail.com</div>
        </div>
      </a>

      <!-- Account 2 -->
      <a href="{{ route('auth.google.callback', ['mock' => 'true', 'name' => 'Mikhail Botvinnik', 'email' => 'botvinnik@gmail.com', 'avatar_url' => 'https://www.gravatar.com/avatar/' . md5('botvinnik@gmail.com') . '?d=mp&s=250']) }}" class="account-item">
        <div class="avatar" style="background-color: #EA4335; color: white;">M</div>
        <div class="account-info">
          <div class="account-name">Mikhail Botvinnik</div>
          <div class="account-email">botvinnik@gmail.com</div>
        </div>
      </a>
    </div>

    <div class="divider">or use another account</div>

    <form class="custom-form" action="{{ route('auth.google.callback') }}" method="GET">
      <input type="hidden" name="mock" value="true">
      
      <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" placeholder="Garry Kasparov" required>
      </div>

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="kasparov@gmail.com" required>
      </div>

      <button type="submit" class="btn-submit">Continue with Mock Google Account</button>
    </form>
  </div>

</body>
</html>
