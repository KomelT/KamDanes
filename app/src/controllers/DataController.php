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
}