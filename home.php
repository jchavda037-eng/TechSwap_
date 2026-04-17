<?php
// home.php — Home Page
session_start();
$pageTitle = 'TechSwap — Buy & Sell Used Electronics';
$activePage = 'home';
include '_header.php';
?>

<!-- ============ HERO ============ -->
<section class="hero">
  <div class="container">
    <div class="hero-inner">
      <div class="hero-content">
        <div class="hero-eyebrow fade-in">
          <span></span> Live marketplace · Thousands of listings
        </div>
        <h1 class="fade-in fade-in-1">
          Buy &amp; Sell<br><em>Pre-owned</em><br>Electronics
        </h1>
        <p class="hero-sub fade-in fade-in-2">
          From flagship phones to gaming laptops — discover verified second-hand tech at unbeatable prices. Global community, trusted sellers.
        </p>
        <div class="hero-actions fade-in fade-in-2">
          <a href="browse.php" class="btn btn-primary btn-lg">Browse Listings</a>
          <a href="categories.php" class="btn btn-outline btn-lg">View Categories</a>
        </div>
        <div class="hero-stats fade-in fade-in-3">
          <div>
            <div class="hero-stat-num count-up" data-val="12">+</div>
            <div class="hero-stat-label">Active listings</div>
          </div>
          <div>
            <div class="hero-stat-num count-up" data-val="8.4"></div>
            <div class="hero-stat-label">Happy users</div>
          </div>
          <div>
            <div class="hero-stat-num count-up" data-val="4.9" data-suffix="★"></div>
            <div class="hero-stat-label">Trust rating</div>
          </div>
        </div>
      </div>
      <div class="hero-visual fade-in fade-in-2">
        <div class="hero-search-bar">
          <select id="heroCategory">
            <option>All Categories</option>
            <option>Phones</option>
            <option>Laptops</option>
            <option>Tablets</option>
            <option>Accessories</option>
          </select>
          <input type="text" id="heroSearchInput" placeholder="What are you looking for?">
          <button class="btn btn-primary" onclick="doHeroSearch()">Search</button>
        </div>
        <div class="hero-cards" id="heroCards">
          <!-- Filled by JS -->
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ QUICK CATEGORIES ============ -->
<section class="section-sm" style="padding-top:0;">
  <div class="container">
    <div class="section-header">
      <div class="tag">Shop by Category</div>
      <h2>What are you looking for?</h2>
      <p>Browse our curated selection of second-hand electronics across all major categories.</p>
    </div>
    <div class="categories-grid">
      <div class="category-card scroll-reveal" onclick="window.location='browse.php?category=Phones'">
        <span class="category-icon floating">📱</span>
        <div class="category-name">Phones</div>
        <div class="category-count" id="cat-count-Phones">0 listings</div>
      </div>
      <div class="category-card scroll-reveal" onclick="window.location='browse.php?category=Tablets'" style="animation-delay: 0.1s">
        <span class="category-icon floating-delayed">📟</span>
        <div class="category-name">Tablets</div>
        <div class="category-count" id="cat-count-Tablets">0 listings</div>
      </div>
      <div class="category-card scroll-reveal" onclick="window.location='browse.php?category=Laptops'" style="animation-delay: 0.2s">
        <span class="category-icon floating">💻</span>
        <div class="category-name">Laptops</div>
        <div class="category-count" id="cat-count-Laptops">0 listings</div>
      </div>
      <div class="category-card scroll-reveal" onclick="window.location='browse.php?category=Accessories'" style="animation-delay: 0.3s">
        <span class="category-icon floating-delayed">🎧</span>
        <div class="category-name">Accessories</div>
        <div class="category-count" id="cat-count-Accessories">0 listings</div>
      </div>
      <div class="category-card scroll-reveal" onclick="window.location='browse.php?category=Gaming'" style="animation-delay: 0.4s">
        <span class="category-icon floating">🎮</span>
        <div class="category-name">Gaming</div>
        <div class="category-count" id="cat-count-Gaming">0 listings</div>
      </div>
    </div>
  </div>
</section>

<!-- ============ FEATURED LISTINGS PREVIEW ============ -->
<section class="section" style="background:var(--bg2);">
  <div class="container">
    <div class="section-header">
      <div class="tag">Marketplace</div>
      <h2>Latest Listings</h2>
      <p>Fresh devices added by verified sellers every day. Find your next tech upgrade.</p>
    </div>
    <div class="products-grid" id="homeProductsGrid" style="grid-template-columns:repeat(3,1fr);">
      <!-- Filled by JS -->
    </div>
    <div style="text-align:center;margin-top:40px;">
      <a href="browse.php" class="btn btn-outline btn-lg">View All Listings →</a>
    </div>
  </div>
</section>

<!-- ============ HOW IT WORKS ============ -->
<section class="section" id="how">
  <div class="container">
    <div class="section-header">
      <div class="tag">How It Works</div>
      <h2>Simple. Fast. Trusted.</h2>
      <p>TechSwap makes buying and selling second-hand electronics effortless for everyone.</p>
    </div>
    <div class="hiw-grid">
      <div class="hiw-card scroll-reveal">
        <div class="hiw-number">1</div>
        <div class="hiw-icon floating">📋</div>
        <h3>List Your Device</h3>
        <p>Create a free listing with device details, condition, and your asking price. Add a description and location to attract the right buyers.</p>
      </div>
      <div class="hiw-card scroll-reveal" style="transition-delay: 0.1s">
        <div class="hiw-number">2</div>
        <div class="hiw-icon floating-delayed">💬</div>
        <h3>Connect with Buyers</h3>
        <p>Interested buyers reach out directly via WhatsApp or our messaging system. Negotiate, answer questions, and close the deal on your terms.</p>
      </div>
      <div class="hiw-card scroll-reveal" style="transition-delay: 0.2s">
        <div class="hiw-number">3</div>
        <div class="hiw-icon floating">✅</div>
        <h3>Sell &amp; Get Paid</h3>
        <p>Complete the transaction securely. Choose self-pickup or arrange delivery. Funds transferred safely — everyone walks away happy.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ SELL CTA ============ -->
