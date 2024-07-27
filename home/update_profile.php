<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file-input'])) {
        session_start();
        $userId = $_SESSION['user-id'];

        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/image/profiles/';
        $fileExtension = pathinfo($_FILES['file-input']['name'], PATHINFO_EXTENSION);
        $fileName = 'user-' . $userId . '.' . $fileExtension;
        $uploadFile = $uploadDir . $fileName;

        if($_SESSION['profile-image'] != 'user.png') {
            unlink($uploadDir . $_SESSION['profile-image']);
        }
        
        if(move_uploaded_file($_FILES['file-input']['tmp_name'], $uploadFile)) {
            $_SESSION['profile-image'] = $fileName;

            require_once('../config/config.php');

            try {
                $connection = new PDO("mysql:host=$database_host;dbname=$database_name", $database_user, $database_password);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $connection->prepare('UPDATE `user` SET `profileimage`=:image WHERE `id`=:uid');
                $stmt->bindParam(':uid', $userId);
                $stmt->bindParam(':image', $fileName);
                $stmt->execute();
            } catch (PDOException $e) {
                die("Error: ".$e->getMessage());
            }
        }
    }

    header('Location: ../home/settings.php');

    $connection = null;
?>
