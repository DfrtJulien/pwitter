<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Follow;
use App\Utils\AbstractController;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Message;

ini_set('display_errors', 1);
error_reporting(E_ALL);
class HomeController extends AbstractController
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





      // ajouter un post
      if (isset($_POST['post'])) {
        $myPost = htmlspecialchars($_POST['post']);
        $created_at = date('Y-m-d H:i:s');
        if ($myPost) {
          $post = new Post(null, $myPost, null, $created_at, null, $user_id, null, null, null, null);

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
          header("Location:  /");
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
        $post = new Post($idPost, null, null, null, null, null, null, null, null, null);
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
        $post = new Post($idPostToDelete, null, null, null, null, null, null, null, null, null);
        $post->deletePost();
        header("Location: /");
      }



      require_once(__DIR__ . '/../Views/home.view.php');
    } else {
       $this->redirectToRoute("/register");
    }
  }

  public function getPost()
  {
  

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $user_id = $_SESSION['user']['user_id'];
      $post = new Post(null, null, null, null, null, null, null, null, null, null);
      $postsAjax = $post->showAllPosts();
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
  
      foreach ($ids as $id) {
        $post = new Post(null, null, null, null, null, $id, null, null, null, null);
        $result = $post->showPosts();
        

        if ($result) {
          if (is_array($result)) {
            $posts = array_merge($posts, $result); // Fusionne les objets directement
          }   
        }
      }
      
      $uniquePosts = [];
      $seenIds = [];
      
      foreach ($posts as $post) {
          if (!in_array($post->getId(), $seenIds)) {
              $uniquePosts[] = $post;
              $seenIds[] = $post->getId();
          }
      }
      
      $posts = $uniquePosts;

      usort($posts, function ($a, $b) {
        return strtotime($b->getCreationDate()) - strtotime($a->getCreationDate());
      });
      
      
      // Convertir chaque objet en tableau associatif
      $postsArray = array_map(fn($post) => $post->toArray(), $posts);
     
      // Encoder en JSON et afficher
      header("Content-Type: application/json");
      echo json_encode($postsArray, JSON_PRETTY_PRINT);
      exit;
    }
    require_once(__DIR__ . '/../Views/test.view.php');
  }

  public function getMessage()
  {
  

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $user_id = $_SESSION['user']['user_id'];
      $message = new Message(null, null,null,null,null,$user_id,null,null);
      $messagesAjax = $message->showAllMessages();
      
      // Convertir chaque objet en tableau associatif
      $MessagesArray = array_map(fn($message) => $message->toArray(), $messagesAjax);
    
      // Encoder en JSON et afficher
      header("Content-Type: application/json");
      echo json_encode($MessagesArray, JSON_PRETTY_PRINT);
      exit;
    }
    require_once(__DIR__ . '/../Views/getMessages.view.php');
  }
}
