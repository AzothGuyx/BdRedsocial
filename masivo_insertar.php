<?php
/*
	Creado por Sergio Alvarez
	Version 1.02 - 2019/04/24
	Tecnicas avanzadas de base de datos - UDEM
	
  _   _  ____        __  __           _ _  __ _                
 | \ | |/ __ \      |  \/  |         | (_)/ _(_)               
 |  \| | |  | |     | \  / | ___   __| |_| |_ _  ___ __ _ _ __ 
 | . ` | |  | |     | |\/| |/ _ \ / _` | |  _| |/ __/ _` | '__|
 | |\  | |__| |     | |  | | (_) | (_| | | | | | (_| (_| | |   
 |_| \_|\____/      |_|  |_|\___/ \__,_|_|_| |_|\___\__,_|_|   
                                                               
															   
*/
	//var_dump($_SERVER);
	//exit(0);
	/*Leer el URL del servidor*/
	$URL_HOME = "http://localhost/BdRedsocial/";
	/*Si lo anterior NO FUNCIONA Usted debe cambiar esto segun su configuracion del proyecto (ubicacion dentro del wampp y el puerto del pache*/
	//$URL_HOME = 'http://localhost/Bd2_NoSQL2019_1/';
	//$URL_HOME = 'http://localhost:9090/Bd2_NoSQL2019_1/';

	/*Se recuperan los argumentos*/
	if( isset( $_GET["bd"] ) ){
		$bd = htmlspecialchars($_GET["bd"]);
	} else {
		$bd = "Cassandra";
	}
	if( isset( $_GET["registros"] ) ){
		$registros = htmlspecialchars($_GET["registros"]);
	} else {
		$registros = 1000;
	}
	
	if( $registros < 1 or $registros > 9999999 ){
		echo "Error en el número de registros a generar. Valor=".$registros;
		exit(0);
	}

	if( isset( $_GET["test"] ) ){
		$esUnTest = htmlspecialchars($_GET["test"]);
	} else {
		$esUnTest = "N";
	}

	$listaCategorias= array(
		1 => "udem",
		2 => "ingenierias",
		3 => "sistemas",
		4 => "telecomunicaciones",
		5 => "derecho",
		6 => "finanzas");

