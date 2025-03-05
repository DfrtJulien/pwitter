<?php
require_once(__DIR__ . "/partials/head.php");
?>
<div>
  <section class="add-postes">
    <form method="POST" id="post-form">
      <input type="text" placeholder="Quoi de nouveau?" class="post-input" name="post">
      <button type="submit" class="active-btn" id="submit-btn">Poster</button>
    </form>
  </section>
  <section class="show-post">
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
  </section>
</div>
<?php
require_once(__DIR__ . "/partials/footer.php");
?>