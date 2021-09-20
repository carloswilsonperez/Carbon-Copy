<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

 <form action="subcategs.php" id="catalogo"  name="catalogo" method="post">
     <input type="hidden" id="categoria" name="categoria">
     <input type="hidden" id="pagina" name="pagina">
 </form>

<form action="catalogo.php" id="indexman"  name="indexman" method="get" target="presen">
    <input type="hidden" id="subcat" name="subcat">
    <input type="hidden" id="pagina" name="pagina">
</form>

<form id='additems' name='additems' action='derecha.php' method='post' target='right'>
    <input type="hidden" id="ean" name="ean" />
    <input type="hidden" id="quantity" name="quantity" />
</form>


