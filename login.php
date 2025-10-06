<?php
session_start();

function canLogin($email, $password) {
    return $email === "jenaam@shop.com" && $password === "12345isnotsecure";
}

if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (canLogin($email, $password)) {
        $_SESSION['loggedin'] = true;
        $_SESSION['user'] = $email;
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