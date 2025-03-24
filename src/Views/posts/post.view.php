<?php
require_once(__DIR__ . '/../partials/head.php');
?>

<div>
  <div class="show-post">
    <div class="post">
      <div class="post-user-info">
        <div class=" user-img">
          <img src="/public/uploads/<?= $postInfo->getProfilePicture() ? $postInfo->getProfilePicture() : "img_default.png" ?>" alt="<?= $postInfo->getUsername() ?> profile pciture">
        </div>
        <h2><?= $postInfo->getUsername() ?></h2>
      </div>
      <p><?= $postInfo->getContent() ?></p>
      <div class="add-comment-post">
        <form method="POST">
          <input type="hidden" value="<?= $postInfo->getId() ?>" name="post-id">
          <input type="text" name="comment" placeholder="Poster votre réponse">
          <button type="submit" class="active-btn">Envoyer</button>
        </form>
      </div>
    </div>
    <div class="show-all-comment">
      <?php
      if (isset($allComment)) {
        foreach ($allComment as $comment) {
      ?>
          <div class="post">
            <a href="/profile?id=<?= $comment->getUserId() ?>">
              <div class="comment-user-info">
                <div class="user-img">
                  <img src="/public/uploads/<?= $comment->getProfilePicture() ? $comment->getProfilePicture() : "img_default.png" ?>" alt="<?= $comment->getUsername() ?> profile pciture">
                </div>
                <h4><?= $comment->getUsername() ?></h4>
              </div>
              <p><?= $comment->getContent() ?></p>
            </a>
          </div>
      <?php
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