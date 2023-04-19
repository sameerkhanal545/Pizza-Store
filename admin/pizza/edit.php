<?php

require_once("pizza.php");
$pizzaData = array_filter($_POST);
$pizza = new Pizza(array_merge([
    "PizzaName" => "",
    "PizzaDescription" => "",
], $pizzaData));
if (!isset($_FILES['PizzaImage']["name"])){
    $pizza->setPizzaImage($_FILES["PizzaImage"]);
}
if (count($pizza->getErrors(true)) > 0) {
    foreach ($pizza->getErrors(true) as $error)
        echo $error;
    echo '<br><a href="addPizza.php">Go Back</a>';
} else {
    $pizza->update();
    header("Location: listPizza.php");
    exit();
}

?>