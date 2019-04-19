<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Home Practica - Cassandra</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="./style.css" type="text/css" media="all" />
</head>
<body>
<!--Revisión de las agendas del usuario-->
<?php

/*Se recuperan los argumentos*/
// Usuario que se logeo
    //conexion a BD
    $mysqli  = new mysqli('localhost', 'root', '','redes_sociales');
    if ($mysqli->connect_errno) {
        echo "Fall� la conexi�n a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        exit(0);
    }
?>
<?php
//obteniendo parametros de header_remov  
$idUsuario = htmlspecialchars($_GET['idUsuario']);
$idEvento = htmlspecialchars($_GET['idEvento']);
//insertar una nueva agenda con los parametros obtenidos
$query = 'INSERT INTO agenda (evento_id, usuario_id)
VALUES ('.$idEvento.','.$idUsuario.')';
$result = $mysqli->query($query);
echo '<h1>Has añadido este evento a tu agenda</h1>';
?>
</body>
</html>