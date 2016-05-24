<?php
/**
 * Ajax page for getting logged users
 * User: romanrajchert
 * Date: 23.04.16
 * Time: 18:46
 * Project: chat
 */

$ajax = true;
$dontIncludeError = true;
require_once "../include.inc";

$logMan = new LoggedInManager();

$logged = $logMan->getLoggedUsers();

echo json_encode($logged);