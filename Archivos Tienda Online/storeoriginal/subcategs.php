<?php
session_start();
//header('Content-Type: text/html; charset=UTF-8'); 
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <link href="ccpystyles.css" rel="stylesheet" type="text/css">

        <script>
            
            //Esta función auxilia para la navegación por medio de índices

            function pagindex(page, subcat) 
            {
                document.forms['indexman'].pagina.value = page;
		document.forms['indexman'].subcat.value = subcat;
		document.forms['indexman'].submit();
            }
            
            document.onload = function()
            {
                var content = "<table><tr><td rowspan = '2' width='80'><a href='viewcart.php' target='presen'><img src='botones/carrito1.png' width='40' height='40' /></a></td><td width='80'><?php echo $_SESSION['total_articles']; ?> </td><td rowspan='2' width='80'><?php echo sprintf ("\$%.2f", $_SESSION['total_money']); ?></td></tr><tr><td>  art&iacute;culo(s)</td></tr></table>";
                var div = top.frames['maquina'].document.getElementById('carrito');
                    
                div.innerHTML = content;
            }

			

        </script>
    </head>

    <body>

    <div class='fondo'>
   
    <?php

           
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
                        echo "<tr><td>" . ($i + 1) . "</td><td><a href='catalogo.php?subcat=" . $_SESSION['idcat'] . "&pagina=1'>" . $_SESSION['subcat'] . "</a></td></tr>";
                    }
                    
                    echo "</table>";
                echo "</div>";
                echo "</div>";
                

            }
            
            ?>
            <br>
            <br>
            
            <form action="catalogo.php" id="indexman"  name="indexman" method="get" target="presen">
                <input type="hidden" id="subcat" name="subcat">
                <input type="hidden" id="pagina" name="pagina">
            </form>
</div>
    </body>
</html>

