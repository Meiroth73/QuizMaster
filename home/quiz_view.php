<?php
    session_start();
    if (isset($_SESSION["user-id"])) {
        $userid = $_SESSION["user-id"];
    } else {
        header("Location: ../login.php");
    }

    if (isset($_GET["id"])) {
        $id = $_GET["id"];
    } else {
        header("../home/solved.php");
    }
    
    require_once('../config/config.php');

    $userAnswers = array();
    $correctAnswers = array();
    $queryResultAssoc = array();
    $questionCount;

    try {
        $connection = new PDO("mysql:host=$database_host;dbname=$database_name", $database_user, $database_password);
        $stmt = $connection->prepare("SELECT `user_id`, `duration`, `questions_number`, `score`, `questions_ids`, `answers` FROM `solved` WHERE `id`=:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $queryResult = $stmt->fetch(PDO::FETCH_ASSOC);

        $duration = $queryResult['duration'];
        $questionCount = $queryResult['questions_number'];

        $score = $queryResult['score'];
        $properCount = (int)($questionCount * ($score / 100));
        
        if($queryResult['user_id'] != $_SESSION['user-id']) {
            header('Location: ../home/solved.php');
        }

        $questionIds = $queryResult['questions_ids'];
   
        $stmt = $connection->prepare("SELECT `question`.`title`, `question`.`option-a`, `question`.`option-b`, `question`.`option-c`, `question`.`option-d`, `question`.`correct` FROM `question` WHERE id IN($questionIds) ORDER BY FIELD(id, $questionIds)");
        $stmt->execute();

        $queryResultAssoc =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        $userAnswers = explode(",", $queryResult['answers']);
        $questionCount = $queryResult['questions_number'];
        // echo $questionCount;

        for ($i = 0; $i < count($queryResultAssoc); $i++) {
            array_push($correctAnswers, $queryResultAssoc[$i]["correct"]);
        }

    } catch (PDOException $e) {
        die("Error: ".$e->getMessage());
    }
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>QuizMaster - Podgląd Quizu</title>
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
                <main class="quiz-view">
                    <?php
                        $options = ['A', 'B', 'C', 'D'];
                        for($i = 0; $i < $questionCount; $i++) {
                            $j = $i + 1;
                            echo '<section class="question-box">';
                            echo '<span class="question-title"><h3><p>'. $j . '.</p>' . $queryResultAssoc[$i]['title'] .'</h3></span>';
                            if($userAnswers[$i] == 'no-select') {
                                echo '<p class="no-select-info">Nie udzielono odpowiedzi!</p>';
                            }
                            foreach($options as $option) {
                                if(strtolower(($userAnswers[$i]) == strtolower($correctAnswers[$i]))) {
                                    if(strtolower($option) == strtolower($correctAnswers[$i])) {
                                        echo '<span class="answer-box correct-answer"><p class="letter">'.$option.'.</p>'. $queryResultAssoc[$i]['option-'. strtolower($option)] .'</span>';
                                    } else {
                                        echo '<span class="answer-box"><p class="letter">'.$option.'.</p>'. $queryResultAssoc[$i]['option-'. strtolower($option)] .'</span>';
                                    }
                                } else if (strtolower(($userAnswers[$i]) == 'no-select')) {
                                    if(strtolower($option) == strtolower($correctAnswers[$i])) {
                                        echo '<span class="answer-box correct-answer-none"><p class="letter">'.$option.'.</p>'. $queryResultAssoc[$i]['option-'. strtolower($option)] .'</span>';
                                    } else {
                                        echo '<span class="answer-box"><p class="letter">'.$option.'.</p>'. $queryResultAssoc[$i]['option-'. strtolower($option)] .'</span>';
                                    }
                                } else {
                                    if(strtolower($option) == strtolower($correctAnswers[$i])) {
                                        echo '<span class="answer-box correct-answer"><p class="letter">'.$option.'.</p>'. $queryResultAssoc[$i]['option-'. strtolower($option)] .'</span>';
                                    } elseif (strtolower($option) == strtolower($userAnswers[$i])) {
                                        echo '<span class="answer-box incorrect-answer"><p class="letter">'.$option.'.</p>'. $queryResultAssoc[$i]['option-'. strtolower($option)] .'</span>';
                                    } else {
                                        echo '<span class="answer-box"><p class="letter">'.$option.'.</p>'. $queryResultAssoc[$i]['option-'. strtolower($option)] .'</span>';
                                    }
                                }
                            }
                            echo '</section>';
                        }
                    ?>
                </main>
            </section> 
        </section>
        <script src="../scripts/home.js"></script>
        <?php
            $connection = null;
        ?>
    </body>
</html>