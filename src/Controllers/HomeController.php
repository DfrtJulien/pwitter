<?php

namespace App\Controllers;

use App\Models\Post;

class HomeController
{
  public function index()
  {
    if (isset($_SESSION["user"])) {
      $user_id = $_SESSION['user']['user_id'];

      // ajouter un post
      if (isset($_POST['post'])) {
        $post = htmlspecialchars($_POST['post']);
        $created_at = date('Y-m-d');
        $post = new Post(null, $post, null, $created_at, null, $user_id);
        $post->addPost();
        header("Location: " . "/");
        exit();
      }

      // affichage de mes post
      $post = new Post(null, null, null, null, null, $user_id);
      $posts = $post->showPosts();


      require_once(__DIR__ . '/../Views/home.view.php');
    } else {
      require_once(__DIR__ . "/../Views/security/register.view.php");
    }
  }
}
