<header>
    <nav>
        <div class="nav-logo">
            <a href="../" class="logo no-select">
                <p class="logo-part-1 logo">Quiz</p>
                <p class="logo-part-2 logo">Master</p>
            </a>
        </div>
        <div class="nav-links">
            <a href="../" class="nav-btn no-select">Start</a>
            <a href="../category.php" class="nav-btn no-select">Quizy</a>
            <a href="../" class="nav-btn no-select">Losuj 1 pytanie</a>
            <a href="../" class="nav-btn no-select">Ogłoszenia</a>
            <a href="../" class="nav-btn no-select">FAQ</a>
        </div>
        <?php
            session_start();
            if (isset($_SESSION["user-id"])) {
                echo <<<TEXT
                    <div class="nav-div-profile">
                        <a href="../home/"><img alt="profil uzytkownika" src="../image/profiles/{$_SESSION['profile-image']}"></a>
                    </div>
                TEXT;                
            } else {
                echo <<<TEXT
                    <div class="nav-div-login">
                        <a href="../login.php" class="nav-login no-select">Zaloguj się</a>
                        <p class="backslash no-select">|</p>
                        <a href="../register.php" class="nav-register no-select">Zarejestruj się</a>
                    <div class="nav-div-login">
                TEXT;
            }
        ?>
    </nav>
</header>