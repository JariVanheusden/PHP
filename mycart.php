<?php
session_start();
require_once "classes/Database.php";
require_once "classes/Product.php";

$db = new Database();
$productObj = new Product($db->pdo);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['remove'])) {
    $removeId = (int)$_POST['remove'];
    unset($_SESSION['cart'][$removeId]);
}

$cartItems = $_SESSION['cart'];
$products = !empty($cartItems) ? $productObj->getByIds(array_keys($cartItems)) : [];

$total = 0;
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Mijn winkelmandje</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include("nav.inc.php"); ?>

<div class="content">
    <h2>Mijn winkelmandje</h2>

    <?php if (empty($products)): ?>
        <p>Je winkelmandje is leeg.</p>
    <?php else: ?>
        <form method="post" action="mycart.php">
        <?php foreach ($products as $product): 
            $qty = $_SESSION['cart'][$product['id']];
            $subtotal = $product['price'] * $qty;
            $total += $subtotal;
        ?>
            <p>
                <?php echo htmlspecialchars($product['name']); ?>  
                (<?php echo $qty; ?>x) – €<?php echo number_format($subtotal, 2); ?> 
                <button type="submit" name="remove" value="<?php echo $product['id']; ?>">Verwijder</button>
            </p>
        <?php endforeach; ?>
        </form>

        <hr>
        <strong>Totaal: €<?php echo number_format($total, 2); ?></strong>

        <form method="post" action="checkout.php">
            <input type="submit" value="Afrekenen" class="btn">
        </form>
    <?php endif; ?>
</div>

</body>
</html>
