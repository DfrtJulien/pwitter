<?php
require_once(__DIR__ . "/partials/head.php");
?>
<div class="show-post">
    <h1 class="search-title">Que cherchez vous ?</h1>
<form method="GET" action="/search" class="search-form-container">
    <div class="search-container">
        <input type="text" class="search-bar" placeholder="Rechercher" name="searching-terms">
        <button type="submit" class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>
</form>
<?php
    if(isset($search_terms)){
      if($searcheUsers){
        foreach($searcheUsers as $user){

        
        ?>
       <div class="post">
        <a href="/profile?id=<?= $user->getId() ?>">
              <div class="post-user-info">
                <div class="user-img">
                  <img src="/public/uploads/<?= $user->getProfilePicture() ? $user->getProfilePicture() : "img_default.png" ?>" alt="<?= $user->getUsername() ?> profile pciture">
                </div>
                <h5><?= $user->getUsername() ?></h5>
              </div> 
        </a>
      </div>
<?php
}
    } else {
      ?>
        <h2>Nous n'avons rien trouvé 😥</h2>
      <?php
    }
  }
?>
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
include_once(__DIR__ . "/partials/footer.php");