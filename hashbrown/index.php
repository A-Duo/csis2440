<?php session_start(); ?>

<?php
    // error_reporting(-1);
    // ini_set( 'display_errors', 1 );

    include 'includes/header.php';
    include 'includes/db-helper.php';

    $logged_in = array_key_exists('username', $_SESSION) && $_SESSION['username'] != NULL;
    if ($_POST != null && array_key_exists('username', $_POST)) {
        $conn = startSQLConnection();

        $results = $conn->execute_query(
            'SELECT password, password_salt, picture, login_count FROM secureusers WHERE username = ?', 
            [$_POST['username']]
        );

        if ($results-> num_rows != 0) {
            $accountData = $results->fetch_row();

            // Hash the password with sha512 which outputs 64 characters.
            // 512 bits not bytes.
            $password = hash('sha512', $_POST['password'].$accountData[1]);
            if ($accountData[0] == $password) {
                $logged_in = true;
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['pfp'] = $accountData[2] ?? 'unknown.jpeg';
                $_SESSION['login-count'] = $accountData[3] + 1;

                $_SESSION['login-fails'] = 0;

                $conn->execute_query(
                    'UPDATE secureusers SET login_count = login_count + 1 WHERE username = ?', 
                    [$_POST['username']]
                );
            }
        }

        if (!$logged_in) {
            $_SESSION['login-fails'] = (($_SESSION['login-fails'] ?? 0) + 1);
            if ($_SESSION['login-fails'] < 3) {
                echo('<h1 class="glow-text" style="color:#d23;--glow-color:#c66">Access Denied</h1>');
            }
        }

        $conn->close();
    }

    if (!array_key_exists('login-fails', $_SESSION) || $_SESSION['login-fails'] < 3):
        # Could be moved above to skip 1 if statement but this monolith file is hard enough to read as is. 
        if ($logged_in): 
            $form_head = '<form method="POST">
                        <input type="submit" value="%s" class="button">';

            if (array_key_exists('extra', $_POST) && $_POST['extra'] == 'logout'):
                session_destroy();
            else:
                if (array_key_exists('extra', $_POST)):
                    $files = array_diff(scandir('includes/data'),  array('..', '.'));
                    $fileName = $_POST['extra'].'.txt'; ?>

                    <div style="margin-bottom:0.5ch">
                        <?= sprintf($form_head, '&lt Back') ?>
                        </form>
                    </div>

                    <table class="alternating-table">
                        <tbody class="glow-text" style="--glow-color: #555a">
                            <tr>
                                <th>Agent</th>
                                <th>Code Name</th>
                            </tr>
                            <?php
                                $fileName = 'includes/data/'.$fileName;
                                $file = fopen($fileName, "r") or die("Unable to open file!");
                                $data = explode('||>><<||', fread($file,filesize($fileName)));
                                fclose($file);
                                foreach($data as $agent):
                                    $agent = explode(',', $agent); ?>
                                    <tr>
                                        <td><?= $agent[0] ?? "unknown.jpeg"; ?></td>
                                        <td><?= $agent[1]; ?></td>
                                    </tr>
                                <?php
                                endforeach
                            ?> 
                        </tbody>
                    </table>
                <?php else: ?>
                    <h1 class="glow-text" style="--glow-color: #666a">Welcome, Agent <?=ucfirst($_SESSION['username'])?>.</h1>
                    <h4 class="glow-text" style="--glow-color: #666a">You've logged in <?= $_SESSION['login-count'] ?> times</h4>
                    <div class="mid-lined" style="--left:20%;">
                        <b class="glow-text" style="--glow-color: #666a">Confidential data</b>
                    </div>
                    <?php
                        $files = array_diff(scandir('includes/data'),  array('..', '.'));
                        foreach($files as $fileName): 
                            $fileName = preg_filter('/\.[^\.]*\z/i', '', $fileName);
                            ?>
                            <?= sprintf($form_head, $fileName) ?>
                                <input type="hidden" name="extra" value="<?=$fileName?>">
                            </form>
                        <?php endforeach; ?>
                        <br>
                        <?= sprintf($form_head, '&LT Logout') ?>
                            <input type="hidden" name="extra" value="logout">
                        </form>
                    <?php
                endif;
                include 'includes/footer.php';
                die();
            endif;
            ?>
        <?php endif?>
        <form method="POST">
            <table>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" class="text-input"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" class="text-input"></td>
                </tr>
            </table>
            <div>
                <input type="submit" value="Login" class="button">
                <input type="reset" class="button">
            </div>
        </form>
        <br>
        <a href="create-account.php" style="font-size:medium">Create Account &gt;</a>
    <?php else: ?>
        <h1 class="glow-text" style="color:#ff1f1f;font-size:xxx-large;text-align:center;--glow-color:#972020;--glow-size:0.2ch">Account Locked</h1>
    <?php endif ?>
<?php include 'includes/footer.php' ?>