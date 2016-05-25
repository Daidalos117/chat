<?php
session_start();
mb_internal_encoding("UTF-8");



function nactiTridu($trida)
{
    $ajaxDir = (isset($ajax) && $ajax) ? "../" : "";
require($ajaxDir."php_classes/$trida.php");
}

spl_autoload_register("nactiTridu");
if(!isset($dontIncludeError)){
    require('php_classes/php_error.php' );
    php_error\reportErrors();
}


#Databaze::pripoj('localhost', 'root', 'root', 'chat');
Databaze::pripoj('wm98.wedos.net', 'a18034_chat', '7qQjgVrw', 'd18034_chat');

date_default_timezone_set("Europe/Prague");

if(!isset($turnOffSecurity)){
    $userManager = new UsersManager();
    if(!isset($_SESSION["ID"]))  {
        header("Location: index.html?error=bad");
        die();
    }
    $user = $userManager->getUserByHash($_SESSION["ID"]);
    if(!$user)   {
        header("Location: index.html?error=bad");
        die();
    }

}


?>