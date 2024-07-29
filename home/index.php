<?php
    session_start();
    if (isset($_SESSION["user-id"])) {
        $userId = $_SESSION["user-id"];
        $lastLoginText = $_SESSION['last-login'];
    } else {
        header("Location: ../login.php");
    }

    require_once('../config/config.php');

    try {
        $connection = new PDO("mysql:host=$database_host;dbname=$database_name", $database_user, $database_password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $stmt = $connection->prepare('SELECT COUNT(*) AS `count`, SUM(`duration`) AS `duration` FROM `solved` WHERE `user_id`=:uid');
        $stmt->bindParam(':uid', $userId);
        $stmt->execute();
        $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);
        $solvedCount = $queryResult['count'];
        $solvedDuration = $queryResult['duration'];

        $stmt = $connection->prepare('SELECT `answers` FROM `solved` WHERE `user_id`=:uid');
        $stmt->bindParam(':uid', $userId);
        $stmt->execute();
        $answersArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $connection->prepare('SELECT `createdate` FROM `user` WHERE `id`=:uid');
        $stmt->bindParam(':uid', $userId);
        $stmt->execute();
        $joinDateText = $stmt->fetch(PDO::FETCH_ASSOC);

        // $stmt = $connection->prepare('');

    } catch (PDOException $e) {
        die("Error: ".$e->getMessage());
    }

    if ($solvedDuration < 60) {
        if($solvedDuration) {
            $solvedDuration = $solvedDuration.'s';
        } else {
            $solvedDuration = '0';
        }
    } else {
        if ($solvedDuration < 3600) {
            $minutes = (int)($solvedDuration / 60);
            $seconds = ($solvedDuration % 60);
            if($seconds == 0) {
                $solvedDuration = $minutes.'m';
            } else {
                $solvedDuration = $minutes.'m '.$seconds.'s';
            }
        } else {
            $hours = (int)($solvedDuration / 3600);
            $solvedDuration = ($solvedDuration - ($hours * 3600));
            $minutes = (int)($solvedDuration / 60);
            $seconds = ($solvedDuration % 60);
            $solvedDuration = $hours.'h'; 
            if($minutes != 0) {
                $solvedDuration = $solvedDuration.' '.$minutes.'m';
            }
            if($seconds != 0) {
                $solvedDuration = $solvedDuration.' '.$seconds.'s';
            }
        }
    }

    $answersCount = 0;

    foreach($answersArray as $answer) {
        $answers = explode(',', $answer['answers']);
        foreach($answers as $answer) {
            if($answer != 'no-select') {
                $answersCount++;
            }
        }
    }

    $joinDateTime = new DateTime($joinDateText['createdate']);
    $nowTime = new DateTime();
    $timeDifference = $nowTime->diff($joinDateTime);

    $date = new DateTime($lastLoginText);
    $lastlogin = $date->format('d.m.y');

    $date = new DateTime($joinDateText['createdate']);
    $joinDate = $date->format('d.m.y');
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
                        <p class="value"><?php echo $solvedCount; ?></p>
                    </div>
                    <div class="box color-2">
                        <p class="title">Liczba udzielonych odpowiedzi:</p>
                        <p class="value"><?php echo $answersCount; ?></p>
                    </div>
                    <div class="box color-3">
                        <p class="title">Czas spedzony na quizach:</p>
                        <p class="value"><?php echo $solvedDuration; ?></p>
                    </div>
                    <div class="box color-4">
                        <p class="title">Czas na platwormie:</p>
                        <p class="value"><?php echo $timeDifference->days; ?> dni</p>
                    </div>
                    <div class="box color-5">
                        <p class="title">Ostatnie logowanie:</p>
                        <p class="value"><?php echo $lastlogin; ?></p>
                    </div>
                    <div class="box color-6">
                        <p class="title">Data dołączenia:</p>
                        <p class="value"><?php echo $joinDate; ?></p>
                    </div>
                </main>
            </section> 
        </section>
    </body>
</html>