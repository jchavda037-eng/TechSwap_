<?php
session_start();
include "db.php";

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$pageTitle = 'My Account — TechSwap';
$activePage = 'account';
include '_header.php';
?>

<!-- ============ ACCOUNT PAGE ============ -->
<section class="section" style="padding-top: 64px; background: var(--bg2);">
  <div class="container" style="max-width: 960px;">
    <div class="section-header">
      <div class="tag">Account</div>
      <h2>My Account</h2>
      <p>Manage your profile, listings, and orders.</p>
    </div>

    <div style="display: grid; grid-template-columns: 240px 1fr; gap: 36px; margin-top: 40px;">
      <!-- SIDEBAR NAV -->
      <div>
        <nav class="account-nav">
          <button class="account-nav-item active" onclick="switchTab('profile')" data-tab="profile">
            👤 Profile
          </button>
          <button class="account-nav-item" onclick="switchTab('listings')" data-tab="listings">
            📋 My Listings
          </button>
          <button class="account-nav-item" onclick="switchTab('orders')" data-tab="orders">
            📦 Orders
          </button>
          <button class="account-nav-item" onclick="switchTab('purchases')" data-tab="purchases">
            🛒 Purchases
          </button>
          <button class="account-nav-item" onclick="switchTab('wishlist')" data-tab="wishlist">
            ♡ Wishlist
          </button>
          <button class="account-nav-item" onclick="switchTab('security')" data-tab="security">
            🔒 Security
          </button>
          <button class="account-nav-item" onclick="switchTab('notifications')" data-tab="notifications">
            🔔 Notifications
          </button>
        </nav>
      </div>

      <!-- CONTENT AREA -->
      <div>
        <!-- PROFILE TAB -->
        <div id="tab-profile" class="account-tab active" style="background: var(--surface); border: 1.5px solid var(--border); border-radius: var(--radius); padding: 32px;">
          <h3 style="margin-bottom: 24px; font-size: 1.2rem;">Personal Information</h3>
          
          <div class="form-row">
            <div class="form-group">
              <label>First Name *</label>
              <input type="text" class="form-control" id="fname" placeholder="John">
            </div>
            <div class="form-group">
              <label>Last Name *</label>
              <input type="text" class="form-control" id="lname" placeholder="Doe">
            </div>
          </div>

          <div class="form-group">
            <label>Email Address *</label>
            <input type="email" class="form-control" id="email" placeholder="you@example.com" disabled style="opacity: 0.6;">
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Phone Number</label>
              <input type="tel" class="form-control" id="phone" placeholder="+1234567890">
            </div>
            <div class="form-group">
              <label>WhatsApp Number (for buyers)</label>
              <input type="tel" class="form-control" id="whatsapp" placeholder="+1234567890">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>City *</label>
              <input type="text" class="form-control" id="city" placeholder="New York">
            </div>
            <div class="form-group">
              <label>Country *</label>
              <select class="form-control" id="country">
                <option>Select Country</option>
                <option>USA</option>
                <option>UK</option>
                <option>Canada</option>
                <option>Australia</option>
                <option>India</option>
                <option>UAE</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label>Bio (optional)</label>
            <textarea class="form-control" id="bio" rows="3" placeholder="Tell other users about yourself…"></textarea>
            <div class="form-hint">Max 160 characters</div>
          </div>

          <button class="btn btn-primary btn-lg" onclick="saveProfile()" style="margin-top: 16px;">
            Save Changes
          </button>
        </div>

        <!-- LISTINGS TAB -->
        <div id="tab-listings" class="account-tab" style="display: none;">
          <h3 style="margin-bottom: 24px; font-size: 1.2rem;">My Listings</h3>
          <div id="userListingsContainer">
            <div style="text-align: center; padding: 60px 20px; color: var(--text2);">
              <div style="font-size: 2.5rem; margin-bottom: 12px;">📋</div>
              <p style="margin-bottom: 20px;">You haven't added any listings yet.</p>
              <a href="browse.php" class="btn btn-primary">Browse Listings →</a>
            </div>
          </div>
        </div>

        <!-- ORDERS TAB -->
        <div id="tab-orders" class="account-tab" style="display: none;">
          <h3 style="margin-bottom: 24px; font-size: 1.2rem;">My Orders</h3>
          <div id="userOrdersContainer">
            <div style="text-align: center; padding: 60px 20px; color: var(--text2);">
              <div style="font-size: 2.5rem; margin-bottom: 12px;">📦</div>
              <p style="margin-bottom: 20px;">You haven't placed any orders yet.</p>
              <a href="browse.php" class="btn btn-primary">Browse Products →</a>
            </div>
          </div>
        </div>

        <!-- PURCHASES TAB -->
        <div id="tab-purchases" class="account-tab" style="display: none;">
          <h3 style="margin-bottom: 24px; font-size: 1.2rem;">Purchase History</h3>
          <div style="text-align: center; padding: 60px 20px; color: var(--text2);">
            <div style="font-size: 2.5rem; margin-bottom: 12px;">🛒</div>
            <p style="margin-bottom: 20px;">No purchases yet.</p>
            <a href="browse.php" class="btn btn-primary">Browse Listings →</a>
          </div>
        </div>

        <!-- WISHLIST TAB -->
        <div id="tab-wishlist" class="account-tab" style="display: none;">
          <h3 style="margin-bottom: 24px; font-size: 1.2rem;">Saved Items</h3>
          <div id="wishlistContainer">
            <div style="text-align: center; padding: 60px 20px; color: var(--text2);">
              <div style="font-size: 2.5rem; margin-bottom: 12px;">♡</div>
              <p style="margin-bottom: 20px;">Your wishlist is empty.</p>
              <a href="browse.php" class="btn btn-primary">Discover Listings →</a>
            </div>
          </div>
        </div>

        <!-- SECURITY TAB -->
        <div id="tab-security" class="account-tab" style="display: none;">
          <h3 style="margin-bottom: 24px; font-size: 1.2rem;">Security Settings</h3>
          
          <div style="background: var(--surface); border: 1.5px solid var(--border); border-radius: var(--radius); padding: 20px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
              <div>
                <h4 style="font-weight: 600; margin-bottom: 4px;">Password</h4>
                <p style="font-size: 0.88rem; color: var(--text2);">Last changed 3 months ago</p>
              </div>
              <button class="btn btn-outline btn-sm" onclick="openPasswordModal()">
                Change Password
              </button>
            </div>
          </div>

          <div style="background: var(--surface); border: 1.5px solid var(--border); border-radius: var(--radius); padding: 20px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <div>
                <h4 style="font-weight: 600; margin-bottom: 4px;">Two-Factor Authentication</h4>
                <p style="font-size: 0.88rem; color: var(--text2);">Disabled — Add extra security to your account</p>
              </div>
              <button class="btn btn-outline btn-sm">
                Enable 2FA
              </button>
            </div>
          </div>

          <div style="background: #fff0eb; border: 1.5px solid #ffccbb; border-radius: var(--radius); padding: 20px;">
            <h4 style="font-weight: 600; margin-bottom: 8px; color: var(--accent);">⚠️ Danger Zone</h4>
            <p style="font-size: 0.88rem; color: var(--text2); margin-bottom: 16px;">Delete your account permanently. This action cannot be undone.</p>
            <button class="btn" style="background: var(--accent); color: #fff;" onclick="deleteAccount()">
              Delete Account
            </button>
          </div>
        </div>

        <!-- NOTIFICATIONS TAB -->
        <div id="tab-notifications" class="account-tab" style="display: none;">
          <h3 style="margin-bottom: 24px; font-size: 1.2rem;">Notification Preferences</h3>
          
          <div style="background: var(--surface); border: 1.5px solid var(--border); border-radius: var(--radius); padding: 24px;">
            <div class="form-group" style="margin-bottom: 20px; display: flex; gap: 12px; align-items: center;">
              <input type="checkbox" id="notify-listings" checked style="accent-color: var(--accent);">
              <div>
                <label for="notify-listings" style="font-weight: 600; margin-bottom: 4px; display: block;">New Listings in Watchlist</label>
                <p style="font-size: 0.82rem; color: var(--text2); margin: 0;">Get notified when new items are added to your watchlist categories.</p>
              </div>
            </div>

            <div class="form-group" style="margin-bottom: 20px; display: flex; gap: 12px; align-items: center;">
              <input type="checkbox" id="notify-messages" checked style="accent-color: var(--accent);">
              <div>
                <label for="notify-messages" style="font-weight: 600; margin-bottom: 4px; display: block;">Messages from Buyers/Sellers</label>
                <p style="font-size: 0.82rem; color: var(--text2); margin: 0;">Get notified about new messages on your listings or purchases.</p>
              </div>
            </div>

            <div class="form-group" style="margin-bottom: 20px; display: flex; gap: 12px; align-items: center;">
              <input type="checkbox" id="notify-newsletter" checked style="accent-color: var(--accent);">
              <div>
                <label for="notify-newsletter" style="font-weight: 600; margin-bottom: 4px; display: block;">Weekly Newsletter</label>
                <p style="font-size: 0.82rem; color: var(--text2); margin: 0;">Get curated listings and deals delivered to your inbox weekly.</p>
              </div>
            </div>

            <div class="form-group" style="display: flex; gap: 12px; align-items: center;">
              <input type="checkbox" id="notify-promo" style="accent-color: var(--accent);">
              <div>
                <label for="notify-promo" style="font-weight: 600; margin-bottom: 4px; display: block;">Promotional Emails</label>
                <p style="font-size: 0.82rem; color: var(--text2); margin: 0;">Receive special offers and promotions.</p>
              </div>
            </div>

            <button class="btn btn-primary" style="margin-top: 20px;" onclick="saveNotifications()">
              Save Preferences
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
.account-nav {
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.account-nav-item {
  text-align: left;
  padding: 12px 16px;
  border-radius: var(--radius-sm);
  background: var(--surface);
  border: 1.5px solid var(--border);
  color: var(--text);
  transition: all var(--transition);
  font-weight: 500;
  cursor: pointer;
}
.account-nav-item:hover {
  border-color: var(--accent);
  color: var(--accent);
}
.account-nav-item.active {
  background: var(--accent);
  color: #fff;
  border-color: var(--accent);
}
.account-tab {
  animation: fadeInUp 0.3s ease;
}
</style>

<script>
function getCurrentUser() {
  return JSON.parse(localStorage.getItem('ts_user') || '{}');
}

function getProfileStorageKey() {
  const user = getCurrentUser();
  return user.id ? `ts_profile_${user.id}` : 'ts_profile_guest';
}

function switchTab(tabName) {
  // Hide all tabs
  document.querySelectorAll('.account-tab').forEach(t => t.style.display = 'none');
  document.querySelectorAll('.account-nav-item').forEach(b => b.classList.remove('active'));
  
  // Show selected tab
  document.getElementById('tab-' + tabName).style.display = 'block';
  document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
  
  // Load tab-specific content
  if (tabName === 'listings') loadMyListings();
  if (tabName === 'orders') loadMyOrders();
  if (tabName === 'wishlist') loadMyWishlist();
}

function saveProfile() {
  const fname = document.getElementById('fname').value.trim();
  const lname = document.getElementById('lname').value.trim();
  const phone = document.getElementById('phone').value.trim();
  const whatsapp = document.getElementById('whatsapp').value.trim();
  const city = document.getElementById('city').value.trim();
  const country = document.getElementById('country').value;
  const bio = document.getElementById('bio').value.trim();

  if (!fname || !lname || !city || !country) {
    showToast('Please fill in all required fields.', 'error', 'Error');
    return;
  }

  const profile = { fname, lname, phone, whatsapp, city, country, bio };
  localStorage.setItem(getProfileStorageKey(), JSON.stringify(profile));
  showToast('Profile saved successfully!', 'success', 'Saved');
}

function loadMyListings() {
  const userEmail = getCurrentUser().email || null;
  if (!userEmail) return;

  const allProducts = JSON.parse(localStorage.getItem('ts_products') || '[]');
  const userListings = allProducts.filter(p => p.seller_email === userEmail);

  const container = document.getElementById('userListingsContainer');
  if (userListings.length === 0) {
    container.innerHTML = `
      <div style="text-align: center; padding: 60px 20px; color: var(--text2);">
        <div style="font-size: 2.5rem; margin-bottom: 12px;">📋</div>
        <p style="margin-bottom: 20px;">You haven't listed anything yet.</p>
        <a href="browse.php" class="btn btn-primary">Browse Listings →</a>
      </div>`;
    return;
  }

  container.innerHTML = `
    <div style="display: grid; gap: 16px;">
      ${userListings.map(p => `
        <div style="background: var(--surface); border: 1.5px solid var(--border); border-radius: var(--radius); padding: 16px; display: grid; grid-template-columns: 80px 1fr auto; gap: 16px; align-items: start;">
          <div style="width: 80px; height: 80px; background: var(--surface2); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 2rem;">
            ${catIcon[p.category] || '📦'}
          </div>
          <div>
            <h4 style="font-weight: 600; margin-bottom: 4px;">${p.name}</h4>
            <p style="font-size: 0.88rem; color: var(--text2); margin-bottom: 8px;">${p.condition} • ${p.location}</p>
            <span class="badge ${conditionBadge[p.condition] || 'badge-used'}">${p.condition}</span>
          </div>
          <div style="text-align: right;">
            <div style="font-weight: 700; color: var(--accent); margin-bottom: 8px;">$${p.price.toFixed(2)}</div>
            <button class="btn btn-ghost btn-sm" onclick="editListing('${p.id}')">Edit</button>
          </div>
        </div>
      `).join('')}
    </div>`;
}

function loadMyOrders() {
  const container = document.getElementById('userOrdersContainer');
  container.innerHTML = `
    <div style="text-align: center; padding: 40px 20px; color: var(--text2);">
      <div style="font-size: 2rem; margin-bottom: 12px;">⏳</div>
      <p>Loading your orders...</p>
    </div>`;

  fetch('user_orders_api.php')
    .then(res => res.json())
    .then(json => {
      if (json.status !== 'success') {
        throw new Error(json.message || 'Failed to load orders.');
      }

      const userOrders = json.data || [];

      if (userOrders.length === 0) {
        container.innerHTML = `
          <div style="text-align: center; padding: 60px 20px; color: var(--text2);">
            <div style="font-size: 2.5rem; margin-bottom: 12px;">📦</div>
            <p style="margin-bottom: 20px;">You haven't placed any orders yet.</p>
            <a href="browse.php" class="btn btn-primary">Browse Products →</a>
          </div>`;
        return;
      }

      container.innerHTML = `
        <div style="display: grid; gap: 20px;">
          ${userOrders.map(order => `
        <div style="background: var(--surface); border: 1.5px solid var(--border); border-radius: var(--radius); padding: 24px;">
          <div style="display: grid; grid-template-columns: 1fr auto; gap: 20px; margin-bottom: 20px;">
            <div>
              <div style="font-size: 0.85rem; color: var(--text3); margin-bottom: 4px;">Order ID</div>
              <h3 style="font-weight: 700; font-size: 1.1rem;">${order.display_order_id || order.order_id}</h3>
              <p style="font-size: 0.9rem; color: var(--text2); margin-top: 8px;">${order.product_name} (${order.product_brand})</p>
            </div>
            <div style="text-align: right;">
              <div style="font-size: 1.8rem; font-weight: 800; color: var(--accent); margin-bottom: 8px;">$${order.total_price.toFixed(2)}</div>
              <div style="padding: 6px 12px; background: ${getOrderStatusBgColor(order.order_status)}; color: ${getOrderStatusColor(order.order_status)}; border-radius: var(--radius-sm); font-weight: 600; font-size: 0.85rem; display: inline-block;">
                ${order.order_status}
              </div>
            </div>
          </div>
          
          <div style="background: var(--bg2); border-radius: var(--radius-sm); padding: 16px; margin-bottom: 20px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; font-size: 0.9rem;">
              <div>
                <div style="color: var(--text3); margin-bottom: 4px;">Order Date</div>
                <div style="font-weight: 600;">${new Date(order.order_date).toLocaleDateString()}</div>
              </div>
              <div>
                <div style="color: var(--text3); margin-bottom: 4px;">Payment Status</div>
                <div style="font-weight: 600; color: ${order.payment_status === 'Paid' ? 'var(--green)' : 'var(--text2)'};">${order.payment_status}</div>
              </div>
              ${order.shipping_date ? `
              <div>
                <div style="color: var(--text3); margin-bottom: 4px;">Shipping Date</div>
                <div style="font-weight: 600;">${new Date(order.shipping_date).toLocaleDateString()}</div>
              </div>
              ` : ''}
              ${order.expected_delivery_date ? `
              <div>
                <div style="color: var(--text3); margin-bottom: 4px;">Expected Delivery</div>
                <div style="font-weight: 600;">${new Date(order.expected_delivery_date).toLocaleDateString()}</div>
              </div>
              ` : ''}
            </div>
          </div>

          ${order.order_status !== 'Cancelled' && order.order_status !== 'Delivered' ? `
          <button class="btn btn-ghost btn-sm" onclick="cancelUserOrder('${order.order_id}')">Cancel Order</button>
          ` : ''}
        </div>
          `).join('')}
        </div>`;
    })
    .catch(err => {
      container.innerHTML = `
        <div style="text-align: center; padding: 60px 20px; color: var(--text2);">
          <div style="font-size: 2.5rem; margin-bottom: 12px;">⚠️</div>
          <p style="margin-bottom: 20px;">${err.message}</p>
          <button class="btn btn-primary" onclick="loadMyOrders()">Try Again</button>
        </div>`;
    });
}

function cancelUserOrder(orderId) {
  if (!confirm('Cancel this order?')) return;
  fetch('user_orders_api.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ action: 'cancel', order_id: Number(orderId) })
  })
    .then(res => res.json())
    .then(json => {
      if (json.status === 'success') {
        showToast('Order cancelled', 'success', 'Cancelled');
        loadMyOrders();
      } else {
        showToast(json.message || 'Cannot cancel this order', 'error', 'Error');
      }
    })
    .catch(() => {
      showToast('Could not cancel the order right now.', 'error', 'Error');
    });
}

