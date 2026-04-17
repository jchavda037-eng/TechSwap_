<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!empty($_SESSION['user_id'])) {
    $redirect = $_REQUEST['redirect'] ?? 'home.php';
    header("Location: $redirect");
    exit();
}
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>
<?php include '_styles.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — TechSwap</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { font-size: 16px; }
    body {
      font-family: var(--font-body);
      min-height: 100vh;
      display: flex;
      background: var(--bg);
      color: var(--text);
      overflow-x: hidden;
    }

    
    .auth-left {
      flex: 1;
      background: linear-gradient(135deg, rgba(232,64,10,0.12), rgba(245,244,240,0.96));
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 60px;
      position: relative;
      overflow: hidden;
    }
    .auth-left::before {
      content: '';
      position: absolute;
      width: 500px; height: 500px;
      background: radial-gradient(circle, rgba(255,107,53,0.3) 0%, transparent 70%);
      top: -100px; right: -100px;
      border-radius: 50%;
      animation: floatOrb 8s infinite ease-in-out;
    }
    .auth-left::after {
      content: '';
      position: absolute;
      width: 400px; height: 400px;
      background: radial-gradient(circle, rgba(232,64,10,0.25) 0%, transparent 70%);
      bottom: -80px; left: -80px;
      border-radius: 50%;
      animation: floatOrb 10s infinite ease-in-out reverse;
    }
    @keyframes floatOrb {
      0%, 100% { transform: translate(0, 0) scale(1); }
      33% { transform: translate(30px, -20px) scale(1.1); }
      66% { transform: translate(-20px, 15px) scale(0.95); }
    }

    .auth-left-content {
      position: relative;
      z-index: 1;
      color: var(--text);
      text-align: center;
      max-width: 420px;
    }
    .auth-left-logo {
      font-family: var(--font-display);
      font-weight: 800;
      font-size: 2.5rem;
      margin-bottom: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
    }
    .auth-left-logo-icon {
      width: 52px; height: 52px;
      background: var(--accent);
      border-radius: 14px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.5rem;
      box-shadow: 0 8px 32px rgba(232,64,10,0.4);
    }
    .auth-left-logo span { color: var(--accent2); }
    .auth-left h2 {
      font-family: var(--font-display);
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 16px;
      line-height: 1.3;
    }
    .auth-left p {
      font-size: 1rem;
      opacity: 0.7;
      line-height: 1.7;
      margin-bottom: 40px;
    }

    .auth-stats {
      display: flex;
      gap: 40px;
      justify-content: center;
    }
    .auth-stat-num {
      font-family: var(--font-display);
      font-size: 1.6rem;
      font-weight: 800;
    }
    .auth-stat-label {
      font-size: 0.82rem;
      opacity: 0.6;
      margin-top: 2px;
    }

    .floating-cards {
      display: flex;
      gap: 16px;
      margin-top: 48px;
      animation: floatCards 6s ease-in-out infinite;
    }
    @keyframes floatCards {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
    .floating-card {
      background: rgba(255,255,255,0.95);
      border: 1px solid rgba(0,0,0,0.06);
      border-radius: 16px;
      padding: 20px;
      text-align: center;
      min-width: 120px;
      transition: transform 0.3s;
    }
    .floating-card:hover { transform: translateY(-4px) scale(1.05); }
    .floating-card-icon { font-size: 1.8rem; margin-bottom: 8px; }
    .floating-card-name { font-weight: 600; font-size: 0.85rem; }
    .floating-card-price { color: var(--accent2); font-weight: 700; font-size: 0.9rem; margin-top: 4px; }

    
    .auth-right {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px;
      position: relative;
    }

    .auth-form-wrapper {
      width: 100%;
      max-width: 440px;
      animation: slideUp 0.5s ease;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 28px;
      box-shadow: var(--shadow-lg);
      padding: 42px;
    }
    @keyframes slideUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .auth-form-wrapper h1 {
      font-family: var(--font-display);
      font-size: 2rem;
      font-weight: 800;
      margin-bottom: 8px;
    }
    .auth-form-wrapper .subtitle {
      color: var(--text2);
      font-size: 0.95rem;
      margin-bottom: 32px;
    }

    
    .auth-tabs {
      display: flex;
      gap: 4px;
      background: var(--bg);
      border-radius: 12px;
      padding: 4px;
      margin-bottom: 32px;
      border: 1.5px solid var(--border);
    }
    .auth-tab {
      flex: 1;
      padding: 12px;
      text-align: center;
      border-radius: 10px;
      font-weight: 600;
      font-size: 0.9rem;
      cursor: pointer;
      transition: all 0.25s;
      border: none;
      background: transparent;
      color: var(--text2);
      font-family: var(--font-body);
    }
    .auth-tab.active {
      background: var(--accent);
      color: #fff;
      box-shadow: 0 4px 16px rgba(232,64,10,0.3);
    }
    .auth-tab:not(.active):hover { color: var(--accent); }

    
    .auth-form { display: none; }
    .auth-form.active { display: block; animation: slideUp 0.3s ease; }

    .form-group {
      margin-bottom: 20px;
    }
    .form-group label {
      display: block;
      font-weight: 500;
      font-size: 0.88rem;
      color: var(--text2);
      margin-bottom: 6px;
    }
    .form-control {
      width: 100%;
      padding: 12px 16px;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      background: var(--bg);
      color: var(--text);
      font-size: 0.92rem;
      font-family: var(--font-body);
      transition: all 0.22s;
      outline: none;
    }
    .form-control:focus {
      border-color: var(--accent);
      background: rgba(255,255,255,0.08);
      box-shadow: 0 0 0 3px rgba(232,64,10,0.1);
    }
    .form-control::placeholder { color: var(--text3); }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

    .password-wrapper {
      position: relative;
    }
    .password-toggle {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: var(--text3);
      cursor: pointer;
      font-size: 1.1rem;
      padding: 4px;
      transition: color 0.2s;
    }
    .password-toggle:hover { color: var(--accent); }

    .btn-submit {
      width: 100%;
      padding: 14px;
      background: var(--accent);
      color: #fff;
      border: none;
      border-radius: 10px;
      font-weight: 700;
      font-size: 0.95rem;
      cursor: pointer;
      transition: all 0.22s;
      font-family: var(--font-display);
      letter-spacing: 0.02em;
      position: relative;
      overflow: hidden;
    }
    .btn-submit::before {
      content: '';
      position: absolute;
      top: 0; left: -100%;
      width: 100%; height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: left 0.5s;
    }
    .btn-submit:hover {
      background: var(--accent2);
      transform: translateY(-1px);
      box-shadow: 0 6px 24px rgba(232,64,10,0.35);
    }
    .btn-submit:hover::before { left: 100%; }

    .forgot-link {
      display: block;
      text-align: right;
      margin-top: -12px;
      margin-bottom: 20px;
      font-size: 0.82rem;
      color: var(--text3);
      text-decoration: none;
      transition: color 0.2s;
    }
    .forgot-link:hover { color: var(--accent); }

    .divider {
      display: flex;
      align-items: center;
      gap: 16px;
      margin: 28px 0;
      color: var(--text3);
      font-size: 0.82rem;
    }
    .divider::before, .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--border);
    }

    .home-link {
      display: block;
      text-align: center;
      margin-top: 24px;
      font-size: 0.88rem;
      color: var(--text2);
      text-decoration: none;
      transition: color 0.2s;
    }
    .home-link:hover { color: var(--accent); }

    
    .alert {
      padding: 12px 16px;
      border-radius: 10px;
      margin-bottom: 20px;
      font-size: 0.88rem;
      font-weight: 500;
      animation: slideUp 0.3s ease;
    }
    .alert-error {
      background: rgba(232,64,10,0.12);
      color: #ffedd5;
      border: 1px solid rgba(232,64,10,0.2);
    }
    .alert-success {
      background: rgba(22,163,74,0.12);
      color: #d1fae5;
      border: 1px solid rgba(26,122,74,0.2);
    }

    
    @media (max-width: 900px) {
      .auth-left { display: none; }
      body { display: flex; justify-content: center; align-items: center; }
      .auth-right { padding: 24px; }
    }
    @media (max-width: 500px) {
      .form-row { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

  
  <div class="auth-left">
    <div class="auth-left-content">
      <div class="auth-left-logo">
        <div class="auth-left-logo-icon">⚡</div>
        Tech<span>Swap</span>
      </div>
      <h2>Buy & Sell Pre-owned<br>Electronics Worldwide</h2>
      <p>Join the global marketplace trusted by thousands. Discover verified second-hand tech at unbeatable prices.</p>

      <div class="auth-stats">
        <div>
          <div class="auth-stat-num">12k+</div>
          <div class="auth-stat-label">Active listings</div>
        </div>
        <div>
          <div class="auth-stat-num">8.4k</div>
          <div class="auth-stat-label">Happy users</div>
        </div>
        <div>
          <div class="auth-stat-num">4.9★</div>
          <div class="auth-stat-label">Trust rating</div>
        </div>
      </div>

      <div class="floating-cards">
        <div class="floating-card">
          <div class="floating-card-icon">📱</div>
          <div class="floating-card-name">iPhone 15 Pro</div>
          <div class="floating-card-price">$899</div>
        </div>
        <div class="floating-card">
          <div class="floating-card-icon">💻</div>
          <div class="floating-card-name">MacBook Air</div>
          <div class="floating-card-price">$999</div>
        </div>
        <div class="floating-card">
          <div class="floating-card-icon">🎧</div>
          <div class="floating-card-name">AirPods Pro</div>
          <div class="floating-card-price">$179</div>
        </div>
      </div>
    </div>
  </div>

  
  <div class="auth-right">
    <div class="auth-form-wrapper">
      <h1 id="formTitle">Welcome back</h1>
      <p class="subtitle" id="formSubtitle">Sign in to continue to TechSwap</p>

      <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
      <?php endif; ?>

      
      <div class="auth-tabs">
        <button class="auth-tab active" type="button" onclick="switchAuthTab('login', this)">Sign In</button>
        <button class="auth-tab" type="button" onclick="switchAuthTab('register', this)">Create Account</button>
      </div>

      
      <form class="auth-form active" id="loginForm" action="login_process.php" method="POST">
        <input type="hidden" name="redirect" value="<?= htmlspecialchars($_GET['redirect'] ?? 'home.php') ?>">

        <div class="form-group">
          <label>Email Address</label>
          <input type="email" name="email" class="form-control" placeholder="you@example.com" required autofocus>
        </div>

        <div class="form-group">
          <label>Password</label>
          <div class="password-wrapper">
            <input type="password" name="password" class="form-control" id="loginPassword" placeholder="••••••••" required>
            <button type="button" class="password-toggle" onclick="togglePassword('loginPassword', this)">👁</button>
          </div>
        </div>

        <a href="forgot_password.php" class="forgot-link">Forgot password?</a>

        <button type="submit" class="btn-submit">Sign In →</button>
      </form>

      
      <form class="auth-form" id="registerForm" action="register_process.php" method="POST">
        <div class="form-row">
          <div class="form-group">
            <label>First Name</label>
            <input type="text" name="fname" class="form-control" placeholder="John" required>
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="lname" class="form-control" placeholder="Doe" required>
          </div>
        </div>

        <div class="form-group">
          <label>Email Address</label>
          <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
        </div>

        <div class="form-group">
          <label>Password</label>
          <div class="password-wrapper">
            <input type="password" name="password" class="form-control" id="registerPassword" placeholder="Min 8 characters" required minlength="8">
            <button type="button" class="password-toggle" onclick="togglePassword('registerPassword', this)">👁</button>
          </div>
        </div>

        <button type="submit" class="btn-submit">Create Account →</button>
      </form>

      <div class="divider">or</div>
      <a href="home.php" class="home-link">← Back to TechSwap</a>
    </div>
  </div>

  <script>
    function switchAuthTab(tab, tabButton) {
      document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
      document.querySelectorAll('.auth-form').forEach(f => f.classList.remove('active'));
      if (tabButton) {
        tabButton.classList.add('active');
      }
      document.getElementById(tab + 'Form').classList.add('active');

      const title = document.getElementById('formTitle');
      const sub = document.getElementById('formSubtitle');
      if (tab === 'login') {
        title.textContent = 'Welcome back';
        sub.textContent = 'Sign in to continue to TechSwap';
      } else {
        title.textContent = 'Create account';
        sub.textContent = 'Join the TechSwap community today';
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
      const params = new URLSearchParams(window.location.search);
      if (params.has('success')) {
        const loginTab = document.querySelector('.auth-tab');
        if (loginTab) switchAuthTab('login', loginTab);
      }
    });

    function togglePassword(inputId, btn) {
      const input = document.getElementById(inputId);
      if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = '🙈';
      } else {
        input.type = 'password';
        btn.textContent = '👁';
      }
    }
  </script>
</body>
</html>
