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

          // je récupere la photo de mon user
          $myUserImg = $myUser->getProfilePicture();
          $myUserPath = "/public/upload/" . $myUserImg;

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
            } else {

              // si mon utilistauer n'a pas changer son image alors je crée un un objet avec la variabke image contenant l'image de la bdd
              $user = new User($user_id, $username, null, null, $myUserImg, $bio, null);
              $user->updateProfile();
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
