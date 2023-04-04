<?php

    require_once("topping.php");

    $toppingData = array_filter($_POST);
    $topping = new Topping(array_merge([
        "ToppingName"=> "",
        "ToppingDescription"=> "",
        ],$toppingData));
    
    if(count($topping->getErrors())>0){
        foreach($topping->getErrors() as $error)
            echo $error;
        echo '<br><a href="insertToppings.php">Go Back</a>';
    } else {
        $topping-> insert();
        header("Location: listTopping.php");
        exit();
    }
            
?>
























