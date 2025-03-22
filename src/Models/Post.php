<?php

namespace App\Models;

use PDO;
use Config\DataBase;

class Post
{
  protected ?int $id;
  protected ?string $content;
  protected ?string $image;
  protected ?string $created_at;
  protected string|null $updated_at;
  protected ?int $user_id;
  protected ?string $username;
  protected ?string $profile_picture;


  public function __construct(?int $id, ?string $content, ?string $image, ?string $created_at, string|null $updated_at, ?int $user_id, ?string $username, ?string $profile_picture)
  {
    $this->id = $id;
    $this->content = $content;
    $this->image = $image;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
    $this->user_id = $user_id;
    $this->username = $username;
    $this->profile_picture = $profile_picture;
  }

  public function addPost()
  {
    $pdo = DataBase::getConnection();
    $sql = "INSERT INTO posts (id, content, image, created_at, updated_at, user_id) VALUES (?,?,?,?,?,?)";
    $statement = $pdo->prepare($sql);
    return $statement->execute([$this->id, $this->content, $this->image, $this->created_at, $this->updated_at, $this->user_id]);
  }

  public function showPosts()
  {
    $pdo = DataBase::getConnection();
    $sql = "SELECT posts.*, `users`.`id` AS `user_id`,`users`.`username`, `users`.`profile_picture` 
        FROM `posts`
        JOIN `users` ON `posts`.`user_id` = `users`.`id`
        WHERE `posts`.`user_id` = ?
        ORDER BY `posts`.`created_at` DESC;";
    $statement = $pdo->prepare($sql);
    $statement->execute([$this->user_id]);
    $resultFetch = $statement->fetchAll(PDO::FETCH_ASSOC);
    $posts = [];
    if ($resultFetch) {
      foreach ($resultFetch as $row) {
        $post =  new Post($row['id'], $row['content'], $row['image'], $row['created_at'], $row['updated_at'], $row['user_id'], $row['username'], $row['profile_picture']);
        $posts[] = $post;
      }
      return $posts;
    }
  }

  public function showUserPost()
  {
    $pdo = DataBase::getConnection();
    $sql = "SELECT posts.*
    FROM `posts`
    WHERE `posts`.`user_id` = ?
    ORDER BY `posts`.`created_at` DESC;";
    $statement = $pdo->prepare($sql);
    $statement->execute([$this->user_id]);
    $resultFetch = $statement->fetchAll(PDO::FETCH_ASSOC);
    $posts = [];
    if ($resultFetch) {
      foreach ($resultFetch as $row) {
        $post =  new Post($row['id'], $row['content'], $row['image'], $row['created_at'], $row['updated_at'], $row['user_id'], null, null);
        $posts[] = $post;
      }
      return $posts;
    }
  }

  public function showPostById()
  {
    $pdo = DataBase::getConnection();
    $sql = "SELECT posts.*, `users`.`id` AS `user_id`,`users`.`username`, `users`.`profile_picture` 
        FROM `posts`
        JOIN `users` ON `posts`.`user_id` = `users`.`id`
    WHERE `posts`.`id` = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$this->id]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if ($row) {
      return new Post($row['id'], $row['content'], $row['image'], $row['created_at'], $row['updated_at'], $row['user_id'], $row['username'], $row['profile_picture']);
    } else {
      return null;
    }
  }

  public function deletePost()
  {
    $pdo = DataBase::getConnection();
    $sql = "DELETE FROM `posts` WHERE `id` = ?";
    $statement = $pdo->prepare($sql);
    return $statement->execute([$this->id]);
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getContent(): ?string
  {
    return $this->content;
  }

  public function getImage(): ?string
  {
    return $this->image;
  }

  public function getCreationDate(): ?string
  {
    return $this->created_at;
  }


  public function getUpdatedAt(): ?string
  {
    return $this->updated_at;
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

  public function setImage(string $image): static
  {
    $this->image = $image;
    return $this;
  }

  public function setCreationDate(string $created_at): static
  {
    $this->created_at = $created_at;
    return $this;
  }
  public function setUpdatedDate(string $updated_at): static
  {
    $this->updated_at = $updated_at;
    return $this;
  }
}
