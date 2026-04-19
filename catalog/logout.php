<?php
    session_start();
    session_destroy();

    $url = preg_replace("/[^\/]*\z/i", '', $_SERVER['REQUEST_URI']);
    header('Location: '.$url, true, 301);
    die();
?>