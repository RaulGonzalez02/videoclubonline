<?php

session_start();
include '../lib/functions/functions.php';
include '../lib/model/Actor.php';
include '../lib/model/Pelicula.php';
include '../lib/model/Usuario.php';

if (isset($_SESSION['user']) && $_SESSION['rol'] == 1) {
    if (count($_POST) != 0) {
        if (htmlspecialchars($_POST['titulo'] != "") && htmlspecialchars($_POST['genero']) != "" && htmlspecialchars($_POST['anyo']) != "" && htmlspecialchars($_POST['pais']) != "") {
            //echo "Todos los campos completos";
            $titulo = htmlspecialchars($_POST['titulo']);
            $genero = htmlspecialchars($_POST['genero']);
            $anyo = htmlspecialchars($_POST['anyo']);
            $pais = htmlspecialchars($_POST['pais']);
            $cartel= str_replace(" ", "_", $titulo).".jpg";
            if(comprobarPelicula($titulo, $genero, $anyo)){
                insertPelicula($titulo, $genero, $anyo, $pais, $cartel);
                
            } else {
                header("Location:./rol1.php?error=2");
            }
        } else {
            header("Location:./rol1.php?error=1");
        }
    } else {
        header("Location:./rol1.php?error=1");
    }
} else {
    header("Location:../index.php?error=1");
}


