/* ---------- Script para el Ticker ------------------------ */

var dias, meses, fecha, dia, mes, mensaje, i, pos, mitexto;
dias=new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
meses=new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
fecha=new Date();
dia=dias[fecha.getDay()];
mes=meses[fecha.getMonth()];
mensaje = "Hoy es " + dia + " " + fecha.getDate() + " de " + mes + " de " + fecha.getYear();;
i=0; pos=0;
mitexto=new Array();
   mitexto[0] = "Hola, Bienvenidos al Sitio...";
   mitexto[1] = "donde conocerá lo mejor";
   mitexto[2] = "de la 3 veces Heroica...";
   mitexto[3] = mensaje;

function maquina_escribir() {
   if ( pos <= mitexto[i].length ) { document.forms['form1'].campotexto.value=mitexto[i].substring(0, pos) + "";
                                     pos++;
                                     setTimeout ("maquina_escribir()",30);
                                    }
                  else         { pos=0;
                                 if ( i<3 ) { i++; }
                                                    else { i=0; }
                                 setTimeout ("maquina_escribir()",1300);
                                }
                            }



/* ---------- Script para imagen de sustitución de los menús ------------------------ */


       boton1 = new Image(65,28); boton1.src="botones/menu1.jpg"
       boton2 = new Image(65,28); boton2.src="botones/menu2.jpg"
       boton3 = new Image(65,28); boton3.src="botones/menu3.jpg"
       boton4 = new Image(65,28); boton4.src="botones/menu4.jpg"
       boton5 = new Image(65,28); boton5.src="botones/menu5.jpg"
       boton1s = new Image(65,28); boton1s.src="botones/menu1s.jpg"
       boton2s = new Image(65,28); boton2s.src="botones/menu2s.jpg"
       boton3s = new Image(65,28); boton3s.src="botones/menu3s.jpg"
       boton4s = new Image(65,28); boton4s.src="botones/menu4s.jpg"
       boton5s = new Image(65,28); boton5s.src="botones/menu5s.jpg"


/* ---------- Script para mostrar menús ------------------------------------------- */


        function abre_menu1() {
                       top.dos.document.all['menu1'].style.visibility="visible";
          }

        function abre_menu2() {
                       top.dos.document.all['menu2'].style.visibility="visible";
          }

        function abre_menu3() {
                       top.dos.document.all['menu3'].style.visibility="visible";
          }

        function abre_menu4() {
                       top.dos.document.all['menu4'].style.visibility="visible";
          }

        function abre_menu5() {
                       top.dos.document.all['menu5'].style.visibility="visible";
          }

        function close_menu1() {
                       top.dos.document.all['menu1'].style.visibility="hidden";
          }

        function close_menu2() {
                       top.dos.document.all['menu2'].style.visibility="hidden";
          }

        function close_menu3() {
                       top.dos.document.all['menu3'].style.visibility="hidden";
          }

        function close_menu4() {
                       top.dos.document.all['menu4'].style.visibility="hidden";
          }

        function close_menu5() {
                       top.dos.document.all['menu5'].style.visibility="hidden";
          }



/*----------------------------- Script del Banner ---------------------------------------- */

var banner, nr, total;
banner = new Array("botones/b0.jpg","botones/b1.jpg","botones/b2.jpg","botones/b3.jpg","botones/b4.jpg","botones/b5.jpg","botones/b6.jpg","botones/b7.jpg","botones/b8.jpg","botones/b9.jpg","botones/b10.jpg","botones/b11.jpg","botones/b12.jpg","botones/b13.jpg","botones/b14.jpg");

nr=0;
total=banner.length;
function bann () {
                    var largo=1500;
                    if ( nr==total ) {  nr=0; }
                    document.images['anuncio'].src=banner[nr];
                    if ( nr>0 ) {  largo=100; }
                    nr++;
                    setTimeout("bann()",largo);
                  }


/*  ------------------------- Script de los Videos --------------------------------------  */


  var m=1;
  function cambia() {

           if ( m==0 ) {  document.all['vid1'].style.visibility="hidden";
                          document.all['vid2'].style.visibility="hidden";
                          document.all['vid3'].style.visibility="hidden";
                          document.all['vid0'].style.visibility="visible";
                        }
            if ( m==1 ) { document.all['vid0'].style.visibility="hidden";
                          document.all['vid2'].style.visibility="hidden";
                          document.all['vid3'].style.visibility="hidden";
                          document.all['vid1'].style.visibility="visible";
                        }
            if ( m==2 ) { document.all['vid0'].style.visibility="hidden";
                          document.all['vid1'].style.visibility="hidden";
                          document.all['vid3'].style.visibility="hidden";
                          document.all['vid2'].style.visibility="visible";
                        }
            if ( m==3 ) { document.all['vid0'].style.visibility="hidden";
                          document.all['vid1'].style.visibility="hidden";
                          document.all['vid2'].style.visibility="hidden";
                          document.all['vid3'].style.visibility="visible";
                        }

             m++;
             if ( m <= 3 ) {
                             setTimeout('cambia()',5000);
                            }
                       else {
                              m=0;
                              setTimeout('cambia()',5000);
                            }
        }

/* ----------------   Script de ventanas musicales  --------------------------------------- */


          function abretigre() {
                        var tigrew;
                        tigrew=window.open("","tigre","width=160, height=50, left=538, top=100");
                        tigrew.document.write("<html><head><title>Folklor</title></head><body bgcolor=#009933>");
                        tigrew.document.write("<h5><font face='Verdana, Arial' color=white>");
                        tigrew.document.write("Canción Típica #1:<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>El Tigre</i>");
                        tigrew.document.write("</font></h5>");
                        tigrew.document.write("<script language='javascript' type='text/javascript'>");
                        tigrew.document.write("location.href='musica/tigre.wav'");
                        tigrew.document.write("</script></body></html>");

                               }

           function abrevamosat() {
                        var tigrew;
                        tigrew=window.open("","tigre","width=160, height=50, left=538, top=100");
                        tigrew.document.write("<html><head><title>Folklor</title></head><body bgcolor=blue>");
                        tigrew.document.write("<h5><font face='Verdana, Arial' color=white>");
                        tigrew.document.write("Canción Típica #2: <p><i>Vamos a Tabasco</i>");
                        tigrew.document.write("</font></h5>");
                        tigrew.document.write("<script language='javascript' type='text/javascript'>");
                        tigrew.document.write("location.href='musica/vamosat.wav'");
                        tigrew.document.write("</script></body></html>");

                               }

           function abrepceiba() {
                        var tigrew;
                        tigrew=window.open("","tigre","width=160, height=50, left=538, top=100");
                        tigrew.document.write("<html><head><title>Folklor</title></head><body bgcolor=red>");
                        tigrew.document.write("<h5><font face='Verdana, Arial' color=white>");
                        tigrew.document.write("Canción Típica #3: <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>Puerto Ceiba</i>");
                        tigrew.document.write("</font></h5>");
                        tigrew.document.write("<script language='javascript' type='text/javascript'>");
                        tigrew.document.write("location.href='musica/pceiba.wav'");
                        tigrew.document.write("</script></body></html>");

                               }