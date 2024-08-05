<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once('../config/config.php');

        session_start();
        $userId = $_SESSION['user-id'];

        try {
            $connection = new PDO("mysql:host=$database_host;dbname=$database_name", $database_user, $database_password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $connection->prepare('SELECT `password` FROM `user` WHERE `id`=:uid');
            $stmt->bindParam(':uid', $userId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!($result && password_verify($_POST['old-password'], $result['password']))) {
                return false;
            }

            $stmt = $connection->prepare('UPDATE `user` SET `password`=:password WHERE `id`=:uid');
            $stmt->bindParam(':uid', $userId);
            $stmt->bindParam(':password', password_hash($_POST['new-password'], PASSWORD_BCRYPT));
            $stmt->execute();

        } catch (PDOException $e) {
            die("Error: ".$e->getMessage());
        }
    }

    header('Location: ../home/settings.php');

    $connection = null;
?>