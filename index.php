<?php
require "vendor/autoload.php";


require_once "Config/Router.php";

use Config\Router;

$router = new Router();

//la page d'accueil
$router->addRoute('/', 'HomeController', 'index');




$router->handleRequest();
