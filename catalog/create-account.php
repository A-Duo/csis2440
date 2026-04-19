<?php 
    // error_reporting(-1);
    // ini_set( 'display_errors', 1 );

    session_start();
    require_once 'includes/helpers.php';

    if (array_key_exists('username', $_POST)) {
        $errorMessages = [];
        // Welcome to if statement hell.
        // I didn't need to do this lmao but eh makes it feel more authentic.
        if (mb_strlen($_POST['username']) > 50) {
            $errorMessages[] = 'Username exceeds max length (50 characters)';

        } elseif (mb_strlen($_POST['username']) < 1) {
            $errorMessages[] = 'Username is required';
        }

        if (!array_key_exists('password', $_POST)) {
            $errorMessages[] = 'Password is required';
        } 
        if (strlen($_POST['password']) > 128) {
            $errorMessages[] = 'Password must not exceed 128 characters';
        } 
        if (preg_match('/[^\w~`!@#$%^&*()\-_+=[{}\]\|:;"\'<,>.?\/\\\]/', $_POST['password'])) {
            $errorMessages[] = 'Password must only be alphanumeric characters or any of the following characters: ~`!@#$%^&*()-_+=[{}]|:;&quot;\'&lt;,&gt;.?/\\';
        } 
        if (!preg_match('/[\d]/', $_POST['password'])) {
            $errorMessages[] = 'Password must contain at least 1 number';
        } 
        if (strlen($_POST['password']) < 8) {
            $errorMessages[] = 'Password must be at least 8 characters';
        } 
        if (!array_key_exists('password2', $_POST) || strlen($_POST['password'] < 1)) {
            $errorMessages[] = 'Must confirm password';
        } 
        if ($_POST['password'] != $_POST['password2']) {
            $errorMessages[] = 'Passwords must match';
        } 

        if (count($errorMessages) == 0) {
            $conn = startSQLConnection();
            $results = $conn->execute_query(
                'SELECT username FROM user WHERE username = ?',
                [$_POST['username']]
            );
            // If username isn't taken
            if ($results->num_rows > 0) {
                $errorMessages[] = 'Username is already taken';
            } else {
                $password = hashPassword($_POST['password'], $_POST['username']);

                $statement = 'INSERT INTO user(username, password) VALUES (?, ?);';
                if ($conn->execute_query($statement, [$_POST['username'], $password])) {
                    // If account created successfully then set session and redirect to home.
                    setLogin($_POST['username']);
                    
                    $url = preg_replace("/[^\/]*\z/i", '', $_SERVER['REQUEST_URI']);
                    header('Location: '.$url, true, 301);
                    die();
                } else {
                    $errorMessages[] = 'DB Error: "'.$conn->error.'"';
                }
            }
            $conn->close();
        }
    }
?>

<?php include 'includes/header.php' ?>
<div class="main-container">
    <div style="width:50ch;margin-left:calc(50% - 25ch)">
        <h1>Create Account</h1>
        <ul id="errorList">
            <?php if (isset($errorMessages)): ?>
                <?php foreach ($errorMessages as $errorMessage): ?>
                    <li><b><?=$errorMessage?></b></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        <form method="POST">
            <input id="username" type="text" name="username" placeholder="Username" class="text-input" style="margin-bottom:0.5ch"
                <?= array_key_exists('username', $_POST) ? 'value="'.$_POST['username'].'"' : '' ?>><br>
            <input id="password" type="password" name="password" placeholder="Password" class="text-input" style="margin-bottom:0.5ch"><br>
            <input id="password2" type="password" name="password2" placeholder="Confirm Password" class="text-input" style="margin-bottom:1ch">
            <div>
                <input type="submit" value="Submit" class="submit" id="submit" disabled>
                <input type="reset" class="submit" style="background-color:#eee">
            </div>
            <script src="js/script.js"></script>
        </form>
        <br>
        <a href="index.php" style="font-size:medium">&lt; Back</a>
    </div>
</div>
<?php include 'includes/footer.php' ?>