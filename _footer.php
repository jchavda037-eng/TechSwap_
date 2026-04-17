
<!-- ============ FOOTER ============ -->
<footer>
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <div class="logo" style="margin-bottom:16px;">
          <div class="logo-icon">⚡</div>
          Tech<span style="color:var(--accent)">Swap</span>
        </div>
        <p class="footer-desc">The global marketplace for second-hand electronics. Buy, sell, and discover trusted pre-owned tech from a community of verified sellers worldwide.</p>
        <div class="footer-social">
          <div class="social-btn" title="Twitter/X">𝕏</div>
          <div class="social-btn" title="Instagram">📷</div>
          <div class="social-btn" title="Facebook">f</div>
          <div class="social-btn" title="WhatsApp" onclick="openWhatsApp('')">💬</div>
        </div>
      </div>
      <div class="footer-col">
        <h4>Marketplace</h4>
        <ul class="footer-links">
          <li><a href="browse.php">Browse Listings</a></li>
          <li><a href="categories.php">Categories</a></li>
          <li><a href="home.php#how">How It Works</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Support</h4>
        <ul class="footer-links">
          <li><a href="faq.php">FAQ</a></li>
          <li><a href="guides.php">Buying Guides</a></li>
          <li><a href="#">Seller Tips</a></li>
          <li><a href="#">Safety Tips</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Company</h4>
        <ul class="footer-links">
          <li><a href="#">About TechSwap</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Terms of Service</a></li>
          <li><a href="#">Careers</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© <?php echo date('Y'); ?> TechSwap. All rights reserved.</span>
      <span>Made with ❤ for the global tech community</span>
    </div>
  </div>
</footer>

<!-- ============================== MODALS ============================== -->

<!-- AUTH MODAL -->
<div class="modal-overlay" id="authModal">
  <div class="modal">
    <div class="modal-header">
      <h3 id="authModalTitle">Sign In</h3>
      <button class="modal-close" onclick="closeModal('authModal')">✕</button>
    </div>
    <div id="authModalBody"><!-- Filled by JS --></div>
  </div>
</div>

<!-- SELL MODAL -->
<div class="modal-overlay sell-modal" id="sellModal">
  <div class="modal" style="max-width:680px;">
    <div class="modal-header">
      <h3>List Your Device</h3>
      <button class="modal-close" onclick="closeModal('sellModal')">✕</button>
    </div>
    <form onsubmit="handleListSubmit(event)">
      <div class="form-row">
        <div class="form-group">
          <label>Device Name *</label>
          <input type="text" class="form-control" id="sell-name" placeholder="e.g. iPhone 15 Pro Max" required>
        </div>
        <div class="form-group">
          <label>Brand *</label>
          <select class="form-control" id="sell-brand" required>
            <option value="">Select Brand</option>
            <option>Apple</option><option>Samsung</option><option>Google</option>
            <option>Sony</option><option>Dell</option><option>HP</option>
            <option>Lenovo</option><option>ASUS</option><option>OnePlus</option>
            <option>Microsoft</option><option>Xiaomi</option><option>Huawei</option>
            <option>Other</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Model *</label>
          <input type="text" class="form-control" id="sell-model" placeholder="e.g. 256GB, Space Black" required>
        </div>
        <div class="form-group">
          <label>Category *</label>
          <select class="form-control" id="sell-category" required>
            <option value="">Select Category</option>
            <option>Phones</option><option>Tablets</option><option>Laptops</option>
            <option>Accessories</option><option>Gaming</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Price (USD) *</label>
          <input type="number" class="form-control" id="sell-price" placeholder="0.00" min="1" required>
        </div>
        <div class="form-group">
          <label>Original Price (optional)</label>
          <input type="number" class="form-control" id="sell-original-price" placeholder="For discount badge">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Condition *</label>
          <select class="form-control" id="sell-condition" required>
            <option value="">Select Condition</option>
            <option>New</option><option>Like New</option><option>Used</option>
            <option>Refurbished</option><option>Open Box</option>
          </select>
        </div>
        <div class="form-group">
          <label>Location *</label>
          <input type="text" class="form-control" id="sell-location" placeholder="City, Country" required>
        </div>
      </div>
      <div class="form-group">
        <label>Description *</label>
        <textarea class="form-control" id="sell-description" rows="3" placeholder="Describe the device, its history, any accessories included…" required></textarea>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Key Specs (e.g. 256GB, 8GB RAM)</label>
          <input type="text" class="form-control" id="sell-specs" placeholder="Storage, RAM, Screen size…">
        </div>
        <div class="form-group">
          <label>Shipping Option *</label>
          <select class="form-control" id="sell-shipping" required>
            <option value="">Select Option</option>
            <option>Delivery Only</option>
            <option>Self Pickup Only</option>
            <option>Both (Delivery &amp; Pickup)</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label>WhatsApp Number (for buyer inquiries) *</label>
        <input type="tel" class="form-control" id="sell-whatsapp" placeholder="+1234567890" required>
        <div class="form-hint">Buyers will contact you directly on WhatsApp.</div>
      </div>
      <div class="form-group">
        <label>Boost this listing?</label>
        <select class="form-control" id="sell-boost">
          <option value="no">No boost (Free)</option>
          <option value="featured">Featured Listing (+$4.99)</option>
        </select>
        <div class="form-hint">Featured listings appear at the top of search results.</div>
      </div>
      <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center;">
        📲 Publish Listing
      </button>
    </form>
  </div>
</div>

<!-- PRODUCT DETAIL MODAL -->
<div class="modal-overlay product-modal" id="productModal">
  <div class="modal" style="max-width:820px;padding:0;">
    <div class="product-modal-grid" id="productModalContent"><!-- Filled by JS --></div>
  </div>
</div>

<!-- ORDER MODAL (Buy Now) -->
<div class="modal-overlay" id="orderModal">
  <div class="modal">
    <div class="modal-header">
      <h3>Complete Purchase</h3>
      <button class="modal-close" onclick="closeModal('orderModal')">✕</button>
    </div>
    <div id="orderModalContent"></div>
  </div>
</div>

<?php include __DIR__ . '/_scripts.php'; ?>
</body>
</html>
