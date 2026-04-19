<?php
    //  error_reporting(-1);
    // ini_set( 'display_errors', 1 );

    session_start();
    require_once 'includes/helpers.php';

    $conn = startSQLConnection();
    $results = $conn->execute_query(
        'SELECT * FROM product WHERE id = ?', 
        [$_GET['id']]
    );
    $conn->close();

    if ($results-> num_rows == 0) {
        die("Invalid product id.");
    }

    $product = $results->fetch_row();

    if (array_key_exists('quantity', $_POST)) {
        if (!($_SESSION['isLoggedIn'] ?? false)) {
            $url = preg_replace("/[^\/]*\z/i", '', $_SERVER['REQUEST_URI']).'?must_login=true';
            header('Location: '.$url, true, 301);
            die("Must be logged in.");
        }

        $messages=[];

        $cart = unserialize($_SESSION['cart']);
        $cartIndex = -1;
        foreach ($cart as $i => $cartItem) {
            if ($cartItem->id == $product[0]) {
                $cartIndex = $i;
                break;
            }
        }

        if ($cartIndex > -1) {
            $cart[$cartIndex]->quantity += (int) $_POST['quantity'];
        } else {
            $cart[] = new CartItem($product[0], $product[1], $product[4], (int) $_POST['quantity']);
        }

        $_SESSION['cart'] = serialize($cart);
        $messages[] = 'Successfully added to cart.';
    }
?>

<?php include 'includes/header.php' ?>
<div class="main-container">
    <?php if (isset($messages)): ?>
        <div class="message-box">
            <?php foreach ($messages as $message): ?>
                <p><b style="font-size:medium"><?=$message?></b></p>
            <?php endforeach; ?>
        </div>
    <?php endif ?>
    <div style="display:inline-block;width:calc(40% - 5ch);vertical-align:top;padding: 3ch 3ch 3ch 0">
        <img src="img/product-images/<?=$product[3]?>" style="width:100%;border:2px solid #68a;border-radius:1.5ch">
    </div>
    <div style="width:60%;display:inline-block;vertical-align:top">
        <h1><?=$product[1]?></h1>
        <p class="price">$<?=$product[4]?></p>
        <p><?=$product[2]?></p>
        <form method="POST">
            <input type="submit" value="Add to cart" class="submit">
            <input type="number" name="quantity" value="1" class="number">
            <a href="catalog.php" style="padding-left:2ch;font-size:1.6ch">&lt; Back</a>
        </form>
    </div>
</div>
<?php include 'includes/footer.php' ?>