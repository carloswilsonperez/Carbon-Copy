<?php
session_start();

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
<html>

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="ccpystyles.css" rel="stylesheet" type="text/css">

        <script>
                function show_v_home()
                {
                    document.getElementById('home').src = 'botones/home2.png';
                }

                function show_b_home()
                {
                    document.getElementById('home').src = 'botones/home.png';
                }
                
                function send_search()
                {
                    var word = top.maquina.document.forms['searcher'].search.value;
                    
                    if (word != "")
                    {
                        document.forms['sendsearch'].pagina.value = 1;
                        document.forms['sendsearch'].subcat.value = "turn_on_search";
                        document.forms['sendsearch'].search_term.value = word;
		        document.forms['sendsearch'].submit();
                    }               
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


    <body onload="update_username('<?php echo $message ?>');">
        <div class="toplogo">
            <table >
               <tr>
               <td ><img src="botones/logo.png" height="100" width="180"></td>
               </tr>
            </table>
        </div>


        <div class='topmenu'>
            <table>
                <tr>
                <td>
                    <a href='presen.php' target='presen'> <img src='botones/home.png' id='home' width='18' height='18' onmouseover='show_v_home();' onmouseout='show_b_home();'></a>
                </td>
                <td>
                    <a href='login.php' target='presen'>Ingresar</a>
                </td>
                <td>
                    <a href='register.php' target='presen'>Crear/ Ver Cuenta</a>
                </td>
                <td>
                    <a href='contacto.php' target='presen'>Contacto </a>
                </td>
                </tr>
            </table>
        </div>

        <form class="form-wrapper" name='searcher' id='searcher'>
            <input type="text" id="search" placeholder="Búsqueda rápida ..." required>
            <input type="submit" value="Buscar" id="submit" onClick="javascript:send_search();">
        </form>

        <div class='ayudatel'>
            <img src="botones/call5.jpg" width="196" height="30">
        </div>

        <div class='carrito' id='carrito'></div>
        
        
         <form action="catalogo.php" id="sendsearch"  name="sendsearch" method="get" target="presen">
                <input type="hidden" id="subcat" name="subcat">
                <input type="hidden" id="pagina" name="pagina">
                <input type='hidden' id='search_term' name='search_term'>
         </form>
        
        <div class='welcome' id='username'></div>

        
    </body>
</html>