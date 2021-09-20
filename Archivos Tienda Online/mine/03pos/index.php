<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
    
          document.write("<html><frameset cols='230," + eval(ancho - 155) + "', border=0 frameborder=0>");
          document.write("<frame src='botones.html' name='botones' scrolling='no' noresize>");
          document.write("<html><frameset rows='150, *' border=0 frameborder=0>");
          document.write("<frame src='pos/naver.php' name='naver' scrolling='no' noresize>");
          document.write("<frame src='pos/presen.php' name='presen' noresize>");
          document.write("</frameset>");
          document.write("</frameset>");
          document.write("</html>");
        }
                

    </script>
    <body onLoad='info()'>
        
        
    </body>
</html>
