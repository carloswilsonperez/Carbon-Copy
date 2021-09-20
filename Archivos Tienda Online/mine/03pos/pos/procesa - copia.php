<?php
session_start();


if (!isset($_SESSION['total_articles']))
{
    $_SESSION['total_articles'] = 0;
    $_SESSION['total_money'] = 0;
    $_SESSION['total_utility'] = 0;
    $_SESSION['row_array'] = array();
    $_SESSION['row_array_tmp'] = array();
}

?>

<!DOCTYPE html>
<html lang="es">
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<link href="posstyles.css" rel="stylesheet" type="text/css">


	<script language="javascript">
	
	   function setcode(ean)
	   {
		document.forms['additem'].cadena.value = ean;  //Se asigna el código ean del artículo que se habrá de agregar
		top.naver.document.forms['buscafield'].tipobusqueda[1].checked = true;  //Esto es necesario para reactivar la búsqueda por código y usar el lector
		top.naver.document.forms['buscafield'].cadena.focus();   //Esto es necesario para que el lector de códigos pueda tomar la siguiente lectura
		document.forms['additem'].submit();
	   }
		 	
	   function delete_item(num)
	   {
	        document.forms['delitem'].delrowtemporal.value = num;
		top.naver.document.forms['buscafield'].tipobusqueda[1].checked = true;
		top.naver.document.forms['buscafield'].cadena.focus();
		document.forms['delitem'].submit();
	   }
	    
	</script>

 
        
	<?php 
	
	function escribe_tabla_temporal()
	{
	           
	    echo "<form action='procesa.php' method='post' target='presen'>";                    
	    echo "<table width='940' border='2'>";
	    echo "<tr><td class='titles' align='center'>No</td><td class='titles' align='center'>Nombre</td><td class='titles' align='center'>Marca</td><td class='titles' align='center'>Presentación</td><td class='titles' align='center'>Cantidad</td><td class='titles' align='center'>Precio</td></tr>";  //encabezados
	    
	    for ($i=0; $i<count($_SESSION['row_array_tmp']); $i += 8) 
	    {
		$_nombreprod = $_SESSION['row_array_tmp'][i + 1];
		$_marcaprod = $_SESSION['row_array_tmp'][i + 2];
		$_presentiten = $_SESSION['row_array_tmp'][i + 3];
		$_cantidad = $_SESSION['row_array_tmp'][i + 7];
		$_precioactual = $_SESSION['row_array_tmp'][i + 6];
		$_subtotal = $_cantidad * $_precioactual;
		
		echo "<tr>";
		echo "<td align='center'>".($i+1)."</td><td>".$_nombreprod."</td><td>".$_marcaprod."</td><td>".$_presentiten."</td><td>".$_cantidad."</td><td align='right'> $".$_precioactual."</td><td align='right'> $".$_subtotal."</td>";
		echo "<td align='center'>";	          				
	        echo "<input type='button' value='Borrar' onClick='delete_item(".($i+1).")'>";
	        echo "</td>";           
	        echo "</tr>";
	    }
	    echo "<tr>";
	    echo "<td colspan='4' align='right' class='titles'>TOTAL:</td>";
	    echo "<td align='right' class='titles'> $6000</td>";
	    echo "</tr>";
	    echo "</table>";
	    echo "<input type='hidden' name='monto' value='6000'>";
	    echo "</form>";
	          
	    
	    $showbuttons = "true";
	    
	        
	    if (isset($showbuttons)) 
	    {
	       echo "<center>";
	       echo "<form action='procesa.php' method='post' target='presen'>";
	       echo "<input type='submit' name='cancelar' value='Cancelar' />";
	       echo "<input type='button' value='<--------->' />";
	       echo "<input type='submit' name='terminar' value='Terminar' />"; 
	       echo "<input type='hidden' name='monto' value='".$suma."'>";
	       echo "</form>";  
	       echo "</center>";
	    }
	    exit;    
	}
	?>

   </head>


   <body>
	 
	<!--El formulario siguiente se ejecuta al persionar el botón AGREGAR   --> 
	<form name='additem' id='additem' action="procesa.php" method="post">
	    <input type="hidden" name="cadena" id="cadena">
	    <input type="hidden" name="tipobusqueda" id="tipobusqueda" value="eancode">
	</form>
	    
	<!--El formulario siguiente se ejecuta al persionar el botón BORRAR   -->    
	<form name='delitem' id='delitem' action="procesa.php" method="post">
	   <input type="hidden" name="delrowtemporal" id="delrowtemporal">
	</form>
	
	<div class="cuadro">
   
        <?php

       // Esta parte se procesa cuando se presiona el botón TERMINAR
       if ( isset($_POST['cancelar']) ) 
       {  
	   $db = new mysqli('localhost', 'root', 'nailita', 'carboncopy');
    
           //insertar todas las filas de la tabla TEMPORAL en la tabla VENTASITEM
        
           $query_borrar = "delete from temporal";
           $result_borrar = $db->query($query_borrar);
           $db->close();
         }   
	?>
	    
	<script language="javascript">
	    parent.presen.document.location.href="presen.php";
	    top.naver.document.location.href="naver.php";
	    top.naver.document.buscafield.cadena.focus();
	</script>
    
       </div>
      </body>
    </html>
    exit;
    
    }
    <?php

    if ( isset($_POST['terminar']) ) 

    {
        if (isset($_POST['monto'])) 
        {
            $monto = $_POST['monto'];
        } 
        else 
        {
            $monto = 0;
        } 
    ?>
    
    <div class="chekin" id="chekin">
        <center>
        <form name="cierre" id="cierre" action="procesa.php" method="POST">
            <table>
                <tr>
                    <td>
                         Monto a pagar:
                    </td>
                </tr>
               <tr>
                    <td style="font-size: 25pt">
                        <?php echo "$ ".$monto; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                 <tr>
                    <td>
                         Introduzca el efectivo:
                    </td>
                </tr>
                <tr>
                    <td>
                         <input type="text" name="cash" id="cash" autofocus required autocomplete='off'>
                    </td>
                </tr>
                <tr>
                    <td>
                         <input type="hidden" name="cambio" id="cambio">
                         <input type="hidden" name="monto" id="monto" value="<?php echo $monto; ?>">
                </tr>
                <tr>
                    <td>
                         <input type="reset" value="Anular">
                    </td>
                    <td>
                          <input type="submit" value="Terminar">
                    </td>
                </tr>
            </table>
        </form>
        </center>
     </div>
     
     <?php
    
	    $db = new mysqli('localhost', 'root', 'nailita', 'carboncopy');
	    
	    
	    //Una vez cerrada la venta,
	    //se insertan todas las filas de la tabla TEMPORAL en la tabla VENTASITEM
	    
	    $query_temporal_dump  = "select * from temporal";
	    $result_temporal_dump = $db->query($query_temporal_dump);
	    $num_results_dump     = $result_temporal_dump->num_rows;
    
    if ($monto != 0 ) 
    {
        for ($i=0; $i<$num_results_dump; $i++) 
            {
            $row = $result_temporal_dump->fetch_assoc(); 
            
            $reancode       = stripslashes($row['eancode']);
            $rprecioactual  = $row['precioactual'];
                       
            $query_ventasitem_insert  = "insert into ventasitem set eancode='".$reancode."', precio= '".$rprecioactual."'";
            $result_ventasitem_insert = $db->query($query_ventasitem_insert);
            }
    }
    
    $query_borrar = "delete from temporal";
    $result_borrar = $db->query($query_borrar);
            
    $result_temporal_dump->free();
    $db->close();
            
    echo "</div>";
    echo "</body>";
    echo "</html>";
    exit;
    
    }

    if ( isset($_POST['cambio']) ) 
        {
        $cambio = $_POST['cambio'];
        $monto = $_POST['monto'];
        $cash = $_POST['cash'];
    
    ?>
    <div class="chekin2">
        <center>
            Cambio a entregar:
            <form action"<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <table>
                    <tr>
                        <td style="font-style: verdana, arial; font-size:30pt">
                        <?php echo "$ ".sprintf("%01.2f",($cash - $monto)); ?>
                        </td>
                    </tr>
                </table>
                <?php
                if (($cash - $monto) < 0 ) 
                {
                    echo "<strong>El cambio no puede ser NEGATIVO</strong>";
                }
                ?>
                
                <input type ="hidden" name="endtransaction" value="yes">
                <input type="submit" value="Finalizar">
            </form>
        </center>
    </div>
    <?php
    } 
      
      
    if ( isset($_POST['endtransaction']) ) 
        {
        ?>      
        <script language="javascript">
            parent.presen.document.location.href="presen.php";
            top.naver.document.location.href="naver.php";
            top.naver.document.buscafield.cadena.focus();
        </script>  
        <?php
        exit;
        }   
    
    
     
    // Esta parte se procesa cuando se presiona los botones BORRAR ITEM
    

    if ( isset($_POST['delrowtemporal']) ) 

    {
    $delrowtemporal = intval($_POST['delrowtemporal']);
      
    $db2 = new mysqli('localhost', 'root', 'nailita', 'carboncopy');
     
    $query_temporal_dump = "select * from temporal";
    $result_temporal_dump = $db2->query($query_temporal_dump);
     
    $num_results_dump = $result_temporal_dump->num_rows;
     
    for ($i=0; $i<$num_results_dump; $i++) 
        {
        $row             = $result_temporal_dump->fetch_assoc(); 
        $ridproduct[$i]  = intval($row['id']);
        }
         
    $delrowtemporal--;
    
    //La variable $temp contiene el índice del elemento a borrar
    $temp = intval($ridproduct[$delrowtemporal]);
    
    
    //Aquí se resta uno al artículo en la tabla TEMPORAL
    $query_tmp = "select * from temporal where temporal.id='".$temp."'";
    $resultemp = $db2->query($query_tmp);
    $rowtemp = $resultemp->fetch_assoc();
    $cantidad  = $rowtemp['cantidad'];
    $precio =  $rowtemp['precioactual'];
    
    
    //Se resta uno a la variable $cantidad
    $cantidad--;
    $subtotal = $precio * $cantidad;
    
    if ($cantidad > 0) 
    {
    	$query_temporal_update = "update temporal set cantidad ='".$cantidad."' where temporal.id='".$temp."'";
        $query_temporal_update2 = "update temporal set subtotal ='".$subtotal."' where temporal.id='".$temp."'";
    	$result_temporal_update = $db2->query($query_temporal_update);
	$result_temporal_update2 = $db2->query($query_temporal_update2);   
    }
    else
    {
    $query_delrow  = "delete from temporal where id=".$temp;
    $result_borrar = $db2->query($query_delrow);
    } 
    
    $query_temporal_dump  = "select * from temporal";
    $result_temporal_dump = $db2->query($query_temporal_dump);
    $num_results_dump     = $result_temporal_dump->num_rows;
     
    if ($num_results_dump != 0) 
        
        {  //Inicia dibujo de la Tabla TEMPORAL
     
        $query_suma = "select sum(subtotal) from temporal";
        $result_suma = $db2->query($query_suma);
        $parcial = $result_suma->fetch_row(); 
        
        echo "<form action='".$_SERVER['PHP_SELF']."' method='post' target='presen'>";                    
        echo "<table width='940' border='2'>";
        echo "<tr><td class='titles' align='center'>No</td><td class='titles' align='center'>Nombre</td><td class='titles' align='center'>Marca</td><td class='titles' align='center'>Presentación</td><td class='titles' align='center'>Cantidad</td><td class='titles' align='center'>Precio</td><td class='titles' align='center'>Subtotal</td></tr>";  //encabezados
        for ($i=0; $i<$num_results_dump; $i++) 
            {
            $row = $result_temporal_dump->fetch_assoc(); 
            echo "<tr>";
            echo "<td>".($i+1)."</td><td>".stripslashes($row['nombreprod'])."</td><td>".stripslashes($row['marcaprod'])."</td><td>".stripslashes($row['presentitem'])."</td><td>".stripslashes($row['cantidad'])."</td><td align='right'> $".stripslashes($row['precioactual'])."</td><td align='right'> $".stripslashes($row['subtotal'])."</td>";
            echo "<td align='center'>";
            echo "<input type='button' value='Borrar' onClick='delete_item(".($i+1).")'>";
            echo "</td>";           
            echo "</tr>";
            }
            
        echo "<tr>";
        echo "<td colspan='6' align='right' class='titles'>TOTAL:</td>";
        echo "<td align='right' class='titles'> $".$parcial[0]."</td>";
        echo "</tr>";
        echo "</table>";
        echo "</form>";
        
        $db2->close();
        
        $showbuttons = "true";
        $suma = $parcial[0];
        if (isset($showbuttons)) 
            {
            echo "<center>";
            echo "<form action='".$_SERVER['PHP_SELF']."' method='post' target='presen'>";
            echo "<input type='submit' name='cancelar' value='Cancelar' />";
            echo "<input type='submit' name='modificar' value='<--------->' />";
            echo "<input type='submit' name='terminar' value='Terminar' />"; 
            echo "<input type='hidden' name='monto' value='".$suma."'>";
            echo "</form>";  
            echo "</center>";
            }
        } else 
            {
            echo "<div class='warn'>";
            echo "<center>";
            echo "<table style='position:relative; top:65px'>";
            echo "<tr>";
            echo "<td>";
                echo "No hay resultados para mostrar";
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>";
            echo " ";
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>";
            echo " ";
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align='center'>";    
            echo "<form action='".$_SERVER['PHP_SELF']."' method='post' target='presen'>";
            echo "<input type='hidden' name='endtransaction' value='yes' />";  
            echo "<input type='submit' value='Volver' />";  
            echo "</form>"; 
            echo "</td>"; 
            echo "</tr>";
            echo "</table>";
            echo "</center>";
            
            }  
        
 
        }    // cierre de mostrar la tabla TEMPORAL en la pantalla

