<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if (!isset($_SESSION['valid_user']))
{
    $_SESSION['valid_user'] = "anonymous";
    $_SESSION['server'] = 'localhost';
    $_SESSION['user_id'] = 'anonymous';
    $_SESSION['user_pass'] = 'anonymous';
    $_SESSION['dbase'] = 'carboncopy';
}


?>
