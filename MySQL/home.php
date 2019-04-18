
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Home Practica - Cassandra</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />


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
<?php
/*
*consulta los eventos que existe basado en # deasistentes-fecha-descripción.
*Permitir agendar uno de estos eventos mediante el boton asistir.
*/
	$query = 'SELECT A.evento_id as "idEvento", COUNT(A.evento_id), E.feevento, E.dsevento
	FROM agenda A
	INNER JOIN evento E ON E.id = A.evento_id
	GROUP BY A.evento_id';

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
		<form method="get" action="agendar.php">
		<input type="hidden" name="idUsuario" value="'.$idUsuario.'">
		<input type="hidden" name="idEvento" value="'.$row['idEvento'].'">
		<button type="submit" class="btn btn-primary">asistir</button></form>
		</td>
		<td>'.$row['COUNT(A.evento_id)'].'</td>
		<td>'.$row['feevento'].'</td>
		<td>'.$row['dsevento'].'</td>
	  </tr>';
	}
	echo '</tbody>
		</table>';

//Consultar la agenda mediante el boton consultar.
?>	
<div class="container">
  <h2>Ejecutar Acción al Cerrar Modal</h2>
  <p>
  Probaremos como ejecutar una accion al detectar el cierre del modal
  </p>
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-md" id="myBtn">Ocultar Modal</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ejecutar Acción al Cerrar Modal</h4>
        </div>
        <div class="modal-body">
          <p>Probaremos como ejecutar una accion al detectar el cierre del modal</p>
        </div>
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
<script src="js/main.js"></script>
</body>
</html>