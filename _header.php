<?php
// _header.php
if (session_status() === PHP_SESSION_NONE) session_start();
$isLoggedIn = !empty($_SESSION['user_id']);
$isAdmin    = !empty($_SESSION['is_admin']);
$userName   = $_SESSION['user_name'] ?? '';
$userEmail  = $_SESSION['user_email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($pageTitle ?? 'TechSwap'); ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
  <?php include '_styles.php'; ?>
</head>
<body>

<?php if ($isLoggedIn): ?>
<script>
  localStorage.setItem('ts_user', JSON.stringify({
    id: "<?php echo $_SESSION['user_id']; ?>",
    name: "<?php echo htmlspecialchars($_SESSION['user_name'], ENT_QUOTES); ?>",
    email: "<?php echo htmlspecialchars($userEmail, ENT_QUOTES); ?>"
  }));
</script>
<?php else: ?>
<script>
  localStorage.removeItem('ts_user');
</script>
<?php endif; ?>
<!-- ANNOUNCEMENT BAR -->
<div class="announce-bar">
  🔥 Verified sellers only — every listing is reviewed before going live.
</div>

<!-- HEADER -->
<header id="header">
  <div class="header-inner">

    <!-- LOGO -->
    <a href="home.php" class="logo">
      <div class="logo-icon">⚡</div>
      Tech<span>Swap</span>
    </a>

    <!-- SEARCH -->
    <div class="header-search">
      <input type="text" id="headerSearch" placeholder="Search phones, laptops, tablets…" autocomplete="off">
      <button class="header-search-btn" onclick="doSearch()">🔍</button>
    </div>

    <!-- NAV LINKS (desktop) — NO sell link -->
    <nav class="nav-links">
      <a href="home.php"       class="<?php echo ($activePage==='home')       ? 'active':'' ?>">Home</a>
      <a href="browse.php"     class="<?php echo ($activePage==='browse')     ? 'active':'' ?>">Browse</a>
      <?php if ($isLoggedIn): ?>
      <a href="orders.php"     class="<?php echo ($activePage==='orders')     ? 'active':'' ?>">Orders</a>
      <?php endif; ?>
      <a href="categories.php" class="<?php echo ($activePage==='categories') ? 'active':'' ?>">Categories</a>
      <a href="guides.php"     class="<?php echo ($activePage==='guides')     ? 'active':'' ?>">Guides</a>
      <a href="faq.php"        class="<?php echo ($activePage==='faq')        ? 'active':'' ?>">FAQ</a>
      <?php if ($isAdmin): ?>
      <a href="admin.php"      class="<?php echo ($activePage==='admin')      ? 'active':'' ?>" style="color:var(--accent)">Admin</a>
      <?php endif; ?>
    </nav>

    <!-- ACTIONS -->
    <div class="header-actions">

      <!-- Theme toggle -->
      <button class="theme-toggle" onclick="toggleTheme()" title="Toggle theme">🌙</button>

      <?php if ($isLoggedIn): ?>
        <!-- Wishlist -->
        <button class="icon-btn" onclick="openWishlist()" title="Wishlist">
          ♡ <span class="count" id="wishlistCount" style="display:none">0</span>
        </button>
        <!-- Cart -->
        <button class="icon-btn" onclick="openCart()" title="Cart">
          🛒 <span class="count" id="cartCount" style="display:none">0</span>
        </button>
        <!-- Account -->
        <a href="account.php" class="icon-btn" title="My Account">👤</a>
        <a href="orders.php" class="btn btn-outline btn-sm" title="My Orders">Orders</a>
        <!-- Logout -->
        <a href="logout.php" class="btn btn-outline btn-sm">Logout</a>
      <?php else: ?>
        <a href="login.php" class="btn btn-primary btn-sm">Login / Register</a>
      <?php endif; ?>

      <!-- Mobile menu -->
      <button class="mobile-menu-btn" id="mobileMenuBtn" onclick="toggleMobileNav()">☰</button>
    </div>
  </div>
</header>

<!-- MOBILE NAV — NO sell link -->
<nav class="mobile-nav" id="mobileNav">
  <a href="home.php">Home</a>
  <a href="browse.php">Browse</a>
  <?php if ($isLoggedIn): ?>
  <a href="orders.php">Orders</a>
  <?php endif; ?>
  <a href="categories.php">Categories</a>
  <a href="guides.php">Guides</a>
  <a href="faq.php">FAQ</a>
  <?php if ($isAdmin): ?>
  <a href="admin.php" style="color:var(--accent)">Admin Panel</a>
  <?php endif; ?>
  <?php if ($isLoggedIn): ?>
  <a href="account.php">My Account</a>
  <a href="logout.php">Logout</a>
  <?php else: ?>
  <a href="login.php">Login / Register</a>
  <?php endif; ?>
</nav>

<!-- ========== WISHLIST SIDE PANEL ========== -->
<div class="panel-backdrop" id="panelBackdrop" onclick="closePanels()"></div>

<div class="side-panel" id="wishlistPanel">
  <div class="side-panel-header">
    <h3>My Wishlist</h3>
    <button class="modal-close" onclick="closeWishlist()">✕</button>
  </div>
  <div class="side-panel-body" id="wishlistBody">
    <div class="empty-state">
      <div class="empty-icon">♡</div>
      <h4>Your wishlist is empty</h4>
      <p>Save items you love while browsing.</p>
    </div>
  </div>
  <div class="side-panel-footer">
    <a href="browse.php" class="btn btn-primary" style="width:100%;justify-content:center;">Browse Listings</a>
  </div>
</div>

<!-- ========== CART SIDE PANEL ========== -->
<div class="side-panel" id="cartPanel">
  <div class="side-panel-header">
    <h3>My Cart</h3>
    <button class="modal-close" onclick="closeCart()">✕</button>
  </div>
  <div class="side-panel-body" id="cartBody">
    <div class="empty-state">
      <div class="empty-icon">🛒</div>
      <h4>Your cart is empty</h4>
      <p>Add items from the browse page.</p>
    </div>
  </div>
  <div class="side-panel-footer" id="cartFooter">
    <div class="cart-total" style="display:flex; justify-content:space-between; margin-bottom:12px; font-weight:bold;">
      <span>Total</span><span id="cartTotal">$0</span>
    </div>
    <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="handleCheckout()">Proceed to Checkout</button>
  </div>
</div>

<!-- TOAST CONTAINER -->
<div class="toast-container" id="toastContainer"></div>

<!-- ========== SHARED JS ========== -->
<script>
// ── Theme ──────────────────────────────────────────────
const html = document.documentElement;
(function(){ const t = localStorage.getItem('theme') || 'light'; html.setAttribute('data-theme', t); })();
function toggleTheme(){
  const t = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
  html.setAttribute('data-theme', t);
  localStorage.setItem('theme', t);
  document.querySelector('.theme-toggle').textContent = t === 'dark' ? '☀️' : '🌙';
}

// ── Header scroll ──────────────────────────────────────
window.addEventListener('scroll', () => {
  document.getElementById('header').classList.toggle('scrolled', window.scrollY > 20);
});

// ── Mobile nav ─────────────────────────────────────────
function toggleMobileNav(){
  document.getElementById('mobileNav').classList.toggle('open');
}

// ── Search ─────────────────────────────────────────────
function doSearch(){
  const q = document.getElementById('headerSearch').value.trim();
  if (q) window.location.href = 'browse.php?q=' + encodeURIComponent(q);
}
document.getElementById('headerSearch').addEventListener('keydown', e => { if(e.key==='Enter') doSearch(); });

// ── Initialization ─────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  if (typeof updateCartCount === 'function') updateCartCount();
  if (typeof updateWishlistCount === 'function') updateWishlistCount();
});
</script>
