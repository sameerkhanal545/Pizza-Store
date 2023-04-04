<?php

    require_once("../db/dbhelper.php");

    session_start();
    
    function login($email, $password)
    {
        global $pdo;
        $stmt=$pdo->prepare(
            "select CustomerID, PasswordHash from customers
            where CustomerEmail=:email");
        $stmt->execute([
            "email" => $email
        ]);
        
       if($stmt->rowCount()==1)
        {
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($password,$row["PasswordHash"]))
            {
                session_regenerate_id();
                $_SESSION["CustomerID"]=$row["CustomerID"];
                return true;
            }
        }
        return false;
    }
    
    function logout()
    {
        $_SESSION = [];
        session_destroy();
        setCookie("PHPSESSID",'',time()-3600,'/',0,0);
    }
    
    function redirectIfLoggedIn()
    {
        if(!empty($_SESSION["CustomerID"]))
        {
            header("Location: welcome.php");
        }
    }
      function redirectIfNotLoggedIn()
    {
        if(empty($_SESSION["CustomerID"]))
        {
            header("Location: login.php");
        }
    }







