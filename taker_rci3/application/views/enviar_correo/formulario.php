<?php $this->load->view('template/header'); ?>

<!-- include summernote -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/summernote.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/summernote.js"></script>
<script language="javascript">
	$(function() {
		$('textarea.wymeditor').summernote({
			height: 400,
			fronturl: "<?php echo base_url(); ?>", //PAGUIAR
			toolbar: [
				['style', ['style']],
				//['font', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
				['font', ['bold']],
				//['fontname', ['fontname']],
				// ['fontsize', ['fontsize']], // Still buggy
				//['color', ['color']],
				//['para', ['ul', 'ol', 'paragraph']],
				['para', ['ul', 'ol']],
				//['height', ['height']],
				//['table', ['table']],
				//['insert', ['link', 'picture', 'video', 'hr']],
				['insert', ['link']],
				['view', ['fullscreen', 'codeview']],

				//['help', ['help']]
			],
		});//summernote
	}); //jquery
</script>


<div class="container">
<div class="row">
<div class="col-md-12">
	
	<h2>Enviar correo</h2>
    
    <form method="post">
    	
    	<p class="alert alert-info">Están listados los vendedores que cuentan con un correo</p>
    	<p class="alert alert-info">Cada vendedor seleccionado debe tener asignado SOLO UN correo, de lo contrario no le llegará el correo</p>
    	
        <h2>Seleccionar destinatarios</h2>
        
        <p><input type="checkbox" name="todos" value="1" data-grupo="uno" class="todos" /> Seleccionar todos</p>
        
        <!--<p><a href="#" id="seleccionar_todos">Seleccionar/deseleccionar todos</a></p>-->
        

        
    	<div style="height: 200px; margin:20px; border: 1px solid #cccccc; overflow: auto;">
    		<table class="table table-striped">
	    		<?php foreach ($usuarios as $usuario): ?>
	    		<tr>
	    			<td>
	    				<input  data-grupo="uno" class="usuario" type="checkbox" name="usuarios[]" id="usuarios[]" value=<?php echo $usuario['id']; ?> <?php echo set_checkbox('usuarios[]',$usuario['id']); ?> /> <?php echo $usuario['Nombre']; ?>
	    			</td>
	    			<td>
	    				<?php echo $usuario['Email']; ?>
	    			</td>
	    		</tr>
	    		<?php endforeach; ?>
	    		
    		</table>
    	</div>
    	<h2>Mensaje</h2>
    	<table class="table table-striped">
			<tr>
				<td><label for="asunto">Asunto</label></td>
				<td><input type="text" name="asunto" id="asunto" value="<?php echo set_value('asunto'); ?>" style="width: 300px;" /></td>
			</tr>
			
			<tr>
				<td><label for="mensaje">Mensaje</label></td>
				<td>
					<textarea name="mensaje" id="mensaje" class="wymeditor"><?php echo set_value('mensaje'); ?></textarea>
				</td>
			</tr>
			
			<tr>
				<td></td>
				<td><input type="submit" name="enviar_correo" value="Enviar correo" class="btn btn-primary" /></td>
			</tr>
		</table>
    	
    </form>
    
</div><!-- col-12 -->
</div><!-- row -->
</div><!-- container -->
<?php $this->load->view('template/footer'); ?>
