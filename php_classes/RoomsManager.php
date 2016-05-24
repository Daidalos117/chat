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

        $query = Databaze::dotaz("SELECT * FROM ".self::TABLE_NAME."; ");
        return $query->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * Gets room by ID
     * @param $id
     * @return mixed
     */
    public function getRoom($id){
        $query = Databaze::dotaz("SELECT * FROM ".self::TABLE_NAME." WHERE ID = ?",array($id));
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Adds room
     * @param $room
     * @param $userId
     * @return string
     * @throws Exception
     */
    public function addRoom($room, $userId){
        $query = Databaze::dotaz("INSERT INTO ".self::TABLE_NAME." VALUES (0,?,?,0)",[$room, $userId]);
        if($query) throw new Exception("New room cant be added");
        else return Databaze::getLastID();
    }

    /**
     * Deletes the room
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function deleteRoom($id){
        $query = Databaze::dotaz("DELETE FROM ".self::TABLE_NAME." WHERE ID=?",[$id]);
        if($query) return true;
        else throw new Exception();
    }


    public function isDelete($room, $user){
        if($room[RoomsManager::COLUMN_USER] == $user["ID"] or $user[UsersManager::ROLE_COLUMN] == UsersManager::ADMIN) {
            if($room["ID"] != 1) return true;
        }
        return false;
    }
}