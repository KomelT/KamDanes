<?php
require_once("DBInnit.php");
class DBKD
{
    public static function registerUser($username, $password, $email,$role)
    {

        if (!self::checkUsername($username)) {
            $db = DBInit::getInstance();
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $statement = $db->prepare("INSERT INTO user
                (username,password,email,name,phone,role, disabled) VALUES (:username, :password,:email,:username,'123',:role,'0')");

            $statement->bindParam(":username", $username, PDO::PARAM_STR);
            $statement->bindParam(":password", $hashed_password, PDO::PARAM_STR);
            $statement->bindParam(":email", $email, PDO::PARAM_STR);
            $statement->bindParam(":role", $role, PDO::PARAM_INT);
            return $statement->execute();


        } else {
            //return to page let the user know account exists
            return false;
        }

    }
    public static function checkUsername($username)
    {
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM user WHERE username = :username OR email = :username");
        $statement->bindParam(":username", $username, PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch();
        if ($user) {
            return true;
        } else {
            return false;
        }
    }
    public static function checkLogin($username, $password)
    {
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM user WHERE username = :username OR email = :username");
        $statement->bindParam(":username", $username, PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch();
        if ($user) {
            return password_verify($password, $user["password"]);
        } else {

            return false;
        }
    }
    public static function getJSONEvents($query)
    {
        $db = DBInit::getInstance();

        $search = "";
        $dateFrom = date('Y-m-d', strtotime('today'));
        $dateTo = date('Y-m-d', (new DateTime('now'))->add(new DateInterval('P7D'))->getTimestamp());
        $type = "";

        foreach ($query as $key => $value) {
            $query[$key] = explode("=", $value)[0];
            if ($query[$key] == "df")
                $dateFrom = explode("=", $value)[1];
            if ($query[$key] == "dt")
                $dateTo = explode("=", $value)[1];
            if ($query[$key] == "q")
                $search = explode("=", $value)[1];
            if ($query[$key] == "type")
                $type = urldecode(explode("=", $value)[1]);
        }

        $statement = $db->prepare("
            SELECT * 
            FROM event 
            WHERE (name LIKE :search OR description LIKE :search)
            AND date_from IS NOT NULL
            AND date_from >= :dateFrom 
            AND date_from <= :dateTo 
            AND FIND_IN_SET(type, :type) > 0
        ");
        $search = "%" . $search . "%";
        $statement->execute([
            ":search" => $search,
            ":dateFrom" => $dateFrom,
            ":dateTo" => $dateTo,
            ":type" => $type
        ]);
        $events = $statement->fetchAll();
        return json_encode($events);
    }
    public static function getAllEvents(){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM event WHERE  (date_to >= CURDATE() AND date_from >= CURDATE()) OR (date_to >= CURDATE() AND (date_from < CURDATE() OR date_from IS NULL)) OR (date_from >= CURDATE() AND date_to IS NULL)");
        $statement->execute();
        $events = $statement->fetchAll();
        return json_encode($events);
    }

    public static function pushEvent($data)
    {
        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO event 
            (id_user, name, organisation, artist_name, date_from, date_to, loc_x, loc_y, time_from, time_to, age_lim, description, price, type, link, online, url_hash) 
            VALUES (:id_user, :name, :organisation, :artist_name, :date_from, :date_to, :loc_x, :loc_y, :time_from, :time_to, :age_lim, :description, :price, :type, :link, :online, :url_hash);");

        $hashed_url = hash('sha512', $data["link"]);

        $statement->bindParam(":id_user", $data["id_user"], PDO::PARAM_INT);
        $statement->bindParam(":name", $data["name"], PDO::PARAM_STR);
        $statement->bindParam(":organisation", $data["organisation"], PDO::PARAM_STR);
        $statement->bindParam(":artist_name", $data["artist_name"], PDO::PARAM_STR);
        $statement->bindParam(":date_from", $data["date_from"], PDO::PARAM_STR);
        $statement->bindParam(":date_to", $data["date_to"], PDO::PARAM_STR);
        $statement->bindParam(":loc_x", $data["loc_x"], PDO::PARAM_STR);
        $statement->bindParam(":loc_y", $data["loc_y"], PDO::PARAM_STR);
        $statement->bindParam(":time_from", $data["time_from"], PDO::PARAM_STR);
        $statement->bindParam(":time_to", $data["time_to"], PDO::PARAM_STR);
        $statement->bindParam(":age_lim", $data["age_lim"], PDO::PARAM_INT);
        $statement->bindParam(":description", $data["description"], PDO::PARAM_STR);
        $statement->bindParam(":price", $data["price"], PDO::PARAM_INT);
        $statement->bindParam(":type", $data["type"], PDO::PARAM_INT);
        $statement->bindParam(":link", $data["link"], PDO::PARAM_STR);
        $statement->bindParam(":online", $data["online"], PDO::PARAM_INT);
        $statement->bindParam(":url_hash", $hashed_url, PDO::PARAM_STR);

        $statement->execute();
    }
    /**
     * @return string A JSON string containing all online events
     */
    public static function getOnlineEvents(){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM event WHERE (loc_x IS NULL) AND (loc_y IS NULL);");
        $statement->execute();
        $events = $statement->fetchAll();
        return json_encode($events);
    }
    public static function deleteEvent($id){
        $db = DBInit::getInstance();
        $statement = $db->prepare("DELETE FROM event WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement;
    }
    public static function getRole($username){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT role FROM user WHERE username = :username OR email = :username");
        $statement->bindParam(":username", $username, PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch();
        return $user["role"];
    }
    public static function getId($username){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT id FROM user WHERE username = :username;");
        $statement->bindParam(":username", $username, PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch();
        return $user["id"];
    }
    public static function getUsers(){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT id, username, email, name,role FROM user");
        $statement->execute();
        $users = $statement->fetchAll();
        return json_encode($users);
    }
    public static function getEventDetail($id){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM event WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        $event = $statement->fetch();
        return json_encode($event);
    }
    public static function deleteUser($id){
        $db = DBInit::getInstance();
        $statement = $db->prepare("DELETE FROM event WHERE id_user = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        $statement = $db->prepare("DELETE FROM user WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement;
    }
    private static function checkID($id){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM user WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        $user = $statement->fetch();
        if ($user) {
            return true;
        } else {
            return false;
        }
    }
    public static function getEventsUser($id){
        if(!self::checkID($id)){
             
            header("HTTP/1.1 412 Precondition Failed");
            exit(0);
        }
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM event WHERE id_user = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        $events = $statement->fetchAll();
        return json_encode($events);
    }
    public static function isEventUser($id,$uid){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT * FROM event WHERE id = :id AND id_user = :uid");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->bindParam(":uid", $uid, PDO::PARAM_INT);
        $statement->execute();
        $event = $statement->fetch();
        if ($event) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateEvent($id,$data){
        $db = DBInit::getInstance();  
        $statement = $db->prepare("UPDATE event
            SET 
             
            name = :name, 
            organisation = :organisation, 
            artist_name = :artist_name, 
            date_from = :date_from, 
            date_to = :date_to, 
            loc_x = :loc_x, 
            loc_y = :loc_y, 
            time_from = :time_from, 
            time_to = :time_to, 
            age_lim = :age_lim, 
            description = :description, 
            price = :price, 
            type = :type, 
            link = :link, 
            online = :online, 
            url_hash = :url_hash
            WHERE id = :id;");

        $hashed_url = hash('sha512', $data["link"]);

        //$statement->bindParam(":id_user", $data["id_user"], PDO::PARAM_INT);
        $statement->bindParam(":name", $data["name"], PDO::PARAM_STR);
        $statement->bindParam(":organisation", $data["organisation"], PDO::PARAM_STR);
        $statement->bindParam(":artist_name", $data["artist_name"], PDO::PARAM_STR);
        $statement->bindParam(":date_from", $data["date_from"], PDO::PARAM_STR);
        $statement->bindParam(":date_to", $data["date_to"], PDO::PARAM_STR);
        $statement->bindParam(":loc_x", $data["loc_x"], PDO::PARAM_STR);
        $statement->bindParam(":loc_y", $data["loc_y"], PDO::PARAM_STR);
        $statement->bindParam(":time_from", $data["time_from"], PDO::PARAM_STR);
        $statement->bindParam(":time_to", $data["time_to"], PDO::PARAM_STR);
        $statement->bindParam(":age_lim", $data["age_lim"], PDO::PARAM_INT);
        $statement->bindParam(":description", $data["description"], PDO::PARAM_STR);
        $statement->bindParam(":price", $data["price"], PDO::PARAM_INT);
        $statement->bindParam(":type", $data["type"], PDO::PARAM_INT);
        $statement->bindParam(":link", $data["link"], PDO::PARAM_STR);
        $statement->bindParam(":online", $data["online"], PDO::PARAM_INT);
        $statement->bindParam(":url_hash", $hashed_url, PDO::PARAM_STR);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);

        $statement->execute(); 
        $row_affected = $statement->rowCount();
        if ($row_affected > 0) {
            return true;
        }
        return false;

    }

}
