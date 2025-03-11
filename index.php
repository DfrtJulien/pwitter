<?php
require "vendor/autoload.php";
session_start();

require_once "Config/Router.php";

use Config\Router;

$router = new Router();

//la page d'accueil
$router->addRoute('/', 'HomeController', 'index');

$router->addRoute('/register', "ConnexionController", "index");
$router->addRoute('/logout', "ConnexionController", "logout");



$router->handleRequest();
