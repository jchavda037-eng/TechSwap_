<script>
// ============================================================
// STATE
// ============================================================
const state = {
  products: [],
  filteredProducts: [],
  wishlist: JSON.parse(localStorage.getItem('ts_wishlist') || '[]'),
  cart: JSON.parse(localStorage.getItem('ts_cart') || '[]'),
  currentView: 'grid',
  currentPage: 1,
  perPage: 9,
  activeCategory: null,
  user: JSON.parse(localStorage.getItem('ts_user') || 'null'),
};

const WHATSAPP_ADMIN = '9825244345';

// ============================================================
// CATEGORY ICONS & CONDITION BADGES
// ============================================================
const catIcon = { Phones:'📱', Tablets:'📟', Laptops:'💻', Accessories:'🎧', Gaming:'🎮' };
const conditionBadge = {
  'New': 'badge-new', 'Like New': 'badge-like-new', 'Used': 'badge-used',
  'Refurbished': 'badge-refurbished', 'Open Box': 'badge-open-box'
};

// ============================================================
// PRODUCTS DB
// ============================================================
function loadProducts() {
  const stored = localStorage.getItem('ts_products');
  if (stored) {
    const parsed = JSON.parse(stored);
    // Check if products have required fields (createdAt, shipping)
    const hasRequiredFields = parsed.length > 0 && parsed[0].createdAt && parsed[0].shipping;
    if (hasRequiredFields) {
      state.products = parsed;
    } else {
      // Reinitialize if structure is outdated
      state.products = initializeSampleProducts();
      saveProducts();
    }
  } else {
    // Add sample products if none exist
    state.products = initializeSampleProducts();
    saveProducts();
  }
  state.filteredProducts = [...state.products];
}

