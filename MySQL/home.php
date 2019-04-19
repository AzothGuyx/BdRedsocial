<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
	$query = 'SELECT id, ultimo_ingreso, nombre FROM usuario WHERE login ='.'\''.$login.'\'';
	$result = $mysqli->query($query);
	foreach ($result as $row) {
		$idUsuario = $row['id'];
		$ui = $row['ultimo_ingreso'];
		$nombre = $row['nombre'];
	}
	
// categoria principal del usuario.
	$query = 'SELECT principal FROM categoria WHERE usuario_id ='.'\''.$idUsuario.'\'';
	$result = $mysqli->query($query);
	foreach ($result as $row) {
		$categoriaP = $row['principal'];
	}
//Actualiza la fecha de ultimo ingreso
	$query = 'UPDATE usuario SET ultimo_ingreso='.'\''.date("Y-m-d H:i:s").'\''.' WHERE login ='.'\''.$login.'\'';
	$result = $mysqli->query($query);


	?>
<!-- Mostrar ultimo ingreso -->
	<header>
		<?php
			echo '<h6>Hola <b>'.$login.'</b> tu ultimo ingreso fue <b>'.$ui.'</b></h6>';
		?>
		<button type="button" class="btn btn-primary " onclick= "reload()"><img src="img/update.png" width="25px" heignt="25px"></button>
	</header>


<!-- HDA #1 y #2 -->
	<div class="card">
		<div class="card-header">
			Eventos  <button type="button" class="btn btn-warning"><img src="img/filtro.png" width="15px" height="auto"></button>
		</div>
		<div class="card-body"> 
<!-- HDA#1:
consulta los eventos que existe basado en # deasistentes-fecha-descripción.
Los eventos deben ser posteriores a la fecha de ultimo ingreso.
Permitir agendar uno de estos eventos mediante el boton asistir.
--> 
		<section id="tablePublicacion">
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Asistir al evento</th>
						<th scope="col">Numero de asistentes</th>
						<th scope="col">Fecha del evento</th>
						<th scope="col">Descripcion del eventoast</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$query = 'SELECT E.dsevento,E.feevento,COUNT(A.evento_id), E.id AS "idEvento" FROM evento E LEFT JOIN  agenda A ON E.id = A.evento_id WHERE E.feevento > '.'\''.$ui.'\' GROUP BY E.id ORDER BY e.feevento ASC';
					$result = $mysqli->query($query);
					foreach ($result as $row) {
						echo '<tr>
								<td>
									<form method="get" action="agendar.php">
										<input type="hidden" name="idUsuario" value="'.$idUsuario.'">
										<input type="hidden" name="idEvento" value="'.$row['idEvento'].'">
										<button type="submit" class="btn btn-primary"><img src="img/check.png" width="15px" heigth="20px"></button>
									</form>
								</td>
								<td>'.$row['COUNT(A.evento_id)'].'</td>
								<td>'.$row['feevento'].'</td>
								<td>'.$row['dsevento'].'</td>
							</tr>';
					}
					?>
				</tbody>
			</table>
		</section>
		<hr>
	<!-- HDA#2:
	consulta los eventos en los que esta registrado el usuario
	Permitir agendar uno de estos eventos mediante el boton asistir.--> 
		<aside>
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#verAgenda"><img src="img/agenda.png" whidth="40px" height="40px"><h4>Revisar mi agenda</h4></button>
				<!-- Modal -->
				<div class="modal fade" id="verAgenda" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"
					aria-hidden="true">
					<div class="modal-dialog modal-dialog-scrollable" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="verAgendaTitle">Mi agenda</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<table class="table">
									<thead class="thead-dark">
										<tr>
											<th scope="col">Descripcion del evento</th>
											<th scope="col">Fecha del evento</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$query = 'SELECT E.dsevento, E.feevento FROM evento E INNER JOIN agenda A ON A.evento_id = E.id WHERE A.usuario_id ='.'\''.$idUsuario.'\'';
										$result = $mysqli->query($query);
										foreach ($result as $row) {
											echo '<tr>
													<td>'.$row['dsevento'].'</td>
													<td>'.$row['feevento'].'</td>
												</tr>';
										}
										?>
									</tbody>
								</table>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</aside	>
	</div>
<!-- HDA #3 y #4 -->
<section class="card">
	<div class="card-header">PUBLICACIONES
	</div>
	<div class="card-body">
		<!-- HDA#3:
Consultar todas las publicaciones.
Actualizar el numero de likes de una publicacón agregandole 1.-->	
		<section id="tablePublicacion">
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Like</th>
						<th scope="col">Numero de likes</th>
						<th scope="col">Publicacion</th>
					</tr>
				</thead>
				<tbody>
					<?php
					try{
						$query = 'SELECT L.numLikes as "like", P.dspublicacion as "pub", P.id as "idP" FROM publicacion P INNER JOIN likes L ON P.id = L.publicacion_id';
						$result = $mysqli->query($query);
						foreach ($result as $row) {
							echo '<tr>
									<td>
										<form method="get" action="like.php">
											<input type="hidden" name="like" value="'.$row['like'].'">
											<input type="hidden" name="idP" value="'.$row['idP'].'">
											<button type="submit" class="btn btn-primary"><img src="img/like_off.png" width="15px" heigth="auto"></button>
										</form>
									</td>
									<td>'.$row['like'].'</td>
									<td>'.$row['pub'].'</td>
								</tr>';
						}
					}catch (Exception $e) {
						echo 'Excepción capturada: ',  $e->getMessage(), "\n";
					}
					?>
				</tbody>
			</table>
		</section> 
		<hr>
		<!-- HDA #4:
Insertar una nueva publicacion en el grupo principal del usuario-->
		<aside>
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#CrearPublicacion" width="70px" height="140px"><img src="img/doc.png" width="40px" height="40px">Crear publicación</button>
		</aside>
	</div>
</section>

<!-- HDA #5:
visalizar la información del usuario que ingresó
con los campos de Usuario, grupo principal y otros grupos.-->
<?php
// categoria secundarias del usuario.
	$categoriasS=" ";
	$query = 'SELECT nombre FROM categoria WHERE usuario_id ='.$idUsuario.' AND principal IS null';
    $result = $mysqli->query($query);
    foreach ($result as $row) {
    	 $categoriasS = $categoriasS.''.$row['nombre'].',';
    }

// categorias principal del usuario.
    $query = 'SELECT nombre FROM categoria WHERE usuario_id ='.$idUsuario.' AND principal=1';
    $result = $mysqli->query($query);
    foreach ($result as $row) {
        $categoriaP = $row['nombre'];
	}
	?>
	<footer>
        <?php
            echo '<p>Usuario: <b>'.$login.'</b> - Categoria principal: <b>'.$categoriaP.'</b> - Categorias secundarias: <b>'.$categoriasS.'</p>';
        ?>
	</footer>
	
	<script>
	function reload(){
		$(document).ready(function() {
   	 		location.reload();
		});   
	}
</script>
	<?php
		$mysqli->close();
	?>
</body>
</html>