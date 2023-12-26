<?php

/**
 * Funcion que nos devuelve una conexión a la base de datos.
 * @return \PDO
 */
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

/**
 * Funcion verifica si el usuario que intento acceder esta registrado en la base de datos
 * @param string $user username del usuario
 * @param string $pass password del usuario
 * @return type
 */
function selectLogin($user, $pass) {
    $bd = conexionBD();
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

/**
 * Funcion que devuelve un array con todas las peliculas si la consulta a la tabla peliculas se ejecuta correctamente, si no devuelve -1
 * @return array
 */
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

/**
 * Funcion que devuelve un array con todos los actores si la consulta a la tabla actores se ejecuta correctamente, si no devuelve -1
 * @return array
 */
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

/**
 * Funcion que comprueba si un actor esta relacionado con una pelicula en la tabla actuan, devolviendo verdadero si lo estan y falso si no lo estan
 * @param integer $idPelicula id de la pelicula
 * @param integer $idActor id del actor
 * @return bool
 */
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

/**
 * Funcion que comprueba si la pelicula existe en la base de datos
 * @param string $titulo titulo de la pelicula que vamos comprobar
 * @param string $genero genero de la pelicula que vamos a comprobar
 * @param integer $anyo año de la pelicula que vamos a comprobar
 * @return bool
 */
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

/**
 * Funcion que añade una nueva pelicula en la base de datos.
 * @param string $titulo titulo de la pelicula que vamos añadir 
 * @param string $genero genero de la pelicula que vamos añadir
 * @param integer $anyo año de la pelicula que vamos añadir
 * @param string $pais pais de la pelicula que vamos añadir
 * @param string $cartel cartel de la pelicula que vamos añadir
 */
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

/**
 * Funcion que elimina de la tabla actuan las relaciones de la pelicula cuyo ID es proporcionado a la funcion para en un futuro eliminar dicha pelicula de la base de datos
 * @param type $id id de la pelicula que vamos eliminar de la tabla
 */
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

/**
 * Funcion que elimina la pelicula de la base de datos atraves del id de la pelicula
 * @param integer $id de la pelicula que vamos eliminar
 */
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

/**
 * Funcion que hace un update en la base de datos, la cual modifica los campos atraves del id de la pelicula
 * @param string $titulo titulo de la pelicula
 * @param string $genero genero de la pelicula
 * @param integer $anyo anyo de la pelicula
 * @param string $pais pais de la pelicula
 * @param integer $id id de la pelicula
 */
function updatePeliculas($titulo, $genero, $anyo, $pais, $id) {
    $bd = conexionBD();
    $prepare = $bd->prepare('update peliculas set titulo=:titulo, genero=:genero, anyo=:anyo, pais=:pais where id=:id');
    if (!$prepare->execute(array(":titulo" => $titulo, ":genero" => $genero, ":anyo" => $anyo, ":pais" => $pais, ":id" => $id))) {
        $bd = null;
        header('Location:./rol1.php?errorU=2');
    } else {
        $bd = null;
        header("Location:./rol1.php?errorU=0");
    }
}
