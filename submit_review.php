<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    die("Niet ingelogd");
}

require_once "classes/Database.php";
require_once "classes/Review.php";

$db = new Database();
$reviewObj = new Review($db->pdo);

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'] ?? null;
$rating = $_POST['rating'] ?? null;
$comment = $_POST['comment'] ?? '';

if (!$product_id || !$rating || !$comment) {
    die("Ongeldige input");
}

if (!$reviewObj->canReview($user_id, $product_id)) {
    die("Je kan alleen reviews plaatsen voor gekochte producten");
}

$reviewObj->add($user_id, $product_id, $rating, $comment);

echo "ok";
?>
