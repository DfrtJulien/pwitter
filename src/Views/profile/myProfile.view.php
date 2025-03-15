<?php
$page = "myProfile";
require_once(__DIR__ . '/../partials/head.php');
?>
<div class="show-profile">

  <div class="update-form-container">
    <form method="POST" enctype="multipart/form-data" class="update-form">
      <h2>Mettre a jour le profile</h2>
      <div class="">
        <label for="username">Nom et Prénom</label>
        <input type="text" name="username" id="username">
        <?php
        if (isset($this->arrayError['username'])) {
        ?>
          <div class="alert alert-danger" role="alert">
            <p class='text-danger'><?= $this->arrayError['username'] ?></p>
          </div>
        <?php
        } ?>
      </div>
      <div class="">
        <label for="bio">Ajouter une bio</label>
        <input type="text" name="bio" id="bio">
        <?php
        if (isset($this->arrayError['bio'])) {
        ?>
          <div class="alert alert-danger" role="alert">
            <p class='text-danger'><?= $this->arrayError['bio'] ?></p>
          </div>
        <?php
        } ?>
      </div>
      <div>
        <label for="fileToUpload">Ajouter votre photo de profile :</label>
        <input type="file" name="fileToUpload" id="fileToUpload">
      </div>
      <div>
        <button type="submit" class="active-btn">Mettre a jour</button>
      </div>
      <i class="fa-solid fa-xmark" id="update-close-icon"></i>
    </form>
  </div>
  <div class="user-profile">
    <div>
      <div class="user-img">
        <img src="/public/uploads/<?= $myUser->getProfilePicture() ? $myUser->getProfilePicture() : "img_default.png" ?>" alt="<?= $myUser->getUsername() ?> profile picture">
      </div>
      <div class="user-info">
        <h3><?= $myUser->getUsername() ?></h3>
        <p><?= $myUser->getBio() ?  $myUser->getBio() : "" ?></p>
        <div class="user-follows">
          <p><span><?= $numberOfFollow ?  $numberOfFollow : "0" ?></span> Abonnement</p>
          <p><span><?= $numberOfFollowing ?  $numberOfFollowing : "0" ?></span> Abonnées</p>
        </div>
      </div>
    </div>
    <?php
    if ($_SESSION['user']['user_id'] == $user_id) {
    ?>
      <button class="active-btn" id="update-form-btn">Editer le profile</button>
    <?php
    }
    ?>

  </div>
  <div class="show-post">
    <div>
      <?php
      if (!empty($myPost)) {

        foreach ($myPost as $post) {
          if (!empty($post)) {

      ?>
            <div class="post">
              <div class="post-user-info">
                <div class="user-img">
                  <img src="/public/uploads/<?= $myUser->getProfilePicture() ? $myUser->getProfilePicture() : "img_default.png" ?>" alt="<?= $myUser->getUsername() ?> profile pciture">
                </div>
                <h5><?= $myUser->getUsername() ?></h5>
              </div>
              <p><?= $post->getContent() ?></p>
            </div>
      <?php
          }
        }
      }
      ?>
    </div>
  </div>
</div>
<div class="show-users-container">
  <?php
  if (!empty($users)) {
    foreach ($users as $user) {
  ?>
      <div class="show-users">
        <div class="post-user-info">
          <div class="user-img">
            <img src="/public/uploads/<?= $user->getProfilePicture() ? $user->getProfilePicture() : "img_default.png" ?>" alt="<?= $user->getUsername() ?> profile pciture">
          </div>
          <h5><?= $user->getUsername() ?></h5>
        </div>
        <form method="POST">
          <input type="hidden" value="<?= $user->getId() ?>" name="follow">
          <button type="submit" class="active-btn">Suivre</button>
        </form>
      </div>
    <?php
    }
    ?>
  <?php
  }
  ?>
</div>
<?php
include_once(__DIR__ . '/../partials/footer.php');
?>