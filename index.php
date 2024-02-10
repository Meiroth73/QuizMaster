<?php 
    require_once("./config/config.php");

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
    <title>QuizMaster</title>
    <link rel="shortcut icon" href="./image/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <div class="nav-logo">
                <a href="./" class="logo">
                    <p class="logo-part-1">Quiz</p>
                    <p class="logo-part-2">Master</p>
                </a>
            </div>
            <div class="nav-links">
                <a href="./" class="nav-btn no-select">Start</a>
                <a href="./" class="nav-btn no-select">Quizy</a>
                <a href="./" class="nav-btn no-select">Losuj 1 pytanie</a>
                <a href="./" class="nav-btn no-select">Ogłoszenia</a>
                <a href="./" class="nav-btn no-select">FAQ</a>
            </div>
            <div class="nav-div-login">
                <a href="./" class="nav-login">Zaloguj się</a>
                <p class="backslash">/</p>
                <a href="./" class="nav-register">Zarejestruj się</a>
            </div>
        </nav>
    </header>
    <section class="section-motivation">
        <div class="motivation-box motivation-box-1">
            <div class="motivation-text-box">
                <h4>Sprawć swoje umiejętności z QuizMaster</h4>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fugit quas minima libero amet! In repellendus magnam quo molestias unde sit sint quibusdam veritatis eveniet corporis, et aliquid sunt adipisci obcaecati.</p>
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
                <h4>Rozwijaj swoje umiejętności razem z nami</h4>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iste quisquam nisi dolores similique soluta expedita ipsam molestias impedit, debitis eos exercitationem, ducimus reiciendis tenetur omnis dignissimos nam magnam a vel!</p>
            </div>
        </div>
        <div class="motivation-box motivation-box-5">
            <div class="motivation-text-box">
                <h4>Każdy znajdzie coś dla siebie!</h4>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. A vero voluptates at sapiente, quidem praesentium et culpa! Labore quia ad modi sequi culpa, mollitia vel nobis obcaecati earum repellat doloremque?</p>
            </div>
        </div>
        <div class="motivation-box motivation-box-6">
            <img src="./image/istockphoto-1189341947-612x612.jpg" alt="obraz">
        </div>
    </section>
    <section class="section-topic">
        <h2>7 losowych tematów</h2>
        <?php 
            $sqlQuery = "SELECT topic.id, topic.category_id, topic.title, category.iconclass FROM topic JOIN category ON topic.category_id = category.id ORDER BY RAND() LIMIT 1";
            $tabTopicIncludeID = array();
            for($i = 1; $i < 4; $i++) {
                echo "<div class='topic-row'>";
                $n = ($i == 2) ? 3 : 2;
                for($j = 1; $j <= $n; $x = 10) {
                    $queryResult = $connection->query($sqlQuery);
                    $row = $queryResult->fetch(PDO::FETCH_ASSOC);
                    if (!in_array($row['category_id'], $tabTopicIncludeID)) {
                        array_push($tabTopicIncludeID, $row['category_id']);
                        $j++;
                        // echo "<a href='./x.php/?x=".$row['id']."'>";
                        echo "<a href='./'>";
                        echo "<div class='topic-box'>";
                        echo "<i class='fa-solid ".$row['iconclass']."'></i>";
                        echo "<p>".$row['title']."</p>";
                        echo "</div>";
                        echo "</a>";
                    }
                }
                echo "</div>";
            }
        ?>
    </section>
    <script src="main.js"></script>
</body>
</html>