?>



<?php 

 // PUNTO DE ENTRADA DEL SCRIPT PROCESA.PHP desde el script INDEX2.PHP
 // Esta parte ejecuta la búsqueda en la tabla PRODUCTOS +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

 if ( isset($_POST['cadena']) ) {
    
    $cadena = $_POST['cadena'];
    $tipobusqueda = $_POST['tipobusqueda'];
        
    $cadena = trim($cadena);  
    
    if (!get_magic_quotes_gpc()) 
    {
        $cadena = addslashes($cadena);
    }
    
    $db = new mysqli('localhost', 'root', 'nailita', 'carboncopy');
 
    if (mysqli_connect_errno()) 
    {
        echo 'Error: Could not connect to database. Please try again later.';
        exit;
    }
    
    //Se consulta la tabla PRODUCTOS por la primera coincidencia, de acuerdo con el criterio seleccionado
    if ($tipobusqueda == "nombreprod") 
    {
        $query = "SELECT * FROM productos WHERE productos.nombreprod LIKE '%".$cadena."%' ORDER BY nombreprod ASC";
    }
    
    if ($tipobusqueda == "eancode") 
    {
        $query = "SELECT * FROM productos WHERE productos.eancode='".$cadena."'";
    }
    
    $result = $db->query($query);
    $num_results = $result->num_rows;
    
    $_SESSION['num'] =  $num_results; 
    
    if ($num_results != 0) 
    {
    	//Si la búsqueda es por nombre del producto y existen resultados,
    	//estos se muestran en la pantalla, y además, el usuario
    	//podrá agregar a la canasta el producto deseado, de uno a la vez.
    	//Si el usuario elige agregar algún producto, el script se autoejecuta según el criterio de búsqueda por EAN
	    
	$_SESSION['total_articles'] = 1;
    	
	if ($tipobusqueda == "nombreprod")
	{
	    echo "<form action='procesa.php' method='post' target='presen' name='agregar' id='agregar'>";        
	    echo "<table width='940' border='2'>";
	    echo "<tr><td class='titles' align='center'>No</td><td class='titles' align='center'>Nombre</td><td class='titles' align='center'>Marca</td><td class='titles' align='center'>Presentación</td><td class='titles' align='center'>Precio</td></tr>";  //encabezados
	    for ($i=0; $i<$num_results; $i++) 
	    {   
	        $row = $result->fetch_assoc(); 
	            
	        $reancode       = intval(stripslashes($row['eancode']));
	        $rnombreprod    = stripslashes($row['nombreprod']);
	        $rmarcaprod     = stripslashes($row['marcaprod']);
	        $rpresentitem   = stripslashes($row['presentitem']);
	        $rcontentitem   = stripslashes($row['contentitem']);
	        $rprecioactual  = floatval($row['precioactual']);
	        $rcosto 	= floatval($row['preciomayoreo']);
	            
	        array_push($_SESSION['row_array_tmp'], $reancode);
		array_push($_SESSION['row_array_tmp'], $rnombreprod);
		array_push($_SESSION['row_array_tmp'], $rmarcaprod);
		array_push($_SESSION['row_array_tmp'], $rpresentitem);
		array_push($_SESSION['row_array_tmp'], $rcontentitem);
		array_push($_SESSION['row_array_tmp'], $rprecioactual);
		array_push($_SESSION['row_array_tmp'], $rcosto);
		array_push($_SESSION['row_array_tmp'], $_SESSION['total_articles']);
		    
		echo "<tr>";
	        echo "<td align='center'>".($i+1)."</td><td>".$rnombreprod."</td><td>".$rmarcaprod."</td><td>".$rpresentitem."</td><td align='right'> $".$rprecioactual."</td>";
	        echo "<td align='center'>";
	        echo "<input type='button' value='Agregar' onClick='setcode(".$reancode.")'>";
	        echo "</td>";      
	        echo "</tr>";
	    }          
	    
	    echo "<input type='hidden' name='addrownum' value='".$num_results."'>"; 
	    echo "</table>";
	    echo "</form>";
	    echo "<center>";
	    echo "<table width='940' style='background-color:white' >";
	    echo "<tr>";
	    echo "<td>&nbsp</td>";
	    echo "</tr>";
	    echo "<tr>";
	    echo "<td colspan='5' align='center'>";
	    echo "<form action='procesa.php' method='post' target='presen'>";
	    echo "<input type='hidden' name='endtransaction' value='yes' />";  
	    echo "<input type='submit' value='Volver' />";  
	    echo "</form>";
	    echo "</td>"; 
	    echo "</tr>";
	    echo "<tr>";
	    echo "<td>&nbsp</td>";
	    echo "</tr>";
	    echo "</table>";
	    echo "</center>";
	    exit;
           
    	}     
	else
	{
	    //Si la búsqueda es por código EAN, y existen resultados,
	    //el resultado de la consulta se escribirá en la pantalla.
		    
	    $row = $result->fetch_assoc(); 
	            
	    $reancode       = intval(stripslashes($row['eancode']));
	    $rnombreprod    = stripslashes($row['nombreprod']);
	    $rmarcaprod     = stripslashes($row['marcaprod']);
	    $rpresentitem   = stripslashes($row['presentitem']);
	    $rcontentitem   = stripslashes($row['contentitem']);
	    $rprecioactual  = floatval($row['precioactual']);
	    $rcosto 	 = floatval($row['preciomayoreo']);
	      
	    array_push($_SESSION['row_array'], $reancode);
	    array_push($_SESSION['row_array'], $rnombreprod);
	    array_push($_SESSION['row_array'], $rmarcaprod);
	    array_push($_SESSION['row_array'], $rpresentitem);
	    array_push($_SESSION['row_array'], $rcontentitem);
	    array_push($_SESSION['row_array'], $rprecioactual);
	    array_push($_SESSION['row_array'], $rcosto);
	    array_push($_SESSION['row_array'], $_SESSION['total_articles']);
     
   
	    // ESTA PARTE MUESTRA la tabla TEMPORAL en la pantalla...
	               
	    echo escribe_tabla_temporal();
	        
	    
        
        }
    } 
    else       
    {
        
	//esta parte es la que se ejecuta si no se encuentra nada    
        
	if (count($_SESSION['row_array']) == 0) {
        //si ya hay productos en la lista no sucede nada; 
        //en caso contrario, volver a pantalla de inicio
        
        echo "<div class='warn'>";
        echo "<center>";
        echo "<table style='position:relative; top:65px'>";
        echo "<tr><td>No hay resultados para mostrar</td></tr>";
        echo "<tr><td></td></tr>";
        echo "<tr><td></td></tr>";
        echo "<tr>";
            echo "<td align='center'>";    
        echo "<form action='procesa.php' method='post' target='presen'>";
        echo "<input type='hidden' name='endtransaction' value='yes' />";  
        echo "<input type='submit' value='Volver' />";  
        echo "</form>"; 
        echo "</td>"; 
        echo "</tr>";
        echo "</table>";
        echo "</center>";
        //}
        
        } 
        else 
        {
           // reescribir la tabla TEMPORAL en pantalla +++++++++++++++++++++++++++++++
           
           echo escribe_tabla_temporal();
        
        }
        ?>
        <script>
            top.naver.document.buscafield.cadena.focus();
        </script>
        
        <?php    
        
        echo "</div>";
        }
        }
        
    // cierre de mostrar la tabla TEMPORAL en la pantalla
 

 
 ?> 


</div>
</body>
</html>