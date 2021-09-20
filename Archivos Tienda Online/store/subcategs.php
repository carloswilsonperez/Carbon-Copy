<?php
session_start();

require_once ('check_valid_user.php');
require_once ('check_total_articles.php');
require_once('greeting.php');
//header('Content-Type: text/html; charset=UTF-8'); 
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
                         

            }
            
            ?>
            <br>
            <br>
            </div><!--/fondo-->
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

