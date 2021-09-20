<?php
session_start();
if (isset($_SESSION['userid']))
{
    if ($_SESSION['userid'] == "carloswilsonperez@yahoo.com.mx" and $_SESSION['passwd'] == "admin") 
    {
        echo "Bienvenido! ".$_SESSION['userid'];
        echo "<br />";
        echo "Ha ingresado Usted a la página protegida";
        echo "<br />";   
    }
    else 
    {
        echo "Nombre no autorizado";    
        unset($_SESSION['userid']);
        echo "<html>";
        echo "<form action='index.php' method='post'>";
        echo "<input type='submit' value='Volver'>";
        echo "</form>";
        echo "</html>";
    }
}
else 
{
    echo "Debe autentificarse para ver esta página";    
    unset($_SESSION['userid']);
    echo "<html>";
    echo "<form action='index.php' method='post'>";
    echo "<input type='submit' value='Volver'>";
    echo "</form>";
    echo "</html>";
        
}
?>

<?php 

// get the product id

$eancode = $_GET['id'];

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}

if (isset($eancode))
{
    if (isset($_SESSION[$eancode]))
    {
        $_SESSION[$eancode]++;
        //array_push($_SESSION['cart'], $id);
        echo $_SESSION[$eancode];
        echo "<br />";
    }
    else
    {
     
        $_SESSION[$eancode] = 1; 
        echo $_SESSION[$eancode];
        echo "<br />";   
    }
    
}


?>

<!DOCTYPE HTML>
<html>
    <head>
        <script>
            function displayDate()
                {
                document.getElementById("demo").innerHTML=Date();
                }
        </script>
    </head>
    <body>
        <form action='pag1.php' method='post'>
            
            <input type="submit" id="return" name="return" value="Seguir Comprando" />
            
        </form>
        <div id="demo">
        </div>
        </div>
    </body>
</html>