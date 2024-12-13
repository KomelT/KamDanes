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
    public static function pushEvent($data) {
        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO event 
            (id_user, name, organisation, artist_name, date_from, date_to, loc_x, loc_y, time, age_lim, description, price, type, link, online) 
            VALUES (:id_user, :name, :organisation, :artist_name, :date_from, :date_to, :loc_x, :loc_y, :time, :age_lim, :description, :price, :type, :link, :online);");
    
        // Bind each parameter, checking if it's NULL
        $statement->bindParam(":id_user", $data["id_user"], PDO::PARAM_INT);
        $statement->bindParam(":name", $data["name"], PDO::PARAM_STR);
        $statement->bindParam(":organisation", $data["organisation"], is_null($data["organisation"]) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $statement->bindParam(":artist_name", $data["artist_name"], is_null($data["artist_name"]) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $statement->bindParam(":date_from", $data["date_from"], is_null($data["date_from"]) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $statement->bindParam(":date_to", $data["date_to"], is_null($data["date_to"]) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $statement->bindParam(":loc_x", $data["loc_x"], is_null($data["loc_x"]) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $statement->bindParam(":loc_y", $data["loc_y"], is_null($data["loc_y"]) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $statement->bindParam(":time", $data["time"], is_null($data["time"]) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $statement->bindParam(":age_lim", $data["age_lim"], is_null($data["age_lim"]) ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $statement->bindParam(":description", $data["description"], is_null($data["description"]) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $statement->bindParam(":price", $data["price"], is_null($data["price"]) ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $statement->bindParam(":type", $data["type"], is_null($data["type"]) ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $statement->bindParam(":link", $data["link"], is_null($data["link"]) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $statement->bindParam(":online", $data["online"], is_null($data["online"]) ? PDO::PARAM_NULL : PDO::PARAM_INT);
    
        $statement->execute();
    }
    

}
