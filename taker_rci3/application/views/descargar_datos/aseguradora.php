<?php $this->load->view('template/header'); ?>

<div class="container">
<div class="row">
<div class="col-md-12">
    
 
    <h2>Exportar emisión de certificados</h2>

    <form method="post">
    	
    	<fieldset>

        	
        <p  class="alert alert-info">Si se completa solamente una fecha de inicio de coberutura, la consulta devolverá 1 solo día. </p>
		<p  class="alert alert-info">Si se completan las dos fechas, la consulta devolverá las operaciones que se inician dentro de ese rango de fechas.</p>
    	
    		<table class="table table-striped">
    			
    			
    			
                <tr>
                    <td><label for="fecha_desde">Fecha mínima de inicio de la cobertura</label></td>
                    <td><input type="text" id="fecha_desde" value="<?php echo set_value('fecha_desde')?>" name="fecha_desde" class="calendario"></td>
                </tr>
                <tr>
                    <td><label for="fecha_hasta">Optativa: Fecha máxima de inicio de la cobertura</label></td>
                    <td><input type="text" id="fecha_hasta" value="<?php echo set_value('fecha_hasta')?>" name="fecha_hasta" class="calendario"></td>
                </tr>
                
    			
    			
    			
    			
    			
    			<tr>
    				<td></td>
    				<td><input type="submit" name="emision" value="Descargar emisión" class="btn btn-primary btn-lg"></td>
    			</tr>
    		</table>
    		
    	</fieldset>
    
    </form>
    
    <hr />

    
</div><!-- col-12 -->
</div><!-- row -->
</div><!-- container -->
<?php $this->load->view('template/footer'); ?>
