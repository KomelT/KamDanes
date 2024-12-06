<?php
require_once("DBInnit.php");
class DBKD
{
    public static function registerUser($username, $password)
    {

        if (self::checkUsername($username)) {
            $db = DBInit::getInstance();
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $statement = $db->prepare("INSERT INTO users 
                (username,password) VALUES (:username, :password)");

            $statement->bindParam(":username", $username, PDO::PARAM_STR);
            $statement->bindParam(":password", $hashed_password, PDO::PARAM_STR);
            return $statement->execute();


        } else {
            //return to page let the user know account exists
            return false;
        }

    }
    public static function checkUsername($username)
    {
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM users WHERE username = :username");
        $statement->bindParam(":username", $username, PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch();
        if ($user) {
            return false;
        } else {
            return true;
        }
    }
    public static function checkLogin($username, $password)
    {
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM users WHERE username = :username");
        $statement->bindParam(":username", $username, PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch();
        if ($user) {
            if (password_verify($password, $user["password"])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public static function getJSONEvents()
    {
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM event");
        $statement->execute();
        $events = $statement->fetchAll();
        return json_encode($events);
    }
    public static function pushEvent($data){
        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO event VALUES(:name, :organisation, :artist, :from, :to, :x, :y, :time, :age, :desc, :price, :type, :online);");
        $statement->bindParam(":organisation", $data["organisation"], PDO::PARAM_STR);
        $statement->bindParam(":artist", $data["artist"], PDO::PARAM_STR);
        $statement->bindParam(":from", $data["from"], PDO::PARAM_STR);
        $statement->bindParam(":to", $data["to"], PDO::PARAM_STR);
        $statement->bindParam(":x", $data["x"], PDO::PARAM_STR);
        $statement->bindParam(":y", $data["y"], PDO::PARAM_STR);
        $statement->bindParam(":time", $data["time"], PDO::PARAM_STR);
        $statement->bindParam(":age", $data["age"], PDO::PARAM_INT);
        $statement->bindParam(":desc", $data["description"], PDO::PARAM_STR);
        $statement->bindParam(":price", $data["price"], PDO::PARAM_INT);
        $statement->bindParam(":type", $data["type"], PDO::PARAM_INT);
        $statement->bindParam(":online", $data["online"], PDO::PARAM_INT);
        

        $statement->execute();
    }


}
