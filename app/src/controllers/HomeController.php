<?php
require_once("model/DBKD.php");
require_once("ViewHelper.php");
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
}