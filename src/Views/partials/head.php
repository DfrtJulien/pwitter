<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Pwitter
    </title>
    <script src="https://kit.fontawesome.com/f5a1d28d53.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./public/style/style.css">
</head>

<body>
    <div class="body">
        <nav class="desktop-nav">
            <div class="nav-container">
                <a href="/">
                    <img src="/public/img/logo.png" alt="Pwitter Logo" class="logo">
                </a>
                <a href="/">
                    <div class="nav-flex">
                        <i class="fa-solid fa-house"></i>
                        <p>Accueil</p>
                    </div>
                </a>
                <a href="/">
                    <div class="nav-flex">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <p>Rechercher</p>
                    </div>
                </a>
                <a href="/">
                    <div class="nav-flex">
                        <i class="fa-regular fa-envelope"></i>
                        <p>Message</p>
                    </div>
                </a>
                <a href="/logout">
                    <div class="nav-flex">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <p>Déconnexion</p>
                    </div>
                </a>
            </div>
        </nav>
        <nav class="mobile-nav">
            <div class="nav-mobile-container">
                <div class="user-img">
                    <img src="/public/img/<?= $_SESSION["user"]["img"] ? $_SESSION["user"]["img"] : "img_default.png" ?>" alt="">
                </div>
                <a href="/" class="logo-nav-mobile">
                    <img src="/public/img/logo.png" alt="Pwitter Logo" class="logo">
                </a>
            </div>
        </nav>