function initializeSampleProducts() {
  const baseTime = Date.now();
  const sampleProducts = [
    // APPLE - Phones
    { id: 'p1', name: 'iPhone 15 Pro Max', brand: 'Apple', category: 'Phones', price: 899, originalPrice: 1199, condition: 'Like New', location: 'New York, USA', featured: true, createdAt: baseTime, shipping: 'Delivery Pickup' },
    { id: 'p2', name: 'iPhone 14', brand: 'Apple', category: 'Phones', price: 599, originalPrice: 799, condition: 'Used', location: 'Los Angeles, USA', featured: false, createdAt: baseTime - 86400000, shipping: 'Delivery' },
    
    // SAMSUNG - Phones
    { id: 'p3', name: 'Samsung Galaxy S24', brand: 'Samsung', category: 'Phones', price: 799, originalPrice: 999, condition: 'New', location: 'Chicago, USA', featured: true, createdAt: baseTime - 172800000, shipping: 'Delivery Pickup' },
    { id: 'p4', name: 'Samsung Galaxy A54', brand: 'Samsung', category: 'Phones', price: 399, originalPrice: 499, condition: 'Like New', location: 'Houston, USA', featured: false, createdAt: baseTime - 259200000, shipping: 'Pickup' },
    
    // GOOGLE - Phones
    { id: 'p5', name: 'Google Pixel 8 Pro', brand: 'Google', category: 'Phones', price: 699, originalPrice: 899, condition: 'Like New', location: 'San Francisco, USA', featured: true, createdAt: baseTime - 345600000, shipping: 'Delivery Pickup' },
    { id: 'p6', name: 'Google Pixel 7a', brand: 'Google', category: 'Phones', price: 349, originalPrice: 449, condition: 'Used', location: 'Seattle, USA', featured: false, createdAt: baseTime - 432000000, shipping: 'Delivery' },
    
    // ONEPLUS - Phones
    { id: 'p7', name: 'OnePlus 12', brand: 'OnePlus', category: 'Phones', price: 649, originalPrice: 799, condition: 'New', location: 'Boston, USA', featured: false, createdAt: baseTime - 518400000, shipping: 'Delivery Pickup' },
    { id: 'p8', name: 'OnePlus 11', brand: 'OnePlus', category: 'Phones', price: 499, originalPrice: 649, condition: 'Like New', location: 'Austin, USA', featured: false, createdAt: baseTime - 604800000, shipping: 'Pickup' },
    
    // XIAOMI - Phones
    { id: 'p9', name: 'Xiaomi 14', brand: 'Xiaomi', category: 'Phones', price: 549, originalPrice: 699, condition: 'Like New', location: 'Miami, USA', featured: false, createdAt: baseTime - 691200000, shipping: 'Delivery' },
    { id: 'p10', name: 'Xiaomi 13 Ultra', brand: 'Xiaomi', category: 'Phones', price: 699, originalPrice: 899, condition: 'Used', location: 'Denver, USA', featured: false, createdAt: baseTime - 777600000, shipping: 'Delivery Pickup' },
    
    // SONY - Phones
    { id: 'p11', name: 'Sony Xperia 1 V', brand: 'Sony', category: 'Phones', price: 799, originalPrice: 1099, condition: 'Refurbished', location: 'Portland, USA', featured: false, createdAt: baseTime - 864000000, shipping: 'Delivery' },
    { id: 'p12', name: 'Sony Xperia 10 V', brand: 'Sony', category: 'Phones', price: 449, originalPrice: 599, condition: 'Like New', location: 'Nashville, USA', featured: false, createdAt: baseTime - 950400000, shipping: 'Pickup' },
    
    // HUAWEI - Phones
    { id: 'p13', name: 'Huawei P60 Pro', brand: 'Huawei', category: 'Phones', price: 699, originalPrice: 899, condition: 'New', location: 'Phoenix, USA', featured: false, createdAt: baseTime - 1036800000, shipping: 'Delivery Pickup' },
    { id: 'p14', name: 'Huawei P50', brand: 'Huawei', category: 'Phones', price: 499, originalPrice: 699, condition: 'Like New', location: 'Memphis, USA', featured: false, createdAt: baseTime - 1123200000, shipping: 'Delivery' },
    
    // ========== LAPTOPS ==========
    // APPLE - Laptops
    { id: 'l1', name: 'MacBook Pro 16" M3 Max', brand: 'Apple', category: 'Laptops', price: 2499, originalPrice: 3499, condition: 'New', location: 'San Francisco, USA', featured: true, createdAt: baseTime - 1209600000, shipping: 'Delivery Pickup' },
    { id: 'l2', name: 'MacBook Air M2', brand: 'Apple', category: 'Laptops', price: 999, originalPrice: 1299, condition: 'Like New', location: 'New York, USA', featured: false, createdAt: baseTime - 1296000000, shipping: 'Delivery' },
    
    // DELL - Laptops
    { id: 'l3', name: 'Dell XPS 15 Plus', brand: 'Dell', category: 'Laptops', price: 1699, originalPrice: 1999, condition: 'New', location: 'Austin, USA', featured: true, createdAt: baseTime - 1382400000, shipping: 'Delivery Pickup' },
    { id: 'l4', name: 'Dell XPS 13', brand: 'Dell', category: 'Laptops', price: 999, originalPrice: 1199, condition: 'Like New', location: 'Dallas, USA', featured: false, createdAt: baseTime - 1468800000, shipping: 'Pickup' },
    
    // LENOVO - Laptops
    { id: 'l5', name: 'Lenovo ThinkPad X1 Carbon', brand: 'Lenovo', category: 'Laptops', price: 1299, originalPrice: 1599, condition: 'Like New', location: 'Chicago, USA', featured: false, createdAt: baseTime - 1555200000, shipping: 'Delivery' },
    { id: 'l6', name: 'Lenovo IdeaPad Pro', brand: 'Lenovo', category: 'Laptops', price: 899, originalPrice: 1099, condition: 'Used', location: 'Houston, USA', featured: false, createdAt: baseTime - 1641600000, shipping: 'Delivery Pickup' },
    
    // HP - Laptops
    { id: 'l7', name: 'HP Spectre x360', brand: 'HP', category: 'Laptops', price: 1399, originalPrice: 1699, condition: 'New', location: 'Los Angeles, USA', featured: false, createdAt: baseTime - 1728000000, shipping: 'Delivery' },
    { id: 'l8', name: 'HP Pavilion 15', brand: 'HP', category: 'Laptops', price: 749, originalPrice: 899, condition: 'Like New', location: 'Phoenix, USA', featured: false, createdAt: baseTime - 1814400000, shipping: 'Pickup' },
    
    // ASUS - Laptops
    { id: 'l9', name: 'ASUS ROG Zephyrus G16', brand: 'ASUS', category: 'Laptops', price: 1999, originalPrice: 2299, condition: 'New', location: 'Denver, USA', featured: true, createdAt: baseTime - 1900800000, shipping: 'Delivery Pickup' },
    { id: 'l10', name: 'ASUS VivoBook 15', brand: 'ASUS', category: 'Laptops', price: 649, originalPrice: 799, condition: 'Like New', location: 'Miami, USA', featured: false, createdAt: baseTime - 1987200000, shipping: 'Delivery' },
    
    // MICROSOFT - Laptops
    { id: 'l11', name: 'Microsoft Surface Laptop 6', brand: 'Microsoft', category: 'Laptops', price: 1699, originalPrice: 1999, condition: 'New', location: 'Seattle, USA', featured: false, createdAt: baseTime - 2073600000, shipping: 'Delivery Pickup' },
    { id: 'l12', name: 'Microsoft Surface Go 4', brand: 'Microsoft', category: 'Laptops', price: 599, originalPrice: 749, condition: 'Like New', location: 'Boston, USA', featured: false, createdAt: baseTime - 2160000000, shipping: 'Pickup' },
    
    // SONY - Laptops
    { id: 'l13', name: 'Sony VAIO FE16', brand: 'Sony', category: 'Laptops', price: 1299, originalPrice: 1599, condition: 'Refurbished', location: 'Portland, USA', featured: false, createdAt: baseTime - 2246400000, shipping: 'Delivery' },
    { id: 'l14', name: 'Sony VAIO FZ', brand: 'Sony', category: 'Laptops', price: 999, originalPrice: 1299, condition: 'Used', location: 'Portland, USA', featured: false, createdAt: baseTime - 2332800000, shipping: 'Delivery Pickup' },
    
    // ========== TABLETS ==========
    // APPLE - Tablets
    { id: 't1', name: 'iPad Pro 12.9" M2', brand: 'Apple', category: 'Tablets', price: 899, originalPrice: 1099, condition: 'New', location: 'San Francisco, USA', featured: true, createdAt: baseTime - 2419200000, shipping: 'Delivery Pickup' },
    { id: 't2', name: 'iPad Air', brand: 'Apple', category: 'Tablets', price: 599, originalPrice: 699, condition: 'Like New', location: 'New York, USA', featured: false, createdAt: baseTime - 2505600000, shipping: 'Delivery' },
    
    // SAMSUNG - Tablets
    { id: 't3', name: 'Samsung Galaxy Tab S10', brand: 'Samsung', category: 'Tablets', price: 749, originalPrice: 899, condition: 'New', location: 'Chicago, USA', featured: false, createdAt: baseTime - 2592000000, shipping: 'Pickup' },
    { id: 't4', name: 'Samsung Galaxy Tab A9', brand: 'Samsung', category: 'Tablets', price: 349, originalPrice: 449, condition: 'Like New', location: 'Houston, USA', featured: false, createdAt: baseTime - 2678400000, shipping: 'Delivery Pickup' },
    
    // MICROSOFT - Tablets
    { id: 't5', name: 'Microsoft Surface Pro 10', brand: 'Microsoft', category: 'Tablets', price: 999, originalPrice: 1299, condition: 'New', location: 'Seattle, USA', featured: true, createdAt: baseTime - 2764800000, shipping: 'Delivery Pickup' },
    { id: 't6', name: 'Microsoft Surface Go 4', brand: 'Microsoft', category: 'Tablets', price: 499, originalPrice: 599, condition: 'Like New', location: 'Boston, USA', featured: false, createdAt: baseTime - 2851200000, shipping: 'Delivery' },
    
    // GOOGLE - Tablets
    { id: 't7', name: 'Google Pixel Tablet', brand: 'Google', category: 'Tablets', price: 549, originalPrice: 699, condition: 'New', location: 'San Francisco, USA', featured: false, createdAt: baseTime - 2937600000, shipping: 'Pickup' },
    { id: 't8', name: 'Google Pixel Tab A', brand: 'Google', category: 'Tablets', price: 349, originalPrice: 429, condition: 'Like New', location: 'Seattle, USA', featured: false, createdAt: baseTime - 3024000000, shipping: 'Delivery Pickup' },
    
    // LENOVO - Tablets
    { id: 't9', name: 'Lenovo Yoga Tab 11 Pro', brand: 'Lenovo', category: 'Tablets', price: 649, originalPrice: 799, condition: 'Like New', location: 'Chicago, USA', featured: false, createdAt: baseTime - 3110400000, shipping: 'Delivery' },
    { id: 't10', name: 'Lenovo Tab P12 Pro', brand: 'Lenovo', category: 'Tablets', price: 749, originalPrice: 899, condition: 'Used', location: 'Dallas, USA', featured: false, createdAt: baseTime - 3196800000, shipping: 'Delivery Pickup' },
    
    // SONY - Tablets
    { id: 't11', name: 'Sony Xperia Z3 Tablet', brand: 'Sony', category: 'Tablets', price: 449, originalPrice: 599, condition: 'Refurbished', location: 'Portland, USA', featured: false, createdAt: baseTime - 3283200000, shipping: 'Pickup' },
    { id: 't12', name: 'Sony Xperia Z2 Tablet', brand: 'Sony', category: 'Tablets', price: 349, originalPrice: 449, condition: 'Used', location: 'Portland, USA', featured: false, createdAt: baseTime - 3369600000, shipping: 'Delivery' },
    
    // ========== ACCESSORIES ==========
    // APPLE - Accessories
    { id: 'a1', name: 'Apple AirPods Pro 2', brand: 'Apple', category: 'Accessories', price: 179, originalPrice: 249, condition: 'New', location: 'San Francisco, USA', featured: true, createdAt: baseTime - 3456000000, shipping: 'Delivery Pickup' },
    { id: 'a2', name: 'Apple Magic Keyboard', brand: 'Apple', category: 'Accessories', price: 149, originalPrice: 199, condition: 'Like New', location: 'New York, USA', featured: false, createdAt: baseTime - 3542400000, shipping: 'Delivery' },
    
    // SONY - Accessories
    { id: 'a3', name: 'Sony WH-1000XM5 Headphones', brand: 'Sony', category: 'Accessories', price: 299, originalPrice: 399, condition: 'New', location: 'Chicago, USA', featured: true, createdAt: baseTime - 3628800000, shipping: 'Delivery Pickup' },
    { id: 'a4', name: 'Sony WF-C700N Earbuds', brand: 'Sony', category: 'Accessories', price: 99, originalPrice: 149, condition: 'Like New', location: 'Houston, USA', featured: false, createdAt: baseTime - 3715200000, shipping: 'Pickup' },
    
    // SAMSUNG - Accessories
    { id: 'a5', name: 'Samsung Galaxy Buds2 Pro', brand: 'Samsung', category: 'Accessories', price: 149, originalPrice: 199, condition: 'New', location: 'Los Angeles, USA', featured: false, createdAt: baseTime - 3801600000, shipping: 'Delivery' },
    { id: 'a6', name: 'Samsung Galaxy Watch 6', brand: 'Samsung', category: 'Accessories', price: 249, originalPrice: 329, condition: 'Like New', location: 'Phoenix, USA', featured: false, createdAt: baseTime - 3888000000, shipping: 'Delivery Pickup' },
    
    // GOOGLE - Accessories
    { id: 'a7', name: 'Google Pixel Buds Pro', brand: 'Google', category: 'Accessories', price: 149, originalPrice: 199, condition: 'New', location: 'San Francisco, USA', featured: false, createdAt: baseTime - 3974400000, shipping: 'Pickup' },
    { id: 'a8', name: 'Google Pixel Watch', brand: 'Google', category: 'Accessories', price: 299, originalPrice: 399, condition: 'Like New', location: 'Seattle, USA', featured: false, createdAt: baseTime - 4060800000, shipping: 'Delivery' },
    
    // MICROSOFT - Accessories
    { id: 'a9', name: 'Microsoft Surface Pen', brand: 'Microsoft', category: 'Accessories', price: 99, originalPrice: 129, condition: 'New', location: 'Seattle, USA', featured: false, createdAt: baseTime - 4147200000, shipping: 'Delivery Pickup' },
    { id: 'a10', name: 'Microsoft Arc Mouse', brand: 'Microsoft', category: 'Accessories', price: 59, originalPrice: 79, condition: 'Like New', location: 'Boston, USA', featured: false, createdAt: baseTime - 4233600000, shipping: 'Delivery' },
    
    // DELL - Accessories
    { id: 'a11', name: 'Dell UltraSharp Monitor', brand: 'Dell', category: 'Accessories', price: 399, originalPrice: 499, condition: 'Like New', location: 'Austin, USA', featured: false, createdAt: baseTime - 4320000000, shipping: 'Pickup' },
    { id: 'a12', name: 'Dell Wireless Mouse', brand: 'Dell', category: 'Accessories', price: 29, originalPrice: 39, condition: 'New', location: 'Dallas, USA', featured: false, createdAt: baseTime - 4406400000, shipping: 'Delivery Pickup' },
  ];
  
  return sampleProducts;
}

