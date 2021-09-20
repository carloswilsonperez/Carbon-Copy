<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

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
    '20' => 'ERROR: El asunto contiene caracteres no válidos',
    '21' => 'ERROR: usuario y contraeña repetidos en la base de Usuarios');


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


function validate_part_1($name, $apat, $amat, $email, $password, $tel1, $tel2) {
        
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
        
        return count($code_bank);
        
    }
    
    function validate_part_2($codpost, $calle, $numext, $numint, $calle1, $calle2) {
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
    
    return count($code_bank);

    }
            
?>
