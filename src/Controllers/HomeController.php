<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Follow;
use App\Utils\AbstractController;
use App\Models\Comment;
use App\Models\Like;

class HomeController
{
  public function index()
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



      //récupérer les ids des users suivi pour récupérer leur postes
      $follow = new Follow(null, $user_id, null);
      $id_users_followed = $follow->followingUserId();
      $ids = [$user_id];

      if ($id_users_followed) {
        foreach ($id_users_followed as $id) {
          $user_followed_id = $id->getIdFollowing();
          $ids[] = $user_followed_id;
        }
      }
      // affichage des postes des user que l'on suit
      $posts = [];
      $idPostAndNumberComment = [];
      $idPostAndNumberLikes = [];
      foreach ($ids as $id) {
        $post = new Post(null, null, null, null, null, $id, null, null);
        $result = $post->showPosts();

        if ($result) {
          if (is_array($result)) {
            $posts = array_merge($posts, $result); // Fusionne les objets directement
          }
          foreach ($result as $post) {
            $idPostComment = $post->getId();

            // $postId = $result->getId();
            $comment = new Comment(null, null, null, null, $idPostComment, null, null);
            $NumberComment = $comment->countCommentByPostId();
            // Extraction du nombre de commentaires
            // rendre le tableau associatif en int
            $numberOfComment = reset($NumberComment);
            // ajouter l'id du post et le nombre de commentaires
            $idPostAndNumberComment[$idPostComment] = $numberOfComment;

            $like = new Like(null, null, $idPostComment);
            $NumberLike = $like->countLikesByPostId();
            // Extraction du nombre de likes
            // rendre le tableau associatif en int
            $numberOfLike = reset($NumberLike);
            // ajouter l'id du post et le nombre de likes
            $idPostAndNumberLikes[$idPostComment] = $numberOfLike;
          }
        }
      }



      // trier les posts par le plus récent au plus ancien 
      usort($posts, function ($a, $b) {
        return strtotime($b->getCreationDate()) - strtotime($a->getCreationDate());
      });

      // ajouter un post
      if (isset($_POST['post'])) {
        $myPost = htmlspecialchars($_POST['post']);
        $created_at = date('Y-m-d h:m:s');
        if ($myPost) {
          $post = new Post(null, $myPost, null, $created_at, null, $user_id, null, null);

          $post->addPost();
          header("Location:  /");
          exit();
        }
      }

      // follow un autre user
      if (isset($_POST['follow'])) {
        $userToFollow = $_POST['follow'];
        $follow = new Follow(null, $user_id, $userToFollow);
        $isFollwed = $follow->isFollowing();
        if (!$isFollwed) {
          $follow->follow();
        }
      }


      // ajouter un commentaire
      if (isset($_POST['comment'], $_POST['post-id'])) {
        $comment = $_POST['comment'];
        $articleId = $_POST['post-id'];
        $created_at = date('Y-m-d h:m:s');
        $userId = $_SESSION['user']['user_id'];

        if ($comment) {
          $post = new Comment(null, $comment, $created_at, $userId, $articleId, null, null);
          $post->addComment();
          header("Location: /");
        }
      }

      // afficher les commentaires d'un poste
      if (isset($_POST['idPost'])) {
        $idPost = $_POST['idPost'];
        $post = new Post($idPost, null, null, null, null, null, null, null);
        $showPost = $post->showPostById();
        $comment = new Comment(null, null, null, null, $idPost, null, null);
        $allComment = $comment->showCommentByPostId();
      }

      // ajouter un like
      if (isset($_POST['idLike'])) {
        $idPost = $_POST['idLike'];
        $like = new Like(null, $user_id, $idPost);
        if ($like->isLiked()) {
          $like->deleteLike();
        } else {
          $like->addLike();
        }
        header("Location: /");
      }

      //supprimer un post
      if (isset($_POST['idPostDelete'])) {
        $idPostToDelete = $_POST['idPostDelete'];
        $post = new Post($idPostToDelete, null, null, null, null, null, null, null);
        $post->deletePost();
        header("Location: /");
      }

      require_once(__DIR__ . '/../Views/home.view.php');
    } else {
      // $this->redirectToRoute("/register");
    }
  }
}
