
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Home Practica - Cassandra</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/bootstrap.css" type="text/css" media="all" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</head>
<body>
<H1 class="mi_color">MySQL o MariaDB-Home</H1>

<!--Cosas bases-->
<?PHP
/*Se recuperan los argumentos*/
// Usuario que se logeo
if( isset( $_GET["login"] ) ){
	$login = htmlspecialchars($_GET["login"]);
} else {
	echo "<H3>Falta el argumento login</H3>";
	exit(0);
}


// Fecha de ultimo acceso -  para filtro. Valor igual a -1 (menos uno) indica que debe consultar y actualizar
if( isset( $_GET["filtro_fecha"] ) ){
	$filtro_fecha = htmlspecialchars($_GET["filtro_fecha"]);
} else {
	echo "<H3>Falta el argumento filtro_fecha</H3>";
	exit(0);
}
/* ==--> Aqui ustede debe hacer la conexion a la base de datos*/
// Documentacion https://www.php.net/manual/es/book.mysqli.php
// Create connection (Puerto, Usuario, Clave y base datos)
$mysqli  = new mysqli('localhost', 'root', '','redes_sociales');
if ($mysqli->connect_errno) {
	echo "Fall� la conexi�n a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	exit(0);
}

//Completar los datos de usuario relevantes.
$query = 'SELECT id
FROM usuario 
WHERE login ='.'\''.$login.'\'';
	$result = $mysqli->query($query);
	foreach ($result as $row) {
	$idUsuario = $row['id'];
	}
?>
<!-- Mostrar ultimo ingreso -->
<header>
<?php
$query = 'SELECT *
FROM`usuario`
WHERE id='.'\''.$idUsuario.'\'';
foreach ($result as $row) {
	echo 'Hola '.$login.' tu ultimo ingreso fue '.$row['ultimo_ingreso'].'';
}
?>
</header>

<?php
/*
*consulta los eventos que existe basado en # deasistentes-fecha-descripción.
*Permitir agendar uno de estos eventos mediante el boton asistir.
*/
	$query = 'SELECT E.dsevento,E.feevento,COUNT(A.evento_id), E.id as "idEvento"
	FROM evento E
	LEFT JOIN  agenda A ON E.id = A.evento_id
	GROUP BY E.id';
	$result = $mysqli->query($query);
	echo '<table class="table">
	<thead class="thead-dark">
	  <tr>
	  <th scope="col">Asistir al evento</th>
	  <th scope="col">Numero de asistentes</th>
		<th scope="col">Fecha del evento</th>
		<th scope="col">Descripcion del eventoast</th>
	  </tr>
	</thead>
	<tbody>';
	foreach ($result as $row) {
		echo '
		<tr>
		<td>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agendarEvento'.$row['idEvento'].'">
		  Asistir
		</button>
		</td>
		<td>'.$row['COUNT(A.evento_id)'].'</td>
		<td>'.$row['feevento'].'</td>
		<td>'.$row['dsevento'].'</td>
	  </tr>';
	}
	echo '</tbody>
		</table>';


		
?>

		<!-- Modal aGENDAR EVENTO -->
		




<!-- //Consultar la agenda mediante el boton consultar. -->


<!-- Boton que llama el pop up(modal) -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#verAgenda">
Revisar mi agenda
</button>

<!-- Modal -->
<div class="modal fade" id="verAgenda" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verAgendaTitle">Mi agenda</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <?php
		$query = 'SELECT E.dsevento, E.feevento
		FROM evento E
		INNER JOIN agenda A ON A.evento_id = E.id
		WHERE A.usuario_id ='.'\''.$idUsuario.'\'';
	
		$result = $mysqli->query($query);
		echo '<table class="table">
		<thead class="thead-dark">
		  <tr>
			<th scope="col">Descripcion del evento</th>
			<th scope="col">Fecha del evento</th>
		  </tr>
		</thead>
		<tbody>';
		foreach ($result as $row) {
			echo '<tr>
			<td>'.$row['dsevento'].'</td>
			<td>'.$row['feevento'].'</td>
		  </tr>';
		}
		echo '</tbody>
			</table>';
		?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
<!-- 
<H3>Home</H3>
	Sin Filtro por fecha
	<form name="q1" action="home.php" method="get">
		filtro_fecha con valor 0 indica que debe buscar todo
		<input type="hidden" name="filtro_fecha" value="0" >
		<input type="hidden" name="login" value="<?php echo $login;?>" >
		<button class="button mi_color">Sin Filtro</button>
	</form>

	 -->

	<!-- Boton de consultar los eventos que estoy matriculado -->
	
	<!-- Lista de Publicaciones -->

<?php
$mysqli->close();
?>
</body>
</html>