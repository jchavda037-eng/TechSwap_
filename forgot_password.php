<?php
// forgot_password.php — Password Recovery Page
session_start();
// If already logged in, redirect to home
if (!empty($_SESSION['user_id'])) {
  header('Location: home.php');
  exit;
}
$pageTitle = 'Forgot Password — TechSwap';
$activePage = 'forgot-password';
include '_header.php';
?>

<!-- ============ FORGOT PASSWORD PAGE ============ -->
<section class="section" style="padding-top: 64px; background: var(--bg2); min-height: 80vh; display:flex; align-items: center;">
  <div class="container" style="max-width: 460px;">

    <!-- STEP 1: REQUEST RESET -->
    <div id="step1-request" style="background:var(--surface);border:1.5px solid var(--border);border-radius:var(--radius);padding:32px;">
      <div style="text-align:center;margin-bottom:28px;">
        <div style="font-size:3rem;margin-bottom:16px;">🔑</div>
        <h2 style="font-size:1.4rem;margin-bottom:6px;">Forgot your password?</h2>
        <p style="color:var(--text2);font-size:0.88rem;">No worries! We'll help you reset it.</p>
      </div>

      <div class="form-group">
        <label>Email Address *</label>
        <input class="form-control" type="email" id="reset-email" placeholder="you@example.com" required>
      </div>
      
      <button class="btn btn-primary btn-lg" style="width:100%;justify-content:center;" onclick="requestPasswordReset()">
        Send Reset Link →
      </button>

      <div style="text-align:center;margin-top:24px;font-size:0.85rem;color:var(--text2);">
        Remember your password? <a href="login.php" style="color:var(--accent);font-weight:600;">Sign in</a>
      </div>
    </div>

    <!-- STEP 2: VERIFICATION SENT -->
    <div id="step2-sent" style="display:none;background:var(--surface);border:1.5px solid var(--border);border-radius:var(--radius);padding:32px;text-align:center;">
      <div style="font-size:2.5rem;margin-bottom:16px;">✉️</div>
      <h2 style="font-size:1.4rem;margin-bottom:12px;">Check your email</h2>
      <p style="color:var(--text2);font-size:0.88rem;margin-bottom:24px;line-height:1.6;">
        We've sent a password reset link to <strong id="display-email"></strong>. Click the link in your email to reset your password.
      </p>
      <div style="background:var(--surface2);border-radius:var(--radius-sm);padding:16px;margin-bottom:24px;border-left:4px solid var(--blue);">
        <p style="font-size:0.82rem;color:var(--text2);margin:0;">
          <strong>Tip:</strong> Check your spam or junk folder if you don't see the email.
        </p>
      </div>
      <button class="btn btn-outline btn-lg" style="width:100%;justify-content:center;" onclick="goBackToEmail()">
        Try another email
      </button>
      <div style="margin-top:20px;">
        <p style="font-size:0.82rem;color:var(--text3);margin-bottom:12px;">Didn't receive the email?</p>
        <button class="btn btn-ghost btn-sm" onclick="resendResetEmail()">
          Resend email
        </button>
      </div>
    </div>

    <!-- STEP 3: RESET PASSWORD (With token) -->
    <div id="step3-reset" style="display:none;background:var(--surface);border:1.5px solid var(--border);border-radius:var(--radius);padding:32px;">
      <div style="text-align:center;margin-bottom:28px;">
        <div style="font-size:2.5rem;margin-bottom:16px;">🔓</div>
        <h2 style="font-size:1.4rem;margin-bottom:6px;">Create new password</h2>
        <p style="color:var(--text2);font-size:0.88rem;">Enter a strong password to secure your account.</p>
      </div>

      <input type="hidden" id="reset-token">

      <div class="form-group">
        <label>New Password *</label>
        <div style="position:relative;">
          <input class="form-control" type="password" id="new-password" placeholder="••••••••" required>
          <button type="button" class="password-toggle" onclick="togglePasswordVisibility('new-password')" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text2);font-size:1.2rem;">👁</button>
        </div>
        <div class="form-hint">At least 8 characters, including uppercase, lowercase, and numbers.</div>
      </div>

      <div class="form-group">
        <label>Confirm Password *</label>
        <div style="position:relative;">
          <input class="form-control" type="password" id="confirm-password" placeholder="••••••••" required>
          <button type="button" class="password-toggle" onclick="togglePasswordVisibility('confirm-password')" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text2);font-size:1.2rem;">👁</button>
        </div>
      </div>

      <div id="password-strength" style="margin-bottom:20px;display:none;">
        <div style="font-size:0.82rem;color:var(--text2);margin-bottom:6px;">Password strength:</div>
        <div style="height:4px;background:var(--surface2);border-radius:2px;overflow:hidden;">
          <div id="strength-bar" style="height:100%;width:0%;background:var(--green);transition:width 0.3s;"></div>
        </div>
      </div>

      <button class="btn btn-primary btn-lg" style="width:100%;justify-content:center;" onclick="resetPassword()">
        Reset Password →
      </button>

      <div style="text-align:center;margin-top:20px;">
        <a href="login.php" style="font-size:0.85rem;color:var(--accent);">Back to sign in</a>
      </div>
    </div>

    <!-- STEP 4: SUCCESS -->
    <div id="step4-success" style="display:none;background:var(--surface);border:1.5px solid var(--border);border-radius:var(--radius);padding:32px;text-align:center;">
      <div style="font-size:3rem;margin-bottom:16px;">✅</div>
      <h2 style="font-size:1.4rem;margin-bottom:12px;">Password reset successful!</h2>
      <p style="color:var(--text2);font-size:0.88rem;margin-bottom:28px;">Your password has been updated. You can now sign in with your new password.</p>
      <a href="login.php" class="btn btn-primary btn-lg" style="width:100%;justify-content:center;">
        Sign In Now →
      </a>
    </div>

  </div>
