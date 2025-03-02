<?php
require_once(__DIR__ . "/partials/head.php");
?>

<section class="add-postes">
  <form method="POST">
    <input type="text" placeholder="Quoi de nouveau?" class="post-input" name="post">
    <button type="submit" class="active-btn">Poster</button>
  </form>
</section>
<?php
require_once(__DIR__ . "/partials/footer.php");
?>