<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Publicar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css">
</head>

<body>
    <H1 class="mi_color">Publicar</H1>
    <div>

    <?php

        // Conexion a la base de batos
        $cluster = Cassandra::cluster()
        ->withContactPoints('127.0.0.1')
        ->build();
        $sesion = $cluster->connect("redsocial");

        $query = 'SELECT publicaciones_id from publicaciones';
        $result = $sesion->execute($query);
        $cont = 0;
        foreach($result as $row){
            $cont = $cont + 1;
        }
        $cont = $cont + 1;

        $categoria_ppal = htmlspecialchars($_GET['categoria_ppal']);
        echo "Categoria principal: <b>".$categoria_ppal."</b>";
        echo "<br>";
        echo "<br>";

        echo    '<form method="get" action="insertPubli.php">
                    <textarea name="dspubli" placeholder="Descripción"></textarea>
                    <br>
                    <input type="hidden" value="'.$categoria_ppal.'" name="categoria_ppal">
                    <input type="hidden" value="'.$cont.'" name="publicaciones_id">
                    <input type="submit" value="Publicar" name="publicar" class="button mi_color">
                </form>';

    ?>
</body>
</html>