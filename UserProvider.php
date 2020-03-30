<?php
class UserProvider 
{
    const FILE_NAME = 'db.xml';

    public static function getUser($login) {
        $database = simplexml_load_file(self::FILE_NAME);
        foreach ($database->user as $user) {
            if ($user->login == $login) {
                return $user;
            }
        }

        return null;
    }

    public static function isEmailUsed($email) {
        $database = simplexml_load_file(self::FILE_NAME);
        foreach ($database->user as $user) {
            if ($user->email == $email) {
                return true;
            }
        }

        return false;
    }

    public static function addUser($login, $hash, $encodedSalt, $email, $cookie, $name) {
        $database = simplexml_load_file(self::FILE_NAME);
        
        $user = $database->addChild("user");
        $encodedCookie = htmlspecialchars($cookie);
        $user->addChild("login", $login);
        $user->addChild("password", $hash);
        $user->addChild("salt", $encodedSalt);
        $user->addChild("email", $email);
        $user->addChild("cookie", $encodedCookie);
        $user->addChild("name", $name);

        self::saveFormatted($database);
    }

    public static function addCookieToUser($login, $cookie) {
        $database = simplexml_load_file(self::FILE_NAME);
        foreach ($database->user as $user) {
            if ($user->login == $login) {
                $user->cookie = htmlspecialchars($cookie);
            }
        }

        self::saveFormatted($database);
    }

    private static function saveFormatted($database) {
        $xmlDocument = new DOMDocument('1.0');
        $xmlDocument->preserveWhiteSpace = false;
        $xmlDocument->formatOutput = true;
        $xmlDocument->loadXML($database->asXML());

        $xmlDocument->save(self::FILE_NAME);
    }
}
?>