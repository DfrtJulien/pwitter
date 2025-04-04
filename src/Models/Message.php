<?php

namespace App\Models;

use PDO;
use Config\DataBase;

class Message
{
  protected ?int $id;
  protected ?string $message;
  protected ?string $created_at;
  protected ?int $sender_id;
  protected ?int $receiver_id;


  public function __construct(?int $id,?string $message,?string $created_at, ?int $sender_id, ?int $receiver_id)
  {
    $this->id = $id;
    $this->message = $message;
    $this->created_at = $created_at;
    $this->sender_id = $sender_id;
    $this->receiver_id = $receiver_id;
  }


  public function sendMessage()
  {
    $pdo = DataBase::getConnection();
    $sql = "INSERT INTO messages (id,message, created_at, sender_id, receiver_id) VALUES (?,?,?,?,?)";
    $statement = $pdo->prepare($sql);
    return $statement->execute([$this->id,$this->message, $this->created_at, $this->sender_id, $this->receiver_id]);
  }

  public function showMessages()
  {
    $pdo = DataBase::getConnection();
    $sql = "SELECT * FROM `messages` WHERE (`sender_id` = ? AND `receiver_id` = ?) 
   OR (`receiver_id` = ? AND `sender_id` = ?) ORDER BY `created_at` ASC";
    $statement = $pdo->prepare($sql);
    $statement->execute([$this->sender_id, $this->receiver_id,$this->sender_id, $this->receiver_id]);
    $resultFetch = $statement->fetchAll(PDO::FETCH_ASSOC);
    $messages = [];
    if ($resultFetch) {
      foreach ($resultFetch as $row) {
        $message =  new Message($row['id'], $row['message'], $row['created_at'], $row['sender_id'], $row['receiver_id']);
        $messages[] = $message;
      }
      return $messages;
    }
  }

  public function getMessage(): ?string
  {
    return $this->message;
  }

  public function getCreatedDate(): ?string
  {
    return $this->created_at;
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getSenderId(): ?int
  {
    return $this->sender_id;
  }

  public function getReceiverId(): ?int
  {
    return $this->receiver_id;
  }
}
