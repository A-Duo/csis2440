<?php 
    function startSQLConnection() {
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            define('HOST',  'localhost');
            define('USER',  'root');
            define('PASS',  '1550');
            define('DB',    'catalogDB');
        } else {
            define('HOST',  'sql208.infinityfree.com');
            define('USER',  'if0_39026963');
            define('PASS',  'To75hucRBh');
            define('DB',    'if0_39026963_catalogDB');
        }

        $conn = mysqli_connect(HOST,USER,PASS,DB) or die('No connection to mysql.');
        return $conn;
    }

    // The DB Schema layed out in the instructions does not have room for a salt so this is my compromise.
    // Since the salt is unique to each user and no other website should my url in the name this should be an effective salt.
    function hashPassword($pasword, $username) {
        // Hash the password with sha512 which outputs 64 characters.
        // 512 bits not bytes.
        return hash('sha512', 'https://csis-2440.wuaze.com/catalog/'.$password.$username);
    }

    function setLogin($username) {
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['cart'] = serialize([]);
    }

    class CartItem {
        public function __construct(
            public int $id, 
            public string $name, 
            public float $unitPrice, 
            public int $quantity
        ) {}
    }
?>