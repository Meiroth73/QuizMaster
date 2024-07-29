<?php
    require_once('./config/config.php');
    try {
        $connection = new PDO("mysql:host=$database_host;dbname=$database_name", $database_user, $database_password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error: ".$e->getMessage());
    }

    $user;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sqlQuery = "SELECT `id`, `email`, `password`, `profileimage`, `lastlogin` FROM `user` WHERE `email`=:email LIMIT 1";
        $statement = $connection->prepare($sqlQuery);
        $statement->bindParam(':email', $email);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        $pass = $user['password'];

        if($user && password_verify($password, $pass)) {
            session_start();
            $_SESSION['user-id'] = $user['id'];
            $_SESSION['profile-image'] = $user['profileimage'];
            $_SESSION['last-login'] = $user['lastlogin'];
            header('Location: ../home/');
        } 

        $stmt = $connection->prepare('UPDATE `user` SET `lastlogin`=NOW() WHERE `id`=:uid');
        $stmt->bindParam(':uid', $_SESSION['user-id']);
        $stmt->execute();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register-email'])) {
        $user_name = $_POST['register-user-name'];
        $email = $_POST['register-email'];
        $password = password_hash($_POST['register-password'], PASSWORD_BCRYPT);
        $name = $_POST['register-name'];
        $lastname = $_POST['register-lastname'];
        $phone = $_POST['register-phone'];
        $description = $_POST['register-description'];

        $sqlQuery = "INSERT INTO user(`name`, `lastname`, `username`, `email`, `password`, `description`, `phonenumber`, `createdate`, `profileimage`, `lastlogin`) VALUES (:name, :lastname, :username, :email, :password, :description, :phone, NOW(), 'user.png', NOW())";
        $stmt = $connection->prepare($sqlQuery);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':username', $user_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':phone', $phone);
        $stmt->execute();

        session_start();
        $_SESSION['user-id'] = $connection->lastInsertId();
        $_SESSION['profile-image'] = 'user.png';
        date_default_timezone_set('Europe/Warsaw');
        $_SESSION['last-login'] = date('d.m.Y');
        header('Location: ../home/');
    }

    $connection = null;

    header('Location: ../login.php');
?>