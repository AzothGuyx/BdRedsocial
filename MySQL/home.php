<html lang="es">
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

	$query = 'SELECT id FROM categoria WHERE usuario_id ='.'\''.$idUsuario.'\' AND principal=1';
	$result = $mysqli->query($query);
	foreach ($result as $row) {
		$categoriaP = $row['id'];
	}
//Actualiza la fecha de ultimo ingreso
	$query = 'UPDATE usuario SET ultimo_ingreso='.'\''.date("Y-m-d H:i:s").'\''.' WHERE login ='.'\''.$login.'\'';
	$result = $mysqli->query($query);
	
// Fecha de ultimo acceso -  para filtro. Valor igual a -1 (menos uno) indica que debe consultar y actualizar
	
	if( isset( $_GET["filtro_fecha"] ) ){
		$filtro_fecha = htmlspecialchars($_GET["filtro_fecha"]);
	} else {
		echo "<H3>Falta el argumento filtro_fecha</H3>";
		exit(0);
	}
	if( isset( $_GET["publicacion"] ) ){
		$publicacion = htmlspecialchars($_GET["publicacion"]);
	} else {
		echo "<H3>Falta el argumento publicacion#</H3>";
		exit(0);
	}
	if( isset( $_GET["dspub"] ) ){
		$dspub="";
		$dspub = htmlspecialchars($_GET["dspub"]);
	} else {
		echo "<H3>Falta el argumento descripcion</H3>";
		exit(0);
	}
	
	
	?>
<!-- Mostrar ultimo ingreso -->

	<div class="jumbotron jumbotron-fluid">
 		<div class="container">
    		<h1 class="display-4"><img src="img/bd.png" width="60px" height="60px">  MySQL o MariaDB</h1>
    		<p class="lead">Es un sistema de gestión de base de datos relacional (RDBMS) de código abierto, basado en lenguaje de consulta estructurado (SQL).</p>
	  </div>
	</div>
	<header>
		<?php
			echo '<h6><img src="img/user.png" width="35px" height="35px" class="img-thumbnail">  <b>'.$login.'</b> ultimo ingreso fue <b>'.$ui.'</b></h6>';
		?>
	</header>
	<span  type="button" id="botonFixed" class="btn btn-primary " onclick= "reload()"><img src="img/update.png" width="50px" height="50px"></span>

<!-- HDA #1 y #2 -->
	<div class="card">
		<div class="card-header">
		<b>EVENTOS:</b>
		</div>
		<div class="card-body"> 
<!-- HDA#1:
consulta los eventos que existe basado en # deasistentes-fecha-descripción.
Los eventos deben ser posteriores a la fecha de ultimo ingreso.
Permitir agendar uno de estos eventos mediante el boton asistir.
--> 
			<table id="tableM">
				<tr>
					<td>
						<form name="q1" action="home.php" method="get">
							<!-- filtro_fecha con valor 0 indica que debe buscar todo -->
							<input type="hidden" name="filtro_fecha" value="0" >
							<input type="hidden" name="dspub" value="" >
							<input type="hidden" name="publicacion" value="0" >							
							<input type="hidden" name="login" value="<?php echo $login;?>" >
							<button type="submit" class="btn btn-warning"><img src="img/filtro.png" width="15px" height="auto">Sin filtro</button>
						</form>
					</td>
					<td>
						<form name="q0" action="home.php" method="get">
							<!-- filtro_fecha con valor -1 indica que debe buscar solo sobre la fecha de ultimo ingreso -->
							<input type="hidden" name="filtro_fecha" value="-1" >
							<input type="hidden" name="publicacion" value="0" >
							<input type="hidden" name="dspub" value="" >
							<input type="hidden" name="login" value="<?php echo $login;?>" >
							<button type="submit" class="btn btn-warning"><img src="img/filtro_on.png" width="15px" height="auto">Con filtro</button>
						</form>
					</td>
				</tr>
			</table>
			<table id="tableM" class="table">
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
					if ($filtro_fecha == 0){
						$query = 'SELECT E.dsevento,E.feevento,COUNT(A.evento_id), E.id AS "idEvento" FROM evento E LEFT JOIN  agenda A ON E.id = A.evento_id  GROUP BY E.id ORDER BY e.feevento ASC';
					}else{
						$query = 'SELECT E.dsevento,E.feevento,COUNT(A.evento_id), E.id AS "idEvento" FROM evento E LEFT JOIN  agenda A ON E.id = A.evento_id WHERE E.feevento > '.'\''.$ui.'\' GROUP BY E.id ORDER BY e.feevento ASC';
					}
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
		<hr>
	<!-- HDA#2:
	consulta los eventos en los que esta registrado el usuario
	Permitir agendar uno de estos eventos mediante el boton asistir.--> 
		<div>
			<button type="button" id="btnCentral" class="btn btn-success" data-toggle="modal" data-target="#verAgenda"><img src="img/agenda.png" whidth="40px" height="40px"><h4>Revisar mi agenda</h4></button>
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
		</div>
	</div>
