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
        <META http-equiv=Content-Type content="text/html; charset=ISO-8859-1" />
        <link href="posstyles.css" rel="stylesheet" type="text/css" />
    </head>

    <body>

        <div class="cuadro">
   
            <img src="botones/logo.png" width="720" height="400" />
      
        </div>
        
    </body>
</html>