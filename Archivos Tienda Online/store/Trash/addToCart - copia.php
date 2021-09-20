<?php

session_start();


if (!isset($_SESSION['valid_user']) )
{
    session_destroy();
    header ("location:index.php");
        
}
else
{  //The user exists and is registered to buy
    
        
	// get the product id
	
	if(isset($_POST['fin']))
	{
	    session_destroy();
        header ("location:index.php");
    }
    
    if(isset($_POST['pagar']))
    {
        // Falta definir completamente esta acciÃ³n
        session_destroy();
        header ("location:index.php");
    }

    if(isset($_POST['ean']))
    {
        $ean = $_POST['ean'];
        $empty_cart = false;
        
                
        if (isset($_POST['sysoperation']))
        {
            $sysoperation = $_POST['sysoperation'];

            if ($sysoperation == 'add')
            {
                for ($i = 0; $i < count($_SESSION['cart']); $i += 7)
                    {
                        if ($ean == $_SESSION['cart'][$i])
                        {
                            $_SESSION['cart'][$i + 6]++;
                            $_SESSION['total_articles']++;
                        }
                        
                    }
            }
            else if ($sysoperation == 'sub')
            {
                $conta = 0;    
                for ($i = 0; $i < count($_SESSION['cart']); $i += 7)
                    {
                        if ($ean == $_SESSION['cart'][$i])
                        {
                            $conta = $i + 6;
                            $_SESSION['cart'][$conta]--;
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
                //Se eliminan las propiedades del artículo cuyo código es $ean del array $_SESSION['cart']
                
                $tmp_array = array();
                $tmp_array2 = array();
                
                $conta = 0;
                //$to_del = 0;
                for ($i = 0; $i < count($_SESSION['cart']); $i += 7)
                    {
                        if ($ean == $_SESSION['cart'][$i])
                        {
                            $conta = $i;
                            $_SESSION['total_articles'] -= $_SESSION['cart'][$i + 6]; 
                            continue;
                        }
                        else 
                        {
                           array_push($tmp_array, $_SESSION['cart'][$i]); 
                           array_push($tmp_array, $_SESSION['cart'][$i + 1]);
                           array_push($tmp_array, $_SESSION['cart'][$i + 2]);
                           array_push($tmp_array, $_SESSION['cart'][$i + 3]);
                           array_push($tmp_array, $_SESSION['cart'][$i + 4]);
                           array_push($tmp_array, $_SESSION['cart'][$i + 5]);
                           array_push($tmp_array, $_SESSION['cart'][$i + 6]);
                           array_push($tmp_array2, $_SESSION['cart'][$i]); 
                        }
                    }
                $_SESSION['articles'] = array();
                $_SESSION['articles'] = $tmp_array2;
                
                $_SESSION['cart'] = array();
                $_SESSION['cart'] = $tmp_array;

                if (count($_SESSION['cart']) == 0)
                    {
                        $empty_cart = true;
                    }
            }
        }

        else
        {
            if (isset($_POST['quantity']))
            {
                $quantity = $_POST['quantity'];

                if(!isset($_SESSION['cart']) || !isset($_SESSION['articles']) )
                {
                    //The 'cart' array is an array that saves 7 properties dor each chosen item (ean, name, mark, presentation, content, price and quantity)
                    // El array $_SESSION['articles'] almacena los códigos $ean de los artículos seleccionados, sin repetición.
                    
                    $_SESSION['cart'] = array();

                    //The array 'articles' saves the ean code for each of the items chosen by the customer in a like-set fashion
                    //this array has no repeated members
                    $_SESSION['articles'] = array();
                }

                if (in_array($ean, $_SESSION['articles']))
                {
                    //Here the item has been previously chosen by the customer
                    for ($i = 0; $i < count($_SESSION['cart']); $i += 7)
                    {
                        if ($ean == $_SESSION['cart'][$i])
                        {
                            $_SESSION['cart'][$i + 6] += $quantity;
                            $_SESSION['total_articles'] += $quantity;
                            
                        }
                        
                    }
                }
                else
                {
                    //Stores items properties, and quantity for the chosen item, all in the array $_SESSION['cart']
                    for ($i = 0; $i < count($_SESSION['row_array']); $i += 6)
                    {
                        if ($ean == $_SESSION['row_array'][$i])
                        {
                            for ($j = $i; $j <= $i + 5; $j++)
                            {
                                array_push($_SESSION['cart'], $_SESSION['row_array'][$j]);
                            } 
                            array_push($_SESSION['cart'], $quantity);  
                            $_SESSION['total_articles'] += $quantity;
                            
                        }   
                    }
                    
                    array_push($_SESSION['articles'], $ean);
                    
                }
            }
            else
            {
                //$sysoperation y $quantity no están definidas.
                // No se llegó a la página siguiendo una ruta válida

                header ("location:index.php");
            }
        }
    }

    else
    {   //$ean no está definida.
        // No se llegó a la pÃ¡gina siguiendo una ruta válida

        header ("location:index.php");
    }

    ?>

    <html>
        
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <script>
    
        function reload_maquina()
        {
            top.maquina.location.reload();
            
        }
        
        function modify_cart(ean, operation)
        {
            document.forms['delform'].ean.value = ean;
            document.forms['delform'].sysoperation.value = operation;
            top.maquina.location.reload();
            document.forms['delform'].submit();
        }


    </script>
    </head>
    <body>
     <script> reload_maquina(); </script>
    <?php
    if ($empty_cart)
    {
        echo "Su carrito está vacío!!"."<br />";
    }
    else
    {
        //Dibujar carrito de compras
        echo "Su carrito contiene lo siguiente:"."<br />";
        ?>
        <table border="1" bgcolor="navy" style="color:white;" >
            <tr><th>Artículos</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th><th>Subtotal</th> <th>Subtotal</th> <th>Subtotal</th></tr>

            <?php
        
            for ($i = 0; $i < count($_SESSION['cart']); $i += 7)
            {
                echo "<tr>";
                echo "<td>".$_SESSION['cart'][$i + 1]." ".$_SESSION['cart'][$i + 2]." ".$_SESSION['cart'][$i + 3]." ".$_SESSION['cart'][$i + 4]."</td><td>".$_SESSION['cart'][$i + 6]."</td><td>".$_SESSION['cart'][$i + 5]."</td><td>".$_SESSION['cart'][$i + 5]*$_SESSION['cart'][$i + 6]."</td>";
                echo "<td><input type='button' value='Eliminar 1 Ítem' onclick=\"modify_cart('".$_SESSION['cart'][$i]."', 'sub')\"></td>";
                echo "<td><input type='button' value='Añadir 1 Ítem' onclick=\"modify_cart('".$_SESSION['cart'][$i]."', 'add')\"></td>";
                echo "<td><input type='button' value='Eliminar Fila' onclick=\"modify_cart('".$_SESSION['cart'][$i]."', 'del')\"></td>";
                echo "</tr>";
            }
            ?>
       
        </table>
        <form id='delform' name='delform' action='addToCart.php' method='post'>
            <input type='hidden' name='ean' id='ean' />
            <input type='hidden' name='sysoperation' id='sysoperation' />
        </form>
    </body>
    </html>

    <?php
    
    }

    print_r($_SESSION['cart']);
    echo "<br />";
    print_r($_SESSION['articles']);
    echo "<br />";
    echo $_SESSION['total_articles'];
    
    ?>

    <form action='catalogo2.php' target='presen' method='get'>
        <input type='submit' id='return' name='return' value='Seguir Comprando'>
        <input type='hidden' name='subcat' id='subcat' value='<?php echo $_SESSION['idcat']; ?>'>
        <input type='hidden' name='pagina'id='pagina' value='<?php echo $_SESSION['actual_page']; ?>'>
    </form>
    <form action='addToCart.php' method='post'>
      
        <input type="submit" id="pagar" name="pagar" value="Colocar Pedido" />
    </form>
    </body>
    </html>
    <?php
    
}


