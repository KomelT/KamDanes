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
      UserController::registerUser($_POST["username"], $_POST["password"], $_POST["email"],1);
   },
   "registerUserAdmin" => function () {
      UserController::registerUser($_POST["username"], $_POST["password"], $_POST["email"], $_POST["role"]);
   },
   "loginUser" => function () {
      UserController::loginUser($_POST["username"], $_POST["password"]);
   },
   "deleteUser" => function () {
      UserController::deleteUser($_POST["id"], $_POST["role"]);
   }
   ,"logout" => function () {
      UserController::logout();
   },
   "API/events" => function () {
      DataController::getEventJson();
   },

   "API/pushEvent" => function () {
      DataController::pushEvent();
   },

   "API/events/all" => function () {
      DataController::getAllEvents();
   },
   "API/events/user" => function () {
      DataController::getEventsUser($_POST["id"]);
   },
  
   "reset" => function () {
      HomeController::reset();
   },
   "API/events/online" => function () {
      DataController::getOnlineEvents();
   },
   'admin' => function () {
      HomeController::admin();
   },
   'adminevents' => function () {
      HomeController::adminEvents();
   },
   'adminusers' => function () {
      HomeController::adminUsers();

   }, 'addEventForm' => function () {
      HomeController::addEventForm(false);
   },
    'API/users/getUsers' => function () {
      UserController::getUsers();
   },
    'API/events/eventDetail' => function () {
      DataController::getEventDetail($_POST["id"]);
   },
   'API/events/delete' => function () {
      DataController::deleteEvent($_POST["id"],$_SESSION["id"],$_SESSION["role"]);
   },
   'updateEvents' => function () {
     
      HomeController::addEventForm(true);
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
   ViewHelper::error404();
}