function saveProducts() {
  localStorage.setItem('ts_products', JSON.stringify(state.products));
}

// ============================================================
// ORDERS MANAGEMENT
// ============================================================
function loadOrders() {
  const stored = localStorage.getItem('ts_orders');
  return stored ? JSON.parse(stored) : [];
}

function saveOrders(orders) {
  localStorage.setItem('ts_orders', JSON.stringify(orders));
}

function placeOrder(productId, quantity = 1) {
  const product = state.products.find(p => p.id === productId);
  if (!product) {
    showToast('Product not found', 'error', 'Error');
    return false;
  }
  
  const user = JSON.parse(localStorage.getItem('ts_user') || 'null');
  if (!user) {
    showToast('Please sign in to place an order', 'error', 'Error');
    return false;
  }

  const orders = loadOrders();
  const order = {
    order_id: 'ORD_' + Date.now(),
    user_id: user.id,
    user_email: user.email,
    user_name: user.name,
    product_id: product.id,
    product_name: product.name,
    product_brand: product.brand,
    product_category: product.category,
    product_price: product.price,
    quantity: quantity,
    total_price: product.price * quantity,
    order_status: 'Placed',
    order_date: new Date().toISOString(),
    shipping_date: null,
    delivery_date: null,
    expected_delivery_date: null,
    payment_status: 'Pending'
  };

  orders.push(order);
  saveOrders(orders);
  showToast('Order placed successfully! 🎉', 'success', 'Ordered');
  return true;
}

function getUserOrders(userEmail) {
  const orders = loadOrders();
  return orders.filter(o => o.user_email === userEmail);
}

function getAllOrders() {
  return loadOrders();
}

function updateOrderStatus(orderId, status) {
  const orders = loadOrders();
  const order = orders.find(o => o.order_id === orderId);
  if (order) {
    order.order_status = status;
    if (status === 'Shipped' && !order.shipping_date) {
      order.shipping_date = new Date().toISOString();
    }
    if (status === 'Delivered' && !order.delivery_date) {
      order.delivery_date = new Date().toISOString();
    }
    saveOrders(orders);
    return true;
  }
  return false;
}

function updateOrderShippingDate(orderId, date) {
  const orders = loadOrders();
  const order = orders.find(o => o.order_id === orderId);
  if (order) {
    order.shipping_date = date;
    saveOrders(orders);
    return true;
  }
  return false;
}

function updateOrderDeliveryDate(orderId, date) {
  const orders = loadOrders();
  const order = orders.find(o => o.order_id === orderId);
  if (order) {
    order.expected_delivery_date = date;
    saveOrders(orders);
    return true;
  }
  return false;
}

function updatePaymentStatus(orderId, status) {
  const orders = loadOrders();
  const order = orders.find(o => o.order_id === orderId);
  if (order) {
    order.payment_status = status;
    saveOrders(orders);
    return true;
  }
  return false;
}

function cancelOrder(orderId) {
  const orders = loadOrders();
  const order = orders.find(o => o.order_id === orderId);
  if (order && (order.order_status === 'Placed' || order.order_status === 'Packed')) {
    order.order_status = 'Cancelled';
    saveOrders(orders);
    return true;
  }
  return false;
}

function getOrderStatusColor(status) {
  const colors = {
    'Delivered': '#1a7a4a',
    'Shipped': '#0a4a8a',
    'Out for Delivery': '#0a4a8a',
    'Packed': '#f5a623',
    'Pending': '#f5a623',
    'Placed': '#f5a623',
    'Cancelled': '#e8400a'
  };
  return colors[status] || '#5a5a55';
}

function getOrderStatusBgColor(status) {
  const colors = {
    'Delivered': '#e6f5ee',
    'Shipped': '#e6f0fa',
    'Out for Delivery': '#e6f0fa',
    'Packed': '#fff8f0',
    'Pending': '#fff8f0',
    'Placed': '#fff8f0',
    'Cancelled': '#fff0eb'
  };
  return colors[status] || '#f0ede7';
}

