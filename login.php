<?php
    require_once('./config/config.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>QuizMaster - Logowanie</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="./style/style_login.css">
        <link rel="stylesheet" href="./style/styles_global.css">
    </head>
    <body>
        <section class="document">
            <?php 
                require_once("elements/header.php");
            ?>
            <section class="document-body">
                <main>
                    <div id="div-register">
                        <h2>Zarejestruj się!</h2>
                        <form action="" method="post">
                            <input type="text" id="user-name" placeholder="Nazwa Użytkownika" required>
                            <input type="email" id="e-mail" placeholder="E-mail" required>
                            <span>
                                <input type="password" id="register-password" placeholder="Hasło" required>
                                <button type="button" id="btn-show-register-password" required>
                                    <i class="fa-regular fa-eye-slash"></i>
                                </button>
                            </span>
                            <span>
                                <input type="password" id="register-password-confirm" placeholder="Potwierdź Hasło">
                                <button type="button" id="btn-show-register-confirm-password">
                                    <i class="fa-regular fa-eye-slash"></i>
                                </button>
                            </span>
                            <button type="button" id="btn-continue-register">Przejdź dalej!</button>
                        </form>
                    </div>
                    <div id="div-register-continue">
                    <h2>Kontynuacja rejestracji!</h2>
                        <form action="<?php $host_name ?>/login_system.php" method="post">
                            <input type="text" name="register-user-name" id="user-name-in-form" placeholder="Username" class="display-none">
                            <input type="text" name="register-email" id="e-mail-in-form" placeholder="E-mail" class="display-none">
                            <input type="password" name="register-password" id="password-in-form" class="display-none">
                            <input type="text" name="register-name" id="name" placeholder="Imie" required>
                            <input type="text" name="register-lastname" id="lastname" placeholder="Nazwisko" required>
                            <input type="text" name="register-phone" id="phone" placeholder="Numer Telefonu" required>
                            <input type="text" name="register-description" id="description" placeholder="Opis">
                            <button type="submit">Zarejestruj się!</button>
                            <button type="button" id="btn-undo">Cofnij!</button>
                        </form>
                    </div>
                    <div id="div-text-login">           
                        <h1 class="login-h1">Witaj Ponownie!</h1>
                        <p class="text">Nie masz jeszcze konta?</p>
                        <p class="text">Utwórz konto poniżej</p>
                        <button id="btn-get-register-form"><p>Zarejestruj się!</p></button>
                    </div>
                    <div id="div-login">
                        <h2>Zaloguj się!</h2>
                        <form action="<?php $host_name ?>/login_system.php" method="post">
                            <input type="text" name="email" id="email" placeholder="E-mail" required>
                            <span>
                                <input type="password" name="password" id="password" placeholder="Hasło" required>
                                <button type="button" id="btn-show-login-password">
                                    <i class="fa-regular fa-eye-slash"></i>
                                </button>
                            </span>
                            <p class="reset-password-link"><a href="">Nie pamiętasz hasła?</a></p>
                            <button type="submit">Zaloguj się!</button>
                        </form>
                    </div>
                    <div id="div-text-register">
                        <h1 class="login-h1">Miło Cię Poznać!</h1>
                        <p class="text">Masz już konto?</p>
                        <p class="text">Zaloguj sie poniżej</p>
                        <button id="btn-get-login-form"><p>Zaloguj się!</p></button>
                    </div>
                </main>
            </section>
        </section>
        <script src="./scripts/login.js"></script>
        <?php 
            if(isset($_COOKIE['register'])) {
                echo <<<SCRIPT
                <script>
                    divRegister.style.left = '0';
                    divTextRegister.style.left = '50%';
                    divLogin.style.left = '0';
                    divTextLogin.style.left = '75%';
                    divLogin.style.zIndex = '0';
                </script>
                SCRIPT;
            }
        ?>
    </body>
</html>
