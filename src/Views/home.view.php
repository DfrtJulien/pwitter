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
      <p id="shoNewPost"></p>
      <?php
        if (isset($showPost)) {
      ?>
          <div id="post-focus">
            <div class="comment">
              <div class="post-user-info">
                <div class=" user-img">
                  <img src="/public/uploads/<?= $showPost->getProfilePicture() ? $showPost->getProfilePicture() : "img_default.png" ?>" alt="<?= $showPost->getUsername() ?> profile pciture">
                </div>
                <h2><?= $showPost->getUsername() ?></h2>
              </div>
              <p><?= $showPost->getContent() ?></p>
              <i class="fa-solid fa-xmark" id="close-comment"></i>
              <div class="add-comment-post">
                <form method="POST">
                  <input type="hidden" value="<?= $showPost->getId() ?>" name="post-id">
                  <input type="text" name="comment" placeholder="Poster votre réponse">
                  <button type="submit" class="active-btn">Envoyer</button>
                </form>
              </div>
              <div class="show-all-comment">
                <?php
                if (isset($allComment)) {
                  foreach ($allComment as $comment) {
                ?>
                    <div class="all-comment">
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
          <?php
        }
     
?>
  </div>
  </div>
  <div id="postList">

  </div>
</section>
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

<script>
  const userId = <?= $_SESSION['user']['user_id'] ?>
</script>
<?php


require_once(__DIR__ . "/partials/footer.php");
?>