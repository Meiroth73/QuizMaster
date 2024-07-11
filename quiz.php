<?php
    require_once('./config/config.php');

    try {
        $connection = new PDO("mysql:host=$database_host;dbname=$database_name", $database_user, $database_password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error: ".$e->getMessage());
    }

    $topicId;

    if(isset($_GET['t'],$_GET['c'])) {
        header("Location: ./category.php");
    } else {
        if(isset($_GET['t'])) {
            $id = $_GET['t'];
            $sqlQuery = "SELECT `question`.`id`, `question`.`title`, `question`.`option-a`, `question`.`option-b`, `question`.`option-c`, `question`.`option-d` FROM `question` WHERE `question`.`topic_id`=$id AND `question`.`id` != 1 ORDER BY RAND() LIMIT 5";
            $queryResult = $connection->query($sqlQuery);
        }

        if(isset($_GET['c'])) {
            $id = $_GET['c'];
            $sqlQuery = "SELECT `question`.`id`, `question`.`title`, `question`.`option-a`, `question`.`option-b`, `question`.`option-c`, `question`.`option-d` FROM `question` WHERE `question`.`category_id`=$id AND `question`.`id` != 1 ORDER BY RAND() LIMIT 5";
            $queryResult = $connection->query($sqlQuery);
        }
    }

    ini_set('session.gc_maxlifetime', 3600);
    ini_set('session.cookie_lifetime', 3600);
    
    session_start();
    $_SESSION['quiz-start-time'] = time();
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>QuizMaster - Quiz</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@100..900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poetsen+One&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./styles/style_global.css">
        <link rel="stylesheet" href="./styles/style_quiz.css">
        <link rel="shortcut icon" href="./image/favicon.png" type="image/x-icon">
    </head>
    <body>
        <section class="document">
                <?php 
                    require_once("./elements/header.php");
                ?>
                <section class="document-body">
                    <section class="section-info">
                        <h1>Quiz z pytań</h1>
                    </section>
                    <section class="section-quiz">
                        <form action="../quiz_result.php" method="post">
                            <?php
                                $i = 0;
                                $questionIDs = [];
                                foreach($queryResult as $row) {
                                    $i-=-1;
                                    array_push($questionIDs, $row['id']);
                                    echo <<<QUESTION
                                        <div class="question-box">
                                            <span class="span-question-title">
                                                <h3>{$i}. {$row['title']}</h3>
                                            </span>
                                            <span class="span-question-answer">
                                                <input type="radio" name="question-{$i}" id="ans-{$row['id']}-a" class="display-none" value="a">
                                                <label for="ans-{$row['id']}-a"><p><p class="letter">A.</p> {$row['option-a']}</p></label>
                                            </span>
                                            <span class="span-question-answer">
                                                <input type="radio" name="question-{$i}" id="ans-{$row['id']}-b" class="display-none" value="b">
                                                <label for="ans-{$row['id']}-b"><p><p class="letter">B.</p> {$row['option-b']}</p></label>
                                            </span>
                                            <span class="span-question-answer">
                                                <input type="radio" name="question-{$i}" id="ans-{$row['id']}-c" class="display-none" value="c">
                                                <label for="ans-{$row['id']}-c"><p><p class="letter">C.</p> {$row['option-c']}</p></label>
                                            </span>
                                            <span class="span-question-answer">
                                                <input type="radio" name="question-{$i}" id="ans-{$row['id']}-d" class="display-none" value="d">
                                                <label for="ans-{$row['id']}-d"><p><p class="letter">D.</p> {$row['option-d']}</p></label>
                                            </span>
                                        </div>
                                    QUESTION;

                                }
                                $strQuestionIDs = implode(',', $questionIDs);
                                echo "<input type='hidden' name='question-ids' value='$strQuestionIDs'>";
                                echo "<input type='hidden' name='question-count' value='$i'>";
                                $i = null;
                            ?>
                            <section>
                                <button type="submit">Sprawdź</button>
                                <button type="reset">Wyczyść</button>
                            </section>
                        </form>
                    </section>
                </section>
                <?php
                    require_once('./elements/footer.html');
                ?>
        </section>
    </body>
    <?php
        $connection = null;
    ?>
</html>