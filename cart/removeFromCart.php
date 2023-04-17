<?php
if (isset($_POST["CartItemID"])) {
    var_dump($_POST);
    $CartItemID = $_POST["CartItemID"];

    // Remove the item from the cart
    require_once("cartItem.php");
    $cartItem = new CartItem();
    if ($cartItem->removeFromCart($CartItemID))
        return "OK";
    else
        return "FAILED";
}
?>