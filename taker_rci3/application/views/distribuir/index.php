<?php $this->load->view("template/header"); ?>
<div class="container">
<div class="row">
<div class="col-md-12">
	
	<h2>Distribuir certificados</h2>
	
	<form method="post">
		<fieldset>
			<legend>Usuarios de mi grupo</legend>
	
			<p>Debe seleccionar uno de los usuarios de su grupo para efectuar la operación:</p>
			
			<ul>
				<?php foreach ($usuarios as $usuario): ?>
					<li style="display: block;"><input type="radio" name="usuario_id" value="<?php echo $usuario['id']; ?>" <?php echo set_radio('usuario_id',$usuario['id']); ?> /> <?php echo $usuario['Nombre']; ?> <strong><?php echo $usuario['total']; ?></strong></li>
				<?php endforeach; ?>
			</ul>
			
		</fieldset>
	
		<fieldset>
			<legend>Sumatorias de certificados</legend>
			
			<p>Sus certificados: <?php echo $total_vendedor_organizador; ?><br />
			Certificados disponibles en el grupo: <?php echo ($total_grupo-$total_vendedor_organizador); ?><br />
			Total: <?php echo $total_grupo; ?></p>
		</fieldset>
		
		<fieldset>
			<legend>Operación</legend>
			<p>Cantidad: (Valores enteros, sin puntos ni comas) <input type="text" name="cantidad" value="<?php echo set_value('cantidad'); ?>" /></p>
		</fieldset>
	
	<p>
	    <input type="submit" name="agregar" value="Agregar" class="btn btn-success"> 
	    <input type="submit" name="quitar" value="Quitar" class="btn btn-primary">
	</p>
	
	</form>
	
</div><!-- col-12 -->
</div><!-- row -->
</div><!-- container -->

<?php $this->load->view("template/footer"); ?>