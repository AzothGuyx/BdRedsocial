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
// Conexion a la base de batos
$cluster = Cassandra::cluster()
            ->withContactPoints('127.0.0.1')
            ->build();
$sesion = $cluster->connect("redsocial");

//Se optiene la cantidad de agendas que hay
$query = 'SELECT agendas_id from agendas';
$result = $sesion->execute($query);
$cont = 0;
foreach($result as $row){
    $cont = $cont + 1;
}
$cont = $cont + 1;

// Se optienen los argumentos
$nickname = htmlspecialchars($_GET['nickname']);

if( isset( $_GET["eventos_id"] )  ){
    $eventos_id = htmlspecialchars($_GET["eventos_id"]);

    if (isset($_GET["feevento"])){
        $feevento = htmlspecialchars($_GET['feevento']);

        if(isset($_GET["dsevento"])){
            $dsevento = htmlspecialchars($_GET['dsevento']);

            //Se actualizan las asistencias del evento
            $query = 'UPDATE eventos set nasistentes = nasistentes + 1 where dummy = 2 and eventos_id = '.$eventos_id.' and feevento = '.'\''.$feevento.'\'  and dsevento ='.'\''.$dsevento.'\'';
            $result = $sesion->execute($query);

            //Se inserta una nueva agenda
            $query = 'INSERT into agendas (agendas_id, nickname, eventos_id, dsevento) values ('.$cont.', '.'\''.$nickname.'\', '.$eventos_id.', '.'\''.$dsevento.'\')';
            $result = $sesion->execute($query);
        }
    }
}

//Se consultan las agendas de la persona
$query = 'SELECT eventos_id, dsevento, agendas_id, nickname FROM agendas WHERE nickname='.'\''.$nickname.'\'';
$result = $sesion->execute($query);

echo '<table cellspacing="10">';
echo    '<tr>
                <td><b>Usuario</b></td>
                <td><b>Evento</b></td>
        </tr>';
foreach($result as $row){
    echo    '<tr>
                    <td>'.$row['nickname'].'</td>
                    <td>'.$row['dsevento'].'</td>
            </tr>';
}
echo "</table>";
?>

</body>
</html>