<?php
/**
 * User: romanrajchert
 * Date: 22.04.16
 * Time: 13:23
 * Project: chat
 */

session_start();



mb_internal_encoding("UTF-8");

function nactiTridu($trida)
{
    require("php_classes/$trida.php");
}

spl_autoload_register("nactiTridu");



Databaze::pripoj('localhost', 'root', 'root', 'chat');



$username = $_POST["user"];
$password = $_POST["pass"];



$userManager = new UsersManager();

$user = $userManager->login($username,$password);
if($user){
    $_SESSION["user"] = $user[UsersManager::USERNAME_COLUMN];
    $_SESSION["ID"] = $user["ID"];
    header("Location: chat.php");
}else{
    header("Location: index.html?error=bad");
}

