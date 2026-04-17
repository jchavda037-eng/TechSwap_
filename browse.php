<?php
// browse.php — Browse / Marketplace Page
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user_id'])) {
  header('Location: login.php?redirect=browse.php');
  exit;
}
$pageTitle  = 'Browse Listings — TechSwap';
$activePage = 'browse';
include '_header.php';
?>

<section class="section" id="browse" style="background:var(--bg2); padding-top:48px;">
  <div class="container">
    <div class="section-header scroll-reveal">
      <div class="tag">Marketplace</div>
      <h2>Latest Listings</h2>
      <p>Fresh devices added by verified sellers every day. Find your next tech upgrade.</p>
    </div>

    <div class="marketplace-layout">
      <!-- FILTERS -->
      <aside class="filters-panel scroll-reveal">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
          <span style="font-family:var(--font-display);font-weight:800;font-size:1rem;">Filters</span>
          <button class="btn btn-ghost btn-sm" onclick="browseClearFilters()" style="font-size:0.78rem;padding:4px 10px;">Clear all</button>
        </div>
        <div class="filter-section">
          <div class="filter-title">Category <span>›</span></div>
          <div class="filter-option"><input type="checkbox" id="f-phones"      onchange="browseApplyFilters()"><label for="f-phones">Phones</label><span class="filter-count" id="fcount-Phones">0</span></div>
          <div class="filter-option"><input type="checkbox" id="f-tablets"     onchange="browseApplyFilters()"><label for="f-tablets">Tablets</label><span class="filter-count" id="fcount-Tablets">0</span></div>
          <div class="filter-option"><input type="checkbox" id="f-laptops"     onchange="browseApplyFilters()"><label for="f-laptops">Laptops</label><span class="filter-count" id="fcount-Laptops">0</span></div>
          <div class="filter-option"><input type="checkbox" id="f-accessories" onchange="browseApplyFilters()"><label for="f-accessories">Accessories</label><span class="filter-count" id="fcount-Accessories">0</span></div>
          <div class="filter-option"><input type="checkbox" id="f-gaming"      onchange="browseApplyFilters()"><label for="f-gaming">Gaming</label><span class="filter-count" id="fcount-Gaming">0</span></div>
        </div>
        <div class="filter-divider"></div>
        <div class="filter-section">
          <div class="filter-title">Condition <span>›</span></div>
          <div class="filter-option"><input type="checkbox" id="fc-new"         onchange="browseApplyFilters()"><label for="fc-new">New</label></div>
          <div class="filter-option"><input type="checkbox" id="fc-like-new"    onchange="browseApplyFilters()"><label for="fc-like-new">Like New</label></div>
          <div class="filter-option"><input type="checkbox" id="fc-used"        onchange="browseApplyFilters()"><label for="fc-used">Used</label></div>
          <div class="filter-option"><input type="checkbox" id="fc-refurbished" onchange="browseApplyFilters()"><label for="fc-refurbished">Refurbished</label></div>
          <div class="filter-option"><input type="checkbox" id="fc-open-box"    onchange="browseApplyFilters()"><label for="fc-open-box">Open Box</label></div>
        </div>
        <div class="filter-divider"></div>
        <div class="filter-section">
          <div class="filter-title">Price Range <span>›</span></div>
          <div class="price-range">
            <input type="number" class="price-input" id="priceMin" placeholder="Min $" onchange="browseApplyFilters()">
            <input type="number" class="price-input" id="priceMax" placeholder="Max $" onchange="browseApplyFilters()">
          </div>
        </div>
        <div class="filter-divider"></div>
        <div class="filter-section">
          <div class="filter-title">Location <span>›</span></div>
          <select class="form-control" id="locationFilter" onchange="browseApplyFilters()" style="font-size:0.85rem;">
            <option value="">All Locations</option>
            <option>USA</option><option>UK</option><option>Canada</option>
            <option>Australia</option><option>India</option><option>UAE</option><option>Singapore</option>
          </select>
        </div>
        <div class="filter-divider"></div>
        <div class="filter-section">
          <div class="filter-title">Shipping <span>›</span></div>
          <div class="filter-option"><input type="checkbox" id="fs-delivery" onchange="browseApplyFilters()"><label for="fs-delivery">Delivery Available</label></div>
          <div class="filter-option"><input type="checkbox" id="fs-pickup"   onchange="browseApplyFilters()"><label for="fs-pickup">Self Pickup</label></div>
        </div>
      </aside>

      <!-- PRODUCTS -->
      <div>
        <div class="products-header">
          <div class="products-count" id="browseProductsCount">Showing 0 listings</div>
          <div class="products-header-right">
            <select class="sort-select" id="browseSortSelect" onchange="browseApplyFilters()">
              <option value="newest">Newest First</option>
              <option value="price-asc">Price: Low to High</option>
              <option value="price-desc">Price: High to Low</option>
              <option value="featured">Featured First</option>
            </select>
            <div class="view-toggle">
              <button class="view-btn active" id="browseGridViewBtn" onclick="browseSetView('grid')" title="Grid view">⊞</button>
              <button class="view-btn"        id="browseListViewBtn" onclick="browseSetView('list')" title="List view">☰</button>
            </div>
          </div>
        </div>
        <div class="products-grid" id="browseProductsGrid"></div>
        <div class="pagination"    id="browsePagination"></div>
      </div>
    </div>
  </div>
