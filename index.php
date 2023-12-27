<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
    <!--INICIO HEAD-->
    <head>
        <meta charset="UTF-8">
        <title>VIDEOCLUB ONLINE</title>
        <!--Link para utilizar las clases de bootstrap-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <!--FIN HEAD-->

    <!--INICIO BODY-->
    <body>
        <div class="container border mt-2">
            <h1 class="text-center">BIENVENIDO AL VIDEOCLUB ONLINE</h1>
            <!--INICIO FORMULARIO-->
            <form method="post" action="./pages/login.php">
                <div class="mb-3">
                    <label class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="user" placeholder="Usuario">
                </div>
                <div class="mb-3">
                    <label  class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="pass">
                </div>
                <!--INICIO PHP-->
                <?php
                //comprobamos si esta definida la variable error en la url
                if (isset($_GET['error'])) {
                    //Si existe comprobamos el valor de la variable si es 1 esque falta algun campo por rellenar
                    if (htmlspecialchars($_GET['error']) == 1) {
                        echo "<p class='mt-2 p-1 text-danger bg-danger-subtle rounded'>Error: Introduzca todos los campos</p>";
                    }
                    //Si esta definada comprobamos el valor de la variable si es 2 el login no fue correcto
                    else if (htmlspecialchars($_GET['error']) == 2) {
                        echo "<p class='mt-2 p-1 text-danger bg-danger-subtle rounded'>Error: Usuario o contraseña incorrectos</p>";
                    }
                    //Si si esta definida comprobamos el valor de la variable si es 3 ha fallado la base de datos.
                    else if (htmlspecialchars($_GET['error']) == 3) {
                        echo "<p class='mt-2 p-1 text-danger bg-danger-subtle rounded'>MANTENIMIENTO DEL SERVIDOR</p>";
                    }
                }
                ?>
                <!--FIN PHP-->
                <button type="submit" class="btn btn-primary">Entrar</button>
            </form>
            <!--FIN FORMULARIO-->
        </div>
        
        <!--Scrip para utilizar las clases de bootstrap que requieren JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
    <!--FIN BODY-->
</html>
