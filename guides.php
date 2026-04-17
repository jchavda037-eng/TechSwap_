<?php
// guides.php — Buying Guides / Blog Page
session_start();
$pageTitle = 'Buying Guides — TechSwap';
$activePage = 'guides';
include '_header.php';
?>

<!-- ============ BLOG / BUYING GUIDES ============ -->
<section class="section" id="blog" style="background: var(--bg2); padding-top: 64px;">
  <div class="container">
    <div class="section-header">
      <div class="tag">Buying Guides</div>
      <h2>Make Smarter Purchases</h2>
      <p>Expert tips, brand comparisons, and guides to help you buy and sell with confidence.</p>
    </div>
    <div class="blog-grid" id="blogGrid">
      <!-- Filled by JS -->
    </div>
    <div style="text-align:center;margin-top:40px;">
      <button class="btn btn-outline">View All Articles →</button>
    </div>
  </div>
</section>

<!-- ============ NEWSLETTER ============ -->
<section class="section">
  <div class="container">
    <div class="newsletter">
      <h2>Get Guides in Your Inbox</h2>
      <p>Subscribe for weekly buying tips, price alerts, and exclusive deals on used electronics.</p>
      <form class="newsletter-form" onsubmit="handleNewsletter(event)">
        <input type="email" placeholder="Enter your email address…" required>
        <button type="submit" class="btn btn-primary">Subscribe</button>
      </form>
      <p style="font-size:0.78rem;color:var(--text3);margin-top:14px;margin-bottom:0;">No spam, ever. Unsubscribe anytime.</p>
    </div>
  </div>
</section>

<?php include '_footer.php'; ?>
