<!DOCTYPE html>
<html lang="es">
<head>
   <meta http-equiv=Content-Type content="text/html; charset=ISO-8859-1" />

<style>

.tablebrowser 
        {
        background-color: white;
        color: gray;
        font-family: verdana, arial;
        }
         
.tablaorigenes 
        {
        position: absolute;
        top: 50px;
        left: 10px;
        }
         
.cuadro {
        position: absolute;
        left: 150px;
        top: 0px;
        background-color: white;
        border-color: black;
        border-style: double;
        border-width:5px;
        color: black;
        width: 950px;
        height: 600px;
        }
         
.coloca {position:absolute;
         left: 620px;
         top: 350px;
         font-size: 25pt;
        
         }

.titles {
         font-size: 15pt;
         font-weight: 700;
        }
         
.warn {  
        position:absolute;
         left: 220px;
         top: 100px;
         background-color: red;
         border-color: white;
         border-style: double;
         border-width:10px;
         color: white;
         width: 500px;
         height: 200px;
         font-size: 15pt;
         font-weight: 700;
         }

.bann_container { 
         position:absolute;
         left: 0px;
         top: 0px;
         background-color: white;
         width: 950px;
         height: 800px;
         visibility: visible;
         z-index:10;
         }

.banner {
        position:relative;
        top: 150px;
        z-index:10; 
        }
    
.wchanger {
         position:absolute;
         left: 505px;
         top: 50px;
         background-color: green;
         border-color: white;
         border-style: double;
         border-width:10px;
         color: white;
         width: 400px;
         height: 270px;
         font-family: verdana, arial;
         font-size: 12pt;
         font-weight: 700;
         visibility: hidden;
         z-index: 5;
     }

</style>

<script language="JavaScript"> 

function regresa() 
    {
    location.href="naver.php";
    }

function abre_loader(id)  {
        top.presen.document.getElementById(id).style.visibility = 'visible';
    }
    
function close_loader(id)    {
        top.presen.document.getElementById(id).style.visibility = 'hidden';
    }


function abrir_changewindow(id) 
    {
        top.presen.document.getElementById(id).style.visibility = 'visible';
        
        var wtitles = new Array('wcambiaidproduct', 'wcambiaeancode', 'wcambianombreprod', 'wcambiamarcaprod', 'wcambiapresentitem', 'wcambiacontentitem', 'wcambiaidcategoria', 'wcambiaanaquel', 'wcambiaprecio', 'wcambiadescripcion');
        var long_wtitle = wtitles.length;
        var i = 0;
                
        for (i = 0; i<long_wtitle; i++) {
            if (wtitles[i] == id) 
            {
                top.presen.document.getElementById(id).style.visibility = 'visible';
            }
            else 
            {
                top.presen.document.getElementById(wtitles[i]).style.visibility = 'hidden';
            }
        } 
     }
     
    
function cerrar_changewindow(id) 
    {
        top.presen.document.getElementById(id).style.visibility = 'hidden';
        
    }

function envia_formindice(indice) 
        {
            document.formindice.indice.value = indice;
            //alert(indice);
            top.naver.document.forms['buscafield'].indice.value = parseInt(indice, 10);
            document.formindice.submit(); 
        }
</script>

</html>