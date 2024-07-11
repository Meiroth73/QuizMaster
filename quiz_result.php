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

    // echo count($queryResultAssoc);

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
    $startTime = $_SESSION["quiz-start-time"];
    $endTime = time();
    $takeTime = $endTime - $startTime;
    $takeTimeMinutes = floor($takeTime / 60);
    $takeTimeSeconds = $takeTime % 60;

    $connection = null;
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>QuizMaster - Wyniki</title>
        <link rel="shortcut icon" href="./image/favicon.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="../styles/style_global.css">
        <link rel="stylesheet" href="../styles/style_quiz_result.css">
    </head>
    <body>
        <section class="document">
            <?php 
                require_once('./elements/header.php');
            ?>
            <section class="document-body">
                <section class="section-info">
                    <!-- <?php
                        //echo "<p>". $numberOfCorrectAnswers ." / ". $questionCount ."(". (($numberOfCorrectAnswers / $questionCount) * 100)."%)</p>";
                        //echo '<br>';
                        //echo $takeTimeMinutes;
                        //echo '<br>'. $takeTimeSeconds;
                    ?> -->

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
            </section>
            <?php
                require_once('./elements/footer.html');
            ?>
        </section>
    </body>
</html>