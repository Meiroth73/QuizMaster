<?php
    require_once('./config/config.php');
    setcookie("register", "register", time() + 1);
    header("Location: ./login.php");
?>