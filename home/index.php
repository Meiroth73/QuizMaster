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
                <a class="menu-button selected first-option" href="../home/">Główna</a>
                <a class="menu-button" href="../home/info.php">Informacje</a>
                <a class="menu-button" href="../home/solved.php">Rozwiązane</a>
                <a class="menu-button" href="../home/settings.php">Ustawienia</a>
            </section>
             <section class="document-body" id="document-body">
                <main class="home-main">
                    <div class="box color-1">
                        <p class="title">Liczba rozwiaznych quizów:</p>
                        <p class="value"></p>
                    </div>
                    <div class="box color-2">
                        <p class="title">Liczba udzielonych odpowiedzi:</p>
                        <p class="value"></p>
                    </div>
                    <div class="box color-3">
                        <p class="title">Czas spedzony na quizach:</p>
                        <p class="value"></p>
                    </div>
                    <div class="box color-4">
                        <p class="title">Czas na platwormie:</p>
                        <p class="value"></p>
                    </div>
                    <div class="box color-5">
                        <p class="title">Ostatnie logowanie:</p>
                        <p class="value"></p>
                    </div>
                    <div class="box color-6">
                        <p class="title">Data dołączenia:</p>
                        <p class="value"></p>
                    </div>
                </main>
            </section> 
        </section>
        <script src="../scripts/home.js"></script>
    </body>
</html>