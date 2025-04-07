<?php
require_once(__DIR__ . "/partials/head.php");
?>
<div class="search-user">
    <h1>Message</h1>
    <form method="GET" action="/message" class="search-form-container">
        <div class="search-container">
            <input type="text" class="search-bar" placeholder="Rechercher" name="searching-terms">
            <button type="submit" class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </form>
<div class="show-user-message">
    <?php  
    if (isset($search_terms)) {
        if ($searcheUsers) {
            ?>
            <div id="searched">
            <?php
            foreach ($searcheUsers as $user) {
    ?>
                <div class="post" >
                    <a href="/profile?id=<?= $user->getId() ?>">
                        <div class="post-user-info">
                            <div class="user-img">
                                <img src="/public/uploads/<?= $user->getProfilePicture() ? $user->getProfilePicture() : "img_default.png" ?>" alt="<?= $user->getUsername() ?> profile pciture">
                            </div>
                            <h5><?= $user->getUsername() ?></h5>
                        </div>
                    </a>
                    <form method="POST">
                        <input type="hidden" name="send-msg" value="<?= $user->getId() ?>">
                        <button type="submit" class="active-btn send-msg-btn">Envoyer un message</button>
                    </form>
                </div>
            <?php
            }
            ?>
              </div>
              <?php
        } else {
            ?>
            <h2>Nous n'avons rien trouvé 😥</h2>
    <?php
        }
    } elseif (isset($showAllMessage)){
        foreach($showAllMessage as $message){
            ?>
            <div class="one-message">
                <div class="show-message-user-info"> 
                    <div class="user-img">
                        <img src="/public/uploads/<?= $message->getProfilePicture() ? $message->getProfilePicture() : "img_default.png" ?>" alt="">
                    </div>
                    <h5><?= $message->getUsername() ?></h5>
                </div>
                <p class="message-content"><?= $message->getMessage() ?></p>
                <form method="POST">
                        <input type="hidden" name="send-msg" value="<?= $message->getSenderId() != $_SESSION['user']['user_id'] ? $message->getSenderId() : $message->getReceiverId() ?>">
                        <button type="submit" class="active-btn send-msg-btn">Envoyer un message</button>
                    </form>
            </div>
            <?php
        }
    }
    ?>
</div>
</div>
<div class="show-message">
    <?php
    if (isset($userToSendMsg)) {
    ?>
        <div id="message">
            <div>
                <div class="">
                    <div class="show-message-user-info">
                        <div class="user-img">
                            <img src="/public/uploads/<?= $userToSendMsg->getProfilePicture() ? $userToSendMsg->getProfilePicture() : "img_default.png" ?>" alt="<?= $user->getUsername() ?> profile pciture">
                        </div>
                        <h5><?= $userToSendMsg->getUsername() ?></h5>
                    </div>
                </div>
            </div>
            <div class="message-container">
                <?php
                if (isset($messages)) {
                    foreach ($messages as $message) {
                        if ($_SESSION['user']["user_id"] == $message->getSenderId()) {
                ?>
                            <div class="my-message">            
                                <p><?= $message->getMessage() ?></p>
                            </div>
                        <?php
                        } else {
                        ?>
                             <div class="received-message">            
                                <p><?= $message->getMessage() ?></p>
                            </div>
                <?php
                        }
                    }
                }
                ?>
            </div>
            <div class="message-container">
                <form method="POST">
                    <input type="hidden" name="userId" value="<?= $userToSendMsg->getId() ?>">
                    <input type="text" class="search-bar" placeholder="Rechercher" name="message">
                    <button type="submit" class="active-btn">Envoyer votre message</button>
                </form>
            </div>
        </div>
    <?php
    }

    ?>
</div>

<?php

include_once(__DIR__ . "/partials/footer.php");