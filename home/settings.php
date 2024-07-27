<?php
    session_start();
    if (isset($_SESSION["user-id"])) {
        $userid = $_SESSION["user-id"];
    } else {
        header("Location: ../login.php");
    }

    require_once('../config/config.php');

    try {
        $connection = new PDO("mysql:host=$database_host;dbname=$database_name", $database_user, $database_password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error: ".$e->getMessage());
    }
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>QuizMaster - Ustawienia</title>
        <link rel="shortcut icon" href="../image/favicon.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="../styles/style_global.css">
        <link rel="stylesheet" href="../styles/style_home.css">
    </head>
    <body>
        <section class="document">
            <?php 
                require_once('../elements/header.php');
            ?>
            <section class="menu">
                <a class="menu-button first-option" href="../home/">Główna</a>
                <a class="menu-button"href="../home/info.php">Informacje</a>
                <a class="menu-button" href="../home/solved.php">Rozwiązane</a>
                <a class="menu-button selected" href="../home/settings.php">Ustawienia</a>
            </section>
             <section class="document-body" id="document-body">
                <main class="settings">
                    <h2 class="settings-h2">Zdjęcie profilowe</h2>
                    <section id="profile-image-wrapper">
                        <img src="../image/profiles/<?php echo $_SESSION['profile-image'] ?>" alt="profile image" id="profile-image">
                    </section>
                    <form action="../home/update_profile.php" method="post" enctype="multipart/form-data">
                        <button id="load-file-button" class="profile-button">Wybierz plik</button>
                        <input type="file" name="file-input" id="file-input" class="display-none">
                        <button id="save-button" type="submit" class="profile-button">Zapisz</button>
                    </form> 
                    <p id="file-error"></p>
                    <hr>
                    <section>
                        <a class="button-logout" href="../logout.php">Wyloguj się</a>
                    </section>
                </main>
            </section> 
        </section>
        <script src="../scripts/settings.js"></script>
    </body>
</html>