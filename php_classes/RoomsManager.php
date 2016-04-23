<?php

/**
 * User: romanrajchert
 * Date: 22.04.16
 * Time: 16:00
 * Project: chat
 */
class RoomsManager
{
    const TABLE_NAME = "rooms",
            COLUMN_NAME = "name",
            COLUMN_USER = "creator_ID",
            COLUMN_PRIVATE = "private";


    /**
     * @return array
     */
    public function getRooms(){

       $dotaz = Databaze::dotaz("SELECT * FROM ".self::TABLE_NAME."; ");
        return $dotaz->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * @param $id
     * @return mixed
     */
    public function getRoom($id){
        $dotaz = Databaze::dotaz("SELECT * FROM ".self::TABLE_NAME." WHERE ID = ?",array($id));
        return $dotaz->fetch(PDO::FETCH_ASSOC);
    }
}