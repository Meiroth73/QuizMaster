<!-- <?php

//require_once('../config/config.php');

$database_host = "192.168.33.2";
$database_name = "quizmaster";
$database_user = "root";
$database_password = "zaq1@WSX";


try {
    $connection = new PDO("mysql:host=$database_host;dbname=$database_name", $database_user, $database_password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: ".$e->getMessage());
}

$userId = 0;
    $querySolvedCount = "SELECT COUNT(*) FROM `quizmaster`.`solved` WHERE `user_id`=$userId";
    $queryResultSolvedCount = $connection->query($querySolvedCount);
    $solvedCount;

    while ($row = $queryResultSolvedCount->fetch(PDO::FETCH_ASSOC)) {
        $solvedCount = $row['COUNT(*)'];
    }

    echo $solvedCount;
?>
<main>
    <div class="color-1"></div>
    <div class="color-2"></div>
    <div class="color-3"></div>
    <div class="color-4"></div>
    <div class="color-5"></div>
    <div class="color-6"></div>
</main> -->
