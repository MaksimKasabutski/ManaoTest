<?php
$_SESSION = [];
if ( isset($_COOKIE[session_name()]) ) {
    setcookie(session_name(), '', time()-3600, '/');
    setcookie("hash", '', time()-60*60*24*30, '/');
}

session_destroy();

header('Location: index.php');
?>