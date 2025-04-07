<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Utils\AbstractController;

class MessageController extends AbstractController
{
  public function message()
  {
    $userId = $_SESSION['user']['user_id'];
    $message = new Message(null, null,null, $userId,null,null,null);
    $showAllMessage = $message->showRecentMessages();
  

    if(isset($_GET["searching-terms"])){
        $search_terms = $_GET["searching-terms"];
        $user = new User(null,null,null,null,null,null,null);
        $searcheUsers = $user->searchedUsers('%' . $search_terms . '%');
        $message = new Message(null, null,null, $userId,null,null,null);
        $showAllMessage = $message->showMessages();

    }

    if(isset($_POST['send-msg'])){
        $idUserToSendMsg = $_POST['send-msg'];
        $user = new User($idUserToSendMsg,null,null,null,null,null,null);
        $userToSendMsg = $user->showUserProfile();
        $message = new Message(null,null,null, $userId, $idUserToSendMsg,null,null);
        $messages = $message->showMessages();
        
    }

    if(isset($_POST['message'], $_POST['userId'])){

        $idUserToSendMsg = $_POST['userId'];
        $user = new User($idUserToSendMsg,null,null,null,null,null,null);
        $userToSendMsg = $user->showUserProfile();
        $messageValue = $_POST['message'];
        $created_at = date("Y-m-d H:i:s");
        $message = new Message(null,$messageValue,$created_at,$userId, $idUserToSendMsg, null,null );
        $message->sendMessage();
        $message = new Message(null,null,null, $userId, $idUserToSendMsg, null,null);
        $messages = $message->showMessages();
    }

    require_once(__DIR__ . "/../Views/message.view.php");
  }
}
