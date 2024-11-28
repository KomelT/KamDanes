<?php
require_once("model/DBKM.php");
require_once("ViewHelper.php");
Class HomeController{
    public static function home(){
        ViewHelper::render("views/home.php");
    }
    public static function login(){
        ViewHelper::render("views/login.php");
    }
    public static function register(){
        ViewHelper::render("views/register.php");
    }
}