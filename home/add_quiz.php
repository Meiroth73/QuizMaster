<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['key'])) {
        $key = $_POST['key'];

        session_start();
        $userid = $_SESSION["user-id"];
    
        require_once('../config/config.php');
    
        try {
            $connection = new PDO("mysql:host=$database_host;dbname=$database_name", $database_user, $database_password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $connection->prepare("SELECT `date`, `duration`, `questions_number`, `score`, `questions_ids`, `answers`, `type` FROM `temp_solved` WHERE `key`=:key");
            $stmt->bindParam(":key", $key);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if($result) {
                $sqlQuery = 'INSERT INTO `quizmaster`.`solved`(`user_id`, `date`, `duration`, `questions_number`, `score`, `questions_ids`, `answers`, `type`) VALUES (:userid, :date, :time, :questionnumber, :score, :questionids, :answers, :type)';
                $stmt = $connection->prepare($sqlQuery);
                $stmt->bindParam(':userid', $_SESSION['user-id']);
                $stmt->bindParam(':date', $result['date']);
                $stmt->bindParam(':time', $result['duration']);
                $stmt->bindParam(':questionnumber', $result['questions_number']);
                $stmt->bindParam(':score', $result['score']);
                $stmt->bindParam(':questionids', $result['questions_ids']);
                $stmt->bindParam(':answers', $result['answers']);
                $stmt->bindParam(':type', $result['type']);
                $stmt->execute();

                $stmt = $connection->prepare('DELETE FROM `temp_solved` WHERE `key`=:key');
                $stmt->bindParam(':key', $key);
                $stmt->execute();
            } else {
                
            }
        } catch (PDOException $e) {
            die("Error: ".$e->getMessage());
        }
    }

    header('Location: ../home/solved.php');
?>