<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    die("Toegang geweigerd. Alleen admin.");
}

require_once "classes/Database.php";
require_once "classes/Product.php";

$db = new Database();
$productObj = new Product($db->pdo);

if (isset($_POST['add'])) {
    $productData = [
        'name' => $_POST['name'] ?? '',
        'price' => $_POST['price'] ?? 0,
        'category' => $_POST['category'] ?? '',
        'description' => $_POST['description'] ?? '',
        'image' => $_POST['image'] ?? ''
    ];
    $productObj->add($productData);
}


if (isset($_POST['edit'])) {
    $productData = [
        'name' => $_POST['name'] ?? '',
        'price' => $_POST['price'] ?? 0,
        'category' => $_POST['category'] ?? '',
        'description' => $_POST['description'] ?? '',
        'image' => $_POST['image'] ?? ''
    ];
    $productObj->update($_POST['id'], $productData);
}


if (isset($_POST['delete'])) {
    $productObj->delete($_POST['delete']);
}


$products = $productObj->getAll();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Admin - F1 Shop</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include("nav.inc.php"); ?>

<div class="content">
    <h2>Admin Panel</h2>

    <h3>Product toevoegen</h3>
    <form method="post">
        Naam: <input type="text" name="name" required><br>
        Prijs: <input type="number" name="price" step="0.01" required><br>
        Categorie: <input type="text" name="category" required><br>
        Beschrijving: <input type="text" name="description"><br>
        Afbeelding (bestand in images/): <input type="text" name="image"><br>
        <input type="submit" name="add" value="Toevoegen">
    </form>

    <h3>Bestaande producten</h3>
    <?php foreach($products as $p): ?>
        <form method="post" style="border:1px solid #ccc; padding:10px; margin:5px;">
            <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
            Naam: <input type="text" name="name" value="<?php echo htmlspecialchars($p['name']); ?>"><br>
            Prijs: <input type="number" name="price" step="0.01" value="<?php echo $p['price']; ?>"><br>
            Categorie: <input type="text" name="category" value="<?php echo htmlspecialchars($p['category']); ?>"><br>
            Beschrijving: <input type="text" name="description" value="<?php echo htmlspecialchars($p['description']); ?>"><br>
            Afbeelding: <input type="text" name="image" value="<?php echo htmlspecialchars($p['image']); ?>"><br>
            <input type="submit" name="edit" value="Bewerken">
            <button type="submit" name="delete" value="<?php echo $p['id']; ?>">Verwijderen</button>
        </form>
    <?php endforeach; ?>
</div>

</body>
</html>
