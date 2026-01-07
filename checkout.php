<?php
session_start();
require_once "classes/Database.php";
require_once "classes/User.php";

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

$db = new Database();
$pdo = $db->pdo;

$userObj = new User($pdo);
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

$userObj->id = $userData['id'];
$userObj->email = $userData['email'];
$userObj->role = $userData['role'];
$userObj->balance = $userData['balance'];

if (empty($_SESSION['cart'])) {
    die("Je winkelmandje is leeg.");
}

$placeholders = implode(',', array_fill(0, count($_SESSION['cart']), '?'));
$stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
$stmt->execute(array_keys($_SESSION['cart']));
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach ($products as $product) {
    $qty = $_SESSION['cart'][$product['id']];
    $total += $product['price'] * $qty;
}

if ($userObj->balance < $total) {
    die("Niet genoeg units. Huidige balans: {$userObj->balance} units, totaal: $total");
}

$userObj->updateBalance($userObj->balance - $total);

require_once "classes/Order.php";
$orderObj = new Order($pdo);

$cartProducts = [];
foreach ($products as $product) {
    $product['quantity'] = $_SESSION['cart'][$product['id']];
    $cartProducts[] = $product;
}

$total = $orderObj->create($userObj->id, $cartProducts);


$_SESSION['cart'] = [];

echo "Aankoop voltooid! Nieuwe balans: {$userObj->balance} units.";
?>
