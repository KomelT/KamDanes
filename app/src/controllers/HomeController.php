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
}