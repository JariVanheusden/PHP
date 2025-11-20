<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
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

    <div class="product-grid">
        <div class="product-card">
            <div class="product-img img-mclaren"></div>
            <h3>McLaren Jas</h3>
            <p class="price">€129,95</p>
            <button class="btn-small">Bekijk</button>
        </div>

        <div class="product-card">
            <div class="product-img img-ferrari"></div>
            <h3>Ferrari T-shirt</h3>
            <p class="price">€49,95</p>
            <button class="btn-small">Bekijk</button>
        </div>

        <div class="product-card">
            <div class="product-img img-aston"></div>
            <h3>Aston Martin Pet</h3>
            <p class="price">€34,95</p>
            <button class="btn-small">Bekijk</button>
        </div>
    </div>
</div>

<footer class="footer">
    <p>© <?php echo date('Y'); ?> F1 Shop – Alle rechten voorbehouden</p>
</footer>

</body>
</html>