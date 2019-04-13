<?php
// Conexion con la base de datos
$cluster = Cassandra::cluster()
            ->withContactPoints('127.0.0.1')
            ->build();
$sesion = $cluster->connect("redsocial");

$publicaciones_id = htmlspecialchars($_GET['publicaciones_id']);
$categoria_ppal = htmlspecialchars($_GET['categoria_ppal']);
$dspubli = htmlspecialchars($_GET['dspubli']);

echo $publicaciones_id." ";
echo $categoria_ppal." ";
echo $dspubli." ";

$query = 'UPDATE publicaciones set likes = likes + 0 where publicaciones_id = '.$publicaciones_id.' and categorias_nombre = '.'\''.$categoria_ppal.'\' and dspubli = '.'\''.$dspubli.'\'';
$sesion->execute($query);
?>