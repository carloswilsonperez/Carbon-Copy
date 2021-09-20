<?php

session_start();

$today = getdate();

if (!isset($_SESSION['valid_user']))
{
    $_SESSION['valid_user'] = "anonymous";
    $_SESSION['server'] = 'localhost';
    $_SESSION['user_id'] = 'anonymous';
    $_SESSION['user_pass'] = 'anonymous';
    $_SESSION['dbase'] = 'carboncopy';
}

if (!isset($_SESSION['total_articles']))
{
    $_SESSION['total_articles'] = 0;
    $_SESSION['total_money'] = 0;
    $_SESSION['total_utility'] = 0;
}

$message = "";
        
if (isset($_SESSION['valid_user']) && $_SESSION['valid_user'] != 'anonymous')
{
    $message = "Bienvenid@ <span>".$_SESSION['valid_user']."</span>";
}
else
{
    $message = "Bienvenid@ a nuestra tienda virtual";
}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="ccpystyles.css" rel="stylesheet" type="text/css">
        <script>
            function update_cart()
            {
                var content = "<table><tr><td rowspan = '2' width='80'><a href='viewcart.php' target='presen'><img src='botones/carrito1.png' width='40' height='40' /></a></td><td width='80'><?php echo $_SESSION['total_articles']; ?> </td><td rowspan='2' width='80'><?php echo sprintf ("\$%.2f", $_SESSION['total_money']); ?></td></tr><tr><td>  art&iacute;culo(s)</td></tr></table>";
                var div = top.frames['maquina'].document.getElementById('carrito');
                    
                div.innerHTML = content;
            }
            
            function update_username(message)
            {
               var div = top.frames['maquina'].document.getElementById('username');
                    
               if (message == 'Bienvenid@ a nuestra tienda virtual')
               {
                   div.innerHTML = message;
               }
               else
               {
                   div.innerHTML = message + "<a href='endUserSession.php' target='presen'>&nbsp;(Salir)</a>";
               }                  
            }
        </script>

    </head>

    <body onload="update_cart();update_username('<?php echo $message ?>');">
        
        
    <?php
            //unset($_SESSION['row_array']);
            print_r($_SESSION['row_array']);
    ?>
    </body>
</html>