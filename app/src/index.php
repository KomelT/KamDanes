<?php

session_start();

require_once "controllers/HomeController.php";
require_once "controllers/UserController.php";
require_once "controllers/DataController.php";


define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("ASSETS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "assets/");

$path = isset($_SERVER["REQUEST_URI"]) ? trim($_SERVER["REQUEST_URI"], "/") : "/";
$path = explode("?", $path)[0];

$urls = [
   "/" => function () {
      HomeController::home();
   },
   "index.php" => function () {
      ViewHelper::redirect("/");
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
      UserController::registerUser($_POST["username"], $_POST["password"], $_POST["email"]);
   },
   "loginUser" => function () {
      UserController::loginUser($_POST["username"], $_POST["password"]);
   },
   "logout" => function () {
      UserController::logout();
   },
   "API/events" => function () {
      DataController::getEventJson();
   },

   "API/pushEvent" => function () {
      DataController::pushEvent();
   },
   "reset" => function () {
      HomeController::reset();
   }
];

try {
   if (isset($urls[$path])) {
      $urls[$path]();
   } else {
      echo "No controller for '$path'";
   }
} catch (Exception $e) {
   echo "An error occurred: <pre>$e</pre>";
   ViewHelper::error404();
}


