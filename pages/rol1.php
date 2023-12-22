<?php
session_start();
include '../lib/functions/functions.php';
include '../lib/model/Actor.php';
include '../lib/model/Pelicula.php';
include '../lib/model/Usuario.php';

//Comprobamos que existe la session[user] y que la session[rol] es 0, que lo que quiere decir que son los usuarios normales.
if (isset($_SESSION['user']) && $_SESSION['rol'] == 1) {
    //echo "Usuario admin contraseña password_admin";
    $timeN = date("d/m/Y");
    //Para que el nombre de la cookie no sea descriptivo le metemos un hash
    $cookieName = hash("sha256", $_SESSION['user']);
} else {
    header("Location:../index.php?error=1");
}
?>
<!DOCTYPE html>
<html lang="es">
    <!--INICIO HEAD-->
    <head>
        <meta charset="UTF-8">
        <title>VIDEOCLUB ONLINE</title>
        <!--Link para utilizar las clases de bootstrap-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link rel="stylesheet" href="../css/styles.css"/>
    </head>
    <!--FIN HEAD-->

    <!--INICIO BODY-->
    <body>
        <!--INICIO CONTAINER-->
        <div class="container-fluid p-3 border mt-2">
            <h1 class='text-center'>Bienvenido <?php echo substr(ucfirst($_SESSION['user']), 0, -1); ?></h1>
            <?php
            //Si la cookie esta inicializada, mostramos un mesaje de su contenido
            if (isset($_COOKIE[$cookieName])) {
                echo "<p>Su ulitma conexion fue " . htmlspecialchars($_COOKIE[$cookieName]) . "</p>";
            }
            //Si no esta inicializada la creamos y mostramos un mensaje
            else {
                echo "Bienvenido por primera vez";
                setcookie($cookieName, $timeN, time() + 10 * 24 * 60 * 60);
            }

            //Llamamos a la funcion selectPeliculas()
            $selectPeliculas = selectPeliculas();
            //Llamamos a la funcion selectActores()
            $selectActores = selectActores();
            //echo count($peliculas);
            // Verifica si no hay elementos en $selectPeliculas y $selectActores
            if (count($selectPeliculas) == 0 && count($selectActores) == 0) {
                echo "<p>No hay niguna pelicula</p>";
            } else {
                $peliculas = [];
                $actores = [];
                //Recorremos el array que nos devolvio la funcion selectPeliculas()
                for ($i = 0; $i < count($selectPeliculas); $i++) {
                    //Creamos el objeto Pelicula
                    $pelicula = new Pelicula($selectPeliculas[$i]["id"], $selectPeliculas[$i]["titulo"], $selectPeliculas[$i]["genero"], $selectPeliculas[$i]["pais"], $selectPeliculas[$i]["anyo"], $selectPeliculas[$i]["cartel"]);
                    //Guadamos los objetos creados en un array
                    array_push($peliculas, $pelicula);
                }
                //Recorremos el array que nos devolvio la funcion selectActores()
                for ($i = 0; $i < count($selectActores); $i++) {
                    //Creamos el objeto Actores
                    $actor = new Actor($selectActores[$i]["id"], $selectActores[$i]["nombre"], $selectActores[$i]["apellidos"], $selectActores[$i]["fotografia"]);
                    //Guardamos los objetos creados en un array
                    array_push($actores, $actor);
                }
            }
            ?>
            <h2 class="border text-center mt-5">Tabla de peliculas</h2>
            <!--INICIO TABLA-->
            <table class="table border">
                <tr>
                    <th>Cartel</th>
                    <th>Pelicula</th>
                    <th>Reparto</th>
                </tr>
                <?php
                foreach ($peliculas as $pelicula) {
                    $actorPelicula = " ";
                    echo "<tr>";
                    foreach ($actores as $actor) {
                        if (selectActuan($pelicula->getId(), $actor->getId())) {
                            $actorPelicula = $actorPelicula . " " . $actor . ",";
                        }
                    }
                    echo '<td><img class="image__pelicula" alt="' . trim($pelicula->getCartel()) . '" src="../assets/images/' . $pelicula->getCartel() . '"></td>';
                    echo '<td class="d-flex td__peli">' . $pelicula . '<div class="text-end d-flex gap-1 p-2 h-50">'
                    . '<button class="bg-info p-2 rounded text-info-emphasis fs-5"><i class="fa-solid fa-pen  "></i></button>'
                    . '<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModalEliminar' . $pelicula->getId() . '"><i class="fa-solid fa-x" ></i></button>'
                    . '</div>'
                    //Creamos un modal para cada una de las peliculas
                    . '<!-- Modal Eliminar -->
                        <div class="modal fade" id="exampleModalEliminar' . $pelicula->getId() . '" tabindex="-1" aria-labelledby="exampleModalEliminar' . $pelicula->getId() . '" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalEliminarTitulo' . $pelicula->getId() . '">Eliminar</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">¿Seguro que quieres eliminar la pelicula ' .
                    $pelicula->getTitulo()
                    . '? Si deseas eliminar pulse aceptar, si no cancelar</div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                                        <a href="./eliminarPelicula.php?id=' . $pelicula->getId() . '" class="btn btn-danger">Aceptar</a>
                                    </div>
                                </div>
                            </div>
                        </div></td>';
                    echo "<td>" . $actorPelicula . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
            <?php
            if (isset($_GET['errorE'])) {
                //Si esta inicializada a 2 mostramos un mensaje de error que la eliminación no se ha podido completar
                if (htmlspecialchars($_GET['errorE']) == 2) {
                    echo "<p class='mt-2 p-1 text-danger bg-danger-subtle rounded'>Error en la eliminación, prueba más tarde</p>";
                }
                //Si esta inicializada en 0 mostramos un mensaje de que la eliminación fue correctamente
                if (htmlspecialchars($_GET['errorE']) == 0) {
                    echo "<p class='mt-2 p-1 text-success bg-success-subtle rounded'>Pelicula eliminada correctamente</p>";
                }
            }
            ?>
            <!--INICIO FORMULARIO PARA AÑADIR PELICULA-->
            <form action="./aniadirPelicula.php" method="post" class="form border mt-4 p-1 d-flex flex-column align-items-center">
                <h3 class="text-center">AÑADIR PELICULA</h3>
                <label class="form-label ms-2">Titulo</label>
                <input class="form-control w-50 ms-2" type="text" name="titulo">
                <label class="form-label ms-2">Genero</label>
                <input class="form-control w-50 ms-2" type="text" name="genero">
                <label class="form-label ms-2">Año</label>
                <input class="form-control w-50 ms-2" type="text" name="anyo">
                <label class="form-label ms-2">Pais</label>
                <input class="form-control w-50 ms-2" type="text" name="pais">
                <?php
                //Si la variable error esta inicializada.
                if (isset($_GET['errorA'])) {
                    //Si esta inicializada a 1 mostramos un error de que los campos estan sin completar.
                    if (htmlspecialchars($_GET['errorA']) == 1) {
                        echo "<p class='mt-2 p-1 text-danger bg-danger-subtle rounded'>Error: Complete todos los campos</p>";
                    }
                    //Si esta inicializada a 2 mostramos un error de que la pelicula ya esta añadida
                    if (htmlspecialchars($_GET['errorA']) == 2) {
                        echo "<p class='mt-2 p-1 text-danger bg-danger-subtle rounded'>Error: Pelicula ya añadida</p>";
                    }
                    //Si esta inicializada a 3 mostramos un mensaje de error que la inserccion no se ha podido completar
                    if (htmlspecialchars($_GET['errorA']) == 3) {
                        echo "<p class='mt-2 p-1 text-danger bg-danger-subtle rounded'>Error en la insercción, prueba más tarde</p>";
                    }
                    //Si esta inicializada en 0 mostramos un mensaje de que la inserccion fue correctamente
                    if (htmlspecialchars($_GET['errorA']) == 0) {
                        echo "<p class='mt-2 p-1 text-success bg-success-subtle rounded'>Pelicula añadida correctamente</p>";
                    }
                }
                ?>
                <input class="btn btn-primary m-1" type="submit">
            </form>
            <!--FIN FORMULARIO PARA AÑADIR PELICULA-->

            <!--FIN TABLA-->
            <a href="cerrarSesion.php" class="btn btn-primary m-2">Cerrar Sesion</a>
        </div>
        <!--FIN CONTAINER-->

        <!--Scrip para utilizar las clases de bootstrap que requieren JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
    <!--FIN BODY-->
</html>
