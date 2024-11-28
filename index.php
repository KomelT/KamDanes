<?php

session_start();

require_once("controllers/HomeController.php");
require_once("controllers/UserController.php");
require_once("controllers/DataController.php");


define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("ASSETS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "bootstrap/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls = [
   "/" => function () {
      HomeController::home();
   },
    # routing
    "index.php" => function () {
      HomeController::home();
   },
    "" => function () {
       HomeController::home();
    },
     "login" => function () {
        HomeController::login();
     },
     "register" => function () {
        HomeController::register();
     },
     "registerUser" => function () {
      UserController::registerUser($_POST["username"],$_POST["password"]);
     },
     "loginUser" => function () {
      UserController::loginUser($_POST["username"],$_POST["password"]);
     },
     "logout" => function () {
      UserController::logout();
     },
     
     
];

try {
    if (isset($urls[$path])) {
       $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
    // ViewHelper::error404();
} 