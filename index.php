<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset="utf-8">
        <title>Manao Test</title>
        <link rel="stylesheet" href="style.css"> 
    </head>
<body>
<div id="response" style="display: none;"></div>
<noscript>
Внимание, включите JavaScript!
</noscript>
    <?php
    session_start();
    require_once('Security.php');

    if ( Security::checkCookie() ) {
        echo "<div id='initial-message'>Вы уже вошли, как ".$_SESSION['user_name']." <a href='logout.php'>Выйти</a></div>";
    } else {
        echo '
        <div class="login-window" id="loginWindow">
            <div class="head">
                <p>ВХОД</p>
            </div>
            <fieldset>
                <form id="loginForm" method="POST">
                    <label for="text">Логин:</label><br>
                    <input name="login" class="login" type="text" placeholder="Login" value="" required><br>

                    <label for="password">Пароль:</label><br>
                    <input name="password" class="password" type="password" placeholder="Password" value="" required><br>

                    <input type="submit" value="ВХОД">
                </form>
            </fieldset>
        </div>
        <div class="login-window" id="registrationWindow">
            <div class="head">
                <p>РЕГИСТРАЦИЯ</p>
            </div>
            <fieldset>
                <form id="registrationForm" method="POST">
                    <label for="text">Логин:</label><br>
                    <input name="login" class="login" type="text" placeholder="Login" value="" required><br>

                    <label for="password">Пароль:</label><br>
                    <input name="password" class="password" type="password" placeholder="Password" value="" required><br>

                    <label for="password">Повторите пароль:</label><br>
                    <input name="confirm_password" id="confirm_password" type="password" placeholder="Password" value="" required><br>

                    <label for="email">E-mail:</label><br>
                    <input name="email" id="email" type="email" placeholder="E-mail" value="" required><br>

                    <label for="name">Имя:</label><br>
                    <input name="name" id="name" type="text" placeholder="Name" value="" required><br>
                    
                    <input type="submit" value="РЕГИСТРАЦИЯ">
                </form>
            </fieldset>
        </div>
        ';
    }
    ?>
    <script src='script.js'></script>
</body>
</html>