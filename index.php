<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$host = "localhost";
$dbname = "f1_shop";
$user = "root";
$pass = "";

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>F1 Shop - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include("nav.inc.php"); ?>

<header class="hero">
    <div class="hero-content">
        <h1>Official F1 Merchandise</h1>
        <p>Ontdek de nieuwste teamkleding, caps en accessoires</p>
        <a href="#" class="btn">Shop nu</a>
    </div>
</header>

<div class="content">
    <h2>Populaire Collecties</h2>

    <div style="margin-bottom:20px;">
        <a href="index.php">Alles</a> |
        <a href="index.php?category=T-shirt">T-shirts</a> |
        <a href="index.php?category=Jassen">Jassen</a> |
        <a href="index.php?category=Petten">Petten</a> |
        <a href="index.php?category=Accessoires">Accessoires</a>
    </div>

<?php
if (isset($_GET['category'])) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category = :category");
    $stmt->execute(['category' => $_GET['category']]);
} else {
    $stmt = $pdo->query("SELECT * FROM products");
}

$products = $stmt->fetchAll();
?>

    <div class="product-grid">
    <?php foreach ($products as $product): ?>
        <div class="product-card">
            <div class="product-img" style="background-image:url('images/<?php echo htmlspecialchars($product['image']); ?>');"></div>
            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
            <p class="price">€<?php echo number_format($product['price'], 2); ?></p>
        <a href="product.php?id=<?php echo $product['id']; ?>" class="btn-small">Bekijk</a>
        </div>
    <?php endforeach; ?>
    </div>
</div>

<footer class="footer">
    <p>© <?php echo date('Y'); ?> F1 Shop – Alle rechten voorbehouden</p>
</footer>

</body>
</html>
