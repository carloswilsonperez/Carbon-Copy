<?php

session_start();


if (!isset($_SESSION['valid_user']) )
{
    session_destroy();
    header ("location:derecha.php");
        
}
else
{
    //The user exists (maybe 'anonymous') and can add items to cart
    // get the product id
	
    if (isset($_POST['ean']) && isset($_POST['quantity']) )
    {
        $ean = $_POST['ean'];
        $empty_cart = false;
        $quantity = $_POST['quantity'];
        
        
        if(!isset($_SESSION['cart']) || !isset($_SESSION['articles']) )
        {
            //The 'cart' array is an array that saves 7 properties for each chosen item (ean, name, mark, presentation, content, price and quantity)
            // El array $_SESSION['articles'] almacena los códigos $ean de los artículos seleccionados, sin repetición.
                    
            $_SESSION['cart'] = array();

            //The array 'articles' saves the ean code for each of the items chosen by the customer in a like-set fashion
            //this array has no repeated members
            $_SESSION['articles'] = array();
        }

        if (in_array($ean, $_SESSION['articles']))
        {
            //...here, the item has been previously chosen by the customer
            for ($i = 0; $i < count($_SESSION['cart']); $i += 8)   //
            {
                if ($ean == $_SESSION['cart'][$i])
                { 
                    $_old = $_SESSION['cart'][$i + 7];
                    $_SESSION['cart'][$i + 7] += $quantity;  //
                    
                    if ($_SESSION['cart'][$i + 7] > $_SESSION['sub_inventory'][$ean])
                    {
                       $_SESSION['cart'][$i + 7] = $_SESSION['sub_inventory'][$ean];
                       $_SESSION['total_articles'] += ($_SESSION['sub_inventory'][$ean] - $_old);
                    }
                    else
                    {
                        $_SESSION['total_articles'] += $quantity;
                    }  
                }
            }
        }
        else
        {
            //Stores items properties, and quantity for the chosen item, all in the array $_SESSION['cart']
            //Here I search through $_SESSION['row_array'] and extract the relevant subset for the chosen items

            for ($i = 0; $i < count($_SESSION['row_array']); $i += 7)  //
            {
                if ($ean == $_SESSION['row_array'][$i])
                {
                    for ($j = $i; $j <= $i + 6; $j++)    //
                    {
                        //Almacenar en 'cart' las 6 características consecutivas, tomadas de 'row_array'...
                        array_push($_SESSION['cart'], $_SESSION['row_array'][$j]);
                    }
                            
                    //...y al final, agregar la cantidad colocada de dicho ítem
                    array_push($_SESSION['cart'], $quantity);  
                    $_SESSION['total_articles'] += $quantity;
                 }   
            }          
            array_push($_SESSION['articles'], $ean);
        }
        
        //A continuación, se calculan el ingreso total y la utilidad total de los ítems en carrito.
        $total_money = 0;
        $total_utility = 0;
        
        for ($i = 0; $i < count($_SESSION['cart']); $i += 8)
        {
           $total_money += $_SESSION['cart'][$i + 5] * $_SESSION['cart'][$i + 7];   
           $total_utility += ($_SESSION['cart'][$i + 5] - $_SESSION['cart'][$i + 6]) * $_SESSION['cart'][$i + 7];
        }
        
        $_SESSION['total_money'] = $total_money;
        $_SESSION['total_utility'] = $total_utility;

    }
}

    ?>


    <!DOCTYPE html>
    <html lang="es">
        
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <link href="ccpystyles.css" rel="stylesheet" type="text/css">
            
            <style>
        
        body
        {
           background-image:url('botones/grids.gif');
        }
    </style>
            <script>

                function update_cart()
                {
                    var content = "<table><tr><td rowspan = '2' width='80'><a href='viewcart.php' target='presen'><img src='botones/carrito1.png' width='40' height='40' /></a></td><td width='80'><?php echo $_SESSION['total_articles']; ?> </td><td rowspan='2' width='80'><?php echo sprintf ("\$%.2f", $_SESSION['total_money']); ?></td></tr><tr><td>  artículo(s)</td></tr></table>";
                    var div = top.frames['maquina'].document.getElementById('carrito');
                    
                    div.innerHTML = content;
                }

            </script>
        </head>

        <body>
            <script> 
                update_cart();                
            </script>
        </body>
    </html>
    


