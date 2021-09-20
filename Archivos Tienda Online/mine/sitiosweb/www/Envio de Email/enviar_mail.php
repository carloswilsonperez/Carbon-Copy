<html>
<body>

<?php

   //Aqui se usa la función mail() de PHP para enviar correo.
   //es necesario tener "encendido" el servidor de correo que escucha
   //en el puerto 25
   //en Mercury es el del servidor SMTP. Finalmente, el escript
   //guarda en el archivo "visit.txt" el contenido del mensaje, el cual 
   //se puede ver más comodamente usando el archivo "leer.php".


   $sendTo = "carlos@prueba.com";
   $subject=$_POST['asunto'];
   $headers = "From: "." Campaña 2009";
   $headers .= "<".$_POST['email'].">\r\n";
   $headers .= "Reply To: ".$_POST['email'];
   $message = $_POST['cuerpo'];
   mail ($sendTo, $subject, $message, $headers);
   echo "&estado=Mensaje Enviado!"; 
   
   if (isset($message)) {
        $fp = fopen("visit.txt", "a");
        fwrite($fp, nl2br($message)."<p>\n");
        fclose($fp);
   }
?>
</body>
</html>