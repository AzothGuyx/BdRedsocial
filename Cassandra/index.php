<?PHP
/*
	Creado por Sergio Alvarez
	Version 1.0 - 2019/03/30
	Tecnicas avanzadas de base de datos - UDEM

  _   _  ____        __  __           _ _  __ _                
 | \ | |/ __ \      |  \/  |         | (_)/ _(_)               
 |  \| | |  | |     | \  / | ___   __| |_| |_ _  ___ __ _ _ __ 
 | . ` | |  | |     | |\/| |/ _ \ / _` | |  _| |/ __/ _` | '__|
 | |\  | |__| |     | |  | | (_) | (_| | | | | | (_| (_| | |   
 |_| \_|\____/      |_|  |_|\___/ \__,_|_|_| |_|\___\__,_|_|   
                                                               
	Notas: 
	* No tiene codigo en PHP es pagina inicio
*/
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Login Practica - Cassandra</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<H1 class="mi_color">Cassandra</H1>
<div>
<H3>Ingreso al módulo de redes sociales</H3>
	<!-- Formulario de Ingreso -->
	<form name="q1" action="home.php" method="get">
		<!-- filtro_fecha con valor -1 indica que debe buscar y actualizar la fecha de ingreso -->
		<input type="hidden" name="filtro_fecha" value="-1" >
		<table>
			<tr>
				<td>Usuario:</td>
				<td><input type="text" name="login" value="stephanie"  maxlength="10"></td>
			</tr>
		  	<tr>
		  		<td>Clave:</td>
			  	<td><!-- <input type="password" name="clave" value=""  maxlength="10"></td></tr> -->
		  	<tr>
			</tr>
				<td> </td>
			<tr>
				<td> </td>
			</tr>
			<tr>
				<td> </td>
			</tr>
		  	<tr>
			  	<td colspan="2"><button class="button mi_color">Ingreso</button></td>
			</tr>
		</table>  
	</form>

</div>

</body>
</html>