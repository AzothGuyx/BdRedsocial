<?php
/*
	Creado por Sergio Alvarez
	Version 1.0 - 2019/03/30
	Tecnicas avanzadas de base de datos - UDEM
	
	Notas: 
	* En Archivo donde no hay que contabilizar los tiempos
*/

/*Se recuperan los argumentos*/
$usuario_id			= htmlspecialchars($_GET["usuario_num"]);
$categoria_nombre	= htmlspecialchars($_GET["categorias_nombre"]);
$dspublicacion		= htmlspecialchars($_GET["dspubli"]);
$tiempo				= htmlspecialchars($_GET["tiempo"]);
$nickname			= htmlspecialchars($_GET["nickname"]);
$usuarios_nombre	= htmlspecialchars($_GET["usuarios_nombre"]);

/*Validación de argumentos - */
echo 'tiempo='. 	$tiempo .'</br>';
echo 'usuario_id='. 		$usuario_id .'</br>';
echo 'usuario_nombre='. 	$usuarios_nombre.'</br>';
echo 'categoria_nombre='. 	$categoria_nombre.'</br>';
echo 'dspublicacion='. 	$dspublicacion.'</br>';

/* ==--> Aqui ustede debe hacer la conexion a la base de datos*/
// Documentacion https://www.php.net/manual/es/book.mysqli.php
// Create connection (Puerto, Usuario, Clave y base datos)
$mysqli  = new mysqli('localhost', 'root', '','redes_sociales');
if ($mysqli->connect_errno) {
    echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	exit(0);
}
//Encontrar el id mediante el nombre
    $query = 'SELECT id FROM categoria WHERE nombre ='.'\''.$categoria_nombre.'\'';
	$result = $mysqli->query($query);
	foreach ($result as $row) {
		$catId = $row['id'];
	}
/* ==--> Se arma el Insert*/
// Documentación https://www.php.net/manual/es/mysqli-stmt.bind-param.php
/* Sentencia preparada, etapa 1: preparación */
   try
   {

    $query = 'INSERT INTO publicacion (dspublicacion, usuario_id, categoria_id) VALUES ('.'\''.$dspublicacion.'\','.'\''.$usuario_id.'\','.'\''.$catId.'\')';
    $result = $mysqli->query($query);
   }catch (Exception $e) {
        echo 'Excepción capturada: ',  $e->getMessage(), "\n";
   }    

?>