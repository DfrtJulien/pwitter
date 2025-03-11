<?php

namespace App\Models;

use PDO;
use Config\DataBase;

class Follow
{
  protected ?int $id;
  protected ?int $follower_id;
  protected ?int $followed_id;


  public function __construct(?int $id, ?int $follower_id, ?int $followed_id)
  {
    $this->id = $id;
    $this->follower_id = $follower_id;
    $this->followed_id = $followed_id;
  }

  public function isFollowing()
  {
    $pdo = DataBase::getConnection();
    $sql = "SELECT * FROM `following` WHERE follower_id = ? AND following_id = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$this->follower_id, $this->followed_id]);
    return $statement->fetch();
  }

  public function follow()
  {
    $pdo = DataBase::getConnection();
    $sql = "INSERT INTO `following` (id, follower_id, following_id) VALUES (?,?,?)";
    $statement = $pdo->prepare($sql);
    return $statement->execute([$this->id, $this->follower_id, $this->followed_id]);
  }
}
