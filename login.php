<?php
/**
 * User: romanrajchert
 * Date: 22.04.16
 * Time: 13:23
 * Project: chat
 */

session_start();
$_SESSION["user"] = $_POST["user"];

header("Location: chat.php");