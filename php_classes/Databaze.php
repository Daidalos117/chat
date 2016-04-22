<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 29. 3. 2015
 * Time: 15:42
 */

class Databaze {

    private static $spojeni;

    private static $nastaveni = Array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //na produkcnim serveru vypnout !!
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" //nastavuje utf - 8
    );


    public static function pripoj($host, $uzivatel, $heslo, $databaze) {
        if (!isset(self::$spojeni)) {
            self::$spojeni = @new PDO(
                "mysql:host=$host;dbname=$databaze",
                $uzivatel,
                $heslo,
                self::$nastaveni
            );
        }
        return self::$spojeni;
    }

    public static function dotaz($sql, $parametry = array()) {
        $dotaz = self::$spojeni->prepare($sql);
        $dotaz->execute($parametry);
        return $dotaz;
    }

}