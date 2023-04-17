<?php

    require_once("pizza.php");
    $pizzaData = array_filter($_POST);
    $pizza = new Pizza(array_merge([
        "PizzaName"=> "",
        "PizzaDescription"=> "",
        "PizzaPrice" => "",
        "PizzaSize" => "",
        ],$pizzaData));
        $pizza->setPizzaImage($_FILES["PizzaImage"]);
    if(count($pizza->getErrors(false))>0){
        foreach($pizza->getErrors(false) as $error)
            echo $error;
        echo '<br><a href="addPizza.php">Go Back</a>';
    } else {
        $pizza-> insert();
        header("Location: listPizza.php");
        exit();
    }
            
?>