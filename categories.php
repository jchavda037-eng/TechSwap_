<?php
// categories.php — Categories, Brands & Sell CTA Page
session_start();
$pageTitle = 'Categories — TechSwap';
$activePage = 'categories';
include '_header.php';
?>

<!-- ============ CATEGORIES ============ -->
<section class="section-sm" id="categories" style="padding-top: 64px;">
  <div class="container">
    <div class="section-header">
      <div class="tag">Shop by Category</div>
      <h2>What are you looking for?</h2>
      <p>Browse our curated selection of second-hand electronics across all major categories.</p>
    </div>
    <div class="categories-grid">
      <div class="category-card scroll-reveal" onclick="filterCategory('Phones')">
        <span class="category-icon floating">📱</span>
        <div class="category-name">Phones</div>
        <div class="category-count" id="cat-count-Phones">0 listings</div>
      </div>
      <div class="category-card scroll-reveal" onclick="filterCategory('Tablets')" style="animation-delay: 0.1s">
        <span class="category-icon floating-delayed">📟</span>
        <div class="category-name">Tablets</div>
        <div class="category-count" id="cat-count-Tablets">0 listings</div>
      </div>
      <div class="category-card scroll-reveal" onclick="filterCategory('Laptops')" style="animation-delay: 0.2s">
        <span class="category-icon floating">💻</span>
        <div class="category-name">Laptops</div>
        <div class="category-count" id="cat-count-Laptops">0 listings</div>
      </div>
      <div class="category-card scroll-reveal" onclick="filterCategory('Accessories')" style="animation-delay: 0.3s">
        <span class="category-icon floating-delayed">🎧</span>
        <div class="category-name">Accessories</div>
        <div class="category-count" id="cat-count-Accessories">0 listings</div>
      </div>
      <div class="category-card scroll-reveal" onclick="filterCategory('Gaming')" style="animation-delay: 0.4s">
        <span class="category-icon floating">🎮</span>
        <div class="category-name">Gaming</div>
        <div class="category-count" id="cat-count-Gaming">0 listings</div>
      </div>
    </div>
  </div>
</section>

<!-- ============ BRANDS ============ -->
<section class="section-sm">
  <div class="container">
    <div class="section-header">
      <div class="tag">Popular Brands</div>
      <h2>Shop by Brand</h2>
    </div>
  </div>
  <div class="brands-wrapper">
    <div class="brands-track">
      <!-- Original Set -->
      <div class="brand-chip scroll-reveal" onclick="searchBrand('Apple')">🍎 Apple</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('Samsung')">🌟 Samsung</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('Google')">🔵 Google</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('Sony')">⬛ Sony</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('Dell')">💠 Dell</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('HP')">🔷 HP</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('Lenovo')">⬜ Lenovo</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('OnePlus')">🔴 OnePlus</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('ASUS')">🎯 ASUS</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('Microsoft')">🪟 Microsoft</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('Xiaomi')">🟠 Xiaomi</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('Huawei')">🌐 Huawei</div>
      
      <!-- Duplicate Set for infinite scroll -->
      <div class="brand-chip scroll-reveal" onclick="searchBrand('Apple')">🍎 Apple</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('Samsung')">🌟 Samsung</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('Google')">🔵 Google</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('Sony')">⬛ Sony</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('Dell')">💠 Dell</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('HP')">🔷 HP</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('Lenovo')">⬜ Lenovo</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('OnePlus')">🔴 OnePlus</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('ASUS')">🎯 ASUS</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('Microsoft')">🪟 Microsoft</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('Xiaomi')">🟠 Xiaomi</div>
      <div class="brand-chip scroll-reveal" onclick="searchBrand('Huawei')">🌐 Huawei</div>
    </div>
  </div>
</section>

<!-- ============ SELL CTA ============ -->
<section class="section" id="sell">
  <div class="container">
    <div class="sell-cta scroll-reveal">
      <div class="sell-cta-inner">
        <div>
          <h2>Turn Your Old Tech<br>Into Cash Today</h2>
          <p>Join thousands of sellers who've turned their unused devices into money. It's free to list — you only pay when you sell.</p>
          <div class="sell-steps">
            <div class="sell-step scroll-reveal">
              <div class="sell-step-num">1</div>
              <div class="sell-step-text">
                <div class="sell-step-title">List Your Device</div>
                Add photos, specs, and your price in minutes
              </div>
            </div>
            <div class="sell-step scroll-reveal" style="transition-delay: 0.1s">
              <div class="sell-step-num">2</div>
              <div class="sell-step-text">
                <div class="sell-step-title">Connect with Buyers</div>
                Get inquiries directly via WhatsApp
              </div>
            </div>
            <div class="sell-step scroll-reveal" style="transition-delay: 0.2s">
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
            Browse All →
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '_footer.php'; ?>
