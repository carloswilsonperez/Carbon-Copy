<html>
<head>
<style>

.cuadro {position:absolute;
         left: 50px;
         top: 65px;
         background-color: #0099CC;
         border-color: black;
         border-style: double;
         border-width:5x;
         }
         
.coloca {position:absolute;
         left: 620px;
         top: 350px;
         font-size: 25pt;
        
         }
         
        
</style>
 
<script language="javascript" type="text/javascript">

function fija_foco()
{
parent.naver.document.codigobarra1.codigobarra2.focus();
//window.parent.presen.document.lista1.lista2.value = "Gato";
}   

function escribe2()
{

// Una vez introducido el código,
// el código PHP ejecutará la consulta en la base de datos.
//  Lo que se devuelva en la base de datos se colocará en la variable CONTENT
// Dicha variable irá almacenando las sucesivas consultas (ítems a comprar).


var content = window.parent.naver.document.codigobarra1.codigobarra2.value;
window.parent.presen.document.lista1.lista2.value = content;
//setTimeOut('escribe2()', 100);
}

function envia()
{
document.forms['codigobarra1'].submit();
}
   

</script>

</head>

<body leftmargin=0 topmargin=0 bgcolor=#FFFAF0 onLoad="fija_foco()">
<table border="0">
    <tr>
    <td>
        Introduzca el Código del Artículo:
    </td>
    <td rowspan="2">
        <a href="javascript:envia()"><img src="cart.jpg" width="50" height="50" align="top"></a>
    </td>
    </tr>
    <tr>
    <td align="center" valign="middle">
        
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" name="codigobarra1">
            <input type="text" size="12" name="codigobarra2" onKeyDown="escribe2()" onKeyUp="escribe2()">
        </form>
    </td>
    </tr>
    
</table>

<?php

$codigo = $_POST['codigobarra2'];
//$saldo .= $codigobarra2;
$total = $total + codigobarra2;
//echo "Usted introdujo ".$codigobarra2;
echo "<script language='javascript'>";
echo "window.parent.presen.document.lista1.lista2.value = 'Usted colocó:' + '$codigo'";
echo "</script>";


 
// Ejecutar la consulta

// Formatear el resultado de la consulta
// anexar el resultado al contenido de la variable CONTENT
// Escribir el valor de CONTENT en el TEXTAREA de presen.html

?>      
</body>
</html>