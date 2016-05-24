<?php
/**
 * User: romanrajchert
 * Date: 21.05.16
 * Time: 12:56
 * Project: chat
 */

$ajax = true;
$dontIncludeError = true;
require_once "../include.inc";

$id = strip_tags($_POST["id"]);
$roomsManager = new RoomsManager();
$room = $roomsManager->getRoom($id);
if(!$room) die("Cant find room");


if($roomsManager->isDelete($room,$user)) {
    $roomsManager->deleteRoom($room["ID"]);
    echo json_encode(true);
}