<?php
/**
 * User: romanrajchert
 * Date: 22.04.16
 * Time: 15:01
 * Project: chat
 */

$ajax = true;
require_once "../include.inc";
$roomsManager = new RoomsManager();
$rooms = $roomsManager->getRooms();

var_dump($rooms);