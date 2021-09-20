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
         
input   {
         font-size: 15pt;
                 
         }          
         
</style>
 
<script language="javascript" type="text/javascript">

function enfoca() 
    {
    document.buscafield.cadena.focus();
    }

function limpia_cadena() 
    {
        top.naver.document.forms['buscafield'].cadena.focus();
        top.naver.document.forms['buscafield'].cadena.value = "";
    }
  
function envia()
    {
    var content = document.forms['buscafield'].cadena.value;
    if (content != "") 
        {
        top.naver.document.forms['buscafield'].submit();
        this.document.forms['buscafield'].cadena.value = "";
        }   
    
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
        <form action="procesa.php" method="post" name="buscafield" id="buscafield" target="presen">
            Nombre<input type="radio" name="tipobusqueda" value="nombreprod" />
            EAN<input type="radio" name="tipobusqueda" value="eancode" checked />
            <input type="text" size="20" name="cadena" id="cadena" align="middle" maxlength="20" onchange="envia()" />
        </form>
        
    </td>
    <td align="center" style="background-color: white">
        <a href="#" onClick="javascript:envia()"><img src="botones/search1.png" width="50" height="50" /></a>
    </td>
    </tr>
    
</table>
</div>


</body>
</html>