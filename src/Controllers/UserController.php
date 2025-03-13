<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Follow;
use App\Utils\AbstractController;

class UserController extends AbstractController
{
  public function index()
  {
    if (isset($_SESSION["user"])) {
      if (isset($_GET['id'])) {
        $user_id = $_GET['id'];
        if ($user_id == $_SESSION['user']['user_id']) {
          $user = new User($user_id, null, null, null, null, null, null);
          $myUser = $user->showUserProfile();

          $follow = new Follow(null, $user_id, $user_id);
          $numberOfFollow = $follow->numberOfFollowByUserId();
          $numberOfFollowing = $follow->numberOfFollowingByUserId();

          $post = new Post(null, null, null, null, null, $user_id, null, null);
          $myPost = $post->showUserPost();


          // afficher des utilisateur a suivre
          $users = [];
          $atempt = 0;
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
          require_once(__DIR__ . '/../Views/profile/myProfile.view.php');
        } else {
          $this->redirectToRoute('/404');
        }
      } else {
        $this->redirectToRoute('/404');
      }
    } else {
      $this->redirectToRoute("/register");
    }
  }
}
