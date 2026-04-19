<?php session_start() ?>

<?php include 'includes/header.php' ?>
<?php 
    if (array_key_exists('username', $_SESSION) && $_SESSION['username'] != NULL): ?>
        <div style="width:128px;height:128px"><img src="img/pfp/<?= $_SESSION['pfp']?>" class="rounded-box" style="width:100%;height:100%;object-fit:cover;"></div>
        <p style="font-size:2.5ch"><strong>Account: </strong>"<?= $_SESSION['username'] ?>"</p>
<?php else:
        $url = preg_replace("/[^\/]*\z/i", '', $_SERVER['REQUEST_URI']) . $redirect;
        header('Location: '.$url, true, 303);
        die();
    endif
?>
<?php include 'includes/footer.php' ?>