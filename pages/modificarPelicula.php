<?php

session_start();
include '../lib/functions/functions.php';
include '../lib/model/Actor.php';
include '../lib/model/Pelicula.php';
include '../lib/model/Usuario.php';

if (isset($_SESSION['user']) && $_SESSION['rol'] == 1) {
    if (htmlspecialchars($_POST['titulo'] != "") && htmlspecialchars($_POST['genero']) != "" && htmlspecialchars($_POST['anyo']) != "" && htmlspecialchars($_POST['pais']) != "") {
        $titulo = htmlspecialchars($_POST['titulo']);
        $genero = htmlspecialchars($_POST['genero']);
        $anyo= htmlspecialchars($_POST['anyo']);
        $pais= htmlspecialchars($_POST['pais']);
        $id= htmlspecialchars($_POST['id']);
        updatePeliculas($titulo, $genero, $anyo, $pais, $id);
    } else {
        header("Location:./rol1.php?errorU=1");
    }
} else {
    header('Location:./rol1.php');
}    