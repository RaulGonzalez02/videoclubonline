<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
session_start();
//Si la session user esta inicializada y la session rol es 0
if (isset($_SESSION['user']) && $_SESSION['rol'] == 0) {
    //Si la longitud del array de POST es diferente a 0
    if (count($_POST) != 0) {
        //Si todas las variables de de POST estan inicializadas a algo diferente de ""
        if (htmlspecialchars($_POST['email'] != "") && htmlspecialchars($_POST['mensaje']) != "") {
            //echo "Todos los campos completos";
            $email = htmlspecialchars($_POST['email']);
            $body = htmlspecialchars($_POST['mensaje']);
            //echo $email." ".$body;
            try {

                /*
                 * Necesitas la vereficación de dos pasos en el gmail activada.
                 * Y la contraseña de aplicación (app password).
                 */

                $mail = new PHPMailer(true); //Crear objeto de la clase PHPMailer

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; //Tipo de host: gmail en este caso
                $mail->SMTPAuth = true; //Autentificación activada


                $mail->Username = 'videoclubgonzalez@gmail.com'; //Tu gmail
                $mail->Password = 'imnnyfzmlhibgthe'; //Tu contraseña de aplicación de gamil
                $mail->SMTPSecure = 'ssl'; //Tipo de seguridad
                $mail->Port = 465; //Puerto de smtp

                $mail->setFrom('videoclubgonzalez@gmail.com'); //Gmail desde el que se envía el mensaje

                $mail->addAddress('videoclubgonzalez@gmail.com'); //El email que recibe el correo

                $mail->isHTML(true); //El mensaje enviado es HTML

                $mail->Subject = "Incidencias del usuario: " . substr($_SESSION['user'], 0, -1) . " con el mail " . $email; //Asunto del mensaje
                $mail->Body = $body; //Cuerpo del mensaje


                /*
                 * De esta forma, envío el mensaje y el resultado lo guardo en una
                 * variable llamada $exito.
                 * 
                 * Si el mensaje es enviado --> $exito tiene valor 1.
                 * 
                 * Por lo que si $exito tiene cualquier otro valor, siginifica que
                 * el mensaje no fue enviado.
                 */
                $exito = $mail->send();

                //Si el mensaje no fue enviado --> Mando una excepción;
                if ($exito == 1) {
                    header("Location:./rol0.php?error=0");
                }
            } catch (Exception $exc) {
                header("Location:./rol0.php?error=2");
            }
        }
        //Si no redireccionamos a la pagina rol0.php y mostramos un error
        else {
            header("Location:./rol0.php?error=1");
        }
    }
    //Si no redireccionamos a la pagina rol0.php y mostramos un error
    else {
        header("Location:./rol0.php?error=1");
    }
}
//Si no redireccionamos a la pagina rol0.php y mostramos un error
else {
    header("Location:../index.php?error=1");
}
