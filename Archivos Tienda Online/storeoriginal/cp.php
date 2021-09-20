<?php

session_start();

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="ccpystyles.css" rel="stylesheet" type="text/css">
        <script>
            function envia_finalizar()
            {
               //se obtiene la cantidad de art?culos a colocar
               document.forms['finalizar'].submit();
            }

        </script>
    </head>

    <body>
        <div class='fondo'>

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
                    </div>
                    <?php
                    exit;

                }
                else
                {

                        //Recuperar el horario de entrega indicado por el cliente
                        if (isset($_POST['horario']))
                        {
                            $horario = $_POST['horario'];
                        }
                        else
                        {
                            //En caso de no indicar un horario específico, se entregará a la brevedad
                            $horario = "El lapso siguiente al lapso que contiene la hora actual";
                        }

                        //Conectar a la bdd usando las variables de sesión con los datos de conexión
                        @$db = new mysqli($_SESSION['server'], $_SESSION['user_id'],  $_SESSION['user_pass'],  $_SESSION['dbase']);

                        if (mysqli_connect_errno()) {
                            echo "Error: Could not connect to database. Please try again later.";
                            exit;
                        }
                        // Escribir los valores para idusuario, orderdate, num_items, montototal, utilidadtotal, status y observaciones, en la Tabla ORDERS
                        $_idusuario = intval(substr( $_SESSION['user_id'], 4));
                        $_numitems = intval($_SESSION['total_articles']);
                        $_montototal = floatval($_SESSION['total_money']);
                        $_utilidadtotal = floatval($_SESSION['total_utility']);
                        $_status = 'A';   // status: A - En Proceso
                        $_observaciones = $horario;

                        $query = "INSERT INTO TABLE usuarios () VALUES ()";
                        
                        $_historial = '';
                        for ($i = 0; $i < count($_SESSION['cart']); $i += 8)
                        {
                            $_historial .= (string)$_SESSION['cart'][$i]."+";
                        }

                        if (!get_magic_quotes_gpc())
                        {
                            $_historial = addslashes($_historial);
                        }

                        echo $_idusuario." colocó todo esto: ".$_historial;

                        $query = "INSERT INTO mybuys set idusuario=".$_idusuario.", historial='".$_historial."'";
                        $result = $db->query($query);

                        if ($result)
                        {
                            echo  $db->affected_rows." product inserted into database.";
                        }
                        else
                        {
                            echo "An error has occurred: ";
                        }
                        

                        echo "FELICIDADEEEEEEEES";
                        //Presentar pantalla con el ID de pedido, el carrito de compras y mensaje de agradecimiento
                        //Enviar correo al usuario con los datos de la compra
                        //Vaciar el carrito de compras
                        //Terminar
                        exit;

                }
            ?>


        </div>
    </body>
</html>

