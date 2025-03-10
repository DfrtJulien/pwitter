<?php
require_once(__DIR__ . "/partials/head.php");
?>

<section class="add-postes">
  <form method="POST" id="post-form">
    <input type="text" placeholder="Quoi de nouveau?" class="post-input" name="post">
    <button type="submit" class="active-btn" id="submit-btn">Poster</button>
  </form>

  <div class="show-post">
    <div>
      <?php
      foreach ($posts as $post) {
      ?>
        <div class="post">
          <div class="post-user-info">
            <div class="user-img">
              <img src="/public/img/<?= $post->getProfilePicture() ? $post->getProfilePicture() : "img_default.png" ?>" alt="<?= $post->getUsername() ?> profile pciture">
            </div>
            <h5><?= $post->getUsername() ?></h5>
          </div>
          <p><?= $post->getContent() ?></p>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
</section>
<div class="show-users-container">
  <?php
  foreach ($users as $user) {
  ?>
    <div class="show-users">
      <div class="post-user-info">
        <div class="user-img">
          <img src="/public/img/<?= $post->getProfilePicture() ? $post->getProfilePicture() : "img_default.png" ?>" alt="<?= $post->getUsername() ?> profile pciture">
        </div>
        <h5><?= $post->getUsername() ?></h5>
      </div>
      <form mthod="POST">
        <input type="hidden" value="<?= $user->getId() ?>">
        <button type="submit" class="active-btn">Suivre</button>
      </form>
    </div>
  <?php
  }
  ?>
</div>
<?php
require_once(__DIR__ . "/partials/footer.php");
?>