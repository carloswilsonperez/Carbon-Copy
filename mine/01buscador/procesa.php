<!DOCTYPE html>
<html lang="es">
<head>
     <META http-equiv=Content-Type content="text/html; charset=ISO-8859-1" />
<style>

table {background-color: navy;
       color: white;
       font-family: verdana, arial;
       font-size: 12pt;
       }
         
.cuadro {position:absolute;
         left: 150px;
         top: 0px;
         background-color: white;
         border-color: black;
         border-style: double;
         border-width:5x;
         color: black;
         width: 950px;
         height: 600px;
3
         }
         
.coloca {position:absolute;
         left: 620px;
         top: 350px;
         font-size: 25pt;
        
         }

.titles {
         font-size: 15pt;
         font-weight: 700;
        
         }

       
</style>
 
</head>

<body leftmargin="0" topmargin="0" bgcolor="red">


<div class="cuadro">
  
    
<?php


/* Aquí se escribe el resultado de la query en un archivo txt con tabulaciones
function escribe ($result, $num_results) {
    
    $fp = fopen("temporal.txt", "a+");
    if (!$fp) {
        echo "<p><strong> Your order could not be processed at this time. Please try again later.</strong></p>" ;
        $result->free();
        $db->close();
        echo "</div></body></html>";
        exit;
            }
    
    for ($i=0; $i <$num_results; $i++) {
            
        $row = $result->fetch_assoc();
        
        //$outputstring = "Producto: ".stripslashes($row['nombreprod'])."\t"."Marca: ".stripslashes($row['marcaprod'])."\t"."Presentación: ".stripslashes($row['presentitem'])."\t"."Precio: $".stripslashes($row['precioactual']."\n");
        $outputstring = stripslashes($row['nombreprod'])."\t".stripslashes($row['marcaprod'])."\t".stripslashes($row['presentitem'])."\t".stripslashes($row['precioactual']."\n");
                
        fwrite ($fp, $outputstring);
        }
    
        fclose ($fp);
        
    }

*/

// Aquí se procesa la búsqueda

if (isset($_POST['cadena']) && $_POST['cadena'] != "") {   
        
    $cadena = $_POST['cadena'];
    $cadena = trim($cadena);
    $cadena = addslashes($cadena);
    
    $tipobusqueda = $_POST['tipobusqueda'];
    
    echo $cadena; 
    echo $tipobusqueda;
    
    if (!$cadena) {
    echo 'You have not entered search details.  Please go back and try again.';
    exit;
    }
    
    if (!get_magic_quotes_gpc()){
        $cadena = addslashes($cadena);

    }
    
    $db = new mysqli('localhost', 'root', 'nailita', 'carboncopy');
    
    if (mysqli_connect_errno()) {
        echo 'Error: Could not connect to database. Please try again later.';
        exit;
    }
    
    if ($tipobusqueda == "nombreprod") {
        $query = "select * from productos where productos.nombreprod like '%".$cadena."%' order by nombreprod asc";
    
    }
    
    if ($tipobusqueda == "eancode") {
        $query = "select * from productos where productos.eancode like '%".$cadena."%'";
    
    }
    
    $result = $db->query($query);
    $num_results = $result->num_rows;
    
    echo "<p>Number of items found: ".$num_results."</p>";
    
    
    if ($num_results != 0) {   
    echo "<table width='940' border='2'>";
    
    echo "<tr><td class='titles' align='center'>No</td><td class='titles' align='center'>Nombre</td><td class='titles' align='center'>Marca</td><td class='titles' align='center'>Presentación</td><td class='titles' align='center'>Precio</td></tr>";  //encabezados
    
        for ($i=0; $i<$num_results; $i++) {
        
            $row = $result->fetch_assoc(); 
            echo "<tr>";
               echo "<td>".($i+1)."</td><td>".stripslashes($row['nombreprod'])."</td><td>".stripslashes($row['marcaprod'])."</td><td>".stripslashes($row['presentitem'])."</td><td>".stripslashes($row['precioactual'])."</td>";
            echo "</tr>";
        }
        echo "</table>";
        }
    
    /* inicia sección que escribe en archivo o base de ddatos
    echo escribe($result2, $num_results);
        
    $items = file("temporal.txt");
    $number_of_items = count($items);
    
    echo "<table width='940' border='2'>";
    echo "<tr>";
    echo "<td>Nombre</td><td>Marca</td><td>Presentación</td><td>Precio</td></tr>";  //encabezados
    for ($i=0; $i<$number_of_items; $i++) {
        
        $line = explode("\t", $items[$i]);
        echo "<tr><td>$line[0]</td><td>$line[1]</td><td>$line[2]</td><td>"."$ "."$line[3]</td></tr>";
    }
    echo "</table>";
    $fp = fopen("temporal.txt", "w");
    fwrite ($fp,"");
    fclose ($fp);
       
    */
    
    $result->free();
    $db->close();
    
    }
    

?> 
<br />

<hr />
<br />
<center>
    <form action="presen.php" method="post" target="presen">
        <input type="submit" value="Volver" />
    </form>  
</center>     
      
</div>

</body>
</html>