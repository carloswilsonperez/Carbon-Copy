<?php

session_start();



?>

<!DOCTYPE html>
<html lang="es">
    <head>


        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="ccpystyles.css" rel="stylesheet" type="text/css">

         
        <script language="javascript" type="text/javascript">


            var texto="Me da Mucho Gusto que me Visites!!      Mis mails: cwilson1974@hotmail.com     cwilson1974@yahoo.com.mx";
            var visualizacion="inicio";
            function mueve()
                {
                if (visualizacion=="inicio") {  for (var i=1; i<=140; i++)
                                                   { texto=" "+texto; }
                                                 visualizacion=texto;
                                              }
                visualizacion=visualizacion.substring(1,visualizacion.length);
                window.status=visualizacion;
                if (visualizacion=="") { visualizacion=texto; }
                setTimeout ("mueve()",60);
                }

            function tiempo()
            {
            var tiempo, hora, min, seg, horario;
            tiempo = new Date();
            hora = tiempo.getHours();  if (hora>12) {hora=hora - 12;
                                                     document.form2.boton2.value="PM"; }

                                           else     {document.form2.boton2.value="AM"; }
            if (hora<10) {hora="0" + hora; }
            min = tiempo.getMinutes(); if (min<10) {min="0" + min; }
            seg = tiempo.getSeconds(); if (seg<10) {seg="0" + seg; }
            horario=hora + ":" + min + ":" + seg;
            document.form1.boton.value=horario;
            setTimeout ("tiempo()",1000);
            }

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