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
        $data = json_decode(file_get_contents('php://input'), true); //reads the whole requesst body
        foreach($data as $key => $value){
            $data[$key] = trim($value);

        }
        DBKD::pushEvent($data);
    
    
    }

    


}