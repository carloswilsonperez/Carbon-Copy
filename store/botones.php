<?php

session_start();



?>

<!DOCTYPE html>
<html lang="es">
    <head>


        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="ccpystyles.css" rel="stylesheet" type="text/css">

         
        <script language="javascript" type="text/javascript">
           
            function envia(categ)
            {
                document.forms['catalogo'].categoria.value = categ;
                document.forms['catalogo'].pagina.value = 1;
                document.forms['catalogo'].submit();
            }

        </script>


    </head>


    <body>
        <div class='fondo'>
            <div class='menu'>
    
                <table width='180'>
                    <tr>
                        <td>
                        <a href="javascript:envia('R')">Refrescos y Jugos</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <a href="javascript:envia('C')">Cocina Fácil</a>
                        </td>
                    </tr>
                   <tr>
                       <td>
                       <a href="javascript:envia('F')">Frutas y Verduras</a>
                       </td>
                   </tr>
                   <tr>
                       <td>
                       <a href="javascript:envia('B')">Botanas y Panes</a>
                       </td>
                   </tr>
                   <tr>
                       <td>
                       <a href="javascript:envia('A')">Abarrotes Básicos</a>
                       </td>
                   </tr>
                   <tr>
                       <td>
                       <a href="javascript:envia('L')">Lácteos y Helados</a>
                       </td>
                   </tr>
                   <tr>
                       <td>
                       <a href="javascript:envia('T')">Tortilla, Harina y Pastas</a>
                       </td>
                   </tr>
                   <tr>
                       <td>
                       <a href="javascript:envia('N')">Carnes</a>
                       </td>
                   </tr>
                   <tr>
                       <td>
                       <a href="javascript:envia('P')">Higiene Personal</a>
                       </td>
                   </tr>
                    <tr>
                       <td>
                       <a href="javascript:envia('H')">Higiene del Hogar</a>
                       </td>
                   </tr>
                   <tr>
                       <td>
                       <a href="javascript:envia('Y')">Bebés</a>
                       </td>
                   </tr>
                   <tr>
                       <td>
                       <a href="javascript:envia('M')">Mascotas</a>
                       </td>
                   </tr>
                   <tr>
                        <td>
                        <a href="javascript:envia('O')">Otros</a>
                        </td>
                   </tr>

            </table>
        </div>

        <div id='browrec'>
            <table>
                <tr><td>Carbon Copy recomienda:</td></tr>
                <tr><td><img src='botones/browsers.jpg' width='107' height='47'></td></tr>
            </table>
        </div>


        <form action="subcategs.php" id="catalogo"  name="catalogo" method="post" target="presen">
            <input type="hidden" id="categoria" name="categoria">
            <input type="hidden" id="pagina" name="pagina">
        </form>

    </div>

</body>
</html>