// ============================================================
// RENDER PRODUCTS
// ============================================================
function renderProducts() {
  
  const grid = document.getElementById('productsGrid');
  const count = document.getElementById('productsCount');
  const pagination = document.getElementById('pagination');
  if (!grid) return;
  const total = state.filteredProducts.length;
  const start = (state.currentPage - 1) * state.perPage;
  const end = Math.min(start + state.perPage, total);
  const page = state.filteredProducts.slice(start, end);

  if (count) count.textContent = `Showing ${total} listing${total !== 1 ? 's' : ''}`;

  if (page.length === 0) {
    grid.innerHTML = `
      <div style="grid-column:1/-1;text-align:center;padding:80px 20px;color:var(--text2);">
        <div style="font-size:3rem;margin-bottom:16px;">🔍</div>
        <h3 style="margin-bottom:8px;font-size:1.2rem;">No listings found</h3>
        <p style="margin-bottom:24px;font-size:0.9rem;">Try adjusting your filters or search terms.</p>
        <button class="btn btn-primary" onclick="clearFilters()">Clear All Filters</button>
      </div>`;
    if (pagination) pagination.innerHTML = '';
    return;
  }

  grid.innerHTML = page.map(p => productCard(p)).join('');

  // Pagination
  if (pagination) {
    const pages = Math.ceil(total / state.perPage);
    if (pages <= 1) { pagination.innerHTML = ''; return; }
    let pHtml = '';
    for (let i = 1; i <= pages; i++) {
      pHtml += `<button class="page-btn ${i===state.currentPage?'active':''}" onclick="goPage(${i})">${i}</button>`;
    }
    pagination.innerHTML = pHtml;
  }

  updateWishlistButtons();
}

function productCard(p) {
  const isWished = state.wishlist.some(w => w.id === p.id);
  const discount = p.originalPrice && p.originalPrice > p.price
    ? Math.round((1 - p.price/p.originalPrice)*100)
    : 0;
  return `
  <div class="product-card" id="pc-${p.id}">
    <div class="product-image">
      <span class="product-image-placeholder">${catIcon[p.category] || '📦'}</span>
      ${p.featured ? `<div class="product-featured-badge"><span class="badge badge-featured">Featured</span></div>` : ''}
      ${discount > 0 ? `<div class="product-discount-badge"><span class="badge badge-discount">-${discount}%</span></div>` : ''}
      <button class="product-wishlist ${isWished?'active':''}" id="wb-${p.id}" onclick="toggleWishlist(event,'${p.id}')" aria-label="Wishlist">
        ${isWished ? '♥' : '♡'}
      </button>
    </div>
    <div class="product-body">
      <div class="product-condition">
        <span class="badge ${conditionBadge[p.condition] || 'badge-used'}">${p.condition}</span>
      </div>
      <div class="product-name">${p.name}</div>
      <div class="product-brand">${p.brand} · ${p.model || ''}</div>
      <div class="product-price-row">
        <div>
          <span class="product-price">$${Number(p.price).toLocaleString()}</span>
          ${discount > 0 ? `<span class="product-original-price">$${Number(p.originalPrice).toLocaleString()}</span>` : ''}
        </div>
      </div>
      <div class="product-location">📍 ${p.location || 'Unknown'}</div>
      <div class="product-actions">
        <button class="btn btn-primary btn-sm" onclick="openProduct('${p.id}')">View Details</button>
        <button class="btn btn-outline btn-sm" onclick="addToCart(event,'${p.id}')">🛒</button>
      </div>
    </div>
  </div>`;
}

function goPage(n) {
  state.currentPage = n;
  renderProducts();
  const browseEl = document.getElementById('browse');
  if (browseEl) browseEl.scrollIntoView({behavior:'smooth'});
}

function setView(v) {
  state.currentView = v;
  const grid = document.getElementById('productsGrid');
  if (grid) grid.classList.toggle('list-view', v === 'list');
  const gBtn = document.getElementById('gridViewBtn');
  const lBtn = document.getElementById('listViewBtn');
  if (gBtn) gBtn.classList.toggle('active', v === 'grid');
  if (lBtn) lBtn.classList.toggle('active', v === 'list');
}

// ============================================================
// FILTERS & SEARCH
// ============================================================
function applyFilters() {
  let products = [...state.products];

  // Search
  const q = (document.getElementById('headerSearchInput')?.value || '').toLowerCase().trim();
  if (q) {
    products = products.filter(p =>
      p.name.toLowerCase().includes(q) ||
      p.brand.toLowerCase().includes(q) ||
      (p.description||'').toLowerCase().includes(q) ||
      p.category.toLowerCase().includes(q)
    );
  }

  // Category checkboxes
  const catChecked = ['Phones','Tablets','Laptops','Accessories','Gaming'].filter(c => {
    const el = document.getElementById(`f-${c.toLowerCase()}`);
    return el && el.checked;
  });
  if (catChecked.length > 0) {
    products = products.filter(p => catChecked.includes(p.category));
  }

  // Active category (from category grid click)
  if (state.activeCategory) {
    products = products.filter(p => p.category === state.activeCategory);
  }

  // Condition
  const conds = ['new','like-new','used','refurbished','open-box'].filter(c => {
    const el = document.getElementById(`fc-${c}`);
    return el && el.checked;
  }).map(c => c.replace('-', ' ').replace(/\b\w/g, l => l.toUpperCase()));
  if (conds.length > 0) {
    products = products.filter(p => conds.includes(p.condition));
  }

  // Price
  const minP = parseFloat(document.getElementById('priceMin')?.value) || 0;
  const maxP = parseFloat(document.getElementById('priceMax')?.value) || Infinity;
  products = products.filter(p => p.price >= minP && p.price <= maxP);

  // Location
  const loc = document.getElementById('locationFilter')?.value || '';
  if (loc) products = products.filter(p => p.location?.includes(loc));

  // Shipping
  const hasDelivery = document.getElementById('fs-delivery')?.checked;
  const hasPickup = document.getElementById('fs-pickup')?.checked;
  if (hasDelivery && !hasPickup) products = products.filter(p => p.shipping?.includes('Delivery'));
  if (hasPickup && !hasDelivery) products = products.filter(p => p.shipping?.includes('Pickup'));

  // Sort
  const sort = document.getElementById('sortSelect')?.value || 'newest';
  if (sort === 'price-asc') products.sort((a,b) => a.price - b.price);
  else if (sort === 'price-desc') products.sort((a,b) => b.price - a.price);
  else if (sort === 'featured') products.sort((a,b) => (b.featured?1:0) - (a.featured?1:0));
  else products.sort((a,b) => b.createdAt - a.createdAt);

  state.filteredProducts = products;
  state.currentPage = 1;
  renderProducts();
  updateCategoryCounts();
}

function clearFilters() {
  state.activeCategory = null;
  ['f-phones','f-tablets','f-laptops','f-accessories','f-gaming',
   'fc-new','fc-like-new','fc-used','fc-refurbished','fc-open-box',
   'fs-delivery','fs-pickup'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.checked = false;
  });
  const pMin = document.getElementById('priceMin');
  const pMax = document.getElementById('priceMax');
  const locF = document.getElementById('locationFilter');
  const hSearch = document.getElementById('headerSearchInput');
  if (pMin) pMin.value = '';
  if (pMax) pMax.value = '';
  if (locF) locF.value = '';
  if (hSearch) hSearch.value = '';
  applyFilters();
}

function filterCategory(cat) {
  state.activeCategory = cat;
  // Navigate to browse page with category filter
  window.location.href = 'browse.php?category=' + encodeURIComponent(cat);
}

function searchBrand(brand) {
  const hSearch = document.getElementById('headerSearchInput');
  if (hSearch) hSearch.value = brand;
  applyFilters();
  const browseEl = document.getElementById('browse');
  if (browseEl) {
    browseEl.scrollIntoView({behavior:'smooth'});
  } else {
    window.location.href = 'browse.php?search=' + encodeURIComponent(brand);
  }
}

function handleHeaderSearch(e) {
  if (e.key === 'Enter') doHeaderSearch();
}

function doHeaderSearch() {
  const q = document.getElementById('headerSearchInput')?.value || '';
  const browseEl = document.getElementById('browse');
  if (browseEl) {
    applyFilters();
    browseEl.scrollIntoView({behavior:'smooth'});
  } else {
    window.location.href = 'browse.php?search=' + encodeURIComponent(q);
  }
}

