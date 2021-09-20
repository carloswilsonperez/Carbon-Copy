<?php

session_start();

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
    '18' => 'ERROR: Su comentario contiene caracteres no válidos',
    '19' => 'ERROR: Campo comentario está vacío',
    '20' => 'ERROR: El asunto contiene caracteres no válidos');


$code_bank = array();

$numeric            = '0123456789';                                 //Numérico, sin espacios
$alphabetic         = ' áéíóúabcdefghijklmnñopqrstuvwxyz';          //Alfabético minúsculas, con espacios y acentos
$alphabetic_m       = ' ÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ';          //Alfabético mayúsculas, con espacios y acentos
$alphabetic_xt      = ' áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ';  //Alfabético mayúsculas y minúsculas, con espacio y acentos
$alphanumeric_na    = ' abcdefghijklmnñopqrstuvwxyz0123456789';     //Alfanumérico minúsculas, con espacios y sin acentos
$alphanumeric       = ' áéíóúabcdefghijklmnñopqrstuvwxyz0123456789';  //Alfanumérico minúsculas, con espacios y acentos
$alphanumeric_ns    = '0123456789abcdefghijklmnñopqrstuvwxyz';      // Alfanumérico minúsculas, sin espacios ni acentos
$alphanumeric_xt    = '0123456789abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ'; // Alfanumérico mayúsculas y minúsculas, sin espacios ni acentos
$alphanumeric_xtx    = '._-0123456789abcdefghijklmnñopqrstuvwxyz';  //Alfanumérico minúsculas, sin espacios, con ., _ y -
$alphanumeric_xtxs    = ' .,;_-()!¡¿?0123456789abcdefghijklmnñopqrstuvwxyz';  //Alfanumérico minúsculas, con espacios, ., _, -, (, )

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="ccpystyles.css" rel="stylesheet" type="text/css">
        <script>
            function change_asterisk(param)
            {
                var element = 'asterisk' + param;
                document.getElementById(element).style.color = 'green';
            }

        </script>
    </head>

    <body>
        <div class='fondo'>

            <div id='contacto'>
                <p>!Nos interesa mucho tu opinion!</p>
                <br>
                Puedes enviarnos tus preguntas, comentarios, dudas, quejas o sugerencias a los correos indicados 
                más adelante, así como al al teléfono (937) 127-3089, o contactarnos por medio del formulario adjunto.
                
                <br><br>
                En Carbon Copy estamos comprometidos a brindarte el mejor servicio posible.
                <br><br>
                ********* Gracias por tu confianza *********
                

                <p>1) Correos de Contacto:</p>

                <table width='70%'>
                    <tr><td>Dudas y comentarios generales</td><td>atencion@carboncopy.mx</td></tr>
                    <tr><td>Pedidos</td><td>pedidos@carboncopy.mx</td></tr>
                    <tr><td>Proveedores</td><td>compras@carboncopy.mx</td></tr>
                </table>

                <br>
                <p>2) Nuestra zona de cobertura actual:</p>

                <div>

                    <iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com.mx/maps?num=40&amp;safe=off&amp;q=google+maps+cardenas+tabasco&amp;ie=UTF8&amp;hq=&amp;hnear=Heroica+C%C3%A1rdenas,+Tabasco&amp;gl=mx&amp;t=m&amp;ll=17.988509,-93.392673&amp;spn=0.007143,0.00912&amp;z=16&amp;iwloc=A&amp;output=embed"></iframe><br />
                </div>
            

            <p>3) Formulario de Contacto:</p>


            <?php

                if (isset($_POST['name']) && isset($_POST['email'])  && isset($_POST['asunto']) && isset($_POST['contenido']) )
                {
                    //Se definen de nuevo las sesiones de conexión, ya que quien escribe podría no ser un cliente registrado
                    if (!isset($_SESSION['valid_user']))
                    {
                        $_SESSION['valid_user'] = "anonymous";
                        $_SESSION['server'] = 'localhost';
                        $_SESSION['user_id'] = 'anonymous';
                        $_SESSION['user_pass'] = 'anonymous';
                        $_SESSION['dbase'] = 'carboncopy';
                    }


                    //Limpieza de los datos del formulario
                    //  Primero, se eliminan los blancos
                    $name = trim($_POST['name']); //La variable $nombre solo puede contener caracteres alfanuméricos en minúscula, punto, @, _ y -
                    $email = trim($_POST['email']);
                    $asunto = trim($_POST['asunto']);
                    $contenido = trim($_POST['contenido']);

                    if (isset($_POST['tomymail']))
                    {
                        $tomymail = 'Y';
                    }
                    else
                    {
                        $tomymail = 'N';
                    }

                    //  Segundo. Se convierte los datos a minúsculas
                    $name = mb_strtolower($name, 'UTF-8');
                    $email = mb_strtolower($email, 'UTF-8');
                    $asunto = mb_strtolower($asunto, 'UTF-8');
                    $contenido = mb_strtolower($contenido, 'UTF-8');


                    //Validación del NOMBRE  ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
                    $long = strlen($name);

                    if ($long > 0)
                    {
                        for ($i=0; $i < $long; $i++)
                        {
                            if (strpos($alphabetic, $name[$i]) === false)
                            {
                                $code_bank[] = '1';     //Campo Nombre contiene caracteres no alfabéticos
                                break;
                            }
                        }
                    }
                    else
                    {
                        $code_bank[] = '1';      //Campo Nombre solo contenía blancos
                    }


                    //La variable EMAIL solo puede contener caracteres alfanuméricos en minúscula, punto, _, y -, sin espacios ni acentos
                    $email_array = explode('@', $email);

                    foreach ($email_array as $mail)
                    {
                        $mail = mb_strtolower($mail, 'UTF-8');
                        $long = strlen($mail);

                        for ($i=0; $i < $long; $i++)
                        {
                            if (strpos($alphanumeric_xtx, $mail[$i]) === false)
                            {
                                $code_bank[] = '16';     //Campo email contiene caracteres no válidos
                                break;
                            }
                        }
                    }

                    //Validación del ASUNTO  ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
                    $long = strlen($asunto);

                    if ($long > 0)
                    {
                        for ($i=0; $i < $long; $i++)
                        {
                            if (strpos($alphanumeric_xtxs, $asunto[$i]) === false)
                            {
                                $code_bank[] = '20';     //Campo asunto contiene caracteres no alfabéticos
                                break;
                            }
                        }
                    }
                    else
                    {
                        $code_bank[] = '1';      //Campo Nombre solo contenía blancos
                    }

                    //Validación del CONTENIDO  ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
                    $long = strlen($contenido);

                    if ($long > 0)
                    {
                        for ($i=0; $i < $long; $i++)
                        {
                            if (strpos($alphanumeric_xtxs, $contenido[$i]) === false)
                            {
                                $code_bank[] = '18';     //Campo Contenido contiene caracteres no alfabéticos
                                break;
                            }
                        }
                    }
                    else
                    {
                        $code_bank[] = '19';      //Campo Contenido solo contenía blancos
                    }


                    $error_count = count($code_bank);

                    if ($error_count == 0)
                    {
                        //El formulario de contacto se ha llenado correctamente
                        //Generar y enviar el correo de contacto a Carbon Copy

                        $to = "atencion@carboncopy.mx";     //Correo de atención de Carbon Copy

                        $subject = 'Mensaje de Contacto - CarbonCopy.Mx';

                        $headers = "From: atencion@carboncopy.mx". "\r\n";
                        $headers .= "Reply-To: ".$email."\r\n";
                        $headers .= "CC: carloswilsonperez@gmail.com\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        $message = '<html><body>';

                        $message .= '<img src="http://www.carboncopy.mx/botones/contact.png" alt="Website Change Request" />';
                        $message .= '<br><br>';
                        $message .= "Se ha recibido el siguiente mensaje de correo:<br><br>";
                        $message .= "<br>Nombre :".$name;
                        $message .= "<br>Email :".$email;
                        $message .= "<br>Asunto :".$asunto;
                        $message .= "<br>Mensaje :".$contenido;

                        $message .= "</body></html>";

                        //Se envia el correo a la cuenta del usuario
                        //Indicar al usuario que su mensaje fue enviado con éxito

                        if (!mail($to, $subject, $message, $headers))
                        {
                            echo "Su correo NO pudo enviarse. Intente más tarde";
                        }
                        else
                        {
                            echo "<div style='position: relative; left: 205px; color: green;'>::::Su correo fue enviado con éxito::::</div>";
                            echo "<br>";
                        }


                        if ($tomymail == 'Y')
                        {

                            $to = $email;  //Cuenta de correo del usuario

                            $subject = 'Mensaje enviado a CarbonCopy.Mx';

                            $headers = "From: atencion@carboncopy.mx". "\r\n";
                            $headers .= "Reply-To: "."\r\n";
                            $headers .= "CC: \r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                            $message = '<html><body>';

                            $message .= '<img src="http://www.carboncopy.mx/botones/contact.png" alt="Website Change Request" />';
                            $message .= '<br><br>';
                            $message .= "Se ha recibido el siguiente mensaje de correo:<br><br>";
                            $message .= "<br>Nombre :".$name;
                            $message .= "<br>Email :".$email;
                            $message .= "<br>Asunto :".$asunto;
                            $message .= "<br>Mensaje :".$contenido;

                            $message .= "</body></html>";

                            //Se envia el correo a la cuenta del usuario
                            mail($to, $subject, $message, $headers);
                        }
                    }
                    else
                    {
                        //No enviar el formulario. Mostrar mensajes de error y dar la opción de intentar de nuevo

                        echo "<div class='errors_found'>";

                            echo "Usted ha introducido datos erróneos en los siguientes campos: ";
                            echo "<br />";
                            echo "<table>";

                                foreach($code_bank as $key)
                                {
                                    echo "<tr><td><img src='botones/nok.png' width='25' height='25'></td><td>".$error_codes[$key]."</td></tr>";
                                }

                            echo "</table>";
                            echo "<br />";
                            echo "Por favor, corrija sus datos para poder enviar su mensaje. Gracias.";
                        echo "</div>";

                    }
                }
                ?>

                </div>
                <section>
                    <div class="register">
                        <h1>Formulario de Contacto</h1>
                        <form method="post" id='contactform' action="contacto.php">
                            <p><input type="text" name="name" placeholder="Nombre(s)" maxlength='20' required onfocus="change_asterisk('9');"/><span id='asterisk9'>&nbsp;&nbsp;*</span></p>

                            <p><input type="email" name="email" placeholder="Correo electrónico" maxlength='40' required onfocus="change_asterisk('10');" /><span id='asterisk10'>&nbsp;&nbsp;*</span></p>

                            <p><input type="text" name="asunto" placeholder="Asunto" maxlength='30' required onfocus="change_asterisk('11');"/><span id='asterisk11'>&nbsp;&nbsp;*</span></p>

                            <p><textarea name='contenido' required />
                                </textarea></p>

                            <p class="notify_me">
                                <label>
                                    <input type="checkbox" name="tomymail" id="tomymail" value='Y' checked>
                                    Enviar una copia a mi correo
                                </label>
                            </p>
                            <p class="submit"><input type="submit" name="commit" value="Enviar" /></p>
                        </form>

                    </div>
                </section>
           </div>
    </body>
</html>