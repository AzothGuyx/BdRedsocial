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
// Documentacion https://www.php.net/manual/es/book.mysqli.php
// Create connection (Puerto, Usuario, Clave y base datos)
$mysqli  = new mysqli('localhost:3307', 'root', '','red_social');
if ($mysqli->connect_errno) {
    echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	exit(0);
}

/* ==--> Se arma el Insert*/
// Documentación https://www.php.net/manual/es/mysqli-stmt.bind-param.php
/* Sentencia preparada, etapa 1: preparación */
$stmt = $mysqli->prepare("INSERT INTO CountryLanguage VALUES (?, ?, ?, ?)");

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
$stmt->bind_param('sssd', $code, $language, $official, $percent);

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