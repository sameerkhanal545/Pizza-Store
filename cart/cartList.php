<!DOCTYPE html>
<html lang="en">
<?php
require_once("cartItem.php");
require_once("cart.php");
$cart = new Cart();
session_start();
if (isset($_SESSION['CustomerID'])) {
    // get the CustomerID value from the session
    $CustomerID = $_SESSION['CustomerID'];
    $cart = $cart->findByCustomer($CustomerID);
    if ($cart) {
        $cartItem = new CartItem();
        $cartItems = $cartItem->findAllByCart($cart->getCartID());
    }
} else {
    header("Location: ../login/login.php");
    exit;
}

?>

<body>
    <?php require_once("../shared/header.php") ?>
    <div class="container body-content">

        <table class="table table-hover">
            <tbody>
                <tr class="table-info">
                    <th>Product</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Action</th>


                </tr>
                <?php if (isset($cartItems)) { ?>
                    <?php foreach ($cartItems as $cart): ?>
                        <tr>
                            <td class="col-sm-6 col-md-6 thumbnail">
                                <img id="MainContent_rptCartItems_Image1_0"
                                    src="../admin/pizza/images/<?php echo $cart->getPizzaImage(); ?>"
                                    style="height:120px;width:120px;">
                            </td>

                            <td class="col-sm-1 col-md-1">
                                <?php echo $cart->getPizzaName(); ?>
                            </td>
                            <td class="col-sm-1 col-md-1 text-center">
                                <?php echo $cart->getQuantity(); ?>
                            </td>
                            <td class="col-sm-1 col-md-1 text-center"><strong> $
                                    <?php echo $cart->getPrice(); ?>
                                </strong></td>
                            <td class="col-sm-1 col-md-1 text-center">
                                <button type="submit" id="removeFromCart" class="btn btn-danger remove-btn"
                                    data-cart-item-id=<?php echo $cart->getCartItemID(); ?>>Remove</button>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                <?php }else { ?>
                    <tr>
                        <td class="text-center" colspan="5">No item in the cart </td>
                    </tr>
                    <?php } ?>
            </tbody>
        </table>

        <div class="cart-button">
            <a class="btn btn-info" href="/">Continue Shopping</a>
            <a class="btn btn-primary" href="..//order/checkout.php">Checkout</a>
        </div>

        <hr>

    </div>
    <?php require_once("../shared/footer.php") ?>

</body>
<script>
    // Find all remove buttons
    const removeButtons = document.querySelectorAll('.remove-btn');

    // Add event listener to each remove button
    removeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const cartItemId = this.dataset.cartItemId;

            // Create AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'removeFromCart.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            // Send AJAX request with cart item ID
            xhr.onload = function () {
                if (xhr.status === 200) {

                    location.reload(); // Reload the current page

                }
            }
            xhr.send('CartItemID=' + cartItemId);
        });
    });

</script>

</html>