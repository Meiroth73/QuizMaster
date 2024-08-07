<?php 
    require_once("./config/config.php");

    try {
        $connection = new PDO("mysql:host=$database_host;dbname=$database_name", $database_user, $database_password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $commentView = false;
        $infoBoxText = "";

        if(isset($_POST['comment-textbox'])) {
            session_start();

            if(!isset($_POST['comments-star'])) {
                $stars = 0;
            } else {
                $stars = $_POST['comments-star'];
            }

            if(isset($_SESSION['user-id'])) {
                $stmt = $connection->prepare('SELECT `id`, `description` FROM `reviews` WHERE `user_id`=:uid LIMIT 1');
                $stmt->bindParam(':uid', $_SESSION['user-id']);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if($result) {
                    $stmt = $connection->prepare('UPDATE `reviews` SET `description`=:desc, `rate`=:rate WHERE `user_id`=:uid');
                    $stmt->bindParam(':desc', $_POST['comment-textbox']);
                    $stmt->bindParam(':rate', $stars);
                    $stmt->bindParam(':uid', $_SESSION['user-id']);
                    $stmt->execute();
                    $infoBoxText = "Zmodyfikowano komentarz";
                } else {
                    $stmt = $connection->prepare('INSERT INTO `reviews` (`user_id`, `date`, `rate`, `description`) VALUES (:userid, NOW(), :rate, :desc)');
                    $stmt->bindParam(':userid', $_SESSION['user-id']);
                    $stmt->bindParam(':rate', $stars);
                    $stmt->bindParam(':desc', $_POST['comment-textbox']);
                    $stmt->execute();
                    $infoBoxText = "Zapisano komentarz";
                }                 
            } else {
                $infoBoxText = "Aby dodać komentarz trzeba sie zalogować";
            }
            
            $commentView = true;
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
        <title>QuizMaster - Strona Główna</title>
        <link rel="shortcut icon" href="./image/favicon.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@100..900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@100..900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./styles/style_index.css">
        <link rel="stylesheet" href="./styles/style_global.css">
        <link rel="stylesheet" href="./styles/style_topic.css">
    </head>
    <body>
        <section class="document">
            <?php 
                require_once("elements/header.php");

                if($commentView) {
                    echo <<<INFO
                        <div class="comment-view" id="comment-view">
                            <p id="comment-view-text">{$infoBoxText}</p>
                        </div>
                    INFO;

                    echo "<script src='../scripts/removeinfo.js'></script>";
                }
            ?>
            <section class="document-body">
                <section class="section-motivation">
                    <div class="motivation-box motivation-box-1">
                        <div class="motivation-text-box">
                            <h4>Odkrywaj Świat Wiedzy z QuizMaster</h4>
                            <p>Witaj w przestrzeni, gdzie nauka staje się pasją, a edukacja staje się podróżą pełną odkryć i inspiracji. Nasza strona to oaza dla poszukiwaczy wiedzy, entuzjastów nauki i wszystkich, którzy pragną rozwinąć swoje umiejętności i pogłębić swoją wiedzę.</p>
                        </div>
                    </div>
                    <div class="motivation-box motivation-box-2">
                        <img src="./image/istockphoto-1291089965-612x612.jpg" alt="obraz">
                    </div>
                    <div class="motivation-box motivation-box-3">
                        <img src="./image/istockphoto-1340309186-612x612.jpg" alt="obraz">
                    </div>
                    <div class="motivation-box motivation-box-4">
                        <div class="motivation-text-box">
                            <h4>Wielobarwny Świat Wiedzy: Znajdź Swój Kawałek Inspiracji</h4>
                            <p>Przekonaj się, jakie tajemnice kryje wszechświat, zgłębiając nasze fascynujące kursy naukowe. A może szukasz praktycznych umiejętności, które pomogą Ci odnieść sukces w życiu osobistym i zawodowym? W takim razie zapraszamy do korzystania z naszych kursów z zakresu biznesu, zdrowego stylu życia, programowania i wielu innych.</p>
                        </div>
                    </div>
                    <div class="motivation-box motivation-box-5">
                        <div class="motivation-text-box">
                            <h4>Każdy znajdzie coś dla siebie!</h4>
                            <p>Czy jesteś miłośnikiem nauki ścisłej, entuzjastą sztuki, czy osobą poszukującą praktycznych umiejętności do zastosowania w codziennym życiu - mamy dla Ciebie coś specjalnego. Dla tych, którzy kochają odkrywanie tajemnic wszechświata, proponujemy nasze fascynujące kursy z dziedziny nauk przyrodniczych i technologii.</p>
                        </div>
                    </div>
                    <div class="motivation-box motivation-box-6">
                        <img src="./image/istockphoto-1189341947-612x612.jpg" alt="obraz">
                    </div>
                </section>
                <section class="section-topic">
                    <h2>Proponowane Tematy</h2>
                    <?php 
                        $sqlQuery = "SELECT topic.id, topic.category_id, topic.title, category.iconclass FROM topic JOIN category ON topic.category_id = category.id ORDER BY RAND() LIMIT 1";
                        $tabTopicIncludeID = array();
                        for($i = 1; $i < 4; $i++) {
                            echo "<div class='topic-row'>";
                            $n = ($i == 2) ? 3 : 2;
                            for($j = 1; $j <= $n;) {
                                $queryResult = $connection->query($sqlQuery);
                                $row = $queryResult->fetch(PDO::FETCH_ASSOC);
                                if (!in_array($row['category_id'], $tabTopicIncludeID)) {
                                    array_push($tabTopicIncludeID, $row['category_id']);
                                    $j++;
                                    echo <<<TOPIC
                                        <a href="quiz.php?t={$row['id']}">
                                            <div class="topic-box">
                                                <i class="fa-solid {$row['iconclass']}"></i>
                                                <p>{$row['title']}</p>
                                            </div>
                                        </a>
                                    TOPIC;
                                }
                            }
                            echo "</div>";
                        }
                    ?>
                </section>
                <?php
                    require_once('./elements/category.php');
                ?>
                <section class="about">
                    <div>
                        <hr>
                        <h3>O Autorze</h3><!-- generated by chatgpt -->
                        <p>Cześć, jestem początkującym programistą, tworzącym hobbistycznie projekt strony z quizami. Aktualnie pracuję nad implementacją różnych typów quizów, w tym quizów wielokrotnego wyboru, quizów z pytaniami otwartymi oraz quizów z zadaniami logicznymi. Moim celem jest stworzenie intuicyjnego i przyjaznego użytkownikowi interfejsu, który umożliwi łatwe tworzenie i rozwiązywanie quizów przez użytkowników</p>
                        <hr>
                        <h4>O Projekcje</h4>
                        <p>Nasza strona to nie tylko platforma edukacyjna, to prawdziwe źródło inspiracji i wiedzy dla wszystkich, którzy pragną rozwijać się i poszerzać horyzonty. Dzięki zaawansowanym technologiom oraz starannie opracowanym quizom, zapewniamy naszym użytkownikom dostęp do najnowszych trendów, eksperckiej wiedzy.</p>
                    </div>
                </section>
                <section class="section-comments">
                    <h3>Opinie naszych użytkowników</h3>
                    <section class="section-comments-section">
                        <button class="button-chevron-left comments-inactive-button" id="reviews-button-get-move-to-left">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <div id="comments-div">
                            <?php 
                                $n = 1;
                                $sqlQuery = "SELECT `reviews`.`id`, `reviews`.`date`, `reviews`.`user_id`, `reviews`.`rate`, `reviews`.`description`, `user`.`id`, `user`.`username`, `user`.`profileimage` FROM reviews JOIN user ON reviews.user_id = user.id";
                                $queryResult = $connection->query($sqlQuery);
                                foreach($queryResult as $row) {
                                    $date = date("d.m.Y", strtotime($row['date']));
                                    echo <<< REVIEWS
                                        <div class="reviews" id="review-id-{$n}">
                                            <div class="reviews-profile-wrapper">
                                                <div class="reviews-div-profile">
                                                    <img src="../image/profiles/{$row['profileimage']}" alt="user profile image" class="reviews-user-profile-image">
                                                    <p class="reviews-user-name">{$row['username']}</p>
                                                </div>
                                                <div class="reviews-div-profile-info">
                                                    <p class="reviews-date">{$date}</p>
                                                    <span rate="{$row['rate']}">
                                                        <p class="reviews-stars comments-star-inactive">&#9733;</p>
                                                        <p class="reviews-stars comments-star-inactive">&#9733;</p>
                                                        <p class="reviews-stars comments-star-inactive">&#9733;</p>
                                                        <p class="reviews-stars comments-star-inactive">&#9733;</p>
                                                        <p class="reviews-stars comments-star-inactive">&#9733;</p>
                                                    </span>
                                                </div>
                                            </div>
                                            <blockquote>{$row['description']}</blockquote>
                                        </div>
                                    REVIEWS;
                                    $n++;
                                }
                                $n = null;
                            ?>
                        </div>
                        <button class="button-chevron-right comments-active-button" id="reviews-button-get-move-to-right">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </section>
                    <h4>Masz swoje zdanie?</h4>
                    <p>My to szanujemy! Podziel sie nim ponizej!</p>
                    <div id="comments-div-btn">
                        <button id="comments-write-own-opinion-btn">Napisz swoją opinie</button>
                    </div>
                    <div id="comments-form">
                        <form action="" method="post">
                            <div>
                                <textarea name="comment-textbox" id="comment-textbox" cols="43" rows="8">
                                    <?php
                                        $userPublicOpinion = false;
                                        if(isset($_SESSION['user-id'])) {
                                            $stmt = $connection->prepare('SELECT `description` FROM `reviews` WHERE `user_id`=:uid LIMIT 1');
                                            $stmt->bindParam(':uid', $_SESSION['user-id']);
                                            $stmt->execute();
                                            $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                            if($result) {
                                                echo $result['description'];
                                                $userPublicOpinion = true;
                                            }
                                        } else {
                                            if(isset($_POST['comment-textbox'])) {
                                                echo $_POST['comment-textbox'];
                                            }
                                        }
                                    ?>
                                </textarea>
                                <?php
                                    if($userPublicOpinion) {
                                        $boolValue = 'true';
                                    } else {
                                        $boolValue = 'false';
                                    }

                                    echo <<< SCRIPT
                                        <script>
                                            let modifyPublishButtonText = {$boolValue};
                                        </script>
                                    SCRIPT;
                                ?>
                                <span>
                                    <label for="comments-star-1" class="comments-label" id="comment-label-1">&#9733;</label>
                                    <input type="radio" name="comments-star" id="comments-star-1" value="1">
                                    <label for="comments-star-2" class="comments-label" id="comment-label-2">&#9733;</label>
                                    <input type="radio" name="comments-star" id="comments-star-2" value="2">
                                    <label for="comments-star-3" class="comments-label" id="comment-label-3">&#9733;</label>
                                    <input type="radio" name="comments-star" id="comments-star-3" value="3">
                                    <label for="comments-star-4" class="comments-label" id="comment-label-4">&#9733;</label>
                                    <input type="radio" name="comments-star" id="comments-star-4" value="4">
                                    <label for="comments-star-5" class="comments-label" id="comment-label-5">&#9733;</label>
                                    <input type="radio" name="comments-star" id="comments-star-5" value="5">
                                </span>
                                <p class="error"><?php if(isset($_POST['comment-textbox']) && !isset($_SESSION['user-id'])) { echo "Aby dodać opinie nalerzy się zalogować!"; } ?></p>
                                <button type="submit" class="publish-review-button"><?php if($userPublicOpinion) { echo "Modyfikuj"; } else { echo "Opublikuj"; } ?></button>
                            </div>
                        </form>
                    </div>
                </section>
            </section>
        </section>
        <?php
            require_once('./elements/footer.html');
        ?>
        <script src="./scripts/main.js"></script>
    </body>
    <?php
        $connection = null;
    ?>
</html>