</section>

<script>
const BROWSE_COND_BADGE = { 'New':'badge-new','Like New':'badge-like-new','Used':'badge-used','Refurbished':'badge-refurbished','Open Box':'badge-open-box' };
const BROWSE_COND_MAP   = { 'new':'New','like-new':'Like New','used':'Used','refurbished':'Refurbished','open-box':'Open Box' };
const BROWSE_PER_PAGE = 9;
let browseCurrentPage = 1;
let browseProducts = [];
let browseFiltered = [];
let browseModalProduct = null;

function getBrowseProducts() {
  return browseProducts;
}

function browseRenderProducts(){
  browseUpdateFilterCounts();
  const page = browseFiltered.slice((browseCurrentPage-1)*BROWSE_PER_PAGE, browseCurrentPage*BROWSE_PER_PAGE);
  const grid = document.getElementById('browseProductsGrid');
  document.getElementById('browseProductsCount').textContent =
    'Showing ' + browseFiltered.length + ' listing' + (browseFiltered.length!==1?'s':'');

  if(!page.length){
    grid.innerHTML = '<div class="empty-state" style="grid-column:1/-1;padding:60px 0"><div class="empty-icon">🔍</div><h4>No listings found</h4><p>Try adjusting your filters.</p></div>';
    document.getElementById('browsePagination').innerHTML = '';
    return;
  }

  grid.innerHTML = page.map((p, idx) => {
    const orig = p.discount ? Math.round(p.price/(1-p.discount/100)) : null;
    return `<div class="product-card visible" style="animation-delay:${idx * 0.05}s">
      <div class="product-image">
        <span class="product-image-placeholder">${p.icon}</span>
        ${p.featured ? '<div class="product-featured-badge"><span class="badge badge-featured">⭐ Featured</span></div>' : ''}
        ${p.discount ? `<div class="product-discount-badge"><span class="badge badge-discount">-${p.discount}%</span></div>` : ''}
        <button class="product-wishlist" title="Save to wishlist"
          onclick="event.stopPropagation();toggleWishlist('${p.id}',{name:'${p.name.replace(/'/g,"\\'")}',price:${p.price},icon:'${p.icon}'},this)">♡</button>
      </div>
      <div class="product-body">
        <div class="product-condition"><span class="badge ${BROWSE_COND_BADGE[p.condition]||''}">${p.condition}</span></div>
        <div class="product-name">${p.name}</div>
        <div class="product-brand">${p.brand}</div>
        <div class="product-price-row">
          <div>
            <span class="product-price">$${p.price.toLocaleString()}</span>
            ${orig ? `<span class="product-original-price">$${orig.toLocaleString()}</span>` : ''}
          </div>
        </div>
        <div class="product-location">📍 ${p.location}</div>
        <div class="product-actions">
          <button class="btn btn-primary btn-sm"
            onclick="event.stopPropagation();addToCart(null,'${p.id}')">🛒 Add to Cart</button>
          <button class="btn btn-outline btn-sm"
            onclick="event.stopPropagation();browseOpenModal('${p.id}')">Details</button>
        </div>
      </div>
    </div>`;
  }).join('');

  if (window.tsObserver) {
    document.querySelectorAll('#browseProductsGrid .scroll-reveal').forEach(el => window.tsObserver.observe(el));
  }

  const totalPages = Math.ceil(browseFiltered.length/BROWSE_PER_PAGE);
  const pg = document.getElementById('browsePagination');
  if(totalPages<=1){ pg.innerHTML=''; return; }
  pg.innerHTML = Array.from({length:totalPages},(_,i)=>
    `<button class="page-btn ${i+1===browseCurrentPage?'active':''}" onclick="browseGoPage(${i+1})">${i+1}</button>`
  ).join('');
}

