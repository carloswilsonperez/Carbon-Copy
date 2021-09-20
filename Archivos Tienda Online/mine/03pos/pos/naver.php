<?php

if (!isset($_SESSION['delete_all']) || $_SESSION['delete_all'] == false )
{
   session_start();
   if (!isset($_SESSION['row_array']))
   {
       $_SESSION['row_array'] = array();	
   }
   
   
   if (!isset($_SESSION['row_array_tmp']))
   {
       $_SESSION['row_array_tmp'] = array();	
   }
   $_SESSION['delete_all'] = false;
}
else if ($_SESSION['delete_all'] == true)
{
   unset($_SESSION['row_array']);
   unset($_SESSION['delete_all']);
   session_destroy();
}

?>

<html>
<head lang="es">
    <META http-equiv='Content-Type' content="text/html; charset=ISO-8859-1" >
    <link href="posstyles.css" rel="stylesheet" type="text/css" />
 
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
           top.naver.document.forms['buscafield'].cadena.value = "";
	   top.naver.document.forms['buscafield'].cadena.focus();
        }
	else
	{
	   top.naver.document.forms['buscafield'].cadena.focus();	
	}   
    
    }



</script>

</head>

<body leftmargin="0" topmargin="0" bgcolor="white" onload="enfoca()">

<div class="cuadrobusqueda">
   <table>
    <tr>
        <td align="center" colspan="2">
            Introduzca código EAN:
        </td>
        </tr>
    
    <tr>
    <td align="center" colspan="2">
        <form action="procesa.php" method="post" name="buscafield" id="buscafield" target="presen">
            Nombre<input type="radio" name="tipobusqueda" value="nombreprod" />
            EAN   <input type='radio' name='tipobusqueda' value="eancode" checked='checked' />
            <input type='text' size='20' name='cadena' id='cadena' maxlength='20' onchange='envia()' />
	    
        </form>
        
    </td>
    <td><input type='submit' value='Enviar' onClick='javascript:envia()' /></td>
    </tr>
    
   </table>
</div>
<?php
 
echo $_SESSION['delete_all'];
?> 

<a href='salir.php' target='presen'>Salir</a>
</body>
</html>