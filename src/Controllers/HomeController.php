<?php

namespace App\Controllers;

use App\Models\Post;

class HomeController
{
  public function index()
  {
    if (isset($_SESSION["user"])) {
      if (isset($_POST['post'])) {
        $post = htmlspecialchars($_POST['post']);
        $user_id = $_SESSION['user']['idUser'];
        $created_at = date('Y-m-d');
        $post = new Post(null, $post, null, $created_at, null, $user_id);
        $post->addPost();
      }
      require_once(__DIR__ . '/../Views/home.view.php');
    } else {
      require_once(__DIR__ . "/../Views/security/register.view.php");
    }
  }
}
