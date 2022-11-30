<?php $this->load->view('template/header'); ?>

<div class="container">
<div class="row">
<div class="col-md-12">
	<?php 
	/*
    <h2 id="page-heading">Descargas generales</h2>
    
    <p><a href="<?php echo BASEURL; ?>descargar_datos/usuarios" class="btn btn-default">Descargar usuarios</a></p>
    <!--
    <p><a href="<?php echo BASEURL; ?>descargar_datos/certificados" class="btn btn-default">Descargar  certificados</a></p>
    -->
    <p><a href="<?php echo BASEURL; ?>descargar_datos/cuenta" class="btn btn-default">Descargar   movimientos de la cuenta corriente</a></p>
	
	*/
	?>
    
    <h2>Emisión</h2>
    <form method="post">
    	
    	<fieldset>

        	
        <p  class="alert alert-info">Si se completa solamente una fecha de inicio de coberutura, la consulta devolverá 1 solo día. </p>
		<p  class="alert alert-info">Si se completan las dos fechas, la consulta devolverá las operaciones que se inician dentro de ese rango de fechas.</p>
    	
    		<table class="table table-striped">
    			<tr>
    				<td><label for="usuario_id">Punto de venta</label></td>
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
                    <td><label for="fecha_desde">Fecha de inicio de la cobertura</label></td>
                    <td><input type="text" id="fecha_desde" name="fecha_desde" class="calendario"></td>
                </tr>
                <tr>
                    <td><label for="fecha_hasta">Optativa: Fecha máxima de inicio de la cobertura</label></td>
                    <td><input type="text" id="fecha_hasta" name="fecha_hasta" class="calendario"></td>
                </tr>
                <tr>
                    <td><label for="aseguradora_id">Aseguradora</label></td>
                    <td>
                        <?php echo form_dropdown('aseguradora_id',$this->aseguradora_model->select(),1)?>
                    </td>
                </tr> 
    			
    			<!--
    			<tr>
    				<td><label for="tipo">Tipo de producto</label></td>
    				<td>
    					<select id="tipo" name="tipo">
    						<option value=""></option>
    						<?php foreach ($tipos as $tipo): ?>
    							<option value="<?php echo $tipo['tipo']; ?>"><?php echo $tipo['tipo']; ?></option>
							<?php endforeach; ?>
    					</select>
    				</td>
    			</tr>
    			-->
    			<tr>
    				<td><label for="validez">Validez</label></td>
    				<td>
    					<select id="validez" name="validez">
    						<option value=""  selected="selected"></option>
    						<option value="3">3 días</option>
    						<option value="5">5 días</option>
    						<option value="10">10 días</option>
    						<option value="30">30 días</option>
    					</select>
    				</td>
    			</tr>
    			<tr>
    			    <td><label>Solicitud</label></td>
    			    <td>
    			    <select name="solicitud">
    			        <option value="" <?php echo set_select('solicitud', ''); ?> >Todas</option>
    			        <option value="solicitud" <?php echo set_select('solicitud', 'solicitud', TRUE); ?> >Con Solicitudes</option>
    			        <option value="sin_solicitud" <?php echo set_select('solicitud', 'sin_solicitud'); ?> >Sin solicitud</options>
    			        <option value="anulada" <?php echo set_select('solicitud', 'anulada'); ?> >Anuladas</option>
    			        <option value="con_error" <?php echo set_select('solicitud', 'con_error'); ?> >Con error</option>
    			    </select>
    			    <p>
    			        <p class="alert alert-info">
    			        <b>Solicitudes</b>, son las operaciones que tienen número de solicitud en la aseguradora.<br />
    			        <b>Los certificados sin solicitud</b>, fueron emitidos pero la aseguradora no fué informada. (NO tienen número de solicitud)<br />
    			        <b>Las solicitudes anuladas</b>, fueron operaciones que fueron anuladas por el administrador (SI tienen un número de solicitud)<br />
                        <b>Las solicitudes con error</b>, fueron certificados emitidos, pero con error de solicitud</p>
    			    </p>
    			    </td>
    			</tr>
    			<tr>
    				<td></td>
    				<td><input type="submit" name="emision" value="Descargar emisión" class="btn btn-primary btn-lg"></td>
    			</tr>
    		</table>
    		
    	</fieldset>
    
    </form>
    
    <hr />
    <h2>Facturación</h2>
    <form method="post">
    
    	<fieldset>

    	
    		<table class="table table-striped">
    			<tr>
    				<td><label for="usuario_id_2">Punto de venta</label></td>
    				<td>
                        <p><input  class="todos" data-grupo="dos" type="checkbox" name="todos" value="1" /> Seleccionar todos</p>
                        <div style="height: 200px; margin:20px; border: 1px solid #cccccc; overflow: auto;">

                                <?php foreach ($usuarios as $usuario): ?>

                                        <p><input  class="usuario" data-grupo="dos"  type="checkbox"  name="usuarios[]" id="usuarios[]" value="<?php echo $usuario['id']; ?>" <?php echo set_checkbox('usuarios[]',$usuario['id']); ?>  /> <?php echo $usuario['Nombre']; ?></p>

                                <?php endforeach; ?>

                        </div>
    				</td>
    			</tr>
    			<tr>
    				<td><label for="fecha_desde_2">Fecha de inicio de la cobertura</label></td>
    				<td ><input type="text" id="fecha_desde_2" name="fecha_desde" class="calendario"></td>
    			</tr>
    			<tr>
    				<td><label for="fecha_hasta_2">Optativa: Fecha máxima de inicio de la cobertura</label></td>
    				<td><input type="text" id="fecha_hasta_2" name="fecha_hasta" class="calendario"></td>
    			</tr>
    			<!--
    			<tr>
    				<td><label for="tipo_2">Tipo de producto</label></td>
    				<td>
    					<select id="tipo_2" name="tipo">
    						<option value=""></option>
    						<?php foreach ($tipos as $tipo): ?>
    							<option value="<?php echo $tipo['tipo']; ?>"><?php echo $tipo['tipo']; ?></option>
							<?php endforeach; ?>
    					</select>
    				</td>
    			</tr>
    			-->
    			<tr>
    				<td><label for="validez_2">Validez</label></td>
    				<td>
    					<select id="validez_2" name="validez">
    						<option value=""  selected="selected"></option>
    						<option value="3">3 días</option>
    						<option value="5">5 días</option>
    						<option value="10">10 días</option>
    						<option value="30">30 días</option>
    					</select>
    				</td>
    			</tr>
    			
    			<tr>
    				<td><label for="cambio">Dolar</label></td>
    				<td>
    				    <b>$ <?php echo $dolar_oficial ?></b>
    				</td>
    			</tr>
    			
    		<tr>
                <td><label>Facturación:</label></td>
                <td>
                    <input type="checkbox" name="importar_a_sistema" value="1"  /> Importar datos al sistema de facturación.
                </td>

              </tr>  
    			
    			<tr>
					<td></td>
					<td><input type="submit" name="facturacion" value="Descargar facturación" class="btn btn-primary btn-lg" /></td>
				</tr>
    		</table>
    		
    	</fieldset>
    	
    </form>
    
    <hr />
    <h2>Facturación Puntos de venta</h2>
    <form method="post">
    
    	<fieldset>

    	
    		<table class="table table-striped">
    			<tr>
    				<td><label for="fecha_desde_3">Fecha de inicio de la cobertura</label></td>
    				<td><input type="text" id="fecha_desde_3" name="fecha_desde" class="calendario"></td>
    			</tr>
    			<tr>
    				<td><label for="fecha_hasta_3">Optativa: Fecha máxima de inicio de la cobertura</label></td>
    				<td><input type="text" id="fecha_hasta_3" name="fecha_hasta" class="calendario"></td>
    			</tr>
    			
    			<tr>
    				<td><label for="cambio2">Dolar</label></td>
    				<td>
                        <b>$ <?php echo $dolar_oficial ?></b>
    				</td>
    			</tr>
    			         <tr>
                <td><label>Facturación:</label></td>
                <td>
                    <input type="checkbox" name="importar_a_sistema" value="1"  /> Importar datos al sistema de facturación.
                </td>

              </tr> 
    			
    			
    			<tr>
					<td></td>
					<td><input type="submit" name="facturacion_puntos_venta" value="Descargar facturación puntos de venta" class="btn btn-primary btn-lg"></td>
				</tr>
    		</table>
    		
    	</fieldset>
    	
    </form>
    
</div><!-- col-12 -->
</div><!-- row -->
</div><!-- container -->
<?php $this->load->view('template/footer'); ?>
