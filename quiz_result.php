<?php
    require_once('./config/config.php');

    try {
        $connection = new PDO("mysql:host=$database_host;dbname=$database_name", $database_user, $database_password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error: ".$e->getMessage());
    }

    $questionIDs = $_POST['question-ids'];
    $questionIDsArray = explode(',' , $questionIDs);
    
    $questionCount = $_POST['question-count'];
    $userAnswers = array();
    $correctAnswers = array();

    for ($i = 1; $i <= $questionCount; $i++) {
        if(isset($_POST['question-'. strtolower($i)])) {
            array_push($userAnswers, $_POST['question-'.$i]);
        } else {
            array_push($userAnswers, 'no-select');
        }
    }

    $query = "SELECT `question`.`title`, `question`.`option-a`, `question`.`option-b`, `question`.`option-c`, `question`.`option-d`, `question`.`correct` FROM `question` WHERE id IN($questionIDs) ORDER BY FIELD(id, $questionIDs);";   
    
    $queryResult = $connection->query($query);
    $queryResultAssoc = $queryResult->fetchAll(PDO::FETCH_ASSOC);

    for ($i = 0; $i < count($queryResultAssoc); $i++) {
        array_push($correctAnswers, $queryResultAssoc[$i]["correct"]);
    }
    
    $numberOfCorrectAnswers = 0;

    for($i = 0; $i < $questionCount; $i++) {
        if(strtolower($userAnswers[$i]) == strtolower($correctAnswers[$i])) {
            $numberOfCorrectAnswers++;
        }
    }

    $obtainedResult = (($numberOfCorrectAnswers / $questionCount) * 100);
    
    session_start();

    if(isset($_SESSION['quiz-start-time'])) {
        $startTime = $_SESSION["quiz-start-time"];
        $endTime = time();
        $takeTime = $endTime - $startTime;
        $takeTimeMinutes = floor($takeTime / 60);
        $takeTimeSeconds = $takeTime % 60;

        $_SESSION['user-end-test'] = true;
        $sqlQuery;
        $stmt;
        $hash;

        if(isset($_SESSION["user-id"])) {
            $sqlQuery = 'INSERT INTO `quizmaster`.`solved`(`user_id`, `date`, `duration`, `questions_number`, `score`, `questions_ids`, `answers`, `type`) VALUES (:userid, NOW(), :time, :questionnumber, :score, :questionids, :answers, :type)';
            $stmt = $connection->prepare($sqlQuery);
            $stmt->bindParam(':userid', $_SESSION['user-id']);
        } else {
            $sqlQuery = 'INSERT INTO `quizmaster`.`temp_solved`(`hash`, `date`, `duration`, `questions_number`, `score`, `questions_ids`, `answers`, `type`) VALUES (:hash, NOW(), :time, :questionnumber, :score, :questionids, :answers, :type)';
            $stmt = $connection->prepare($sqlQuery);
            $hash = substr(bin2hex(random_bytes(ceil(32/2))),0,32);
            $stmt->bindParam(':hash', $hash);
        }

        $stmt->bindParam(':time', $takeTime);
        $stmt->bindParam(':questionnumber', $questionCount);
        $stmt->bindParam(':score', $obtainedResult);
        $stmt->bindParam(':questionids', $questionIDs);
        $stmt->bindParam(':answers', implode(',', $userAnswers));
        $stmt->bindParam(':type', $_SESSION['type']);
        $stmt->execute();
    }
    
    unset($_SESSION["quiz-start-time"]);

    $connection = null;
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>QuizMaster - Wyniki</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="../styles/style_global.css">
        <link rel="stylesheet" href="../styles/style_quiz_result.css">
        <link rel="shortcut icon" href="../image/favicon.png" type="image/x-icon">
    </head>
    <body>
        <section class="document">
            <?php 
                require_once('./elements/header.php');
            ?>
            <section class="document-body">
                <section class="section-info">
                    <hr>
                    <h1>Ukończno Quiz! <span>Uzyskany wynik: <?php echo $obtainedResult . '% ('. $numberOfCorrectAnswers . '/' . $questionCount . ')' ?></span></h1>
                    <hr>
                </section>
                <section class="section-quiz">
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
                </section>
                    <?php
                        if(!isset($_SESSION['user-id'])) {
                            echo <<<hash
                                <button id="hash-info">
                                    <p><i id="arrow" class="fa-solid fa-caret-right"></i> Klucz dostępu</p>
                                </button>
                                <div id="hash-wrapper">
                                    <div id="div-hash"><p>{$hash}</p></div>
                                </div>
                            hash;
                        }
                    ?>
            </section>
            <?php
                require_once('./elements/footer.html');
            ?>
        </section>
        <script src="../scripts/quiz_result.js"></script>
    </body>
</html>