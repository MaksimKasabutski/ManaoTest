<?php
require_once('UserProvider.php');

class Security 
{
    public static function generateRandomString($length=8) {
        $string = '';
        for ($i = 0; $i<$length; $i++) {
            $string .= chr(mt_rand(33, 126));
        }
        return $string;
    }

    public static function encodePassword($password) {
        $salt = self::generateRandomString(8);
        $hash = md5($salt.$password);
        $encodedSalt = htmlspecialchars($salt);
        
        return array('password'=>$hash, 'encodedSalt'=>$encodedSalt);
    }

    public static function checkPassword($user, $password) {
        $salt = htmlspecialchars_decode($user->salt);
        $hash = md5($salt.$password);          
        return $hash == $user->password;
    }

    public static function checkCookie() {
        if (isset($_COOKIE['hash']) && isset($_SESSION['user_login'])) {
            $user = UserProvider::getUser($_SESSION['user_login']);
            $decodedCookie = htmlspecialchars_decode($user->cookie);

            if ($user != null && $decodedCookie == $_COOKIE['hash']) {
                $_SESSION['user_name'] = $user->name;
                return true;
            }
        }
    }
}
?>