// Formula para GoogleDocs (Inicia en K3)
// =E3&" => array( '"&$F$2&"'=>'"&F3&"', '"&$G$2&"'=>'"&G3&"', '"&$I$2&"'=> array("&I3&"), '"&$J$2&" =>'"&J3&"),"
$listaUsuarios= array(
		1 => array( "nickname"=>"stephanie", "usuarios_nombre"=>"STEPHANIE ABAD", "ultingreso"=>"", "categorias_nombre"=>"udem"),
		2 => array( "nickname"=>"juand", "usuarios_nombre"=>"JUAN DAVID ABAD DIAZ", "ultingreso"=>"", "categorias_nombre"=>"ingenierias"),
		3 => array( "nickname"=>"piedad", "usuarios_nombre"=>"PIEDAD ABAD ALVAREZ", "ultingreso"=>"",  "categorias_nombre"=>"sistemas"),
		4 => array( "nickname"=>"melisa", "usuarios_nombre"=>"MELISA ABAD CARRASCO", "ultingreso"=>"",  "categorias_nombre"=>"telecomunicaciones"),
		5 => array( "nickname"=>"manuela", "usuarios_nombre"=>"MANUELA ABAD DUQUE", "ultingreso"=>"",  "categorias_nombre"=>"sistemas"),
		6 => array( "nickname"=>"juanf", "usuarios_nombre"=>"JUAN FERNANDO ABAD ECHEVERRI", "ultingreso"=>"",  "categorias_nombre"=>"telecomunicaciones"),
		7 => array( "nickname"=>"lucas", "usuarios_nombre"=>"LUCAS ABAD GIRALDO", "ultingreso"=>"",  "categorias_nombre"=>"derecho"),
		8 => array( "nickname"=>"xavier", "usuarios_nombre"=>"XAVIER EDMUNDO ABAD HERRERA", "ultingreso"=>"",  "categorias_nombre"=>"finanzas"),
		9 => array( "nickname"=>"angie", "usuarios_nombre"=>"ANGIE MELISSA ABAD MARTINEZ", "ultingreso"=>"",  "categorias_nombre"=>"udem"),
		10 => array( "nickname"=>"miguel", "usuarios_nombre"=>"MIGUEL ABAD NUNEZ", "ultingreso"=>"",  "categorias_nombre"=>"ingenierias"),
		11 => array( "nickname"=>"juliana", "usuarios_nombre"=>"Juliana Abad Varon", "ultingreso"=>"",  "categorias_nombre"=>"derecho"),
		12 => array( "nickname"=>"esteban", "usuarios_nombre"=>"ESTEBAN ABAD VELEZ", "ultingreso"=>"",  "categorias_nombre"=>"finanzas"),
		13 => array( "nickname"=>"yicsy", "usuarios_nombre"=>"YICSY ZAIR ABADIA ASPRILLA", "ultingreso"=>"",  "categorias_nombre"=>"sistemas"),
		14 => array( "nickname"=>"luzm", "usuarios_nombre"=>"Luz Maria Abadia Caicedo", "ultingreso"=>"",  "categorias_nombre"=>"telecomunicaciones"),
		15 => array( "nickname"=>"alex", "usuarios_nombre"=>"Alex Steven Abadia Conrado", "ultingreso"=>"",  "categorias_nombre"=>"udem"));

		// $listaUsuarios= array(
		// 	1 => array( "nickname"=>"stephanie", "usuarios_nombre"=>"STEPHANIE ABAD", "categorias_secundarias"=> array("ingenierias","sistemas"), "categoria_principal"=>"udem"),
		// 	2 => array( "nickname"=>"juand", "usuarios_nombre"=>"JUAN DAVID ABAD DIAZ", "categorias_secundarias"=> array("udem","telecomunicaciones"), "categoria_principal"=>"ingenierias"),
		// 	3 => array( "nickname"=>"piedad", "usuarios_nombre"=>"PIEDAD ABAD ALVAREZ", "categorias_secundarias"=> array("udem","derecho"), "categoria_principal"=>"sistemas"),
		// 	4 => array( "nickname"=>"melisa", "usuarios_nombre"=>"MELISA ABAD CARRASCO", "categorias_secundarias"=> array("udem","finanzas"), "categoria_principal"=>"telecomunicaciones"),
		// 	5 => array( "nickname"=>"manuela", "usuarios_nombre"=>"MANUELA ABAD DUQUE", "categorias_secundarias"=> array("derecho", "ingenierias"), "categoria_principal"=>"sistemas"),
		// 	6 => array( "nickname"=>"juanf", "usuarios_nombre"=>"JUAN FERNANDO ABAD ECHEVERRI", "categorias_secundarias"=> array("udem","ingenierias"), "categoria_principal"=>"telecomunicaciones"),
		// 	7 => array( "nickname"=>"lucas", "usuarios_nombre"=>"LUCAS ABAD GIRALDO", "categorias_secundarias"=> array("derecho"), "categoria_principal"=>"derecho"),
		// 	8 => array( "nickname"=>"xavier", "usuarios_nombre"=>"XAVIER EDMUNDO ABAD HERRERA", "categorias_secundarias"=> array("udem"), "categoria_principal"=>"finanzas"),
		// 	9 => array( "nickname"=>"angie", "usuarios_nombre"=>"ANGIE MELISSA ABAD MARTINEZ", "categorias_secundarias"=> array("ingenierias","sistemas"), "categoria_principal"=>"udem"),
		// 	10 => array( "nickname"=>"miguel", "usuarios_nombre"=>"MIGUEL ABAD NUNEZ", "categorias_secundarias"=> array("udem","telecomunicaciones"), "categoria_principal"=>"ingenierias"),
		// 	11 => array( "nickname"=>"juliana", "usuarios_nombre"=>"Juliana Abad Varon", "categorias_secundarias"=> array("udem"), "categoria_principal"=>"derecho"),
		// 	12 => array( "nickname"=>"esteban", "usuarios_nombre"=>"ESTEBAN ABAD VELEZ", "categorias_secundarias"=> array("udem"), "categoria_principal"=>"finanzas"),
		// 	13 => array( "nickname"=>"yicsy", "usuarios_nombre"=>"YICSY ZAIR ABADIA ASPRILLA", "categorias_secundarias"=> array("udem","ingenierias"), "categoria_principal"=>"sistemas"),
		// 	14 => array( "nickname"=>"luzm", "usuarios_nombre"=>"Luz Maria Abadia Caicedo", "categorias_secundarias"=> array("udem","ingenierias"), "categoria_principal"=>"telecomunicaciones"),
		// 	15 => array( "nickname"=>"alex", "usuarios_nombre"=>"Alex Steven Abadia Conrado", "categorias_secundarias"=> array("derecho"), "categoria_principal"=>"udem"));

