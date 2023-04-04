<?php

    require_once("customer.php");
    
    $errors = array();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $customerData = array_filter($_POST);

        $customer = new Customer(array_merge([
      
        "CustomerName"=> "",
        "CustomerEmail"=> "",
        "CustomerPhone"=> "",
        "CustomerAddress"=> "",
        "CustomerCity"=> "",
        "ProvinceID"=> "",
        ],$customerData));
        
        if(empty($customer->getErrors())){
        $customer->insert();
            header("Location: listScooter.php");
            exit();
        } else {
            session_start();
            $_SESSION['errors'] = $customer->getErrors();
            $_SESSION['customerData'] = $customerData;
            header("Location: addCustomer.php");
            exit();
    }
           
} 
        
        function trimmedSpecialCharsInput($input){
          $input = trim($input);
          $input = htmlspecialchars($input);
          return $input;
      }
      
       function checkEmpty($input){
          if(empty(trimmedSpecialCharsInput($input)))
              return true;
          else
             return false;
    }
    
       function checkNumber($input){
           if (is_numeric(trimmedSpecialCharsInput($input)) == '1'){
            return true;
           }else {
            return false;
           }
        }

?>
















































































































