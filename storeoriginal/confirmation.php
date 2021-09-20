<?php

session_start();

//Aquí se crea el usuario mysql, de la siguiente forma:
// user_id = ccpy + userid  (donde userid es el idusuario en al Tabla USUARIOS)


if (isset($_SESSION['valid_user']))
{
    $_SESSION['valid_user'] = "anonymous";
    $_SESSION['server'] = 'localhost';
    $_SESSION['user_id'] = 'anonymous';
    $_SESSION['user_pass'] = 'anonymous';
    $_SESSION['dbase'] = 'carboncopy';
}

if (isset($_GET['ccpy']))
{
    $mysha1 = $_GET['ccpy'];
    $success = false;
    $invalid_intrusion = false;
    $repeated_sha = false;
    $long = strlen($mysha1);

    if ($long == 40)
    {
        //Si la clave tiene la longitud válida, se realiza la consulta a la Tabla USUARIOS
        $db_tmp = new mysqli($_SESSION['server'], $_SESSION['user_id'],  $_SESSION['user_pass'],  $_SESSION['dbase']);
        $query = "SELECT * FROM usuarios WHERE SHA1(usuarios.cupon)='".$mysha1."'";
        
        $result = $db_tmp -> query($query);
        $num_checks = $result->num_rows;
                       
        if ($num_checks == 1)
        {
            //Solo debe haber exactamente una coincidencia. El mundo ideal
            $row = $result->fetch_assoc();
            
            $user_id = stripslashes($row['idusuario']);
            $user_status = stripslashes($row['status']);
            $user_name = stripslashes($row['nombre']);
            $user_password = stripslashes($row['contrasena']);


            //El usuario normalmente debe tener el status RN al momento de acceder a esta página desde su correo
            //Escribir el valor RV en el campo 'status' de la Tabla USUARIOS
            if ($user_status == 'RN')
            {
                //Si el campo 'status' tiene el valor 'RN', se modifica, de 'RN' a 'RV'
                $query = "UPDATE usuarios SET status='RV' WHERE idusuario='".$user_id."'";
                $result = $db_tmp -> query($query);

                //Crear la cuenta MySQL del nuevo usuario
                $new_account = "ccpy".$user_id;
                $q1 = "GRANT select, insert, update ON carboncopy.usuarios TO '".$new_account."'@'localhost' IDENTIFIED BY '".$user_password."'";
                $q2 = "GRANT select, insert, update ON carboncopy.direnvios TO '".$new_account."'@'localhost' IDENTIFIED BY '".$user_password."'";
                $q3 = "GRANT select, insert, update ON carboncopy.productos TO '".$new_account."'@'localhost' IDENTIFIED BY '".$user_password."'";
                $q4 = "GRANT select, insert, update ON carboncopy.inventario TO '".$new_account."'@'localhost' IDENTIFIED BY '".$user_password."'";
                $q5 = "GRANT select, insert, update ON carboncopy.categorias TO '".$new_account."'@'localhost' IDENTIFIED BY '".$user_password."'";
                $q6 = "GRANT select, insert, update ON carboncopy.mybuys TO '".$new_account."'@'localhost' IDENTIFIED BY '".$user_password."'";
                $q7 = "GRANT select, insert, update ON carboncopy.orders TO '".$new_account."'@'localhost' IDENTIFIED BY '".$user_password."'";
                $q8 = "GRANT select, insert, update ON carboncopy.historial TO '".$new_account."'@'localhost' IDENTIFIED BY '".$user_password."'";
                $q9 = "FLUSH PRIVILEGES";

                $result1 = $db_tmp -> query($q1);
                $result2 = $db_tmp -> query($q2);
                $result3 = $db_tmp -> query($q3);
                $result4 = $db_tmp -> query($q4);
                $result5 = $db_tmp -> query($q5);
                $result6 = $db_tmp -> query($q6);
                $result7 = $db_tmp -> query($q7);
                $result8 = $db_tmp -> query($q8);
                $result9 = $db_tmp -> query($q9);

                //Borrar el campo 'cupon' de la Tabla USUARIOS
                $query = "UPDATE usuarios SET cupon='' WHERE idusuario='".$user_id."'";
                //$result = $db_tmp -> query($query);

                //Cargar las credenciales de navegación del nuevo usuario
                session_regenerate_id();
                $_SESSION['valid_user'] = $user_name;  //
                $_SESSION['user_id'] = "ccpy".$user_id;  //Nombre de cuenta para acceder a la base de datos
                $_SESSION['user_pass'] = $user_password;  //Contraeña para acceder a la base de datos

                $success = true;
                $db_tmp ->close();

            }
            else
            {
                //La cuenta ya ha sido activada antes. Mostrar pantalla de confirmación de activación nuevamente
                //Cargar las credenciales de navegación del nuevo usuario
                $_SESSION['valid_user'] = $user_name;  //
                $_SESSION['user_id'] = "ccpy".$user_id;  //Nombre de cuenta para acceder a la base de datos
                $_SESSION['user_pass'] = $user_password;  //Contraeña para acceder a la base de datos
                $success = true;
            }
        }
        else if ($num_checks == 0)
        {
            //Se accedió a la página CONFIRMATION.PHP por error, o se busca intrusión en la misma;
            $invalid_intrusion = true;
            echo "ERROR: USTED NO DEBERÍA ESTAR EN ESTE PÁGINA!";
        }
        else if ($num_checks > 1)
        {
            //ERROR: no puede haber dos usuarios con la misma cadena aleatoria de confirmación
            $repeated_sha = true;
            echo "ERROR: USUARIOS CON LA MISMA CADENA SHA1";
        }

    }
    else
    {
        //Se accedió a la página CONFIRMATION.PHP por error, o se busca intrusión en la misma;
        $invalid_intrusion = true;
    }

    if($invalid_intrusion)
    {
        $to = "atencion@carboncopy.mx";

        $subject = 'Intento de Intrusión - CarbonCopy.Mx';

        $headers = "From: atencion@carboncopy.mx". "\r\n";
        $headers .= "Reply-To: ". "\r\n";
        $headers .= "CC: \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $message = '<html><body>';

        $message .= '<img src="http://www.carboncopy.mx/botones/welcome.png" alt="Website Change Request" />';
        $message .= '<br><br>';
        $message .= 'ATENCIÓN: Se ha detectado un intento no válido de verificación de cuenta de correo.';

        $message .= "</body></html>";

        //Se envia el correo a la cuenta del usuario
        mail($to, $subject, $message, $headers);
    }

    if ($repeated_sha)
    {
        $to = "atencion@carboncopy.mx";

        $subject = 'Intento de Intrusión - CarbonCopy.Mx';

        $headers = "From: atencion@carboncopy.mx". "\r\n";
        $headers .= "Reply-To: ". "\r\n";
        $headers .= "CC: \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $message = '<html><body>';

        $message .= '<img src="http://www.carboncopy.mx/botones/welcome.png" alt="Website Change Request" />';
        $message .= '<br><br>';
        $message .= 'ATENCIÓN: Se ha detectado usuario con SHA duplicado: .'.$mysha1;

        $message .= "</body></html>";

        //Se envia el correo a la cuenta del usuario
        mail($to, $subject, $message, $headers);

    }
    echo "S".$success;
    if ($success)
    {

        ?>

        <!DOCTYPE html>
        <html lang="es">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <link href="ccpystyles.css" rel="stylesheet" type="text/css">
            </head>

            <body>
                <div class='fondo'>
                    <div id='confirmed'>
                        <table id='confirmed2'>
                            <tr><td><img src="botones/logo.png" width="500" height="250" /></td></tr>
                            <tr><td align='center'> Estimado Cliente: Su cuenta ha quedado activada.</td></tr>
                            <tr><td align='center'>En Carbon Copy estaremos encantados de poder servirle.</td></tr>
                            <tr><td align='center'>Gracias...</td></tr>
                            <tr><td align='center'><a href='index.php'><img src='botones/gotostore.png'></a></td></tr>
                        </table>
                    </div>
                </div>
            </body>
        </html>
        <?php
    }
}