$listaMariaTeniaUnCorderito= array(
		1=>"Mary had a little lamb,",
		2=>"Its fleece was white as snow.",
		3=>"And everywhere that Mary went,",
		4=>"The lamb was sure to go.",
		5=>"He followed her to school one day,",
		6=>"That was against the rule.",
		7=>"It made the children laugh and play,",
		8=>"To see a lamb at school.",
		9=>"So the teacher turned him out,",
		10=>"But still he lingered near,",
		11=>"And waited patiently about,",
		12=>"Till Mary did appear.",
		13=>"And then he ran to her and laid",
		14=>"His head upon her arm",
		15=>"As if he said, I m not afraid,",
		16=>"You ll keep me from all harm.",
		17=>"Why does the lamb love Mary so?",
		18=>"The eager children cry.",
		19=>"O, Mary loves the lamb you know,",
		20=>"The teacher did reply;",
		21=>"And you each gentle animal",
		22=>"In confidence may bind,",
		23=>"And make them follow at your call",
		24=>"If you are always kind.",
		25=>"Maria tenia un corderito",
		26=>"Que vellon blanco de nieve tenia.",
		27=>"Y por todas partes donde Maria iba",
		28=>"El corderita la seguia.",
		29=>"La siguio a la escuela un dia,",
		30=>"Y no era permitido.",
		31=>"Los ninos se rieron y se divirtieron",
		32=>"De ver en la escuela un cordero.",
		33=>"Luego el maestro lo echo fuera",
		34=>"Pero se quedo muy cerca.",
		35=>"Espero pacientemente por ahi",
		36=>"Hasta que Maria apareciera.",
		37=>"Y luego corrio a ella y poso",
		38=>"La cabeza sobre su brazo,",
		39=>"Como si dijera No tengo miedo,",
		40=>"Me guardaras del dano.",
		41=>"¿Por que el cordero quiere tanto a Maria?",
		42=>"Pidieron los ninos.",
		43=>"Pues Maria quiere al cordero, sabeis,",
		44=>"Respondio el maestro.",
		45=>"Y podeis, con un buen animal,",
		46=>"En confianza ser amigos,",
		47=>"Y hacerlos venir si los llamais",
		48=>"Si estais siempre buenos."	);
		
/*Formato en HTML*/
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Generación registros - NoSQL</title>
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

table, th, td {
	color: black;
    border: 1px solid black;
    border-collapse: collapse;
}
td{
	padding: 10px;
}

