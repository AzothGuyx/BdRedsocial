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

     $asistentes= htmlspecialchars($_GET['nasistentes']);


    if( isset( $_GET["eventos_id"] )  ){
        $eventos_id = htmlspecialchars($_GET["eventos_id"]);
    
        if (isset($_GET["feevento"])){
            $feevento = htmlspecialchars($_GET['feevento']);
    
            if(isset($_GET["dsevento"])){
                $dsevento = htmlspecialchars($_GET['dsevento']);
                
                $evento=intval($eventos_id);
                //Se inserta una nueva agenda
                $bulk->insert(['nickname' => $nickname, 'eventos_id' => $evento]);
                $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 100);
                $manager->executeBulkWrite('RedSocial.Asistencias', $bulk, $writeConcern);
               
                
            }
        }
    }
    

   

   

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
$filter = ["nickname" => ['$eq' =>$nickname]];
$options = [
   'maxTimeMS' => 1000];

 $query = new MongoDB\Driver\Query($filter, $options);

 $resultA = $manager->executeQuery('RedSocial.Asistencias', $query);



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
$asistentes=$asistentes+1;


        echo "</table>";
        echo '<br>';
        echo'<form method="get" action="CAsistencia.php">
        <input type="hidden" name="id_evento" value="'.$eventos_id.'">
        <input class="button mi_color" type="submit" value="Actualizar asistencia">
        </form>';
        echo $asistentes;
?>

</body>
</html>