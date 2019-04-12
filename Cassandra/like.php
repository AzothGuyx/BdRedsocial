<?php
    $cluster   = Cassandra::cluster()
        ->withContactPoints('127.0.0.1')
        ->build();
    // Seleccionar la base de datos
    $session   = $cluster->connect("redsocial");

    $publicaciones_id = htmlspecialchars($_GET['publicaciones_id']);
    $categorias_nombre = htmlspecialchars($_GET['categorias_nombre']);
    $dspubli = htmlspecialchars($_GET['dspubli']);
    
    $query = 'UPDATE publicaciones set likes = likes + 1 where publicaciones_id = '.$publicaciones_id.' and categorias_nombre = '.'\''.$categorias_nombre.'\' and dspubli = '.'\''.$dspubli.'\'';
    $result = $session->execute($query);
    echo $query;
?>