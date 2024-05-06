<?php
    require_once('./config/config.php');
    setcookie("register", "register", time() + 1);
    header("Location: $host_name/login.php");