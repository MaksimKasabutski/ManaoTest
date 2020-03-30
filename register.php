<?php 
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');
    session_start();
    
    require_once('Response.php');
    require_once('UserProvider.php');
    require_once('Security.php');

    $request = json_decode(file_get_contents('php://input'), true);
    
    $login = strip_tags(trim( $request['login'] ));
    $password = strip_tags(trim( $request['password'] ));
    $passwordConf = strip_tags(trim( $request['passwordConf'] ));
    $email = strip_tags(trim( $request['email'] ));
    $name = ucfirst(strtolower(strip_tags(trim( $request['name'] ))));
    
    
    if ( UserProvider::getUser($login) != null ) {
        $response = new Response('error', 'Пользователь с таким именем уже существует');
    } elseif ( UserProvider::isEmailUsed($email) ) {
        $response = new Response('error', 'Пользователь с таким Email уже существует');
    } elseif ( $password != $passwordConf ) {
        $response = new Response('error', 'Ошибка. Пароли не совпадают.');
    } elseif ( !preg_match("/^\w+([\.\w]+)*\w@\w((\.\w)*\w+)*\.\w{2,3}$/", $email) ) {
        $response = new Response('error', 'Ошибка. Неверный формат почтового адреса.');
    } elseif ( !preg_match("/^[a-zа-яё\s]*$/i", $name) ) {
        $response = new Response('error', 'Имя должно содержать только латинские или русские символы.');
    } else {
        $encodingResult = Security::encodePassword($password);
        $cookie = Security::generateRandomString(15);

        UserProvider::addUser($login, $encodingResult['password'], $encodingResult['encodedSalt'], $email, $cookie, $name);
        setcookie("hash", $cookie, time()+60*60*24*30);
        $_SESSION['user_login'] = $login;
        
        $response = new Response('success', 'Регистрация прошла успешно.');
    }

    echo json_encode($response);
    return;
?>