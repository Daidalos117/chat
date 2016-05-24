<?php
/**
 * User: romanrajchert
 * Date: 22.04.16
 * Time: 15:56
 * Project: chat
 */
class UsersManager {

    const TABLE_NAME = "users",
        USERNAME_COLUMN = "username",
        PASSWORD_COLUMN = "password",
        ROLE_COLUMN = "role_ID",
        LOGIN_HASH_COLUMN = "login_hash",
        ADMIN = 0,
        USER = 1,
        SALT = "1j9/32";


    /**
     * Is user exists?
     * @param $username
     * @return bool
     */
    public function userExist($username){

        $users = Databaze::dotaz("SELECT * FROM ".self::TABLE_NAME." WHERE ".self::USERNAME_COLUMN." = ? ",array($username));
        $users = $users->fetchAll();
        if($users) return true;
        else return false;

    }

    /**
     * Adds user to DB
     * @param $params
     * @return bool
     */
    public function addUser($params){

        $params[1] = password_hash($params[1],PASSWORD_DEFAULT);
        $loginHash = sha1($params[0].self::SALT.$params[1]);
        $params[2] = $loginHash;
        $users = Databaze::dotaz("INSERT INTO ".self::TABLE_NAME." (".self::USERNAME_COLUMN.", ".self::PASSWORD_COLUMN.",".self::ROLE_COLUMN.",".self::LOGIN_HASH_COLUMN." )
        VALUES (?,?,".self::USER.",?)",$params);
        return true;
    }

    /**
     * Logins user
     * @param $user
     * @param $pass
     * @return bool|mixed|PDOStatement
     */
    public function login($user,$pass){


        $user = Databaze::dotaz("SELECT * FROM ".self::TABLE_NAME." WHERE ".self::USERNAME_COLUMN." = ?",array($user));
        $user = $user->fetch(PDO::FETCH_ASSOC);

        if($user){
            $rightPass = password_verify($pass,$user[self::PASSWORD_COLUMN]);
            if($rightPass){
                return $user;
            }
        }

        return false;

    }

    /**
     * Returns user info based on login hash
     * @param $hash
     * @return mixed|PDOStatement
     */
    public function getUserByHash($hash){
        $user = Databaze::dotaz("SELECT * FROM ".self::TABLE_NAME." WHERE ".self::LOGIN_HASH_COLUMN." = ?",array($hash));
        $user = $user->fetch(PDO::FETCH_ASSOC);
        return $user;

    }

}