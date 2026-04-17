<?php
// wishlist_action.php — Session-backed wishlist API
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');

// Must be logged in
if (empty($_SESSION['user_id'])) {
  echo json_encode(['success'=>false, 'error'=>'not_logged_in', 'count'=>0, 'items'=>[]]);
  exit;
}

if (!isset($_SESSION['wishlist'])) $_SESSION['wishlist'] = [];

$action     = $_POST['action']     ?? 'get';
$product_id = $_POST['product_id'] ?? null;

switch ($action) {

  case 'toggle':
    if (!$product_id) break;
    if (isset($_SESSION['wishlist'][$product_id])) {
      unset($_SESSION['wishlist'][$product_id]);
      $inWishlist = false;
    } else {
      $_SESSION['wishlist'][$product_id] = [
        'id'    => $product_id,
        'name'  => htmlspecialchars($_POST['name']  ?? 'Product'),
        'price' => (float)($_POST['price'] ?? 0),
        'icon'  => htmlspecialchars($_POST['icon']  ?? '📦'),
      ];
      $inWishlist = true;
    }
    echo json_encode(['success'=>true, 'inWishlist'=>$inWishlist, 'count'=>count($_SESSION['wishlist'])]);
    exit;

  case 'remove':
    unset($_SESSION['wishlist'][$product_id]);
    echo json_encode(['success'=>true, 'count'=>count($_SESSION['wishlist'])]);
    exit;

  case 'get':
  default:
    echo json_encode([
      'success' => true,
      'count'   => count($_SESSION['wishlist']),
      'items'   => array_values($_SESSION['wishlist']),
    ]);
    exit;
}

echo json_encode(['success'=>false, 'count'=>count($_SESSION['wishlist']), 'items'=>array_values($_SESSION['wishlist'])]);