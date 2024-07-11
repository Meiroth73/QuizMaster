<?php
    require_once("./config/config.php");
    
    try {
        $connection = new PDO("mysql:host=$database_host;dbname=$database_name", $database_user, $database_password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if(isset($_POST['comment-textbox']) && isset($_POST['comments-star'])) {
            $sqlQuery = "INSERT INTO reviews (`user_id`, `date`, `rate`, `description`) VALUES (1, NOW(), ".$_POST['comments-star'].", '".$_POST['comment-textbox']."');";
            $connection->query($sqlQuery);
        }

    } catch (PDOException $e) {
        die("Error: ".$e->getMessage());
    }

    $categoryId;
    $isCategorySelected = false;

    if(isset($_GET['c']) && ((int)($_GET['c']) >= 1 && (int)($_GET['c']) <= 15)) {
        $categoryId = $_GET['c'];
    } else {
        $isCategorySelected = true;
    }


?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>QuizMaster - Kategorie</title>
        <link rel="shortcut icon" href="./image/favicon.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@100..900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poetsen+One&family=Roboto+Condensed:ital,wght@1,100..900&family=Suez+One&family=Ultra&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./styles/style_global.css">
        <link rel="stylesheet" href="./styles/style_topic.css">
        <link rel="stylesheet" href="./styles/style_quiz.css">
    </head>
    <body>
        <section class="document">
            <?php 
                require_once('./elements/header.php');
            ?>
            <section class="document-body" style="margin-top: -20px">
                <main>
                    <?php
                        if($isCategorySelected) {
                            require_once('./elements/category.php');
                        } else {
                            $sqlQuery = "SELECT topic.id, topic.title FROM topic WHERE topic.category_id = $categoryId";
                            $queryResult = $connection->query($sqlQuery);
                            foreach($queryResult as $row) {
                                echo <<<TOPIC
                                    <a href="../quiz.php?t={$row['id']}" class="topic-box"> 
                                        <p>{$row['title']}</p>
                                    </a>
                                TOPIC;
                            }
                            echo <<<TOPIC
                                <a href="../quiz.php?c={$categoryId}" class="topic-box"> 
                                    <p>Wszystko</p>
                                </a>
                            TOPIC;
                        }
                    ?>
                </main>
            </section>
            <?php
                require_once('./elements/footer.html');
            ?>
        </section>
        <script src="../scripts/quiz.js"></script>
    </body>
    <?php
        $connection = null;
    ?>
</html>