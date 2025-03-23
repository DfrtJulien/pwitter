<?php

namespace App\Models;

use PDO;
use Config\DataBase;

class Follow
{
  protected ?int $id;
  protected ?int $follower_id;
  protected ?int $following_id;


  public function __construct(?int $id, ?int $follower_id, ?int $following_id)
  {
    $this->id = $id;
    $this->follower_id = $follower_id;
    $this->following_id = $following_id;
  }

  public function isFollowing()
  {
    $pdo = DataBase::getConnection();
    $sql = "SELECT * FROM `following` WHERE follower_id = ? AND following_id = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$this->follower_id, $this->following_id]);
    return $statement->fetch();
  }

  public function follow()
  {
    $pdo = DataBase::getConnection();
    $sql = "INSERT INTO `following` (id, follower_id, following_id) VALUES (?,?,?)";
    $statement = $pdo->prepare($sql);
    return $statement->execute([$this->id, $this->follower_id, $this->following_id]);
  }

  public function unfollow()
  {
    $pdo = DataBase::getConnection();
    $sql = "DELETE FROM `following` WHERE follower_id = ? AND following_id = ?";
    $statement = $pdo->prepare($sql);
    return $statement->execute([$this->follower_id, $this->following_id]);
  }

  public function followingUserId()
  {
    $pdo = DataBase::getConnection();
    $sql = "SELECT `following`.`following_id` FROM `following` WHERE follower_id = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$this->follower_id]);
    $result = $statement->fetchAll();
    $ids = [];
    if ($result) {
      foreach ($result as $idUser) {
        $id = new Follow(null, null, $idUser['following_id']);
        $ids[] = $id;
      }
      return $ids;
    }
  }

  public function numberOfFollowByUserId()
  {
    $pdo = DataBase::getConnection();
    $sql = "SELECT count(`follower_id`) FROM `following` WHERE `follower_id` = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$this->follower_id]);
    $resultFetch = $statement->fetchColumn();
    return $resultFetch;
  }

  public function numberOfFollowingByUserId()
  {
    $pdo = DataBase::getConnection();
    $sql = "SELECT count(`following_id`) FROM `following` WHERE `following_id` = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$this->follower_id]);
    $resultFetch = $statement->fetchColumn();
    return $resultFetch;
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getIdFollowed(): ?int
  {
    return $this->follower_id;
  }

  public function getIdFollowing(): ?int
  {
    return $this->following_id;
  }
}
