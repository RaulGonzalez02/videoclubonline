<?php

session_start();
include '../lib/functions/functions.php';
include '../lib/model/Usuario.php';
if (isset($_SESSION)) {
    if (htmlspecialchars($_POST['user']) != null && htmlspecialchars($_POST['pass'] != null) != null) {
        $username = htmlspecialchars($_POST['user']);
        $pass = htmlspecialchars($_POST['pass']);
        $passHash = hash("sha256", $pass);
        $bd = conexionBD();
        $select = selectLogin($username, $passHash);
        if ($select != -1) {
            $usuario = new Usuario($select["id"], $select["username"], $select["password"], $select["rol"]);
            //echo $usuario;
            if ($usuario->getRol() == 0) {
                $_SESSION['user'] = $usuario->getUsername().$usuario->getId();
                $_SESSION['rol'] = $usuario->getRol();
                header("Location:./rol0.php");
            } else if ($usuario->getRol() == 1) {
                $_SESSION['user'] = $usuario->getUsername().$usuario->getId();
                $_SESSION['rol'] = $usuario->getRol();
                header("Location:./rol1.php");
            } 
        }else {
                header("Location:../index.php?error=2");
            }
    } else {
        header("Location:../index.php?error=1");
    }
} else {
    header("Location:../index.php?error=1");
}
