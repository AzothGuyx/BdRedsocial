<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Agenda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <style type="text/css">
body {
	background: #ededed;
	width: 900px;
	margin: 30px auto;
	color: #999;
}
p {
	margin: 0 0 2em;
}
h1 {
	margin: 0;
}
a {
	color: #339;
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
div {
	padding: 20px 0;
	border-bottom: solid 1px #ccc;
}

/* button 
---------------------------------------------- */
.button {
	display: inline-block;
	zoom: 1; /* zoom and *display = ie7 hack for display:inline-block */
	*display: inline;
	vertical-align: baseline;
	margin: 0 2px;
	outline: none;
	cursor: pointer;
	text-align: center;
	text-decoration: none;
	font: 14px/100% Arial, Helvetica, sans-serif;
	padding: .5em 2em .55em;
	text-shadow: 0 1px 1px rgba(0,0,0,.3);
	-webkit-border-radius: .5em; 
	-moz-border-radius: .5em;
	border-radius: .5em;
	-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
	-moz-box-shadow: 0 1px 2px rgba(0,0,0,.2);
	box-shadow: 0 1px 2px rgba(0,0,0,.2);
}
.button:hover {
	text-decoration: none;
}
.button:active {
	position: relative;
	top: 1px;
}

.bigrounded {
	-webkit-border-radius: 2em;
	-moz-border-radius: 2em;
	border-radius: 2em;
}
.medium {
	font-size: 12px;
	padding: .4em 1.5em .42em;
}
.small {
	font-size: 11px;
	padding: .2em 1em .275em;
}


/* mi_color */
.mi_color {
	color: #fef4e9;
	border: solid 1px #da7c0c;
	background: #f78d1d;
	background: -webkit-gradient(linear, left top, left bottom, from(#faa51a), to(#f47a20));
	background: -moz-linear-gradient(top,  #faa51a,  #f47a20);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#faa51a', endColorstr='#f47a20');
}
.mi_color:hover {
	background: #f47c20;
	background: -webkit-gradient(linear, left top, left bottom, from(#f88e11), to(#f06015));
	background: -moz-linear-gradient(top,  #f88e11,  #f06015);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#f88e11', endColorstr='#f06015');
}
.mi_color:active {
	color: #fcd3a5;
	background: -webkit-gradient(linear, left top, left bottom, from(#f47a20), to(#faa51a));
	background: -moz-linear-gradient(top,  #f47a20,  #faa51a);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#f47a20', endColorstr='#faa51a');
}

</style>
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