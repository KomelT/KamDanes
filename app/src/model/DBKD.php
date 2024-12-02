<?php
require_once("DBInnit.php");
Class DBKD{
    public static function registerUser($username, $password){
        
        if(self::checkUsername($username)){
            $db = DBInit::getInstance();
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $statement = $db->prepare("INSERT INTO users 
                (username,password) VALUES (:username, :password)");

            $statement->bindParam(":username", $username, PDO::PARAM_STR);
            $statement->bindParam(":password", $hashed_password, PDO::PARAM_STR);
            return $statement->execute();
            
          
        }else{
            //return to page let the user know account exists
            return false;
        }
    
    }
    public static function checkUsername($username){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM users WHERE username = :username");
        $statement->bindParam(":username", $username, PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch();
        if($user){
            return false;
        }else{
            return true;
        }
    }
    public static function checkLogin($username, $password){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM users WHERE username = :username");
        $statement->bindParam(":username", $username, PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch();
        if($user){
            if(password_verify($password, $user["password"])){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public static function getJSONEvents(){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM events");
        $statement->execute();
        $events = $statement->fetchAll();
        return json_encode($events);
    }


}
