<?php
require_once("model/DBKD.php");
require_once("ViewHelper.php");
class DataController
{
    public static function getEventJson()
    {
        ViewHelper::returnJson(DBKD::getJSONEvents());
    }

    public static function pushEvent(){
        $data = json_decode(file_get_contents('php://input'), true);
        // foreach($data as $key => $value){
        //     if(is_string($data[$key])){
        //         $data[$key] = trim($value);
        //     }

        // }
        DBKD::pushEvent($data);
    
    
    }

    


}