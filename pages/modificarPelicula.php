<?php

session_start();
include '../lib/functions/functions.php';
include '../lib/model/Actor.php';
include '../lib/model/Pelicula.php';
include '../lib/model/Usuario.php';

//Si la session user esta inicializada y la session rol es 1
if (isset($_SESSION['user']) && $_SESSION['rol'] == 1) {
    //Si todas las variables de de POST estan inicializadas a algo diferente de ""
    if (htmlspecialchars($_POST['titulo'] != "") && htmlspecialchars($_POST['genero']) != "" && htmlspecialchars($_POST['anyo']) != "" && htmlspecialchars($_POST['pais']) != "") {
        $titulo = htmlspecialchars($_POST['titulo']);
        $genero = htmlspecialchars($_POST['genero']);
        $anyo = htmlspecialchars($_POST['anyo']);
        $pais = htmlspecialchars($_POST['pais']);
        $id = htmlspecialchars($_POST['id']);
        //Funcion que modifica una pelicula
        updatePeliculas($titulo, $genero, $anyo, $pais, $id);
    }
    //Si no redireccinamos a la pagina rol1.php y mostramos un error
    else {
        header("Location:./rol1.php?errorU=1");
    }
}
//Si no redireccinamos a la pagina rol1.php y mostramos un error
else {
    header('Location:./rol1.php');
}    