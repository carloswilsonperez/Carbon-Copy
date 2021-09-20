<?php

    session_start();
    //header('Content-Type: text/html; charset=UTF-8'); 
    
    require_once ('check_valid_user.php');
    require_once ('check_total_articles.php');
    require_once('greeting.php');
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <link href="ccpystyles.css" rel="stylesheet" type="text/css">
<title>Carbon Copy</title>
        <meta name="description" content="">
        <meta name="author" content="Carlos">

        <meta name="viewport" content="width=device-width; initial-scale=1.0">

        <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
        <link rel="shortcut icon" type="image/png" href="logo.png">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        <script> 
            var username = '<?php echo $message; ?>';
            var total_articles = '<?php echo $_SESSION["total_articles"]; ?>';
            var total_money = '<?php echo $_SESSION["total_money"]; ?>';
        </script>
        <script src='script_code.js'></script>
    </head>

    <body> 
        
        
   <header id="site_head">	
            
        <?php 
            require_once('header.php');
        ?>
    
        </header>

        <div id='indice'></div>
        <div id='izquierda'>
            
        <?php 
            require_once('menu.php');
        ?>
            
        </div>
        <div id='derecha'></div>
        <div id='right-upper-box'></div>
        <div id='left-upper-box'></div>
        
<div id="fondo"><!--Incluye al mostrador-->
   <div id='mostrador'>
    
    </div>
   



            <?php

            function cintilla($max_pages, $subcat, $index_status) 
            {
                echo "<div id='pageindexs'>";
                    echo "<table border='1'>";
                    echo "<tr>";
                    
                    if ($subcat == "turn_on_search")
                    {
                        $subcat = "turn_off_search";
                    }
                    
                    for ($i = 1; $i <= $max_pages; $i++) 
                    {    
                        if ($_SESSION['actual_page'] == $i) 
                        {
                            echo "<td id='thispage' width='30'><a href='#' onClick = 'location.href=\"catalogo.php?pagina=" . $i . "&subcat=" . $subcat . "\"'>" . $i . "</a></td>";
                        } 
                        else 
                        {
                            echo "<td id='thisnotpage' width='30'><a href='#' onClick = 'location.href=\"catalogo.php?pagina=" . $i . "&subcat=" . $subcat . "\"'>" . $i . "</a></td>";
                        }
                    }
                    echo "<td>".$index_status."</td>";
                    echo "</tr>";
                    echo "</table>";
                echo "</div>";
            }
            
                        
            if (isset($_GET['subcat'])&& isset($_GET['pagina'])) 
            {
                
                //Almacena la subcategoría elegida por el usuario.
                $subcat = $_GET['subcat'];
                
                //Almacena la página elegida por el usuario (=1 al cargarse por primera vez).
                $pagina = $_GET['pagina'];
                
                $_SESSION['actual_page'] = $pagina;
                
                if ($subcat == "turn_on_search")
                {
                    unset($_SESSION['categ']);
                    unset($_SESSION['row_array']);
                    unset($_SESSION['num_results']);
                }                
                
                //Almacena la página seleccionada por el usuario

                //Mientras se están explorando las páginas de una misma subcategoría, ya no se realizan más consultas a la bdd
                //únicamente se usan los datos de la variable de sesión $_SESSION['row_array']) ya leídos la primera vez
                //Esta variable de sesión se limpia al seleccionar otra categoría o subcategoría distinta

                if (!isset($_SESSION['row_array'])) 
                {
                    //Se consultan los productos dentro de la subcategoría dada
                    //SE DEBERÁN ORDENAR POR POPULARIDAD (PENDIENTE)
                    
                    //Si está activada la búsqueda y existe un término de búsqueda
                    
                    
                    
                    if ($subcat == "turn_on_search")
                    {
                        if (isset($_GET['search_term']))
                        {
                            $search_term = $_GET['search_term'];
                            $search_term = trim($search_term);
                            $search_term = mb_convert_encoding($search_term, 'ISO-8859-1', 'UTF-8');
                            $search_term = strtolower($search_term);
                            
                            $query = "SELECT * FROM productos WHERE productos.nombreprod LIKE '%".$search_term."%' OR productos.marcaprod LIKE '%".$search_term."%'";
                        }
                        else
                        {
                            header("location:index.php");
                        }
                    }
                    else 
                    {
                        $query = "SELECT * FROM productos WHERE productos.idcategoria = '".$subcat."' ORDER BY nombreprod ASC";
                    }
                                                
                    $db = new mysqli($_SESSION['server'], $_SESSION['user_id'], $_SESSION['user_pass'], $_SESSION['dbase']);

                    $result = $db -> query($query);

                    //$db -> close();

                    //La variable de sesión 'num_results' alberga el número de artículos que integran una subcategoría dada
                    $_SESSION['num_results'] = $result -> num_rows;
                    
                    if ($_SESSION['num_results'] == 0)
                    {
                        echo "Lo siento: cero resultados";
                        exit;
                    }
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
                //Este es el total de índices a mostrar en la cintilla para la categoría elegida

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
                
                
                cintilla($max_pages, $subcat, $index_status);
                //Esta función muestra la cintilla de índice de navegación.

               
                echo "<div class='banner'></div>";

                //Aquí estaba antes la función 'cintilla'.

            }
            else
            {
                //header ("location:presen.php");
            }

           ?>
    
    
</div>


        
        <div id="bottom">
        
        <?php 
            require_once('bottom.php');
        ?>
            
        </div>

        <?php
        
            require_once('forms.php');
        ?>
    </body>
</html>

