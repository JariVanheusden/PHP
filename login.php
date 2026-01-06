<?php
session_start();

$host = "localhost";
$dbname = "f1_shop";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database verbinding mislukt: " . $e->getMessage());
}

if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Onjuiste combinatie van e-mailadres en wachtwoord.";
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>F1 Shop - Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="login-container">
    <h2>Inloggen bij F1 Shop</h2>
    <?php if(isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <form action="" method="post">
        <div class="form-field">
            <label>Email</label>
            <input type="text" name="email" required>
        </div>
        <div class="form-field">
            <label>Wachtwoord</label>
            <input type="password" name="password" required>
        </div>
        <input type="submit" value="Inloggen" class="btn">
    </form>
</div>
</body>
</html>