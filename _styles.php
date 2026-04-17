<style>
  :root {
    --bg: #f5f4f0;
    --bg2: #eceae4;
    --surface: #ffffff;
    --surface2: #f0ede7;
    --border: #ddd9d0;
    --text: #1a1a18;
    --text2: #5a5a55;
    --text3: #9a9a90;
    --accent: #e8400a;
    --accent2: #ff6b35;
    --accent-light: #fff0eb;
    --green: #1a7a4a;
    --green-light: #e6f5ee;
    --blue: #0a4a8a;
    --blue-light: #e6f0fa;
    --shadow: 0 2px 12px rgba(0,0,0,0.06);
    --shadow-md: 0 8px 32px rgba(0,0,0,0.10);
    --shadow-lg: 0 20px 60px rgba(0,0,0,0.15);
    --radius: 14px;
    --radius-sm: 8px;
    --radius-lg: 24px;
    --font-display: 'Syne', sans-serif;
    --font-body: 'DM Sans', sans-serif;
    --transition: 0.22s cubic-bezier(0.4,0,0.2,1);
  }
  [data-theme="dark"] {
    --bg: #111110;
    --bg2: #1a1a18;
    --surface: #212120;
    --surface2: #2a2a28;
    --border: #333330;
    --text: #f0ede7;
    --text2: #a0a09a;
    --text3: #666660;
    --accent: #ff6b35;
    --accent2: #e8400a;
    --accent-light: #2a1508;
    --green: #3aaa6a;
    --green-light: #0a2018;
    --blue: #4a9aff;
    --blue-light: #0a1828;
    --shadow: 0 2px 12px rgba(0,0,0,0.3);
    --shadow-md: 0 8px 32px rgba(0,0,0,0.4);
    --shadow-lg: 0 20px 60px rgba(0,0,0,0.5);
  }
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  html { scroll-behavior: smooth; font-size: 16px; }
  body {
    font-family: var(--font-body);
    background: var(--bg);
    color: var(--text);
    line-height: 1.6;
    transition: background var(--transition), color var(--transition);
    overflow-x: hidden;
  }
  a { color: inherit; text-decoration: none; }
  button { cursor: pointer; font-family: var(--font-body); border: none; outline: none; }
  input, select, textarea { font-family: var(--font-body); outline: none; }
  img { max-width: 100%; display: block; }

  /* SCROLLBAR */
  ::-webkit-scrollbar { width: 6px; }
  ::-webkit-scrollbar-track { background: var(--bg); }
  ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

  /* TYPOGRAPHY */
  h1,h2,h3,h4,h5 { font-family: var(--font-display); font-weight: 700; line-height: 1.15; }

  /* UTILITY */
  .container { max-width: 1280px; margin: 0 auto; padding: 0 24px; }
  .section { padding: 96px 0; }
  .section-sm { padding: 64px 0; }
  .tag {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 0.72rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase;
    color: var(--accent); background: var(--accent-light);
    padding: 4px 12px; border-radius: 100px;
  }
  .section-header { text-align: center; margin-bottom: 56px; }
  .section-header h2 { font-size: clamp(2rem, 4vw, 3rem); margin: 12px 0 16px; }
  .section-header p { color: var(--text2); font-size: 1.05rem; max-width: 560px; margin: 0 auto; }
  .btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 24px; border-radius: var(--radius-sm);
    font-weight: 600; font-size: 0.9rem; transition: all var(--transition);
    cursor: pointer; white-space: nowrap;
  }
  .btn-primary { background: var(--accent); color: #fff; position: relative; overflow: hidden; }
  .btn-primary::after { content: ''; position: absolute; top: 0; left: -100%; width: 50%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transform: skewX(-20deg); transition: 0s; }
  .btn-primary:hover::after { left: 150%; transition: left 0.8s ease; }
  .btn-primary:hover { background: var(--accent2); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(232,64,10,0.35); }
  .btn-outline { background: transparent; color: var(--text); border: 1.5px solid var(--border); }
  .btn-outline:hover { border-color: var(--accent); color: var(--accent); transform: translateY(-1px); }
  .btn-ghost { background: transparent; color: var(--text2); }
  .btn-ghost:hover { color: var(--accent); }
  .btn-sm { padding: 8px 16px; font-size: 0.82rem; }
  .btn-lg { padding: 16px 36px; font-size: 1rem; border-radius: var(--radius); }
  .badge { display: inline-block; padding: 2px 10px; border-radius: 100px; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.04em; }
  .badge-new { background: var(--green-light); color: var(--green); }
  .badge-like-new { background: var(--blue-light); color: var(--blue); }
  .badge-used { background: var(--surface2); color: var(--text2); }
  .badge-refurbished { background: #fdf3e0; color: #b8700a; }
  .badge-open-box { background: #f0e8f8; color: #6a30a0; }
  .badge-featured { background: var(--accent-light); color: var(--accent); }
  .badge-discount { background: var(--accent); color: #fff; }
  .card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); transition: all var(--transition); overflow: hidden; }
  .card:hover { box-shadow: var(--shadow-md); transform: translateY(-3px); }
  .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; }
  .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
  .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
  .grid-5 { display: grid; grid-template-columns: repeat(5, 1fr); gap: 16px; }
  .flex { display: flex; }
  .flex-col { flex-direction: column; }
  .items-center { align-items: center; }
  .justify-between { justify-content: space-between; }
  .gap-2 { gap: 8px; }
  .gap-3 { gap: 12px; }
  .gap-4 { gap: 16px; }

  /* MODAL BASE */
  .modal-overlay {
    position: fixed; inset: 0; z-index: 1000;
    background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);
    display: flex; align-items: center; justify-content: center; padding: 24px;
    opacity: 0; pointer-events: none; transition: opacity 0.25s;
  }
  .modal-overlay.active { opacity: 1; pointer-events: all; }
  .modal {
    background: var(--surface); border-radius: var(--radius-lg);
    width: 100%; max-width: 520px; max-height: 90vh; overflow-y: auto;
    padding: 40px; transform: translateY(20px); transition: transform 0.25s;
    border: 1px solid var(--border);
  }
  .modal-overlay.active .modal { transform: translateY(0); }
  .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; }
  .modal-header h3 { font-size: 1.5rem; }
  .modal-close {
    width: 36px; height: 36px; border-radius: 50%; background: var(--surface2);
    display: flex; align-items: center; justify-content: center;
    color: var(--text2); font-size: 1.2rem; cursor: pointer; border: none;
    transition: all var(--transition);
  }
  .modal-close:hover { background: var(--accent); color: #fff; }
  .form-group { margin-bottom: 20px; }
  .form-group label { display: block; font-weight: 500; font-size: 0.88rem; color: var(--text2); margin-bottom: 6px; }
  .form-control {
    width: 100%; padding: 11px 14px; border: 1.5px solid var(--border);
    border-radius: var(--radius-sm); background: var(--bg);
    color: var(--text); font-size: 0.92rem; transition: border-color var(--transition);
  }
  .form-control:focus { border-color: var(--accent); }
  select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23999' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 36px; }
  textarea.form-control { resize: vertical; min-height: 100px; }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
  .form-hint { font-size: 0.78rem; color: var(--text3); margin-top: 4px; }

  /* ============== HEADER ============== */
  #header {
    position: sticky; top: 0; z-index: 500;
    background: var(--bg); border-bottom: 1px solid var(--border);
    transition: all var(--transition);
  }
  #header.scrolled { box-shadow: var(--shadow-md); }
  .header-inner {
    display: flex; align-items: center; justify-content: space-between;
    gap: 16px; padding: 0 24px; height: 68px; max-width: 1280px; margin: 0 auto;
  }
  .logo { font-family: var(--font-display); font-weight: 800; font-size: 1.5rem; display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
  .logo-icon { width: 36px; height: 36px; background: var(--accent); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
  .logo span { color: var(--accent); }
  .header-search { flex: 1; max-width: 480px; position: relative; }
  .header-search input {
    width: 100%; padding: 10px 48px 10px 16px;
    background: var(--surface2); border: 1.5px solid var(--border);
    border-radius: var(--radius-sm); color: var(--text); font-size: 0.9rem;
    transition: all var(--transition);
  }
  .header-search input:focus { border-color: var(--accent); background: var(--surface); }
  .header-search input::placeholder { color: var(--text3); }
  .header-search-btn {
    position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
    background: none; border: none; color: var(--text2); cursor: pointer;
    display: flex; align-items: center; font-size: 1rem; transition: color var(--transition);
  }
  .header-search-btn:hover { color: var(--accent); }
  .header-actions { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }
  .icon-btn {
    width: 40px; height: 40px; border-radius: var(--radius-sm);
    background: var(--surface2); border: 1.5px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    color: var(--text2); font-size: 1.1rem; cursor: pointer;
    transition: all var(--transition); position: relative;
  }
  .icon-btn:hover { background: var(--accent); border-color: var(--accent); color: #fff; }
  .icon-btn .count {
    position: absolute; top: -4px; right: -4px; width: 18px; height: 18px;
    background: var(--accent); color: #fff; border-radius: 50%;
    font-size: 0.65rem; font-weight: 700; display: flex; align-items: center; justify-content: center;
  }
  .nav-links { display: flex; align-items: center; gap: 0; }
  .nav-links a {
    padding: 8px 14px; font-size: 0.88rem; font-weight: 500;
    color: var(--text2); border-radius: var(--radius-sm); transition: all var(--transition);
  }
  .nav-links a:hover, .nav-links a.active { color: var(--accent); background: var(--accent-light); }
  .theme-toggle {
    width: 40px; height: 40px; border-radius: var(--radius-sm);
    background: var(--surface2); border: 1.5px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    color: var(--text2); font-size: 1rem; cursor: pointer; transition: all var(--transition);
  }
  .theme-toggle:hover { background: var(--accent); border-color: var(--accent); color: #fff; }

  /* MOBILE NAV */
  .mobile-menu-btn {
    display: none; width: 40px; height: 40px; border-radius: var(--radius-sm);
    background: var(--surface2); border: 1.5px solid var(--border);
    align-items: center; justify-content: center; color: var(--text2);
    font-size: 1.2rem; cursor: pointer; transition: all var(--transition);
  }
  .mobile-nav {
    display: none; position: fixed; top: 68px; left: 0; right: 0; bottom: 0;
    background: var(--bg); z-index: 400; padding: 24px; overflow-y: auto;
    flex-direction: column; gap: 8px;
  }
  .mobile-nav.open { display: flex; }
  .mobile-nav a {
    padding: 14px 16px; border-radius: var(--radius-sm);
    font-weight: 500; font-size: 1rem; color: var(--text2);
    border: 1px solid var(--border); transition: all var(--transition);
  }
  .mobile-nav a:hover { color: var(--accent); border-color: var(--accent); }

  /* ============== ANNOUNCEMENT BAR ============== */
  .announce-bar {
    background: var(--accent); color: #fff; text-align: center;
    padding: 9px 24px; font-size: 0.82rem; font-weight: 500; letter-spacing: 0.02em;
  }
  .announce-bar a { text-decoration: underline; margin-left: 8px; }

  /* ============== HERO ============== */
  .hero { padding: 80px 0 64px; position: relative; overflow: hidden; }
  .hero::before {
    content: ''; position: absolute; top: -120px; right: -80px;
    width: 600px; height: 600px;
    background: radial-gradient(circle, var(--accent-light) 0%, transparent 70%);
    border-radius: 50%; pointer-events: none;
  }
  .hero-inner { display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: center; }
  .hero-content { position: relative; z-index: 1; }
  .hero-eyebrow {
    display: inline-flex; align-items: center; gap: 8px; margin-bottom: 20px;
    padding: 6px 16px; background: var(--surface); border: 1px solid var(--border);
    border-radius: 100px; font-size: 0.82rem; font-weight: 500; color: var(--text2);
  }
  .hero-eyebrow span { width: 6px; height: 6px; border-radius: 50%; background: var(--green); display: inline-block; animation: pulse 2s infinite; }
  @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)}50%{opacity:0.5;transform:scale(1.3)} }
  .hero h1 { font-size: clamp(2.8rem, 5.5vw, 4.5rem); margin-bottom: 20px; }
  .hero h1 em { font-style: normal; color: var(--accent); }
  .hero-sub { font-size: 1.1rem; color: var(--text2); margin-bottom: 36px; line-height: 1.7; max-width: 460px; }
  .hero-actions { display: flex; gap: 14px; flex-wrap: wrap; margin-bottom: 48px; }
  .hero-stats { display: flex; gap: 40px; }
  .hero-stat-num { font-family: var(--font-display); font-size: 1.8rem; font-weight: 800; line-height: 1; }
  .hero-stat-label { font-size: 0.82rem; color: var(--text2); margin-top: 3px; }
  .hero-visual { position: relative; }
  .hero-search-bar {
    background: var(--surface); border: 1.5px solid var(--border);
    border-radius: var(--radius-lg); padding: 8px; display: flex; gap: 8px;
    align-items: center; box-shadow: var(--shadow-md); margin-bottom: 24px;
  }
  .hero-search-bar select {
    padding: 10px 14px; background: var(--bg2); border: 1px solid var(--border);
    border-radius: var(--radius-sm); color: var(--text); font-size: 0.88rem; cursor: pointer;
  }
  .hero-search-bar input { flex: 1; padding: 10px 14px; background: transparent; border: none; color: var(--text); font-size: 0.95rem; }
  .hero-search-bar input::placeholder { color: var(--text3); }
  .hero-cards { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
  .hero-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--radius); padding: 18px; transition: all var(--transition); cursor: pointer;
  }
  .hero-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
  .hero-card-icon { font-size: 1.8rem; margin-bottom: 10px; }
  .hero-card-name { font-family: var(--font-display); font-weight: 700; font-size: 0.95rem; margin-bottom: 4px; }
  .hero-card-price { color: var(--accent); font-weight: 700; font-size: 1.05rem; }
  .hero-card-condition { font-size: 0.75rem; color: var(--text2); }

  /* ============== CATEGORY GRID ============== */
  .categories-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 16px; }
  .category-card {
    background: var(--surface); border: 1.5px solid var(--border);
    border-radius: var(--radius-lg); padding: 28px 20px; text-align: center;
    cursor: pointer; transition: all var(--transition); position: relative; overflow: hidden;
  }
  .category-card::before { content: ''; position: absolute; inset: 0; background: var(--accent); opacity: 0; transition: opacity var(--transition); }
  .category-card:hover::before { opacity: 0.05; }
  .category-card:hover { border-color: var(--accent); transform: translateY(-4px); box-shadow: var(--shadow-md); }
  .category-card:hover .category-icon { transform: scale(1.1); }
  .category-icon { font-size: 2.5rem; margin-bottom: 14px; transition: transform var(--transition); display: block; }
  .category-name { font-family: var(--font-display); font-weight: 700; font-size: 0.95rem; margin-bottom: 4px; }
  .category-count { font-size: 0.78rem; color: var(--text3); }

  /* ============== FILTERS + PRODUCTS ============== */
  .marketplace-layout { display: grid; grid-template-columns: 260px 1fr; gap: 32px; }
  .filters-panel {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--radius-lg); padding: 24px; height: fit-content; position: sticky; top: 90px;
  }
  .filter-section { margin-bottom: 28px; }
  .filter-section:last-child { margin-bottom: 0; }
  .filter-title { font-family: var(--font-display); font-weight: 700; font-size: 0.9rem; margin-bottom: 14px; color: var(--text); display: flex; justify-content: space-between; align-items: center; cursor: pointer; }
  .filter-title span { color: var(--text3); font-size: 0.75rem; font-family: var(--font-body); font-weight: 400; }
  .filter-option { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; cursor: pointer; }
  .filter-option input[type="checkbox"] { width: 16px; height: 16px; accent-color: var(--accent); cursor: pointer; }
  .filter-option label { font-size: 0.88rem; color: var(--text2); cursor: pointer; flex: 1; }
  .filter-option .filter-count { font-size: 0.75rem; color: var(--text3); }
  .price-range { display: flex; gap: 10px; width: 100%; }
  .price-input { flex: 1; min-width: 0; padding: 8px 12px; background: var(--bg); border: 1.5px solid var(--border); border-radius: var(--radius-sm); color: var(--text); font-size: 0.85rem; }
  .price-input:focus { border-color: var(--accent); }
  .filter-divider { height: 1px; background: var(--border); margin: 20px 0; }
  .products-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; gap: 16px; flex-wrap: wrap; }
  .products-count { font-size: 0.9rem; color: var(--text2); }
  .products-header-right { display: flex; align-items: center; gap: 12px; }
  .sort-select {
    padding: 8px 32px 8px 12px; background: var(--surface); border: 1.5px solid var(--border);
    border-radius: var(--radius-sm); color: var(--text); font-size: 0.88rem; cursor: pointer;
    appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23999' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 10px center;
  }
  .view-toggle { display: flex; gap: 4px; }
  .view-btn {
    width: 36px; height: 36px; border-radius: var(--radius-sm); border: 1.5px solid var(--border);
    background: var(--surface); color: var(--text2); display: flex; align-items: center;
    justify-content: center; cursor: pointer; transition: all var(--transition);
  }
  .view-btn.active { background: var(--accent); border-color: var(--accent); color: #fff; }
  .products-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
  .products-grid.list-view { grid-template-columns: 1fr; }
  .product-card {
    background: var(--surface); border-radius: var(--radius);
    border: 1px solid var(--border); overflow: hidden;
    transition: all var(--transition); position: relative;
  }
  .product-card:hover { box-shadow: var(--shadow-md); transform: translateY(-3px); }
  .product-card:hover .product-wishlist { opacity: 1; }
  .product-image { aspect-ratio: 4/3; background: var(--surface2); display: flex; align-items: center; justify-content: center; font-size: 4rem; position: relative; overflow: hidden; }
  .product-image-placeholder { font-size: 3.5rem; color: var(--text3); transition: transform var(--transition); }
  .product-card:hover .product-image-placeholder { transform: scale(1.05); }
  .product-featured-badge { position: absolute; top: 10px; left: 10px; z-index: 1; }
  .product-discount-badge { position: absolute; top: 10px; right: 52px; z-index: 1; }
  .product-wishlist {
    position: absolute; top: 10px; right: 10px; z-index: 1;
    width: 34px; height: 34px; border-radius: 50%; background: var(--surface);
    border: 1px solid var(--border); display: flex; align-items: center; justify-content: center;
    cursor: pointer; opacity: 0; transition: all var(--transition); color: var(--text2); font-size: 1rem;
  }
  .product-wishlist:hover, .product-wishlist.active { background: #fee; border-color: #f88; color: #e44; }
  .product-wishlist.active { opacity: 1; }
  .product-body { padding: 16px; }
  .product-condition { margin-bottom: 8px; }
  .product-name { font-family: var(--font-display); font-weight: 700; font-size: 0.95rem; margin-bottom: 4px; line-height: 1.3; }
  .product-brand { font-size: 0.8rem; color: var(--text3); margin-bottom: 10px; }
  .product-price-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
  .product-price { font-family: var(--font-display); font-size: 1.25rem; font-weight: 800; color: var(--accent); }
  .product-original-price { font-size: 0.82rem; color: var(--text3); text-decoration: line-through; margin-left: 6px; }
  .product-location { font-size: 0.78rem; color: var(--text2); display: flex; align-items: center; gap: 4px; margin-bottom: 12px; }
  .product-actions { display: flex; gap: 8px; }
  .product-actions .btn { flex: 1; justify-content: center; font-size: 0.82rem; padding: 9px 14px; }
  /* LIST VIEW */
  .products-grid.list-view .product-card { display: flex; flex-direction: row; }
  .products-grid.list-view .product-image { width: 180px; flex-shrink: 0; aspect-ratio: unset; }
  .products-grid.list-view .product-body { flex: 1; display: flex; flex-direction: column; justify-content: space-between; }
  .pagination { display: flex; justify-content: center; gap: 8px; margin-top: 40px; }
  .page-btn {
    width: 40px; height: 40px; border-radius: var(--radius-sm); border: 1.5px solid var(--border);
    background: var(--surface); color: var(--text2); display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-weight: 600; transition: all var(--transition);
  }
  .page-btn.active { background: var(--accent); border-color: var(--accent); color: #fff; }
  .page-btn:hover:not(.active) { border-color: var(--accent); color: var(--accent); }

  /* ============== BRANDS ============== */
  .brands-wrapper { 
    width: 100%;
    overflow-x: auto;
    overflow-y: hidden;
    -ms-overflow-style: none;
    scrollbar-width: none;
    margin: 0;
    padding-left: 24px;
    padding-right: 24px;
  }
  .brands-wrapper::-webkit-scrollbar { display: none; }
  .brands-track { 
    display: flex; 
    gap: 20px; 
    padding-bottom: 8px;
    padding-top: 0;
    width: max-content;
    animation: scrollLeft 30s linear infinite;
  }
  .brands-track:hover { animation-play-state: paused; }
  @keyframes scrollLeft { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
  .brand-chip {
    flex-shrink: 0;
    min-width: fit-content;
    padding: 14px 28px; 
    background: var(--surface);
    border: 1.5px solid var(--border); 
    border-radius: var(--radius);
    font-family: var(--font-display); 
    font-weight: 700; 
    font-size: 1rem;
    cursor: pointer; 
    transition: all var(--transition); 
    white-space: nowrap;
  }
  .brand-chip:hover { border-color: var(--accent); color: var(--accent); transform: translateY(-2px); box-shadow: var(--shadow); }

  /* ============== SELL CTA ============== */
  .sell-cta { background: var(--text); color: var(--bg); border-radius: var(--radius-lg); padding: 80px 64px; position: relative; overflow: hidden; }
  [data-theme="dark"] .sell-cta { background: var(--surface); color: var(--text); border: 1px solid var(--border); }
  .sell-cta::before { content: ''; position: absolute; top: -100px; right: -60px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(232,64,10,0.3) 0%, transparent 70%); border-radius: 50%; pointer-events: none; }
  .sell-cta-inner { display: grid; grid-template-columns: 1fr auto; gap: 40px; align-items: center; position: relative; z-index: 1; }
  .sell-cta h2 { font-size: clamp(2rem, 3.5vw, 2.8rem); margin-bottom: 12px; }
  .sell-cta p { opacity: 0.7; font-size: 1rem; max-width: 480px; }
  .sell-cta .btn-primary { background: var(--accent); }
  .sell-steps { display: flex; gap: 40px; margin-top: 36px; }
  .sell-step { display: flex; align-items: flex-start; gap: 14px; }
  .sell-step-num { width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-family: var(--font-display); font-weight: 800; font-size: 0.9rem; flex-shrink: 0; }
  [data-theme="dark"] .sell-step-num { background: var(--bg2); }
  .sell-step-text { font-size: 0.88rem; opacity: 0.85; }
  .sell-step-title { font-weight: 600; margin-bottom: 3px; opacity: 1; }

  /* ============== HOW IT WORKS ============== */
  .hiw-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; }
  .hiw-card { background: var(--surface); border: 1.5px solid var(--border); border-radius: var(--radius-lg); padding: 36px; text-align: center; transition: all var(--transition); position: relative; }
  .hiw-card:hover { border-color: var(--accent); transform: translateY(-4px); box-shadow: var(--shadow-md); }
  .hiw-number { width: 56px; height: 56px; border-radius: 50%; background: var(--accent-light); color: var(--accent); display: flex; align-items: center; justify-content: center; font-family: var(--font-display); font-weight: 800; font-size: 1.3rem; margin: 0 auto 20px; transition: all var(--transition); }
  .hiw-card:hover .hiw-number { background: var(--accent); color: #fff; }
  .hiw-icon { font-size: 2rem; margin-bottom: 12px; }
  .hiw-card h3 { font-size: 1.15rem; margin-bottom: 10px; }
  .hiw-card p { color: var(--text2); font-size: 0.9rem; line-height: 1.7; }

  /* ============== TESTIMONIALS ============== */
  .testimonials-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
  .testimonial-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 28px; }
  .testimonial-stars { color: #f5a623; font-size: 0.9rem; margin-bottom: 14px; letter-spacing: 2px; }
  .testimonial-text { color: var(--text2); font-size: 0.92rem; line-height: 1.7; margin-bottom: 20px; font-style: italic; }
  .testimonial-author { display: flex; align-items: center; gap: 12px; }
  .testimonial-avatar { width: 44px; height: 44px; border-radius: 50%; background: var(--accent); display: flex; align-items: center; justify-content: center; font-family: var(--font-display); font-weight: 700; color: #fff; }
  .testimonial-name { font-weight: 600; font-size: 0.9rem; }
  .testimonial-role { font-size: 0.78rem; color: var(--text3); }

  /* ============== FAQ ============== */
  .faq-list { max-width: 760px; margin: 0 auto; }
  .faq-item { border: 1.5px solid var(--border); border-radius: var(--radius); margin-bottom: 12px; overflow: hidden; transition: border-color var(--transition); }
  .faq-item.open { border-color: var(--accent); }
  .faq-question { display: flex; align-items: center; justify-content: space-between; padding: 20px 24px; cursor: pointer; font-weight: 600; font-size: 0.95rem; background: var(--surface); gap: 16px; }
  .faq-question:hover { color: var(--accent); }
  .faq-icon { width: 28px; height: 28px; border-radius: 50%; background: var(--surface2); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; transition: all var(--transition); color: var(--text2); }
  .faq-item.open .faq-icon { background: var(--accent); color: #fff; transform: rotate(45deg); }
  .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.35s ease, padding 0.2s; background: var(--surface); padding: 0 24px; color: var(--text2); font-size: 0.9rem; line-height: 1.7; }
  .faq-answer.open { max-height: 200px; padding: 0 24px 20px; }

  /* ============== BLOG ============== */
  .blog-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
  .blog-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; cursor: pointer; transition: all var(--transition); }
  .blog-card:hover { box-shadow: var(--shadow-md); transform: translateY(-3px); }
  .blog-image { height: 180px; background: var(--surface2); display: flex; align-items: center; justify-content: center; font-size: 3rem; }
  .blog-body { padding: 24px; }
  .blog-cat { font-size: 0.72rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--accent); margin-bottom: 10px; }
  .blog-card h3 { font-size: 1.05rem; margin-bottom: 8px; line-height: 1.4; }
  .blog-card p { color: var(--text2); font-size: 0.85rem; line-height: 1.6; margin-bottom: 16px; }
  .blog-meta { font-size: 0.78rem; color: var(--text3); display: flex; gap: 14px; }

  /* ============== NEWSLETTER ============== */
  .newsletter { background: var(--surface); border: 1.5px solid var(--border); border-radius: var(--radius-lg); padding: 64px; text-align: center; position: relative; overflow: hidden; }
  .newsletter::before { content: ''; position: absolute; width: 300px; height: 300px; border-radius: 50%; background: radial-gradient(circle, var(--accent-light) 0%, transparent 70%); top: -100px; left: -100px; pointer-events: none; }
  .newsletter h2 { font-size: clamp(1.8rem, 3vw, 2.5rem); margin-bottom: 12px; position: relative; }
  .newsletter p { color: var(--text2); margin-bottom: 32px; max-width: 420px; margin-left: auto; margin-right: auto; position: relative; }
  .newsletter-form { display: flex; gap: 12px; max-width: 460px; margin: 0 auto; position: relative; }
  .newsletter-form input { flex: 1; padding: 14px 18px; background: var(--bg); border: 1.5px solid var(--border); border-radius: var(--radius-sm); color: var(--text); font-size: 0.95rem; transition: border-color var(--transition); }
  .newsletter-form input:focus { border-color: var(--accent); }
  .newsletter-form input::placeholder { color: var(--text3); }

  /* ============== FOOTER ============== */
  footer { background: var(--text); color: var(--bg); padding: 64px 0 32px; }
  [data-theme="dark"] footer { background: var(--surface); color: var(--text); border-top: 1px solid var(--border); }
  .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 48px; margin-bottom: 48px; }
  .footer-brand .logo { color: var(--bg); margin-bottom: 16px; }
  [data-theme="dark"] .footer-brand .logo { color: var(--text); }
  .footer-desc { opacity: 0.6; font-size: 0.88rem; line-height: 1.7; max-width: 280px; margin-bottom: 24px; }
  .footer-social { display: flex; gap: 10px; }
  .social-btn { width: 38px; height: 38px; border-radius: var(--radius-sm); background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; color: inherit; font-size: 0.95rem; cursor: pointer; transition: all var(--transition); border: 1px solid rgba(255,255,255,0.15); }
  [data-theme="dark"] .social-btn { background: var(--surface2); border-color: var(--border); }
  .social-btn:hover { background: var(--accent); border-color: var(--accent); }
  .footer-col h4 { font-family: var(--font-display); font-weight: 700; font-size: 0.9rem; margin-bottom: 18px; }
  .footer-links { list-style: none; }
  .footer-links li { margin-bottom: 10px; }
  .footer-links a { opacity: 0.6; font-size: 0.88rem; transition: opacity var(--transition); }
  .footer-links a:hover { opacity: 1; color: var(--accent); }
  .footer-bottom { border-top: 1px solid rgba(255,255,255,0.12); padding-top: 28px; display: flex; justify-content: space-between; align-items: center; font-size: 0.82rem; opacity: 0.5; flex-wrap: wrap; gap: 12px; }
  [data-theme="dark"] .footer-bottom { border-color: var(--border); }

  /* ============== PRODUCT DETAIL MODAL ============== */
  .product-modal .modal { max-width: 820px; padding: 0; }
  .product-modal-grid { display: grid; grid-template-columns: 1fr 1fr; }
  .product-modal-image { background: var(--surface2); border-radius: var(--radius-lg) 0 0 var(--radius-lg); display: flex; align-items: center; justify-content: center; font-size: 6rem; min-height: 360px; }
  .product-modal-body { padding: 36px; overflow-y: auto; max-height: 90vh; }
  .spec-table { width: 100%; border-collapse: collapse; margin: 16px 0; }
  .spec-table tr { border-bottom: 1px solid var(--border); }
  .spec-table tr:last-child { border-bottom: none; }
  .spec-table td { padding: 8px 0; font-size: 0.85rem; }
  .spec-table td:first-child { color: var(--text2); width: 40%; }
  .seller-info { background: var(--surface2); border-radius: var(--radius-sm); padding: 14px; margin: 16px 0; }
  .seller-info-row { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
  .seller-avatar { width: 38px; height: 38px; border-radius: 50%; background: var(--accent); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 0.9rem; }
  .seller-name { font-weight: 600; font-size: 0.88rem; }
  .seller-rating { font-size: 0.78rem; color: var(--text2); }
  .report-link { font-size: 0.78rem; color: var(--text3); cursor: pointer; text-decoration: underline; }
  .report-link:hover { color: var(--accent); }
  .product-modal-actions { display: flex; flex-direction: column; gap: 10px; margin-top: 20px; }
  .whatsapp-btn { display: flex; align-items: center; justify-content: center; gap: 10px; padding: 12px 24px; background: #25d366; color: #fff; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer; transition: all var(--transition); border: none; font-family: var(--font-body); }
  .whatsapp-btn:hover { background: #20b858; transform: translateY(-1px); }

  /* ============== WISHLIST / CART PANEL ============== */
  .side-panel { position: fixed; right: 0; top: 0; bottom: 0; width: 420px; z-index: 600; background: var(--surface); border-left: 1px solid var(--border); transform: translateX(100%); transition: transform 0.3s cubic-bezier(0.4,0,0.2,1); display: flex; flex-direction: column; }
  .side-panel.open { transform: translateX(0); box-shadow: var(--shadow-lg); }
  .side-panel-header { padding: 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
  .side-panel-header h3 { font-size: 1.2rem; }
  .side-panel-body { flex: 1; overflow-y: auto; padding: 20px; }
  .side-panel-footer { padding: 20px; border-top: 1px solid var(--border); }
  .wishlist-item { display: flex; gap: 14px; align-items: flex-start; padding: 14px 0; border-bottom: 1px solid var(--border); }
  .wishlist-item:last-child { border-bottom: none; }
  .wishlist-thumb { width: 64px; height: 64px; border-radius: var(--radius-sm); background: var(--surface2); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; flex-shrink: 0; }
  .wishlist-item-body { flex: 1; }
  .wishlist-item-name { font-weight: 600; font-size: 0.88rem; margin-bottom: 4px; }
  .wishlist-item-price { color: var(--accent); font-weight: 700; font-size: 0.95rem; }
  .wishlist-remove { color: var(--text3); cursor: pointer; font-size: 1.1rem; transition: color var(--transition); padding: 4px; }
  .wishlist-remove:hover { color: var(--accent); }
  .cart-item { display: flex; gap: 14px; align-items: flex-start; padding: 14px 0; border-bottom: 1px solid var(--border); }
  .cart-item:last-child { border-bottom: none; }
  .cart-thumb { width: 64px; height: 64px; border-radius: var(--radius-sm); background: var(--surface2); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; flex-shrink: 0; }
  .cart-item-body { flex: 1; }
  .cart-item-name { font-weight: 600; font-size: 0.88rem; margin-bottom: 4px; }
  .cart-item-price { color: var(--accent); font-weight: 700; }
  .cart-total { display: flex; justify-content: space-between; font-weight: 700; margin-bottom: 16px; font-size: 1.05rem; }
  .empty-state { text-align: center; padding: 40px 20px; color: var(--text2); }
  .empty-icon { font-size: 3rem; margin-bottom: 14px; }
  .empty-state h4 { margin-bottom: 8px; }
  .empty-state p { font-size: 0.88rem; }

  /* ============== SELL MODAL ============== */
  .sell-modal .modal { max-width: 680px; }

  /* ============== TOAST ============== */
  .toast-container { position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; }
  .toast { background: var(--surface); border: 1.5px solid var(--border); border-radius: var(--radius); padding: 16px 20px; min-width: 280px; max-width: 360px; box-shadow: var(--shadow-md); display: flex; align-items: center; gap: 12px; animation: slideInRight 0.3s ease; position: relative; }
  .toast-success { border-left: 4px solid var(--green); }
  .toast-error { border-left: 4px solid #e44; }
  .toast-info { border-left: 4px solid var(--blue); }
  @keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
  .toast-icon { font-size: 1.2rem; flex-shrink: 0; }
  .toast-text { flex: 1; font-size: 0.88rem; }
  .toast-title { font-weight: 600; margin-bottom: 2px; }
  .toast-desc { color: var(--text2); font-size: 0.82rem; }
  .toast-close { color: var(--text3); cursor: pointer; font-size: 1rem; flex-shrink: 0; padding: 2px; transition: color var(--transition); }
  .toast-close:hover { color: var(--text); }

  /* ============== OVERLAY BACKDROP ============== */
  .panel-backdrop { position: fixed; inset: 0; z-index: 590; background: rgba(0,0,0,0.4); opacity: 0; pointer-events: none; transition: opacity 0.3s; }
  .panel-backdrop.active { opacity: 1; pointer-events: all; }

  /* ============== ANIMATIONS ============== */
  @keyframes fadeInUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
  .fade-in { animation: fadeInUp 0.6s ease both; }
  .fade-in-1 { animation-delay: 0.1s; }
  .fade-in-2 { animation-delay: 0.2s; }
  .fade-in-3 { animation-delay: 0.3s; }
  
  .scroll-reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.6s ease, transform 0.6s ease; }
  .scroll-reveal.visible { opacity: 1; transform: translateY(0); }
  
  @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-15px); } }
  .floating { animation: float 5s ease-in-out infinite; }
  .floating-delayed { animation: float 6s ease-in-out infinite reverse; }

  /* ============== RESPONSIVE ============== */
  @media (max-width: 1100px) {
    .marketplace-layout { grid-template-columns: 220px 1fr; }
    .products-grid { grid-template-columns: repeat(2, 1fr); }
    .footer-grid { grid-template-columns: 1fr 1fr; gap: 32px; }
  }
  @media (max-width: 900px) {
    .hero-inner, .product-modal-grid { grid-template-columns: 1fr; }
    .hero-visual { display: none; }
    .categories-grid { grid-template-columns: repeat(3, 1fr); }
    .hiw-grid, .testimonials-grid, .blog-grid { grid-template-columns: 1fr 1fr; }
    .sell-cta-inner { grid-template-columns: 1fr; }
    .sell-steps { flex-direction: column; gap: 20px; }
    .nav-links, .header-search { display: none; }
    .mobile-menu-btn { display: flex; }
    .marketplace-layout { grid-template-columns: 1fr; }
    .filters-panel { position: static; }
  }
  @media (max-width: 640px) {
    .categories-grid { grid-template-columns: repeat(2, 1fr); }
    .hiw-grid, .testimonials-grid, .blog-grid { grid-template-columns: 1fr; }
    .footer-grid { grid-template-columns: 1fr; }
    .hero-actions { flex-direction: column; }
    .hero-stats { gap: 24px; }
    .sell-cta { padding: 40px 24px; }
    .newsletter { padding: 40px 24px; }
    .newsletter-form { flex-direction: column; }
    .side-panel { width: 100%; }
    .products-grid { grid-template-columns: 1fr; }
  }

.orders-table {
    width: 100%;
    border-collapse: collapse;
}

.orders-table th {
    background: var(--accent);
    color: #fff;
    padding: 12px;
}

.orders-table td {
    padding: 12px;
    border-bottom: 1px solid var(--border);
    text-align: center;
}

.orders-table tr:hover {
    background: var(--surface2);
}
</style>