function doHeroSearch() {
  const q = document.getElementById('heroSearchInput')?.value || '';
  const cat = document.getElementById('heroCategory')?.value || '';
  let url = 'browse.php?';
  if (q) url += 'search=' + encodeURIComponent(q) + '&';
  if (cat && cat !== 'All Categories') url += 'category=' + encodeURIComponent(cat);
  window.location.href = url;
}

function updateCategoryCounts() {
  const cats = ['Phones','Tablets','Laptops','Accessories','Gaming'];
  cats.forEach(c => {
    const n = state.products.filter(p => p.category === c).length;
    const el = document.getElementById(`cat-count-${c}`);
    const fel = document.getElementById(`fcount-${c}`);
    if (el) el.textContent = `${n} listing${n!==1?'s':''}`;
    if (fel) fel.textContent = n;
  });
}

// ============================================================
// PRODUCT DETAIL
// ============================================================
function openProduct(id) {
  const p = state.products.find(x => x.id === id);
  if (!p) return;
  const discount = p.originalPrice && p.originalPrice > p.price
    ? Math.round((1 - p.price/p.originalPrice)*100) : 0;
  const content = document.getElementById('productModalContent');
  content.innerHTML = `
    <div class="product-modal-image">
      ${catIcon[p.category] || '📦'}
    </div>
    <div class="product-modal-body">
      <button class="modal-close" onclick="closeModal('productModal')" style="float:right;margin-bottom:8px;">✕</button>
      <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px;">
        <span class="badge ${conditionBadge[p.condition]||'badge-used'}">${p.condition}</span>
        ${p.featured ? `<span class="badge badge-featured">⭐ Featured</span>` : ''}
        ${discount > 0 ? `<span class="badge badge-discount">-${discount}% OFF</span>` : ''}
      </div>
      <h2 style="font-size:1.5rem;margin-bottom:4px;">${p.name}</h2>
      <p style="color:var(--text2);font-size:0.9rem;margin-bottom:16px;">${p.brand}${p.model ? ' · ' + p.model : ''}</p>
      <div style="display:flex;align-items:baseline;gap:12px;margin-bottom:20px;">
        <span style="font-family:var(--font-display);font-size:2rem;font-weight:800;color:var(--accent);">$${Number(p.price).toLocaleString()}</span>
        ${discount > 0 ? `<span style="font-size:0.9rem;color:var(--text3);text-decoration:line-through;">$${Number(p.originalPrice).toLocaleString()}</span>` : ''}
      </div>
      ${p.description ? `<p style="color:var(--text2);font-size:0.9rem;line-height:1.7;margin-bottom:20px;">${p.description}</p>` : ''}
      ${p.specs ? `
      <table class="spec-table">
        <tr><td>Specs</td><td><strong>${p.specs}</strong></td></tr>
        <tr><td>Category</td><td>${p.category}</td></tr>
        <tr><td>Condition</td><td>${p.condition}</td></tr>
        <tr><td>Shipping</td><td>${p.shipping || 'Contact seller'}</td></tr>
        <tr><td>Location</td><td>📍 ${p.location}</td></tr>
      </table>` : ''}
      <div class="seller-info">
        <div class="seller-info-row">
          <div class="seller-avatar">${(p.sellerName||'S').charAt(0).toUpperCase()}</div>
          <div>
            <div class="seller-name">${p.sellerName || 'TechSwap Seller'}</div>
            <div class="seller-rating">★★★★☆ Verified Seller</div>
          </div>
        </div>
      </div>
      <div class="product-modal-actions">
        <button class="btn btn-primary btn-lg" style="justify-content:center;" onclick="buyNow('${p.id}')">⚡ Buy Now</button>
        <button class="btn btn-outline" style="justify-content:center;" onclick="addToCart(event,'${p.id}')">🛒 Add to Cart</button>
        <button class="whatsapp-btn" onclick="openWhatsApp('${p.whatsapp||WHATSAPP_ADMIN}','${encodeURIComponent('Hi! I am interested in: '+p.name+' listed on TechSwap.')}')">
          💬 Inquire on WhatsApp
        </button>
      </div>
      <div style="text-align:right;margin-top:16px;">
        <span class="report-link" onclick="showToast('Report submitted. Our team will review this listing.','info','Report Sent')">⚑ Report Listing</span>
      </div>
    </div>`;
  openModal('productModal');
}

// ============================================================
// WISHLIST
// ============================================================
function toggleWishlist(e, id) {
  let actualId = id;
  if (typeof e === 'string') actualId = e;
  if (e && e.stopPropagation) e.stopPropagation();
  let p = state.products.find(x => x.id === actualId);
  if (!p && typeof BROWSE_PRODUCTS !== 'undefined') p = BROWSE_PRODUCTS.find(x => x.id === actualId);
  if (!p) return;
  const idx = state.wishlist.findIndex(w => w.id === actualId);
  if (idx === -1) {
    state.wishlist.push(p);
    showToast(`${p.name} added to wishlist!`, 'success', 'Wishlist');
  } else {
    state.wishlist.splice(idx, 1);
    showToast(`Removed from wishlist`, 'info', 'Wishlist');
  }
  localStorage.setItem('ts_wishlist', JSON.stringify(state.wishlist));
  updateWishlistCount();
  updateWishlistButtons();
  renderWishlistPanel();
}

function updateWishlistButtons() {
  state.products.forEach(p => {
    const btn = document.getElementById(`wb-${p.id}`);
    if (!btn) return;
    const isWished = state.wishlist.some(w => w.id === p.id);
    btn.classList.toggle('active', isWished);
    btn.innerHTML = isWished ? '♥' : '♡';
  });
}

function updateWishlistCount() {
  const n = state.wishlist.length;
  const el = document.getElementById('wishlistCount');
  if (el) { el.textContent = n; el.style.display = n > 0 ? 'flex' : 'none'; }
}

function openWishlist() {
  renderWishlistPanel();
  document.getElementById('wishlistPanel').classList.add('open');
  document.getElementById('panelBackdrop').classList.add('active');
}
function closeWishlist() {
  document.getElementById('wishlistPanel').classList.remove('open');
  document.getElementById('panelBackdrop').classList.remove('active');
}

function renderWishlistPanel() {
  const body = document.getElementById('wishlistBody');
  if (!body) return;
  if (state.wishlist.length === 0) {
    body.innerHTML = `<div class="empty-state"><div class="empty-icon">♡</div><h4>Your wishlist is empty</h4><p>Tap the heart on any listing to save it here.</p></div>`;
    return;
  }
  body.innerHTML = state.wishlist.map(p => `
    <div class="wishlist-item">
      <div class="wishlist-thumb">${catIcon[p.category]||'📦'}</div>
      <div class="wishlist-item-body">
        <div class="wishlist-item-name">${p.name}</div>
        <div class="wishlist-item-price">$${Number(p.price).toLocaleString()}</div>
        <button class="btn btn-primary btn-sm" style="margin-top:8px;" onclick="openProduct('${p.id}')">View</button>
      </div>
      <button class="wishlist-remove" onclick="toggleWishlist(event,'${p.id}')">✕</button>
    </div>`).join('');
}

