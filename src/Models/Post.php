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


  public function __construct(?int $id, ?string $content, ?string $image, ?string $created_at, string|null $updated_at, ?int $user_id)
  {
    $this->id = $id;
    $this->content = $content;
    $this->image = $image;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
    $this->user_id = $user_id;
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
    $sql = "SELECT * FROM `posts` WHERE `user_id` = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$this->user_id]);
    $resultFetch = $statement->fetchAll(PDO::FETCH_ASSOC);
    $posts = [];
    if ($resultFetch) {
      foreach ($resultFetch as $row) {
        $post =  new Post($row['id'], $row['content'], $row['image'], $row['created_at'], $row['updated_at'], $row['user_id']);
        $posts[] = $post;
      }
      return $posts;
    }
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
