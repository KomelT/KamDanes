<?php
require_once("model/DBKD.php");
require_once("ViewHelper.php");
Class DataController{
    public static function getEventJson(){
        ViewHelper::returnJson(DBKD::getJSONEvents());
    }

}