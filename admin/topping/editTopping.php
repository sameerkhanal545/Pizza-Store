<?php
    require('topping.php');

    $error = null;
    if(!empty($_GET['topping_id'])){
        $topping_id = $_GET['topping_id'];
    } else {
        $topping_id = null;
        $error = "<p> Error! Topping Id not recieved.";
    }

    if($error == null){
        
        $topping = new Topping();
        
        $topping->find($topping_id);
    } else {
        echo $error;
    }

?>

<!DOCTYPE html>
<html>
    <body>
        <form class="form" action="update.php" method="POST">
            <h1>Please enter Topping for Pizza<br></h1>
            
            <input type="hidden" class="input" id="ToppingID" name="ToppingID" value="<?php echo $topping->getToppingID() ??'' ?>"/>
            
            <label for="ToppingName" class="placeholder">Name</label>
            <input type="text" class="input" id="ToppingName" name="ToppingName"value="<?php echo $topping->getToppingName() ??'' ?>" />
            <br>
             <label for="ToppingDescription" class="placeholder">Description</label>
            <input type="text" class="input" id="ToppingDescription" name="ToppingDescription" value="<?php echo $topping->getToppingDescription() ??'' ?>"/>
            <br>

            <button type="submit" class="submit">Add</button>
            
        </form>
    </body>
</html>



































