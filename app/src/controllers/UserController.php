<?php
require_once("model/DBKD.php");
require_once("ViewHelper.php");
class UserController
{
    public static function registerUser($username, $password,$email)
    {
        DBKD::registerUser($username, $password,$email);
        ViewHelper::redirect("index.php?register=true");


    }
    public static function loginUser($username, $password)
    {
        if(!(DBKD::checkUsername($username))){
            
            ViewHelper::render("view/login.php",["error"=>"Uporabnik ne obstaja"]);
            exit(0);
        }
        $result = DBKD::checkLogin($username, $password);
        
        if ($result) {
            $_SESSION["username"] = $username;
            $_SESSION["role"] = DBKD::getRole($username);
            ViewHelper::redirect("index.php");
            
        }
        ViewHelper::render("view/login.php",["error"=>"Napačno geslo"]);
        exit(0);
    }
    public static function logout()
    {
        unset($_SESSION["username"]);
        unset($_SESSION["role"]);
        ViewHelper::redirect("index.php");
    }
}