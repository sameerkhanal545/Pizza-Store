<?php
    // redirectIfLoggedIn();]
    require_once("account.php");
    $errors=[];
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
         $loginData = array_filter($_POST);

        $account = new Account(array_merge([
     
        "Email"=> "",
        "Password"=> "",
       
        ],$loginData));
        
        if(empty($account->getErrors())){
       if($account->login())
       {
            header("Location: ../products/products.php");
            exit();
       }else{
            $errors[]="<h3>Login Failed.</h3>";
       }
        }
        
        // if(empty($_POST["email"]))
        // {
        //     $errors[]="<h3>Please enter a valid email.</h3>";
        // }
        // else if(empty($_POST["password"]))
        // {
        //     $errors[]="<h3>Please enter a password.</h3>";
        // }
        // else
        // {
        //     if(login($_POST["email"],$_POST["password"]))
        //     {
        //         // $errors[]="<h3>Login Successful.</h3>";
        //         redirectIfLoggedIn();
        //         exit();
        //     }
        //     else
        //     {
        //         $errors[]="<h3>Login Failed.</h3>";
        //     }
        // }
    }
?>

















