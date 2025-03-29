<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Follow;
use App\Models\Like;
use App\Utils\AbstractController;

class UserController extends AbstractController
{
  public function index()
  {
    if (isset($_SESSION["user"])) {
      if (isset($_GET['id'])) {
        $user_id = $_GET['id'];

        $user = new User($user_id, null, null, null, null, null, null);
        $myUser = $user->showUserProfile();


        // je récupere la photo de mon user
        $myUserImg = $myUser->getProfilePicture();
        $myUserPath = "/public/upload/" . $myUserImg;

        $follow = new Follow(null, $user_id, null);
        $numberOfFollow = $follow->numberOfFollowByUserId();
        $numberOfFollowing = $follow->numberOfFollowingByUserId();
        $id_user_following = $follow->followingUserId();
        $usersFollowing = [];

        foreach ($id_user_following as $userFollowing) {
          $idUserFollowing = $userFollowing->getIdFollowing();
          $user = new User($idUserFollowing, null, null, null, null, null, null);
          $myUsers = $user->showUserProfile();
          $usersFollowing[] = $myUsers;
        }
        $userFollower = [];
        $id_user_follower = $follow->followerUserId();
        $usersFollowed = [];
        foreach ($id_user_follower as $userFollowing) {

          $idUserFollowing = $userFollowing->getIdFollowed();
          $user = new User($idUserFollowing, null, null, null, null, null, null);
          $myUsers = $user->showUserProfile();
          $usersFollowed[] = $myUsers;
        }


        $post = new Post(null, null, null, null, null, $user_id, null, null);
        $myPost = $post->showUserPost();




        $like = new Like(null, $user_id, null);
        $idsLikedPost = $like->getPostIdFromUserId();
        $likedPosts = [];

        foreach ($idsLikedPost as $postLiked) {
          $idPost = $postLiked->getPostId();
          $post = new Post($idPost, null, null, null, null, null, null, null);
          $likedPost = $post->showPostById();
          $likedPosts[] = $likedPost;
        }


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

        if (isset($_POST['username'], $_POST['bio'])) {

          $username = $_POST['username'];
          $bio = $_POST['bio'];
          $img = "";


          // chemin du dossier des images
          $target_dir = "public/uploads/";

          // chemin plus le nom de l'image
          $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

          // si mon image a bien été déplacé 
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // alors ma variable contient le nom de l'image si mon utilisateur a ajouté une image
            $img = htmlspecialchars(basename($_FILES["fileToUpload"]["name"]));
            $_SESSION['user']['img_path'] = $img;
          } else {
            // sinon je récupere l'image si elle na pas été changé
            $_SESSION['user']['img_path'] = $myUserImg;
          }


          if ($_FILES["fileToUpload"]["name"]) {
            // si mon utilistauer a changé son image je suprime l'ancienne
            unlink('public/uploads/' . $myUserImg);

            // et je crée un objet avec la variable contenant la nouvelle image
            $user = new User($user_id, $username, null, null, $img, $bio, null);
            $user->updateProfile();
            header("Refresh: 0");
          } else {

            // si mon utilistauer n'a pas changer son image alors je crée un un objet avec la variabke image contenant l'image de la bdd
            $user = new User($user_id, $username, null, null, $myUserImg, $bio, null);
            $user->updateProfile();
            header("Refresh: 0");
          }
        }

        $userIsFollowing = $_SESSION['user']['user_id'];
        $follow = new Follow(null, $userIsFollowing, $user_id);
        $isFollowing = $follow->isFollowing();

        if (isset($_POST['follow'])) {
          if ($isFollowing) {
            $follow->unfollow();
            header("Location: /" . "profile?id=" . $user_id);
          } else {
            $follow->follow();
            header("Location: /" . "profile?id=" . $user_id);
          }
        }

        require_once(__DIR__ . '/../Views/profile/myProfile.view.php');
      } else {
        $this->redirectToRoute('/404');
      }
    } else {
      $this->redirectToRoute("/register");
    }
  }
}
