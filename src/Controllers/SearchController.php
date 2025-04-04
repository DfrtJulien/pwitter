<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Follow;
use App\Utils\AbstractController;

class SearchController extends AbstractController
{
  public function search()
  {
    if (isset($_SESSION["user"])) {

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

        if(isset($_GET["searching-terms"])){
            $search_terms = $_GET["searching-terms"];
            $user = new User(null,null,null,null,null,null,null);
            $searcheUsers = $user->searchedUsers('%' . $search_terms . '%');
        }

        if(isset($_POST['follow'])){
          $userToFollow = $_POST['follow'];
          $follow = new Follow(null, $user_id, $userToFollow);
          $isFollwed = $follow->isFollowing();
          if (!$isFollwed) {
            $follow->follow();
            header("refresh: /search?searching-terms=" . $search_terms);
          }
        }


    require_once(__DIR__ . "/../Views/search.view.php");
    }
  }
}
