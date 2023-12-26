<?php

session_start();
include '../lib/functions/functions.php';
include '../lib/model/Actor.php';
include '../lib/model/Pelicula.php';
include '../lib/model/Usuario.php';

//Si la session user esta inicializada y la session rol es 1
if (isset($_SESSION['user']) && $_SESSION['rol'] == 1) {
    //Si la longitud del array de POST es diferente a 0
    if (count($_POST) != 0) {
        //Si todas las variables de de POST estan inicializadas a algo diferente de ""
        if (htmlspecialchars($_POST['titulo'] != "") && htmlspecialchars($_POST['genero']) != "" && htmlspecialchars($_POST['anyo']) != "" && htmlspecialchars($_POST['pais']) != "") {
            //echo "Todos los campos completos";
            $titulo = htmlspecialchars($_POST['titulo']);
            $genero = htmlspecialchars($_POST['genero']);
            $anyo = htmlspecialchars($_POST['anyo']);
            $pais = htmlspecialchars($_POST['pais']);
            $cartel = str_replace(" ", "_", $titulo) . ".jpg";
            //Si la funcion comprobarPelicula devuelve una pelicula
            if (comprobarPelicula($titulo, $genero, $anyo)) {
                //Funcion que inserta una pelicula
                insertPelicula($titulo, $genero, $anyo, $pais, $cartel);
            }
            //Si no redireccionamos a la pagina rol1.php y mostramos un error
            else {
                header("Location:./rol1.php?errorA=2");
            }
        }
        //Si no redireccionamos a la pagina rol1.php y mostramos un error
        else {
            header("Location:./rol1.php?errorA=1");
        }
    }
    //Si no redireccionamos a la pagina rol1.php y mostramos un error
    else {
        header("Location:./rol1.php?errorA=1");
    }
}
//Si no redireccionamos a la pagina index.php y mostramos un error
else {
    header("Location:../index.php?error=1");
}


