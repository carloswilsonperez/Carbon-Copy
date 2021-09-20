<?php

    session_start();
    require_once ('check_valid_user.php');
    require_once ('check_total_articles.php');
    require_once('greeting.php');
    require_once('error_codes.php');
    
        
    //***********************************************************************************************************************
    
    if (isset($_GET['unr']) && $_GET['unr'] == true) {
        //El usuario hizo click en el enlace '¿No está registrado?' en la página de login.
        //Se definen de nuevo las sesiones de conexión, para evitar abusos de sesiones ya existentes y no cerradas
        $_SESSION['valid_user'] = "anonymous";
        $_SESSION['server'] = 'localhost';
        $_SESSION['user_id'] = 'anonymous';
        $_SESSION['user_pass'] = 'anonymous';
        $_SESSION['dbase'] = 'carboncopy';
    }

    if (isset($_SESSION['valid_user']) && $_SESSION['valid_user'] !='anonymous' ) {
        //Ir a página que muestra los detalles de la cuenta
        echo "Datos de la cuenta ";
        }
        else {
            
            if (!isset($_POST['completed2'])) {
                
                if (isset($_POST['completed1'])) {
                    
                    // Obtención de datos

                    $name = $_POST['name']; //Validar únicamente que contenga únicamente caracteres alfabéticos en minúscula, acentos y espacios.
                    $apat = $_POST['apat']; //Validar únicamente que contenga únicamente caracteres alfabéticos en minúscula, acentos y espacios.
                    $amat = $_POST['amat']; //Validar únicamente que contenga únicamente caracteres alfabéticos en minúscula, acentos y espacios.
                    $email = $_POST['email'];  //Solo puede contener caracteres alfanuméricos, punto, guión bajo y guión
                    $password = $_POST['password'];  //Validar que tenga una longitud mínima de 6 caracteres alfanuméricos sin espacios ni acentos y máximo 10
                    $tel1 = $_POST['tel1'];  //Validar que sea una cadena válida de diez dígitos numéricos, sin espacios.
                    $tel2 = $_POST['tel2']; //Si se proporciona, validar que sea una cadena válida de diez dígitos numéricos, sin espacios.

                    if (isset($_POST['notificarme'])) {
                        $notificarme = 'Y';
                    }
                    else {
                        $notificarme = 'N';
                    }

                    //Preparación de los datos (eliminación de blancos)

                    $name = trim($name);
                    $apat = trim($apat);
                    $amat = trim($amat);
                    $email = trim($email);
                    $password = trim($password);  //El password NO es convertido a minúsculas y solo admite caracteres alfanuméricos, sin espacios
                    $tel1 = trim($tel1);
                    $tel2 = trim($tel2);

                    $name = mb_strtolower($name, 'UTF-8');
                    $apat = mb_strtolower($apat, 'UTF-8');
                    $amat = mb_strtolower($amat, 'UTF-8');
                    //$email = mb_strtolower($email, 'UTF-8');
                    
                    $error_count = validate_part_1($name, $apat, $amat, $email, $password, $tel1, $tel2);

                    if ($error_count == 0) {
                        //echo "Usted ha introducido los datos correctamente";
                        $completed1 = true;
                        
                        //Se almacenan los datos válidos en la sesión 'user_data'
                        $_SESSION['user_data']['name'] = mb_strtoupper($name, 'UTF-8');
                        $_SESSION['user_data']['apat'] = mb_strtoupper($apat, 'UTF-8');
                        $_SESSION['user_data']['amat'] = mb_strtoupper($amat, 'UTF-8');
                        $_SESSION['user_data']['email'] = $email;
                        $_SESSION['user_data']['password'] = $password;
                        $_SESSION['user_data']['tel1'] = $tel1;
                        $_SESSION['user_data']['tel2'] = $tel2;
                        $_SESSION['user_data']['notificarme'] = mb_strtoupper($notificarme, 'UTF-8');

                        //Continuar al Formulario Final
                    }
                    else
                    {
                        //Volver al Formulario Inicial
                        $completed1 = false;
                        
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
                        echo "<br>";
                        echo "Por favor, corrija sus datos para poder efectuar su registro. Gracias.";
                        echo "</div>";

                    }
                }
            }
            else {
                //Se inicializa array con los nombres de las calles

                $array_streets = array('olivo', 'roble', 'cedros', 'palmas', 'castaño', 'caoba', 'abedules', 'caimito', 'torres', 'nogal', 'ceiba', 'cipres');

                // Obtención de datos...
                // ...primero, se obtienen las variables que no necesitan validación, por estar predeterminadas
                $entidad = $_POST['entidad'];
                $municipio = $_POST['municipio'];
                $localidad = $_POST['localidad'];
                $colonia = $_POST['colonia'];

                //  Segundo, se obtienen y validan las demás variables
                $codpost = $_POST['codpost'];   //Fijo por ahora. No requiere validación.
                $calle = $_POST['calle'];       //Validar únicamente que contenga caracteres alfanuméricos y espacios, y pertenezca al Fracc.
                $numext = $_POST['numext'];     //Validar únicamente que contenga caracteres alfanuméricos y no consista solo en blancos
                $numint = $_POST['numint'];     //Validar únicamente que contenga caracteres alfanuméricos. PUEDE SER DEJADA EN BLANCO
                $calle1 = $_POST['calle1'];     //Validar únicamente que contenga caracteres alfanuméricos y espacios. PUEDE SER DEJADA EN BLANCO
                $calle2 = $_POST['calle2'];     //Validar únicamente que contenga caracteres alfanuméricos y espacios. PUEDE SER DEJADA EN BLANCO
                $referencia = $_POST['referencia'];  //Validar únicamente que contenga caracteres alfanuméricos y espacios. PUEDE SER DEJADA EN BLANCO

                //Preparación de los datos (eliminación de blancos)
                $codpost = trim($codpost);
                $calle = trim($calle);
                $numext = trim($numext);
                $numint = trim($numint);
                $calle1 = trim($calle1);
                $calle2 = trim($calle2);

                $calle = mb_strtolower($calle, 'UTF-8');
                $calle1 = mb_strtolower($calle1, 'UTF-8');
                $calle2 = mb_strtolower($calle2, 'UTF-8');
                $referencia = mb_strtolower($referencia, 'UTF-8');
    
                $error_count = validate_part_2($codpost, $calle, $numext, $numint, $calle1, $calle2);

                if ($error_count == 0) {
                    //Todos los datos introducidos son correctos.
                    $completed1 = true;
                    $completed2 = true;

                    //Escribir los datos validados en la tabla DIRENVIOS
                    //Se almacenan los datos válidos en la sesión 'user_data'
                    $_SESSION['user_data']['entidad'] = mb_strtoupper($entidad, 'UTF-8');
                    $_SESSION['user_data']['municipio'] = mb_strtoupper($municipio, 'UTF-8');
                    $_SESSION['user_data']['localidad'] = mb_strtoupper($localidad, 'UTF-8');
                    $_SESSION['user_data']['colonia'] = mb_strtoupper($colonia, 'UTF-8');
                    $_SESSION['user_data']['codpost'] = $codpost;
                    $_SESSION['user_data']['calle'] = mb_strtoupper($calle, 'UTF-8');
                    $_SESSION['user_data']['numext'] = $numext;
                    $_SESSION['user_data']['numint'] = $numint;
                    $_SESSION['user_data']['callex'] = mb_strtoupper($calle1, 'UTF-8');
                    $_SESSION['user_data']['calley'] = mb_strtoupper($calle2, 'UTF-8');
                    $_SESSION['user_data']['reference'] = mb_strtoupper($referencia, 'UTF-8');

                    header ("location:new_mysql_user.php");

                }
                else {
                    //Volver al Formulario 2
                    $completed1 = true;
                    $completed2 = false;

                    echo "<div class='errors_found'>";
                    echo "Usted ha introducido datos erróneos en los siguientes campos: ";
                    echo "<br />";
                    echo "<table>";

                    foreach($code_bank as $key) {
                        echo "<tr><td><img src='botones/nok.png' width='25' height='25'></td><td>".$error_codes[$key]."</td></tr>";
                    }

                    echo "</table>";
                    echo "<br />";
                    echo "Por favor, corrija sus datos para poder efectuar su registro. Gracias.";
                    echo "</div>";

                }
            }

            if (!isset($completed1) || $completed1 == false) {
                //Mostrar Formulario 1
                ?>

                <section class="container">
                    <div class="register">
                        <h1>Paso 1 de 2: Datos Personales</h1>
                        <form method="post" action="register.php">
                            <p><input type="text" name="name" placeholder="Nombre(s)" maxlength='20' required onfocus="change1('1');"/><span id='asterisk1'>&nbsp;&nbsp;*</span></p>
                            <p><input type="text" name="apat" placeholder="Apellido Paterno" maxlength='20' required onfocus="change1('2');"/><span id='asterisk2'>&nbsp;&nbsp;*</span></p>
                            <p><input type="text" name="amat" placeholder="Apellido Materno" maxlength='20'/></p>
                            <p><input type="email" name="email" placeholder="Correo electrónico" maxlength='40' required onfocus="change1('3');" /><span id='asterisk3'>&nbsp;&nbsp;*</span></p>
                            <p><input type="password" name="password" placeholder="Password" maxlength='10' required onfocus="change1('4');" /><span id='asterisk4'>&nbsp;&nbsp;*</span></p>
                            <p><input type="tel" name="tel1" placeholder="Teléfono 1" maxlength='10'required onfocus="change1('5');" /><span id='asterisk5'>&nbsp;&nbsp;*</span></p>
                            <p><input type="tel" name="tel2" placeholder="Teléfono 2 (Opcional)" maxlength='10' /></p>
                            <input type='hidden' name='completed1' id='completed1' value='false'>
                            <p class="notify_me">
                            <label>
                                <input type="checkbox" name="notificarme" id="notificarme" value='Y' checked>
                                    Acepto recibir notificaciones a mi correo
                            </label>
                            </p>
                            <p class="submit"><input type="submit" name="commit" value="Siguiente" /></p>
                        </form>
                    </div>
                </section>
  
</body>
</html>

<?php

}
else if (!isset($completed2) || $completed2 == false) {
    
    //Mostrar Formulario 2
    ?>

    <section class="container">
        <div class="register">
            <h1>Paso 2 de 2: Datos de Envío</h1>
            <form method="post" action="register.php">
                <p><input type="text" name="entidad" value='Tabasco' readonly /></p>
                <p><input type="text" name="municipio" value='Cárdenas' readonly /></p>

                <p><input type="text" name="localidad" value='Cárdenas' readonly /></p>
                <p>Colonia:
                    <select name='colonia' onfocus="change1('6');" >
                        <option value='los reyes'>Los Reyes Loma Alta</option>
                    </select><span id='asterisk6'>&nbsp;&nbsp;*</span>
                </p>

                <p><input type="text" name="codpost" value='86570' readonly/></p>
                <p>Calle:
                    <select name='calle' onfocus="change1('7');" >
                        <option value='none' selected='selected'>Seleccione su calle</option>
                                <option value='palmas'>Av. de las Palmas</option>
                                <option value='abedules'>Calle Abedules</option>
                                <option value='caimito'>Calle Caimito</option>
                                <option value='caoba'>Calle Caoba</option>
                                <option value='castaño'>Calle Castaño</option>
                                <option value='cedros'>Calle Cedros</option>
                                <option value='ceiba'>Calle Ceiba</option>
                                <option value='las torres'>Calle de las Tores</option>
                                <option value='nogal'>Calle Nogal</option>
                                <option value='olivo'>Calle Olivo</option>
                                <option value='roble'>Calle Roble</option>

                        </select><span id='asterisk7'>&nbsp;&nbsp;*</span>
                        <p><input type="text" name="numext" value="" placeholder='Número Exterior' maxlength='5'required onfocus="change1('8');" /><span id='asterisk8'>&nbsp;&nbsp;*</span></p>
                        <p><input type="text" name="numint" value="" placeholder='Número Interior' maxlength='4' /></p>
                        <p><input type="text" name="calle1" placeholder='Entre Calle 1' maxlength='30' /></p>
                        <p><input type="text" name="calle2" placeholder='Entre Calle 2' maxlength='30' /></p>
                        <p><input type="text" name="referencia" value="" placeholder="Señas de ubicación" maxlength='80' /></p>

                        <input type='hidden' name='completed2' id='completed2' value='false'>

                        <p class="submit"><input type="submit" name="commit" value="Registrar" /></p>
                    </form>
                </div>
       
            </section>

?>


<!DOCTYPE html>
<html lang="es">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
    <body>

        <header id="site_head">	
            
        <?php 
            //Arriba estaba el form id='catalogo'
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

<?php
}
}
