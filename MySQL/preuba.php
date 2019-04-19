<?php
 
if(isset($_POST['submit']))
 
{
 
$name = $_POST['name'];
 
echo "User Has submitted the form and entered this name : <b> $name </b>";
 
echo "<br>You can use the following form again to enter a new name.";
 
}
 
?>
 
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
 
<input type="text" name="name"><br>
 
<input type="submit" name="submit" value="Submit Form"><br>
 
</form>


<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#CrearPublicacion">
Crear publicación
</button>
<?php
			if(isset($_POST['submit']))
			{
			$dspublicacion = $_POST['dspublicacion'];
			$query = 'INSERT INTO publicacion (dspublicacion, usuario_id, categoria_id
			VALUES ('.$dspublicacion.','.$idUsuario.','.$categoriaP.')';
			$result = $mysqli->query($query);
			}
			?>
<div class="modal fade" id="CrearPublicacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nueva publicación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	 	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Descripción:</label>
            <textarea class="form-control" id="message-text" name="dspublicacion	"></textarea>
			
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Crear</button>
      </div>
    </div>
  </div>
</div>