function browseGoPage(n){ browseCurrentPage=n; browseRenderProducts(); window.scrollTo({top:300,behavior:'smooth'}); }
function browseSetView(v){
  document.getElementById('browseProductsGrid').classList.toggle('list-view', v==='list');
  document.getElementById('browseGridViewBtn').classList.toggle('active', v==='grid');
  document.getElementById('browseListViewBtn').classList.toggle('active', v==='list');
}

function browseApplyFilters(){
  browseCurrentPage = 1;
  const products = getBrowseProducts();
  const cats   = ['Phones','Tablets','Laptops','Accessories','Gaming'].filter(c=>document.getElementById('f-'+c.toLowerCase())?.checked);
  const conds  = ['new','like-new','used','refurbished','open-box'].filter(c=>document.getElementById('fc-'+c)?.checked).map(c=>BROWSE_COND_MAP[c]);
  const minP   = parseFloat(document.getElementById('priceMin').value)||0;
  const maxP   = parseFloat(document.getElementById('priceMax').value)||Infinity;
  const loc    = document.getElementById('locationFilter').value;
  const deliv  = document.getElementById('fs-delivery')?.checked;
  const pick   = document.getElementById('fs-pickup')?.checked;
  const sort   = document.getElementById('browseSortSelect').value;
  const q      = (new URLSearchParams(window.location.search).get('q')||'').toLowerCase();
  const catParam = new URLSearchParams(window.location.search).get('category');

  browseFiltered = products.filter(p => {
    if(cats.length  && !cats.includes(p.category))    return false;
    if(conds.length && !conds.includes(p.condition))  return false;
    if(p.price<minP || p.price>maxP)                  return false;
    if(loc && p.location!==loc)                        return false;
    if(deliv && !p.delivery)                           return false;
    if(pick  && !p.pickup)                             return false;
    if(q && !p.name.toLowerCase().includes(q) && !p.brand.toLowerCase().includes(q)) return false;
    if(catParam && p.category !== catParam)             return false;
    return true;
  });

  if(sort==='price-asc')  browseFiltered.sort((a,b)=>a.price-b.price);
  if(sort==='price-desc') browseFiltered.sort((a,b)=>b.price-a.price);
  if(sort==='featured')   browseFiltered.sort((a,b)=>b.featured-a.featured);
  browseRenderProducts();
}

function browseClearFilters(){
  document.querySelectorAll('.filters-panel input[type=checkbox]').forEach(c=>c.checked=false);
  document.getElementById('priceMin').value='';
  document.getElementById('priceMax').value='';
  document.getElementById('locationFilter').value='';
  document.getElementById('browseSortSelect').value='newest';
  // Clear URL params
  window.history.replaceState({}, '', 'browse.php');
  browseApplyFilters();
}

function browseUpdateFilterCounts(){
  ['Phones','Tablets','Laptops','Accessories','Gaming'].forEach(cat=>{
    const el=document.getElementById('fcount-'+cat);
    if(el) el.textContent=getBrowseProducts().filter(p=>p.category===cat).length;
  });
}