// ============================================================
// CART
// ============================================================
function addToCart(e, id) {
  if (e && e.stopPropagation) e.stopPropagation();
  let p = state.products.find(x => x.id === id);
  if (!p && typeof BROWSE_PRODUCTS !== 'undefined') p = BROWSE_PRODUCTS.find(x => x.id === id);
  if (!p) return;
  const exists = state.cart.find(c => c.id === id);
  if (exists) { showToast('Already in cart!', 'info', 'Cart'); return; }
  state.cart.push({...p, qty: 1});
  localStorage.setItem('ts_cart', JSON.stringify(state.cart));
  updateCartCount();
  renderCartPanel();
  showToast(`${p.name} added to cart!`, 'success', 'Cart');
}

function removeFromCart(id) {
  state.cart = state.cart.filter(c => c.id !== id);
  localStorage.setItem('ts_cart', JSON.stringify(state.cart));
  updateCartCount();
  renderCartPanel();
}

function updateCartCount() {
  const n = state.cart.length;
  const el = document.getElementById('cartCount');
  if (el) { el.textContent = n; el.style.display = n > 0 ? 'flex' : 'none'; }
}

function openCart() {
  renderCartPanel();
  document.getElementById('cartPanel').classList.add('open');
  document.getElementById('panelBackdrop').classList.add('active');
}

function closeCart() {
  document.getElementById('cartPanel').classList.remove('open');
  document.getElementById('panelBackdrop').classList.remove('active');
}

function renderCartPanel() {
  const body = document.getElementById('cartBody');
  const footer = document.getElementById('cartFooter');
  if (!body) return;
  if (state.cart.length === 0) {
    body.innerHTML = `<div class="empty-state"><div class="empty-icon">🛒</div><h4>Your cart is empty</h4><p>Add devices to your cart to purchase them.</p></div>`;
    if (footer) footer.style.display = 'none';
    return;
  }
  const total = state.cart.reduce((s, c) => s + c.price, 0);
  body.innerHTML = state.cart.map(p => `
    <div class="cart-item">
      <div class="cart-thumb">${catIcon[p.category]||'📦'}</div>
      <div class="cart-item-body">
        <div class="cart-item-name">${p.name}</div>
        <div class="cart-item-price">$${Number(p.price).toLocaleString()}</div>
      </div>
      <button class="wishlist-remove" onclick="removeFromCart('${p.id}')">✕</button>
    </div>`).join('');
  const totalEl = document.getElementById('cartTotal');
  if (totalEl) totalEl.textContent = `$${total.toLocaleString()}`;
  if (footer) footer.style.display = 'block';
}

function handleCheckout() {
  if (!state.cart.length) {
    showToast('Your cart is empty.', 'info', 'Cart');
    return;
  }

  closeCart();
  openModal('orderModal');
  const content = document.getElementById('orderModalContent');
  const total = state.cart.reduce((s,c) => s+c.price, 0);
  content.innerHTML = `
    <p style="color:var(--text2);margin-bottom:24px;">You're purchasing ${state.cart.length} item${state.cart.length>1?'s':''} for a total of <strong>$${total.toLocaleString()}</strong>.</p>
    <div class="form-group"><label>Full Name *</label><input class="form-control" type="text" placeholder="John Doe" required></div>
    <div class="form-group"><label>Email *</label><input class="form-control" type="email" placeholder="john@example.com" required></div>
    <div class="form-group"><label>Delivery Address *</label><textarea class="form-control" rows="2" placeholder="Street, City, Country, ZIP"></textarea></div>
    <div class="form-group"><label>Payment Method</label>
      <select class="form-control">
        <option>Credit/Debit Card</option>
        <option>PayPal</option>
        <option>Bank Transfer</option>
        <option>Cash on Delivery</option>
      </select>
    </div>
    <button class="btn btn-primary btn-lg" id="confirmOrderBtn" style="width:100%;justify-content:center;margin-top:8px;" onclick="confirmOrder()">
      🔒 Place Order — $${total.toLocaleString()}
    </button>`;
}

async function confirmOrder() {
  if (!state.cart.length) {
    showToast('Your cart is empty.', 'info', 'Cart');
    closeModal('orderModal');
    return;
  }

  const button = document.getElementById('confirmOrderBtn');
  if (button) {
    button.disabled = true;
    button.textContent = 'Placing Order...';
  }

  try {
    const results = await Promise.all(state.cart.map(item =>
      fetch('buy.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ product_id: item.id })
      }).then(res => res.json())
    ));

    const failed = results.find(r => r.status !== 'success');
    if (failed) {
      throw new Error(failed.message || 'Some orders could not be placed.');
    }

    closeModal('orderModal');
    state.cart = [];
    localStorage.setItem('ts_cart', JSON.stringify(state.cart));
    updateCartCount();
    renderCartPanel();

    const firstOrderId = results[0]?.display_order_id || '';
    const suffix = results.length > 1 ? ` + ${results.length - 1} more` : '';
    showToast(`Order ${firstOrderId}${suffix} placed successfully! Redirecting...`, 'success', 'Order Confirmed');

    setTimeout(() => {
      window.location.href = 'orders.php?order_success=1';
    }, 1400);
  } catch (error) {
    showToast(error.message || 'Could not place the order right now.', 'error', 'Error');
    if (button) {
      button.disabled = false;
      button.textContent = `🔒 Place Order — $${state.cart.reduce((s,c) => s + c.price, 0).toLocaleString()}`;
    }
  }
}

function buyNow(id) {
  fetch('buy.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ product_id: id })
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === "success") {
      showToast(`Order ${data.display_order_id || ''} placed successfully! Redirecting...`, 'success', 'Order Confirmed');
      setTimeout(() => {
        window.location.href = 'orders.php?order_success=1';
      }, 1400);
    } else {
      showToast(data.message || 'Order failed', 'error', 'Error');
    }
  })
  .catch(() => {
    showToast('Could not place the order right now.', 'error', 'Error');
  });
}

// ============================================================
// SELL / LIST DEVICE
// ============================================================
function openSellModal() {
  if (!state.user) {
    showToast('Please sign in to list a device.', 'info', 'Sign In Required');
    openAuthModal('login');
    return;
  }
  openModal('sellModal');
}

function handleListSubmit(e) {
  e.preventDefault();
  const product = {
    id: 'p_' + Date.now(),
    name: document.getElementById('sell-name').value,
    brand: document.getElementById('sell-brand').value,
    model: document.getElementById('sell-model').value,
    category: document.getElementById('sell-category').value,
    price: parseFloat(document.getElementById('sell-price').value),
    originalPrice: parseFloat(document.getElementById('sell-original-price').value) || null,
    condition: document.getElementById('sell-condition').value,
    location: document.getElementById('sell-location').value,
    description: document.getElementById('sell-description').value,
    specs: document.getElementById('sell-specs').value,
    shipping: document.getElementById('sell-shipping').value,
    whatsapp: document.getElementById('sell-whatsapp').value,
    featured: document.getElementById('sell-boost').value === 'featured',
    sellerName: state.user?.name || 'Seller',
    createdAt: Date.now(),
  };
  state.products.unshift(product);
  saveProducts();
  applyFilters();
  updateCategoryCounts();
  renderHeroCards();
  closeModal('sellModal');
  e.target.reset();
  showToast(`${product.name} listed successfully!`, 'success', 'Listing Published 🎉');
  openWhatsApp(WHATSAPP_ADMIN, `New listing on TechSwap: ${product.name} - $${product.price}`);
}

