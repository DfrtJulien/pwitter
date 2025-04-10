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
  protected ?string $username;
  protected string|null $profile_picture;

  public function __construct(?int $id,?string $message,?string $created_at, ?int $sender_id, ?int $receiver_id,?string $username,string|null $profile_picture)
  {
    $this->id = $id;
    $this->message = $message;
    $this->created_at = $created_at;
    $this->sender_id = $sender_id;
    $this->receiver_id = $receiver_id;
    $this->username = $username;
    $this->profile_picture = $profile_picture;
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
        $message =  new Message($row['id'], $row['message'], $row['created_at'], $row['sender_id'], $row['receiver_id'], null,null);
        $messages[] = $message;
      }
      return $messages;
    }
  }

  public function showRecentMessages()
  {
    $pdo = DataBase::getConnection();
    $sql = "SELECT 
  m1.*, 
  u.username AS interlocutor_username,
  u.profile_picture AS interlocutor_profile_picture
FROM messages m1
JOIN users u 
  ON u.id = CASE 
              WHEN m1.sender_id = ? THEN m1.receiver_id
              ELSE m1.sender_id
            END
WHERE m1.created_at = (
    SELECT MAX(m2.created_at)
    FROM messages m2
    WHERE (
        (m2.sender_id = m1.sender_id AND m2.receiver_id = m1.receiver_id)
        OR
        (m2.sender_id = m1.receiver_id AND m2.receiver_id = m1.sender_id)
    )
)
AND (? IN (m1.sender_id, m1.receiver_id))
ORDER BY m1.created_at DESC
            ";
    $statement = $pdo->prepare($sql);
    $statement->execute([$this->sender_id, $this->sender_id]);
    $resultFetch = $statement->fetchAll(PDO::FETCH_ASSOC);
    $messages = [];
    if ($resultFetch) {
      foreach ($resultFetch as $row) {
        $message =  new Message($row['id'], $row['message'], $row['created_at'], $row['sender_id'], $row['receiver_id'], $row["interlocutor_username"], $row['interlocutor_profile_picture']);
        $messages[] = $message;
      }
      return $messages;
    }
      
  }

  public function showAllMessages(){
    $pdo = DataBase::getConnection();
    $sql = "SELECT * FROM `messages` WHERE `receiver_id` = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$this->receiver_id]);
    $resultFetch = $statement->fetchAll(PDO::FETCH_ASSOC);
    $messages = [];
    if ($resultFetch) {
      foreach ($resultFetch as $row) {
        $message =  new Message($row['id'], $row['message'], $row['created_at'], $row['sender_id'], $row['receiver_id'], null,null);
        $messages[] = $message;
      }
      return $messages;
    }
  }

  public function toArray()
  {
    return [
      "id" => $this->id,
      "message" => $this->message,
      "created_at" => $this->created_at,
      "sender_id" => $this->sender_id,
      "receiver_id" => $this->receiver_id
    ];
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

  public function getUsername(): ?string
  {
    return $this->username;
  }

  public function getProfilePicture(): ?string
  {
    return $this->profile_picture;
  }

}
