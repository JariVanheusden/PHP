<?php
session_start();
require_once "classes/Database.php";
require_once "classes/User.php";

$db = new Database();
$pdo = $db->pdo;

if (!isset($_GET['product_id'])) {
    die("Geen product geselecteerd");
}

$product_id = (int)$_GET['product_id'];

$stmt = $pdo->prepare("
    SELECT r.*, u.email 
    FROM reviews r 
    JOIN users u ON r.user_id = u.id 
    WHERE product_id = :product_id 
    ORDER BY created_at DESC
");
$stmt->execute(['product_id' => $product_id]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($reviews as $review) {
    echo "<p><strong>".htmlspecialchars($review['email'])."</strong> ({$review['rating']}/5): ".htmlspecialchars($review['comment'])."</p>";
}
