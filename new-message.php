<?php
/**
 * User: romanrajchert
 * Date: 23.04.16
 * Time: 13:34
 * Project: chat
 */
$dontIncludeError = true;
 require_once "include.inc";


$userManager = new UsersManager();
$user = $userManager->getUserByHash($_SESSION["ID"]);


$chatManager = new ChatManager();
$message = strip_tags($_POST["message"]);
try{
    $insert = $chatManager->addMessage($message,$user["ID"],$_POST["room"]);
    $mm = array("message" => $message, "ID" => $insert , "username" => $user[UsersManager::USERNAME_COLUMN]);
    echo json_encode( $mm );
}catch(Exception  $e){
    echo json_encode( array("error" => $e) );
}


