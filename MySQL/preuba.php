<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
<table id="tableM">
				<tr>
					<td>
						<form name="q1" action="home.php" method="get">
							<!-- filtro_fecha con valor 1  indica que debe buscar todo -->
							<input type="hidden" name="filtro_fecha" value="1" >
							<input type="hidden" name="login" value="<?php echo $login;?>" >
							<button type="submit" class="btn btn-warning"><img src="img/filtro.png" width="15px" height="auto">Sin filtro</button>
						</form>
					</td>
					<td>
						<form name="q0" action="home.php" method="get">
							<!-- filtro_fecha con valor 2 indica que debe buscar solo sobre la fecha de ultimo ingreso -->
							<input type="hidden" name="filtro_fecha" value="2" >
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
</body>
</html>



<?php
						try{
							$result = $mysqli->query($query);
							foreach ($result as $row) {
								
							}
						}catch (Exception $e) {
							echo 'Excepción capturada: ',  $e->getMessage(), "\n";
						}
					?>