// ============================================================
// AUTH
// ============================================================
function openAuthModal(mode) {
  const modal = document.getElementById('authModal');
  const title = document.getElementById('authModalTitle');
  const body = document.getElementById('authModalBody');
  if (mode === 'login') {
    title.textContent = 'Sign In to TechSwap';
    body.innerHTML = `
      <div class="form-group"><label>Email *</label><input class="form-control" type="email" id="auth-email" placeholder="you@example.com" required></div>
      <div class="form-group"><label>Password *</label><input class="form-control" type="password" id="auth-password" placeholder="••••••••" required></div>
      <button class="btn btn-primary btn-lg" style="width:100%;justify-content:center;" onclick="handleLogin()">Sign In →</button>
      <p style="text-align:center;margin-top:20px;font-size:0.88rem;color:var(--text2);">
        Don't have an account? <a href="#" onclick="openAuthModal('register')" style="color:var(--accent);font-weight:600;">Register</a>
      </p>
      <div style="text-align:center;margin-top:12px;">
        <a href="#" style="font-size:0.82rem;color:var(--text3);">Forgot password?</a>
      </div>`;
  } else {
    title.textContent = 'Create Account';
    body.innerHTML = `
      <div class="form-row">
        <div class="form-group"><label>First Name *</label><input class="form-control" type="text" id="auth-fname" placeholder="John" required></div>
        <div class="form-group"><label>Last Name *</label><input class="form-control" type="text" id="auth-lname" placeholder="Doe" required></div>
      </div>
      <div class="form-group"><label>Email *</label><input class="form-control" type="email" id="auth-email" placeholder="you@example.com" required></div>
      <div class="form-group"><label>Password *</label><input class="form-control" type="password" id="auth-password" placeholder="Min 8 characters" required></div>
      <div class="form-group"><label>WhatsApp (optional)</label><input class="form-control" type="tel" id="auth-wa" placeholder="+1234567890"></div>
      <div class="form-group" style="display:flex;gap:10px;align-items:flex-start;">
        <input type="checkbox" id="auth-terms" style="margin-top:3px;accent-color:var(--accent);">
        <label for="auth-terms" style="font-size:0.85rem;color:var(--text2);">I agree to the <a href="#" style="color:var(--accent);">Terms of Service</a> and <a href="#" style="color:var(--accent);">Privacy Policy</a></label>
      </div>
      <button class="btn btn-primary btn-lg" style="width:100%;justify-content:center;" onclick="handleRegister()">Create Account →</button>
      <p style="text-align:center;margin-top:20px;font-size:0.88rem;color:var(--text2);">
        Already have an account? <a href="#" onclick="openAuthModal('login')" style="color:var(--accent);font-weight:600;">Sign In</a>
      </p>`;
  }
  openModal('authModal');
}

function handleLogin() {
  const email = document.getElementById('auth-email')?.value;
  const pass = document.getElementById('auth-password')?.value;
  if (!email || !pass) { showToast('Please fill in all fields.', 'error', 'Error'); return; }
  const user = { email, name: email.split('@')[0], id: 'u_' + Date.now() };
  state.user = user;
  localStorage.setItem('ts_user', JSON.stringify(user));
  closeModal('authModal');
  showToast(`Welcome back, ${user.name}!`, 'success', 'Signed In');
}

function handleRegister() {
  const fname = document.getElementById('auth-fname')?.value;
  const lname = document.getElementById('auth-lname')?.value;
  const email = document.getElementById('auth-email')?.value;
  const pass = document.getElementById('auth-password')?.value;
  const terms = document.getElementById('auth-terms')?.checked;
  if (!fname || !email || !pass) { showToast('Please fill in all required fields.', 'error', 'Error'); return; }
  if (!terms) { showToast('Please agree to the Terms of Service.', 'error', 'Error'); return; }
  const user = { email, name: `${fname} ${lname}`.trim(), id: 'u_' + Date.now() };
  state.user = user;
  localStorage.setItem('ts_user', JSON.stringify(user));
  closeModal('authModal');
  showToast(`Welcome to TechSwap, ${user.name}!`, 'success', 'Account Created 🎉');
  openWhatsApp(WHATSAPP_ADMIN, `New user registered: ${user.name} (${user.email})`);
}

// ============================================================
// WHATSAPP
// ============================================================
function openWhatsApp(number, msg) {
  const n = number || WHATSAPP_ADMIN;
  const m = msg ? encodeURIComponent(msg) : '';
  const clean = n.replace(/[^0-9]/g, '');
  window.open(`https://wa.me/${clean}${m ? '?text=' + m : ''}`, '_blank');
}

// ============================================================
// MODAL HELPERS
// ============================================================
function openModal(id) {
  document.getElementById(id).classList.add('active');
  document.body.style.overflow = 'hidden';
}
function closeModal(id) {
  document.getElementById(id).classList.remove('active');
  document.body.style.overflow = '';
}
document.addEventListener('click', e => {
  if (e.target.classList.contains('modal-overlay')) {
    e.target.classList.remove('active');
    document.body.style.overflow = '';
  }
});

function closePanels() { closeWishlist(); closeCart(); }

// ============================================================
// TOAST
// ============================================================
function showToast(message, type = 'info', title = '') {
  const container = document.getElementById('toastContainer');
  const toast = document.createElement('div');
  toast.className = `toast toast-${type}`;
  const icons = { success: '✅', error: '❌', info: 'ℹ️' };
  toast.innerHTML = `
    <span class="toast-icon">${icons[type] || 'ℹ️'}</span>
    <div class="toast-text">
      ${title ? `<div class="toast-title">${title}</div>` : ''}
      <div class="toast-desc">${message}</div>
    </div>
    <span class="toast-close" onclick="this.parentElement.remove()">✕</span>`;
  container.appendChild(toast);
  setTimeout(() => toast.remove(), 4000);
}

// ============================================================
// THEME
// ============================================================
function toggleTheme() {
  const html = document.documentElement;
  const current = html.getAttribute('data-theme');
  const next = current === 'dark' ? 'light' : 'dark';
  html.setAttribute('data-theme', next);
  document.querySelector('.theme-toggle').textContent = next === 'dark' ? '☀' : '🌙';
  localStorage.setItem('ts_theme', next);
}

// ============================================================
// MOBILE MENU
// ============================================================
function toggleMobileMenu() { document.getElementById('mobileNav').classList.toggle('open'); }
function closeMobileMenu() { document.getElementById('mobileNav').classList.remove('open'); }

// ============================================================
// SCROLL HEADER
// ============================================================
window.addEventListener('scroll', () => {
  document.getElementById('header').classList.toggle('scrolled', window.scrollY > 20);
});

// ============================================================
// FAQ
// ============================================================
const faqs = [
  {q: 'Is TechSwap free to use?', a: 'Browsing and buying are completely free. Sellers can list their first device at no cost. Optional paid features like Featured Listings are available to boost visibility.'},
  {q: 'How do I contact a seller?', a: 'Each listing has a WhatsApp Inquire button. Click it to open a direct WhatsApp chat with the seller. You can negotiate price, ask questions, or arrange pickup/delivery.'},
  {q: 'How are payments handled?', a: 'Payments are processed securely through our checkout system. We support credit/debit cards, PayPal, and bank transfers. For local pickups, cash is also an option agreed between buyer and seller.'},
  {q: 'What conditions are accepted on TechSwap?', a: 'We accept devices in New, Like New, Used, Refurbished, and Open Box conditions. Sellers must accurately describe the condition — misrepresentation can result in account suspension.'},
  {q: 'Can I sell from any country?', a: 'Yes! TechSwap is a global marketplace. Sellers from any country can list devices and specify their shipping options. Buyers worldwide can browse and purchase.'},
  {q: 'What if I receive a defective device?', a: 'We have a buyer protection policy. If a device does not match its listing description, contact us within 48 hours of delivery. Our team will mediate and issue refunds where applicable.'},
  {q: 'How do I report a suspicious listing?', a: 'Each product page has a "Report Listing" link. Our moderation team reviews all reports within 24 hours and takes action on policy violations immediately.'},
];

