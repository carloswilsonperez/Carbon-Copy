<!DOCTYPE html>
<html lang="es">
<head>
     <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<style>

table {
            background-color: navy;
            color: white;
            font-family: verdana, arial;
            font-size: 12pt;
      }
         
.cuadro {
            position:absolute;
            left: 150px;
            top: 0px;
            background-color: white;
            border-color: black;
            border-style: double;
            border-width:5x;
            color: black;
            width: 950px;
            height: 6000px;
         }
         
.coloca {
            position:absolute;
            left: 620px;
            top: 350px;
            font-size: 25pt;
         }

.titles {
            font-size: 15pt;
            font-weight: 700;
         }
         
.warn {  
            position:absolute;
            left: 220px;
            top: 100px;
            background-color: red;
            border-color: white;
            border-style: double;
            border-width:10px;
            color: white;
            width: 500px;
            height: 200px;
            font-size: 15pt;
            font-weight: 700;
         }

.chekin {  
            position:absolute;
            left: 220px;
            top: 100px;
            background-color: red;
            border-color: white;
            border-style: double;
            border-width:10px;
            color: white;
            width: 500px;
            height: 200px;
            font-size: 15pt;
            font-weight: 700;
         }
         
.chekin2 {  
            position:absolute;
            left: 220px;
            top: 100px;
            background-color: red;
            border-color: white;
            border-style: double;
            border-width:10px;
            color: white;
            width: 500px;
            height: 200px;
            font-family: verdana, arial;
            font-size: 20pt;
            font-weight: 700;
         }

</style>

</head>


<body leftmargin="0" topmargin="0" bgcolor="gray">


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
            
    ?>
    
    <script language="javascript">
        parent.presen.document.location.href="presen.php";
        top.naver.document.location.href="naver.php";
        top.naver.document.buscafield.cadena.focus();
    </script>
    
    <?php
   
    echo "</div>";
    echo "</body>";
    echo "</html>";
    exit;
    
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
        <form name="cierre" id="cierre" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
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
                         <input type="text" name="cash" id="cash" autofocus required>
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
    
    //insertar todas las filas de la tabla TEMPORAL en la tabla VENTASITEM
    $query_temporal_dump  = "select * from temporal";
    $result_temporal_dump = $db->query($query_temporal_dump);
    $num_results_dump     = $result_temporal_dump->num_rows;
    
    if ($monto != 0 ) {
    for ($i=0; $i<$num_results_dump; $i++) 
            {
            $row = $result_temporal_dump->fetch_assoc(); 
            
            //$ridproduct     = $row['idproduct'];
            $reancode       = stripslashes($row['eancode']);
            
            //$rnombreprod    = stripslashes($row['nombreprod']);
            //$rmarcaprod     = stripslashes($row['marcaprod']);
            //$rpresentitem   = stripslashes($row['presentitem']);
            //$rcontentitem   = $row['contentitem'];
            //$ridcategoria   = stripslashes($row['idcategoria']);
            //$ranaquel       = stripslashes($row['anaquel']);
            $rprecioactual  = $row['precioactual'];
            //$rdescripcion   = stripslashes($row['descripcion']);
            
            
            $query_ventasitem_insert  = "insert into ventasitem set eancode='".$reancode."', precio= '".$rprecioactual."'";
            $result_ventasitem_insert = $db->query($query_ventasitem_insert);
            
            }
    }
    
    $query_borrar = "delete from temporal";
    $result_borrar = $db->query($query_borrar);
            
    $result_temporal_dump->free();
            //$result_borrar->free();
    $db->close();
            
    echo "</div>";
    echo "</body>";
    echo "</html>";
    exit;
    
    }

    ?>

    <?php 



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
      
    ?>
    
 
    
    <?php  
    
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
    
    
     
