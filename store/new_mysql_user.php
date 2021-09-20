<?php

session_start();
header('Content-Type: text/html; charset=UTF-8');

if (!isset($_SESSION['valid_user']) || !isset($_SESSION['user_data']) )
{
    session_destroy();
    header("location:index.php");
        
}
else
{
    //The user exists. Proceed to write data in tables USUARIOS and DIRENVIOS

    // Primero, se extraen las variables de datos de la Tabla USUARIOS
    $name = mb_convert_encoding($_SESSION['user_data']['name'], 'ISO-8859-1', 'UTF-8');
    $apat = mb_convert_encoding($_SESSION['user_data']['apat'], 'ISO-8859-1', 'UTF-8');
    $amat = mb_convert_encoding($_SESSION['user_data']['amat'], 'ISO-8859-1', 'UTF-8');
    $email = mb_convert_encoding($_SESSION['user_data']['email'], 'ISO-8859-1', 'UTF-8');
    $password = mb_convert_encoding($_SESSION['user_data']['password'], 'ISO-8859-1', 'UTF-8');
    $tel1 = $_SESSION['user_data']['tel1'];
    $tel2 = $_SESSION['user_data']['tel2'];
    $notificarme = $_SESSION['user_data']['notificarme'];

    // Segundo, se preparan las variables de Datos de la Tabla DIRENVIOS
    $entidad = mb_convert_encoding($_SESSION['user_data']['entidad'], 'ISO-8859-1', 'UTF-8');
    $municipio = mb_convert_encoding($_SESSION['user_data']['municipio'], 'ISO-8859-1', 'UTF-8');
    $localidad = mb_convert_encoding($_SESSION['user_data']['localidad'], 'ISO-8859-1', 'UTF-8');
    $colonia = mb_convert_encoding($_SESSION['user_data']['colonia'], 'ISO-8859-1', 'UTF-8');
    $codpost = $_SESSION['user_data']['codpost'];
    $calle = mb_convert_encoding($_SESSION['user_data']['calle'], 'ISO-8859-1', 'UTF-8');
    $numext = $_SESSION['user_data']['numext'];
    $numint = $_SESSION['user_data']['numint'];
    $calle1 = mb_convert_encoding($_SESSION['user_data']['callex'], 'ISO-8859-1', 'UTF-8');
    $calle2 = mb_convert_encoding($_SESSION['user_data']['calley'], 'ISO-8859-1', 'UTF-8');
    $referencia = mb_convert_encoding($_SESSION['user_data']['reference'], 'ISO-8859-1', 'UTF-8');

    if (!get_magic_quotes_gpc())
    {
        $name = addslashes($name);
        $apat = addslashes($apat);
        $amat = addslashes($amat);
        $email = addslashes($email);
        $password = addslashes($password);

        $notificarme = addslashes($notificarme);

        $entidad = addslashes($entidad);
        $municipio = addslashes($municipio);
        $localidad = addslashes($localidad);
        $colonia = addslashes($colonia);

        $calle = addslashes($calle);

        $calle1 = addslashes($calle1);
        $calle2 = addslashes($calle2);
        $referencia = addslashes($referencia);
    }

    $tipousuario = 'C';   //Tipo C - cliente
    $status = 'RN';
    $histamount = 0.00;

    //Generación de 6 caracteres alfanuméricos aleatorios para almacenar en el campo 'cupon' de la Tabla USUARIOS
    $alphanumeric_sha = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    $sequence = range(1, strlen($alphanumeric_sha));
    shuffle($sequence);

    $random_chain = "";
    for ($i=0; $i<= 5; $i++)
    {
        $random_chain .= $alphanumeric_sha[$sequence[$i] - 1];
    }

    //Mostrar al usuario los datos de acceso y los datos de envio  //ESTO DEBE ELIMINARSE
    foreach ($_SESSION['user_data'] as $data)
    {
        echo "Campo: ".$data."<br>";
    }
    
    //Fecha de creación de la cuenta
    $_itemdate = date("Y-m-d H:i:s", time());
    
    //Número de colocaciones y número de pagos inicializados en 0
    $num_colocs = 0;
    $num_payments = 0;

    //Tercero. Se insertan los valores de la tabla USUARIOS
    $usuarios = "INSERT INTO usuarios (nombre, appaterno, apmaterno, email, contrasena, tel1, tel2, notificaciones, tipousuario, status, histamount, num_colocs, num_payments, fechacreada, cupon) VALUES ('".$name."', '".$apat."', '".$amat."', '".$email."', '".$password."', '".$tel1."', '".$tel2."', '".$notificarme."', '".$tipousuario."', '".$status."', '".$histamount."', '".$num_colocs."', '".$num_payments."', '".$_itemdate."', '".$random_chain."')";

    //Cuarto. Se insertan los valores de la tabla DIRENVIOS
    $direcciones = "INSERT INTO direnvios (entidad, municipio, localidad, colonia, codigopost, calle, numext, numint, entrecalle1, entrecalle2, referencia) VALUES ('".$entidad."', '".$municipio."', '".$localidad."', '".$colonia."', '".$codpost."', '".$calle."', '".$numext."', '".$numint."', '".$calle1."', '".$calle2."', '".$referencia."')";

    //Quinto. Conexión a la base de datos: se deben ocultar y usar otro usuario.
    $db = new mysqli('localhost', 'root',  'nailita',  'carboncopy');

    $result1 = $db -> query($usuarios);
    $result2 = $db -> query($direcciones);

    //Sexto. Nos desconectamos de la base de datos
    $db -> close();

    //Séptimo. Se crea y envia el correo para confirmar el correo proporcionado en el registro
    $to = $email;

    $subject = 'Bienvenido - CarbonCopy.Mx';

    $headers = "From: atencion@carboncopy.mx". "\r\n";
    $headers .= "Reply-To: atencion@carboncopy.mx". "\r\n";
    $headers .= "CC: atencion@carboncopy.mx\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    $message = '<html><body>';

    $message .= '<img src="http://www.carboncopy.mx/botones/welcome.png" alt="Website Change Request" />';
    $message .= '<br><br>';
    $message .= 'Gracias por registrarse en Carbon Copy';
    $message .= "<br>";
    $message .= "Para activar su cuenta, haga click en el siguiente enlace:<br><br>";
    $message .= "<a href='http://www.carboncopy.mx/confirmation.php?ccpy=".sha1($random_chain)."'>Haga click aquí</a>";

    $message .= "</body></html>";

    //Se envia el correo a la cuenta del usuario
    mail($to, $subject, $message, $headers);

    //Sexto, se envia un correo indicándome que un nuveo cliente se ha registrado.
    $to = "atencion@carboncopy.mx";

    $subject = 'Nuevo Registro de Cliente - CarbonCopy.Mx';

    $headers = "From: ".$email."\r\n";
    $headers .= "Reply-To: ". "\r\n";
    $headers .= "CC: carloswilsonperez@gmail.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    $message = '<html><body>';

    $message .= '<img src="http://www.carboncopy.mx/botones/welcome.png" alt="Website Change Request" />';
    $message .= '<br><br>';
    $message .= 'Un nuevo cliente acaba de registrarse en Carbon Copy';
    $message .= "<br>";
    $message .= "</body></html>";

    //Se envia el correo a la cuenta del usuario
    mail($to, $subject, $message, $headers);

    //Se limpia la variable de sesión con los datos del usuario.
    unset($_SESSION['user_data']);

    exit;

}


