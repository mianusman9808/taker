<?php if (validation_errors()):
?>
<div class="alert alert-danger">
	<?php echo validation_errors(); ?>
</div>
<?php endif; ?>

<form action="<?php echo base_url(); ?>acceso/index" method="post">
	<fieldset>
		<div class="form-group">
			<label>Usuario</label>
			<input type="text" name="correo" maxlength="50" size="22" class="form-control" value="<?php echo set_value('correo'); ?>" />
		</div>

		<div class="form-group">
			<label>Contraseña</label>
			<input type="password" name="password" maxlength="50" size="22" class="form-control" />
		</div>
		<p>
			<input class="btn btn-lg btn-success btn-destacado btn-block" type="submit" value="Ingresar">
		</p>
	</fieldset>
</form>