
<?php session_start(); ?>
<?php include 'includes/header.php';?>

<?php if($_SESSION['username']!=null): ?>
    <h1 class="glow-text" style="--glow-color: #666a">Welcome, Agent <?=ucfirst($_SESSION['username'])?>.</h1>
    <div class="mid-lined" style="--left:20%;">
        <b class="glow-text" style="--glow-color: #666a">Confidential data</b>
    </div>
    <?php
        $files = array_diff(scandir('includes/data'),  array('..', '.'));
        foreach($files as $fileName): 
            $fileName = preg_filter('/\.[^\.]*\z/i', '', $fileName);
            ?>
            <a href="data.php?<?=$fileName?>"><?=$fileName?></a><br>
        <?php endforeach
    ?>
<?php else: 
    include 'includes/access-denied.php';
    $url = preg_replace("/[^\/]*\z/i", '', $_SERVER['REQUEST_URI']) . 'failure.php';
    header('Location: '.$url, true, 303);
    die();
endif; ?>
<?php include 'includes/footer.php';?>