function loadMyWishlist() {
  const wishlist = JSON.parse(localStorage.getItem('ts_wishlist') || '[]');
  const container = document.getElementById('wishlistContainer');
  
  if (wishlist.length === 0) {
    container.innerHTML = `
      <div style="text-align: center; padding: 60px 20px; color: var(--text2);">
        <div style="font-size: 2.5rem; margin-bottom: 12px;">♡</div>
        <p style="margin-bottom: 20px;">Your wishlist is empty.</p>
        <a href="browse.php" class="btn btn-primary">Discover Listings →</a>
      </div>`;
    return;
  }

  container.innerHTML = `
    <div style="display: grid; gap: 16px;">
      ${wishlist.map(p => `
        <div style="background: var(--surface); border: 1.5px solid var(--border); border-radius: var(--radius); padding: 16px; display: grid; grid-template-columns: 80px 1fr auto; gap: 16px; align-items: start;">
          <div style="width: 80px; height: 80px; background: var(--surface2); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; font-size: 2rem;">
            ${catIcon[p.category] || '📦'}
          </div>
          <div>
            <h4 style="font-weight: 600; margin-bottom: 4px;">${p.name}</h4>
            <p style="font-size: 0.88rem; color: var(--text2); margin-bottom: 8px;">$${p.price.toFixed(2)}</p>
            <span class="badge ${conditionBadge[p.condition] || 'badge-used'}">${p.condition}</span>
          </div>
          <div style="text-align: right;">
            <button class="btn btn-ghost btn-sm" onclick="removeFromWishlist('${p.id}')">Remove</button>
          </div>
        </div>
      `).join('')}
    </div>`;
}

