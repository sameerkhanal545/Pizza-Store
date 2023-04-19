<!DOCTYPE html>
<html lang="en">
<?php
require_once("../cart/cartItem.php");
require_once("../cart/cart.php");
$cart = new Cart();
session_start();
if (isset($_SESSION['CustomerID'])) {
    // get the CustomerID value from the session
    $CustomerID = $_SESSION['CustomerID'];
    $cart = $cart->findByCustomer($CustomerID);
    if ($cart) {
        $cartItem = new CartItem();
        $cartItems = $cartItem->findAllByCart($cart->getCartID());
        if (sizeof($cartItems) <= 0) {
            header("Location: ../cart/cartList.php");
            exit;
        }
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->getPrice() * $item->getQuantity();
        }
    }
} else {
    header("Location: ../login/login.php");
    exit;
}

?>

<body>
    <?php require_once("../shared/header.php") ?>

    <div class="container">

        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Your cart</span>
                    <span class="badge badge-secondary badge-pill">3</span>
                </h4>
                <ul class="list-group mb-3 sticky-top">
                    <?php foreach ($cartItems as $cart): ?>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">
                                    <?php echo $cart->getPizzaName() ?>
                                </h6>
                                <small class="text-muted">Quantity:
                                    <?php echo $cart->getQuantity() ?>
                                </small>
                            </div>
                            <span class="text-muted">$
                                <?php echo $cart->getPrice() ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                    <li class="list-group-item d-flex justify-content-between text-success">
                        <span>Total (CAD)</span>
                        <strong>$
                            <?php echo $total ?>
                        </strong>
                    </li>
                </ul>
            </div>
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Billing address</h4>
                <form class="needs-validation" novalidate="" action="createOrder.php" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName">First name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder=""
                                value="" required="">
                            <div class="invalid-feedback"> Valid first name is required. </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName">Last name</label>
                            <input type="text" class="form-control" id="lastName" name="lastname" placeholder=""
                                value="" required="">
                            <div class="invalid-feedback"> Valid last name is required. </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="ShippingAddress" id="address"
                            placeholder="1234 Main St" required="">
                        <div class="invalid-feedback"> Please enter your shipping address. </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="zip">Zip</label>
                            <input type="text" class="form-control" name="ZipCode" id="zip" placeholder="" required="">
                            <div class="invalid-feedback"> Zip code required. </div>
                        </div>
                    </div>
                    <hr class="mb-4">
                    <h4 class="mb-3">Payment</h4>
                    <div class="d-block my-3">
                        <div class="custom-control custom-radio">
                            <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked=""
                                required="">
                            <label class="custom-control-label" for="credit">Credit card</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="debit" name="paymentMethod" type="radio" class="custom-control-input"
                                required="">
                            <label class="custom-control-label" for="debit">Debit card</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cc-name">Name on card</label>
                            <input type="text" class="form-control" id="cc-name" name="CardName" placeholder=""
                                required="">
                            <small class="text-muted">Full name as displayed on card</small>
                            <div class="invalid-feedback"> Name on card is required </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cc-number">Credit card number</label>
                            <input type="text" class="form-control" id="cc-number" name="CardNumber" placeholder=""
                                required="">
                            <div class="invalid-feedback"> Credit card number is required </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="cc-expiration">Expiration</label>
                            <input type="text" class="form-control" id="cc-expiration" name="ExpiryDate" placeholder=""
                                required="">
                            <div class="invalid-feedback"> Expiration date required </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="cc-cvv">CVV</label>
                            <input type="text" class="form-control" id="cc-cvv" name="Cvv" placeholder="" required="">
                            <div class="invalid-feedback"> Security code required </div>
                        </div>
                    </div>
                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Place Order</button>
                </form>
            </div>
        </div>
        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© 2017-2019 Company Name</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Privacy</a></li>
                <li class="list-inline-item"><a href="#">Terms</a></li>
                <li class="list-inline-item"><a href="#">Support</a></li>
            </ul>
        </footer>
    </div>
</body>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict'

        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation')

            // Loop over them and prevent submission
            Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        }, false)
    }())
</script>

</html>