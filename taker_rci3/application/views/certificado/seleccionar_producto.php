<?php $this->load->view("template/header"); ?>
<div class="container">
    <div class="row">
    <div class="grid_12">
    	
    	<h2>Ingresar Datos</h2>
    	
        	<form id="datos_precargados" method="post" action="">
        		<table class="table table-bordered table-striped">

        			<tr>
        				<td>
        					<label>RUT o Pasaporte:</label> 
        					<input type="text" name="rut" id="campoRut" size="12" maxlength="20" /> 
        					<p><small>Ej: 11222333-K</small></p>
        				</td>
        				<td>
        					<label for="patente">Patente:</label>
        					<input type="text" name="patente" id="patente" size="8" maxlength="10" />
        					<p><small>Separar letras de números con guión medio. Ejemplos: AA-1234 o AAAA-12</small></p>
        				</td>
        				<td>	
        					<label>Dígito:</label> 
        					<input type="text" name="patente_digito" id="patente_digito" size="1" maxlength="1" /> 
        					
        					<!--Patente (trailer): <input type="text" name="trailer_patente" id="trailer_patente" size="8" maxlength="10" />
        					Dígito (trailer): <input type="text" name="trailer_digito" id="trailer_digito" size="1" maxlength="1" />-->
        				</td>
        			</tr>
        		</table>
        	</form>

        	<?php $this->load->view('certificado/productos_tabla'); ?>
        	
        </div>
    </div>
</div>
<?php $this->load->view("template/footer"); ?>