// Esta parte se procesa cuando se presiona los botones de borrar ítem

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
        $ridproduct[$i]  = intval($row['idproduct']);
        }
         
    $delrowtemporal--;
    $temp = intval($ridproduct[$delrowtemporal]);
     
    $query_delrow  = "delete from temporal where idproduct=".$temp;
    $result_borrar = $db2->query($query_delrow);
     
    $query_temporal_dump  = "select * from temporal";
    $result_temporal_dump = $db2->query($query_temporal_dump);
    $num_results_dump     = $result_temporal_dump->num_rows;
     
    if ($num_results_dump != 0) 
        
        {  //inicia dibujo de tabla
     
        $query_suma = "select sum(precioactual) from temporal";
        $result_suma = $db2->query($query_suma);
        $parcial = $result_suma->fetch_row(); 
        
        echo "<form action='".$_SERVER['PHP_SELF']."' method='post' target='presen'>";                    
        echo "<table width='940' border='2'>";
        echo "<tr><td class='titles' align='center'>No</td><td class='titles' align='center'>Nombre</td><td class='titles' align='center'>Marca</td><td class='titles' align='center'>Presentación</td><td class='titles' align='center'>Precio</td></tr>";  //encabezados
        for ($i=0; $i<$num_results_dump; $i++) 
            {
            $row = $result_temporal_dump->fetch_assoc(); 
            echo "<tr>";
            echo "<td>".($i+1)."</td><td>".stripslashes($row['nombreprod'])."</td><td>".stripslashes($row['marcaprod'])."</td><td>".stripslashes($row['presentitem'])."</td><td align='right'> $".stripslashes($row['precioactual'])."</td>";
            echo "<td align='center'>";
            echo "<input type='submit' name='delrowtemporal' value='".($i+1)."'>";
            echo "</td>";           
            echo "</tr>";
            }
            
        echo "<tr>";
        echo "<td colspan='4' align='right' class='titles'>TOTAL:</td>";
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

// Esta parte ejecuta la búsqueda en la tabla PRODUCTOS

 if ( isset($_POST['cadena']) ) {
    $cadena = $_POST['cadena'];
    $cadena = trim($cadena);
    $cadena = addslashes($cadena);
    
    $tipobusqueda = $_POST['tipobusqueda'];
    
    if (!$cadena) {  //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    ?>
    <script language="javascript">
        parent.presen.document.location.href="presen.php";
        top.naver.document.location.href="naver.php";
        top.naver.document.buscafield.cadena.focus();
    </script>  
    <?php
    }
    
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
    
    //se consulta la tabla por la primera coincidencia con el criterio seleccionado
    if ($tipobusqueda == "nombreprod") 
    {
        $query = "select * from productos where productos.nombreprod like '%".$cadena."%' order by nombreprod asc";
    }
    
    if ($tipobusqueda == "eancode") 
    {
        $query = "select * from productos where productos.eancode like '%".$cadena."%' limit 1";
    }
    
    $result = $db->query($query);
    $num_results = $result->num_rows;
    
    if ($tipobusqueda == "nombreprod") 
    {
        echo "<table width='940' border='2'>";
        echo "<tr><td class='titles' align='center'>No</td><td class='titles' align='center'>Nombre</td><td class='titles' align='center'>Marca</td><td class='titles' align='center'>Presentación</td><td class='titles' align='center'>Precio</td></tr>";  //encabezados
        for ($i=0; $i<$num_results; $i++) 
            {
            $row = $result->fetch_assoc(); 
            echo "<tr>";
            echo "<td>".($i+1)."</td><td>".stripslashes($row['nombreprod'])."</td><td>".stripslashes($row['marcaprod'])."</td><td>".stripslashes($row['presentitem'])."</td><td align='right'> $".stripslashes($row['precioactual'])."</td>";
                
            echo "</tr>";
            }
        
        echo "</table>";
        echo "<center>";
        echo "<table width='940' style='background-color:white' >";
        echo "<tr>";
        echo "<td>&nbsp</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td colspan='5' align='center'>";
        echo "<form action='".$_SERVER['PHP_SELF']."' method='post' target='presen'>";
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
    //Aquí se escribe el resultado de la consulta en la tabla TEMPORAL,
    //pero si la búsqueda NO arroja resultados, no se inserta nada en TEMPORAL
    if ($tipobusqueda == "eancode" && $num_results != 0 ) {  
    
        $row = $result->fetch_assoc(); 
            
        $ridproduct     = $row['idproduct'];
        $reancode       = stripslashes($row['eancode']);
        $rnombreprod    = stripslashes($row['nombreprod']);
        $rmarcaprod     = stripslashes($row['marcaprod']);
        $rpresentitem   = stripslashes($row['presentitem']);
        $rcontentitem   = $row['contentitem'];
        $ridcategoria   = stripslashes($row['idcategoria']);
        $ranaquel       = stripslashes($row['anaquel']);
        $rprecioactual  = $row['precioactual'];
        $rdescripcion   = stripslashes($row['descripcion']);
        
        $result->free();
        
        //aquí se insertan los datos, excepto si se trata de una búsqueda por nombre del producto
        
         
                   
        $query_temporal_insert = "insert into temporal (eancode, nombreprod, marcaprod, presentitem, contentitem, idcategoria, anaquel, precioactual, descripcion) values ('".$reancode."', '".$rnombreprod."', '".$rmarcaprod."', '".$rpresentitem."', '".$rcontentitem."', '".$ridcategoria."', '".$ranaquel."', '".$rprecioactual."', '".$rdescripcion."')";
        $result_temporal_insert = $db->query($query_temporal_insert);
                
                
        // inicia mostrar la tabla TEMPORAL en la pantalla...
        
        $query_temporal_dump = "select * from temporal";
        $result_temporal_dump = $db->query($query_temporal_dump);
        $num_results_dump = $result_temporal_dump->num_rows;
         
        $query_suma = "select sum(precioactual) from temporal";
        $result_suma = $db->query($query_suma);
        $parcial = $result_suma->fetch_row(); 
        
        
        echo "<form action='".$_SERVER['PHP_SELF']."' method='post' target='presen'>";                    
        echo "<table width='940' border='2'>";
        echo "<tr><td class='titles' align='center'>No</td><td class='titles' align='center'>Nombre</td><td class='titles' align='center'>Marca</td><td class='titles' align='center'>Presentación</td><td class='titles' align='center'>Precio</td></tr>";  //encabezados
        for ($i=0; $i<$num_results_dump; $i++) 
            {
            $row = $result_temporal_dump->fetch_assoc(); 
            echo "<tr>";
            echo "<td>".($i+1)."</td><td>".stripslashes($row['nombreprod'])."</td><td>".stripslashes($row['marcaprod'])."</td><td>".stripslashes($row['presentitem'])."</td><td align='right'> $".stripslashes($row['precioactual'])."</td>";
            echo "<td align='center'>";
            echo "<input type='submit' name='delrowtemporal' value='".($i+1)."'>";
            echo "</td>";           
            echo "</tr>";
            }
        echo "<tr>";
        echo "<td colspan='4' align='right' class='titles'>TOTAL:</td>";
        echo "<td align='right' class='titles'> $".$parcial[0]."</td>";
        echo "</tr>";
        echo "</table>";
        echo "<input type='hidden' name='monto' value='".$parcial[0]."'>";
        echo "</form>";
          
        $db->close();
        $showbuttons = "true";
        $suma = $parcial[0];
        
        if (isset($showbuttons)) 
            {
            echo "<center>";
            echo "<form action='".$_SERVER['PHP_SELF']."' method='post' target='presen'>";
            echo "<input type='submit' name='cancelar' value='Cancelar' />";
            echo "<input type='button' value='<--------->' />";
            echo "<input type='submit' name='terminar' value='Terminar' />"; 
            echo "<input type='hidden' name='monto' value='".$suma."'>";
            echo "</form>";  
            echo "</center>";
            }
        
        } 
    else       //esta parte es la que se ejecuta si no se encuentra nada
        {
        $query = "select * from temporal";
        $result_temporal_dump = $db->query($query);
        $num_results_dump = $result_temporal_dump->num_rows;
        
        
        if ($num_results_dump == 0) {
        //si ya hay productos en la lista no sucede nada; 
        //en caso contrario, volver a pantalla de inicio
        
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
        //}
        $db->close();
        } 
        else 
        {
            // reescribir la tabla TEMPORAL en pantalla
           
        $query_suma = "select sum(precioactual) from temporal";
        $result_suma = $db->query($query_suma);
        $parcial = $result_suma->fetch_row(); 
        
            echo "<form action='".$_SERVER['PHP_SELF']."' method='post' target='presen'>";                    
            echo "<table width='940' border='2'>";
            echo "<tr><td class='titles' align='center'>No</td><td class='titles' align='center'>Nombre</td><td class='titles' align='center'>Marca</td><td class='titles' align='center'>Presentación</td><td class='titles' align='center'>Precio</td></tr>";  //encabezados
            for ($i=0; $i<$num_results_dump; $i++) 
                {
                $row = $result_temporal_dump->fetch_assoc(); 
                echo "<tr>";
                echo "<td>".($i+1)."</td><td>".stripslashes($row['nombreprod'])."</td><td>".stripslashes($row['marcaprod'])."</td><td>".stripslashes($row['presentitem'])."</td><td align='right'> $".stripslashes($row['precioactual'])."</td>";
                echo "<td align='center'>";
                echo "<input type='submit' name='delrowtemporal' value='".($i+1)."'>";
                echo "</td>";           
                echo "</tr>";
                }
        echo "<tr>";
        echo "<td colspan='4' align='right' class='titles'>TOTAL:</td>";
        echo "<td align='right' class='titles'> $".$parcial[0]."</td>";
        echo "</tr>";
        echo "</table>";
        echo "<input type='hidden' name='monto' value='".$parcial[0]."'>";
        echo "</form>";
          
        $db->close();
        $showbuttons = "true";
        $suma = $parcial[0];
        
        if (isset($showbuttons)) 
            {
            echo "<center>";
            echo "<form action='".$_SERVER['PHP_SELF']."' method='post' target='presen'>";
            echo "<input type='submit' name='cancelar' value='Cancelar' />";
            echo "<input type='button' value='<--------->' />";
            echo "<input type='submit' name='terminar' value='Terminar' />"; 
            echo "<input type='hidden' name='monto' value='".$suma."'>";
            echo "</form>";  
            echo "</center>";
            }    
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