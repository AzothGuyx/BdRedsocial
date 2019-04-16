<?php
   
    $publicaciones_id = htmlspecialchars($_GET['publicaciones_id']);
    $catprincipal = htmlspecialchars($_GET['catprincipal']);
    $dspubli = htmlspecialchars($_GET['dspublicacion']);
    $likes=htmlspecialchars($_GET['likes']);
    try {
        $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        $bulk = new MongoDB\Driver\BulkWrite;
      
        $likes=$likes+1;
        $id_publicaciones=intval($publicaciones_id);
        echo $likes;
        echo $publicaciones_id;

        $bulk->update(['publicaciones_id' => $id_publicaciones], ['$set' => ['likes' =>$likes]], ['multi' => false, 'upsert' => false]);
	    $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 100);
        $result = $manager->executeBulkWrite('RedSocial.Publicaciones', $bulk, $writeConcern);
    
        
    }catch (MongoDB\Driver\Exception\Exception $e) {
        $filename = basename(__FILE__);
        echo "El script $filename tine un error.\n"; 
        echo "Falla al ejecutar:\n";    
        echo "Exception:", $e->getMessage(), "\n";
        echo "In file:", $e->getFile(), "\n";
        echo "On line:", $e->getLine(), "\n";     
        exit(0);	
    }
    
    echo 'like actualizado ';
?>