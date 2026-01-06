<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

$host = "localhost";
$dbname = "f1_shop";
$user = "root";
$pass = "";

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

// check id
if (!isset($_GET['id'])) {
    die("Geen product geselecteerd");
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute(['id' => $_GET['id']]);
$product = $stmt->fetch();

if (!$product) {
    die("Product niet gevonden");
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include("nav.inc.php"); ?>

<div class="content">
    <h2><?php echo htmlspecialchars($product['name']); ?></h2>

    <div class="product-card" style="max-width:400px;">
        <div class="product-img" style="background-image:url('images/<?php echo htmlspecialchars($product['image']); ?>'); height:300px;"></div>
        <p><?php echo htmlspecialchars($product['description']); ?></p>
        <p class="price">€<?php echo number_format($product['price'], 2); ?></p>

        <form method="post" action="mycart.php">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <input type="submit" value="Toevoegen aan winkelmandje" class="btn">
        </form>
    </div>
</div>

</body>
</html>
