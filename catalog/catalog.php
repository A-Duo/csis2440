<?php
    //  error_reporting(-1);
    // ini_set( 'display_errors', 1 );
    
    session_start();
    include 'includes/helpers.php';
?>


<?php include 'includes/header.php' ?>
<div class="main-container">
    <div class="product-listing">
        <?php 
            $conn = startSQLConnection();
            $results = $conn->query('SELECT * FROM product;');
            $conn->close();
            while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)): 
        ?>
            <div>
                <img src="img/product-images/<?=$row['image']?>">
                <div class="product-info">
                    <a href="product.php?id=<?=$row['id']?>"><?=$row['name']?></a>
                    <br>
                    <span class="price">$<?=$row['price']?></span>
                    <div style="height:0.25ch"></div>
                    <a class="product-details" href="product.php?id=<?=$row['id']?>">View Details ></a>
                    <div style="height:3ch"></div>
                </div>
            </div>
        <?php endwhile ?>
    </div>
</div>
<?php include 'includes/footer.php' ?>