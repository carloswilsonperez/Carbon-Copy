<?php

    session_start();

?>


<!DOCTYPE html>
<html lang="es">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="ccpystyles.css" rel="stylesheet" type="text/css">

        <script>
            function change1(param)
            {
                var element = 'asterisk' + param;
                document.getElementById(element).style.color = 'green';
            }

            function reload_maquina()
            {
                top.maquina.location.reload();

            }
        </script>
    </head>

    <body>

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


            $code_bank = array();

            $numeric            = '0123456789';                                 //Numérico, sin espacios
            $alphabetic         = ' áéíóúabcdefghijklmnñopqrstuvwxyz';          //Alfabético minúsculas, con espacios y acentos
            $alphabetic_m       = ' ÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ';          //Alfabético mayúsculas, con espacios y acentos
            $alphabetic_xt      = ' áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ';
            $alphanumeric_na    = ' abcdefghijklmnñopqrstuvwxyz0123456789';     //Alfanumérico, con espacios y sin acentos
            $alphanumeric       = ' áéíóúabcdefghijklmnñopqrstuvwxyz0123456789';  //Alfanumérico, con espacios y acentos
            $alphanumeric_ns    = '0123456789abcdefghijklmnñopqrstuvwxyz';      // Alfanumérico minúsculas, sin espacios ni acentos
            $alphanumeric_xt    = '0123456789abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ'; // Alfanumérico sin espacios ni acentos
            $alphanumeric_xtx    = '._-0123456789abcdefghijklmnñopqrstuvwxyz';

            if (isset($_GET['unr']) && $_GET['unr'] == true)
            {
                //El usuario hizo click en el enlace '¿No está registrado?' en la página de login.
                //Se definen de nuevo las sesiones de conexión, para evitar abusos de sesiones ya existentes y no cerradas
                $_SESSION['valid_user'] = "anonymous";
                $_SESSION['server'] = 'localhost';
                $_SESSION['user_id'] = 'anonymous';
                $_SESSION['user_pass'] = 'anonymous';
                $_SESSION['dbase'] = 'carboncopy';

                echo "<script>";
                    echo "reload_maquina();";
                echo "</script>";
            }

            if (isset($_SESSION['valid_user']) && $_SESSION['valid_user'] !='anonymous' )
            {
                //Ir a página que muestra los detalles de la cuenta

                echo "Datos de la cuenta ";
            }
            else
            {


            if (!isset($_POST['completed2']))
            {

                if (isset($_POST['completed1']))
                {
                    // Obtención de datos

                    $name = $_POST['name']; //Validar únicamente que contenga únicamente caracteres alfabéticos en minúscula, acentos y espacios.
                    $apat = $_POST['apat']; //Validar únicamente que contenga únicamente caracteres alfabéticos en minúscula, acentos y espacios.
                    $amat = $_POST['amat']; //Validar únicamente que contenga únicamente caracteres alfabéticos en minúscula, acentos y espacios.
                    $email = $_POST['email'];  //Solo puede contener caracteres alfanuméricos, punto, guión bajo y guión
                    $password = $_POST['password'];  //Validar que tenga una longitud mínima de 6 caracteres alfanuméricos sin espacios ni acentos y máximo 10
                    $tel1 = $_POST['tel1'];  //Validar que sea una cadena válida de diez dígitos numéricos, sin espacios.
                    $tel2 = $_POST['tel2']; //Si se proporciona, validar que sea una cadena válida de diez dígitos numéricos, sin espacios.

                    if (isset($_POST['notificarme']))
                    {
                        $notificarme = 'Y';
                    }
                    else
                    {
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


        //Validación del nombre  ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
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


        //Validación del apellido paterno  :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        $long = strlen($apat);
        if ($long > 0)
        {
            for ($i=0; $i < $long; $i++)
            {
                if (strpos($alphabetic, $apat[$i]) === false)
                {
                    $code_bank[] = '2';     //Campo Apellido Paterno contiene caracteres no alfabéticos
                    break;
                }
            }
        }
        else
        {
            $code_bank[] = '2';     //Campo Apellido Paterno solo contenía blancos
        }


        //Validación del apellido materno  :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        $long = strlen($amat);

        if ($long > 0)
        {
            for ($i=0; $i < $long; $i++)
            {
                if (strpos($alphabetic, $amat[$i]) === false)
                {
                    $code_bank[] = '3';     //Campo Apellido Materno contiene caracteres no alfabéticos
                    break;
                }
            }
        }
        else
        {
            $code_bank[] = '3';     //Campo Apellido Materno solo contenía blancos
        }

        //Validación de CORREO ELECTRÓNICO:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        //Primero, se verifica si no existe un correo idéntico previamente registrado

        $db_tmp = new mysqli($_SESSION['server'], $_SESSION['user_id'],  $_SESSION['user_pass'],  $_SESSION['dbase']);

        $query = "SELECT * FROM usuarios WHERE usuarios.email='".$email."'";

        $result = $db_tmp -> query($query);

        $num_emails = $result->num_rows;

        if ($num_emails != 0)
        {
            $code_bank[] = '4';   //Correo repetido.
        }

        //Segundo, se verifica que el correo solo contenga caracteres válidos
        //La variable EMAIL solo puede contener caracteres alfanuméricos en minúscula, punto, guión bajo y guión, sin espacios ni acentos
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
                     $code_bank[] = '16';     //Campo email contiene caracteres no válidos
                     break;
                 }
             }
         }


        //Validación de CONTRASEÑA ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        $long = strlen($password);  //Debe contener de 6 a 10 caracteres alfanuméricos, sin espacios ni acentos

        if ($long < 6)      // El campo debe contener al menos 6 caracteres
        {
            $code_bank[] = '15';     //Campo Contraseña con longitud menor a 6. Formato incorrecto
        }
        else
        {
            //Se verifica que contenga únicamente caracteres alfanuméricos, punto, guión bajo o guión, sin espacios ni acentos
            for ($i=0; $i < $long; $i++)
            {
                if (strpos($alphanumeric_xt, $password[$i]) === false)
                {
                    $code_bank[] = '15';     //Campo Contraseña contiene caracteres no válidos. Formato incorrecto
                    break;
                }
            }
        }

        //Validación de $tel1  ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        $long = strlen($tel1);  //Este campo es 'required', pero podría dejar pasar blancos

        //Se examina la longitud de la cadena telefónica
        if ($long < 10)
        {
            $code_bank[] = '5';     //Campo Teléfono 1 con longitud menor a 10. Formato incorrecto
        }
        else
        {
            //Luego se valida tel1 no contenga espacios en blanco
            for ($i=0; $i < $long; $i++)
            {
                if (strpos($numeric, $tel1[$i]) === false)
                {
                    $code_bank[] = '5';     //Campo Teléfono 1 contiene espacios. Formato incorrecto
                    break;
                }
            }
        }

        //Validación de $tel2   :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        $long = strlen($tel2);  //Esta longitud puede ser 0, ya que es opcional...

        if ($long > 0)      //...pero si se introduce algo en el campo, debe constar únicamente de 10 dígitos numéricos, sin espacios
        {
            if ($long < 10)
            {
                $code_bank[] = '6';     //Campo Teléfono 2 con longitud menor a 10. Formato incorrecto
            }
            else
            {
                //Si se introdujo algo en el campo tel2, debe ser únicamente numérico y sin espacios
                for ($i=0; $i < $long; $i++)
                {
                    if (strpos($numeric, $tel2[$i]) === false)
                    {
                        $code_bank[] = '6';     //Campo Teléfono 2 contiene espacios. Formato incorrecto
                        break;
                    }
                }
            }
        }

        $error_count = count($code_bank);

        if ($error_count == 0)
        {
            //echo "Usted ha introducido los datos correctamente";
            $completed1 = true;
            echo $name.'***'.$apat.'***'.$amat."<br>";
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
            echo $name.'***'.$apat.'***'.$amat."<br>";
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
else
{
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


    //Validación de CALLE  :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    if ($calle == 'none')
    {
        $code_bank[] = '7';          //No se seleccionó calle
    }

    //Validación de NÚMERO EXTERIOR  :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    $long = strlen($numext);

    if ($long >= 1)
    {
        //Se valida que contenga únicamente caracteres alfanuméricos y espacios
        for ($i=0; $i < $long; $i++)
        {
            if (strpos($numeric, $numext[$i]) === false)
            {
                $code_bank[] = '10';          //Número Exterior contiene caracteres no numéricos
                break;
            }
        }
    }
    else
    {
        //El número exterior solo contiene blancos
        $code_bank[] = '10';
    }

    //Validación de NÚMERO INTERIOR  :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    $long = strlen($numint);

    if ($long >= 1)
    {
        //Se valida que contenga únicamente caracteres alfanuméricos y espacios
        for ($i=0; $i < $long; $i++)
        {
            if (strpos($alphanumeric_na, $numint[$i]) === false)
            {
                $code_bank[] = '11';          //Si el Número interior contiene caracteres no alfanuméricos, se genera ERRROR 15
                break;
            }
        }
    }


    //Validación de la calle 1  :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    //      Primero se validan los caracteres alfabéticos
    $long = strlen($calle1);

    if ($long > 0)
    {
        for ($i=0; $i < $long; $i++)
        {
            if (strpos($alphanumeric, $calle1[$i]) === false)
            {
                $code_bank[] = '12';          //El nombre de calle 1 contiene caracteres no alfanuméricos
                break;
            }
        }
    }


    //Validación de calle 2  :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    $long = strlen($calle2);

    if ($long > 0)
    {
        for ($i=0; $i < $long; $i++)
        {
            if (strpos($alphanumeric, $calle2[$i]) === false)
            {
                $code_bank[] = '13';          //Nombre de calle 2 contiene caracteres no alfanuméricos
                break;
            }
        }
    }

    $long = strlen($referencia);

    if ($long > 0)
    {
        for ($i=0; $i < $long; $i++)
        {
            if (strpos($alphanumeric, $referencia[$i]) === false)
            {
                $code_bank[] = '14';          //Si LA REFERENCIA contiene caracteres no alfanuméricos
                break;
            }
        }
    }

    $error_count = count($code_bank);

    if ($error_count == 0)
    {
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
    else
    {
        //Volver al Formulario 2
        $completed1 = true;
        $completed2 = false;

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
        echo "Por favor, corrija sus datos para poder efectuar su registro. Gracias.";
        echo "</div>";

    }
}

if (!isset($completed1) || $completed1 == false)
{
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
  </div>
</body>
</html>

<?php

}
else if (!isset($completed2) || $completed2 == false)
{
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
            </div>
            </body>
            </html>

<?php
}
}
