<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$message = "";
        
if (isset($_SESSION['valid_user']) && $_SESSION['valid_user'] != 'anonymous')
{
    $message = "Bienvenid@ <span>".$_SESSION['valid_user']."</span>";
}
else
{
    $message = "Bienvenid@ a nuestra tienda virtual";
}

?>
