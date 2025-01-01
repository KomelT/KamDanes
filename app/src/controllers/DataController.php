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
        // foreach($data as $key => $value){
        //     if(is_string($data[$key])){
        //         $data[$key] = trim($value);
        //     }

        // }
        DBKD::pushEvent($data);
    }
}