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
$categoria_nombre	= htmlspecialchars($_GET["categorias_nombre"]);
$dspublicacion		= htmlspecialchars($_GET["dspubli"]);
					
/*Validación de argumentos - */

echo 'tiempo='. 	$tiempo .'</br>';
echo 'usuario_login='. 		$nickname .'</br>';
echo 'categoria_nombre='. 	$categoria_nombre.'</br>';
echo 'dspublicacion='. 	$dspublicacion.'</br>';


/* ==--> Aqui ustede debe hacer la conexion a la base de datos*/
// Documentación https://www.php.net/manual/es/class.mongodb-driver-manager.php
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

/* ==--> Crear proceso batch y se preparan las acciones*/
// Documentación https://www.php.net/manual/es/mongodb-driver-manager.executebulkwrite.php
$bulk = new MongoDB\Driver\BulkWrite;
	$cont=0;

    $filter= [];
    $options = [];
    $query = new MongoDB\Driver\Query($filter, $options);
    $result = $manager->executeQuery('RedSocial.Publicaciones', $query);

	foreach ($result as $row) {
		$cont=$cont+1;
	}

	$cont=$cont+1;
/* ==--> Ejemplo de Insert*/
$id_documento = $bulk->insert(['dspublicacion' => $dspublicacion,'likes' => 0,'catprincipal' => $categoria_nombre,'publicaciones_id' =>$cont]);
//var_dump($id_documento);


/* ==--> Ejemplo de Actualización*/

//$id_documento = $bulk->update(['x' => 2], ['$set' => ['x' => 1]], ['multi' => false, 'upsert' => false]);
//var_dump($id_documento);

/* ==--> Se ejecuta contra una base de datos y una colexion*/
$result = $manager->executeBulkWrite('RedSocial.Publicaciones', $bulk);

/*retornar el texto con resultado*/
echo 'ok';
?>