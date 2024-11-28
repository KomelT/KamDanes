<?php
require_once("model/DBKD.php");
require_once("ViewHelper.php");
Class UserController{
    public static function registerUser($username,$password){
        DBKD::registerUser($username,$password);

    
    }
    public static function loginUser($username,$password){
        if(DBKD::checkLogin($username,$password)){
            $_SESSION["username"] = $username;
            ViewHelper::redirect("index.php");
        }
    }
    public static function logout(){
        unset($_SESSION["username"]);
        ViewHelper::redirect("index.php");
    }
}