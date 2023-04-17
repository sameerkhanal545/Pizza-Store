<?php

require_once("order.php");

$orderDetails = array_filter($_POST);
$orderDetails["ShppingCustomerName"] = $_POST["firstName"]." " . $_POST["lastname"];
$orderDetails["Status"] = "PAID";
$order = new Order(array_merge([
    "ShippingAddress" => "",
    "ZipCode" => "",
    "ShippingCustomerName" => "",
], $orderDetails));
if (count($order->getErrors()) > 0) {
    foreach ($order->getErrors() as $error)
        echo $error;
    echo '<br><a href="insertToppings.php">Go Back</a>';
} else {
    $cart = new Cart();
    session_start();
    if (isset($_SESSION['CustomerID'])) {
        // get the CustomerID value from the session
        $CustomerID = $_SESSION['CustomerID'];
        $order->setCustomerID($CustomerID);
        $cart = $cart->findByCustomer($CustomerID);
       
        if ($cart) {
            $cartItem = new CartItem();
            $cartItems = $cartItem->findAllByCart($cart->getCartID());
            $order->insert($cartItems,$cart->getCartID());
        }
    } else {
        header("Location: ../login/login.php");
        exit;
    }
    header("Location: orderList.php");
    exit();
}

?>