<?php session_start() ?>

<?php include 'includes/header.php' ?>
<?php 
    if (array_key_exists('username', $_SESSION) && $_SESSION['username'] != NULL): ?>
    <h1>Enjoy :)</h1>
    <br>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/JcJSW7Rprio?si=BRXGV2o8VnCuHvT2" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
<?php else:
        $url = preg_replace("/[^\/]*\z/i", '', $_SERVER['REQUEST_URI']) . $redirect;
        header('Location: '.$url, true, 303);
        die();
    endif
?>
<?php include 'includes/footer.php' ?>