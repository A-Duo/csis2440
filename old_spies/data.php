<?php session_start(); ?>
<?php include 'includes/header.php';?>

<?php 
$files = array_diff(scandir('includes/data'),  array('..', '.'));
$fileName = $_SERVER['QUERY_STRING'].'.txt';
if($_SESSION['username']!=null && in_array($fileName, $files)): ?>
    <a href="success.php">&lt Back</a>
    <?php 
    $fileName = "includes/data/".$fileName;
    include 'includes/display-file.php'
    ?>
<?php else: 
    include 'includes/access-denied.php';
    $url = preg_replace("/[^\/]*\z/i", '', $_SERVER['REQUEST_URI']) . 'failure.php';
    header('Location: '.$url, true, 303);
    die();
endif; ?>
<?php include 'includes/footer.php';?>