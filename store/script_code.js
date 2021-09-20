window.onload = function() {
    update_cart();
    update_username(username);
}

function update_cart()
            {
                var content = "<table><tr><td rowspan = '2' width='80'><a href='viewcart.php'><img src='botones/carrito1.png' width='40' height='40' /></a></td><td width='80'>" + total_articles + "</td><td rowspan='2' width='80'>" + total_money + "</td></tr><tr><td>  art&iacute;culo(s)</td></tr></table>";
               var div = document.getElementById('right-upper-box');
                    
                div.innerHTML = content;
            }
            
function update_username(message) {
    var div = document.getElementById('username');
                   alert(message); 
    if (message == 'Bienvenid@ a nuestra tienda virtual') {
        div.innerHTML = message;
    }
    else {
        div.innerHTML = message + "<a href='endUserSession.php'>&nbsp;(Salir)</a>";
    }            
}
            
function show_v_home() {
    document.getElementById('home').src = 'botones/home2.png';
}

function show_b_home() {
    document.getElementById('home').src = 'botones/home.png';
}
                
function send_search() {
    var word = top.maquina.document.forms['searcher'].search.value;
    
    if (word != "") {
        document.forms['sendsearch'].pagina.value = 1;
        document.forms['sendsearch'].subcat.value = "turn_on_search";
        document.forms['sendsearch'].search_term.value = word;
        document.forms['sendsearch'].submit();
    }               
}
                
         
function envia(categ) {
    document.forms['catalogo'].categoria.value = categ;
    document.forms['catalogo'].pagina.value = 1;
    document.forms['catalogo'].submit();
}

function pagindex(page, subcat) {
    document.forms['indexman'].pagina.value = page;
    document.forms['indexman'].subcat.value = subcat;
    document.forms['indexman'].submit();
}

function prev_item(itemform) {
    var itemno = document.forms[itemform].elements[0].value;
    itemno--;

    if (itemno < 1) {
        itemno = 1;
    }
            
    if (itemno < 10) {
        document.forms[itemform].elements[0].value = "   " + itemno;     
        }
    else if (itemno < 100) {
        document.forms[itemform].elements[0].value = "  " + itemno;
        }
    else {
        document.forms[itemform].elements[0].value = " " + itemno;
    }
}

                        
function next_item(itemform, cant) {
    var itemno = document.forms[itemform].elements[0].value;
    itemno++;

    if (itemno > cant) {
        itemno = cant;
        }
                                
    if (itemno < 10) {
        document.forms[itemform].elements[0].value = "   " + itemno;     
        }
    else if (itemno < 100) {
        document.forms[itemform].elements[0].value = "  " + itemno;
        }
    else {
        document.forms[itemform].elements[0].value = " " + itemno;
    }			
}

function item_to_cart(itemform) {
    //se obtiene la cantidad de artículos a colocar
    var itemno = document.forms[itemform].elements[0].value;

    //se escriben el código de producto y la cantidad pedida en el formulario de envio
    document.forms['additems'].ean.value = itemform;
    document.forms['additems'].quantity.value = itemno;
    document.forms['additems'].submit();
}

function modify_cart(ean, operation) {
    document.forms['delform'].ean.value = ean;
    document.forms['delform'].sysoperation.value = operation;
    document.forms['delform'].submit();
}
            
function envia_seguir() {
    document.forms['seguir'].submit();
}

function envia_finalizar()  { //coloca_pedido.php
    //se obtiene la cantidad de artículos a colocar
    document.forms['finalizar'].submit();
}


function change1(param) { //register.php
    var element = 'asterisk' + param;
    document.getElementById(element).style.color = 'green';
}

function change_asterisk(param)  {//contacto.php
    var element = 'asterisk' + param;
    document.getElementById(element).style.color = 'green';
}

if (document.getElementById("login")) {
    update_username(message);
}
