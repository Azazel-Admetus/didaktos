<?php
session_start();
$_SESSION = array();
session_destroy();
if(isset($_COOKIE['id_jogo'])){
    setcookie('id_jogo', '', time() - 3600, "/");
}
if(ini_get("session.use_cookies")){
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600,
        $params["path"], $params["domain"], 
        $params["secure"], $params["httponly"]);
}

header("Location:../html/index.html");
exit;
?>

