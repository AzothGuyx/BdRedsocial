<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Agenda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css">
</head>

<body>
    <H1 class="mi_color">Agenda</H1>
    <div>

    <?php

try {

    // Conexion a la base de batos
   $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");


   $bulk = new MongoDB\Driver\BulkWrite;
   // se obtienen los datos de la url // Se optienen los argumentos

    $nickname = htmlspecialchars($_GET['nickname']);
    

    $filter = ["nickname" => ['$eq' =>$nickname]];
    $options = [
       'maxTimeMS' => 1000];
    
     $query = new MongoDB\Driver\Query($filter, $options);
    
     $resultA = $manager->executeQuery('RedSocial.Asistencias', $query);

   

   

   //Se consultan las agendas de la persona

} catch (MongoDB\Driver\Exception\Exception $e) {
    $filename = basename(__FILE__);
    echo "El script $filename tine un error.\n"; 
    echo "Falla al ejecutar:\n";    
    echo "Exception:", $e->getMessage(), "\n";
    echo "In file:", $e->getFile(), "\n";
    echo "On line:", $e->getLine(), "\n";     
	exit(0);	
}
//se procede con la consulta para traer los eventos a los que asitira la persona



echo '<table cellspacing="10">';
echo    '<tr>
                <td><b>Usuario</b></td>
                <td><b>Evento</b></td>
        </tr>';
foreach($resultA as $row){
    echo    '<tr>
                    <td>'.$row->nickname.'</td>
                    <td>'.$row->eventos_id.'</td>';
    $filterB = ["eventos_id" => ['$eq' =>$row->eventos_id]];
    $optionsB = ['maxTimeMS' => 1000];
    $queryB = new MongoDB\Driver\Query($filterB, $optionsB);
    $resultB = $manager->executeQuery('RedSocial.Eventos', $queryB);

    foreach ($resultB as $row2) {
        echo '<td>'.$row2->dsevento.'</td> </tr>';   
    }
}


echo "</table>";
?>

</body>
</html>