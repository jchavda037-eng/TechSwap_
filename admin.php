<?php
// admin.php — Admin Dashboard
if (session_status() === PHP_SESSION_NONE) session_start();

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit();
}

// Simple admin check (password: admin123)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_login'])) {
  if ($_POST['admin_password'] === 'admin123') {
    $_SESSION['admin_logged_in'] = true;
    header('Location: admin.php');
    exit;
  } else {
    $login_error = 'Invalid password';
  }
}

if (!isset($_SESSION['admin_logged_in'])) {
  ?>
  <!DOCTYPE html>
  <html lang="en" data-theme="light">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — TechSwap</title>
    <style>
      * { box-sizing: border-box; margin: 0; padding: 0; }
      html { scroll-behavior: smooth; font-size: 16px; }
      body {
        font-family: 'DM Sans', sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .login-container {
        background: white;
        border-radius: 14px;
        padding: 48px;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
      }
      h1 {
        font-size: 1.8rem;
        margin-bottom: 12px;
        color: #1a1a18;
        font-family: 'Syne', sans-serif;
        font-weight: 800;
      }
      .subtitle {
        color: #5a5a55;
        font-size: 0.95rem;
        margin-bottom: 32px;
      }
      .form-group {
        margin-bottom: 24px;
      }
      label {
        display: block;
        font-weight: 600;
        font-size: 0.88rem;
        color: #5a5a55;
        margin-bottom: 8px;
      }
      input {
        width: 100%;
        padding: 12px 14px;
        border: 1.5px solid #ddd9d0;
        border-radius: 8px;
        background: #f5f4f0;
        color: #1a1a18;
        font-size: 0.95rem;
        transition: border-color 0.22s;
      }
      input:focus {
        outline: none;
        border-color: #e8400a;
        background: white;
      }
      button {
        width: 100%;
        padding: 14px;
        background: #e8400a;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: background 0.22s;
        font-family: 'Syne', sans-serif;
      }
      button:hover {
        background: #ff6b35;
      }
      .error {
        background: #fff0eb;
        color: #e8400a;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 16px;
        font-size: 0.9rem;
        border: 1px solid #e8400a;
      }
    </style>
  </head>
  <body>
    <div class="login-container">
      <h1>🔐 Admin Panel</h1>
      <p class="subtitle">Enter admin password to continue</p>
      <?php if (isset($login_error)): ?>
        <div class="error"><?= $login_error ?></div>
      <?php endif; ?>
      <form method="POST">
        <div class="form-group">
          <label>Admin Password *</label>
          <input type="password" name="admin_password" placeholder="Enter password" required autofocus>
        </div>
        <button type="submit" name="admin_login">Sign In</button>
      </form>
    </div>
  </body>
  </html>
  <?php
  exit;
}

include 'db.php';

// Fetch Statistics from Database
$total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM products"))['count'];
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"))['count'];
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders"))['count'];

$top_cat_res = mysqli_query($conn, "SELECT category, COUNT(*) as count FROM products GROUP BY category ORDER BY count DESC LIMIT 1");
$top_category = ($row = mysqli_fetch_assoc($top_cat_res)) ? $row['category'] : 'None';

$avg_price_res = mysqli_query($conn, "SELECT AVG(price) as avg FROM products");
$avg_price = ($row = mysqli_fetch_assoc($avg_price_res)) ? round($row['avg']) : 0;

$pageTitle = 'Admin Dashboard — TechSwap';
$activePage = 'admin';
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $pageTitle ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&display=swap" rel="stylesheet">
  <?php include '_styles.php'; ?>
  <style>
    .admin-wrapper { display: grid; grid-template-columns: 260px 1fr; min-height: 100vh; }
    .admin-sidebar {
      background: var(--surface);
      border-right: 1px solid var(--border);
      padding: 24px 0;
      position: sticky;
      top: 0;
      height: 100vh;
      overflow-y: auto;
    }
    .admin-sidebar h3 {
      font-size: 0.85rem;
      font-weight: 700;
      color: var(--text3);
      padding: 12px 24px;
      margin-bottom: 8px;
      text-transform: uppercase;
      letter-spacing: 0.06em;
    }
    .admin-nav { border-bottom: 1px solid var(--border); padding-bottom: 16px; margin-bottom: 16px; }
    .admin-nav-item {
      padding: 12px 24px;
      color: var(--text2);
      cursor: pointer;
      transition: all var(--transition);
      font-weight: 500;
      border-left: 3px solid transparent;
      display: block;
    }
    .admin-nav-item:hover {
      color: var(--accent);
      background: var(--accent-light);
      border-left-color: var(--accent);
    }
    .admin-nav-item.active {
      color: var(--accent);
      background: var(--accent-light);
      border-left-color: var(--accent);
    }
    .admin-content {
      padding: 32px;
      overflow-y: auto;
    }
    .admin-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 32px;
      flex-wrap: wrap;
      gap: 16px;
    }
    .admin-header h1 { font-size: 1.8rem; }
    .admin-logout { padding: 10px 16px; background: var(--accent); color: white; border-radius: var(--radius-sm); cursor: pointer; font-weight: 600; border: none; }
    .admin-stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
      margin-bottom: 32px;
    }
    .stat-card {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: var(--radius);
      padding: 24px;
      text-align: center;
    }
    .stat-number { font-size: 2rem; font-weight: 800; color: var(--accent); font-family: var(--font-display); }
    .stat-label { font-size: 0.85rem; color: var(--text2); margin-top: 8px; }
    .admin-section { display: none; }
    .admin-section.active { display: block; }
    .table-container {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: var(--radius);
      overflow: hidden;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th {
      background: var(--bg2);
      padding: 14px;
      text-align: left;
      font-weight: 700;
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 0.04em;
      color: var(--text2);
    }
    td {
      padding: 14px;
      border-bottom: 1px solid var(--border);
      font-size: 0.9rem;
    }
    tr:last-child td { border-bottom: none; }
    tr:hover { background: var(--bg2); }
    .action-btn {
      padding: 6px 12px;
      margin-right: 4px;
      border-radius: var(--radius-sm);
      border: none;
      cursor: pointer;
      font-weight: 600;
      font-size: 0.8rem;
      transition: all var(--transition);
    }
    .btn-edit { background: var(--blue-light); color: var(--blue); }
    .btn-edit:hover { background: var(--blue); color: white; }
    .btn-delete { background: #fee; color: #e44; }
    .btn-delete:hover { background: #e44; color: white; }
    .form-modal {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.5);
      z-index: 1000;
      align-items: center;
      justify-content: center;
      padding: 24px;
    }
    .form-modal.active { display: flex; }
    .form-modal-content {
      background: var(--surface);
      border-radius: var(--radius-lg);
      padding: 40px;
      width: 100%;
      max-width: 520px;
      max-height: 90vh;
      overflow-y: auto;
    }
    .form-modal-close {
      float: right;
      font-size: 1.5rem;
      cursor: pointer;
      color: var(--text2);
    }
    .form-modal-close:hover { color: var(--accent); }
    .form-modal h2 { margin-bottom: 24px; }
  </style>
</head>
<body>
  <div class="admin-wrapper">
    <!-- SIDEBAR -->
    <div class="admin-sidebar">
      <h3>🔧 Admin</h3>
      <div class="admin-nav">
        <div class="admin-nav-item active" onclick="switchAdminTab('dashboard', this)">📊 Dashboard</div>
        <div class="admin-nav-item" onclick="switchAdminTab('products', this)">📦 Products</div>
        <div class="admin-nav-item" onclick="switchAdminTab('orders', this)">📋 Orders</div>
        <div class="admin-nav-item" onclick="switchAdminTab('users', this)">👥 Users</div>
        <div class="admin-nav-item" onclick="switchAdminTab('analytics', this)">📈 Analytics</div>
      </div>
      <h3>More</h3>
      <div class="admin-nav">
        <form method="POST" style="margin: 0;">
          <button name="logout" class="admin-nav-item" style="width: 100%; text-align: left;" onclick="return confirm('Logout?')">🚪 Logout</button>
        </form>
      </div>
    </div>

    <!-- CONTENT -->
    <div class="admin-content">
      <div class="admin-header">
        <h1>Admin Dashboard</h1>
        <form method="POST" style="margin: 0;">
          <button type="submit" class="admin-logout" onclick="return confirm('Logout?')">Logout</button>
        </form>
      </div>

      <div id="tab-dashboard" class="admin-section active">
        <div class="admin-stats">
          <div class="stat-card">
            <div class="stat-number" id="total-products"><?= $total_products ?></div>
            <div class="stat-label">Total Products</div>
          </div>
          <div class="stat-card">
            <div class="stat-number" id="total-users"><?= $total_users ?></div>
            <div class="stat-label">Total Users</div>
          </div>
          <div class="stat-card">
            <div class="stat-number" id="most-category"><?= $top_category ?></div>
            <div class="stat-label">Most Popular Category</div>
          </div>
          <div class="stat-card">
            <div class="stat-number" id="avg-price">$<?= $avg_price ?></div>
            <div class="stat-label">Average Price</div>
          </div>
        </div>
      </div>

      <!-- PRODUCTS TAB -->
      <div id="tab-products" class="admin-section">
        <div style="margin-bottom: 24px;">
          <button class="btn btn-primary" onclick="openAddProductModal()">+ Add Product</button>
        </div>
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Product Name</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Price</th>
                <th>Condition</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="admin-products-list">
              <!-- Filled by JS -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- USERS TAB -->
      <div id="tab-users" class="admin-section">
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>User Email</th>
                <th>User Name</th>
                <th>Listings</th>
                <th>Date Joined</th>
              </tr>
            </thead>
            <tbody id="admin-users-list">
              <!-- Filled by JS -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- ORDERS TAB -->
      <div id="tab-orders" class="admin-section">
        <div style="margin-bottom: 24px;">
          <h2>All Orders</h2>
        </div>
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Product</th>
                <th>Status</th>
                <th>Price</th>
                <th>Payment</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="admin-orders-list">
              <!-- Filled by JS -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- ANALYTICS TAB -->
      <div id="tab-analytics" class="admin-section">
        <div style="background: var(--surface); border: 1.5px solid var(--border); border-radius: var(--radius); padding: 32px; text-align: center;">
          <h2 style="margin-bottom: 16px;">📊 Platform Analytics</h2>
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 24px;">
            <div>
              <div style="font-size: 1.8rem; color: var(--accent); font-weight: 800; margin-bottom: 8px;" id="analytics-listings">0</div>
              <div style="color: var(--text2);">Total Listings</div>
            </div>
            <div>
              <div style="font-size: 1.8rem; color: var(--accent); font-weight: 800; margin-bottom: 8px;" id="analytics-users">0</div>
              <div style="color: var(--text2);">Registered Users</div>
            </div>
            <div>
              <div style="font-size: 1.8rem; color: var(--accent); font-weight: 800; margin-bottom: 8px;" id="analytics-featured">0</div>
              <div style="color: var(--text2);">Featured Products</div>
            </div>
            <div>
              <div style="font-size: 1.8rem; color: var(--accent); font-weight: 800; margin-bottom: 8px;" id="analytics-categories">0</div>
              <div style="color: var(--text2);">Categories</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ADD/EDIT PRODUCT MODAL -->
  <div id="productModal" class="form-modal">
    <div class="form-modal-content">
      <span class="form-modal-close" onclick="closeAdminModal('productModal')">&times;</span>
      <h2 id="productModalTitle">Add Product</h2>
      <form onsubmit="saveAdminProduct(event)">
        <div class="form-group">
          <label>Product Name *</label>
          <input type="text" id="admin-product-name" required>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Brand *</label>
            <input type="text" id="admin-product-brand" required>
          </div>
          <div class="form-group">
            <label>Category *</label>
            <select id="admin-product-category" required>
              <option value="">Select Category</option>
              <option value="Phones">Phones</option>
              <option value="Laptops">Laptops</option>
              <option value="Tablets">Tablets</option>
              <option value="Accessories">Accessories</option>
              <option value="Gaming">Gaming</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Price ($) *</label>
            <input type="number" id="admin-product-price" step="0.01" required>
          </div>
          <div class="form-group">
            <label>Original Price ($)</label>
            <input type="number" id="admin-product-original-price" step="0.01">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Condition *</label>
            <select id="admin-product-condition" required>
              <option value="New">New</option>
              <option value="Like New">Like New</option>
              <option value="Used">Used</option>
              <option value="Refurbished">Refurbished</option>
              <option value="Open Box">Open Box</option>
            </select>
          </div>
          <div class="form-group">
            <label>Location *</label>
            <input type="text" id="admin-product-location" required>
          </div>
        </div>
        <div class="form-group">
          <label>
            <input type="checkbox" id="admin-product-featured" style="width: auto;">
            Mark as Featured
          </label>
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Save Product</button>
      </form>
    </div>
  </div>

  <?php include '_scripts.php'; ?>
  <script>
    let adminEditingId = null;

    function switchAdminTab(tab, navItem) {
      document.querySelectorAll('.admin-section').forEach(s => s.classList.remove('active'));
      document.querySelectorAll('.admin-nav-item').forEach(i => i.classList.remove('active'));
      document.getElementById('tab-' + tab).classList.add('active');
      if (navItem) {
        navItem.classList.add('active');
      }

      if (tab === 'dashboard') loadAdminDashboard();
      else if (tab === 'products') loadAdminProducts();
      else if (tab === 'orders') loadAdminOrders();
      else if (tab === 'users') loadAdminUsers();
      else if (tab === 'analytics') loadAdminAnalytics();
    }

    function loadAdminDashboard() {
      // Re-fetch stats via reload or separate call if needed, but for now they are PHP-bound.
    }

    async function loadAdminProducts() {
      const res = await fetch('admin_api.php?action=get_products');
      const json = await res.json();
      if (json.status !== 'success') return;
      const products = json.data;
      const tbody = document.getElementById('admin-products-list');
      tbody.innerHTML = products.map(p => `
        <tr>
          <td>${p.name}</td>
          <td>${p.brand}</td>
          <td>${p.category}</td>
          <td>$${parseFloat(p.price).toFixed(2)}</td>
          <td><span class="badge ${conditionBadge[p.condition_text] || 'badge-used'}">${p.condition_text}</span></td>
          <td>
            <button class="action-btn btn-edit" onclick="editAdminProduct('${p.id}')">Edit</button>
            <button class="action-btn btn-delete" onclick="deleteAdminProduct('${p.id}')">Delete</button>
          </td>
        </tr>
      `).join('');
    }

    async function loadAdminOrders() {
      const res = await fetch('admin_api.php?action=get_orders');
      const json = await res.json();
      if (json.status !== 'success') return;
      const orders = json.data;
      const tbody = document.getElementById('admin-orders-list');
      
      if (orders.length === 0) {
        tbody.innerHTML = `<tr><td colspan="7" style="text-align: center; padding: 40px;">No orders yet</td></tr>`;
        return;
      }

      tbody.innerHTML = orders.map(order => `
        <tr>
          <td><strong>${order.display_order_id || order.order_id}</strong></td>
          <td>${order.user_name}${order.user_email ? `<div style="font-size:0.8rem;color:var(--text3);">${order.user_email}</div>` : ''}</td>
          <td>${order.product_name}</td>
          <td>
            <select id="status-${order.order_id}" style="padding: 6px; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--bg);">
              <option value="Placed" ${order.order_status === 'Placed' ? 'selected' : ''}>Placed</option>
              <option value="Packed" ${order.order_status === 'Packed' ? 'selected' : ''}>Packed</option>
              <option value="Shipped" ${order.order_status === 'Shipped' ? 'selected' : ''}>Shipped</option>
              <option value="Out for Delivery" ${order.order_status === 'Out for Delivery' ? 'selected' : ''}>Out for Delivery</option>
              <option value="Delivered" ${order.order_status === 'Delivered' ? 'selected' : ''}>Delivered</option>
              <option value="Cancelled" ${order.order_status === 'Cancelled' ? 'selected' : ''}>Cancelled</option>
            </select>
          </td>
          <td>$${parseFloat(order.product_price || 0).toFixed(2)}</td>
          <td>
            <select id="payment-${order.order_id}" style="padding: 6px; border: 1px solid var(--border); border-radius: var(--radius-sm); background: var(--bg);">
              <option value="Pending" ${order.payment_status === 'Pending' ? 'selected' : ''}>Pending</option>
              <option value="Paid" ${order.payment_status === 'Paid' ? 'selected' : ''}>Paid</option>
            </select>
          </td>
          <td>
            <button class="action-btn btn-edit" onclick="updateAdminOrder('${order.order_id}')">Update</button>
            <button class="action-btn btn-delete" onclick="cancelAdminOrder('${order.order_id}')">Cancel</button>
          </td>
        </tr>
      `).join('');
    }

    async function updateAdminOrder(orderId) {
      const newStatus = document.getElementById('status-' + orderId).value;
      const newPayment = document.getElementById('payment-' + orderId).value;
      
      const res = await fetch('admin_api.php?action=update_order', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ order_id: orderId, order_status: newStatus, payment_status: newPayment })
      });
      const json = await res.json();
      
      if (json.status === 'success') {
        showToast('Order updated!', 'success', 'Updated');
        loadAdminOrders();
      } else {
        showToast('Update failed: ' + json.message, 'error', 'Error');
      }
    }

    async function cancelAdminOrder(orderId) {
      if (!confirm('Cancel this order from admin?')) return;

      const paymentField = document.getElementById('payment-' + orderId);
      const res = await fetch('admin_api.php?action=update_order', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          order_id: orderId,
          order_status: 'Cancelled',
          payment_status: paymentField ? paymentField.value : 'Pending'
        })
      });
      const json = await res.json();

      if (json.status === 'success') {
        showToast('Order cancelled from admin.', 'success', 'Cancelled');
        loadAdminOrders();
      } else {
        showToast('Cancel failed: ' + json.message, 'error', 'Error');
      }
    }

    async function loadAdminUsers() {
      const res = await fetch('admin_api.php?action=get_users');
      const json = await res.json();
      if (json.status !== 'success') return;
      const users = json.data;
      const tbody = document.getElementById('admin-users-list');
      tbody.innerHTML = users.map(u => `
        <tr>
          <td>${u.email}</td>
          <td>${u.name}</td>
          <td>-</td>
          <td>${new Date(u.created_at).toLocaleDateString()}</td>
        </tr>
      `).join('');
    }

    function loadAdminAnalytics() {
      loadProducts();
      const featured = state.products.filter(p => p.featured).length;
      document.getElementById('analytics-listings').textContent = state.products.length;
      document.getElementById('analytics-users').textContent = JSON.parse(localStorage.getItem('ts_users') || '[]').length;
      document.getElementById('analytics-featured').textContent = featured;
      document.getElementById('analytics-categories').textContent = new Set(state.products.map(p => p.category)).size;
    }

    function openAddProductModal() {
      adminEditingId = null;
      document.getElementById('productModalTitle').textContent = 'Add Product';
      document.getElementById('admin-product-name').value = '';
      document.getElementById('admin-product-brand').value = '';
      document.getElementById('admin-product-category').value = '';
      document.getElementById('admin-product-price').value = '';
      document.getElementById('admin-product-original-price').value = '';
      document.getElementById('admin-product-condition').value = 'New';
      document.getElementById('admin-product-location').value = '';
      document.getElementById('admin-product-featured').checked = false;
      document.getElementById('productModal').classList.add('active');
    }

    function editAdminProduct(id) {
      loadProducts();
      const product = state.products.find(p => p.id === id);
      if (!product) return;
      adminEditingId = id;
      document.getElementById('productModalTitle').textContent = 'Edit Product';
      document.getElementById('admin-product-name').value = product.name;
      document.getElementById('admin-product-brand').value = product.brand;
      document.getElementById('admin-product-category').value = product.category;
      document.getElementById('admin-product-price').value = product.price;
      document.getElementById('admin-product-original-price').value = product.originalPrice || '';
      document.getElementById('admin-product-condition').value = product.condition;
      document.getElementById('admin-product-location').value = product.location;
      document.getElementById('admin-product-featured').checked = product.featured || false;
      document.getElementById('productModal').classList.add('active');
    }

    async function saveAdminProduct(e) {
      e.preventDefault();
      const product = {
        id: adminEditingId || 'p_' + Date.now(),
        name: document.getElementById('admin-product-name').value,
        brand: document.getElementById('admin-product-brand').value,
        category: document.getElementById('admin-product-category').value,
        price: parseFloat(document.getElementById('admin-product-price').value),
        originalPrice: parseFloat(document.getElementById('admin-product-original-price').value) || null,
        condition: document.getElementById('admin-product-condition').value,
        location: document.getElementById('admin-product-location').value,
        featured: document.getElementById('admin-product-featured').checked
      };

      const res = await fetch('admin_api.php?action=save_product', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(product)
      });
      const json = await res.json();

      if (json.status === 'success') {
        closeAdminModal('productModal');
        loadAdminProducts();
        showToast('Product sync successful!', 'success', 'Saved ✅');
      } else {
        showToast('Sync failed: ' + json.message, 'error', 'Error');
      }
    }

    async function deleteAdminProduct(id) {
      if (!confirm('Delete this product from database?')) return;
      const res = await fetch('admin_api.php?action=delete_product&id=' + id);
      const json = await res.json();
      if (json.status === 'success') {
        loadAdminProducts();
        showToast('Deleted from database!', 'success', 'Deleted');
      } else {
        showToast('Delete failed: ' + json.message, 'error', 'Error');
      }
    }

    function closeAdminModal(id) {
      document.getElementById(id).classList.remove('active');
    }

    // Load dashboard on start
    window.addEventListener('DOMContentLoaded', () => {
      loadAdminDashboard();
    });
  </script>
</body>
</html>
