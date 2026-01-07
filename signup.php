<?php
session_start();
require_once "classes/Database.php";
require_once "classes/User.php";

$db = new Database();
$pdo = $db->pdo;

$userObj = new User($pdo);

$error = "";

if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($userObj->register($email, $password)) {
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $userObj->id;
        $_SESSION['role'] = $userObj->role;
        header("Location: index.php");
        exit;
    } else {
        $error = "Dit e-mailadres is al in gebruik.";
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>F1 Shop - Registreren</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="login-container">
    <h2>Registreren bij F1 Shop</h2>

    <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Email</label><br>
        <input type="email" name="email" required><br><br>
        <label>Wachtwoord</label><br>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Registreren" class="btn">
    </form>

    <p>Heb je al een account? <a href="login.php">Log hier in</a></p>
</div>
</body>
</html>
