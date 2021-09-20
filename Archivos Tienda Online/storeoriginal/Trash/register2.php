
<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        .box{
    background : red;
    padding: 20px;
    position: relative;
    width: 200px;
}
.overlay{
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    top: 0;    
    background: rgba(0,0,0,0.6);
    visibility: hidden;
    opacity: 0;
    z-index: 1;
}

.box input {
    position: absolute;
    visibility: hidden;
    opacity: 0;
    width: 50%;
    top: 0;
    left: 50%;
    margin-left: -25%;
    z-index: 2;
}

.box:hover .overlay,
.box:hover input,
.box input:focus,
.box input:focus + .overlay
{
    visibility: visible;
    opacity: 1;
}
    </style>
	
</head>
<body>

 
<div class="box">
    <input/>
    <div class="overlay"></div>
LOREM IPSUM LOREM IPSUM <br/>
LOREM IPSUM LOREM IPSUM LOREM IPSUM
</div>
</body>
</html>

