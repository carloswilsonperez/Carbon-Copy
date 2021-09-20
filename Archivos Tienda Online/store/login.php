<?php

session_start();

require_once ('check_valid_user.php');
require_once ('check_total_articles.php');
require_once('greeting.php');
require_once('error_codes.php');

$must_activate = false;
$new_activation_mail = true;
$login_errors = true;
$valid_user = false;
$repeated_user = false;
$null_user = false;


            if (isset($_POST['email']) && isset($_POST['password'])) {

                //Se definen de nuevo las sesiones de conexión, y se establece el usuario 'anonymous' para evitar abusos de sesiones ya existentes y no cerradas
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

                if ($error_count == 0) {
                    //Si no hay errores tipográficos, y el password tiene la longitud mínima, entonces se establece...
                    //  ...la conexión a la base de datos para verificar la existencia del par correo - contraseña
                    
                    $login_errors = false;
                    
                    $dbc = new mysqli($_SESSION['server'], $_SESSION['user_id'], $_SESSION['user_pass'], $_SESSION['dbase']);
                    
                    //$email = $dbc->real_escape_string($email);
                    //$password = $dbc->real_escape_string($password);
                    $consulta = "SELECT * FROM usuarios WHERE email='".$email."' AND contrasena='".$password."'";
                    $result = $dbc -> query($consulta);

                    $num = $result->num_rows;

                    if ($num > 1) {
                        //Existen credenciales repetidas en la base de datos de usuarios.
                        $repeated_user = true;
                    }
                    else if ($num == 1) {
                        //El par usuario - contraseña existe en la Tabla USUARIOS.
                        // Y se verifica que el usuario ya activó su cuenta.

                        //Obtener el nombre y el idusuario del usuario
                        $row = $result->fetch_assoc();

                        $user_name = stripslashes($row['nombre']);
                        $user_id = stripslashes($row['idusuario']);
                        $user_status = stripslashes($row['status']);
                        $random_chain = stripslashes($row['cupon']);

                        if ($user_status == 'RV') {
                            //El usuario ya activó previamente su cuenta.
                            //Se modifican las variables de sesión con los datos de conexión
                            //session_regenerate_id();
                            $valid_user = true;
                            $_SESSION['valid_user'] = $user_name;  //
                            $_SESSION['user_id'] = "ccpy".$user_id;  //Nombre de cuenta para acceder a la base de datos
                            $_SESSION['user_pass'] = $password;  //Contraeña para acceder a la base de datos
                               
                            
                            //Continuar a la página de inicio
                            //exit;
                        }
                        else {
                            //El usuario no ha activado su cuenta.
                            $must_activate = true;
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

                            if (!mail($to, $subject, $message, $headers)) {
                                $new_activation_mail = false;    
                                }
                            
                            $dbc->close();
                                    //exit;
                        }
                    }
                    else {
                        $null_user = true;
                    }   
                }                
            }

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="ccpystyles.css" rel="stylesheet" type="text/css">
    <title>Carbon Copy</title>
        <meta name="description" content="">
        <meta name="author" content="Carlos">

        <meta name="viewport" content="width=device-width; initial-scale=1.0">

        <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
        <link rel="shortcut icon" type="image/png" href="logo.png">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        <script> 
            var username = '<?php echo $message; ?>';
            var total_articles = '<?php echo $_SESSION["total_articles"]; ?>';
            var total_money = '<?php echo $_SESSION["total_money"]; ?>';
        </script>
        <script src='script_code.js'></script>

</head>
<body id='loginbody'>
    <header id="site_head">	
            
        <?php 
            require_once('header.php');
        ?>
    
    </header>

    <div id='indice'></div>
    <div id='izquierda'>
            
        <?php 
            require_once('menu.php');
        ?>
            
    </div>
    <div id='derecha'></div>
    <div id='right-upper-box'></div>
    <div id='left-upper-box'></div>

     <div id="fondo"><!--Incluye al mostrador-->  
            
            <?php
            
            if (isset($_POST['email']) && isset($_POST['password'])) {
                
                if ($login_errors) {
                    //$valid_user = false
                    //Mostrar errores
                    ?>
                    <div class='errors_found'>
                        Usted ha introducido datos erróneos : 

                        <br />
                        <br />
                        <table>
                        <?php
                            foreach($code_bank as $key)
                            {
                                echo "<tr><td><img src='botones/nok.png' width='25' height='25'></td><td>".$error_codes[$key]."</td></tr>";
                            }
                        ?>
                        </table>
                        <br />
                        Por favor, corrija sus datos para poder efectuar su registro. Gracias.
                    </div>
                 
                    <?php
                }
                else if (!$repeated_user && !$null_user) {
                    
                    //$valid_user = true
                        
                    if ($must_activate) {
                        
                        if ($new_activation_mail) {
                    
                        //Mostrar nuevo mensaje
                        ?>
                        <div id='must_be_activated'>
                            <table id='confirmed2'>
                                <tr><td><img src="botones/logo.png" width="500" height="250" /></td></tr>
                                <tr><td> Estimado Cliente: Su cuenta aún no ha sido activada.</td></tr>
                                <tr><td>Hemos enviado un nuevo enlace de activación a su cuenta de correo.</td></tr>
                                <tr><td>Gracias...</td></tr>
                            </table>
                        </div></div>
            
                        <?php
                        
                        }
                        else {
                        //Mostrar viejo mensaje
                        ?>
                        <div id='must_be_activated'>
                            <table id='confirmed2'>
                                <tr><td><img src="botones/logo.png" width="500" height="250" /></td></tr>
                                <tr><td> Estimado Cliente: Su cuenta aún no ha sido activada.</td></tr>
                                <tr><td>En su correo encontrará el mensaje de activación.</td></tr>
                                <tr><td>Gracias...</td></tr>
                            </table>
                        </div></div>
                        <?php
                    }
                    
                    //Salir
                    
                    exit;
                    }

                }    
                else {
                    //$valid_user = false
                    if ($repeated_user) {
                        //Avisar al administrador
                    }   
                }     
            } //FIN isset($_POST['email']) && isset($_POST['password'])
            
            //Mostrar formulario
            ?>
                
                <div class='unregistered'>
                <?php
                
                if (!isset($_SESSION['valid_user']) || $_SESSION['valid_user'] =='anonymous' ) {
                    ?>
                        
                            ¿No está registrado? <a href='register.php?unr=true'>Haga click aquí.</a>
                        
                    <?php
                }
                ?>
                </div>

                <div id="login">

                    <h1>Introduzca sus datos de acceso</h1>
                    <form method="post" action="login.php">
                        <p><input type="email" name="email" value="" placeholder="Username or Email" required></p>
                        <p><input type="password" name="password" value="" placeholder="Password" required=""></p>
                        <p id="remember_me">
                            <label>
                                <input type="checkbox" name="remember_me" id="remember_me" checked>
                                Recordarme en esta computadora
                            </label>
                        </p>
                        <p class="submit"><input type="submit" name="commit" value="Entrar"></p>
                    </form>
                </div>

                <div class="login-help">
                    <p>¿Olvidó su contraseña? <a href='restore_passwd.php'>Haga click aquí para restaurarla</a>.</p>
                </div>
            
            
    </div>      
    <div id="bottom">
        
        <?php 
            require_once('bottom.php');
        ?>
            
    </div>

    <?php
        
        require_once('forms.php');
    ?>
   
    </body>
</html>



