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

$router->addRoute('/profile', "UserController", "index");

$router->addRoute('/post', "PostController", "index");
$router->addRoute('/test', "HomeController", "getPost");
$router->addRoute('/getMessage', "HomeController", "getMessage");
$router->addRoute('/search', "SearchController", "search");
$router->addRoute('/message', "MessageController", "message");

$router->handleRequest();
