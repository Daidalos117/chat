<?php
/**
 * User: romanrajchert
 * Date: 22.04.16
 * Time: 15:01
 * Project: chat
 */

mb_internal_encoding("UTF-8");

function nactiTridu($trida)
{
    require("php_classes/$trida.php");
}

spl_autoload_register("nactiTridu");

\php_error\reportErrors();

Databaze::pripoj('localhost', 'root', 'root', 'chat');
