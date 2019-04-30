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
<title>Home Practica - Mongo</title>
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
	color: #e9e9e9;
	border: solid 1px #555;
	background: #6e6e6e;
	background: -webkit-gradient(linear, left top, left bottom, from(#888), to(#575757));
	background: -moz-linear-gradient(top,  #888,  #575757);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#888888', endColorstr='#575757');
}
.mi_color:hover {
	background: #616161;
	background: -webkit-gradient(linear, left top, left bottom, from(#757575), to(#4b4b4b));
	background: -moz-linear-gradient(top,  #757575,  #4b4b4b);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#757575', endColorstr='#4b4b4b');
}
.mi_color:active {
	color: #afafaf;
	background: -webkit-gradient(linear, left top, left bottom, from(#575757), to(#888));
	background: -moz-linear-gradient(top,  #575757,  #888);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#575757', endColorstr='#888888');
}

</style>
</head>

<body>
<H1 class="mi_color">Mongo-Home</H1>
<div>

<?PHP
/*Se recuperan los argumentos*/
// Usuario que se logeo
$time_start = microtime(true);
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
// Documentaci�n https://www.php.net/manual/es/class.mongodb-driver-manager.php
try {
	$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
	$bulk = new MongoDB\Driver\BulkWrite;
	/* ==--> Aqui ustede debe validar el usuario*/
	// Documentaci�n en https://www.php.net/manual/es/mongodb-driver-manager.executequery.php

	
	$filter = ["nickname" => ['$eq' =>$login]];
	$options = [
		'maxTimeMS' => 1000
	];
	$query = new MongoDB\Driver\Query($filter, $options);
	//echo $query;
	/* ==--> Se ejecuta contra una base de datos y una colexion*/
	$result = $manager->executeQuery('RedSocial.Usuarios', $query);

	// Se recupera el primer registro
	$encontro_informacion_usuario = 0;

	foreach ($result as $row) {
		$encontro_informacion_usuario = 1;
		$nombre=$row->usuarios_nombre;
		$categria_ppal = $row->catprincipal;
		$fecha_ultimo_ingreso = $row->ultingreso;
		$catSecond=$row->categorias_nombre;
		break;
	}
	//se acutaliza la fecha de ultimo ingreso
	$bulk->update(['nickname' =>['$eq' => $login]], ['$set' => ['ultingreso' => time()]], ['multi' => false, 'upsert' => false]);
	$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 100);
	$result = $manager->executeBulkWrite('RedSocial.Usuarios', $bulk, $writeConcern);
	
	if( $encontro_informacion_usuario == 0) {
		echo "<H3>Usuario No encontrado</H3>";
		exit(0);
	}
} catch (MongoDB\Driver\Exception\Exception $e) {
    $filename = basename(__FILE__);
    echo "El script $filename tine un error.\n"; 
    echo "Falla al ejecutar:\n";    
    echo "Exception:", $e->getMessage(), "\n";
    echo "In file:", $e->getFile(), "\n";
    echo "On line:", $e->getLine(), "\n";     
	exit(0);	
}


?>

<H3>Home</H3>
<table>
		<tr>
			<td>
				<form name="q1" action="home.php" method="get">
					<!-- filtro_fecha con valor 0 indica que debe buscar todo -->
					<input type="hidden" name="filtro_fecha" value="0" >
					<input type="hidden" name="login" value="<?php echo $login;?>" >
					<button class="button mi_color">Sin Filtro</button>
				</form>
			</td>
			<td>
				<form name="q0" action="home.php" method="get">
					<!-- filtro_fecha con valor -1 indica que debe buscar solo sobre la fecha de ultimo ingreso -->
					<input type="hidden" name="filtro_fecha" value="-1" >
					<input type="hidden" name="login" value="<?php echo $login;?>" >
					<button class="button mi_color">Con Filtro</button>
				</form>
			</td>
		</tr>
		<hr>

	<!-- Lista de Eventos -->	
	<?php
	echo "<b>Lista de eventos</b>";
	if ($filtro_fecha == 0){
		$filter = [];
		$options = [];
		$query = new MongoDB\Driver\Query($filter, $options);
		
	}else{
		$filter = ['feevento' => ['$gte'=>time()]];
		$options = [];
		$query = new MongoDB\Driver\Query($filter, $options);
	}
	
	// Where 

	//echo $query;
	$result = $manager->executeQuery('RedSocial.Eventos', $query);
	echo "<table>";
	foreach ($result as $row) {
		//echo "<!-- Boton de asistire -->"
		//printf("<tr><td>\"%s\"</td><td>\"%s\"</td></tr>\n", $row->feevento, $row->dsevento);
		
		echo	'<tr>
					<td>'.'Nro asistentes ( '.$row->nasistentes.' ) </td><td>'.$row->dsevento.'</td>
					<td>'.date('m/d/Y H:i:s' ,$row->feevento).'</td>
					<td>
						<form methon="get" action="agendar.php">
							<input type="hidden" name="eventos_id" value="'.$row->eventos_id.'">
							<input type="hidden" name="feevento" value="'.$row->feevento.'">
							<input type="hidden" name="dsevento" value="'.$row->dsevento.'">
							<input type="hidden" name="nasistentes" value="'.$row->nasistentes.'">
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

			//se mostraran las publicaciones con sus respenctivos likes

			echo "<b>Lista de publicaciones</b>";
			$filterP= ['catprincipal' => ['$eq'=>$categria_ppal]];
			$optionsP = [];
			$queryP = new MongoDB\Driver\Query($filterP, $optionsP);
			$resultP = $manager->executeQuery('RedSocial.Publicaciones',$queryP);

			foreach ($resultP as $row) {
				echo '<tr>
									<td>Nro likes ( '.$row->likes.' )</td>
									<td>'.$row->dspublicacion.'</td>
									<td>
										<form method="get" action="like.php">
											<input type="hidden" name="publicaciones_id" value="'.$row->publicaciones_id.'">
											<input type="hidden" name="catprincipal" value="'.$row->catprincipal.'">
											<input type="hidden" name="dspublicacion" value="'.$row->dspublicacion.'">
											<input type="hidden" name="likes" value="'.$row->likes.'">
											<input class="button mi_color" type="submit" value="Like">
										</form>
									</td>
							</tr>';
			}


			echo '<a href="publicar.php?categoria_ppal='.$categria_ppal.'"><button class="button mi_color">Publicar</button></a>';

			$secundarias='';

			for ($i=0; $i <sizeof($catSecond) ; $i++) { 
				$secundarias=$secundarias.','.$catSecond[$i];
			}

			$time_end = microtime(true); // Tiempo Final
			$time = $time_end - $time_start;
			
			echo "<hr>";
			echo $nombre. " - ";
			echo date('m/d/Y H:i:s' , $fecha_ultimo_ingreso);
			echo " - ".$categria_ppal;
			echo "-".$secundarias;
			echo'<br>';
			echo'Tiempo:'.$time;

		
	?>

	<!-- Boton de consultar los eventos que estoy matriculado -->
	
	
	<!-- Lista de Publicaciones -->

</body>
</html>