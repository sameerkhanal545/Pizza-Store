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
<!doctype html>
<html>
    <body>
        <form method="POST">
            <h1>Login Form</h1>
            <table>
                <tr>
                    <td>Email</td>
                    <td><input name="Email"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="Password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="Login" style="width:100%">
                    </td>
                </tr>
            </table>
            <?php
                foreach($errors as $error)
                    echo $error;
            ?>
        </form>
    </body>
</html>
















