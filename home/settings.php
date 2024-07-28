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
        $stmt = $connection->prepare('SELECT `name`, `lastname`, `username`, `email`, `description` FROM `user` WHERE `id`=:uid');
        $stmt->bindParam(':uid', $userid);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
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
                <a class="menu-button" href="../home/info.php">Informacje</a>
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
                    <h2 class="settings-h2">Główne dane</h2>
                    <form action="../home/update_settings.php" method="post" id="settings-form">
                        <section class="form-items-wrapper">
                            <label for="name">Imię: </label>    
                            <input type="text" name="name" id="name" value="<?php echo $userData['name']; ?>">
                            <label for="lastname">Nazwisko: </label>    
                            <input type="text" name="lastname" id="lastname" value="<?php echo $userData['lastname'] ?>">
                            <label for="username">Nazwa uzytkownika: </label>    
                            <input type="text" name="username" id="username" value="<?php echo $userData['username'] ?>">
                            <label for="email">Email: </label>    
                            <input type="email" name="email" id="email" value="<?php echo $userData['email'] ?>">
                            <label for="description">Opis: </label>    
                            <input type="text" name="description" id="description" value="<?php echo $userData['description'] ?>">
                        </section>
                        <button id="save-settings">Zapisz</button>
                    </form>
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