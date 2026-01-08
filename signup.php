<?php
session_start();
require_once "classes/Database.php";
require_once "classes/User.php";

$db = new Database();
$pdo = $db->pdo;

$userObj = new User($pdo);

$error = "";

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: index.php");
    exit;
}

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
        <div class="form-field">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-field">
            <label>Wachtwoord</label>
            <input type="password" name="password" required>
        </div>

        <input type="submit" value="Registreren" class="btn">
    </form>

    <p>Heb je al een account? <a href="login.php">Log hier in</a></p>
</div>
</body>
</html>
