<?php 
    require_once("./config/config.php");

    try {
        $connection = new PDO("mysql:host=$database_host;dbname=$database_name", $database_user, $database_password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $connection->prepare('SELECT `date`, DATE_FORMAT(`date`, "%W") AS `day_of_week`, `announcement_image`, `title`, `description` FROM `announcements` ORDER BY `date` DESC');
        $stmt->execute();
        $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("Error: ".$e->getMessage());
    }
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>QuizMaster - Ogłoszenia</title>
        <link rel="shortcut icon" href="./image/favicon.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="../styles/style_global.css">
        <link rel="stylesheet" href="../styles/style_announcements.css">
    </head>
    <body>
        <section class="document">
                <?php 
                    require_once('./elements/header.php');
                ?>
                <section class="document-body">
                    <h1>Tablica ogłoszeń</h1>
                    <main>
                        <?php
                            foreach($announcements as $announcement) {
                                $date = new DateTime($announcement['date']);
                                $date = $date->format('d.m.y');

                                $daysTranslation = [
                                    'Monday' => 'Poniedziałek',
                                    'Tuesday' => 'Wtorek',
                                    'Wednesday' => 'Środa',
                                    'Thursday' => 'Czwartek',
                                    'Friday' => 'Piątek',
                                    'Saturday' => 'Sobota',
                                    'Sunday' => 'Niedziela'
                                ];

                                echo <<<ANNOUNCEMENT
                                    <section class="announcement-wrapper">
                                        <div class="left-div">
                                            <img src="./image/{$announcement['announcement_image']}" alt="">
                                        </div>
                                        <div class="right-div">
                                            <p class="date">{$daysTranslation[$announcement['day_of_week']]} {$date}</p>
                                            <h2>{$announcement['title']}</h2>
                                            <p class="description">{$announcement['description']}</p>
                                        </div>
                                    </section> 
                                ANNOUNCEMENT;
                            }
                        ?>
                    </main>
                </section>
                <?php
                    require_once('./elements/footer.html');
                ?>
        </section>
    </body>
</html>