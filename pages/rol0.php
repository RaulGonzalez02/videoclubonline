<?php
session_start();
include '../lib/functions/functions.php';
include '../lib/model/Actor.php';
include '../lib/model/Pelicula.php';
include '../lib/model/Usuario.php';

//Comprobamos que existe la session[user] y que la session[rol] es 0, que lo que quiere decir que son los usuarios normales.
if (isset($_SESSION['user']) && $_SESSION['rol'] == 0) {
    //echo "subdelegado password_subdelegado";
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
        <div class="container border mt-2">
            <h1 class='text-center'>Bienvenido <?php echo ucfirst($_SESSION['user']); ?></h1>
            <?php
            if (isset($_COOKIE[$cookieName])) {
                echo "<p>Su ultima conexion fue " . htmlspecialchars($_COOKIE[$cookieName]) . "</p>";
            } else {
                echo "Bienvenido por primera vez";
                setcookie($cookieName, $timeN, time() + 10 * 24 * 60 * 60);
            }
            $selectPeliculas = selectPeliculas();
            $selectActores = selectActores();
            //echo count($peliculas);
            if (count($selectPeliculas) == 0 && count($selectActores) == 0) {
                echo "<p>No hay niguna pelicula</p>";
            } else {
                $peliculas = [];
                $actores = [];
                for ($i = 0; $i < count($selectPeliculas); $i++) {
                    $pelicula = new Pelicula($selectPeliculas[$i]["id"], $selectPeliculas[$i]["titulo"], $selectPeliculas[$i]["genero"], $selectPeliculas[$i]["pais"], $selectPeliculas[$i]["anyo"], $selectPeliculas[$i]["cartel"]);
                    array_push($peliculas, $pelicula);
                }
                for ($i = 0; $i < count($selectActores); $i++) {
                    $actor = new Actor($selectActores[$i]["id"], $selectActores[$i]["nombre"], $selectActores[$i]["apellidos"], $selectActores[$i]["fotografia"]);
                    array_push($actores, $actor);
                }
            }
            ?>
            <h2 class="border text-center mt-5">Tabla de peliculas</h2>
            <!--INICIO TABLA-->
            <table class="table">
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
                    echo "<td><img class='image__pelicula' alt='" . trim($pelicula->getCartel()) . "' src='../assets/images/" . $pelicula->getCartel() . "'>";
                    echo "<td>" . $pelicula . "</td>";
                    echo "<td>" . $actorPelicula . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
            <!--INICIO FORMULARIO PARA CORREO-->
            <form action="./enviarCorreo.php" method="post" class="form border mt-4 p-1 d-flex flex-column align-items-center">
                <label class="fomr-label">Dirección de correo</label>
                <input class="form_control form-control" type="email" name="email" placeholder="Tu email: ejemplo@ejemplo.com" pattern="\S+@\S+\.\S+">
                <label class="form-label">Incidencia</label>
                <textarea class="form_control form-control" name="mensaje" rows="15" cols="10" placeholder="Escriba aqui su incendicia" minlength="5"></textarea>
                <?php
                if (isset($_GET['error'])) {
                    if (htmlspecialchars($_GET['error']) == 1) {
                        echo "<p class='mt-2 p-1 text-danger bg-danger-subtle rounded'>Error: Complete todos los campos</p>";
                    }
                    if (htmlspecialchars($_GET['error']) == 2) {
                        echo "<p class='mt-2 p-1 text-danger bg-danger-subtle rounded'>Error: No se pudo enviar el correo intentelo de nuevo</p>";
                    }
                    if (htmlspecialchars($_GET['error']) == 0) {
                        echo "<p class='mt-2 p-1 text-success bg-success-subtle rounded'>Envio correctamente</p>";
                    }
                }
                ?>
                <input type="submit" class="btn btn-primary mt-2" placeholder="Enviar">

            </form>
            <!--FIN FORMULARIO PARA CORREO-->
            <!--FIN TABLA-->
            <a href="cerrarSesion.php" class="btn btn-primary m-2">Cerrar Sesion</a>
        </div>
        <!--FIN CONTAINER-->
        <!--Scrip para utilizar las clases de bootstrap que requieren JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
    <!--FIN BODY-->
</html>
