<?php

namespace App\Controllers;

class HomeController
{
  public function index()
  {
    if (isset($_SESSION["user"])) {

      require_once(__DIR__ . '/../Views/home.view.php');
    } else {
      require_once(__DIR__ . "/../Views/security/register.view.php");
    }
  }
}
