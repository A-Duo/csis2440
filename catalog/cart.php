<?php 
    // error_reporting(-1);
    // ini_set( 'display_errors', 1 );

    require_once 'includes/helpers.php';
    
    session_start();
    if (!($_SESSION['isLoggedIn'] ?? false)) {
        $url = preg_replace("/[^\/]*\z/i", '', $_SERVER['REQUEST_URI']);
        header('Location: '.$url, true, 301);
        die("Must be logged in.");
    }

    $cart = unserialize($_SESSION['cart']);

    if (array_key_exists('submit', $_POST)) {
        $updateList = $_POST;
        unset($updateList['submit']);

        $newCart = [];
        foreach ($updateList as $index => $quantity) {
            $index = substr($index, 8);
            $quantity = (int) $quantity;
            if ($quantity > 0) {
                $item = $cart[$index];
                $item->quantity = $quantity;
                $newCart[] = $item;
            }
        }
        $cart = $newCart;

        if ($_POST['submit'] == 'Update Cart') {
            $_SESSION['cart'] = serialize($cart);
        } else {
            $_SESSION['cart'] = serialize([]);
        }
    }
?>

<?php include 'includes/header.php' ?>
<div class="main-container" style="width:60%;margin-left:20%">
    <?php if (($_POST['submit'] ?? 'Update Cart') == 'Place Order'): ?>
        <h1>Thank you for shopping with us!</h1>
        <div class="cart-items">
            <div>
                <h3 style="margin-top:0.5ch">Receipt</h3>
                <ul>
                    <?php $total = 0; ?>
                    <?php foreach ($cart as $i => $cartItem): ?>
                        <?php 
                            $price = $cartItem->unitPrice * $cartItem->quantity;
                            $total += $price;
                        ?>
                        <li>
                            <b><?=$cartItem->name?>:</b>
                            <span class="price" style="padding-left:0.4ch">$<?=$price?></span>
                        </li>
                    <?php endforeach ?>
                </ul>
                <div class="price">Total: $<?=$total?></div>
            </div>
        </div>
        <br>
        <a href="catalog.php" class="submit" style="padding:0.5ch 1ch;text-decoration:none">&lt; Back to shopping</a>
    <?php else: ?>
        <h1>Cart</h1>
        <?php if (count($cart) < 1): ?>
            <p>Your cart is empty.</p>
            <br>
            <a href="catalog.php" class="submit" style="padding:0.5ch 1ch;text-decoration:none">View Products</a>
        <?php else: ?>
            <form method="POST">
                <?php $total = 0 ?>
                <div class="cart-items">
                    <?php foreach ($cart as $i => $cartItem): ?>
                        <?php $total += $cartItem->unitPrice * $cartItem->quantity ?>
                        <div>
                            <b><?=$cartItem->name?></b>
                            <span class="price" style="padding-left:1.2ch">$<?=$cartItem->unitPrice?> per unit</span>
                            <input type="number" name="quantity<?=$i?>" value="<?=$cartItem->quantity?>" class="number" style="float:right">
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="price" style="padding:0.5ch 0 1ch 0.5ch">Total: $<?=number_format($total, 2, '.', '')?></div>
                <input type="submit" name="submit" class="submit" value="Update Cart">
                <input type="submit" name="submit" class="submit" value="Place Order" style="float:right;background-color:#617AFF;color:#fff;border-color:#0000">
            </form>
        <?php endif ?>
    <?php endif ?>
</div>
<?php include 'includes/footer.php' ?>