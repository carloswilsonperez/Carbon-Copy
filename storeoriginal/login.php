<?php

session_start();

if (!isset($_SESSION['valid_user']))
{
    $_SESSION['valid_user'] = "anonymous";
    $_SESSION['server'] = 'localhost';
    $_SESSION['user_id'] = 'anonymous';
    $_SESSION['user_pass'] = 'anonymous';
    $_SESSION['dbase'] = 'carboncopy';
}

if (!isset($_SESSION['total_articles']))
{
    $_SESSION['total_articles'] = 0;
    $_SESSION['total_money'] = 0;
    $_SESSION['total_utility'] = 0;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Login Form</title>
    <link href="ccpystyles.css" rel="stylesheet" type="text/css">
    <script>
        function update_username_login(message)
        {
            var div = top.frames['maquina'].document.getElementById('username');
            
            if (message == 'anonymous')
            {
                div.innerHTML = "Bienvenid@ a nuestra tienda virtual";
            }
            else
            {
                top.presen.location.href = 'presen.php';
            }
                      
        }
           
        function update_cart()
        {
            var content = "<table><tr><td rowspan = '2' width='80'><a href='viewcart.php' target='presen'><img src='botones/carrito1.png' width='40' height='40' /></a></td><td width='80'><?php echo $_SESSION['total_articles']; ?> </td><td rowspan='2' width='80'><?php echo sprintf ("\$%.2f", $_SESSION['total_money']); ?></td></tr><tr><td>  art&iacute;culo(s)</td></tr></table>";
            var div = top.frames['maquina'].document.getElementById('carrito');
                    
            div.innerHTML = content;
        }
    </script>

    </head>
    <body onload="update_cart();update_username_login('<?php echo $_SESSION['valid_user'] ?>')">
        <div>

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


            if (isset($_POST['email']) && isset($_POST['password']))
            {

                //Se definen de nuevo las sesiones de conexión, para evitar abusos de sesiones ya existentes y no cerradas
                $_SESSION['valid_user'] = "anonymous";
                $_SESSION['server'] = 'localhost';
                $_SESSION['user_id'] = 'anonymous';
                $_SESSION['user_pass'] = 'anonymous';
                $_SESSION['dbase'] = 'carboncopy';


                //Limpieza de email y password
                $email = trim($_POST['email']); //La variable email solo puede contener caracteres alfanuméricos en minúscula, punto, @, _ y -
                $password = trim($_POST['password']);

                $email_array = explode('@', $email);

                //La variable EMAIL solo puede contener caracteres alfanuméricos en minúscula, punto, guión bajo y guión, sin espacios ni acentos
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

                //Se verifica que el PASSWORD tenga de 6 a 10 caracteres alfanuméricos, sin espacios ni acentos.
                $long = strlen($password);  //Debe contener de 6 a 10 caracteres alfanuméricos, sin espacios ni acentos

                if ($long < 6)      // El campo debe contener al menos 6 caracteres
                {
                    $code_bank[] = '15';     //Campo Contraseña con longitud menor a 6. Formato incorrecto
                }
                else
                {
                    //Se verifica que contenga únicamente caracteres alfanuméricos, sin espacios ni acentos
                    for ($i=0; $i < $long; $i++)
                    {
                        if (strpos($alphanumeric_xt, $password[$i]) === false)
                        {
                            $code_bank[] = '15';     //Campo Contraseña contiene caracteres no válidos. Formato incorrecto
                            break;
                        }
                    }
                }


                $error_count = count($code_bank);

                if ($error_count == 0)
                {
                    //Si no hay errores tipográficos, entonces se establece
                    //  la conexión a la base de datos para verificar la existencia del par correo - contraseña
                    $dbc = new mysqli($_SESSION['server'], $_SESSION['user_id'], $_SESSION['user_pass'], $_SESSION['dbase']);

                    $consulta = "SELECT * FROM usuarios WHERE email='".$email."' AND contrasena='".$password."'";
                    $result = $dbc -> query($consulta);

                    $num = $result->num_rows;

                    if ($num == 1) {
                        //El par usuario - contraseña existe en la Tabla USUARIOS
                        // Falta verificar si el usuario ya activó su cuenta.

                        //Obtener el nombre y el idusuario del usuario
                        $row = $result->fetch_assoc();

                        $user_name = stripslashes($row['nombre']);
                        $user_id = stripslashes($row['idusuario']);
                        $user_status = stripslashes($row['status']);
                        $random_chain = stripslashes($row['cupon']);

                        if ($user_status == 'RV') {
                            //El usuario ya activó previamente su cuenta.
                            //Se modifican las variables de sesión con los datos de conexión
                            session_regenerate_id();
                            $_SESSION['valid_user'] = $user_name;  //
                            $_SESSION['user_id'] = "ccpy".$user_id;  //Nombre de cuenta para acceder a la base de datos
                            $_SESSION['user_pass'] = $password;  //Contraeña para acceder a la base de datos
                            
                            $message = "";
        
                            if (isset($_SESSION['valid_user']) && $_SESSION['valid_user'] != 'anonymous')
                            {
                                $message = $_SESSION['valid_user'];
                                    
                                ?>
                                <script>
                                    update_username_login('<?php echo $message; ?>');
                                </script>
                                <?php
                            }
                            //Continuar a la página de inicio
                            
                        }
                        else {
                            //El usuario no ha activado su cuenta.

                            //Primero, enviar de nueva cuenta el correo de activación al correo del usuario
                            $to = $email;

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
                                        <tr><td> Estimado Cliente: Su cuenta aún no ha sido activada.</td></tr>
                                        <tr><td>En su correo encontrará el mensaje de activación.</td></tr>
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
                                //Segundo. Indicar al usuario que debe activar su cuenta antes de poder logearse al sitio
                                ?>

                                <div id='must_be_activated'>
                                    <table id='confirmed2'>
                                        <tr><td><img src="botones/logo.png" width="500" height="250" /></td></tr>
                                        <tr><td> Estimado Cliente: Su cuenta aún no ha sido activada.</td></tr>
                                        <tr><td>Hemos enviado un enlace de activación a su cuenta de correo.</td></tr>
                                        <tr><td>Gracias...</td></tr>

                                    </table>
                                </div>
                                </div>
                                </body>
                                </html>
                                <?php

                                $dbc->close();
                                exit;
                            }
                        }
                    }
                    else
                    {
                        $code_bank[] = '17';
                    }
                }

                //Volver al Formulario de Acceso

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
                <div class='unregistered'>¿No está registrado? <a href='register.php?unr=true' target='presen'>Haga click aquí.</a></div>

                <div class="login">

                    <h1>Introduzca sus datos de acceso</h1>
                    <form method="post" action="login.php">
                        <p><input type="email" name="email" value="" placeholder="Username or Email" required></p>
                        <p><input type="password" name="password" value="" placeholder="Password" required=""></p>
                        <p class="remember_me">
                            <label>
                                <input type="checkbox" name="remember_me" id="remember_me" checked>
                                Recordarme en esta computadora
                            </label>
                        </p>
                        <p class="submit"><input type="submit" name="commit" value="Entrar"></p>
                    </form>
                </div>

                <div class="login-help">
                    <p>¿Olvidó su contraseña? <a href='restore_passwd.php' target='presen'>Haga click aquí para restaurarla</a>.</p>
                </div>

            </div>
        </div>
    </body>
</html>



