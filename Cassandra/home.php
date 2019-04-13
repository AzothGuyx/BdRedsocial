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
<link rel="stylesheet" type="text/css" media="screen" href="style.css">
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
// Documentaci�n en https://datastax.github.io/php-driver/features
$cluster   = Cassandra::cluster()
               ->withContactPoints('127.0.0.1')
               ->build();
// Seleccionar la base de datos
$session   = $cluster->connect("redsocial");


/* ==--> Aqui ustede debe validar el usuario*/
// Documentaci�n en https://datastax.github.io/php-driver/features/#executing-queries
// Documentaci�n en https://datastax.github.io/php-driver/features/simple_statements/

//$query = 'SELECT cateroria_ppal,fecha_ultimo_ingreso ... FROM ... WHERE ... usuario='.$login;
$query = 'SELECT usuarios_nombre, ultingreso, categorias_nombre FROM usuarios WHERE nickname='.'\''.$login.'\'';
//echo $query;
$result = $session->execute($query);
// Se recupera el primer registro
$encontro_informacion_usuario = 1;

foreach ($result as $row) {
	$encontro_informacion_usuario = 0;
		$nombre = $row['usuarios_nombre'];
    $categria_ppal = $row['categorias_nombre'];
		$fecha_ultimo_ingreso = $row['ultingreso'];
	break;
}
if( $encontro_informacion_usuario == 1) {
	echo "<H3>Usuario No encontrado</H3>";
	exit(0);
}

//Optener las categorias secundarias
$query = 'SELECT categorias_nombre from catsecun where nickname='.'\''.$login.'\'';
$result = $session->execute($query);

$cont = 0;
$tiene_catsecun = 1;
foreach($result as $row){
	$tiene_catsecun = 0;
	$catsecun[$cont] = $row['categorias_nombre'];
	$cont = $cont + 1;
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

	<hr>
	<!-- Lista de Eventos -->	
	<?php
	echo "<b>Lista de eventos</b>";
	$query = 'SELECT feevento, eventos_id, dsevento, nasistentes FROM eventos WHERE dummy=2 and feevento>'.'\''.$fecha_ultimo_ingreso.'\' ORDER BY feevento ASC';
	//echo $query;
	$result = $session->execute($query);
	echo '<table cellspacing="5">';
	foreach ($result as $row) {
		//echo "<!-- Boton de asistire -->"
		//printf("<tr><td>\"%s\"</td><td>\"%s\"</td><td>\"%s\"</td></tr>\n", 'Nro asistentes '.$row['nasistentes'], $row['dsevento'], date('m/d/Y H:i:s' ,$row['feevento']->time()))
		echo	'<tr>
					<td>'.'Nro asistentes ( '.$row['nasistentes'].' ) </td><td>'.$row['dsevento'].'</td>
					<td>'.date('m/d/Y H:i:s' ,$row['feevento']->time()).'</td>
					<td>
						<form methon="get" action="agenda.php">
							<input type="hidden" name="eventos_id" value="'.$row['eventos_id'].'">
							<input type="hidden" name="feevento" value="'.$row['feevento'].'">
							<input type="hidden" name="dsevento" value="'.$row['dsevento'].'">
							<input type="hidden" name="nickname" value="'.$login.'">
							<input class="button mi_color" type="submit" value="Asistir">
						</form>
					</td>
				</tr>';
	}
	echo "</table>";
	// Boton de consultar los eventos que estoy matriculado
	echo	'<br>
			<a href="agenda.php?nickname='.$login.'"><button class="button mi_color">Asistencias</button></a>
			<hr>';

	// Lista de Publicaciones
	echo "<b>Lista de publicaciones</b>";
	$query = 'SELECT publicaciones_id, dspubli, likes, categorias_nombre FROM publicaciones WHERE categorias_nombre='.'\''.$categria_ppal.'\'';
	//echo $query;
	$result = $session->execute($query);
	echo '<table cellspacing="5">';

	foreach ($result as $row) {
		echo	'<tr>
						<td>Nro likes ( '.$row['likes'].' )</td>
						<td>'.$row['dspubli'].'</td>
						<td>
							<form method="get" action="like.php">
								<input type="hidden" name="publicaciones_id" value="'.$row['publicaciones_id'].'">
								<input type="hidden" name="categorias_nombre" value="'.$row['categorias_nombre'].'">
								<input type="hidden" name="dspubli" value="'.$row['dspubli'].'">
								<input class="button mi_color" type="submit" value="Like">
							</form>
						</td>
				</tr>';
	}
	
	if ($tiene_catsecun == 0){
		for ($i = 0; $i < count($catsecun); $i++){
			$query = 'SELECT publicaciones_id, dspubli, likes, categorias_nombre FROM publicaciones WHERE categorias_nombre='.'\''.$catsecun[$i].'\'';
			
			$result = $session->execute($query);

			foreach ($result as $row) {
				echo	'<tr>
								<td>Nro likes ( '.$row['likes'].' )</td>
								<td>'.$row['dspubli'].'</td>
								<td>
									<form method="get" action="like.php">
										<input type="hidden" name="publicaciones_id" value="'.$row['publicaciones_id'].'">
										<input type="hidden" name="categorias_nombre" value="'.$row['categorias_nombre'].'">
										<input type="hidden" name="dspubli" value="'.$row['dspubli'].'">
										<input class="button mi_color" type="submit" value="Like">
									</form>
								</td>
						</tr>';
			}
		}
	}
	echo "</table>";

	echo '<a href="publicar.php?categoria_ppal='.$categria_ppal.'"><button class="button mi_color">Publicar</button></a>';

	echo "<hr>";
	echo $nombre. " - ";
	echo date('m/d/Y H:i:s' , $fecha_ultimo_ingreso->time());
	echo " - ".$categria_ppal;
	?>
</body>
</html>