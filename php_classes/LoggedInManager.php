<?php
/**
 * User: romanrajchert
 * Date: 23.04.16
 * Time: 18:26
 * Project: chat
 */
class LoggedInManager extends UsersManager{

    const TABLE_NAME = "logged_in",
        USER_COLUMN = "user_ID",
        TIME_COLUMN = "time";


    /**
     * Add log
     * @param $userId
     * @return PDOStatement
     */
    public function loggedIn($userId){
        $query = Databaze::dotaz("INSERT INTO ".self::TABLE_NAME." (".self::USER_COLUMN.") VALUES (?)",array($userId));
        return $query;

    }

    /**
     * Returns actually logged users
     * @return array
     */
    public function getLoggedUsers(){
        $query = Databaze::dotaz("SELECT ".self::USER_COLUMN." AS ID,".parent::TABLE_NAME.".".parent::USERNAME_COLUMN."
            FROM ".self::TABLE_NAME."
            LEFT JOIN ".parent::TABLE_NAME."
            ON ".self::TABLE_NAME.".".self::USER_COLUMN."=".parent::TABLE_NAME.".ID
            WHERE ".self::TIME_COLUMN."  >= NOW() - INTERVAL 1 MINUTE
            GROUP BY ".self::USER_COLUMN."

        " );
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    public function flush(){

        $query = Databaze::dotaz("DELETE FROM ".self::TABLE_NAME." WHERE ".self::TIME_COLUMN."  < NOW() - INTERVAL 1 DAY
        " );
        return $query;
    }

}