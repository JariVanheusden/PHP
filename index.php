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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include("nav.inc.php"); ?>

<div class="content">
    <h1>Welkom bij de F1 Shop!</h1>
    <p>Klik rond en ontdek de nieuwste merchandise.</p>

    <div class="collection">
        <div class="item">Mclaren Jas</div>
        <div class="item">Ferrari T-shirt</div>
        <div class="item">Aston Martin Pet</div>
    </div>
</div>

</body>
</html>