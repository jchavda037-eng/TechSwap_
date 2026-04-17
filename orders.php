<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['user_id'])) {
    header('Location: login.php?redirect=orders.php');
    exit();
}

$pageTitle = 'My Orders — TechSwap';
$activePage = 'orders';
include '_header.php';
?>

<section class="section" style="padding-top: 56px; background: var(--bg2); min-height: 70vh;">
  <div class="container" style="max-width: 1100px;">
    <div class="section-header">
      <div class="tag">Orders</div>
      <h2>Track Your Orders</h2>
      <p>View your latest purchases, statuses, payment state, and delivery progress.</p>
    </div>

    <div id="ordersPageContainer" style="display:grid; gap:20px; margin-top:32px;"></div>
  </div>
</section>

<script>
function getOrderBadge(status) {
  const map = {
    Delivered: 'badge-new',
    Shipped: 'badge-like-new',
    'Out for Delivery': 'badge-like-new',
    Packed: 'badge-open-box',
    Placed: 'badge-used',
    Cancelled: 'badge-discount'
  };
  return map[status] || 'badge-used';
}

function loadOrdersPage() {
  const container = document.getElementById('ordersPageContainer');
  container.innerHTML = `
    <div style="text-align:center; padding:56px 20px; background:var(--surface); border:1.5px solid var(--border); border-radius:var(--radius);">
      <div style="font-size:2rem; margin-bottom:12px;">⏳</div>
      <p>Loading your orders...</p>
    </div>`;

  fetch('user_orders_api.php')
    .then(res => res.json())
    .then(json => {
      if (json.status !== 'success') {
        throw new Error(json.message || 'Could not load orders.');
      }

      const orders = json.data || [];
      if (!orders.length) {
        container.innerHTML = `
          <div style="text-align:center; padding:64px 20px; background:var(--surface); border:1.5px solid var(--border); border-radius:var(--radius);">
            <div style="font-size:2.5rem; margin-bottom:12px;">📦</div>
            <h3 style="margin-bottom:8px;">No orders yet</h3>
            <p style="color:var(--text2); margin-bottom:20px;">Browse the marketplace and place your first order.</p>
            <a href="browse.php" class="btn btn-primary">Browse Listings</a>
          </div>`;
        return;
      }

      container.innerHTML = orders.map(order => `
        <article style="background:var(--surface); border:1.5px solid var(--border); border-radius:var(--radius); padding:24px;">
          <div style="display:grid; grid-template-columns:1fr auto; gap:20px; margin-bottom:20px;">
            <div>
              <div style="font-size:0.82rem; color:var(--text3); margin-bottom:4px;">Order ID</div>
              <h3 style="font-size:1.1rem; font-weight:800; margin-bottom:6px;">${order.display_order_id || order.order_id}</h3>
              <p style="color:var(--text2);">${order.product_name}${order.product_brand ? ` · ${order.product_brand}` : ''}</p>
            </div>
            <div style="text-align:right;">
              <div style="font-size:1.6rem; font-weight:800; color:var(--accent); margin-bottom:8px;">$${Number(order.total_price || 0).toFixed(2)}</div>
              <span class="badge ${getOrderBadge(order.order_status)}">${order.order_status}</span>
            </div>
          </div>

          <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:16px; background:var(--bg); border-radius:var(--radius-sm); padding:16px; margin-bottom:16px;">
            <div>
              <div style="font-size:0.8rem; color:var(--text3); margin-bottom:4px;">Ordered</div>
              <div>${new Date(order.order_date).toLocaleDateString()}</div>
            </div>
            <div>
              <div style="font-size:0.8rem; color:var(--text3); margin-bottom:4px;">Payment</div>
              <div>${order.payment_status}</div>
            </div>
            <div>
              <div style="font-size:0.8rem; color:var(--text3); margin-bottom:4px;">Shipping Date</div>
              <div>${order.shipping_date ? new Date(order.shipping_date).toLocaleDateString() : 'Not shipped yet'}</div>
            </div>
            <div>
              <div style="font-size:0.8rem; color:var(--text3); margin-bottom:4px;">Delivery Date</div>
              <div>${order.delivery_date ? new Date(order.delivery_date).toLocaleDateString() : 'Pending'}</div>
            </div>
          </div>

          ${order.order_status !== 'Cancelled' && order.order_status !== 'Delivered' ? `
            <button class="btn btn-ghost btn-sm" onclick="cancelOrdersPageOrder('${order.order_id}')">Cancel Order</button>
          ` : ''}
        </article>
      `).join('');
    })
    .catch(err => {
      container.innerHTML = `
        <div style="text-align:center; padding:56px 20px; background:var(--surface); border:1.5px solid var(--border); border-radius:var(--radius);">
          <div style="font-size:2rem; margin-bottom:12px;">⚠️</div>
          <p style="margin-bottom:18px;">${err.message}</p>
          <button class="btn btn-primary" onclick="loadOrdersPage()">Try Again</button>
        </div>`;
    });
}

function cancelOrdersPageOrder(orderId) {
  if (!confirm('Cancel this order?')) return;

  fetch('user_orders_api.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ action: 'cancel', order_id: Number(orderId) })
  })
    .then(res => res.json())
    .then(json => {
      if (json.status === 'success') {
        showToast('Order cancelled successfully.', 'success', 'Cancelled');
        loadOrdersPage();
      } else {
        showToast(json.message || 'Could not cancel this order.', 'error', 'Error');
      }
    })
    .catch(() => showToast('Could not cancel this order.', 'error', 'Error'));
}

document.addEventListener('DOMContentLoaded', loadOrdersPage);
</script>

<?php include '_footer.php'; ?>
