<?php

//INICIAMOS UNA SESIÓN
session_start();
//Moficamos el valor de la cookie para que guarde el ultimo dia que se conecto el usuario
$time = date("d/m/Y");
$cookieName= hash("sha256", $_SESSION['user']);
if (isset($_COOKIE[$cookieName])) {
    setcookie($cookieName, $time, time() + 10 * 24 * 60 * 60);
}
//para borrar todas las sesiones que existan.
$_SESSION = array();
session_destroy();
//para que te lleve al index
header('Location:../index.php');

