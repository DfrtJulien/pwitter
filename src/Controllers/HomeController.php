<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Follow;

class HomeController
{
  public function index()
  {
    if (isset($_SESSION["user"])) {
      $user_id = $_SESSION['user']['user_id'];
      $user = new User($user_id, null, null, null, null, null, null);
      $users = [];

      while (count($users) < 3) {
        $isUserFollowed = $user->showOtherUser();
        foreach ($isUserFollowed as $userToFollow) {
          if (count($users) >= 3) {
            break;
          }
          $id_user_follow = $user->getId();
          $follow = new Follow(null, $user_id, $id_user_follow);
          $isFollwed = $follow->isFollowing();
          if (!$isFollwed) {
            $users[] = $userToFollow;
          }
        }
      }


      // ajouter un post
      if (isset($_POST['post'])) {
        $post = htmlspecialchars($_POST['post']);
        $created_at = date('Y-m-d');
        $post = new Post(null, $post, null, $created_at, null, $user_id, null, null);
        $post->addPost();
        header("Location: " . "/");
        exit();
      }

      // affichage de mes post
      $post = new Post(null, null, null, null, null, $user_id, null, null);
      $posts = $post->showPosts();


      // follow un autre user
      if (isset($_POST['follow'])) {
        $userToFollow = $_POST['follow'];
        $follow = new Follow(null, $user_id, $userToFollow);
        $isFollwed = $follow->isFollowing();
        if (!$isFollwed) {
          $follow->follow();
        }
      }

      require_once(__DIR__ . '/../Views/home.view.php');
    } else {
      require_once(__DIR__ . "/../Views/security/register.view.php");
    }
  }
}
