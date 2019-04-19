<html lang="en">
    <head>
        <meta charset="UTF-8">
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

/* ==--> Aqui ustede debe hacer la conexion a la base de datos*/
// Documentacion https://www.php.net/manual/es/book.mysqli.php
// Create connection (Puerto, Usuario, Clave y base datos)
        $mysqli  = new mysqli('localhost', 'root', '','redes_sociales');
        if ($mysqli->connect_errno) {
            echo "Fall� la conexi�n a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            exit(0);
        }

        try{
            $like = htmlspecialchars($_GET['like']);
            $idP = htmlspecialchars($_GET['idP']);
            echo $like;
            echo $idP;
            $numLike = 0;
            $numLike = $like + 1;
            $query ='UPDATE likes SET numLikes = '.$numLike.' WHERE publicacion_id ='.$idP.'';
            $result = $mysqli->query($query);
            echo'Like registrado';
        }catch (Exception $e) {
             echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
        ?>
        
</body>
</html>