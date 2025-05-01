<?php

namespace App\Controllers;

use App\Models\User;
use App\Utils\AbstractController;

class ConnexionController extends AbstractController
{
  public function index()
  {
    if (isset($_POST['username'], $_POST['mail'], $_POST['password'])) {
      $this->handleRegister($_POST);
    }

    if (isset($_POST['login-mail'], $_POST['password'])) {
      $this->handleLogin($_POST);
    }

    require_once(__DIR__ . "/../Views/security/register.view.php");
  }

  public function handleRegister(array $post)
  {
    $username = htmlspecialchars($post['username']);
    $mail = htmlspecialchars($post['mail']);
    $password = htmlspecialchars($post['password']);
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $user = new User(null, $username, $mail, $passwordHash, null, null, null);
    $user->register();
  }

  public function handleLogin(array $post)
  {
    $mail = htmlspecialchars($post['login-mail']);
    $password = htmlspecialchars($post['password']);
    $user = new User(null, null, $mail, $password, null, null, null);
    $userExist = $user->existingUser($mail);
    if ($userExist) {
      $responseGetUser = $user->login($mail);
      $passwordUser = $responseGetUser->getPassword();

      if (password_verify($password, $passwordUser)) {

        $_SESSION['user'] = [
          'id' => uniqid(),
          'user_id' => $responseGetUser->getId(),
          'username' => $responseGetUser->getUsername(),
          'mail' => $responseGetUser->getMail(),
          'img' => $responseGetUser->getProfilePicture(),
          'bio' => $responseGetUser->getBio(),
          'register_date' => $responseGetUser->getRegisterDate(),
        ];
        $this->redirectToRoute('/');
      } else {
        $error = "Le mail ou mot de passe n'est pas correct";
      }
    } else {
      $error = "Le mail ou mot de passe n'est pas correct";
    }
  }

  public function logout()
  {
    session_destroy();
    $this->redirectToRoute('/register');
  }
}
