<?php

session_start();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Login Form</title>
    <link href="ccpystyles.css" rel="stylesheet" type="text/css">
    <script>
        function reload_maquina()
        {
            //top.maquina.location.reload();
        }
    </script>

    </head>
    <body onload='reload_maquina();'>
        <div class='fondo'>

            <?php

            $error_codes = array(
                '1' => 'ERROR: Nombre con caracteres no alfabéticos',
                '2' => 'ERROR: Apellido Paterno con caracteres no alfabéticos',
                '3' => 'ERROR: Apellido Materno con caracteres no alfabéticos',
                '4' => 'ERROR: Cuenta de correo ya registrada',
                '5' => 'ERROR: Teléfono 1 con formato incorrecto',
                '6' => 'ERROR: Teléfono 2 con formato incorrecto',
                '7' => 'ERROR: No se indicó calle',
                '8' => 'ERROR: Nombre de Calle solo contiene blancos',
                '9' => 'ERROR: Calle no pertenece al Fraccionamiento',
                '10' => 'ERROR: Número exterior no válido',
                '11' => 'ERROR: Número Interior no válido',
                '12' => 'ERROR: Nombre de Calle 1 no válido',
                '13' => 'ERROR: Nombre de Calle 2 no válido',
                '14' => 'ERROR: El campo Referencia con caracteres no válidos',
                '15' => 'ERROR: Campo Password con formato incorrecto',
                '16' => 'ERROR: Cuenta de correo contiene caracteres no válidos',
                '17' => 'ERROR: El correo o la contraseña no coinciden',
                '18' => 'ERROR: El correo proporcionado no ha sido registrado');

            $alphanumeric_xt    = '0123456789abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ';
            $alphanumeric_xtx    = '._-0123456789abcdefghijklmnñopqrstuvwxyz';

            $code_bank = array();

            if (isset($_POST['email']))
            {
                //Se destruye cualquier dato de sesión y variables de sesión
                session_unset();

                //Se recarga MÁQUINA.PHP
                echo "<script>";
                echo "reload_maquina()";
                echo "</script>";

                //Se cargan las credenciales de 'anonymous', las cuales se usarán también para la conexión a la base de datos
                $_SESSION['valid_user'] = "anonymous";
                $_SESSION['server'] = 'localhost';
                $_SESSION['user_id'] = 'anonymous';
                $_SESSION['user_pass'] = 'anonymous';
                $_SESSION['dbase'] = 'carboncopy';

                //Se limpia el contenido de 'email'
                $email = trim($_POST['email']);

                //Se verifica que 'email' contenga caracteres válidos
                $email_array = explode('@', $email);

                foreach ($email_array as $mail)
                {
                    $mail = mb_strtolower($mail, 'UTF-8');
                    $long = strlen($mail);

                    for ($i=0; $i < $long; $i++)
                    {
                        if (strpos($alphanumeric_xtx, $mail[$i]) === false)
                        {
                            $code_bank[] = '16';     //Cuenta de correo contiene caracteres no válidos
                            break;
                        }
                    }
                }


                $error_count = count($code_bank);

                if ($error_count == 0)
                {
                    //Si no hay errores tipográficos, entonces se establece
                    //  la conexión a la base de datos para verificar la existencia del correo del usuario
                    $dbc = new mysqli($_SESSION['server'], $_SESSION['user_id'], $_SESSION['user_pass'], $_SESSION['dbase']);

                    $consulta = "SELECT * FROM usuarios WHERE email='".$email."'";
                    $result = $dbc -> query($consulta);

                    $num = $result->num_rows;

                    if ($num == 1)
                    {
                        //  Si la cadena está en la bdd: se recupera la contraseña de la bdd, y se envia al correo del usuario
                        // Primero extraemos los campos de interés

                        $row = $result->fetch_assoc();

                        $user_id = stripslashes($row['idusuario']);
                        $user_name = stripslashes($row['nombre']);
                        $user_mail = stripslashes($row['email']);
                        $user_passwd = stripslashes($row['contrasena']);
                        $user_status = stripslashes($row['status']);
                        $random_chain = stripslashes($row['cupon']);

                        $dbc->close();

                        // Segundo, se verifica si el usuario ya activó su cuenta
                        if ($user_status == 'RV')
                        {
                            //Se envia la contraseña original al correo del usuario
                            $to = $user_mail;

                            $subject = 'Bienvenido - Active su cuenta CarbonCopy';

                            $headers = "From: atencion@carboncopy.mx". "\r\n";
                            $headers .= "Reply-To: ". "\r\n";
                            $headers .= "CC: \r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                            $message = '<html><body>';

                            $message .= '<img src="http://www.carboncopy.mx/botones/welcome.png" alt="Website Change Request" />';
                            $message .= '<br><br>';
                            $message .= 'Gracias por registrarse en Carbon Copy';
                            $message .= "<br>";
                            $message .= "Estimado usuario, su contraseña es la siguiente:<br><br>";
                            $message .= $user_passwd;

                            mail($to, $subject, $message, $headers);

                            ?>

                                <div id='must_be_activated'>
                                    <table id='confirmed2'>
                                        <tr><td><img src="botones/logo.png" width="500" height="250" /></td></tr>
                                        <tr><td>Estimado Cliente: Su contraseña fue recuperada exitosamente.</td></tr>
                                        <tr><td>Su contraseña ha sido enviada a su correo.</td></tr>
                                        <tr><td>Gracias...</td></tr>


                                    </table>
                                </div>
                                </div>
                                </body>
                                </html>
                            <?php
                            exit;

                        }
                        else if ($user_status == 'RN')
                        {
                            //El usuario no ha activado su cuenta.
                            //Primero, enviar de nueva cuenta el correo de activación al correo del usuario
                            $to = $user_mail;

                            $subject = 'Bienvenido - Active su cuenta CarbonCopy';

                            $headers = "From: atencion@carboncopy.mx". "\r\n";
                            $headers .= "Reply-To: ". "\r\n";
                            $headers .= "CC: \r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                            $message = '<html><body>';

                            $message .= '<img src="http://www.carboncopy.mx/botones/welcome.png" alt="Website Change Request" />';
                            $message .= '<br><br>';
                            $message .= 'Gracias por registrarse en Carbon Copy';
                            $message .= "<br>";
                            $message .= "Para activar su cuenta, haga click en el siguiente enlace:<br><br>";
                            $message .= "<a href='http://www.carboncopy.mx/confirmation.php?ccpy=".sha1($random_chain)."'>Haga click aquí</a>";

                            if (!mail($to, $subject, $message, $headers))
                            {
                                ?>

                                <div id='must_be_activated'>
                                    <table id='confirmed2'>
                                        <tr><td><img src="botones/logo.png" width="500" height="250" /></td></tr>
                                        <tr><td>ERROR: Ha ocurrido una falla.</td></tr>
                                        <tr><td>Intente restaurar su contraseña más tarde.</td></tr>
                                        <tr><td>Gracias...</td></tr>

                                    </table>
                                </div>
                                </div>
                                </body>
                                </html>
                                <?php
                            }
                            else
                            {
                                //Segundo.
                                ?>

                                <div id='must_be_activated'>
                                    <table id='confirmed2'>
                                        <tr><td><img src="botones/logo.png" width="500" height="250" /></td></tr>
                                        <tr><td>Estimado Cliente: Debe activar primero su cuenta para esta operación.</td></tr>
                                        <tr><td>En su correo encontrará el mensaje de activación.</td></tr>
                                        <tr><td>Gracias...</td></tr>

                                    </table>
                                </div>
                                </div>
                                </body>
                                </html>
                                <?php
                            }
                        }
                    }
                    else
                    {
                        $code_bank[] = '18';
                    }
                exit;
                }

                 //Si existen errores tipográficos, no se realiza la conexión a la bdd, y se vuelve al Formulario de Restauración

                 echo "<div class='errors_found'>";
                     echo "Usted ha introducido datos erróneos : ";

                     echo "<br />";
                     echo "<br />";
                     echo "<table>";

                         foreach($code_bank as $key)
                         {
                             echo "<tr><td><img src='botones/nok.png' width='25' height='25'></td><td>".$error_codes[$key]."</td></tr>";
                         }

                     echo "</table>";
                     echo "<br />";
                     echo "Por favor, corrija sus datos para poder efectuar su registro. Gracias.";
                 echo "</div>";

            }

            ?>


            <div class='container'>

                <div class="login">

                    <h1>Restauración de Contraseña</h1>
                    <form method="post" action="restore_passwd.php">
                        <p><input type="email" name="email" value="" placeholder="Introduzca su email" required></p>

                        <p class="submit"><input type="submit" name="commit" value="Enviar"></p>
                    </form>
                </div>


            </div>
        </div>
    </body>
</html>



