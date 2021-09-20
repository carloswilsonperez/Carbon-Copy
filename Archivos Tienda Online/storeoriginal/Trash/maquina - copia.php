<?php
session_start();

if (!isset($_SESSION['valid_user']))
{
    $_SESSION['valid_user'] = "anonymous";
    
}


if (!isset($_SESSION['total_articles']))
{
    $_SESSION['total_articles'] = 0;
    $_SESSION['total_money'] = 0;
}

?>




<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" lang="eS">
    <!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="es"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="es"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="es"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="es"> <!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title></title>
        <link rel="stylesheet" href="css/style2.css" />
    
    
    <style>
    
    .titulo  {
                font-family: arial;
                font-size: 10pt;
                color:gray;
                font-weight:400;
             }
    .welcome {
                position:absolute;
                top: 130px;
                left: 202px;
                font-family: arial;
                font-size: 10pt;
                color:gray;
                font-weight:400;
             }
            
    .ayudatel 
            {
            position:absolute;
            top: 60px;
            left: 400px;
            font-family: arial;
            font-size: 10pt;
            color:gray;
            font-weight:400;
            }
            
     .carrito 
            {
            position:absolute;
            top: 60px;
            left: 750px;
            width: 240px;
            height: 120px;
            background-color: white;

            }

     .carrito table
     {
         border-width: 5px;
         border-color: red;
         font-family: arial;
         font-size: 14pt;
         font-weight:500;
     }
                 
    .carrito td
        {
        font-family: 'Lucida Grande', Tahoma, Verdana, sans-serif; 
        color: rgb(163, 73, 164);
        text-align: center;
        vertical-align: middle;


        }

    .topmenu
        {
        position:absolute;
        top: 10px;
        left: 5px;
        font-family: verdana;
        width: 950px;
        font-size: 9pt;
    }
    
    .topline {
        position:absolute;
        top: 15px;
        left: 10px;
        width: 970px;
        height: 40px;
        border-bottom: solid 1px gray;
        z-index: -1;
    }
    
    .toplogo {
        position:absolute;
        top: 55px;
        left: 5px;
    }
   .form-wrapper {
   
   }
   
   .form-wrapper #search {
   	width: 330px;
   	height: 20px;
   	padding: 10px 5px;
   	float: left;   
	position: absolute;
	left: 350px;
	top: 8px; 
   	font: bold 16px courier;
   	border: 1px solid #ccc;
   	-moz-box-shadow: 0 1px 1px #ddd inset, 0 1px 0 #fff;
   	-webkit-box-shadow: 0 1px 1px #ddd inset, 0 1px 0 #fff;
   	box-shadow: 0 1px 1px #ddd inset, 0 1px 0 #fff;
   	-moz-border-radius: 3px;
   	-webkit-border-radius: 3px;
   	border-radius: 3px;      
   }
   
   .form-wrapper #search:focus {
   	outline: 0; 
   	border-color: #aaa;
   	-moz-box-shadow: 0 1px 1px #bbb inset;
   	-webkit-box-shadow: 0 1px 1px #bbb inset;
   	box-shadow: 0 1px 1px #bbb inset;  
   }
   
   .form-wrapper #search::-webkit-input-placeholder {
      color: #999;
      font-weight: normal;
   }
   
   .form-wrapper #search:-moz-placeholder {
   	color: #999;
   	font-weight: normal;
   }
   
   .form-wrapper #search:-ms-input-placeholder {
           color: #999;
           font-weight: normal;
   } 
   
   .form-wrapper #submit 
   	{
   	position: absolute;
   	left: 690px;
   	top: 8px; 
   	float: right;    
   	border: 1px solid #00748f;
   	height: 42px;
   	width: 100px;
   	padding: 0;
   	cursor: pointer;
   	font: bold 15px Arial, Helvetica;
   	color: #fafafa;
   	text-transform: uppercase;    
   	background-color: #0483a0;
   	background-image: -webkit-gradient(linear, left top, left bottom, from(#31b2c3), to(#0483a0));
   	background-image: -webkit-linear-gradient(top, #31b2c3, #0483a0);
   	background-image: -moz-linear-gradient(top, #eef2f5, #0483a0);
   	background-image: -ms-linear-gradient(top, #eef2f5, #0483a0);
   	background-image: -o-linear-gradient(top, #eef2f5, #0483a0);
   	background-image: linear-gradient(top, #31b2c3, #0483a0);
   	-moz-border-radius: 3px;
   	-webkit-border-radius: 3px;
   	border-radius: 3px;      
   	text-shadow: 0 1px 0 rgba(0, 0 ,0, .3);
   	-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 1px 0 #fff;
   	-webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 1px 0 #fff;
   	box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 1px 0 #fff;
   }
     
   .form-wrapper #submit:hover, 
   .form-wrapper #submit:focus {		
   	background-color: #31b2c3;
   	background-image: -webkit-gradient(linear, left top, left bottom, from(#0483a0), to(#31b2c3));
   	background-image: -webkit-linear-gradient(top, #eef2f5, #31b2c3);
   	background-image: -moz-linear-gradient(top, #eef2f5, #31b2c3);
   	background-image: -ms-linear-gradient(top, #eef2f5, #31b2c3);
   	background-image: -o-linear-gradient(top, #eef2f5, #31b2c3);
   	background-image: linear-gradient(top, #eef2f5, #31b2c3);
   }	
     
   .form-wrapper #submit:active {
   	outline: 0;    
   	-moz-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.5) inset;
   	-webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.5) inset;
   	box-shadow: 0 1px 4px rgba(0, 0, 0, 0.5) inset;    
   }
     
   .form-wrapper #submit::-moz-focus-inner {
   	border: 0;
   }
    
     a:link {text-decoration:none; color:black;}
     a:visited {text-decoration:none; color:navy;}
     a:hover {text-decoration:underline;}
     a:active {text-decoration:none;}
 
</style>


<body>
<div class="toplogo">
    <table >
       <tr>
       <td >
               <img src="botones/logo.png" height="100" width="180">

       </td>
	   <td align="center">
	             
               
	            
	   </td>
	   </tr>
    </table>
</div>
  

<div class=topmenu>
<table cellpadding="10">
  <tr>      
        <td style="border-right:1px solid black">
            <a href="presen.php" target="presen"> <img src="botones/home.png" width="18" heigth="18"></a>

        </td>
        <td style="border-right:1px solid black">
        	<a href="login.php" target="presen"> Ingresar</a>

        </td>
        <td align="center">
              	<a href="register.html" target='presen'> Crear/ Ver Cuenta</a>
        </td>
            
        
	 <td align="center">
	             	<a href="#"> &nbsp Contacto </a>
	        </td>
	
	 
	 </tr>      
</table>
 
</div>  

<form class="form-wrapper" >
	<input type="text" id="search" placeholder="B?squeda r?pida ..." required>
  	<input type="submit" value="go" id="submit">
</form> 
<div class='topline'>
   
</div>
<div class='ayudatel'>
    <img src="botones/call5.jpg" width="196" height="30">
</div>

<div class='carrito'>
    <table border='1' bordercolor='red'>
        
        <tr>
            <td rowspan = '2' width='80'><a href='viewcart.php' target='presen'><img src='botones/carrito1.png' width='40' height='40' /></a></td>
        </tr>
        <tr><td width='80'><?php echo $_SESSION['total_articles']; ?> </td><td rowspan='2' width='80'>$<?php echo $_SESSION['total_money']; ?></td></tr>
        <tr><td>  artículo(s)</td></tr>
    </table>
</div>

<?php 
    
    if (isset($_SESSION['valid_user']) && $_SESSION['valid_user'] != 'anonymous')
    {
        echo "<div class='welcome'>Bienvenid@ ".$_SESSION['valid_user']."<a href='endUserSession.php' target='presen'>&nbsp;(Salir)</a></div>";
    }
    else 
    {
        echo "<div class='welcome'>Bienvenid@ a nuestra p?gina ";
    } 
?>   
    
</body>
</html>