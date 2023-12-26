<?php

session_start();
include '../lib/functions/functions.php';
include '../lib/model/Actor.php';
include '../lib/model/Pelicula.php';
include '../lib/model/Usuario.php';
//Si la session user esta inicializada y la session rol es 1 
if (isset($_SESSION['user']) && $_SESSION['rol'] == 1) {
    //Si la variable GET id esta inicializada
    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET['id']);
        //Funcion que elimina las relaciones de la tabla actuan relacionadas con es ID
        eliminarActuan($id);
        //Funcion que elimina la pelicula que tenga ese ID
        eliminarPelicula($id);
    }
    //Si no redireccionamos a la pagina rol1.php y mostramos un error
    else {
        header('Location:./rol1.php');
    }
}
//Si no redireccionamos a la pagina rol1.php y mostramos un error
else {
    header('Location:./rol1.php');
}