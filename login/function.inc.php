<?php

require_once("../db/dbhelper.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function logout()
{
    $_SESSION = [];
    session_destroy();
    setCookie("PHPSESSID", '', time() - 3600, '/', 0, 0);
}

function redirectIfLoggedIn()
{
    if (!empty($_SESSION["CustomerID"])) {
        header("Location: ../products/products.php");
    }
}
function redirectIfNotLoggedIn()
{
    if (empty($_SESSION["CustomerID"])) {
        header("Location: /");
    }
}