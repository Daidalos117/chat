<?php
/**
 * User: romanrajchert
 * Date: 22.04.16
 * Time: 17:07
 * Project: chat
 */



mb_internal_encoding("UTF-8");

function nactiTridu($trida)
{
    require("php_classes/$trida.php");
}

spl_autoload_register("nactiTridu");



Databaze::pripoj('localhost', 'root', 'root', 'chat');



$username = $_POST["username"];
$password = $_POST["pass"];



$userManager = new UsersManager();
$exists = $userManager->userExist( $username );

if($exists){
    echo json_encode(["error" => "User with this username already exists."]);
    die();
}

if(strlen($password) < 6){
    echo json_encode(["error" => "Please choose stronger password."]);
    die();
}

$add = $userManager->addUser([$username,$password]);

if($add === true){
    echo json_encode(["succes" => "You have been registered, please log in."]);
    die();
}