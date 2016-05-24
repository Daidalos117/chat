<?php
/**
 * User: romanrajchert
 * Date: 21.05.16
 * Time: 11:13
 * Project: chat
 */

$ajax = true;
$dontIncludeError = true;
require_once "../include.inc";

$roomsManager = new RoomsManager();
$room = strip_tags($_POST["new-room"]);
try{
    $insert = $roomsManager->addRoom($room,$user["ID"]);
    $mm = array("message" => $message, "ID" => $insert , "username" => $user[UsersManager::USERNAME_COLUMN]);
    echo json_encode( $mm );
}catch(Exception  $e){
    echo json_encode( array("error" => $e) );
}

