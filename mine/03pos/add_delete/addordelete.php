<!DOCTYPE html>
<html lang="es">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<style> 

.tablebrowser 
        {
        background-color: white;
        color: gray;
        font-family: verdana, arial;
        }
         
.tablaorigenes 
        {
        position: absolute;
        top: 50px;
        left: 10px;
        }
         
.cuadro {
        position: absolute;
        left: 150px;
        top: 0px;
        background-color: white;
        border-color: black;
        border-style: double;
        border-width:5px;
        color: black;
        width: 950px;
        height: 600px;
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

.bann_container { 
         position:absolute;
         left: 0px;
         top: 0px;
         background-color: white;
         width: 950px;
         height: 800px;
         visibility: visible;
         z-index:10;
         }

.banner {
        position:relative;
        top: 150px;
        z-index:10; 
        }
    
.wchanger {
         position:absolute;
         left: 505px;
         top: 50px;
         background-color: green;
         border-color: white;
         border-style: double;
         border-width:10px;
         color: white;
         width: 400px;
         height: 270px;
         font-family: verdana, arial;
         font-size: 12pt;
         font-weight: 700;
         visibility: hidden;
         z-index: 5;
     }

</style>

<script language="JavaScript"> 

function regresa() 
    {
    location.href="naver.php";
    }

function abre_loader(id)  {
        top.presen.document.getElementById(id).style.visibility = 'visible';
    }
    
function close_loader(id)    {
        top.presen.document.getElementById(id).style.visibility = 'hidden';
    }


function abrir_changewindow(id) 
    {
        top.presen.document.getElementById(id).style.visibility = 'visible';
        
        var wtitles = new Array('wcambiaidproduct', 'wcambiaeancode', 'wcambianombreprod', 'wcambiamarcaprod', 'wcambiapresentitem', 'wcambiacontentitem', 'wcambiaidcategoria', 'wcambiaanaquel', 'wcambiaprecio', 'wcambiadescripcion');
        var long_wtitle = wtitles.length;
        var i = 0;
                
        for (i = 0; i<long_wtitle; i++) {
            if (wtitles[i] == id) 
            {
                top.presen.document.getElementById(id).style.visibility = 'visible';
            }
            else 
            {
                top.presen.document.getElementById(wtitles[i]).style.visibility = 'hidden';
            }
        } 
     }
     
    
function cerrar_changewindow(id) 
    {
        top.presen.document.getElementById(id).style.visibility = 'hidden';
        
    }

function envia_formindice(indice) 
        {
            document.formindice.indice.value = indice;
            //alert(indice);
            top.naver.document.forms['buscafield'].indice.value = parseInt(indice, 10);
            document.formindice.submit(); 
        }
</script>


<?php

if (isset($_POST['cambiaridproduct'])) {
    
    $nuevoidproduct = $_POST['cambiaridproduct'];
    $ridproduct  = $_POST['ean'];
    $db = new mysqli('localhost', 'root', 'nailita', 'carboncopy');
    $query = "update productos set idproduct = '".$nuevoidproduct."' where idproduct = ".$ridproduct;
    $result = $db->query($query);
    ?>
    <script language='JavaScript'>
        alert ("La tabla se ha actualizado");
    </script>
    <?php
    unset($cambiaridproduct);
}


if (isset($_POST['cambiareancode'])) {
    
    $nuevoeancode = $_POST['cambiareancode'];
    $ridproduct  = $_POST['ean'];
    $db = new mysqli('localhost', 'root', 'nailita', 'carboncopy');
    $query = "update productos set eancode = '".$nuevoeancode."' where idproduct = ".$ridproduct;
    $result = $db->query($query);
    ?>
    <script language='JavaScript'>
        alert ("La tabla se ha actualizado");
    </script>
    <?php
    unset($cambiareancode);
}



if (isset($_POST['cambiarnombreprod'])) {
    
    $nuevonombreprod = $_POST['cambiarnombreprod'];
    $ridproduct  = $_POST['ean'];
    $db = new mysqli('localhost', 'root', 'nailita', 'carboncopy');
    $query = "update productos set nombreprod = '".$nuevonombreprod."' where idproduct = ".$ridproduct;
    $result = $db->query($query);
    ?>
    <script language='JavaScript'>
        alert ("La tabla se ha actualizado");
    </script>
    <?php
    unset($cambiarnombreprod);
}



if (isset($_POST['cambiarmarcaprod'])) {
    
    $nuevomarcaprod = $_POST['cambiarmarcaprod'];
    $ridproduct  = $_POST['ean'];
    $db = new mysqli('localhost', 'root', 'nailita', 'carboncopy');
    $query = "update productos set marcaprod = '".$nuevomarcaprod."' where idproduct = ".$ridproduct;
    $result = $db->query($query);
    ?>
    <script language='JavaScript'>
        alert ("La tabla se ha actualizado");
    </script>
    <?php
    unset($cambiarmarcaprod);
}



if (isset($_POST['cambiarpresentitem'])) {
    
    $nuevopresentitem = $_POST['cambiarpresentitem'];
    $ridproduct  = $_POST['ean'];
    $db = new mysqli('localhost', 'root', 'nailita', 'carboncopy');
    $query = "update productos set presentitem = '".$nuevopresentitem."' where idproduct = ".$ridproduct;
    $result = $db->query($query);
    ?>
    <script language='JavaScript'>
        alert ("La tabla se ha actualizado");
    </script>
    <?php
    unset($cambiarpresentitem);
}



if (isset($_POST['cambiarcontentitem'])) {
    
    $nuevocontentitem = $_POST['cambiarcontentitem'];
    $ridproduct  = $_POST['ean'];
    $db = new mysqli('localhost', 'root', 'nailita', 'carboncopy');
    $query = "update productos set contentitem = '".$nuevocontentitem."' where idproduct = ".$ridproduct;
    $result = $db->query($query);
    ?>
    <script language='JavaScript'>
        alert ("La tabla se ha actualizado");
    </script>
    <?php
    unset($cambiarcontentitem);
}



if (isset($_POST['cambiaridcategoria'])) {
    
    $nuevoidcatgoria = $_POST['cambiaridcategoria'];
    $ridproduct  = $_POST['ean'];
    $db = new mysqli('localhost', 'root', 'nailita', 'carboncopy');
    $query = "update productos set idcategoria = '".$nuevoidcatgoria."' where idproduct = ".$ridproduct;
    $result = $db->query($query);
    ?>
    <script language='JavaScript'>
        alert ("La tabla se ha actualizado");
    </script>
    <?php
    unset($cambiaridcategoria);
}


if (isset($_POST['cambiaranaquel'])) {
    
    $nuevoanaquel = $_POST['cambiaranaquel'];
    $ridproduct  = $_POST['ean'];
    $db = new mysqli('localhost', 'root', 'nailita', 'carboncopy');
    $query = "update productos set anaquel = '".$nuevoanaquel."' where idproduct = ".$ridproduct;
    $result = $db->query($query);
    ?>
    <script language='JavaScript'>
        alert ("La tabla se ha actualizado");
    </script>
    <?php
    unset($cambiaranaquel);
}



if (isset($_POST['cambiarprecio'])) {
    
    $nuevoprecio = $_POST['cambiarprecio'];
    $ridproduct  = $_POST['ean'];
    $db = new mysqli('localhost', 'root', 'nailita', 'carboncopy');
    $query = "update productos set precioactual = '".$nuevoprecio."' where idproduct = ".$ridproduct;
    $result = $db->query($query);
    ?>
    <script language='JavaScript'>
        alert ("La tabla se ha actualizado");
    </script>
    <?php
    unset($cambiarprecio);
}



if (isset($_POST['cambiardescripcion'])) {
    
    $nuevodescripcion = $_POST['cambiardescripcion'];
    $ridproduct  = $_POST['ean'];
    $db = new mysqli('localhost', 'root', 'nailita', 'carboncopy');
    $query = "update productos set descripcion = '".$nuevodescripcion."' where idproduct = ".$ridproduct;
    $result = $db->query($query);
    ?>
    <script language='JavaScript'>
        alert ("La tabla se ha actualizado");
    </script>
    <?php
    unset($cambiardescripcion);
}


?>
<?php

if ( isset($_POST['eancoded']) ) 
    {
        $cadena = $_POST['eancoded'];
        $db = new mysqli('localhost', 'root', 'nailita', 'carboncopy');
        if (mysqli_connect_errno()) 
            {
            echo 'Error: Could not connect to database. Please try again later.';
            exit;
            }
        $query = "select * from productos where productos.eancode like '%".$cadena."%' limit 1";
        $result = $db->query($query);
        $num_results = $result->num_rows;
        
        $row = $result->fetch_assoc(); 
            
        $indice     = $row['idproduct'];
        
        echo "<form action='procesa.php' method='post' name='formindice'>";    
        
        echo "<input type='hidden' name='indice'>";
        
        echo "</form>";
        ?>
        <script language='JavaScript'>
            envia_formindice( <?php echo $indice; ?> );
        </script>
        <?php
        
    }
       
?>



<?php

if ( isset($_POST['indice']) ) 
    {
    echo "<script language='javascript'>";
    echo "abre_loader('loader')";
    echo "</script>";
    $indice = $_POST['indice'];
    
    $db = new mysqli('localhost', 'root', 'nailita', 'carboncopy');
 
    if (mysqli_connect_errno()) 
    {
        echo 'Error: Could not connect to database. Please try again later.';
        exit;
    }
    
    $query = "select * from productos";
    $result = $db->query($query);
    $num_results = $result->num_rows;
    
   
    if ($indice <= 1) { $num = 0; }
    else { $num = $indice - 1; }
    
    
    //si la bÃƒÂºsqueda NO arroja resultados, no se escribe nada y tampoco se muestra la tabla temporal
    if ($num_results != 0) {
        
        for ($i=0; $i<$num; $i++) 
            {
            $row = $result->fetch_assoc(); 
            }  
    
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
        }
        
        $cerrar = "yes";
        
        }
?>


</head>




<body leftmargin="0" topmargin="0" bgcolor="gray" onUnload="javascript:abre_loader('loader');">


    <div id="cuadro" class="cuadro">
    
        <div id='loader' name='loader' class='bann_container'>
        <center>
            <img src="botones/temporal.gif" class="banner" />
        </center>
    </div> 
    
    <div id='wcambiaidproduct' name='wcambiaidproduct' class='wchanger'>
    Usted ha solicitado cambiar el ID del producto.
    <br />   
    <br />
    ID del producto actual:
    <br />   
    <?php
        if (isset($ridproduct)) 
        {
            echo $ridproduct;
        }
    ?>
    <br />   
    <br />   
    Introduzca el nuevo ID del Producto:
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method='post' target='presen'>
        <input type='text' name='cambiaridproduct' />
        <input type='hidden' name='indice' value="<?php echo $indice ?>" />
        <input type='hidden' name='ean' value="<?php echo $ridproduct ?>" /> 
        <br /><br />        
        <input type='reset' name='cancelar' value='Cancelar' onclick="cerrar_changewindow('wcambiaidproduct');" />
        <input type='submit' name='enviar' value='Aplicar' onclick="cerrar_changewindow('wcambiaidproduct');" />
        
    
    </form>     
</div> 



<div id='wcambiaeancode' name='wcambiaeancode' class='wchanger'>
    Usted ha solicitado cambiar el c�digo EAN del producto.
    <br />   
    <br />  
    Código EAN actual:
    <br />   
    <?php
        if (isset($reancode)) 
        {
            echo $reancode;
        }
    ?>
    <br />   
    <br />   
    Introduzca el nuevo código EAN:
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method='post' target='presen'>
        <input type='text' name='cambiareancode' />       
        <input type='hidden' name='indice' value="<?php echo $indice ?>" />
        <input type='hidden' name='ean' value="<?php echo $ridproduct ?>" />
        <br /><br />  
        <input type='reset' name='cancelar' value='Cancelar' onclick="cerrar_changewindow('wcambiaeancode');" />
        <input type='submit' name='enviar' value='Aplicar' onclick="cerrar_changewindow('wcambiaeancode');" />
    </form>     
</div> 



<div id='wcambianombreprod' name='wcambianombreprod' class='wchanger'>
    Usted ha solicitado cambiar el Nombre del producto.
    <br />   
    <br />  
    Nombre del producto actual:
    <br />   
    <?php
        if (isset($rnombreprod)) 
        {
            echo $rnombreprod;
        }
    ?>
    <br />   
    <br />   
    Introduzca el nuevo Nombre del producto:
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method='post' target='presen'>
        <input type='text' name='cambiarnombreprod' />        
        <input type='hidden' name='indice' value="<?php echo $indice ?>" />
        <input type='hidden' name='ean' value="<?php echo $ridproduct ?>" />
        <br /><br /> 
        <input type='reset' name='cancelar' value='Cancelar' onclick="cerrar_changewindow('wcambianombreprod');" />
        <input type='submit' name='enviar' value='Aplicar' onclick="cerrar_changewindow('wcambianombreprod');" />
    
    </form>     
</div> 


<div id='wcambiamarcaprod' name='wcambiamarcaprod' class='wchanger'>
    Usted ha solicitado cambiar la Marca del producto.
    <br />   
    <br />  
    Marca del producto actual:
    <br />   
    <?php
        if (isset($rmarcaprod)) 
        {
            echo $rmarcaprod;
        }
    ?>
    <br />   
    <br />   
    Introduzca la nueva Marca del producto:
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method='post' target='presen'>
        <input type='text' name='cambiarmarcaprod' />        
        <input type='hidden' name='indice' value="<?php echo $indice ?>" />
        <input type='hidden' name='ean' value="<?php echo $ridproduct ?>" />
        <br /><br />  
        <input type='reset' name='cancelar' value='ancelar' onclick="cerrar_changewindow('wcambiamarcaprod');" />
        <input type='submit' name='enviar' value='Aplicar' onclick="cerrar_changewindow('wcambiamarcaprod');" />
    
    </form>     
</div> 


<div id='wcambiapresentitem' name='wcambiapresentitem' class='wchanger'>
    Usted ha solicitado cambiar la Presentación del producto.
    <br />   
    <br /> 
    Presentación del producto actual:
    <br />   
    <?php
        if (isset($rpresentitem)) 
        {
            echo $rpresentitem;
        }
    ?>
    <br />   
    <br />   
    Introduzca la nueva Presentación del producto:
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method='post' target='presen'>
        <input type='text' name='cambiarpresentitem' />        
        <input type='hidden' name='indice' value="<?php echo $indice ?>" />
        <input type='hidden' name='ean' value="<?php echo $ridproduct ?>" />
        <br /><br />  
        <input type='reset' name='cancelar' value='Cancelar' onclick="cerrar_changewindow('wcambiapresentitem');" />
        <input type='submit' name='enviar' value='Aplicar' onclick="cerrar_changewindow('wcambiapresentitem');" />
    
    </form>     
</div> 


<div id='wcambiacontentitem' name='wcambiacontentitem' class='wchanger'>
    Usted ha solicitado cambiar el Contenido del producto.
    <br />   
    <br /> 
    Contenido del producto actual:
    <br />   
    <?php
        if (isset($rcontentitem)) 
        {
            echo $rcontentitem;
        }
    ?>
    <br />   
    <br />   
    Introduzca el nuevo Contenido:
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method='post' target='presen'>
        <input type='text' name='cambiarcontentitem' />       
        <input type='hidden' name='indice' value="<?php echo $indice ?>" />
        <input type='hidden' name='ean' value="<?php echo $ridproduct ?>" />
        <br />
        <br />
        <input type='reset' name='cancelar' value='Cancelar' onclick="cerrar_changewindow('wcambiacontentitem');" />
        <input type='submit' name='enviar' value='Aplicar' onclick="cerrar_changewindow('wcambiacontentitem');" />
    
    </form>     
</div> 


<div id='wcambiaidcategoria' name='wcambiaidcategoria' class='wchanger'>
    Usted ha solicitado cambiar la Categoría del producto.
    <br />   
    <br />  
    Categoría del producto actual:
    <br />   
    <?php
        if (isset($ridcategoria)) 
        {
            echo $ridcategoria;
        }
    ?>
    <br />   
    <br />   
    Introduzca la nueva Categoría del producto:
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method='post' target='presen'>
        <input type='text' name='cambiaridcategoria' />        
        <input type='hidden' name='indice' value="<?php echo $indice ?>" />
        <input type='hidden' name='ean' value="<?php echo $ridproduct ?>" />
        <br /><br />
        <input type='reset' name='cancelar' value='Cancelar' onclick="cerrar_changewindow('wcambiaidcategoria');" />
        <input type='submit' name='enviar' value='Aplicar' onclick="cerrar_changewindow('wcambiaidcategoria');" />
    
    </form>     
</div> 


<div id='wcambiaanaquel' name='wcambiaanaquel' class='wchanger'>
    Usted ha solicitado cambiar el Anaquel del producto.
    <br />   
    <br />  
    Anaquel del producto actual:
    <br />   
    <?php
        if (isset($ranaquel)) 
        {
            echo $ranaquel;
        }
    ?>
    <br />   
    <br />   
    Introduzca el nuevo Anaquel:
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method='post' target='presen'>
        <input type='text' name='cambiaranaquel' />       
        <input type='hidden' name="indice" value="<?php echo $indice ?>" />
        <input type='hidden' name='ean' value="<?php echo $ridproduct ?>" />
        <br /><br />
        <input type='reset' name='cancelar' value='Cancelar' onclick="cerrar_changewindow('wcambiaanaquel');" />
        <input type='submit' name='enviar' value='Aplicar' onclick="cerrar_changewindow('wcambiaanaquel');" />
    
    </form>     
</div> 


<div id='wcambiaprecio' name='wcambiaprecio' class='wchanger'>
    Usted ha solicitado cambiar el Precio del producto.
    <br />   
    <br />  
    Precio actual:
    <br />   
    <?php
        if (isset($rprecioactual)) {
            echo $rprecioactual;
        }
    ?>
    <br />   
    <br />   
    Introduzca el nuevo Precio:
    <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='post' target='presen'>
        <input type='text' name='cambiarprecio' />        
        <input type='hidden' name='indice' value='<?php echo $indice ?>' />
        <input type='hidden' name='ean' value='<?php echo $ridproduct ?>' />
        <br /><br />
        <input type='reset' name='cancelar' value='Cancelar' onclick="cerrar_changewindow('wcambiaprecio');" />
        <input type='submit' name='enviar' value='Aplicar' onclick="cerrar_changewindow('wcambiaprecio');" />
    
    </form>     
</div> 



<div id='wcambiadescripcion' name='wcambiadescripcion' class="wchanger">
    Usted ha solicitado cambiar la Descripción del producto.
    <br />   
    <br />  
    Descripción del producto actual:
    <br />   
    <?php
        if (isset($rdescripcion)) {
            echo $rdescripcion;
        }
    ?>
    <br />   
    <br />   
    Introduzca la nueva Descripción del producto:
    <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='post' target='presen'>
        <input type='text' name='cambiardescripcion' />        
        <input type='hidden' name='indice' value='<?php echo $indice ?>' />
        <input type='hidden' name='ean' value='<?php echo $ridproduct ?>' />
        <br />
        <br />
        <input type='reset' name='cancelar' value='Cancelar' onclick="cerrar_changewindow('wcambiadescripcion');" />
        <input type='submit' name='enviar' value='Aplicar' onclick="cerrar_changewindow('wcambiadescripcion');" />
    
    </form>     
    </div> 


    <div class="tablaorigenes">  
    <form action='procesa.php' method='post' target='presen'>
        <table border='1' cellpadding='5'  class='tablebrowser'>
            <tr>
                <td valign='middle'>
                   Agregue el Idproduct:
                </td>
                <td valign='middle'>
                    <input type='text' size='5' name='idproduct' value='<?php echo $ridproduct ?>' />
                </td>
                <td>
                    <input type='button' name='chidproduct' value='cambiar' onclick="abrir_changewindow('wcambiaidproduct')" />
                </td>
            </tr>
            <tr>
                <td valign='middle'>
                   Agregue el EAN:
                </td>
                <td>
                    <input type='text' size='12' name='eancode' value='<?php echo $reancode   ?>' />
                </td>
                 <td>
                    <input type='button' name='chidproduct' value='cambiar' onclick="abrir_changewindow('wcambiaeancode')" />
                </td>
            </tr>
            <tr>
                <td valign='middle'>
                   Agregue el Nombre:
                </td>
                <td>
                    <input type='text' size='35' name='nombreprod' value='<?php echo $rnombreprod ?>' />
                </td>
                 <td>
                    <input type='button' name='chidproduct' value='cambiar' onclick="abrir_changewindow('wcambianombreprod')" />
                </td>
            </tr>
            <tr>
                <td valign='middle'>
                   Agregue el Marca:
                </td>
                <td>
                    <input type='text' size='20' name='marcaprod' value='<?php echo $rmarcaprod ?>' />
                </td>
                 <td>
                    <input type='button' name='chidproduct' value='cambiar'  onclick="abrir_changewindow('wcambiamarcaprod')" />
                </td>
            </tr>
            <tr>
                <td valign='middle'>
                   Agregue el Presentaci�n:
                </td>
                <td>
                    <input type='text' size='10' name='presentitem' value='<?php echo $rpresentitem ?>' />
                </td>
                 <td>
                    <input type='button' name='chidproduct' value='cambiar'  onclick="abrir_changewindow('wcambiapresentitem')" />
                </td>
            </tr>
            <tr>
                <td valign='middle'>
                   Agregue el Contenido:
                </td>
                <td>
                    <input type='text' size='4' name='contentitem' value='<?php echo $rcontentitem ?>' />
                </td>
                 <td>
                    <input type='button' name='chidproduct' value='cambiar' onclick="abrir_changewindow('wcambiacontentitem')" />
                </td>
            </tr>
            <tr>
                <td valign='middle'>
                   Agregue el Categor�a:
                </td>
                <td>
                    <input type='text' size='3' name='categoria' value='<?php echo $ridcategoria ?>' />
                </td>
                 <td>
                    <input type='button' name='chidproduct' value='cambiar' onclick="abrir_changewindow('wcambiaidcategoria')" />
                </td>
            </tr>
            <tr>
                <td valign='middle'>
                   Agregue el Anaquel:
                </td>
                <td>
                    <input type='text' size='2' name='anaquel' value='<?php echo $ranaquel ?>' />
                </td>
                 <td>
                    <input type='button' name='chidproduct' value='cambiar' onclick="abrir_changewindow('wcambiaanaquel')" />
                </td>
            </tr>
            <tr>
                <td valign='middle'>
                   Agregue el Precio:
                </td>
                <td>
                    <input type='text' size='8' name='precioactual' value='$ <?php echo $rprecioactual ?>' />
                </td>
                 <td>
                    <input type='button' name='chidproduct' value='cambiar' onclick="abrir_changewindow('wcambiaprecio')" />
                </td>
            </tr>
            <tr>
                <td valign='middle'>
                   Agregue el Descripci�n:
                </td>
                <td>
                    <input type='text' size='25' name='descripcion' value='<?php echo $rdescripcion ?>' />
                </td>
                 <td>
                    <input type='button' name='chidproduct' value='cambiar' onclick="abrir_changewindow('wcambiadescripcion')" />
                </td>
            </tr>
            
        </table>
    
    <br />
    <br />
    <center>
        <input type='submit' name='terminar' value='Terminar' /> 
    </form>
    </center>
    
    </div>
    
<?php

if (isset($cerrar))
    {
    echo "<script language='javascript'>";
    echo "close_loader('loader')";
    echo "</script>";
    unset($cerrar);
    
     
 
//Botones de la parte inferior
if (isset($showbuttons)) 
    {
    echo "<br /><br />";
    echo "<center>";
    echo "<form action='".$_SERVER['PHP_SELF']."' method='post' target='presen'>";
    echo "<input type='submit' name='cancelar' value='Cancelar' />";
    echo "<input type='submit' name='modificar' value='<--------->' />";
    echo "<input type='submit' name='terminar' value='Terminar' />";  
    echo "</form>";  
    echo "</center>";
    }
    }
?>



<?php

    // Esta parte se procesa cuando se presiona el botón TERMINAR
    if ( isset($_POST['terminar']) ) 
        {  
                    
    ?>
    
    <script language="javascript">
        top.presen.document.location.href="presen.php";
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



</div>
</body>
</html>