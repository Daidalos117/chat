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
if(mb_strlen($room) > 20) {
    echo json_encode( array("error" => "To long") );
    die();
}


echo $insert;
try{
    $insert = $roomsManager->addRoom($room,$user["ID"]);

    echo json_encode( $insert );
}catch(Exception  $e){
    echo json_encode( array("error" => $e) );
}

