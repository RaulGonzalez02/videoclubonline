<?php

function conexionBD() {
    $cadena_conexion = 'mysql:dbname=videoclubonline;host=127.0.0.1';
    $usuario = 'root';
    $clave = '';
    try {
        //Se crea la conexión con la base de datos
        $bd = new PDO($cadena_conexion, $usuario, $clave);
        return $bd;
    } catch (Exception $e) {
        header("Location:../index.php?error=3");
    }
}

function selectLogin($user, $pass) {
    $bd = conexionBD();
    //********************************MIRAR SI QUE PASA CUANDO DESCONECTAMOS LA BASE DE DATOS***************************************
    $prepare = $bd->prepare("select id, username, trim(password), rol from usuarios where username=:user and password=:pass");
    $prepare->execute(array(":user" => $user, ":pass" => $pass));
    $fila = $prepare->fetch(PDO::FETCH_ASSOC);
    $bd = null;
    if (isset($fila['rol'])) {
        return $fila;
    } else {
        return -1;
    }
}

function selectPeliculas() {
    $bd = conexionBD();
    $prepare = $bd->prepare("select id, titulo, genero, pais, anyo, cartel from peliculas");
    $prepare->execute();
    $filas = $prepare->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($filas);
    //echo count($filas);
    $bd = null;
    if (count($filas) != 0) {
        return $filas;
    } else {
        return -1;
    }
}

function selectActores() {
    $bd = conexionBD();
    $prepare = $bd->prepare("select id, nombre, apellidos, fotografia from actores");
    $prepare->execute();
    $filas = $prepare->fetchAll(PDO::FETCH_ASSOC);
    $bd = null;
    if (count($filas) != 0) {
        return $filas;
    } else {
        return -1;
    }
}

function selectActuan($idPelicula, $idActor) {
    $bd = conexionBD();
    $prepare = $bd->prepare("select idPelicula, idActor from actuan where idPelicula=:idPelicula and idActor=:idActor");
    $prepare->execute(array(":idPelicula" => $idPelicula, ":idActor" => $idActor));
    $filas = $prepare->fetchAll(PDO::FETCH_ASSOC);
    $bd = null;
    if (count($filas) == 0) {
        return false;
    } else {
        return true;
    }
}

function comprobarPelicula($titulo, $genero, $anyo) {
    $bd = conexionBD();
    $prepare = $bd->prepare("select id from peliculas where titulo=:titulo and genero=:genero and anyo=:anyo");
    $prepare->execute(array(":titulo" => $titulo, ":genero" => $genero, ":anyo" => $anyo));
    $filas = $prepare->fetch(PDO::FETCH_ASSOC);
    $bd = null;
    if ($filas) {
        return false;
    } else {
        return true;
    }
}

function insertPelicula($titulo, $genero, $anyo, $pais, $cartel) {
    $bd = conexionBD();
    $prepare = $bd->prepare("insert into peliculas values(id, :titulo, :genero, :pais, :anyo, :cartel)");
    if (!$prepare->execute(array(":titulo" => $titulo, ":genero" => $genero, ":pais" => $pais, ":anyo" => $anyo, ":cartel" => $cartel))) {
        $bd = null;
        header("Location:./rol1.php?errorA=3");
    } else {
        $bd = null;
        header("Location:./rol1.php?errorA=0");
    }
}

function eliminarActuan($id) {
    $bd = conexionBD();
    $prepare = $bd->prepare('delete from actuan where idPelicula=:id');
    if (!$prepare->execute(array(":id" => $id))) {
        $bd = null;
        header('Location:./rol1.php?errorE=2');
    } else {
        $bd = null;
    }
}

function eliminarPelicula($id) {
    $bd = conexionBD();
    $prepare = $bd->prepare('delete from peliculas where id=:id');
    if (!$prepare->execute(array(":id" => $id))) {
        $bd = null;
        header('Location:./rol1.php?errorE=2');
    } else {
        $bd = null;
        header("Location:./rol1.php?errorE=0");
    }
}
