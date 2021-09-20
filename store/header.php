<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="toplogo">
            <table >
               <tr>
               <td ><img src="botones/logo.png" height="80" width="150"></td>
               </tr>
            </table>
        </div>


        <div class='topmenu'>
            <table>
                <tr>
                <td>
                    <a href='index.php'> <img src='botones/home.png' id='home' width='18' height='18' onmouseover='show_v_home();' onmouseout='show_b_home();'></a>
                </td>
                <td>
                    <a href='login.php'>Ingresar</a>
                </td>
                <td>
                    <a href='register.php'>Crear/ Ver Cuenta</a>
                </td>
                <td>
                    <a href='contacto.php'>Contacto </a>
                </td>
                </tr>
            </table>
        </div>

        <form class="form-wrapper" name='searcher' id='searcher'>
            <input type="text" id="search" placeholder="BÃºsqueda rÃ¡pida ..." required>
            <input type="submit" value="Buscar" id="submit" onClick="javascript:send_search();">
        </form>

        <div class='ayudatel'>
            <img src="botones/call5.jpg" width="196" height="30">
        </div>

        <div class='carrito' id='carrito'></div>
        
        
         <form action="catalogo.php" id="sendsearch"  name="sendsearch" method="get" target="presen">
                <input type="hidden" id="subcat" name="subcat">
                <input type="hidden" id="pagina" name="pagina">
                <input type='hidden' id='search_term' name='search_term'>
         </form>
        
        <div class='welcome' id='username'></div>

