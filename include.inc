<?php
session_start();
mb_internal_encoding("UTF-8");

function nactiTridu($trida)
{
require("php_classes/$trida.php");
}

spl_autoload_register("nactiTridu");
if(!isset($dontIncludeError)){
    require('php_classes/php_error.php' );
    php_error\reportErrors();
}


Databaze::pripoj('localhost', 'root', 'root', 'chat');

date_default_timezone_set("Europe/Prague");

if(!isset($turnOffSecurity)){
    $userManager = new UsersManager();
    $user = $userManager->getUserByHash($_SESSION["ID"]);
    if(!isset($_SESSION["ID"]) and !$user)     header("Location: index.html?error=bad");
}


?>