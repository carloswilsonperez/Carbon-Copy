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

<!DOCTYPE html>
<html lang="es">
    <head>
	   <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	   <link href="posstyles.css" rel="stylesheet" type="text/css" />


       <script language="javascript">
            
	       function setcode(ean)
	       {
	             
               top.presen.document.forms['additem'].cadena.value = ean;  //Se asigna el código ean del artículo que se habrá de agregar
		       top.presen.document.forms['additem'].tipobusqueda.value = "nombreprod";
		       top.naver.document.forms['buscafield'].tipobusqueda[1].checked = true;  //Esto es necesario para reactivar la búsqueda por código y usar el lector
		       top.naver.document.forms['buscafield'].cadena.focus();   //Esto es necesario para que el lector de códigos pueda tomar la siguiente lectura
		       top.presen.document.forms['additem'].submit();
	       }
		 	
	       
	       function operation(ean,operation)
	       {
	           top.presen.document.forms['agregar'].cadena.value = ean;  //Se asigna el código ean del artículo que se habrá de agregar
	        
	           if (operation == "agregar")
	           {
	               top.presen.document.forms['agregar'].sysoperation.value = "agregar";   
	           }
	        
	           if (operation == "delete")
               {
                   top.presen.document.forms['agregar'].sysoperation.value = "delete";   
               }
	        
	   	
	   	       top.naver.document.forms['buscafield'].tipobusqueda[1].checked = true;  //Esto es necesario para reactivar la búsqueda por código y usar el lector
	   	       top.naver.document.forms['buscafield'].cadena.focus();   //Esto es necesario para que el lector de códigos pueda tomar la siguiente lectura
	   	       top.presen.document.forms['agregar'].submit();
	       }
	   
	       function prev_item(itemform)
	       {
                var itemno = top.presen.document.forms[itemform].elements["qty"].value;
	      	    itemno = parseInt(itemno);
	      	    itemno--;
	        
	      	    if (itemno < 1)
	      	    {
	               itemno = 1;
	      	    }   
	      	
	      	    top.presen.document.forms[itemform].elements["qty"].value = itemno;
		        top.presen.document.forms['agregar'].cadena.value = itemform.substring(4);  //Se asigna el código ean del artículo que se habrá de agregar
		        top.presen.document.forms['agregar'].sysoperation.value = "sub";
		        top.presen.document.forms['agregar'].submit();
	       }
	   
	        function next_item(itemform)
	        {
	     	    var itemno = top.presen.document.forms[itemform].elements[0].value;
	            itemno++;
	        	 
	            if (itemno > 99)
	            {
	               itemno = 99;
	            }
	   
	            top.presen.document.forms[itemform].elements["qty"].value = itemno;
                top.presen.document.forms['agregar'].cadena.value = itemform.substring(4);  //Se asigna el código ean del artículo que se habrá de agregar
		        top.presen.document.forms['agregar'].sysoperation.value = "sum";
		        top.presen.document.forms['agregar'].submit();
	        }
	    
            </script>

 
        
	<?php 
	
	function escribe_tabla_temporal($my_array)
	{
        echo "<table class='write_table'>";
	       echo "<tr><th>No</th><th>Nombre</th><th>Marca</th><th>Presentación</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th></tr>";  //encabezados
	        
    	   $total_money = 0;
                
            for ($i=0; $i<count($my_array); $i += 8) 
    	    {
    	        $eancode = (string)$my_array[$i];
                    
                $_nombreprod = $my_array[$i + 1];
    	        $_marcaprod = $my_array[$i + 2];
    	        $_presentiten = $my_array[$i + 3];
    	        $_cantidad = intval($my_array[$i + 7]);
    	        $_precioactual = floatval($my_array[$i + 5]);
    	        $_subtotal = $_cantidad * $_precioactual;
    		    $total_money += $_subtotal;
        	    $id_renglon = intval($i/8) + 1;
        	    $form_name = "form".$eancode;
    		   
                echo "<tr>";
            	echo "<td>".$id_renglon."</td><td>".$_nombreprod."</td><td>".$_marcaprod."</td><td>".$_presentiten."</td>";
            	echo "<td>";
            	echo "<form name='".$form_name."' id='".$form_name."'>";
            	echo "<img src='botones/prev.png' width='20' height='20' onclick='prev_item(\"".$form_name."\")' />";
            	echo "<input type='text' id='qty' name='qty' maxlength='3' size='3' value='".$_cantidad."' >";
        		echo "<img src='botones/next.png' width='20' height='20' onclick='next_item(\"".$form_name."\")' />";
        		echo "</form>";
        		echo "</td>";
        		echo "<td align='right'>";
        		printf('$%0.2f', $_precioactual);
        		echo "</td><td align='right'>";
        		printf('$%0.2f', $_subtotal)."</td>";
        		
    		    echo "<td align='center'>";	          				
                 echo "<input type='button' value='Borrar' onClick='operation(\"".$eancode."\", \"delete\")'>";
    		    echo "</td>";           
    		    echo "</tr>";
    		
	        }
		
            $_SESSION['total_money'] = $total_money;
	    	echo "<tr>";
	    	echo "<td colspan='6'>TOTAL:</td>";
	    	echo "<td>";
	        printf ('$%0.2f', $_SESSION['total_money']);
		    echo "</td>";
	    	echo "</tr>";
        echo "</table>";
	    echo "<input type='hidden' name='monto' value='6000'>";
	    echo $_POST['sysoperation']."<br>";
	    echo $_POST['cadena']."<br>";
	    echo $_SESSION['row_array'][7]."<br>";
	    print_r($_SESSION['row_array']);
	      
	    $showbuttons = "true";
	           
	    if (isset($showbuttons)) 
	    {
	        echo "<center>";
	        echo "<form action='procesa.php' method='post' target='presen'>";
	        echo "<input type='submit' name='cancelar' value='Cancelar' />";
	        echo "<input type='button' value='<--------->' />";
	        echo "<input type='submit' name='terminar' value='Terminar' />"; 
	        echo "<input type='hidden' name='monto' value='".$_SESSION['total_money']."'>";
	        echo "</form>";  
	        echo "</center>";
	    }
	        
	}
	
	?>

   </head>


   <body>
	 
	
	<form name='additem' id='additem' action="procesa.php" method="post">
	    <input type="hidden" name="cadena" id="cadena">
	    <input type="hidden" name="tipobusqueda" id="tipobusqueda">
	</form>
	    
	<!--El formulario siguiente se ejecuta al persionar el botón BORRAR   -->    
	<form name='delitem' id='delitem' action="procesa.php" method="post">
	   <input type="hidden" name="delrowtemporal" id="delrowtemporal">
	</form>
	
	<!--El formulario siguiente se ejecuta al persionar el botón AGREGAR   --> 
	<form name='agregar' id='agregar' action="procesa.php" method="post">
	    <input type="hidden" name="sysoperation" id="sysoperation">
	    <input type="hidden" name="cadena" id="cadena">
	</form>
	 

   

    <?php 
	
	if (isset($_POST['sysoperation']) && isset($_POST['cadena']))
	{
	    $cadena = $_POST['cadena'];
	    $sysoperation = $_POST['sysoperation'];
	    
	    if (!in_array($cadena, $_SESSION['row_array']) && $sysoperation == 'agregar')
	    {
	    	    
	       for ($i=0; $i<count($_SESSION['row_array_tmp']); $i += 8) 
	       {
	           if ($cadena == $_SESSION['row_array_tmp'][$i])
	    	   {
	    	       array_push($_SESSION['row_array'], $_SESSION['row_array_tmp'][$i]);  	//EAN
	    	       array_push($_SESSION['row_array'], $_SESSION['row_array_tmp'][$i+1]);	//Nombre
	    	       array_push($_SESSION['row_array'], $_SESSION['row_array_tmp'][$i+2]);	//Marca
	    	       array_push($_SESSION['row_array'], $_SESSION['row_array_tmp'][$i+3]);	//Presentación
	    	       array_push($_SESSION['row_array'], $_SESSION['row_array_tmp'][$i+4]);	//Contenido
	    	       array_push($_SESSION['row_array'], $_SESSION['row_array_tmp'][$i+5]);	//Precio
	    	       array_push($_SESSION['row_array'], $_SESSION['row_array_tmp'][$i+6]);	//Costo
	    	       array_push($_SESSION['row_array'], 1);
	    	   }
	       }
	    
	       $_SESSION['row_array_tmp'] = array();
	    }
	    
	    if (in_array($cadena, $_SESSION['row_array']) && $sysoperation == 'sum')
	    {    	    	    
	        for ($i=0; $i<count($_SESSION['row_array']); $i += 8) 
	    	{
	    	    if ($cadena == $_SESSION['row_array'][$i])
	    	    {
	    	       $_SESSION['row_array'][$i + 7]++;
	    	    }
	    	}
	    }
	    
	    if (in_array($cadena, $_SESSION['row_array']) && $sysoperation == 'sub')
	    {
	        	    	    
	        for ($i=0; $i<count($_SESSION['row_array']); $i += 8) 
	        {
	    	    if ($cadena == $_SESSION['row_array'][$i])
	    	    {
	    	        $_SESSION['row_array'][$i + 7]--;
		        if ($_SESSION['row_array'][$i + 7] <= 1)
			{
			   $_SESSION['row_array'][$i + 7] = 1;
			}
	    	    }
	      	}
	    }
        
         if (in_array($cadena, $_SESSION['row_array']) && $sysoperation == 'delete')
        {
            $tmp_array = array();          
            for ($i=0; $i<count($_SESSION['row_array']); $i += 8) 
            {
                if ($cadena == $_SESSION['row_array'][$i])
                {
                    continue;
                }
                else 
                {
                    array_push($tmp_array, $_SESSION['row_array'][$i]);
                    array_push($tmp_array, $_SESSION['row_array'][$i + 1]);
                    array_push($tmp_array, $_SESSION['row_array'][$i + 2]);
                    array_push($tmp_array, $_SESSION['row_array'][$i + 3]);
                    array_push($tmp_array, $_SESSION['row_array'][$i + 4]);
                    array_push($tmp_array, $_SESSION['row_array'][$i + 5]);
                    array_push($tmp_array, $_SESSION['row_array'][$i + 6]);
                    array_push($tmp_array, $_SESSION['row_array'][$i + 7]);
                  
                }
            }
            
            $_SESSION['row_array'] = array();
            $_SESSION['row_array'] = $tmp_array;
        }
        
        //Si el array se queda sin elementos, mandar a presen.php    
        if (count($_SESSION['row_array']) == 0)
        {
            header("location:presen.php");
        }
	    echo escribe_tabla_temporal($_SESSION['row_array']);  	        
	    exit;
	}
	
		
	 // PUNTO DE ENTRADA DEL SCRIPT PROCESA.PHP desde el script INDEX2.PHP
	 // Esta parte ejecuta la búsqueda en la tabla PRODUCTOS +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	 if ( isset($_POST['cadena'])) 
	 {
	    
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
		$_SESSION['row_array_tmp'] = array();
	    	
		if ($tipobusqueda == "nombreprod")
		{
		    echo "<form action='procesa.php' method='post' target='presen' name='agregar' id='agregar'>";        
		    echo "<table width='940' border='2'>";
		    echo "<tr><td class='titles' align='center'>No</td><td class='titles' align='center'>Nombre</td><td class='titles' align='center'>Marca</td><td class='titles' align='center'>Presentación</td><td class='titles' align='center'>Precio</td></tr>";  //encabezados
		    for ($i=0; $i<$num_results; $i++) 
		    {   
		        $row = $result->fetch_assoc(); 
		            
		        $reancode       = stripslashes($row['eancode']);
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
			    array_push($_SESSION['row_array_tmp'], 1);
			    
			    echo "<tr>";
		        echo "<td align='center'>".($i+1)."</td><td>".$rnombreprod."</td><td>".$rmarcaprod."</td><td>".$rpresentitem."</td><td align='right'>";
			    printf('$%0.2f', $rprecioactual);
			    echo "</td>";
		        echo "<td align='center'>";
		        echo "<input type='button' value='Agregar' onClick='operation(\"".$reancode."\", \"agregar\")'>";
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
		    $result -> free;
		    exit;
	           
	    	}     
		else
		{
		    //Si la búsqueda es por código EAN, y existen resultados,
		    //el resultado de la consulta se escribirá en la pantalla.
			    
		    $row = $result->fetch_assoc(); 
		            
		    $reancode       = stripslashes($row['eancode']);
		    $rnombreprod    = stripslashes($row['nombreprod']);
		    $rmarcaprod     = stripslashes($row['marcaprod']);
		    $rpresentitem   = stripslashes($row['presentitem']);
		    $rcontentitem   = stripslashes($row['contentitem']);
		    $rprecioactual  = floatval($row['precioactual']);
		    $rcosto 	    = floatval($row['preciomayoreo']);
		      
		    array_push($_SESSION['row_array'], $reancode);
		    array_push($_SESSION['row_array'], $rnombreprod);
		    array_push($_SESSION['row_array'], $rmarcaprod);
		    array_push($_SESSION['row_array'], $rpresentitem);
		    array_push($_SESSION['row_array'], $rcontentitem);
		    array_push($_SESSION['row_array'], $rprecioactual);
		    array_push($_SESSION['row_array'], $rcosto);
		    array_push($_SESSION['row_array'], $_SESSION['total_articles']);
	     
	   
		    // ESTA PARTE MUESTRA la tabla TEMPORAL en la pantalla...
		               
		    echo escribe_tabla_temporal($_SESSION['row_array']);
	        
	        }
		$result -> free;
	    } 
	    else       
	    {
	        
		//esta parte es la que se ejecuta si no se obtienen resultados de la búsqueda   
	        
		if (count($_SESSION['row_array']) == 0) 
		{
	           //si no hay productos en la lista, se vuelve a la pantalla de inicio;
		   //en caso contrario, no sucede nada
	        
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
	           
	           echo escribe_tabla_temporal($_SESSION['row_array']);
	        
	        }
	        ?>
	        <script>
	            top.naver.document.buscafield.cadena.focus();
	        </script>
	        
	        <?php    
	        
	        echo "</div>";
	        }
	 }
 
 ?> 
 
 
 
 
 
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
    
        //$db = new mysqli('localhost', 'root', 'nailita', 'carboncopy');
        
        
        //Una vez cerrada la venta,
        //se insertan todas las filas de la tabla TEMPORAL en la tabla VENTASITEM
        
       
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
    
    
     
   

?>


 
 
 
 
 
 
 
 
 
 


</body>
</html>