<!-- HDA #3 y #4 -->
	<div class="card">
		<div class="card-header">PUBLICACIONES</div>
		<div class="card-body">
<!-- HDA#3:
Consultar todas las publicaciones.
Actualizar el numero de likes de una publicacón agregandole 1.-->
			<table id="tableM">
				<tr>
					<td>
						<form name="q1" action="home.php" method="get">
							<!-- filtro_fecha con valor 1  indica que debe buscar todo -->
							<input type="hidden" name="dspub" value="" >
							<input type="hidden" name="filtro_fecha" value="1" >
							<input type="hidden" name="publicacion" value="0" >
							<input type="hidden" name="login" value="<?php echo $login;?>" >
							<button type="submit" class="btn btn-warning"><img src="img/filtro.png" width="15px" height="auto">Sin filtro</button>
						</form>
					</td>
					<td>
						<form name="q0" action="home.php" method="get">
							<!-- filtro_fecha con valor 2 indica que debe buscar solo sobre la fecha de ultimo ingreso -->
							<input type="hidden" name="filtro_fecha" value="0">
							<input type="hidden" name="dspub" value="" >
							<input type="hidden" name="publicacion" value="0" >
							<input type="hidden" name="login" value="<?php echo $login;?>" >
							<button type="submit" class="btn btn-warning"><img src="img/filtro_on.png" width="15px" height="auto">Con filtro</button>
						</form>
					</td>
				</tr>
			</table>
			<table id="tableM" class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Like</th>
						<th scope="col">Numero de likes</th>
						<th scope="col">Publicacion</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if ($filtro_fecha == 1){
						$query = 'SELECT L.numLikes as "like", P.dspublicacion as "pub", P.id as "idP" FROM publicacion P INNER JOIN likes L ON P.id = L.publicacion_id';
					}else{
						$query = 'SELECT L.numLikes AS "like", P.dspublicacion AS "pub", P.id AS "idP",categoria_id FROM publicacion P INNER JOIN likes L ON P.id = L.publicacion_id WHERE categoria_id IN (SELECT id FROM categoria WHERE usuario_id='.$idUsuario.')';
					}
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
					?>
				</tbody>
			</table>
<!-- HDA #4:
qInsertar una nueva publicacion en el grupo principal del usuario-->
			<div>
				<p>
					<button id="btnCentral" class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
						<img src="img/doc.png" width="40px" height="40px"><h4>Crear publicación<h4>
					</button>
				</p>
				<div class="collapse" id="collapseExample">
					<div class="card card-body">
						<form name="q3" action="home.php" method="get">
							<!-- filtro_fecha con valor 0 indica que debe buscar todo -->
							<input type="hidden" name="filtro_fecha" value="-1" >
							<input type="hidden" name="publicacion" value="0" >
							<input type="hidden" name="login" value="<?php echo $login;?>">
							<input name="dspub">
							<button type="submit" class="btn btn-warning">Crear publicacion</button>
						</form>
						<?php
							try{
								if ($publicacion == 0 and !$dspub==""){
							
									echo "Descripcion: ".$dspub."<br>";
									echo "usuario: ".$idUsuario."<br>";
									echo "Categoria: ".$categoriaP."<br>";
									$query = 'INSERT INTO publicacion(dspublicacion, usuario_id, categoria_id) VALUES ('.'\''.$dspub.'\','.'\''.$idUsuario.'\','.'\''.$categoriaP.'\')';
									$result = $mysqli->query($query);
									echo '<form name="q3" action="home.php" method="get">
											  <input type="hidden" name="login" value="'.$login.'" >
											  <input type="hidden" name="dspub" value="" >
											  <input type="hidden" name="filtro_fecha" value="-1" >
											  <input type="hidden" name="publicacion" value="0" >
											<button type="submit" class="btn btn-warning">Confirmar</button>
											</form>';
								}
								

								$dspub="";	
							}catch (Exception $e) {
								echo 'Excepción capturada: ',  $e->getMessage(), "\n";
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

<!-- HDA #5:
visalizar la información del usuario que ingresó
con los campos de Usuario, grupo principal y otros grupos.-->
<?php
// categoria secundarias del usuario.
	$categoriasS=" ";
	$query = 'SELECT nombre FROM categoria WHERE usuario_id ='.$idUsuario.' AND principal IS null';
    $result = $mysqli->query($query);
    foreach ($result as $row) {
    	 $categoriasS = $categoriasS.''.$row['nombre'].' ';
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
            echo '<p>Usuario: <b>'.$login.'</b> - Categoria principal: <b>'.$categoriaP.'</b> - Categorias secundarias: <b>'.$categoriasS.'.</p>';
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