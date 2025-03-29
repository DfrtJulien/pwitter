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

  public function countLikesByPostId()
  {
    $pdo = DataBase::getConnection();
    $sql = "SELECT count(`user_id`) FROM `likes` WHERE `post_id` = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$this->post_id]);
    return $resultFetch = $statement->fetch(PDO::FETCH_ASSOC);
  }

  public function deleteLike()
  {
    $pdo = DataBase::getConnection();
    $sql = "DELETE FROM `likes` WHERE `post_id` = ? AND `user_id` = ?";
    $statement = $pdo->prepare($sql);
    return $statement->execute([$this->post_id, $this->user_id]);
  }

  public function isLiked()
  {
    $pdo = DataBase::getConnection();
    $sql = "SELECT * FROM `likes` WHERE `post_id` = ? AND `user_id` = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$this->post_id, $this->user_id]);
    return $statement->fetch();
  }

  public function getPostIdFromUserId()
  {
    $pdo = DataBase::getConnection();
    $sql = "SELECT `post_id` FROM `likes` WHERE `user_id` = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$this->user_id]);
    $resultFetch = $statement->fetchAll(PDO::FETCH_ASSOC);
    $ids = [];
    if ($resultFetch) {
      foreach ($resultFetch as $row) {
        $ids[] = new Like(null, null, $row['post_id']);
      }
      return $ids;
    } else {
      return null;
    }
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