function removeFromWishlist(productId) {
  let wishlist = JSON.parse(localStorage.getItem('ts_wishlist') || '[]');
  wishlist = wishlist.filter(p => p.id !== productId);
  localStorage.setItem('ts_wishlist', JSON.stringify(wishlist));
  loadMyWishlist();
  showToast('Removed from wishlist', 'success', 'Removed');
}

function openPasswordModal() {
  showToast('In a real app, this would open a password change modal.', 'info', 'Feature');
}

function deleteAccount() {
  if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
    if (confirm('This is permanent. Type your email to confirm deletion.')) {
      localStorage.removeItem(getProfileStorageKey());
      localStorage.removeItem('ts_user');
      window.location.href = 'logout.php';
    }
  }
}

function saveNotifications() {
  showToast('Notification preferences saved!', 'success', 'Saved');
}

function editListing(productId) {
  showToast('Edit feature coming soon!', 'info', 'Coming Soon');
}

// Load profile on page load
document.addEventListener('DOMContentLoaded', function() {
  const params = new URLSearchParams(window.location.search);
  if (params.get('order_success') === '1') {
    switchTab('orders');
  }

  const user = getCurrentUser();
  const profile = JSON.parse(localStorage.getItem(getProfileStorageKey()) || '{}');
  const legacyProfile = JSON.parse(localStorage.getItem('ts_profile') || '{}');
  
  if (user.name) {
    const [fname, ...lname] = user.name.split(' ');
    document.getElementById('fname').value = fname || '';
    document.getElementById('lname').value = lname.join(' ') || '';
  }
  if (user.email) {
    document.getElementById('email').value = user.email;
  }
  
  const effectiveProfile = Object.keys(profile).length ? profile : legacyProfile;

  Object.keys(effectiveProfile).forEach(key => {
    const field = document.getElementById(key);
    if (field) field.value = effectiveProfile[key];
  });
});
</script>

<?php include '_footer.php'; ?>
