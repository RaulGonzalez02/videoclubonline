<?php

session_start();
include '../lib/functions/functions.php';
include '../lib/model/Actor.php';
include '../lib/model/Pelicula.php';
include '../lib/model/Usuario.php';

if (isset($_SESSION['user']) && $_SESSION['rol'] == 1) {

    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET['id']);
        eliminarActuan($id);
        eliminarPelicula($id);
    } else {
        header('Location:./rol1.php');
    }
} else {
    header('Location:./rol1.php');
}