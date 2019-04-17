<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agenda</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="./style.css" type="text/css" media="all" />
</head>
<body>
<!--Revisión de las agendas del usuario-->
    <?php
    /*Se recuperan los argumentos*/
// Usuario que se logeo
if( isset( $_GET["login"] ) ){
	$login = htmlspecialchars($_GET["login"]);
} else {
	echo "<H3>Falta el argumento login</H3>";
	exit(0);
}
    //conexion a BD
$mysqli  = new mysqli('localhost', 'root', '','redes_sociales');
if ($mysqli->connect_errno) {
	echo "Fall� la conexi�n a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	exit(0);


//obteniendo parametros de header_remov   
$nickname = htmlspecialchars($_GET['nickname']);
?>
</body>
</html>