<?php

    require_once("pizzaPrices.php");
    $priceData = array_filter($_POST);

    echo "Size: " . $priceData['Size'] . "<br>";
    echo "Price: " . $priceData['Price'] . "<br>";
    echo "PizzaID: " . $priceData['PizzaID'] . "<br>";

    $pizzaPrice = new PizzaPrices(array_merge([
        "PizzaID"=> "",
        "Size"=> "",
        "Price"=>""
    ],$priceData));

    if(count($pizzaPrice->getErrors(true))>0){
        // foreach($pizza->getErrors(true) as $error)
        //     echo $error;
        // echo '<br><a href="addPizza.php">Go Back</a>';
    } else {
        $pizzaPrice-> create();
        header("Location: listPizza.php");
        exit();
    }


?>