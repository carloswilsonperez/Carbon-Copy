<!DOCTYPE html>

<html>
    <head>

    <title>
            
</title>
</head>
<script language="JavaScript" type="text/javascript">


          
function info() {
        
    var alto, ancho, nombre, sisop, navegador, sialto, siancho, sisisop, sinombre, sinavegador;
    alto = screen.height;            sialto="no";
    ancho = screen.width;            siancho="no";
    sisop = navigator.platform;      sisisop="no";
    nombre = navigator.appName;      sinombre="no";
    navegador = navigator.userAgent; sinavegador="no";
    parent.window.scrollwidth = 250;
    window.moveTo(0,0);           
    
          document.write("<html><frameset cols='190," + eval(ancho - 380) + ", 190' border=0 frameborder=0>");
          document.write("<frame src='izquierda.html' name='left' noresize>");
          document.write("<html><frameset rows='150,*' border=0 frameborder=0>");
          document.write("<frame name='maquina' src='maquina.php' name='maquina' scrolling='no' noresize>");
          document.write("<html><frameset cols='200, *' border=0 frameborder=0>");
          document.write("<frame src='botones.php' name='botones' scrolling='no' noresize>");
          document.write("<frame src='presen.php' name='presen' noresize>");
          document.write("</frameset>");
          document.write("</frameset>");
          document.write("<frame src='derecha.php' name='right' noresize>");
          document.write("</frameset>");
          document.write("</html>");
        }
              

    </script>
    <body onLoad='info()'>
    </body>
</html>
