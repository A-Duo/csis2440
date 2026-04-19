<?php session_start() ?>

<?php include 'includes/header.php' ?>
<?php include 'includes/db-helper.php' ?>
<?php 
    // error_reporting(-1);
    // ini_set( 'display_errors', 1 );

    if (array_key_exists('username', $_POST)):
        $errorMessages = [];
        // Welcome to if statement hell.
        // I didn't need to do this lmao but eh makes it feel more authentic.
        if (mb_strlen($_POST['username']) > 40) {
            $errorMessages[] = 'Username exceeds max length (40 characters)';

        } elseif (mb_strlen($_POST['username']) < 1) {
            $errorMessages[] = 'Username is required';
        }

        if (!array_key_exists('password', $_POST)) {
            $errorMessages[] = 'Password is required';
        } 
        if (strlen($_POST['password']) > 128) {
            $errorMessages[] = 'Password must not exceed 128 characters... I\'m not wasting time hashing that.';
        } 
        if (preg_match('/[^\w~`!@#$%^&*()\-_+=[{}\]\|:;"\'<,>.?\/\\\]/', $_POST['password'])) {
            $errorMessages[] = 'Password must only be alphanumeric characters or any of the following characters: ~`!@#$%^&*()-_+=[{}]|:;&quot;\'&lt;,&gt;.?/\\';
        } 
        if (strlen($_POST['password']) < 4) {
            $errorMessages[] = 'Password must be at least 4 characters';
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
                'SELECT username FROM secureusers WHERE username = ?',
                [$_POST['username']]
            );
            // If username isn't taken
            if ($results->num_rows == 0) {
                // Keep generating new salts until a unique one is made there are 1.8e+19 possible so shouldn't happen.
                while (true) {
                    $salt = bin2hex(random_bytes(8));
                    $results = $conn->execute_query(
                        'SELECT username FROM secureusers WHERE username = ?',
                        [$_POST['username']]
                    );
                    if ($results->num_rows == 0) break;
                }
                
                // Hash the password with sha512 which outputs 64 characters.
                // 512 bits not bytes.
                $password = hash('sha512', $_POST['password'].$salt);

                $statement = 'INSERT INTO secureusers(username, password, password_salt) VALUES (?, ?, ?);';
                if ($conn->execute_query($statement, [$_POST['username'], $password, $salt])) {
                    // If account created successfully then set session and redirect to home.
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['pfp'] = 'unknown.jpeg';
                    $_SESSION['login-count'] = 0;
                    
                    $url = preg_replace("/[^\/]*\z/i", '', $_SERVER['REQUEST_URI']) . $redirect;
                    header('Location: '.$url, true, 303);
                    die();
                } else {
                    $errorMessages[] = 'DB Error: "'.$conn->error.'"';
                }
            } else {
                $errorMessages[] = 'Username is already taken';
            }
            $conn->close();
        }
    endif; ?>
    <h1 class="glow-text" style="--glow-color: #555a">Create Account</h1>
    <?php if (isset($errorMessages)): ?>
        <ul style="color:#ff3a4b;margin-left:-1.5ch">
            <?php foreach ($errorMessages as $errorMessage): ?>
                <li><b class="glow-text" style="font-size:large;--glow-color:#713030bf"><?=$errorMessage?></b></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form method="POST">
        <table>
            <tr>
                <td>Username:</td>
                <td><input type="text" name="username" class="text-input" 
                    <?= array_key_exists('username', $_POST) ? 'value="'.$_POST['username'].'"' : '' ?>
                ></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password" class="text-input"></td>
            </tr>
            <tr>
                <td>Confirm password:</td>
                <td><input type="password" name="password2" class="text-input"></td>
            </tr>
        </table>
        <div>
            <input type="submit" value="Login" class="button">
            <input type="reset" class="button">
        </div>
    </form>
    <br>
    <a href="index.php" style="font-size:medium">&lt; Back</a>
<?php include 'includes/footer.php' ?>