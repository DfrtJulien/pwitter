<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Follow;
use App\Utils\AbstractController;

class PostController extends AbstractController
{
  public function index()
  {
    if (isset($_GET['id'])) {
      $post_id = $_GET['id'];

      $post = new Post($post_id, null, null, null, null, null, null, null,null,null);
      $postInfo = $post->showPostById();

      $comment = new Comment(null, null, null, null, $post_id, null, null);
      $allComment = $comment->showCommentByPostId();


      $user_id = $_SESSION['user']['user_id'];
      $user = new User($user_id, null, null, null, null, null, null);
      $users = [];
      $atempt = 0;


      // afficher des utilisateur a suivre
      while (count($users) < 3 && $atempt < 5) {
        $atempt++;
        $isUserFollowed = $user->showOtherUser();
        foreach ($isUserFollowed as $userToFollow) {
          if (count($users) >= 3) {
            break;
          }
          $id_user_follow = $userToFollow->getId();
          $follow = new Follow(null, $user_id, $id_user_follow);
          $isFollwed = $follow->isFollowing();
          if ($isFollwed === false) {
            $users[] = $userToFollow;
          }
        }
      }

      require_once(__DIR__ . '/../Views/posts/post.view.php');
    }
  }
}
