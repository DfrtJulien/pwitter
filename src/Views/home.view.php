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
        <div>
          <p><?= $post->getContent() ?></p>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
</section>
<div>
  <?php
  foreach ($users as $user) {
  ?>
    <div>
      <p><?= $user->getUsername() ?></p>
      <form mthod="POST">
        <input type="hidden" value="<?= $user->getId() ?>">
        <button type="submit">Suivre</button>
      </form>
    </div>
  <?php
  }
  ?>
</div>
<?php
require_once(__DIR__ . "/partials/footer.php");
?>