<?php

namespace App\Utils;


abstract class AbstractController
{
  protected array $arrayError = [];
  protected array  $cart = [];
  protected array $arraySucces = [];

  public function redirectToRoute($route)
  {
    http_response_code(303);
    header("Location: {$route} ");
    exit;
  }

  public function isNotEmpty($value)
  {
    if (empty($_POST[$value])) {
      $this->arrayError[$value] = "Le champ $value ne peut pas être vide.";
      return $this->arrayError;
    }
    return false;
  }

  public function checkFormat($nameInput, $value)
  {
    $regexName = '/^[a-zA-Zà-üÀ-Ü -]{2,255}$/';
    $regexPassword = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
    $regexAdress = '/^[a-zA-Zà-üÀ-Ü0-9 -]{2,255}$/';
    $regexPhoneNumber = '/^(?:([+]\d{1,11})[-.\s]?)?(?:[0](\d{1,9}))?$/';
    $regexPostal = '/^[0-9]{5}$/';
    $regexTitle = '/^[a-zA-Zà-üÀ-Ü \'\d]{2,255}$/';
    $regexDescription = '/^(.|\s)*[a-zA-Z]+(.|\s)*$/';
    $regexPriceWithoutTaxe = '/^[0-9 ,]/';
    $regexType = '/^collier|boucles|chale|bracelet|bague/';
    $regexQuantity = '/^[0-9]/';
    $regexMaterial = '/^or|argent|coton$/';
    $regexNote = '/^\s*[0-5]\s*$/';

    switch ($nameInput) {
      case 'firstname':
        if (!preg_match($regexName, $value)) {
          $this->arrayError['firstname'] = 'Merci de renseigner un prénom correcte!';
        }
        break;
      case 'lastname':
        if (!preg_match($regexName, $value)) {
          $this->arrayError['lastname'] = 'Merci de renseigner un nom correcte!';
        }
        break;
      case 'mail':
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
          $this->arrayError['mail'] = 'Merci de renseigner un e-mail correcte!';
        }
        break;
      case 'password':
        if (!preg_match($regexPassword, $value)) {
          $this->arrayError['password'] = 'Merci de donné un mot de passe avec au minimum : 8 caractères, 1 majuscule, 1 miniscule, 1 caractère spécial!';
        }
        break;
      case 'city':
        if (!preg_match($regexName, $value)) {
          $this->arrayError['city'] = 'Merci de renseigner une ville correcte!';
        }
        break;
      case 'street':
        if (!preg_match($regexAdress, $value)) {
          $this->arrayError['street'] = 'Merci de renseigner un adresse correcte!';
        }
        break;
      case 'postal':
        if (!preg_match($regexPostal, $value)) {
          $this->arrayError['postal'] = 'Merci de renseigner une adresse postale correcte!';
        }
        break;
      case 'phone':
        if (!preg_match($regexPhoneNumber, $value)) {
          $this->arrayError['phone'] = 'Merci de renseigner une numéro de téléphone correcte!';
        }
        break;
      case 'title':
        if (!preg_match($regexTitle, $value)) {
          $this->arrayError['title'] = 'Merci de renseigner un titre correcte !';
        }
        break;
      case 'description':

        if (!preg_match($regexDescription, $value)) {
          $this->arrayError['description'] = 'Merci de renseigner une description correcte !';
        }
        break;
      case 'priceExcludingTax':
        if (!preg_match($regexPriceWithoutTaxe, $value)) {
          $this->arrayError['priceExcludingTax'] = 'Merci de renseigner un prix correcte !';
        }
        break;
      case 'type':
        if (!preg_match($regexType, $value)) {
          $this->arrayError['type'] = 'Merci de renseigner un type correcte';
        }
        break;
      case 'quantity':
        if (!preg_match($regexQuantity, $value)) {
          $this->arrayError['quantity'] = 'Merci de renseigner une quantité correcte';
        }
        break;
      case 'material':
        if (!preg_match($regexMaterial, $value)) {
          $this->arrayError['material'] = 'Merci de renseigner un matériaux  correcte';
        }
        break;
      case 'comment':
        if (!preg_match($regexDescription, $value)) {
          $this->arrayError['comment'] = 'Merci de renseigner un commentaire correcte !';
        }
        break;
      case 'editComment':
        if (!preg_match($regexDescription, $value)) {
          $this->arrayError['editComment'] = 'Merci de renseigner un commentaire correcte !';
        }
        break;
      case "subject":
        if (!preg_match($regexTitle, $value)) {
          $this->arrayError['subject'] = 'Merci de renseigner un sujet correcte !';
        }
        break;
      case "message":
        if (!preg_match($regexDescription, $value)) {
          $this->arrayError['message'] = 'Merci de renseigner un message correcte !';
        }
        break;
      case "note":
        if (!preg_match($regexNote, $value)) {
          $this->arrayError['note'] = 'Merci de renseigner un note correcte !';
        }
        break;
      case "editNote":
        if (!preg_match($regexNote, $value)) {
          $this->arrayError['editNote'] = 'Merci de renseigner un note correcte !';
        }
        break;
    }
  }



  public function showMsg($msg)
  {
    switch ($msg) {
      case 'register':
        $this->arraySucces['register'] = "Inscirpiton réussi !";
        break;
      case 'addedComment':
        $this->arraySucces['addedComment'] = "Commentaire ajouté avec succes !";
        break;
      case 'edditedComment':
        $this->arraySucces['edditedComment'] = "Commentaire modiffié avec succes !";
        break;
      case "updateProfile":
        $this->arraySucces['updateProfile'] = "Profile modiffié avec succes !";
        break;
      case "addArticle":
        $this->arraySucces["addArticle"] = "Article ajouter avec succes !";
        break;
      case "updateArticle":
        $this->arraySucces["updateArticle"] = "Article modifier avec succes !";
        break;
    }
  }

  public function check($nameInput, $value)
  {
    $this->isNotEmpty($nameInput);
    $value = htmlspecialchars($value);
    $this->checkFormat($nameInput, $value);
    return $this->arrayError;
  }
}
