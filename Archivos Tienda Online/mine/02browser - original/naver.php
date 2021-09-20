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
         
.cuadroindice 
			{position:absolute;
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


<?php

// aqu� nos conectaremos a la tabla art�culos y guardaremos el tama�o de la misma;
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
    // debemos consultar el tama�o de la tabla y colocarlo aqu�
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
   

</script>

</head>

<body leftmargin="0" topmargin="0" bgcolor="white" onload="carga_indice()">

<div class="cuadroindice">
<table border="0">
    <tr>
    <td align="center" colspan="5">
        Introduzca c�digo EAN:
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
            
            <input type="text" size="12" name="indice" align="middle" maxlength="12" onchange=""/>
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

</div>




<div id="logo" class="logo">
<img src="botones/logo.png" width="260" height="140" />
</div>

</body>
</html>