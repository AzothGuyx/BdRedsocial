<?PHP
/*
	Creado por Sergio Alvarez
	Version 1.0 - 2019/03/30
	Tecnicas avanzadas de base de datos - UDEM
	
  _   _  ____        __  __           _ _  __ _                
 | \ | |/ __ \      |  \/  |         | (_)/ _(_)               
 |  \| | |  | |     | \  / | ___   __| |_| |_ _  ___ __ _ _ __ 
 | . ` | |  | |     | |\/| |/ _ \ / _` | |  _| |/ __/ _` | '__|
 | |\  | |__| |     | |  | | (_) | (_| | | | | | (_| (_| | |   
 |_| \_|\____/      |_|  |_|\___/ \__,_|_|_| |_|\___\__,_|_|   
                                                               

	Notas: 
	* No modificar. Sacar copia y renombrar 
	* Esto es un ejemplo, que le ayude a hacer su trabajo
*/
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Home Practica - Cassandra</title>
<style type="text/css">
body {
	background: #ededed;
	width: 900px;
	margin: 30px auto;
	color: #999;
}
p {
	margin: 0 0 2em;
}
h1 {
	margin: 0;
}
a {
	color: #339;
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
div {
	padding: 20px 0;
	border-bottom: solid 1px #ccc;
}

/* button 
---------------------------------------------- */
.button {
	display: inline-block;
	zoom: 1; /* zoom and *display = ie7 hack for display:inline-block */
	*display: inline;
	vertical-align: baseline;
	margin: 0 2px;
	outline: none;
	cursor: pointer;
	text-align: center;
	text-decoration: none;
	font: 14px/100% Arial, Helvetica, sans-serif;
	padding: .5em 2em .55em;
	text-shadow: 0 1px 1px rgba(0,0,0,.3);
	-webkit-border-radius: .5em; 
	-moz-border-radius: .5em;
	border-radius: .5em;
	-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
	-moz-box-shadow: 0 1px 2px rgba(0,0,0,.2);
	box-shadow: 0 1px 2px rgba(0,0,0,.2);
}
.button:hover {
	text-decoration: none;
}
.button:active {
	position: relative;
	top: 1px;
}

.bigrounded {
	-webkit-border-radius: 2em;
	-moz-border-radius: 2em;
	border-radius: 2em;
}
.medium {
	font-size: 12px;
	padding: .4em 1.5em .42em;
}
.small {
	font-size: 11px;
	padding: .2em 1em .275em;
}


/* mi_color */
.mi_color {
	color: #fef4e9;
	border: solid 1px #da7c0c;
	background: #f78d1d;
	background: -webkit-gradient(linear, left top, left bottom, from(#faa51a), to(#f47a20));
	background: -moz-linear-gradient(top,  #faa51a,  #f47a20);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#faa51a', endColorstr='#f47a20');
}
.mi_color:hover {
	background: #f47c20;
	background: -webkit-gradient(linear, left top, left bottom, from(#f88e11), to(#f06015));
	background: -moz-linear-gradient(top,  #f88e11,  #f06015);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#f88e11', endColorstr='#f06015');
}
.mi_color:active {
	color: #fcd3a5;
	background: -webkit-gradient(linear, left top, left bottom, from(#f47a20), to(#faa51a));
	background: -moz-linear-gradient(top,  #f47a20,  #faa51a);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#f47a20', endColorstr='#faa51a');
}

</style>
</head>

<body>
<H1 class="mi_color">Cassandra-Home</H1>
<div>

<?PHP
/*Se recuperan los argumentos*/
// Usuario que se logeo
if( isset( $_GET["login"] ) ){
	$login = htmlspecialchars($_GET["login"]);
} else {
	echo "<H3>Falta el argumento login</H3>";
	exit(0);
}


// Fecha de ultimo acceso -  para filtro. Valor igual a -1 (menos uno) indica que debe consultar y actualizar
if( isset( $_GET["filtro_fecha"] ) ){
	$filtro_fecha = htmlspecialchars($_GET["filtro_fecha"]);
} else {
	echo "<H3>Falta el argumento filtro_fecha</H3>";
	exit(0);
}



/* ==--> Aqui ustede debe hacer la conexion a la base de datos*/
// Documentación en https://datastax.github.io/php-driver/features
$cluster   = Cassandra::cluster()
               ->withContactPoints('127.0.0.1')
               ->build();
// Seleccionar la base de datos
$session   = $cluster->connect("CAMBIAR_ESTE_NOMBRE_CON_EL_NOMBRE_DEL_KEY_SPACE");

/* ==--> Aqui ustede debe validar el usuario*/
// Documentación en https://datastax.github.io/php-driver/features/#executing-queries
// Documentación en https://datastax.github.io/php-driver/features/simple_statements/

$query = 'SELECT cateroria_ppal,fecha_ultimo_ingreso ... FROM ... WHERE ... usuario='.$login;
//echo $query;
$result = $session->execute($query);
// Se recupera el primer registro
$encontro_informacion_usuario = 0;
foreach ($result as $row) {
	$encontro_informacion_usuario = 1;
    $categria_ppal = $row['cateroria_ppal'];
	$fecha_ultimo_ingreso = $row['fecha_ultimo_ingreso'];
	break;
}
if( $encontro_informacion_usuario == 1) {
	echo "<H3>Usuario No encontrado</H3>";
	exit(0);
}
?>

<H3>Home</H3>
	<!-- Sin Filtro por fecha -->
	<form name="q1" action="home.php" method="get">
		<!-- filtro_fecha con valor 0 indica que debe buscar todo -->
		<input type="hidden" name="filtro_fecha" value="0" >
		<input type="hidden" name="login" value="<?php echo $login;?>" >
		<button class="button mi_color">Sin Filtro</button>
	</form>

	<!-- Lista de Eventos -->	
	<?php
	$query = 'SELECT columna_a, columna_b FROM tabla WHERE ....';
	//echo $query;
	$result = $session->execute($query);
	echo "<table>";
	foreach ($result as $row) {
		//echo "<!-- Boton de asistire -->"
		printf("<tr><td>\"%s\"</td><td>\"%s\"</td></tr>\n", $row['columna_a'], $row['columna_b']);
	}
	echo "</table>";
	?>

	<!-- Boton de consultar los eventos que estoy matriculado -->
	
	<!-- Lista de Publicaciones -->

</body>
</html>