<?php
require_once("model/DBKD.php");
require_once("ViewHelper.php");
use Dotenv\Dotenv as Dotenv;

class HomeController
{
    public static function home()
    {
        ViewHelper::render("view/index/index.php");
    }
    public static function login()
    {
        ViewHelper::render("view/login.php");
    }
    public static function register()
    {
        ViewHelper::render("view/register.php");
    }
    public static function reset(){
        ViewHelper::render("view/reset.php");
    }
    public static function admin(){
        if(!self::checkAccess()){
            ViewHelper::render("view/index/index.php",["error"=>"Nimate pravice"]);
            exit(0);
        }
        
        ViewHelper::render("view/adminpage/index.php");
    }
    public static function adminEvents(){
        if(!self::checkAccess()){
            ViewHelper::render("view/index/index.php",["error"=>"Nimate pravice"]);
            exit(0);
        }
        
        ViewHelper::render("view/adminpage/events.php");
    }
    public static function adminUsers(){
        if(!self::checkAccess()){
            ViewHelper::render("view/index/index.php",["error"=>"Nimate pravice"]);
            exit(0);
        }
        
        ViewHelper::render("view/adminpage/users.php");
    }
    private static function checkAccess(){
        if(isset($_SESSION["username"]) && isset($_SESSION["role"]) && $_SESSION["role"] == 0){
            return true;
        }
        return false;
    }

    public static function addEventForm($update){
        
        $name = NULL;
        if(isset($_POST["name"])){
            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
        }

        $organisation = NULL;
        if(isset($_POST["organisation"])){
            $organisation = filter_input(INPUT_POST, "organisation", FILTER_SANITIZE_SPECIAL_CHARS);
        }
        
        $artist_name = NULL;
        if(isset($_POST["artist_name"])){
            $artist_name = filter_input(INPUT_POST, "artist_name", FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if(isset($_POST["date_from"])){
            $date_from = filter_input(INPUT_POST, "date_from", FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if(isset($_POST["date_to"])){
            $date_to = filter_input(INPUT_POST, "date_to", FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if(isset($_POST["online"])){
            $online = filter_input(INPUT_POST, "location", FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if(isset($_POST["street"])){
            $street = filter_input(INPUT_POST, "street", FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if(isset($_POST["city"])){
            $city = filter_input(INPUT_POST, "city", FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if(isset($_POST["zip"])){
            $zip = filter_input(INPUT_POST, "zip", FILTER_SANITIZE_SPECIAL_CHARS);
        }

        $address = $street . ", " . $city . "," . $zip;

        if(isset($_POST["time_from"])){
            $time_from = filter_input(INPUT_POST, "time_from", FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if(isset($_POST["time_to"])){
            $time_to = filter_input(INPUT_POST, "time_to", FILTER_SANITIZE_SPECIAL_CHARS);
        }
        
        $age_lim = NULL;
        if(isset($_POST["age_lim"])){
            $age_lim = filter_input(INPUT_POST, "age_lim", FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if(isset($_POST["description"])){
            $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);
        }

        $price = NULL;
        if(isset($_POST["price"])){
            $price = filter_input(INPUT_POST, "price", FILTER_SANITIZE_SPECIAL_CHARS);
        }
        
        if(isset($_POST["type"])){
            $type = filter_input(INPUT_POST, "type", FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if(isset($_POST["link"])){
            $link = filter_input(INPUT_POST, "link", FILTER_SANITIZE_SPECIAL_CHARS);
        }

        $online = NULL;
        if(isset($_POST["online"])){
            $online = filter_input(INPUT_POST, "online", FILTER_SANITIZE_SPECIAL_CHARS);
        }
        
        $coordinates = HomeController::getCoordinates($address);
        
        
      
        $data = [
            "id_user" => $_SESSION['id'],
            "name" => $name,
            "organisation" => $organisation,
            "artist_name" => $artist_name,
            "date_from" => $date_from == "" ? NULL : $date_from,
            "date_to" => $date_to == "" ? NULL : $date_to,
            "loc_x" => $coordinates[1],
            "loc_y" => $coordinates[0],
            "time_from" => $time_from,
            "time_to" => $time_to,
            "age_lim" => $age_lim,
            "description" => $description, 
            "price" => $price,
            "type" => $type,
            "link" => $link,
            "online" => $online,
        ];
        
        
        if($update){
           ob_start();
            DataController::updateEvent($_POST["id"],$data);
            
            ob_flush();

            //ViewHelper::returnJson(json_encode($data));
            exit();
        }else{
            
            DataController::pushEventForm($data);
            ViewHelper::redirect("index.php");
        }
        
    }

    private static function getCoordinates($address){
        $google_api_key = getenv(('GoogleMapsKey'));
        $formatted_address = str_replace(' ', '+', $address);
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $formatted_address . "&key=" . $google_api_key;
        $geocodeFromAddr = file_get_contents($url);

        $apiResponse = json_decode($geocodeFromAddr);

        if (isset($apiResponse->results[0]->geometry->location->lat)) {
            $latitude  = $apiResponse->results[0]->geometry->location->lat;
            $longitude = $apiResponse->results[0]->geometry->location->lng;
            return [$latitude, $longitude];
        }

        return [null, null];
    }
}