<?php
/**
 * User: romanrajchert
 * Date: 21.05.16
 * Time: 11:25
 * Project: chat
 */

$ajax = true;
$dontIncludeError = true;
require_once "../include.inc";

$roomsManager = new RoomsManager();
$rooms = $roomsManager->getRooms();

foreach($rooms as $key => $room){
    if($roomsManager->isDelete($room, $user)) {
        $rooms[$key]["delete"] = true;
    }
}
echo json_encode($rooms);