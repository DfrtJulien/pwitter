<?php

namespace App\Models;

use PDO;
use Config\DataBase;

class User
{
  protected ?int $id;
  protected ?string $username;
  protected ?string $email;
  protected ?string $password;
  protected string|null $profile_picture;
  protected string|null $bio;
  protected ?string $register_date;


  public function __construct(?int $id, ?string $username, ?string $email, ?string $password, string|null $profile_picture, string|null $bio,  ?string $register_date)
  {
    $this->id = $id;
    $this->username = $username;
    $this->email = $email;
    $this->password = $password;
    $this->profile_picture = $profile_picture;
    $this->bio = $bio;
    $this->register_date = $register_date;
  }

  public function register()
  {
    $pdo = DataBase::getConnection();
    $sql = "INSERT INTO users (id, username, email, password, profile_picture, bio, created_at) VALUES (?,?,?,?,?,?,?)";
    $statement = $pdo->prepare($sql);
    return $statement->execute([$this->id, $this->username, $this->email, $this->password, $this->profile_picture, $this->bio, $this->register_date]);
  }

  public function existingUser($mail)
  {
    $pdo = DataBase::getConnection();
    $sql = "SELECT * FROM `users` WHERE email = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$mail]);
    return $statement->fetch();
  }

  public function login($mail)
  {
    $pdo = DataBase::getConnection();
    $sql = "SELECT `users`.`id`, `users`.`email`, `users`.`password`,`users`.`created_at`,`users`.`username`, `users`.`profile_picture`, `users`.`bio` 
      FROM `users`
      WHERE email = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$mail]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if ($row) {
      return new User($row['id'], $row['username'], $row['email'], $row['password'], $row['profile_picture'], $row['bio'], $row['created_at']);
    } else {
      return null;
    }
  }

  public function showOtherUser()
  {
    $pdo = DataBase::getConnection();
    $sql = "SELECT `users`.`id`, `users`.`username`, `users`.`profile_picture`
            FROM `users`
            WHERE `users`.`id` <> ?
            ORDER BY RAND()
            LIMIT 5";
    $statement = $pdo->prepare($sql);
    $statement->execute([$this->id]);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    $users = [];
    if ($result) {
      foreach ($result as $row) {
        $user =  new User($row['id'], $row['username'], null, null, $row['profile_picture'], null, null);
        $users[] = $user;
      }
    } else {
      return null;
    }
    return $users;
  }

  public function showUserProfile()
  {
    $pdo = DataBase::getConnection();
    $sql = "SELECT `users`.`id`, `users`.`username`, `users`.`profile_picture`, `users`.`bio`
    FROM `users`
    WHERE `users`.`id` = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$this->id]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if ($row) {
      return new User($row['id'], $row['username'], null, null, $row['profile_picture'], $row['bio'], null);
    } else {
      return null;
    }
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getMail(): ?string
  {
    return $this->email;
  }

  public function getPassword(): ?string
  {
    return $this->password;
  }

  public function getRegisterDate(): ?string
  {
    return $this->register_date;
  }


  public function getUsername(): ?string
  {
    return $this->username;
  }


  public function getProfilePicture(): ?string
  {
    return $this->profile_picture;
  }

  public function getBio(): ?string
  {
    return $this->bio;
  }


  public function setId(int $id): static
  {
    $this->id = $id;
    return $this;
  }

  public function setMail(string $email): static
  {
    $this->email = $email;
    return $this;
  }

  public function setPassword(string $password): static
  {
    $this->password = $password;
    return $this;
  }

  public function setRegisterDate(string $register_date): static
  {
    $this->register_date = $register_date;
    return $this;
  }
}
