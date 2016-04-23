<?php
/**
 * User: romanrajchert
 * Date: 23.04.16
 * Time: 18:26
 * Project: chat
 */
class LoggedInManager extends UsersManager{

    const TABLE_NAME = "logged_in",
        USER_COLUMN = "user_ID";


    /**
     * Add log
     * @param $userId
     * @return PDOStatement
     */
    public function loggedIn($userId){
        $query = Databaze::dotaz("INSERT INTO ".self::TABLE_NAME." (".self::USER_COLUMN.") VALUES (?)",array($userId));
        return $query;


    }



}