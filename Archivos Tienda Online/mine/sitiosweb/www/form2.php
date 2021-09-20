<html>
<body>
<h1>Hola!</h1>
<?php
    $nombre = "\"Carlos\"";

    //Aqui se muestra como pasar una variable PHP (en este
    //caso, se trata de $nombre, a JavaScript.
    //Extendiendo esto, podemos hacer lo mismo, pero
    //siguiendo la ruta FLASH --> PHP ---> JavaScript.
    //OJO: FLASH puede comunicarse DIRECTAMENTE con JavaScript.

    PRINT "<SCRIPT LANGUAGE=Javascript>
               var javaVar = 'Hola ' + $nombre;
               alert(javaVar);
           ";
 
?></SCRIPT>
</body>
</html>