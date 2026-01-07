<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

require_once "classes/Database.php";

$db = new Database();
$pdo = $db->pdo;

$error = "";
$success = "";

if (!empty($_POST)) {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = :id");
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($current, $user['password_hash'])) {
        $error = "Huidig wachtwoord is onjuist.";
    } elseif ($new !== $confirm) {
        $error = "Nieuwe wachtwoorden komen niet overeen.";
    } else {
        $hash = password_hash($new, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password_hash = :hash WHERE id = :id");
        $stmt->execute(['hash' => $hash, 'id' => $_SESSION['user_id']]);
        $success = "Wachtwoord succesvol gewijzigd!";
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Wachtwoord wijzigen</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include("nav.inc.php"); ?>

<div class="content">
    <h2>Wachtwoord wijzigen</h2>

    <?php if($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if($success): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Huidig wachtwoord</label><br>
        <input type="password" name="current_password" required><br><br>

        <label>Nieuw wachtwoord</label><br>
        <input type="password" name="new_password" required><br><br>

        <label>Bevestig nieuw wachtwoord</label><br>
        <input type="password" name="confirm_password" required><br><br>

        <input type="submit" value="Wijzigen" class="btn">
    </form>
</div>
</body>
</html>
