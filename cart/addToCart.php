<?php

require_once("cartItem.php");

$cartItems = array_filter($_POST);
$selectedOption = json_decode($_POST["Price"]);
$size = $selectedOption->size;
$price = $selectedOption->price;
$cartItems["Price"] = $price;
$cartItem = new CartItem(array_merge([
    "PizzaID" => "",
    "Quantity" => "",
    "Price" => "",
], $cartItems));

$cartItem->setSize($size);
if (count($cartItem->getErrors()) > 0) {
    foreach ($cartItem->getErrors() as $error)
        echo $error;
    echo '<br><a href="insertToppings.php">Go Back</a>';
} else {

    $cartItem->insert();
    // header("Location: cartList.php");
    // exit();
}

?>