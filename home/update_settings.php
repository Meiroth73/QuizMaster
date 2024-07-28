<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        session_start();
        $userId = $_SESSION['user-id'];

        require_once('../config/config.php');

        try {
            $connection = new PDO("mysql:host=$database_host;dbname=$database_name", $database_user, $database_password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $connection->prepare('UPDATE `user` SET `name`=:name, `lastname`=:lastname, `username`=:username, `email`=:email, `description`=:description WHERE `id`=:uid');
            $stmt->bindParam(':name', $_POST['name']);
            $stmt->bindParam(':lastname', $_POST['lastname']);
            $stmt->bindParam(':username', $_POST['username']);
            $stmt->bindParam(':email', $_POST['email']);
            $stmt->bindParam(':description', $_POST['description']);
            $stmt->bindParam(':uid', $userId);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error: ".$e->getMessage());
        }
    }

    header('Location: ../home/settings.php');

    $connection = null;
?>