/* blue */
.blue {
	color: #d9eef7;
	border: solid 1px #0076a3;
	background: #0095cd;
	background: -webkit-gradient(linear, left top, left bottom, from(#00adee), to(#0078a5));
	background: -moz-linear-gradient(top,  #00adee,  #0078a5);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#00adee', endColorstr='#0078a5');
}
.blue:hover {
	background: #007ead;
	background: -webkit-gradient(linear, left top, left bottom, from(#0095cc), to(#00678e));
	background: -moz-linear-gradient(top,  #0095cc,  #00678e);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#0095cc', endColorstr='#00678e');
}
.blue:active {
	color: #80bed6;
	background: -webkit-gradient(linear, left top, left bottom, from(#0078a5), to(#00adee));
	background: -moz-linear-gradient(top,  #0078a5,  #00adee);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#0078a5', endColorstr='#00adee');
}

</style>
</head>
<body>
<H1 class="blue">Insertar Masivo para <?=$bd;?>(registros:<?=$registros;?>)</H1>
<div>
<table style="width:100%">
<tr>
	<th>#</th>
    <th>URL</th>
    <th>Resultado</th>
</tr>
<?php

$tiempo = time() - ($registros/2); /*Tiempo de Inicio generación registros*/
	
$time_start = microtime(true); // Tiempo Inicial Proceso

	/*Ciclo*/
	for( $i= 1 ; $i <= $registros ; $i++ ) {	
		/*Genera los valores de forma aleatoria*/
		$usuario_num = rand ( 1 , 15 );
		$usuario = $listaUsuarios[$usuario_num];
		
		$tiempo = $tiempo + rand ( 0 , 1 );

		$pub =  htmlentities($listaMariaTeniaUnCorderito[ rand ( 1 , 48 ) ]);
		//$pub = str_replace(" ", "+", $pub);
		/*Arma la cadena del llamado*/
		$url = 		$URL_HOME .
					$bd . '/insertar.php'.
					'?tiempo='. $tiempo .					
					'&usuario_num='. ($usuario_num) .
					'&nickname='. ($usuario["nickname"]).
					'&usuarios_nombre='. ($usuario["usuarios_nombre"]).
					'&categorias_nombre='. ($usuario["categorias_nombre"]).
					//'&categoria_nombre='. ($listaCategorias[$usuario["categoria_principal"]]).
					'&dspubli='. $pub;
		
		$getdata = http_build_query(
			array(
				'tiempo' => $tiempo,
				'usuario_num' => $usuario_num,
				'nickname'=>$usuario["nickname"],
				'usuarios_nombre'=>$usuario["usuarios_nombre"],
				'categorias_nombre'=>$usuario["categorias_nombre"],
				'dspubli'=> $pub
				)
			);
			//var_dump( $getdata);
			//exit(0);
		$opts = array('http' =>
				array(
					'method'  => 'GET',
					'content' => $getdata,
					'header' => 'Content-Type: application/x-www-form-urlencoded'
				)
			);
						
						$context  = stream_context_create($opts);

		if( $esUnTest == 'S' ){
			header('Location: '.$url);
			die();
		}
		/*Se hace el llamado*/
		$contents = "";
		try{
			//suppress the warning by putting an error control operator (i.e. @) 
			$contents = file_get_contents($URL_HOME .
						$bd . '/insertar.php?'.$getdata , false, $context);
			//echo "Se supone que todo esta bien";
		}catch (Exception $e) {
			$contents = $e->getMessage();
			//echo "Algo malo paso";
		}
		/*Se imprime la fila de la tabla*/
		echo 	"<tr>
					<td>$i</td>
					<td>".$url."</td>
					<td>".$contents."</td>
				</tr>\n";
	}
	
?>
</table>
</div>
<?php
$time_end = microtime(true); // Tiempo Final
$time = $time_end - $time_start; // Tiempo Consumido
echo "\n</br></br><h2>Tiempo de ejecución ".$time." segundos</h2>";
echo $url;
?>
</body>
</html>
