<?php

session_start();

require_once ('check_valid_user.php');
require_once ('check_total_articles.php');
require_once('greeting.php');

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
    <body>
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
   <div id='mostrador'>
    
    </div>
            
            <?php
            
            if (!isset($_SESSION['valid_user']) || $_SESSION['valid_user'] == 'anonymous')
            {
                //El usuario no se ha logeado a la página.
                //Mostrar aviso de que el usuario debe registrarse
                //enviar a la pantalla de login
                ?>
                <div id='must_be_activated'>
                    <table>
                        <tr><td>Estimado Cliente: Debe acceder al sitio para poder colocar su pedido.</td></tr>
                    </table>
                    <br><br>
                </div>
                <div class='container'>
                    <div class="login">
                        <h1>Introduzca sus datos de acceso</h1>
                        <form method="post" action="login.php">
                            <p><input type="email" name="email" value="" placeholder="Username or Email" required></p>
                            <p><input type="password" name="password" value="" placeholder="Password" required></p>
                            <p class="remember_me">
                            <label>
                            <input type="checkbox" name="remember_me" id="remember_me" checked>
                                Recordarme en esta computadora
                            </label>
                            </p>
                            <p class="submit"><input type="submit" name="commit" value="Entrar"></p>
                        </form>
                   </div>
                </div>
                <?php
                
                exit;

            }
            else
            {
                if (isset($_POST['finish']))
                {
                    //Recuperar el horario de entrega del pedido, indicado por el cliente, o en su defecto,...
                    //...el horario predeterminado.
                    if (isset($_POST['horario']))
                    {
                        $horario = $_POST['horario'];
                    }
                    else
                    {
                        $horario = "Inmediato";
                    }
                        
                    //Conectar a la bdd usando las variables de sesión con los datos de conexión.
                    $db = new mysqli($_SESSION['server'], $_SESSION['user_id'],  $_SESSION['user_pass'],  $_SESSION['dbase']);
                    echo "Host: ".$_SESSION['server']." Usuario: ".$_SESSION['user_id']." Password: ".$_SESSION['user_pass']." Base de datos: ".$_SESSION['dbase']."<br>";
                                                         
                    //Se escribirán los datos siguientes en las tablas indicadas, en el orden señalado:
                    //1.Tabla: USUARIOS. Campos: histamount, num_colocs, fechalastbuy
                    //2.Tabla: MYBUYS. Campos: idbuy, idusuario, historial
                    //3.Tabla: ORDERS. Campos: idorder, idusuario, orderdate, num_items, montototal, utilidadtotal, status, observaciones
                    //4.Tabla: HISTORIAL. Campos: idorder, eancode, orderdate, cantidad, precio 
                    //5.Tabla: INVENTARIO. Campos: eancode, existencias, popularity 
                                        
                    //* Escribir los valores para idusuario, orderdate, num_items, montototal, utilidadtotal, status y observaciones, en la Tabla ORDERS
                    $_idusuario = intval(substr( $_SESSION['user_id'], 4));
                    $_numitems = intval($_SESSION['total_articles']);
                    $_montototal = floatval($_SESSION['total_money']);
                    $_utilidadtotal = floatval($_SESSION['total_utility']);
                    $_status = 'A';   // status: A - En Proceso
                    $_observaciones = $horario;

                    //Se establece la hora de la transacción
                    $_itemdate = date("Y-m-d H:i:s", time());    
                    //$_itemdate = time();
                    //$query = "INSERT INTO orders (idusuario, orderdate, num_items, montototal, utilidadtotal, status, observaciones) VALUES ('".$_idusuario."', FROM_UNIXTIME('".$_itemdate."'), '".$_numitems."', '".$_montototal."', '".$_utilidadtotal."', '".$_status."', '".$_observaciones."')";
                        
                    //1. Se escriben los campos de la Tabla USUARIOS
                    //   Primero se recupera el valor float almacenado en el campo histamount,
                    //   así como el valor del entero almacenado en el campo num_colocs.
                    //   Luego, el valor histamount se aumenta en la cantidad $_montototal,
                    //   y el valor num_colocs se aumenta en uno.
                    //   Finalmente, ambos valores se actualizan en sus respectivos campos.
                    
                    $query = "SELECT * FROM usuarios WHERE usuarios.idusuario = '".$_idusuario."'";
                    $result1 = $db -> query($query);
                    
                    $_results_user = $result1 -> num_rows;
                    
                    if ($_results_user == 1)  //Debe haber uno, y sólo un resultado.
                    {
                        $row = $result1 -> fetch_assoc();
                    
                        $_histamount = floatval($row['histamount']);
                        $_num_colocs = intval($row['num_colocs']);                    
                        
                        $_histamount = $_histamount + $_montototal;
                        $_num_colocs = $_num_colocs + 1;
                        
                        $query1 = "UPDATE usuarios SET histamount='".$_histamount."' WHERE idusuario='".$_idusuario."'";
                        $query2 = "UPDATE usuarios SET num_colocs='".$_num_colocs."' WHERE idusuario='".$_idusuario."'";
                        $query3 = "UPDATE usuarios SET fechalastbuy='".$_itemdate."' WHERE idusuario='".$_idusuario."'";
                        $result = $db->query($query1);      
                        $result = $db->query($query2); 
                        $result = $db->query($query3);
                    }
                    else
                    {
                        echo "OPERATION NOT VALID: REDUNDANT USER IN TABLE USUARIOS";
                        exit;
                    }
                    
                    //2. Se escriben los campos de la Tabla MYBUYS
                    //   Primero se recupera el historial de compras,
                    //   Luego, este historial se actualiza en caso de compras nuevas,
                    //   Finalmente, el nuevo historial se actualiza en el campo historial.
                                                                                 
                    $query = "SELECT * FROM mybuys WHERE idusuario = '".$_idusuario."'";
                    $result4 = $db->query($query);
                    
                    $_results_user = $result4->num_rows;
                    
                    $_ean_arrays = array();
                    
                    if ($_results_user == 0)  //El usuario no ha hecho ninguna compra antes.
                    {
                        for ($i = 0; $i < count($_SESSION['cart']); $i += 8)
                        {
                            $_eancode = $_SESSION['cart'][$i];
                            array_push($_ean_arrays, $_eancode);
                        }
                        
                        $_joint_eans = addslashes(implode("+", $_ean_arrays));
                        echo $_joint_eans;
                        $query = "INSERT INTO mybuys (idusuario, historial) VALUES ('".$_idusuario."', '".$_joint_eans."')";
                        $result5 = $db->query($query);
                    }
                    else if ($_results_user == 1)  //El usuario ya ha hecho al menos una compra antes.
                    {
                        $row = $result4->fetch_assoc();
                    
                        $_historial = stripslashes($row['historial']);
                        
                        $_ean_arrays = explode("+", $_historial);
                        
                        $long = count($_ean_arrays);
                        
                        for ($i = 0; $i < count($_SESSION['cart']); $i += 8)
                        {
                            $_eancode = $_SESSION['cart'][$i];
                             
                            if (!in_array($_eancode, $_ean_arrays))
                            {
                                //Si $_eancode no está en el array, se agregará a este.
                                array_push($_ean_arrays, $_eancode);     
                            }                    
                        }
                        
                        $_historial = implode("+", $_ean_arrays);
                           
                        $query = "UPDATE mybuys SET mybuys.historial='".$_historial."' WHERE idusuario='".$_idusuario."'";
                        $result6 = $db->query($query);
                    }
                    else
                    {
                        echo "OPERATION NOT VALID: REDUNDAND USER IN TABLE MYBUYS";
                        exit;
                    }
                    
                    //3. Tabla ORDERS.
                    //Campos: idorder, idusuario, orderdate, num_items, montototal, utilidadtotal, status
                                            
                    $query = "INSERT INTO orders (idusuario, orderdate, num_items, montototal, utilidadtotal, status, observaciones) VALUES ('".$_idusuario."', '".$_itemdate."', '". $_numitems."', '".$_montototal."', '".$_utilidadtotal."', '".$_status."', '".$_observaciones."')";
                       
                    $result7 = $db->query($query);
                    
                    //4.Tabla: HISTORIAL. Campos: idorder, eancode, orderdate, cantidad, precio 
                    //  Primero, se debe recuperar el valor del campo 'idorder' de la Tabla ORDERS, que corresponde a la operación actual
                    
                    $query = "SELECT LAST_INSERT_ID()";
                    $result8 = $db->query($query);

                    $row = $result8->fetch_row();
                    $_SESSION['idorder'] = intval($row[0]);
                    
                    $_idorder = intval($row[0]);  //Valor del campo idorder
                    
                    echo "Su número de orden es:".$_idorder;


                    //  Segundo, para el usuario y operación actual, escribir los valores para 'idorder', 'eancode', 'itemdate', 'cantidad' y 'precio', de cada ítem elegido.
                    for ($i = 0; $i < count($_SESSION['cart']); $i += 8)
                    {
                        $_eancode = $_SESSION['cart'][$i];
                        $_cantidad = intval($_SESSION['cart'][$i + 7]);
                        $_precio = floatval($_SESSION['cart'][$i + 5]);

                        $query = "INSERT INTO historial (idorder, eancode, orderdate, cantidad, precio) VALUES ('".$_idorder."', '".$_eancode."', '".$_itemdate."', '".$_cantidad."', '".$_precio."')";
                        $result9 = $db->query($query);
                    }

                    //5.Tabla: INVENTARIO. Campos: eancode, existencias, popularity 
                    //  Primero, se debe actualizar el valor del campo 'existencias' de la Tabla INVENTARIO, para cada uno de los artículos del carrito
                    //  Segundo, se debe actualizar el valor del campo 'popularity'
                    //  Por cada operación, el decremento en existencias debe ser igual al incremento en popularity.
                    
                    for ($i = 0; $i < count($_SESSION['cart']); $i += 8)
                    {
                        $_eancode = $_SESSION['cart'][$i];
                        $_num_items = intval($_SESSION['cart'][$i + 7]);
                        
                        $query = "SELECT * FROM inventario WHERE inventario.eancode = '".$_eancode."'";
                        $result = $db -> query($query);
                    
                        $_results_ean = $result -> num_rows;
                    
                        if ($_results_ean == 1)  //Debe haber uno, y sólo un resultado.
                        {
                            $row = $result -> fetch_assoc();
                    
                            $_existencias = intval($row['existencias']);
                            $_popularity = intval($row['popularity']);
                           
                            $_existencias = $_existencias - $_num_items ;
                            $_popularity = $_popularity + $_num_items;
                        
                            $query1 = "UPDATE inventario SET existencias='".$_existencias."' WHERE eancode='".$_eancode."'";
                            $query2 = "UPDATE inventario SET popularity='".$_popularity."' WHERE eancode='".$_eancode."'";
                        
                            $result = $db->query($query1);      
                            $result = $db->query($query2); 
                        }
                        else if ($_results_ean > 1)
                        {
                            echo "OPERATION NOT VALID: REDUNDANT USER IN TABLE USUARIOS";
                            exit;
                        }
                        else 
                        {
                            echo "ERROR: ITEM NOT FOUND IN INVENTORY TABLE!";
                            exit;
                        }
                    }

                    echo "FELICIDADEEEEEEEES";
                    echo "<br>";
                    echo "Su Pedido es el Número ".$_idorder;
                    //Presentar pantalla con el ID de pedido, el carrito de compras y mensaje de agradecimiento
                    //Dibujar carrito de compras

                ?>
                <div class='no_emptycart2'>
                    Su carrito contiene lo siguiente:
                    <table border="1" bgcolor="navy" id='cart_table'>
                        <thead>
                        <th>#</th><th>Art�culos</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th>
                        </thead>
                        <tbody>
                        <?php
                        
                        $total_money = 0;
                        $total_utility = 0;
                        $id = 1;
                        for ($i = 0; $i < count($_SESSION['cart']); $i += 8)
                        {
                            $total_money += $_SESSION['cart'][$i + 5]*$_SESSION['cart'][$i + 7];
                            $total_utility += ($_SESSION['cart'][$i + 5] - $_SESSION['cart'][$i + 6]) * $_SESSION['cart'][$i + 7];
                            echo "<tr>";
                            echo "<td>".$id."</td>";
                            echo "<td>".$_SESSION['cart'][$i + 1]." ".$_SESSION['cart'][$i + 2]." ".$_SESSION['cart'][$i + 3]." ".$_SESSION['cart'][$i + 4]."</td><td>".$_SESSION['cart'][$i + 7]."</td><td>".$_SESSION['cart'][$i + 5]."</td><td>".$_SESSION['cart'][$i + 5]*$_SESSION['cart'][$i + 7]."</td>";
                            echo "</tr>";
                            $id++;
                        }
                       
                        
                        ?>
                        
                        </tbody>
                    </table>
                </div>
                
                <?php
                //Enviar correo al usuario con los datos de la compra
                
                $to = $email;
                $total_money = 0;
                $total_utility = 0;
                $id = 1;            //Contador de renglones del carrito.

                $subject = 'Ticket de Compra - CarbonCopy.Mx';

                $headers = "From: pedidos@carboncopy.mx". "\r\n";
                $headers .= "Reply-To: ". "\r\n";
                $headers .= "CC: atencion@carboncopy.mx\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                $message = '<html><body>';

                $message .= '<img src="http://www.carboncopy.mx/botones/welcome.png" alt="Website Change Request" />';
                $message .= '<br><br>';
                $message .= 'Gracias por comprar en Carbon Copy';
                $message .= "<br>";
                
                for ($i = 0; $i < count($_SESSION['cart']); $i += 8)
                {
                    $total_money += $_SESSION['cart'][$i + 5]*$_SESSION['cart'][$i + 7];   //precio*cantidad
                    $total_utility += ($_SESSION['cart'][$i + 5] - $_SESSION['cart'][$i + 6]) * $_SESSION['cart'][$i + 7];
                    $item_desc = $_SESSION['cart'][$i + 1]." ".$_SESSION['cart'][$i + 2]." ".$_SESSION['cart'][$i + 3]." ".$_SESSION['cart'][$i + 4];
                    $_item_cantidad = $_SESSION['cart'][$i + 7];
                    $_item_precio = $_SESSION['cart'][$i + 5];
                    $_item_subtotal = $_item_cantidad * $_item_precio;         
                             
                    $message .= "<tr>";
                    $message .= "<td>".$id."</td>";
                    $message .= "<td>".$_item_desc."</td>";
                    $message .= "<td><img src='botones/l.png' width='20' height='20' onclick=\"modify_cart('".$_SESSION['cart'][$i]."', 'sub')\"></td>";
                    $message .= "<td align='center'>";
                    $message .= sprintf ("%d", $_item_cantidad);
                    $message .= "</td>";
                    $message .= "<td><img src='botones/r.png' width='20' height='20' onclick=\"modify_cart('".$_SESSION['cart'][$i]."', 'add')\"></td>";
                    $message .= "<td>";
                    $message .= sprintf ("\$%'*8.2f", $_item_precio);
                    $message .= "</td><td>";
                    $message .= sprintf ("\$%'*8.2f", $_item_subtotal);
                    $message .= "</td>";
                            
                    $message .= "<td><input type='button' value='Eliminar Ítem' onclick=\"modify_cart('".$_SESSION['cart'][$i]."', 'del')\"></td>";
                    $message .= "</tr>";
                    $id++;
                }
                        
                $message .= "Su compra asciende a un total de $".$total_money;
                
                $message .= "</body></html>";

                //Se envia el correo a la cuenta del usuario
                mail($to, $subject, $message, $headers);

                //Vaciar el carrito de compras
                    
                //Terminar
                exit;
                }
                else
                {
                    //Mostrar pantalla de selección de horarios
                    ?>

                    <div id='checkout'>
                        
                        <form name='finalizar' id='finalizar' action='coloca_pedido.php' method='post'>
                            
                        <?php
                                
                        $today = getdate();
                                        
                        $local_hour = intval($today['hours']);
                        $local_minute = intval($today['minutes']);
                                       
                        if ($local_hour < 20)
                        {
                            echo "<p>Está a punto de colocar su pedido.";
                            echo "<p>Solo falta que nos indique el horario en que desea recibir sus artículos.";
                            echo "<br><br>";
                            echo "1) Seleccione el horario para recibir hoy sus productos.";
                                            
                            echo "<table>";
                                            
                            if ( $local_hour < 12 && $local_minute < 30)
                            {
                                echo "<tr><td>Durante la mañana:</td>";
                                echo "<td>";
                                                
                                if ( $local_hour == 7 && $local_minute < 30 )
                                {
                                    if ($local_hour == 7)
                                    {
                                        echo "<input type='radio' name='horario' value='08-09am' checked>08 - 09 horas<br>";
                                    }
                                    else 
                                    {
                                        echo "<input type='radio' name='horario' value='08-09am'>08 - 09 horas<br>";    
                                    }            
                                }
                                            
                                if ( $local_hour == 7 || ($local_hour == 8 && $local_minute < 30) )
                                {
                                    if ($local_hour == 8)
                                    {
                                        echo "<input type='radio' name='horario' value='09-10am' checked>09 - 10 horas<br>";
                                    }
                                    else
                                    {
                                        echo "<input type='radio' name='horario' value='09-10am'>09 - 10 horas<br>";
                                    }                                          
                                }
                                            
                                if ( $local_hour == 8 || ($local_hour == 9 && $local_minute < 30) )
                                {
                                    if ($local_hour == 9)
                                    {
                                        echo "<input type='radio' name='horario' value='10-11am' checked>10 - 11 horas<br>";
                                    }
                                    else 
                                    {
                                        echo "<input type='radio' name='horario' value='10-11am'>10 - 11 horas<br>";
                                    }
                                }
                                            
                                if ( $local_hour == 9 || ($local_hour == 10 && $local_minute < 30) )
                                {
                                    if ($local_hour == 10)
                                    {
                                        echo "<input type='radio' name='horario' value='11-12am' checked>11 - 12 horas<br>";
                                    }
                                    else
                                    {
                                        echo "<input type='radio' name='horario' value='11-12am'>11 - 12 horas<br>";
                                    }                
                                }
                                
                                echo "</td></tr>";
                            }
                                               
                            if ($local_hour >= 11 && $local_hour < 17 )
                            {
                                echo "<tr><td>Durante la tarde:</td>";
                                echo "<td>";  
                                
                                if ( $local_hour < 12 && $local_minute < 30 )
                                {
                                    if ($local_hour == 11)
                                    {
                                        echo "<input type='radio' name='horario' value='12-13pm' checked>12 - 13 horas<br>";
                                    }
                                    else 
                                    {
                                        echo "<input type='radio' name='horario' value='12-13pm'>12 - 13 horas<br>";
                                    }
                                }
                                            
                                if ( $local_hour == 11 || ($local_hour == 12 && $local_minute < 30) )
                                {
                                    if ($local_hour == 12)
                                    {
                                        echo "<input type='radio' name='horario' value='13-14pm' checked>13 - 14 horas<br>";
                                    }
                                    else 
                                    {
                                        echo "<input type='radio' name='horario' value='13-14pm'>13 - 14 horas<br>";
                                    }                                     
                                }
                                        
                                if ( $local_hour == 12 || ($local_hour == 13 && $local_minute < 30) )
                                {
                                    if ($local_hour == 13)
                                    {
                                        echo "<input type='radio' name='horario' value='14-15pm' checked>14 - 15 horas<br>";
                                    }
                                    else 
                                    {
                                        echo "<input type='radio' name='horario' value='14-15pm'>14 - 15 horas<br>";
                                    }
                                }
                                            
                                if ( $local_hour == 13 || ($local_hour == 14 && $local_minute < 30) )
                                {
                                    if ($local_hour == 14)
                                    {
                                        echo "<input type='radio' name='horario' value='15-16pm' checked>15 - 16 horas<br>";
                                    }
                                    else
                                    {
                                        echo "<input type='radio' name='horario' value='15-16pm'>15 - 16 horas<br>";
                                    }
                                }
                                                
                                if ( $local_hour == 14 || ($local_hour == 15 && $local_minute < 30) )
                                {
                                    if ($local_hour == 15)
                                    {
                                        echo "<input type='radio' name='horario' value='16-17pm' checked>16 - 17 horas<br>";
                                    }
                                    else 
                                    {
                                        echo "<input type='radio' name='horario' value='16-17pm'>16 - 17 horas<br>";
                                    }            
                                }
                                                
                                if ( $local_hour == 15 || ($local_hour == 16 && $local_minute < 30) )
                                {
                                    if ($local_hour == 16)
                                    {
                                        echo "<input type='radio' name='horario' value='17-18pm' checked>17 - 18 horas<br>";
                                    }
                                    else
                                    {
                                        echo "<input type='radio' name='horario' value='17-18pm'>17 - 18 horas<br>";
                                    }
                                }
                                        
                                echo "</td></tr>";
                            }
                                
                            //Horarios Nocturnos *************************************************************
                            if ( $local_hour >= 17 && $local_hour < 20 )
                            {
                                echo "<tr><td>Durante la noche:</td>";
                                echo "<td>";                             
                                
                                if ( $local_hour < 18 && $local_minute < 30 )
                                {
                                    if ($local_hour == 17)
                                    {
                                        echo "<input type='radio' name='horario' value='18-19pm' checked>18 - 19 horas<br>";
                                    }
                                    else
                                    {
                                        echo "<input type='radio' name='horario' value='18-19pm'>18 - 19 horas<br>";
                                    }
                                }
                                                
                                if ( $local_hour == 17 || ($local_hour == 18 && $local_minute < 30) )
                                {
                                    if ($local_hour == 18)
                                    {
                                        echo "<input type='radio' name='horario' value='19-20pm' checked>19 - 20 horas<br>";
                                    }
                                    else 
                                    {
                                        echo "<input type='radio' name='horario' value='19-20pm'>19 - 20 horas<br>";
                                    }                                           
                                }
                                                
                                if ( $local_hour == 18 || ($local_hour == 19 && $local_minute < 30) )
                                {
                                    if ($local_hour == 19)
                                    {
                                        echo "<input type='radio' name='horario' value='20-21pm' checked>20 - 21 horas<br>";
                                    }
                                    else 
                                    {
                                        echo "<input type='radio' name='horario' value='20-21pm'>20 - 21 horas<br>";
                                    }
                                }
                                
                            echo "</td></tr>";
                            }
                                            
                            echo "<br><br>";
                            echo "</table>";
                            echo "<p>2) Presione el siguiente botón:</p>";
                            echo "<a href='javascript:void(0);' onclick='envia_finalizar();'><img src='botones/finalizar.png' width='120' height='40' id='finish_buy'  /></a>";
                        echo "</div>";                    
                        }
                        else 
                        {
                            ?>
                            </div>
                            <div id='noservice'>
                                <table>
                                    <tr><td><img src="botones/logo.png" width="500" height="250" /></td></tr>
                                    <tr><td align='center'> Estimado Cliente: el día de hoy ya no hay servicio disponible.</td></tr>
                                    <tr><td align='center'>En Carbon Copy estaremos encantados de poder servirle mañana.</td></tr>
                                    <tr><td align='center'>Gracias...</td></tr>
                                    <tr><td align='center'><a href='index.php'><img src='botones/gotostore.png'></a></td></tr>
                                </table>
                            </div>
                            <?php
                        }
                                      
                        ?>
                            
                        <input type='hidden' name='finish' value='finish' />
                        </form>   
                            
                       
                        <?php
                        }

            }
            ?>

        
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

