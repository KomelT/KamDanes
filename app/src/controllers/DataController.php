<?php
require_once("model/DBKD.php");
require_once("ViewHelper.php");
class DataController
{
    public static function getEventJson()
    {

        $data = $_SERVER["QUERY_STRING"] ?? "";
        $query = explode('&', $data);
        ViewHelper::returnJson(DBKD::getJSONEvents($query));
    }

    public static function pushEvent()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        DBKD::pushEvent($data);
    }
    public static function getAllEvents()
    {
        ViewHelper::returnJson(DBKD::getAllEvents());
    }
    public static function getOnlineEvents(){
        ViewHelper::returnJson(DBKD::getOnlineEvents());
        
    }

    public static function pushEventForm($data){
        DBKD::pushEvent($data);
    }
    public static function getEventDetail($id){
        ViewHelper::returnJson(DBKD::getEventDetail($id));
    }
    public static function getEventsUser($id){

        ViewHelper::returnJson(DBKD::getEventsUser($id));
    }
    public static function updateEvent($id,$role){
        $data = json_decode(file_get_contents('php://input'), true);

        if($_SESSION["id"] != $data["id_user"] || $role != 0){
            header("HTTP/1.1 403 Forbidden");
            exit();
            
        }
        if(DBKD::updateEvent($id,$data)){
            header("HTTP/1.1 200 OK");
            exit();
        }
        header("HTTP/1.1 500 Internal Server Error");
        exit();
    }
    public static function deleteEvent($id,$uid){
        if(!DBKD::isEventUser($id,$uid)){
            header("HTTP/1.1 404 Not Found");
            exit();
        }
        
        
        if(DBKD::deleteEvent($id)){
            header("HTTP/1.1 200 OK");
            exit();
        }
        header("HTTP/1.1 500 Internal Server Error");
        exit();


    }

}