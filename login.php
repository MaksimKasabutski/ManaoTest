<?php
    if(session_status() != PHP_SESSION_ACTIVE) session_start();     
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');
    

    require_once('Response.php');
    require_once('UserProvider.php');
    require_once('Security.php');


    $request = json_decode(file_get_contents('php://input'), true);
    $database = simplexml_load_file('db.xml');
    
    $login = strip_tags(trim( $request['login'] ));
    $password = strip_tags(trim( $request['password'] ));

    $user = UserProvider::getUser($login);
    if ($user == null) {
        $response = new Response('error', 'Такой пользователь не найден.');
    } else {
        if (Security::checkPassword($user, $password)) {
            $cookie = Security::generateRandomString(15);
            UserProvider::addCookieToUser($login, $cookie);
            setcookie("hash", $cookie, time()+60*60*24*30);
            $_SESSION['user_login'] = $login;
            $response = new Response('success', 'Hello, '.$user->name);
        } else {
            $response = new Response('error', 'Неверный пароль');
        }
    }
    
    echo json_encode($response);
    return;
?>