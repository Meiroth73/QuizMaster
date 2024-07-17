<?php
    session_start();
    $_SESSION['register'] = true;    
    header("Location: ./login.php");
?>