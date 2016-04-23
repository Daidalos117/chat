<?php

/**
 * User: romanrajchert
 * Date: 23.04.16
 * Time: 12:24
 * Project: chat
 */
class ChatManager
{

    const TABLE_NAME = "chat",
        COLUMN_MESSAGE = "message",
        COLUMN_USER = "user_ID",
        COLUMN_ROOM = "room_ID",
        COLUMN_TME = "time";


    /**
     * Returns messages based on room ID
     * @param $roomId
     * @return array
     */
    public function getMessagesByRoom($roomId){
        $dotaz = Databaze::dotaz("SELECT ".self::TABLE_NAME.".*,".UsersManager::TABLE_NAME.".".UsersManager::USERNAME_COLUMN." FROM ".self::TABLE_NAME." LEFT JOIN ".UsersManager::TABLE_NAME." ON ".self::TABLE_NAME.".".self::COLUMN_USER."=".UsersManager::TABLE_NAME.".ID WHERE ".self::COLUMN_ROOM."= ?",array($roomId));
        $data = $dotaz->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

}