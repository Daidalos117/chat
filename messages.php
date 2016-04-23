<?php
/**
 * Ajax page gets most actual messages
 * User: romanrajchert
 * Date: 23.04.16
 * Time: 16:25
 * Project: chat
 */

$dontIncludeError = true;
require_once "include.inc";

$lastMessage = $_POST["id"];
$room = $_SESSION["room"];


$chatManager = new ChatManager();

//$newMessages = $chatManager->getLastMessages($lastMessage,$room["ID"]);


if(empty($newMessages)) echo json_encode(false);
else echo json_encode($newMessages);