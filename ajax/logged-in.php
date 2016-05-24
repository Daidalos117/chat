<?php
/**
 * Ajax page for logging loged user
 * User: romanrajchert
 * Date: 23.04.16
 * Time: 18:29
 * Project: chat
 */
$ajax = true;
$dontIncludeError = true;
require_once "../include.inc";

$logMan = new LoggedInManager();

$return = $logMan->loggedIn($user["ID"]);

$logMan->flush();