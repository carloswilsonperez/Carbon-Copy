<!DOCTYPE html>
<html lang="es">

<head>
     <META http-equiv=Content-Type content="text/html; charset=ISO-8859-1" />
<style>

table {background-color: navy;
       color: white;
       font-family: verdana, arial;
       font-size: 12pt;
       }
         
.cuadro 
	{
	position:absolute;
        left: 0px;
        top: 0px;
        background-color: white;
        border-color: black;
        border-style: double;
        border-width:5x;
        color: black;
        width: 800px;
        height: 600px;
        }
         
.coloca 
	{
	position:absolute;
        left: 620px;
        top: 350px;
        font-size: 25pt;
        }

       
</style>

</head>

<body leftmargin="0" topmargin="0" bgcolor="gray">

<form id='login' action='login2.php' method='post' target='presen'>
<fieldset>
<legend>login</legend>
<input type='hidden' name='submitted' id='submitted' value='1' />

<label for='username'>UserName*:</label>
<input type='text' name='username' id='username' maxlength='50' />

<label for='password'>Password*:</label>
<input type='password' name='password' id='password' maxlength='10' />

<input type='submit' name='Submit' value='submit' />
</fieldset>
</form>


            
</body>
</html>		