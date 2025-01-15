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
    public static function updateEvent($id,$data){
        /*if($_SESSION["id"] != $uid && $role != 0){
            header("HTTP/1.1 403 Forbidden");
            exit();
            
        }*/
        
        if(DBKD::updateEvent($id,$data)){
            header("HTTP/1.1 200 OK");
            exit();
        }
        header("HTTP/1.1 500 Internal Server Error Ni update uspel ");
            echo json_encode(array('error' => 'Error updating event', 'data' => $data));
        exit();
    }
    public static function deleteEvent($id,$uid,$role){
        if(!DBKD::isEventUser($id,$uid) && $role != 0){

            header("HTTP/1.1 404 " . (DBKD::isEventUser($id,$uid) or $role != 0));

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