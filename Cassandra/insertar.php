<?php
/*
	Creado por Sergio Alvarez
	Version 1.0 - 2019/03/30
	Tecnicas avanzadas de base de datos - UDEM
	
	Notas: 
	* En Archivo donde no hay que contabilizar los tiempos
*/

/*Se recuperan los argumentos*/
$tiempo				= htmlspecialchars($_GET["tiempo"]);
$usuario_num		= htmlspecialchars($_GET["usuario_num"]);
$nickname			= htmlspecialchars($_GET["nickname"]);
$usuarios_nombre	= htmlspecialchars($_GET["usuarios_nombre"]);
$categorias_nombre	= htmlspecialchars($_GET["categorias_nombre"]);
//$categoria_nombre	= htmlspecialchars($_GET["categoria_nombre"]);
$dspubli			= htmlspecialchars($_GET["dspubli"]);

					
/*Validación de argumentos - */

echo 'tiempo='. 			$tiempo .'</br>';
echo 'usuario_num='. 		$usuario_num .'</br>';
echo 'nickname='. 			$nickname .'</br>';
echo 'usuarios_nombre='. 	$usuarios_nombre.'</br>';
//echo 'categoria_id='. 	$categoria_id.'</br>';
echo 'categorias_nombre='. 	$categorias_nombre.'</br>';
echo 'dspubli='. 			$dspubli.'</br>';



// Si es cassandra
$tiempo = $tiempo*1000;


/* ==--> Aqui ustede debe hacer la conexion a la base de datos*/

// Documentación en https://datastax.github.io/php-driver/features
$cluster   = Cassandra::cluster()
               ->withContactPoints('127.0.0.1')
               ->build();
// Seleccionar la base de datos
$session   = $cluster->connect("redsocial");


// Documentación en https://datastax.github.io/php-driver/features/#executing-queries
// Documentación en https://datastax.github.io/php-driver/features/simple_statements/
/* ==--> Se arma el Batch para insertar en tablas. Note que hay dos ejemplos de insert*/

// $batch = new Cassandra\BatchStatement(Cassandra::BATCH_UNLOGGED);
// 	// Ejemplo de tabla Qn con las columnas x,y,z,w. Y se usan las variables $v_x, $v_y, $v_z, $v_w. Note que las columnas x, w son tipo texto
// 	$batch -> add(
// 		"INSERT INTO Qn(x,y,z,w) VALUES ('${v_x}', ${v_y}, ${v_z}, '${v_w}')"
// 	);
// 	// Ejemplo de tabla Qm con las columnas a,b,x. Y se usan las variables $v_a, $v_b, $v_z, $v_x. Note que la columna a es tipo texto
// 	$batch -> add(
// 		"INSERT INTO Qm(a,b,x) VALUES ('${v_a}', ${v_b}, ${v_x})"
// 	);
// $session->execute($batch);


/* ==--> Se arma el Batch para actualizar en tablas*/

$batchCounter = new Cassandra\BatchStatement(Cassandra::BATCH_COUNTER);
	// Ejemplo de actualizar la tabla Qt se incrementa la columna contador
	$query = 'SELECT publicaciones_id from publicaciones';
	$result = $session->execute($query);
	$cont = 0;
	foreach($result as $row){
		$cont = $cont + 1;
	}
	$cont = $cont + 1;
	echo "Proximo publicaciones id= ". $cont.'<br>';
	$batchCounter -> add(
		//"UPDATE Qt SET contador = contador + 1 WHERE x='${v_x}' AND y = ${v_y}"
		//"UPDATE publicaciones set likes = likes + 0 where publicaciones_id = ${cont} and categorias_nombre = ${categorias_nombre} and dspubli = ${dspubli}"
		'UPDATE publicaciones set likes = likes + 0 where publicaciones_id = '.$cont.' and categorias_nombre = '.'\''.$categorias_nombre.'\' and dspubli = '.'\''.$dspubli.'\''
	);
$session->execute($batchCounter);

/* ==--> Cerrar Conexion*/
$session->close();

/*retornar el texto con resultado*/
echo "OK";
?>