</section>

<script>
// Check if there's a reset token in URL (from email link)
document.addEventListener('DOMContentLoaded', function() {
  const urlParams = new URLSearchParams(window.location.search);
  const token = urlParams.get('token');
  if (token) {
    showResetPasswordForm(token);
  }
});

function requestPasswordReset() {
  const email = document.getElementById('reset-email').value.trim();
  if (!email) {
    showToast('Please enter your email address.', 'error', 'Error');
    return;
  }
  if (!email.includes('@')) {
    showToast('Please enter a valid email address.', 'error', 'Error');
    return;
  }

  fetch('password_reset_request.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ email })
  })
    .then(res => res.json())
    .then(data => {
      if (data.status !== 'success') {
        throw new Error(data.message || 'Could not send reset email.');
      }

      document.getElementById('step1-request').style.display = 'none';
      document.getElementById('step2-sent').style.display = 'block';
      document.getElementById('display-email').textContent = email;
      showToast('Reset link sent to your email.', 'success', 'Email Sent');
    })
    .catch(err => {
      showToast(err.message, 'error', 'Error');
    });
}

function goBackToEmail() {
  document.getElementById('step2-sent').style.display = 'none';
  document.getElementById('step1-request').style.display = 'block';
  document.getElementById('reset-email').value = '';
}

function resendResetEmail() {
  const email = document.getElementById('display-email').textContent;
  document.getElementById('reset-email').value = email;
  requestPasswordReset();
}

function showResetPasswordForm(token) {
  fetch('password_reset_verify.php?token=' + encodeURIComponent(token))
    .then(res => res.json())
    .then(data => {
      if (data.status !== 'success') {
        throw new Error(data.message || 'Invalid or expired reset link.');
      }

      document.getElementById('step1-request').style.display = 'none';
      document.getElementById('step2-sent').style.display = 'none';
      document.getElementById('step3-reset').style.display = 'block';
      document.getElementById('reset-token').value = token;
      document.getElementById('password-strength').style.display = 'block';
      document.getElementById('new-password').addEventListener('input', checkPasswordStrength);
    })
    .catch(err => {
      showToast(err.message, 'error', 'Error');
      setTimeout(() => window.location.href = 'login.php', 2000);
    });
}

function checkPasswordStrength() {
  const pwd = document.getElementById('new-password').value;
  let strength = 0;
  
  if (pwd.length >= 8) strength++;
  if (pwd.length >= 12) strength++;
  if (/[a-z]/.test(pwd) && /[A-Z]/.test(pwd)) strength++;
  if (/\d/.test(pwd)) strength++;
  if (/[!@#$%^&*]/.test(pwd)) strength++;

  const bar = document.getElementById('strength-bar');
  const widths = [0, 20, 40, 60, 80, 100];
  bar.style.width = widths[strength] + '%';
  
  const colors = ['#e44', '#ff9500', '#ffc107', '#90ee90', '#1a7a4a'];
  bar.style.background = colors[Math.max(0, strength - 1)];
}

function togglePasswordVisibility(fieldId) {
  const field = document.getElementById(fieldId);
  field.type = field.type === 'password' ? 'text' : 'password';
}

function resetPassword() {
  const newPwd = document.getElementById('new-password').value;
  const confirmPwd = document.getElementById('confirm-password').value;
  const token = document.getElementById('reset-token').value;

  if (!newPwd || !confirmPwd) {
    showToast('Please fill in all fields.', 'error', 'Error');
    return;
  }
  if (newPwd.length < 8) {
    showToast('Password must be at least 8 characters.', 'error', 'Error');
    return;
  }
  if (newPwd !== confirmPwd) {
    showToast('Passwords do not match.', 'error', 'Error');
    return;
  }

  fetch('password_reset_update.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      token,
      password: newPwd,
      confirm_password: confirmPwd
    })
  })
    .then(res => res.json())
    .then(data => {
      if (data.status !== 'success') {
        throw new Error(data.message || 'Could not reset password.');
      }

      document.getElementById('step3-reset').style.display = 'none';
      document.getElementById('step4-success').style.display = 'block';
      showToast('Password reset successfully!', 'success', 'Success');
      setTimeout(() => {
        window.location.href = 'login.php';
      }, 3000);
    })
    .catch(err => {
      showToast(err.message, 'error', 'Error');
    });
}
</script>

<?php include '_footer.php'; ?>
