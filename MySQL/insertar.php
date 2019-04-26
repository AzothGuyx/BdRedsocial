<?php
/*
	Creado por Sergio Alvarez
	Version 1.0 - 2019/03/30
	Tecnicas avanzadas de base de datos - UDEM
	
	Notas: 
	* En Archivo donde no hay que contabilizar los tiempos
*/

/*Se recuperan los argumentos*/
$usuario_num			= htmlspecialchars($_GET["usuario_id"]);
$categorias_nombre	= htmlspecialchars($_GET["categoria_nombre"]);
$dspubli		= htmlspecialchars($_GET["dspublicacion"]);

					
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
// Documentacion https://www.php.net/manual/es/book.mysqli.php
// Create connection (Puerto, Usuario, Clave y base datos)
$mysqli  = new mysqli('localhost', 'root', '','redes_sociales');
if ($mysqli->connect_errno) {
    echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	exit(0);
}

/* ==--> Se arma el Insert*/
// Documentación https://www.php.net/manual/es/mysqli-stmt.bind-param.php
/* Sentencia preparada, etapa 1: preparación */
//Encontrar el id mediante el nombre
$query = 'SELECT id FROM categoria WHERE nombre ='.'\''.$categoria_nombre.'\'';
$result = $mysqli->query($query);
foreach ($result as $row) {
	$catId = $row['id'];
}

$stmt = $mysqli->prepare('INSERT INTO publicacion (dspublicacion, usuario_id, categoria_id) VALUES ('.'\''.$dspublicacion.'\','.'\''.$usuario_id.'\','.'\''.$catId.'\')');

/* Sentencia preparada, etapa 2: Enlace*/
/*
 types

    Una cadena que contiene uno o más caracteres que especifican los tipos para el correspondiente enlazado de variables:
    Especificación del tipo de caracteres Carácter 	Descripción
    i 	la variable correspondiente es de tipo entero
    d 	la variable correspondiente es de tipo double
    s 	la variable correspondiente es de tipo string
    b 	la variable correspondiente es un blob y se envía en paquetes
	
	En el ejemplo hay sssd significa 3 cadenas y decimal
*/
$stmt->bind_param('Sii', $code, $language, $official, $percent);

$code = 'COL';
$language = 'Español';
$official = "E";
$percent = 98.0;

/* Sentencias preprada, etapa 3: ejecuta */
$stmt->execute();

//printf("%d Fila insertada.\n", $stmt->affected_rows);


/* se recomienda el cierre explícito */
$stmt->close();
$mysqli->close();
/*retornar el texto con resultado*/
echo "OK";
?>