<?php $this->load->view('template/header');?>

<div class="container">
<div class="row">
<div class="col-md-12">
    <h2>Exportar Pagos</h2>
    <form method="post">
    	
    	<fieldset>

        	
        <p  class="alert alert-info">Si se completa solamente una fecha de inicio, la consulta devolverá 1 solo día. </p>
		<p  class="alert alert-info">Si se completan las dos fechas, la consulta devolverá las operaciones que se inician dentro de ese rango de fechas.</p>
    	
    		<table class="table table-striped">
    			<tr>
    				<td><label for="usuario_id">Puntos de venta</label></td>
    				<td>
                        <p><input  class="todos" data-grupo="uno"  type="checkbox" name="todos" value="1" /> Seleccionar todos</p>
                        <div style="height: 200px; margin:20px; border: 1px solid #cccccc; overflow: auto;">

                                <?php foreach ($usuarios as $usuario): ?>

                                        <p><input  class="usuario" data-grupo="uno"  type="checkbox"  name="usuarios[]"  value="<?php echo $usuario['id']; ?>" <?php echo set_checkbox('usuarios[]',$usuario['id']); ?>  /> <?php echo $usuario['Nombre']; ?></p>

                                <?php endforeach; ?>

                        </div>
    				</td>
    			</tr>
    			
    			
                <tr>
                    <td><label for="fecha_desde">Fecha de inicio mayor que:</label></td>
                    <td><input type="text" id="fecha_desde" name="fecha_desde" class="calendario"></td>
                </tr>
                <tr>
                    <td><label for="fecha_hasta">Fecha de inicio menor que:</label></td>
                    <td><input type="text" id="fecha_hasta" name="fecha_hasta" class="calendario"></td>
                </tr>
                
                <tr>
                    <td><label for="pagos_pendientes">Solo pagos pendientes</label></td>
                    <td><input type="checkbox" id="pagos_pendientes" name="pagos_pendientes" value="1"> </td>
                </tr>
                
    			<tr>
    				<td></td>
    				<td><input type="submit" name="emision" value="Exportar Pagos" class="btn btn-primary btn-lg"></td>
    			</tr>
    		</table>
    		
    	</fieldset>
    
    </form>








</div><!-- col-12 -->
</div><!-- row -->
</div><!-- container -->

<?php $this->load->view('template/footer');?>