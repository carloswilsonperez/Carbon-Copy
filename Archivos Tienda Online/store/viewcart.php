<?php

session_start();
require_once ('check_valid_user.php');
require_once ('check_total_articles.php');
require_once('greeting.php');

if (!isset($_SESSION['valid_user']) )
{
    session_destroy();
    header ("location:index.php");
        
}
else
{  //The user exists and is registered to buy
    
        
    // get the product id
	
    if (isset($_POST['fin']))
    {
	session_destroy();
        header ("location:index.php");
    }
    
    if(isset($_POST['pagar']))
    {
        // Falta definir completamente esta acción
        session_destroy();
        header ("location:index.php");
    }
    
    
    if (isset($_POST['sysoperation']))
        {
                
            $ean = $_POST['ean'];
                        
            $sysoperation = $_POST['sysoperation'];

            if ($sysoperation == 'add')
            {
                for ($i = 0; $i < count($_SESSION['cart']); $i += 8)
                {
                    if ($ean == $_SESSION['cart'][$i])
                    {
                        $_SESSION['cart'][$i + 7]++;
                        
                        if ($_SESSION['cart'][$i + 7] > $_SESSION['sub_inventory'][$ean])
                        {
                            $_SESSION['cart'][$i + 7] = $_SESSION['sub_inventory'][$ean];
                        }
                        else
                        {
                            $_SESSION['total_articles']++;
                        }  
                       
                    }
                }
            }
            else if ($sysoperation == 'sub')
            {
                $conta = 0;    
                for ($i = 0; $i < count($_SESSION['cart']); $i += 8)
                {
                    if ($ean == $_SESSION['cart'][$i])
                    {
                        $conta = $i + 7;
                        $_SESSION['cart'][$i + 7]--;
                        $_SESSION['total_articles']--;
                    }
                }

                if ($_SESSION['cart'][$conta] == 0)
                {
                    $sysoperation = 'del';
                }

            }

            if ($sysoperation == 'del')
            {
                //Se eliminan de $_SESSION['cart'] las propiedades del artículo cuyo código es $ean.
                
                $tmp_array = array();
                $tmp_array2 = array();
                
                $conta = 0;
                //
                for ($i = 0; $i < count($_SESSION['cart']); $i += 8)
                {
                    if ($ean == $_SESSION['cart'][$i])
                    {
                        $conta = $i;
                        $_SESSION['total_articles'] -= $_SESSION['cart'][$i + 7];
                        continue;
                    }
                    else 
                    {
                        //Se llena el array $tmp_array.
                        array_push($tmp_array, $_SESSION['cart'][$i]); 
                        array_push($tmp_array, $_SESSION['cart'][$i + 1]);
                        array_push($tmp_array, $_SESSION['cart'][$i + 2]);
                        array_push($tmp_array, $_SESSION['cart'][$i + 3]);
                        array_push($tmp_array, $_SESSION['cart'][$i + 4]);
                        array_push($tmp_array, $_SESSION['cart'][$i + 5]);
                        array_push($tmp_array, $_SESSION['cart'][$i + 6]);
                        array_push($tmp_array, $_SESSION['cart'][$i + 7]);
                        //Se llena el array $tmp_array2.
                        array_push($tmp_array2, $_SESSION['cart'][$i]); 
                    }
                }
                $_SESSION['articles'] = array();
                $_SESSION['articles'] = $tmp_array2;
                
                $_SESSION['cart'] = array();
                $_SESSION['cart'] = $tmp_array;

            }
        }
}
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

            if (!isset($_SESSION['articles']) || (count($_SESSION['articles']) == 0))   // Carrito de compras vacío.
            {
                //Se reinician a 0 las variables de sesión 'total_money' y 'total_utility'.
                $_SESSION['total_money'] = 0;
                $_SESSION['total_utility'] = 0;

                echo  "<div class='emptycart'>";
                    echo "<table>";
                    echo "<tr><td><img src='botones/carrito1.png' width='320' height='250'></td></tr>";
                    echo "<tr><td>Su carrito de compras está vacío.</td></tr>";
                    echo "<tr><td><a href='presen.php'><img src='botones/seguir.png' width='120' height='40'></a></td></tr>";
                    echo "</table>";
                echo "</div>";
                ?>
                <script>
                
                    var content = "<table><tr><td rowspan='2' width='80'><a href='viewcart.php' target='presen'><img src='botones/carrito1.png' width='40' height='40' /></a></td><td width='80'><?php echo $_SESSION['total_articles']; ?> </td><td rowspan='2' width='80'><?php echo sprintf ("\$%.2f", $_SESSION['total_money']); ?></td></tr><tr><td>  art&iacuteculo(s)</td></tr></table>";
                    var div = top.frames['maquina'].document.getElementById('carrito');
                    
                    div.innerHTML = content;
                   
                </script>
                <?php
            }
            else
            {
                //Dibujar carrito de compras

                ?>
                <div class='no_emptycart'>
                    Su carrito contiene lo siguiente:
                    <table id='cart_table'>
                        <thead>
                        <th>#</th><th>Artículos</th><th>-</th><th></th><th>+</th><th>Precio</th> <th>Subtotal</th> <th></th>
                        </thead>
                        <tbody>
                        
                        <?php
                        
                        $total_money = 0;
                        $total_utility = 0;
                        $id = 1;            //Contador de renglones del carrito.
                        
                        for ($i = 0; $i < count($_SESSION['cart']); $i += 8)
                        {
                            $total_money += $_SESSION['cart'][$i + 5]*$_SESSION['cart'][$i + 7];   //precio*cantidad
                            $total_utility += ($_SESSION['cart'][$i + 5] - $_SESSION['cart'][$i + 6]) * $_SESSION['cart'][$i + 7];
                            $_item_desc = $_SESSION['cart'][$i + 1]." ".$_SESSION['cart'][$i + 2]." ".$_SESSION['cart'][$i + 3]." ".$_SESSION['cart'][$i + 4];
                            $_item_cantidad = $_SESSION['cart'][$i + 7];
                            $_item_precio = $_SESSION['cart'][$i + 5];
                            $_item_subtotal = $_item_cantidad * $_item_precio;         
                             
                            echo "<tr>";
                            echo "<td>".$id."</td>";
                            echo "<td>".$_item_desc."</td>";
                            echo "<td><img src='botones/l.png' width='20' height='20' onclick=\"modify_cart('".$_SESSION['cart'][$i]."', 'sub')\"></td>";
                            echo "<td align='center'>";
                            echo sprintf ("%d", $_item_cantidad);
                            echo "</td>";
                            echo "<td><img src='botones/r.png' width='20' height='20' onclick=\"modify_cart('".$_SESSION['cart'][$i]."', 'add')\"></td>";
                            echo "<td>";
                            echo sprintf ("\$%'*8.2f", $_item_precio);
                            echo "</td><td>";
                            echo sprintf ("\$%'*8.2f", $_item_subtotal);
                            echo "</td>";
                            
                            
                            echo "<td><input type='button' value='Eliminar Ítem' onclick=\"modify_cart('".$_SESSION['cart'][$i]."', 'del')\"></td>";
                            echo "</tr>";
                            $id++;
                        }
                        
                        $_SESSION['total_money'] = $total_money;
                        $_SESSION['total_utility'] = $total_utility;

                        ?>
                        </tbody>
                    </table>
                   <script>
                        var content = "<table><tr><td rowspan='2' width='80'><a href='viewcart.php' target='presen'><img src='botones/carrito1.png' width='40' height='40' /></a></td><td width='80'><?php echo $_SESSION['total_articles']; ?> </td><td rowspan='2' width='80'><?php echo sprintf ("\$%.2f", $_SESSION['total_money']); ?></td></tr><tr><td>  art&iacuteculo(s)</td></tr></table>";
                        var div = document.getElementById('upper-right-box');
                    
                        div.innerHTML = content;
                   </script>
                   
                    <form id='delform' name='delform' action='viewcart.php' method='post'>
                        <input type='hidden' name='ean' id='ean' />
                        <input type='hidden' name='sysoperation' id='sysoperation' />
                    </form>

                    <form id='seguir' name='seguir' action='catalogo.php' method='get'>
                        <input type='hidden' name='subcat' id='subcat' value='<?php echo $_SESSION['idcat']; ?>'>
                        <input type='hidden' name='pagina'id='pagina' value='<?php echo $_SESSION['actual_page']; ?>'>
                    </form>

                    <table width='100%'>
                        <tr>&nbsp;</tr>
                        <tr><td><a href='#'><img src='botones/seguir.png' width='120' height='40' onclick='envia_seguir();' /></a></td>
                            <td width='500'>&nbsp;</td>
                            <td><a href='#'><img src='botones/colocar.png' width='120' height='40' onclick="location.href='coloca_pedido.php'"></a></td>
                        </tr>
                    </table>

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

<?php
  }

    
    


