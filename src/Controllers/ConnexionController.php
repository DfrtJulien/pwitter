<?php

namespace App\Controllers;

use App\Models\User;
use App\Utils\AbstractController;

class ConnexionController extends AbstractController
{
  public function index()
  {
    if (isset($_POST['username'], $_POST['mail'], $_POST['password'])) {
      $username = htmlspecialchars($_POST['username']);
      $mail = htmlspecialchars($_POST['mail']);
      $password = htmlspecialchars($_POST['password']);
      $passwordHash = password_hash($password, PASSWORD_DEFAULT);

      $user = new User(null, $username, $mail, $passwordHash, null, null, null);
      $user->register();
    }

    if (isset($_POST['login-mail'], $_POST['password'])) {
      $mail = htmlspecialchars($_POST['login-mail']);
      $password = htmlspecialchars($_POST['password']);
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
            'img' => $responseGetUser->getImg(),
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

    require_once(__DIR__ . "/../Views/security/register.view.php");
  }
}
