<?php
$page = "myProfile";
require_once(__DIR__ . '/../partials/head.php');
?>
<div class="show-profile">
  <div class="user-profile">
    <div>
      <div class="user-img">
        <img src="/public/img/<?= $myUser->getProfilePicture() ? $myUser->getProfilePicture() : "img_default.png" ?>" alt="<?= $myUser->getUsername() ?> profile picture">
      </div>
      <div class="user-info">
        <h3><?= $myUser->getUsername() ?></h3>
        <p><?= $myUser->getBio() ?  $myUser->getBio() : "" ?></p>
        <div class="user-follows">
          <p><span><?= $numberOfFollow ?  $numberOfFollow : "" ?></span> Abonnement</p>
          <p><span><?= $numberOfFollowing ?  $numberOfFollowing : "" ?></span> Abonnées</p>
        </div>
      </div>
    </div>
    <button class="active-btn">Editer le profile</button>
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
                  <img src="/public/img/<?= $myUser->getProfilePicture() ? $myUser->getProfilePicture() : "img_default.png" ?>" alt="<?= $myUser->getUsername() ?> profile pciture">
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
            <img src="/public/img/<?= $user->getProfilePicture() ? $user->getProfilePicture() : "img_default.png" ?>" alt="<?= $user->getUsername() ?> profile pciture">
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