<html>
<head lang="es">
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
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
         border-width:5px;
         }
         
.cuadroindice 
			{position:absolute;
        	left: 150px;
         	top: 30px;
         	background-color: white;
         	border-color: black;
         	border-style: double;
         	border-width:5x;
         }

.cuadrobusqueda {position:absolute;
         left: 500px;
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
         left: 1080px;
         top: 0px;
                       
         }      
         
  INPUT   {
         font-size: 15pt;
                 
         }          
         
</style>


<?php

// aquï¿½ nos conectaremos a la tabla artï¿½culos y guardaremos el tamaï¿½o de la misma;
// usaremos una consulta SELECT * FROM articulos

    $db = new mysqli('localhost', 'root', 'nailita', 'carboncopy');
 
    if (mysqli_connect_errno()) 
    {
        echo 'Error: Could not connect to database. Please try again later.';
        exit;
    }
    
    $query_naver = "select * from productos";
    
    $result_naver = $db->query($query_naver);
    $num_results_naver = $result_naver->num_rows;
    
?> 
 
 
<script language="javascript" type="text/javascript">

function first_item() 
{
    var itemno = 1;
    document.buscafield.indice.value = itemno;
    document.buscafield.indice.focus();
    document.buscafield.submit();
}


function last_item() 
{
    // debemos consultar el tamaï¿½o de la tabla y colocarlo aquï¿½
    var itemno = <?php echo $num_results_naver; ?>;
    document.buscafield.indice.value = itemno;
    document.buscafield.submit();
}


function prev_item() 
{
    var itemno = document.buscafield.indice.value;
    itemno--;
    if (itemno < 1) {
        itemno = 1;
    }
    document.buscafield.indice.value = itemno;
    document.buscafield.submit();
}


function next_item() 
{
    var itemno = document.buscafield.indice.value;
    itemno++;
    if (itemno > <?php echo $num_results_naver ?>) 
    {
        itemno = <?php echo $num_results_naver ?>;
    }
    document.buscafield.indice.value = itemno;
    document.buscafield.submit();
}


function carga_indice() 
{
    document.buscafield.indice.focus();
    document.buscafield.indice.value = 1;
    document.buscafield.submit();
}
   
function envia()
{
    var content = document.buscanombre.cadena.value;
    if (content != "") 
    {
       document.forms['buscanombre'].submit();
       document.buscanombre.cadena.value = "";
     }
    

}

function enfoca() 
{
    document.buscanombre.cadena.focus();
}
</script>

</head>

<body leftmargin="0" topmargin="0" bgcolor="white" onload="carga_indice()">

<div class="cuadroindice">
<table border="0">
    <tr>
    <td align="center" colspan="5">
        Presione las flechas para navegar:
    </td>
    </tr>
    <tr>
    <td align="center" style="background-color: white">
        <a href="#" onClick="javascript:first_item()"><img src="botones/first.png" width="50" height="50" /></a>
    </td>
    <td align="center" style="background-color: white">
        <a href="#" onClick="javascript:prev_item()"><img src="botones/prev.png" width="50" height="50" /></a>
    </td>
    <td align="center" valign="middle">
        <form action="procesa.php" method="POST" name="buscafield" target="presen">
            
            <input type="text" size="5" name="indice" align="middle" maxlength="5" onchange=""/>
        </form>
        
    </td>
    <td align="center" style="background-color: white">
        <a href="#" onClick="javascript:next_item()"><img src="botones/next.png" width="50" height="50" /></a>
    </td>
    <td align="center" style="background-color: white">
        <a href="#" onClick="javascript:last_item()"><img src="botones/last.png" width="50" height="50" /></a>
    </td>
    </tr>
    
</table>
</div>


<div class="cuadrobusqueda">
<table border="0">
    <tr>
    <td align="center" colspan="2">
        Introduzca Búsqueda o código EAN: 
    </td>
    </tr>
    
    <tr>
    <td align="center" colspan="2">
        <form action="procesa2.php" method="POST" name="buscanombre" target="presen">
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