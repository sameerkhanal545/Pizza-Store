<?php
// redirectIfLoggedIn();]
require_once("account.php");
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $loginData = array_filter($_POST);

     $account = new Account(array_merge([

          "Email" => "",
          "Password" => "",

     ], $loginData));

     if (empty($account->getErrors())) {
          if ($account->login()) {
               header("Location: ../products/products.php");
               exit();
          } else {
               session_start();
               session_regenerate_id();
               $_SESSION["Error"] = "Username Or password did not match";
               header("Location: /");
               exit();
          }
     }
}
?>