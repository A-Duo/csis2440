<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Spies R. Us</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class ="background">
            <img src="img/fbi.png">
        </div>
        <div class="main-container">
<?php
    error_reporting(-1);
    ini_set( 'display_errors', 1 );

    $logged_in = false;
    if ($_POST != null && array_key_exists('username', $_POST)) {
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            define('HOST',  'localhost');
            define('USER',  'root');
            define('PASS',  '1550');
            define('DB',    'insecureDB');
        } else {
            define('HOST',  'sql208.infinityfree.com');
            define('USER',  'if0_39026963');
            define('PASS',  'To75hucRBh');
            define('DB',    'if0_39026963_insecureDB');
        }

        $conn = mysqli_connect(HOST,USER,PASS,DB) or die('No connection to mysql.');

        $results = $conn->execute_query(
            'SELECT * FROM account WHERE username = ? AND password = ?', 
            [$_POST['username'], $_POST['password']]
        );

        if ($results-> num_rows != 0) {
            $logged_in = true;
        } else {
            echo('<h1 class="glow-text" style="color:#d23;--glow-color:#c66">Access Denied</h1>');
        }
    }

    # Could be moved above to skip 1 if statement but this monolith file is hard enough to read as is. 
    if ($logged_in): 
        $form_head = '<form method="POST">
                    <input type="submit" value="%s" class="button">
                    <input type="hidden" name="username" value="'.$_POST['username'].'">
                    <input type="hidden" name="password" value="'.$_POST['password'].'">';

        if (array_key_exists('extra', $_POST)):
            $files = array_diff(scandir('includes'),  array('..', '.'));
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
                        $fileName = 'includes/'.$fileName;
                        $file = fopen($fileName, "r") or die("Unable to open file!");
                        $data = explode('||>><<||', fread($file,filesize($fileName)));
                        fclose($file);
                        foreach($data as $agent):
                            $agent = explode(',', $agent); ?>
                            <tr>
                                <td><?= $agent[0]; ?></td>
                                <td><?= $agent[1]; ?></td>
                            </tr>
                        <?php
                        endforeach
                    ?> 
                </tbody>
            </table>
        <?php else: ?>
            <h1 class="glow-text" style="--glow-color: #666a">Welcome, Agent <?=ucfirst($_POST['username'])?>.</h1>
            <div class="mid-lined" style="--left:20%;">
                <b class="glow-text" style="--glow-color: #666a">Confidential data</b>
            </div>
            <?php
                $files = array_diff(scandir('includes'),  array('..', '.'));
                foreach($files as $fileName): 
                    $fileName = preg_filter('/\.[^\.]*\z/i', '', $fileName);
                    ?>
                    <?= sprintf($form_head, $fileName) ?>
                        <input type="hidden" name="extra" value="<?=$fileName?>">
                    </form>
                <?php endforeach; ?>
                <br>
                <a href="" class="button">&LT Logout</a>
            <?php
        endif;
        echo '</div></body></html>';
        die();
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
        </div> 
    </body>
</html>