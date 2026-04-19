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

    session_start();

    if ($_POST != null && array_key_exists('username', $_POST)) {
        $accounts=[
            "chuck" => "roast",
            "bob"   => "ross"
        ];

        if (array_key_exists($_POST['username'], $accounts) && 
            $accounts[$_POST['username']] == $_POST['password']
        ) {
            $_SESSION['username'] = $_POST['username'];
        } else {
            echo('<h1 class="glow-text" style="color:#d23;--glow-color:#c66">Access Denied</h1>');
        }
    }
    if ($_SESSION['username']!=null): 
        $end = true;
        if ($_POST == null || !array_key_exists('extra', $_POST)):
        ?>
            <h1 class="glow-text" style="--glow-color: #666a">Welcome, Agent <?=ucfirst($_SESSION['username'])?>.</h1>
            <div class="mid-lined" style="--left:20%;">
                <b class="glow-text" style="--glow-color: #666a">Confidential data</b>
            </div>
            <?php
                $files = array_diff(scandir('includes'),  array('..', '.'));
                foreach($files as $fileName): 
                    $fileName = preg_filter('/\.[^\.]*\z/i', '', $fileName);
                    ?>
                    <form method="POST">
                        <input type="hidden" name="extra" value="<?=$fileName?>">
                        <input type="submit" value="<?=$fileName?>" class="button">
                    </form>
                <?php endforeach; ?>
                <br>
                <form method="POST">
                    <input type="hidden" name="extra" value="logout">
                    <input type="submit" value="< Logout" class="button">
                </form>
            <?php
        elseif ($_POST['extra'] == 'logout'):
            $end = false;
            $_SESSION['username'] = null;
        else:
            $files = array_diff(scandir('includes'),  array('..', '.'));
            $fileName = $_POST['extra'].'.txt';
            if($_SESSION['username']!=null && in_array($fileName, $files)): ?>
                <a href="index.php">&lt Back</a>
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
            <?php endif;
        endif;
        if ($end) {
            echo '</div></body></html>';
            die();
        }
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