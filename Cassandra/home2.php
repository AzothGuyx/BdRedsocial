<?php

// Conexion con la base de datos
$cluster = Cassandra::cluster()
            ->withContactPoints('127.0.0.1')
            ->build();
$sesion = $cluster->connect("redsocial");

// Optener nombre de usuario por metodo get desde index.php
$usuario = htmlspecialchars($_GET["login"]);

// Prueba de que si se esta opteniendo el nombre de usuario
echo "Home del usuario ".$usuario;

// Creacion de la consulta
$query = 'SELECT usuarios_nombre, ultingreso, categorias_nombre FROM usuarios2 WHERE nickname='.'\''.$usuario.'\'';

// Ejecucion de la consulta
$result = $sesion->execute($query);

foreach($result as $row){
    $catPP = $row['categorias_nombre'];
    $ultIngreso = $row['ultingreso'];
    break;
}

echo "<br>";
echo "Categoria principal: ".$catPP;
echo "<br>";
echo "Ultimo ingreso: ".date('m/d/Y', $ultIngreso->seconds);

echo "<br>";
echo "<br>";

//$query = 'SELECT feevento, eventos_id, dsevento, nasistentes FROM eventos WHERE dummy=2 and feevento>'.'\''.$ultIngreso->time().'\' ORDER BY feevento ASC';
//$result = $sesion->execute($query);

echo "<h3>Eventos</h3>";
echo "<table>";
echo "<tr><td><b>Descripcion</b></td><td><b>Fecha</b></td></tr>";

/*foreach($result as $row){
    echo'<tr><td>'.$row['dsevento'].'</td><td>'.date('m/d/Y H:i:s', $row['feevento'].'</td></tr>';
    //echo '<p>'.$row['dsevento'].'</p>';
    //echo '<p>'.date('m/d/Y H:i:s', $row['feevento']->time()).'</p>';
}*/

echo "</table>";

?>