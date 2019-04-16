<?php
try {
    // Conexion con la base de datos
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$bulk = new MongoDB\Driver\BulkWrite;
        $filter = [];
	    $options = [
		'maxTimeMS' => 1000
	                        ];

$publicaciones_id = htmlspecialchars($_GET['publicaciones_id']);
$categoria_ppal = htmlspecialchars($_GET['categoria_ppal']);
$dspubli = htmlspecialchars($_GET['dspubli']);

$id_publicaciones=intval($publicaciones_id);

$bulk->insert(['dspublicacion'=>$dspubli,'likes'=>0,'catprincipal'=>$categoria_ppal,'publicaciones_id'=>$id_publicaciones]);
	$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 100);
    $result = $manager->executeBulkWrite('RedSocial.Publicaciones', $bulk, $writeConcern);
    
} catch (MongoDB\Driver\Exception\Exception $e) {
    $filename = basename(__FILE__);
    echo "El script $filename tine un error.\n"; 
    echo "Falla al ejecutar:\n";    
    echo "Exception:", $e->getMessage(), "\n";
    echo "In file:", $e->getFile(), "\n";
    echo "On line:", $e->getLine(), "\n";     
	exit(0);	
}

?>