function renderFAQ() {
  const list = document.getElementById('faqList');
  if (!list) return;
  list.innerHTML = faqs.map((f,i) => `
    <div class="faq-item" id="faq-${i}">
      <div class="faq-question" onclick="toggleFAQ(${i})">
        ${f.q}
        <div class="faq-icon">+</div>
      </div>
      <div class="faq-answer" id="faq-ans-${i}">${f.a}</div>
    </div>`).join('');
}

function toggleFAQ(i) {
  const item = document.getElementById(`faq-${i}`);
  const ans = document.getElementById(`faq-ans-${i}`);
  const isOpen = item.classList.contains('open');
  document.querySelectorAll('.faq-item').forEach(el => {
    el.classList.remove('open');
    el.querySelector('.faq-answer').classList.remove('open');
  });
  if (!isOpen) { item.classList.add('open'); ans.classList.add('open'); }
}

// ============================================================
// BLOG
// ============================================================
const blogs = [
  { icon: '📱', cat: 'Buying Guide', title: 'How to Buy a Used Smartphone Without Getting Scammed', excerpt: 'Key checks to run before paying for any second-hand phone — IMEI verification, battery health, and more.', date: 'Jan 2025', read: '5 min read' },
  { icon: '💻', cat: 'Comparison', title: 'MacBook vs Windows Laptop: Which Holds Value Better?', excerpt: 'A data-driven look at resale prices for Apple and PC laptops over 3 years.', date: 'Jan 2025', read: '8 min read' },
  { icon: '🎧', cat: 'Tips', title: '10 Accessories Worth Buying Second-Hand (And 3 to Avoid)', excerpt: 'Not all electronics age the same. Here is what is safe to buy used and what you should always buy new.', date: 'Dec 2024', read: '6 min read' },
];

function renderBlog() {
  const grid = document.getElementById('blogGrid');
  if (!grid) return;
  grid.innerHTML = blogs.map(b => `
    <div class="blog-card">
      <div class="blog-image">${b.icon}</div>
      <div class="blog-body">
        <div class="blog-cat">${b.cat}</div>
        <h3>${b.title}</h3>
        <p>${b.excerpt}</p>
        <div class="blog-meta"><span>📅 ${b.date}</span><span>⏱ ${b.read}</span></div>
      </div>
    </div>`).join('');
}

// ============================================================
// HERO CARDS
// ============================================================
function renderHeroCards() {
  const container = document.getElementById('heroCards');
  if (!container) return;
  const recent = state.products.slice(0, 4);
  if (recent.length === 0) {
    container.innerHTML = `
      <div style="grid-column:1/-1;text-align:center;padding:40px 20px;background:var(--surface);border-radius:var(--radius);border:1.5px dashed var(--border);">
        <div style="font-size:2rem;margin-bottom:10px;">📦</div>
        <p style="color:var(--text2);font-size:0.9rem;">No listings yet — be the first to sell!</p>
        <button class="btn btn-primary btn-sm" style="margin-top:12px;" onclick="openSellModal()">List a Device</button>
      </div>`;
    return;
  }
  container.innerHTML = recent.map(p => `
    <div class="hero-card" onclick="openProduct('${p.id}')">
      <div class="hero-card-icon">${catIcon[p.category]||'📦'}</div>
      <div class="hero-card-name">${p.name}</div>
      <div class="hero-card-price">$${Number(p.price).toLocaleString()}</div>
      <div class="hero-card-condition">${p.condition}</div>
    </div>`).join('');
}

// ============================================================
// NEWSLETTER
// ============================================================
function handleNewsletter(e) {
  e.preventDefault();
  showToast('You are now subscribed to TechSwap updates!', 'success', 'Subscribed 🎉');
  e.target.reset();
}

// ============================================================
// SCROLL HELPER
// ============================================================
function scrollTo(selector) {
  document.querySelector(selector)?.scrollIntoView({behavior:'smooth'});
}

// ============================================================
// READ URL PARAMS (for cross-page navigation)
// ============================================================
function readUrlParams() {
  const params = new URLSearchParams(window.location.search);
  const search = params.get('search');
  const category = params.get('category');
  if (search) {
    const el = document.getElementById('headerSearchInput');
    if (el) el.value = search;
  }
  if (category) {
    state.activeCategory = category;
  }
}

// ============================================================
// INIT
// ============================================================
function init() {
  // Theme
  const savedTheme = localStorage.getItem('ts_theme') || 'light';
  document.documentElement.setAttribute('data-theme', savedTheme);
  const themeBtn = document.querySelector('.theme-toggle');
  if (themeBtn) themeBtn.textContent = savedTheme === 'dark' ? '☀' : '🌙';

  // Load data
  loadProducts();
  readUrlParams();
  applyFilters();
  updateCategoryCounts();
  updateWishlistCount();
  updateCartCount();
  renderHeroCards();
  renderFAQ();
  renderBlog();
  renderWishlistPanel();
  renderCartPanel();
}

document.addEventListener('DOMContentLoaded', () => {
  init();
  
  // Global Scroll Reveal & Counters Observer
  window.tsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        
        // Trigger counter animation
        if (entry.target.classList.contains('count-up') || entry.target.querySelector('.count-up')) {
          const counters = entry.target.classList.contains('count-up') ? [entry.target] : entry.target.querySelectorAll('.count-up');
          counters.forEach(c => {
            if (c.dataset.counted) return;
            c.dataset.counted = "true";
            const target = parseFloat(c.getAttribute('data-val'));
            const suffix = c.getAttribute('data-suffix') || 'k';
            let count = 0;
            let inc = target / 40;
            let timer = setInterval(() => {
              count += inc;
              if (count >= target) {
                count = target;
                clearInterval(timer);
              }
              c.innerText = count.toFixed(target % 1 === 0 ? 0 : 1).replace(/\.0$/, '') + suffix + (target === 12 ? '+' : '');
            }, 30);
          });
        }
      }
    });
  }, { threshold: 0.1 });
  
  document.querySelectorAll('.scroll-reveal, .hero-stats').forEach((el) => window.tsObserver.observe(el));
});
function loadCartUI() {
  const cart = JSON.parse(localStorage.getItem('ts_cart') || '[]');
  const container = document.getElementById('cartItems');

  if (!container) return;

  if (cart.length === 0) {
    container.innerHTML = `
      <div style="text-align:center; padding:40px;">
        <h3>Your cart is empty</h3>
        <p>Add items from the browse page.</p>
      </div>
    `;
    return;
  }

  let html = '';
  cart.forEach(item => {
    html += `
      <div class="card" style="padding:12px; margin-bottom:10px;">
        <strong>${item.name}</strong>
        <div>$${item.price}</div>
      </div>
    `;
  });

  container.innerHTML = html;
}
function placeOrderPHP(product) {
  fetch('place_order.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `product_id=${product.id}&product_name=${encodeURIComponent(product.name)}`
  })
  .then(res => res.text())
  .then(data => {
    alert(data);
  });
}
</script>
