<?php
require_once(__DIR__ . '/../partials/noHeader.php');
?>
<section class="connexion-container">
  <div class="connexion-flex">
    <div>
      <img src="/public/img/logo.png" alt="pwitter logo" class="connexionLogo">
    </div>
    <div class="connexion-info">
      <h1>Connecte, partage, inspire.</h1>
      <div class="connexion-btn-container">
        <p>Inscrivez-vous.</p>
        <button class="active-btn" id="register-btn">Créer un compte</button>
        <p class="or">Ou</p>
        <button class="seconde-btn" id="login-btn">Se connecter</button>
      </div>
    </div>
    <div class="register-form">
      <form method="POST">
        <div>
          <div>
            <p>Content de vous compter parmis nous</p>
          </div>
          <?php
          if (isset($this->arraySucces['register'])) {
          ?>
            <div class="alert alert-success errorContainer" role="alert">
              <p class='text-success'><?= $this->arraySucces['register'] ?></p>
            </div>
          <?php
          }
          ?>
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
            <label for="mail">Mail</label>
            <input type="email" name="mail" id="mail">
            <?php
            if (isset($this->arrayError['mail'])) {
            ?>
              <div class="alert alert-danger" role="alert">
                <p class='text-danger'><?= $this->arrayError['mail'] ?></p>
              </div>
            <?php
            } ?>
          </div>
          <div class="">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password">
            <?php
            if (isset($this->arrayError['password'])) {
            ?>
              <div class="alert alert-danger" role="alert">
                <p class='text-danger'><?= $this->arrayError['password'] ?></p>
              </div>
            <?php
            } ?>
          </div>
          <div class="formLoginRegister">
            <button type="submit" class="">S'inscrire</button>
          </div>
        </div>
      </form>
    </div>
    <div class="login-form">
      <form method="POST">
        <div>
          <div>
            <p>Content de vous revoir</p>
          </div>
          <?php
          if (isset($this->arraySucces['register'])) {
          ?>
            <div class="alert alert-success errorContainer" role="alert">
              <p class='text-success'><?= $this->arraySucces['register'] ?></p>
            </div>
          <?php
          }
          ?>
          <div class="">
            <label for="mail">Mail</label>
            <input type="email" name="login-mail" id="mail">
            <?php
            if (isset($this->arrayError['mail'])) {
            ?>
              <div class="alert alert-danger" role="alert">
                <p class='text-danger'><?= $this->arrayError['mail'] ?></p>
              </div>
            <?php
            } ?>
          </div>
          <div class="">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password">
            <?php
            if (isset($this->arrayError['password'])) {
            ?>
              <div class="alert alert-danger" role="alert">
                <p class='text-danger'><?= $this->arrayError['password'] ?></p>
              </div>
            <?php
            } ?>
          </div>
          <div class="formLoginRegister">
            <button type="submit" class="activeFormBtn">Se connecter</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>