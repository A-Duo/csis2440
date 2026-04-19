<?php 
    function startSQLConnection() {
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            define('HOST',  'localhost');
            define('USER',  'root');
            define('PASS',  '1550');
            define('DB',    'hashbrownDB');
        } else {
            define('HOST',  'sql208.infinityfree.com');
            define('USER',  'if0_39026963');
            define('PASS',  'To75hucRBh');
            define('DB',    'if0_39026963_hashbrownDB');
        }

        $conn = mysqli_connect(HOST,USER,PASS,DB) or die('No connection to mysql.');
        return $conn;
    }
?>