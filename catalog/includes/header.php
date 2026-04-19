<?php if (session_id() == '') session_start(); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ACME Co.</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="navbar">
            <div>
                <a href="index.php" class="home-button nav-item" style="font-size:2.3ch">
                    <span style="font-weight:600">ACME </span>Co.
                </a>
                <span>
                    <a href="index.php" class="home-button nav-item">Home</a>
                    <a href="catalog.php" class="home-button nav-item">Products</a>
                </span>
                <span style="float:right">
                    <?php if ($_SESSION['isLoggedIn'] ?? false): ?>
                        <a href="cart.php" class="home-button nav-item">Cart</a>
                        <a href="logout.php" class="home-button nav-item">Logout</a>
                    <?php else: ?>
                        <a href="index.php" class="home-button nav-item">Login</a>
                        <a href="create-account.php" class="home-button nav-item">Create Account</a>
                    <?php endif ?>
                </span>
            </div>
        </div>