function browseOpenModal(id){
  const p = getBrowseProducts().find(x=>x.id===id);
  if(!p) return;
  browseModalProduct = p;
  const orig = p.discount ? Math.round(p.price/(1-p.discount/100)) : null;
  const content = document.getElementById('productModalContent');
  content.innerHTML = `
    <div class="product-modal-image">${p.icon}</div>
    <div class="product-modal-body">
      <button class="modal-close" onclick="closeModal('productModal')" style="float:right;margin-bottom:8px;">✕</button>
      <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px;">
        <span class="badge ${BROWSE_COND_BADGE[p.condition]||''}">${p.condition}</span>
        ${p.featured ? '<span class="badge badge-featured">⭐ Featured</span>' : ''}
        ${p.discount ? `<span class="badge badge-discount">-${p.discount}% OFF</span>` : ''}
      </div>
      <h2 style="font-size:1.5rem;margin-bottom:4px;">${p.name}</h2>
      <p style="color:var(--text2);font-size:0.9rem;margin-bottom:16px;">${p.brand}</p>
      <div style="display:flex;align-items:baseline;gap:12px;margin-bottom:20px;">
        <span style="font-family:var(--font-display);font-size:2rem;font-weight:800;color:var(--accent);">$${p.price.toLocaleString()}</span>
        ${orig ? `<span style="font-size:0.9rem;color:var(--text3);text-decoration:line-through;">$${orig.toLocaleString()}</span>` : ''}
      </div>
      <table class="spec-table">
        <tr><td>Brand</td><td><strong>${p.brand}</strong></td></tr>
        <tr><td>Category</td><td>${p.category}</td></tr>
        <tr><td>Condition</td><td>${p.condition}</td></tr>
        <tr><td>Location</td><td>📍 ${p.location}</td></tr>
        <tr><td>Delivery</td><td>${p.delivery?'✅ Available':'❌ Not available'}</td></tr>
        <tr><td>Self Pickup</td><td>${p.pickup?'✅ Available':'❌ Not available'}</td></tr>
      </table>
      <div class="seller-info">
        <div class="seller-info-row">
          <div class="seller-avatar">S</div>
          <div><div class="seller-name">Verified Seller</div><div class="seller-rating">⭐ 4.8 · 42 sales</div></div>
        </div>
      </div>
      <div class="product-modal-actions">
        <button class="btn btn-primary btn-lg" style="justify-content:center;" onclick="buyNow('${p.id}');closeModal('productModal');">⚡ Buy Now</button>
        <button class="btn btn-outline" style="justify-content:center;" onclick="addToCart(null,'${p.id}')">🛒 Add to Cart</button>
        <button class="whatsapp-btn" onclick="openWhatsApp('','Hi! I am interested in: ${p.name} on TechSwap.')">💬 Inquire on WhatsApp</button>
      </div>
      <div style="text-align:right;margin-top:16px;">
        <span class="report-link" onclick="showToast('Report submitted.','info','Report Sent')">⚑ Report Listing</span>
      </div>
    </div>`;
  openModal('productModal');
}

function browseInitializeProducts() {
  const grid = document.getElementById('browseProductsGrid');
  if (grid) {
    grid.innerHTML = '<div class="empty-state" style="grid-column:1/-1;padding:60px 0"><div class="empty-icon">⏳</div><h4>Loading listings</h4><p>Fetching products from the database.</p></div>';
  }

  fetch('products_api.php')
    .then(res => res.json())
    .then(json => {
      if (json.status !== 'success') {
        throw new Error(json.message || 'Could not load products.');
      }

      browseProducts = (json.data || []).map(p => ({
        ...p,
        icon: (typeof catIcon !== 'undefined' ? (catIcon[p.category] || '📦') : '📦')
      }));
      browseApplyFilters();
    })
    .catch(err => {
      if (grid) {
        grid.innerHTML = `<div class="empty-state" style="grid-column:1/-1;padding:60px 0"><div class="empty-icon">⚠️</div><h4>Could not load listings</h4><p>${err.message}</p></div>`;
      }
      document.getElementById('browseProductsCount').textContent = 'Showing 0 listings';
      document.getElementById('browsePagination').innerHTML = '';
    });
}

document.addEventListener('DOMContentLoaded', browseInitializeProducts);
</script>

<?php include '_footer.php'; ?>
