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
$usuario_id			= htmlspecialchars($_GET["usuario_id"]);
$usuario_login		= htmlspecialchars($_GET["usuario_login"]);
$usuario_nombre		= htmlspecialchars($_GET["usuario_nombre"]);
$categoria_id		= htmlspecialchars($_GET["categoria_id"]);
$categoria_nombre	= htmlspecialchars($_GET["categoria_nombre"]);
$dspublicacion		= htmlspecialchars($_GET["dspublicacion"]);

					
/*Validación de argumentos - */
/*
echo 'tiempo='. 	$tiempo .'</br>';
echo 'usuario_id='. 		$usuario_id .'</br>';
echo 'usuario_login='. 		$usuario_login .'</br>';
echo 'usuario_nombre='. 	$usuario_nombre.'</br>';
echo 'categoria_id='. 	$categoria_id.'</br>';
echo 'categoria_nombre='. 	$categoria_nombre.'</br>';
echo 'dspublicacion='. 	$dspublicacion.'</br>';
*/

/* ==--> Aqui ustede debe hacer la conexion a la base de datos*/
// Documentación https://www.php.net/manual/es/class.mongodb-driver-manager.php
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

/* ==--> Crear proceso batch y se preparan las acciones*/
// Documentación https://www.php.net/manual/es/mongodb-driver-manager.executebulkwrite.php
$bulk = new MongoDB\Driver\BulkWrite;

/* ==--> Ejemplo de Insert*/
$id_documento = $bulk->insert(['_id' => 1, 'x' => 1]);
//var_dump($id_documento);


/* ==--> Ejemplo de Actualización*/

$id_documento = $bulk->update(['x' => 2], ['$set' => ['x' => 1]], ['multi' => false, 'upsert' => false]);
//var_dump($id_documento);

/* ==--> Se ejecuta contra una base de datos y una colexion*/
$result = $manager->executeBulkWrite('NOMBRE_DE_LA_BASE_DE_DATOS.NOMBRE_DE_LA_COLECCION', $bulk);

/*retornar el texto con resultado*/
echo "OK";
?>