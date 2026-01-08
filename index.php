<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: signup.php");
    exit;
}

require_once "classes/Database.php";
require_once "classes/Product.php";

$currentCategory = $_GET['category'] ?? 'all';

$db = new Database();
$productObj = new Product($db->pdo);

$category = $_GET['category'] ?? null;
$products = $productObj->getAll($category);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>F1 Shop - Home</title>
    <link rel="stylesheet" href="css/style.css">
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

    <div class="category-nav">
    <a href="index.php" class="<?= $currentCategory === 'all' ? 'active' : '' ?>">Alles</a>

    <a href="index.php?category=T-shirt"
       class="<?= $currentCategory === 'T-shirt' ? 'active' : '' ?>">
       T-shirts
    </a>

    <a href="index.php?category=Jassen"
       class="<?= $currentCategory === 'Jassen' ? 'active' : '' ?>">
       Jassen
    </a>

    <a href="index.php?category=Petten"
       class="<?= $currentCategory === 'Petten' ? 'active' : '' ?>">
       Petten
    </a>

    <a href="index.php?category=Accessoires"
       class="<?= $currentCategory === 'Accessoires' ? 'active' : '' ?>">
       Accessoires
    </a>
</div>



    <div class="product-grid">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <div class="product-img" style="background-image: url('images/<?php echo htmlspecialchars($product['image']); ?>');"></div>
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="price">€<?php echo number_format($product['price'], 2); ?></p>
                    <a href="product.php?id=<?php echo $product['id']; ?>" class="btn-small">Bekijk</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Geen producten gevonden in deze categorie.</p>
        <?php endif; ?>
    </div>
</div>

<footer class="footer">
    <p>© <?php echo date('Y'); ?> F1 Shop – Alle rechten voorbehouden</p>
</footer>

</body>
</html>
