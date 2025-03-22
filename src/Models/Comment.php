<?php

namespace App\Models;

use PDO;
use Config\DataBase;

class Comment
{
  protected ?int $id;
  protected ?string $content;
  protected ?string $created_at;
  protected ?int $user_id;
  protected ?int $post_id;
  protected ?string $username;
  protected ?string $profile_picture;


  public function __construct(?int $id, ?string $content, ?string $created_at, ?int $user_id, ?int $post_id, ?string $username, ?string $profile_picture)
  {
    $this->id = $id;
    $this->content = $content;
    $this->created_at = $created_at;
    $this->user_id = $user_id;
    $this->post_id = $post_id;
    $this->username = $username;
    $this->profile_picture = $profile_picture;
  }

  public function addComment()
  {
    $pdo = DataBase::getConnection();
    $sql = "INSERT INTO comments (id, content, created_at, user_id, post_id) VALUES (?,?,?,?,?)";
    $statement = $pdo->prepare($sql);
    return $statement->execute([$this->id, $this->content, $this->created_at,  $this->user_id, $this->post_id]);
  }

  public function showCommentByPostId()
  {
    $pdo = DataBase::getConnection();
    $sql = "SELECT comments.*, `users`.`id` AS `user_id`,`users`.`username`, `users`.`profile_picture` 
    FROM `comments`
    JOIN `users` ON `comments`.`user_id` = `users`.`id`
    WHERE `comments`.`post_id` = ?
    ORDER BY `comments`.`created_at` DESC;";
    $statement = $pdo->prepare($sql);
    $statement->execute([$this->post_id]);
    $resultFetch = $statement->fetchAll(PDO::FETCH_ASSOC);
    $comments = [];
    if ($resultFetch) {
      foreach ($resultFetch as $row) {
        $comment =  new Comment($row['id'], $row['content'],  $row['created_at'], $row['user_id'], $row['post_id'], $row['username'], $row['profile_picture']);
        $comments[] = $comment;
      }
      return $comments;
    }
  }

  public function countCommentByPostId()
  {
    $pdo = DataBase::getConnection();
    $sql = "SELECT count(`content`) FROM `comments` WHERE `post_id` = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$this->post_id]);
    return $resultFetch = $statement->fetch(PDO::FETCH_ASSOC);
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getContent(): ?string
  {
    return $this->content;
  }


  public function getCreationDate(): ?string
  {
    return $this->created_at;
  }


  public function getUserId(): ?int
  {
    return $this->user_id;
  }

  public function getUsername(): ?string
  {
    return $this->username;
  }

  public function getProfilePicture(): ?string
  {
    return $this->profile_picture;
  }

  public function setId(int $id): static
  {
    $this->id = $id;
    return $this;
  }

  public function setContent(string $content): static
  {
    $this->content = $content;
    return $this;
  }


  public function setCreationDate(string $created_at): static
  {
    $this->created_at = $created_at;
    return $this;
  }
}
