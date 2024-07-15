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
        $stmt = $connection->prepare("SELECT `id`, `date`, `duration`, `questions_number`, `score` FROM `quizmaster`.`solved` WHERE `user_id`=:uid");
        $stmt->bindParam(":uid", $userid);
        $stmt->execute();
        $queryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <a class="menu-button first-option" href="../home/">Główna</a>
                <a class="menu-button" href="../home/info.php">Informacje</a>
                <a class="menu-button selected" href="../home/solved.php">Rozwiązane</a>
                <a class="menu-button" href="../home/settings.php">Ustawienia</a>
            </section>
             <section class="document-body" id="document-body">
                <main class="solved">
                    <table>
                        <tr>
                            <th>Numer:</th>
                            <th>Link do testu:</th>
                            <th>Data:</th>
                            <th>Czas:</th>
                            <th>Wynik:</th>
                            <th>Ilosc Pytan:</th>
                        </tr>
                        <?php
                            $i = 0;
                            foreach ($queryResult as $row) {
                                $i++;
                                $date = new DateTime($row['date']);
                                $dateFormat = $date->format('d-m-y');

                                $time = '';
                                if ($row['duration'] <= 59) {
                                    $time = $row['duration'].'s';
                                } else {
                                    $timeM = floor($row['duration'] / 60);
                                    $timeS = $row['duration'] % 60;
                                    $time = $timeM.'m '.$timeS.'s';
                                }

                                echo <<<TABLE
                                    <tr>
                                        <td>{$i}</td>
                                        <td><a href="../home/quiz_viev.php?id={$row['id']}">Kliknij aby otworzyć</a></td>
                                        <td>{$dateFormat}</td>
                                        <td>{$time}</td>
                                        <td>{$row['score']}</td>
                                        <td>{$row['questions_number']}</td>
                                    </tr>
                                TABLE;
                            }
                        ?>
                    </table>
                </main>
            </section> 
        </section>
        <script src="../scripts/home.js"></script>
    </body>
</html>