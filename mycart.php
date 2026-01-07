<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

require_once "classes/Product.php";
require_once "classes/Database.php";

$db = new Database();
$productObj = new Product($db->pdo);

$cartItems = $_SESSION['cart'] ?? [];
$products = $cartItems ? $productObj->getByIds(array_keys($cartItems)) : [];

$total = 0;
foreach ($products as $product) {
    $qty = $cartItems[$product['id']];
    $total += $product['price'] * $qty;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove'])) {
        $removeId = (int)$_POST['remove'];
        unset($_SESSION['cart'][$removeId]);
    }

    if (isset($_POST['product_id'])) {
        $productId = (int)$_POST['product_id'];
        if (!isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] = 1;
        } else {
            $_SESSION['cart'][$productId]++;
        }
    }

    $cartItems = $_SESSION['cart'] ?? [];
    $products = $cartItems ? $productObj->getByIds(array_keys($cartItems)) : [];
    $total = 0;
    foreach ($products as $product) {
        $qty = $cartItems[$product['id']];
        $total += $product['price'] * $qty;
    }
}
?>
