<?php
session_start();

require_once "classes/Database.php";
require_once "classes/Product.php";

if (!isset($_GET['id'])) {
    die("Geen product geselecteerd.");
}

$db = new Database();
$productObj = new Product($db->pdo);

$product = $productObj->getById((int)$_GET['id']);

if (!$product) {
    die("Product niet gevonden.");
}

// Winkelmandje logica
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $id = (int)$product['id'];
    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 1;
    } else {
        $_SESSION['cart'][$id]++;
    }
    $added = true;
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include("nav.inc.php"); ?>

<div class="content">
    <h2><?php echo htmlspecialchars($product['name']); ?></h2>

    <div class="product-card" style="max-width:400px;">
        <div class="product-img" style="background-image: url('images/<?php echo htmlspecialchars($product['image']); ?>'); height:300px;"></div>
        <p><?php echo htmlspecialchars($product['description']); ?></p>
        <p class="price">€<?php echo number_format($product['price'], 2); ?></p>

        <?php if (!empty($added)): ?>
            <div class="success">Product toegevoegd aan winkelmandje!</div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <input type="submit" name="add_to_cart" value="Toevoegen aan winkelmandje" class="btn">
        </form>
    </div>
</div>

</body>
</html>
