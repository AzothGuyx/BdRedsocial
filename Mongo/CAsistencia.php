<?php

$cont=0;


try {
    $eventos_id = htmlspecialchars($_GET["id_evento"]);

    $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $bulk = new MongoDB\Driver\BulkWrite;

    $evento=intval($eventos_id);
    $filter= ['eventos_id' => ['$eq'=>$evento]];
    $options = [];
    $query = new MongoDB\Driver\Query($filter, $options);
    $result = $manager->executeQuery('RedSocial.Asistencias', $query);

    foreach ($result as $row) {
        $cont=$cont+1;
    }
    
    
    $bulk->update(['eventos_id' =>['$eq' => $evento]], ['$set' => ['nasistentes' => $cont]], ['multi' => false, 'upsert' => false]);
    $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 100);
    $result = $manager->executeBulkWrite('RedSocial.Eventos', $bulk, $writeConcern);

} catch(MongoDB\Driver\Exception\Exception $e) {
    $filename = basename(__FILE__);
    echo "El script $filename tine un error.\n"; 
    echo "Falla al ejecutar:\n";    
    echo "Exception:", $e->getMessage(), "\n";
    echo "In file:", $e->getFile(), "\n";
    echo "On line:", $e->getLine(), "\n";     
	exit(0);	
}

echo "asistencia actualizada";
echo "<br>";
?>