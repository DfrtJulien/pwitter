<?php

namespace App\Models;

use PDO;
use Config\DataBase;

class Like
{
  protected ?int $id;
  protected ?int $user_id;
  protected ?int $post_id;


  public function __construct(?int $id, ?int $user_id, ?int $post_id)
  {
    $this->id = $id;
    $this->user_id = $user_id;
    $this->post_id = $post_id;
  }

  public function addLike()
  {
    $pdo = DataBase::getConnection();
    $sql = "INSERT INTO likes (id, user_id, post_id) VALUES (?,?,?)";
    $statement = $pdo->prepare($sql);
    return $statement->execute([$this->id, $this->user_id, $this->post_id]);
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getUserId(): ?int
  {
    return $this->user_id;
  }

  public function getPostId(): ?int
  {
    return $this->post_id;
  }
}
