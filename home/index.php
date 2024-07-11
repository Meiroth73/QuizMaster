<?php
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
        <title>QuizMaster - Strona domowa</title>
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
                <button class="menu-button selected" id="menu-main" index="1">Główna</button>
                <button class="menu-button" id="menu-info" index="2">Informacje</button>
                <button class="menu-button" id="menu-settings" index="3">Ustawienia</button>
            </section>
            <section class="document-body" id="document-body">
                <?php
                    include('./elements/main.php');
                ?>
            </section>
        </section>
        <script src="../scripts/home.js"></script>
    </body>
</html>