<section class="section">
  <div class="container">
    <div class="sell-cta">
      <div class="sell-cta-inner">
        <div>
          <h2>Turn Your Old Tech<br>Into Cash Today</h2>
          <p>Join thousands of sellers who've turned their unused devices into money. It's free to list — you only pay when you sell.</p>
          <div class="sell-steps">
            <div class="sell-step">
              <div class="sell-step-num">1</div>
              <div class="sell-step-text">
                <div class="sell-step-title">List Your Device</div>
                Add photos, specs, and your price in minutes
              </div>
            </div>
            <div class="sell-step">
              <div class="sell-step-num">2</div>
              <div class="sell-step-text">
                <div class="sell-step-title">Connect with Buyers</div>
                Get inquiries directly via WhatsApp
              </div>
            </div>
            <div class="sell-step">
              <div class="sell-step-num">3</div>
              <div class="sell-step-text">
                <div class="sell-step-title">Get Paid Securely</div>
                Accept payment and ship or meet up
              </div>
            </div>
          </div>
        </div>
        <div>
          <a href="browse.php" class="btn btn-primary btn-lg" style="white-space:nowrap;">
            Browse Listings →
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ TESTIMONIALS ============ -->
<section class="section" style="background:var(--bg2);">
  <div class="container">
    <div class="section-header">
      <div class="tag">Reviews</div>
      <h2>Loved by Thousands</h2>
      <p>Real stories from real buyers and sellers in our community.</p>
    </div>
    <div class="testimonials-grid">
      <div class="testimonial-card scroll-reveal">
        <div class="testimonial-stars">★★★★★</div>
        <p class="testimonial-text">"Sold my old iPhone within 48 hours of listing. The process was incredibly smooth and the buyer was genuine. TechSwap is my go-to for all electronics resales now."</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">MR</div>
          <div>
            <div class="testimonial-name">Marcus R.</div>
            <div class="testimonial-role">Seller · New York, USA</div>
          </div>
        </div>
      </div>
      <div class="testimonial-card scroll-reveal" style="transition-delay: 0.1s">
        <div class="testimonial-stars">★★★★★</div>
        <p class="testimonial-text">"Found a Like New MacBook Pro for 40% less than retail. The listing was accurate, the seller was responsive, and delivery was fast. Absolutely recommend!"</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">PL</div>
          <div>
            <div class="testimonial-name">Priya L.</div>
            <div class="testimonial-role">Buyer · London, UK</div>
          </div>
        </div>
      </div>
      <div class="testimonial-card scroll-reveal" style="transition-delay: 0.2s">
        <div class="testimonial-stars">★★★★☆</div>
        <p class="testimonial-text">"Great marketplace for electronics. I've bought three devices and sold two. The WhatsApp integration makes communication super easy."</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">AK</div>
          <div>
            <div class="testimonial-name">Ahmed K.</div>
            <div class="testimonial-role">Buyer &amp; Seller · Dubai, UAE</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ NEWSLETTER ============ -->
<section class="section">
  <div class="container">
    <div class="newsletter">
      <h2>Stay in the Loop</h2>
      <p>Get notified about new listings, exclusive deals, and buying guides — straight to your inbox.</p>
      <form class="newsletter-form" onsubmit="handleNewsletter(event)">
        <input type="email" placeholder="Enter your email address…" required>
        <button type="submit" class="btn btn-primary">Subscribe</button>
      </form>
      <p style="font-size:0.78rem;color:var(--text3);margin-top:14px;margin-bottom:0;">No spam, ever. Unsubscribe anytime.</p>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
  function tryRenderHome() {
    if (typeof state !== 'undefined') {
      const grid = document.getElementById('homeProductsGrid');
      if (!grid) return;
      if (state.products.length > 0) {
        grid.innerHTML = state.products.slice(0, 3).map((p, idx) => {
          let html = productCard(p);
          // inject scroll reveal into product card html for homepage
          return html.replace('class="product-card"', `class="product-card scroll-reveal" style="transition-delay:${idx*0.1}s"`);
        }).join('');
      } else {
        grid.innerHTML = `<div style="grid-column:1/-1;text-align:center;padding:60px 20px;color:var(--text2);">
          <div style="font-size:3rem;margin-bottom:12px;">📦</div>
          <h3 style="margin-bottom:8px;">No listings yet</h3>
          <p style="margin-bottom:20px;font-size:0.9rem;">Browse our curated selection of pre-owned electronics.</p>
          <a href="browse.php" class="btn btn-primary">Start Browsing →</a>
        </div>`;
      }
      updateCategoryCounts();
      
      // Let the global observer handle the newly added cards
      document.querySelectorAll('#homeProductsGrid .scroll-reveal').forEach(el => {
        if(window.tsObserver) window.tsObserver.observe(el);
      });
      
    } else {
      setTimeout(tryRenderHome, 100);
    }
  }
  tryRenderHome();
});
</script>

<?php include '_footer.php'; ?>
