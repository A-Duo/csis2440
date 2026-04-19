<?php #Why is this index.php and not smth like account.php with catalog as index? ?>

<?php 
    // error_reporting(-1);
    // ini_set( 'display_errors', 1 );
    
    session_start();
    require_once 'includes/helpers.php';
    
    $loggedIn = $_SESSION['isLoggedIn'] ?? false;
    if ($_POST != null && array_key_exists('username', $_POST)) {
        $conn = startSQLConnection();

        $results = $conn->execute_query(
            'SELECT password FROM user WHERE username = ?', 
            [$_POST['username']]
        );

        if ($results-> num_rows != 0) {
            $accountData = $results->fetch_row();
            $password = hashPassword($_POST['password'], $_POST['username']);
            if ($accountData[0] == $password) {
                $loggedIn = true;
                setLogin($_POST['username']);
            }
        }

        $conn->close();
    }
?>

<?php include 'includes/header.php' ?>
<div class="main-container">
    <?php if ($loggedIn): ?>
        <h1>Welcome, <?=$_SESSION['username']?>!</h1>
        <p>
            We here at ACME Co. are here to suit your <i>every</i> need. No matter how strange or obscure!<br>
            Feel free to get started below.
        </p>
        <a href="catalog.php" class="submit" style="padding:0.5ch 1ch;text-decoration:none">View Products</a>
        <br><br>
        <a href="cart.php" class="submit" style="padding:0.5ch 1ch;text-decoration:none">Checkout</a>
    <?php else: ?>
        <?php if ($_GET['must_login'] ?? false): ?>
            <div id="errorList">
                <b>Login Required.</hb>
            </div>
        <?php endif ?>

        <h1 style="color:#242a37">Welcome to the official ACME Co. Store!</h1>
        <p>Purchasing products requires you to create an account. But you can preview them without first.</p>
        <a href="catalog.php" class="submit" style="padding:0.5ch 1ch;text-decoration:none">View Products</a>
        <br><br>
        <?php if (array_key_exists('username', $_POST)): ?>
            <h3 style="color:#d23;padding:0">Incorrect username or password.</h3>
        <?php endif ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" class="text-input" style="margin-bottom:0.5ch"><br>
            <input type="password" name="password" placeholder="Password" class="text-input" style="margin-bottom:1ch">
            <div>
                <input type="submit" value="Login" class="submit">
                <a href="create-account.php" style="padding-left:2ch">Create Account ></a>
            </div>
        </form>
    <?php endif ?>
</div>
<?php include 'includes/footer.php' ?>