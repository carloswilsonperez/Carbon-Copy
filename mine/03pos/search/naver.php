<html>
<head lang="es">
    <META http-equiv=Content-Type content="text/html; charset=ISO-8859-1" />
<style>

table {background-color: green;
       color: white;
       font-family: verdana, arial;
       font-size: 12pt;
       }

.cuadro {position:absolute;
         left: 50px;
         top: 65px;
         background-color: white;
         border-color: black;
         border-style: double;
         border-width:5x;
         }
         
.cuadrobusqueda {position:absolute;
         left: 150px;
         top: 30px;
         background-color: white;
         border-color: black;
         border-style: double;
         border-width:5x;
         }
         
.coloca {position:absolute;
         left: 620px;
         top: 350px;
         font-size: 25pt;
        
         }
         
 .logo   {position:absolute;
         left: 850px;
         top: 0px;
         font-size: 25pt;
                 
         }      
         
  INPUT   {
         font-size: 15pt;
                 
         }          
         
</style>
 
<script language="javascript" type="text/javascript">


function envia()
{
    var content = document.buscafield.cadena.value;
    if (content != "") 
    {
       document.forms['buscafield'].submit();
       document.buscafield.cadena.value = "";
     }
    

}

function enfoca() 
{
    document.buscafield.cadena.focus();
}
   

</script>

</head>

<body leftmargin="0" topmargin="0" bgcolor="white" onload="enfoca()">

<div class="cuadrobusqueda">
<table border="0">
    <tr>
    <td align="center" colspan="2">
        Introduzca código EAN:
    </td>
    </tr>
    
    <tr>
    <td align="center" colspan="2">
        <form action="procesa.php" method="POST" name="buscafield" target="presen">
            Nombre<input type="radio" name="tipobusqueda" value="nombreprod" />
            EAN<input type="radio" name="tipobusqueda" value="eancode" checked />
            <input type="text" size="20" name="cadena" align="middle" maxlength="20" onchange="javascript:envia()"/>
        </form>
        
    </td>
    <td align="center" style="background-color: white">
        <a href="#" onClick="javascript:envia()"><img src="botones/search1.png" width="50" height="50" /></a>
    </td>
    </tr>
    
</table>
</div>

<div id="logo" class="logo">
<img src="botones/logo.png" width="260" height="140" />
</div>

</body>
</html>