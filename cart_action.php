<?php
// cart_action.php — Session-backed cart API
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');
 
// Must be logged in
if (empty($_SESSION['user_id'])) {
  echo json_encode(['success'=>false, 'error'=>'not_logged_in', 'count'=>0, 'items'=>[]]);
  exit;
}
 
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
 
$action     = $_POST['action']     ?? 'get';
$product_id = $_POST['product_id'] ?? null;
 
switch ($action) {
 
  case 'add':
    if (!$product_id) break;
    $_SESSION['cart'][$product_id] = [
      'id'    => $product_id,
      'name'  => htmlspecialchars($_POST['name']  ?? 'Product'),
      'price' => (float)($_POST['price'] ?? 0),
      'icon'  => htmlspecialchars($_POST['icon']  ?? '📦'),
    ];
    echo json_encode(['success'=>true, 'count'=>count($_SESSION['cart'])]);
    exit;
 
  case 'remove':
    unset($_SESSION['cart'][$product_id]);
    echo json_encode(['success'=>true, 'count'=>count($_SESSION['cart'])]);
    exit;
 
  case 'clear':
    $_SESSION['cart'] = [];
    echo json_encode(['success'=>true, 'count'=>0]);
    exit;
 
  case 'get':
  default:
    echo json_encode([
      'success' => true,
      'count'   => count($_SESSION['cart']),
      'items'   => array_values($_SESSION['cart']),
    ]);
    exit;
}
 
echo json_encode(['success'=>false, 'count'=>count($_SESSION['cart']), 'items'=>array_values($_SESSION['cart'])]);