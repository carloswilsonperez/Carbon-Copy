<?php

session_start();

$_SESSION['delete_all'] = true;

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

