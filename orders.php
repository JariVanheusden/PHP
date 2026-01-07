<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

require_once "classes/Database.php";

$db = new Database();
$pdo = $db->pdo;

$stmt = $pdo->prepare("
    SELECT o.*, p.name, p.image, p.price 
    FROM orders o
    JOIN products p ON o.product_id = p.id
    WHERE o.user_id = :user_id
    ORDER BY o.id DESC
");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Mijn bestellingen</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include("nav.inc.php"); ?>

<div class="content">
    <h2>Mijn bestellingen</h2>

    <?php if(empty($orders)): ?>
        <p>Je hebt nog geen bestellingen geplaatst.</p>
    <?php else: ?>
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Afbeelding</th>
                    <th>Prijs per stuk</th>
                    <th>Aantal</th>
                    <th>Totaal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['name']); ?></td>
                        <td><img src="images/<?php echo htmlspecialchars($order['image']); ?>" alt="" width="50"></td>
                        <td>€<?php echo number_format($order['price'], 2); ?></td>
                        <td><?php echo $order['quantity']; ?></td>
                        <td>€<?php echo number_format($order['total_price'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
