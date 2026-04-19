<?php 
    $accounts=[
        "chuck" => "roast",
        "bob"   => "ross"
    ];

    session_start();
    $redirect = 'failure.php';

    if (array_key_exists($_POST['username'], $accounts) && 
        $accounts[$_POST['username']] == $_POST['password']
    ) {
        $_SESSION['username'] = $_POST['username'];
        $redirect = 'success.php';
        
    // Not good practice, just to show the login has an effect for the assignment.
    // Can't fail a login and then just type in the success url.
    } else {
        $_SESSION['username'] = null;
    }

    $url = preg_replace("/[^\/]*\z/i", '', $_SERVER['REQUEST_URI']) . $redirect;
    header('Location: '.$url, true, 303);
    die();
?>