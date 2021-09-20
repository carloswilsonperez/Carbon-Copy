<?php

session_start();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <link href="ccpystyles.css" rel="stylesheet" type="text/css">

        <script>
			//Esta función auxilia para la navegación por medio de índices

			function pagindex(page, subcat) {
				document.forms['indexman'].pagina.value = page;
				document.forms['indexman'].subcat.value = subcat;
				document.forms['indexman'].submit();
			}

			function prev_item(itemform) 
                        {
				var itemno = document.forms[itemform].elements[0].value;
				itemno--;

				if (itemno < 1) {
					itemno = 1;
				}
				if (itemno < 10)
                                {
                                   document.forms[itemform].elements[0].value = "   " + itemno;     
                                }
                                else if (itemno < 100)
                                {
                                   document.forms[itemform].elements[0].value = "  " + itemno;
                                }
                                else
                                {
                                   document.forms[itemform].elements[0].value = " " + itemno;
                                }
			}

			function next_item(itemform, cant) 
                        {

				var itemno = document.forms[itemform].elements[0].value;
				itemno++;

				if (itemno > cant) {
					itemno = cant;
				}
                                
                                if (itemno < 10)
                                {
                                   document.forms[itemform].elements[0].value = "   " + itemno;     
                                }
                                else if (itemno < 100)
                                {
                                   document.forms[itemform].elements[0].value = "  " + itemno;
                                }
                                else
                                {
                                   document.forms[itemform].elements[0].value = " " + itemno;
                                }

				
			}

			function item_to_cart(itemform) {
				//se obtiene la cantidad de artículos a colocar
				var itemno = document.forms[itemform].elements[0].value;

				//se escriben el código de producto y la cantidad pedida en el formulario de envio
				document.forms['additems'].ean.value = itemform;
				document.forms['additems'].quantity.value = itemno;

				document.forms['additems'].submit();
			}

        </script>
    </head>

    <body>

        <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
        

            <?php

            function cintilla($max_pages, $subcat, $index_status) 
            {
                echo "<div id='pageindexs'>";
                    echo "<table border='1'>";
                    echo "<tr>";

                    for ($i = 1; $i <= $max_pages; $i++) {
                        if ($_SESSION['actual_page'] == $i) 
                        {
                            echo "<td style='background-color:rgb(153, 217, 234);' width='30'><a href='#' onClick = 'location.href=\"catalogo2.php?pagina=" . $i . "&subcat=" . $subcat . "\"'>" . $i . "</a></td>";
                        } 
                        else 
                        {
                            echo "<td width='30'><a href='#' onClick = 'location.href=\"catalogo2.php?pagina=" . $i . "&subcat=" . $subcat . "\"'>" . $i . "</a></td>";
                        }
                    }
                    echo "<td>".$index_status."</td>";
                    echo "</tr>";
                    echo "</table>";
                echo "</div>";
            }

            if (isset($_GET['pagina']) && isset($_GET['subcat'])) 
            {
                $subcat = $_GET['subcat'];
                //Almacena la subcategoría elegida por el usuario
                
                $pagina = $_GET['pagina'];
                
                $_SESSION['actual_page'] = $pagina;
                //Almacena la página seleccionada por el usuario

                //Mientras se están explorando las páginas de una misma subcategoría, ya no se realizan más consultas a la bdd
                //únicamente se usan los datos de la variable de sesión $_SESSION['row_array']) ya leídos la primera vez
                //Esta variable de sesión se limpia al seleccionar otra categoría o subcategoría distinta

                if (!isset($_SESSION['row_array'])) 
                {
                    //Se consultan los productos dentro de la subcategoría dada
                    //SE DEBERÁN ORDENAR POR POPULARIDAD (PENDIENTE)
                    $query = "select * from productos where productos.idcategoria = '".$subcat."' order by nombreprod asc";

                    $db = new mysqli($_SESSION['server'], $_SESSION['user_id'], $_SESSION['user_pass'], $_SESSION['dbase']);

                    $result = $db -> query($query);

                    //$db -> close();

                    //La variable de sesión 'num_results' alberga el número de artículos que integran una subcategoría dada
                    $_SESSION['num_results'] = $result -> num_rows;

                    //Se define y carga la variable de sesión 'row_array' que albergará un array de todos los artículos que pertenecen a una subcategoría dada
                    //Para cada producto, se guardarán: ean, nombre, marca, presentación y precio.
                    $_SESSION['row_array'] = array();  //Inicialización del array

                    for ($i = 0; $i < $_SESSION['num_results']; $i++) 
                    {
                        $row = $result -> fetch_assoc();

                        $reancode = stripslashes($row['eancode']);
                        $rnombreprod = stripslashes($row['nombreprod']);
                        $rmarcaprod = stripslashes($row['marcaprod']);
                        $rpresentitem = stripslashes($row['presentitem']);
                        $rcontentitem = stripslashes($row['contentitem']);
                        $rprecioactual = $row['precioactual'];
                        $rcosto = $row['preciomayoreo'];

                        array_push($_SESSION['row_array'], $reancode);
                        array_push($_SESSION['row_array'], $rnombreprod);
                        array_push($_SESSION['row_array'], $rmarcaprod);
                        array_push($_SESSION['row_array'], $rpresentitem);
                        array_push($_SESSION['row_array'], $rcontentitem);
                        array_push($_SESSION['row_array'], $rprecioactual);
                        array_push($_SESSION['row_array'], $rcosto);
                    }
                }

                $_SESSION['sub_inventory'] = array();
                $_tmparray = array();
                
                for ($i = 0; $i < count($_SESSION['row_array']); $i += 7) 
                {
                    $_eancode = $_SESSION['row_array'][$i];
                    
                    $query = "SELECT * FROM inventario WHERE inventario.eancode = '".$_eancode."'";
                    $db = new mysqli($_SESSION['server'], $_SESSION['user_id'], $_SESSION['user_pass'], $_SESSION['dbase']);             
                    $result = $db -> query($query);
                    $num = $result -> num_rows;
                    
                    if ($num == 1)
                    {
                        $row = $result -> fetch_assoc();
                        
                        $_existencias = stripslashes($row['existencias']);
                        $_tmparray[$_eancode] = $_existencias;
                    }      
                }
                
                $_SESSION['sub_inventory'] = $_tmparray;
                
                $db -> close();
                $numcols = 4;
                $filasporpagina = 4;
                $max_pages = ceil($_SESSION['num_results'] / ($numcols * $filasporpagina));
                //Este es el total de ?ndices a mostrar en la cintilla para la categor?a elegida

                //El elemento 'mostrador' es el que alberga las p?ginas que contienen el listado de ?tems

                $inicio = ($numcols * $filasporpagina) * ($pagina - 1) + 1;
                $final = $inicio + ($numcols * $filasporpagina) - 1;

                if ($_SESSION['num_results'] > $final) 
                {
                    $offset = $numcols * $filasporpagina - 1;
                } 
                else 
                {
                    $offset = $_SESSION['num_results'] - $inicio;
                }

                //La variable $finalitem señala el último elemento en una página dada. Ejemplo: inicio: 13, $finalitem: 24
                //La variable $offset señala el número de elementos relativos al valor $inicio, en que termina una p�gina dada.
                //Por ejemplo, si estamos en la página 2 y hay un total de 14 artículos encontrados, entonces $inicio = 13, $offset = 1 y $finalitem = 14
                $finalitem = $inicio + $offset;

                //La variable de sesión $_SESSION['index_status'] almacena entre páginas información del tipo: "Mostrando 1 - 12 de 31 resultados"
                //ME PARECE QUE NO ES NECESARIO QUE ESTA VARIABLE SEA DE SESIÓN????

                $index_status = "Mostrando " . $inicio . " - " . $finalitem . " de " . $_SESSION['num_results'] . " resultados";

                $num = $finalitem - $inicio + 1;

                //A continuación se crea la tabla que aloja a los 12 artículos por página.
                echo "<div class='fondo'>";
                echo "<div id='mostrador'>";

                echo "<table width='150' cellspacing='20'>";
                echo "<tr>";

                for ($i = $inicio; $i <= $finalitem; $i++) 
                {
                    //La variable $inicio señala el número de artículo que inicia la página; ejemplo: página=2 e $inicio = 13.
                    //La variable $index señala el índice del array a usar; señala la ubicación del código EAN

                    $index = $inicio + 7 * ($i - 1) - 16 * ($pagina - 1) - 1;

                    $codigo = $_SESSION['row_array'][$index];     //Código EAN del Producto.
                    $nombre = $_SESSION['row_array'][$index + 1]; //Nombre del Producto.
                    $marca = $_SESSION['row_array'][$index + 2];   //Marca del Producto.
                    $presentacion = $_SESSION['row_array'][$index + 3];  //Presentación del producto.
                    $contenido = $_SESSION['row_array'][$index + 4];  //Contenido del Producto.
                    $precio = $_SESSION['row_array'][$index + 5];    //Precio del Producto.

                    echo "<td>";

                    //A continuación se crea la tabla que aloja la presentación de cada ítem.

                    echo "<table id='individual' width='120' cellpadding='1'>";
                    
                    if ($_SESSION['sub_inventory'][$codigo] > 0)
                    {
                        echo "<tr><td colspan='3'><img src='pictures/mamut.jpg' width='100' height='100'></td></tr>";
                    }
                    else
                    {
                        echo "<tr><td colspan='3'><img src='pictures/nostock2.jpg' width='100' height='100'></td></tr>";
                    }

                    echo "<tr><td colspan='3'>" . $nombre . "<br /></td></tr>";  //Nombre del Producto

                    echo "<tr><td colspan='3'>" . $marca . "<br /></td></tr>";    //Marca del Producto

                    echo "<tr><td colspan='3'>" . $presentacion . "<br /></td></tr>";  //Presentaci?n del Producto

                    echo "<tr><td colspan='3'>" . $contenido . "<br /></td></tr>";  //Contenido del Producto

                    echo "<tr><td colspan='3'>$" . $precio . "</td></tr>";  //Precio del Producto

                    echo "<tr>";
                    
                    if ($_SESSION['sub_inventory'][$codigo] > 0)
                    {
                        echo "<form name='" . $codigo . "' id='" . $codigo . "'>";
                                    
                            echo "<td width='30'><img src='botones/l.png' width='20' height='20' onclick='prev_item(\"" . $codigo . "\")' /></td>";
                            echo "<td width='30'><input name='1' id='1' maxlength='2' size='2' value='   1' readonly></td><td width='30'>";
                            echo "<img src='botones/r.png' width='20' height='20' onclick='next_item(\"" . $codigo . "\", ".$_SESSION['sub_inventory'][$codigo].")' /></td>";
                        
                            echo "</form>";
                        echo "</tr>";

                        echo "</td></tr>";
                        echo "<tr>";
                        echo "<td colspan='3' align='center'>";
                        echo "<a href='#' onclick='item_to_cart(\"" . $codigo . "\");'>";
                        echo "<img src='botones/addtocart.png' width='99' height='33' />";
                        echo "</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    else 
                    {
                         echo "<td width='30'><img src='botones/l.png' width='20' height='20' onclick='prev_item(\"" . $codigo . "\")' /></td>";
                         echo "<td width='30'><input name='1' id='1' maxlength='2' size='2' value='   0' readonly></td><td width='30'>";
                         echo "<img src='botones/r.png' width='20' height='20' /></td>";
                        
                         echo "</tr>";

                         echo "</td></tr>";
                         echo "<tr>";
                         echo "<td colspan='3' align='center'>";
                         echo "<a href='javascript:void(0)'>";
                         echo "<img src='botones/addtocart.png' width='99' height='33' />";
                         echo "</a>";
                         echo "</td>";
                         echo "</tr>"; 
                        
                    }
                    
                    echo "</table>";

                    echo "</td>";
                    
                    if ($i % $numcols == 0) 
                    {
                        echo "</tr><tr>";
                    }
                }

                echo "</tr>";
                echo "</table>";
                 echo "</div>";
                echo "</div>";
                cintilla($max_pages, $subcat, $index_status);
                //Esta función muestra la cintilla de índice de navegación.

               
                echo "<div class='banner'></div>";

                //Aquí estaba antes la función 'cintilla'.

            }

            if (isset($_POST['categoria']) && isset($_SESSION['valid_user'])) 
            {
                $categoria = $_POST['categoria'];

                unset($_SESSION['categ']);
                unset($_SESSION['subcat']);
                unset($_SESSION['row_array']);
                unset($_SESSION['num_results']);
                unset($_SESSION['actual_page']);
                //unset($_SESSION['index_status']);

                switch ($categoria) {
                    case 'R' :
                        $_SESSION['categ'] = "Refrescos y Jugos";
                        $query = "select idcategoria, subcat from categorias where categorias.idcategoria like '%" . $categoria . "%'";
                        break;
                    case 'C' :
                        $_SESSION['categ'] = "Cocina Fácil";
                        $query = "select idcategoria, subcat from categorias where categorias.idcategoria like '%" . $categoria . "%'";
                        break;
                    case 'F' :
                        $_SESSION['categ'] = "Frutas y Verduras";
                        $query = "select idcategoria, subcat from categorias where categorias.idcategoria like '%" . $categoria . "%'";
                        break;
                    case 'B' :
                        $_SESSION['categ'] = "Botanas y Panes";
                        $query = "select idcategoria, subcat from categorias where categorias.idcategoria like '%" . $categoria . "%'";
                        break;
                    case 'A' :
                        $_SESSION['categ'] = "Abarrotes Básicos";
                        $query = "select idcategoria, subcat from categorias where categorias.idcategoria like '%" . $categoria . "%'";
                        break;
                    case 'L' :
                        $_SESSION['categ'] = "Lácteos y Helados";
                        $query = "select idcategoria, subcat from categorias where categorias.idcategoria like '%" . $categoria . "%'";
                        break;
                    case 'T' :
                        $_SESSION['categ'] = "Tortilla, Harina y Pastas";
                        $query = "select idcategoria, subcat from categorias where categorias.idcategoria like '%" . $categoria . "%'";
                        break;
                    case 'N' :
                        $_SESSION['categ'] = "Carnes";
                        $query = "select idcategoria, subcat from categorias where categorias.idcategoria like '%" . $categoria . "%'";
                        break;
                    case 'P' :
                        $_SESSION['categ'] = "Higiene Personal";
                        $query = "select idcategoria, subcat from categorias where categorias.idcategoria like '%" . $categoria . "%'";
                        break;
                    case 'H' :
                        $_SESSION['categ'] = "Higiene del Hogar";
                        $query = "select idcategoria, subcat from categorias where categorias.idcategoria like '%" . $categoria . "%'";
                        break;
                    case 'Y' :
                        $_SESSION['categ'] = "Bebés";
                        $query = "select idcategoria, subcat from categorias where categorias.idcategoria like '%" . $categoria . "%'";
                        break;
                    case 'M' :
                        $_SESSION['categ'] = "Mascotas";
                        $query = "select idcategoria, subcat from categorias where categorias.idcategoria like '%" . $categoria . "%'";
                        break;
                    case 'O' :
                        $_SESSION['categ'] = "Otros";
                        $query = "select idcategoria, subcat from categorias where categorias.idcategoria like '%" . $categoria . "%'";
                        break;
                }

                $db = new mysqli($_SESSION['server'], $_SESSION['user_id'], $_SESSION['user_pass'], $_SESSION['dbase']);

                $result = $db -> query($query);
                $num_results = $result -> num_rows;
                
                echo "<div class='fondo_categories'>";
                echo "<div class='subcategorias'>";
                    echo "<img src='clipart/" . $categoria . ".jpg' width='200' height='200'>";
                    echo "<table class='subs'>";

                    echo "<tr><th colspan='2'>" . $_SESSION['categ'] . "</th></tr>";

                    for ($i = 0; $i < $num_results; $i++) 
                    {
                        $row = $result -> fetch_assoc();
                        $_SESSION['subcat'] = stripslashes($row['subcat']); //Refrescos varios, sardina y atún, etc.
                                                
                        $_SESSION['idcat'] = stripslashes($row['idcategoria']); //R01, N01, etc.
                        
                        //A continuación se crea la tabla que aloja la presentación de cada subcategoría de la categoría elegida
                        echo "<tr><td>" . ($i + 1) . "</td><td><a href='catalogo2.php?subcat=" . $_SESSION['idcat'] . "&pagina=1'>" . $_SESSION['subcat'] . "</a></td></tr>";
                    }
                    
                    echo "</table>";
                echo "</div>";
                echo "</div>";
                echo "<div class='banner_categories'>";
                ?>
                <a href="http://www.facebook.com/carloswilsonperez" target="_blank" style="target-new: tab;"><img src="botones/facebook.png"></a>
                <?php 
                echo "</div>";

            }
            
            ?>
            <br>
            <br>
            
            <form action="catalogo2.php" id="indexman"  name="indexman" method="get" target="presen">

                <input type="hidden" id="subcat" name="subcat">
                <input type="hidden" id="pagina" name="pagina">

            </form>

            <form id='additems' name='additems' action='derecha.php' method='post' target='right'>
                <input type="hidden" id="ean" name="ean" />
                <input type="hidden" id="quantity" name="quantity" />
            </form>

        </div>
    </body>
</html>

