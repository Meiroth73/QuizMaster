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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@100..900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@100..900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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
                <h4>Odkrywaj Świat Wiedzy z QuizMaster</h4>
                <p>Witaj w przestrzeni, gdzie nauka staje się pasją, a edukacja staje się podróżą pełną odkryć i inspiracji. Nasza strona to oaza dla poszukiwaczy wiedzy, entuzjastów nauki i wszystkich, którzy pragną rozwinąć swoje umiejętności i pogłębić swoją wiedzę</p>
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
        <h2>7 losowych tematów</h2>
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
    <section class="section-category">
        <h4>Dostępne kategorie</h4>
        <div>
            <?php
                $sqlQuery = "SELECT * FROM category";
                $queryResult = $connection->query($sqlQuery);
                foreach($queryResult as $row) {
                    echo "<a href='./' class='category-box' style='background-image: url(./image/category/" . $row['image'] . ")'>";
                    echo "<p>".$row['title']."</p>";
                    echo "<a>";
                }
            ?>
        </div>
    </section>
    <section class="about">
        <div>
            <hr>
            <h3>O nas</h3>
            <p>Jesteśmy wiodącą firmą w dziedzinie edukacji online, oferującą nieograniczone możliwości odkrywania, nauki i inspiracji. Nasza różnorodna oferta została stworzona z myślą o każdym, kto pragnie rozwijać się i poszerzać horyzonty.</p>
            <p>Nasza firma to nie tylko platforma edukacyjna, to prawdziwe źródło inspiracji i wiedzy dla wszystkich, którzy pragną rozwijać się i poszerzać horyzonty. Dzięki zaawansowanym technologiom oraz starannie opracowanym kursom, artykułom i materiałom edukacyjnym, zapewniamy naszym użytkownikom dostęp do najnowszych trendów, eksperckiej wiedzy i praktycznych umiejętności.</p>
        </div>
    </section>
    <script src="main.js"></script>
</body>
</html>
