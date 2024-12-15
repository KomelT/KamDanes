<?php
require_once("model/DBKD.php");
require_once("ViewHelper.php");
class UserController
{
    public static function registerUser($username, $password,$email)
    {
        DBKD::registerUser($username, $password,$email);
        ViewHelper::redirect("index.php");


    }
    public static function loginUser($username, $password)
    {
        $result = DBKD::checkLogin($username, $password);
        
        if ($result) {
            $_SESSION["username"] = $username;
            ViewHelper::redirect("index.php");
            
        }
        ViewHelper::redirect("login");
    }
    public static function logout()
    {
        unset($_SESSION["username"]);
        ViewHelper::redirect("index.php");
    }
}