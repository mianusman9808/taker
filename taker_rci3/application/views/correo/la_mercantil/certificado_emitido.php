<h2>TAKER RCI</h2>
<h3>La Mercantil</h3> 
		
<p>Número Certificado: <?php echo $certificado['Numero']; ?></p>
<p>Conductor: <?php echo $certificado['conductor']; ?></p>
<p>Asegurado: <?php echo $certificado['Nombre']; ?></p>
<p>RUT: <?php echo $certificado['Rut']; ?></p>
<p>Domicilio: <?php echo $certificado['Domicilio']; ?></p>
<p>Localidad: <?php echo $certificado['Localidad']; ?></p>
<p>País: <?php echo $certificado['Pais']; ?></p>
<p>Vigencia Desde las <?php echo $desdeHoras; ?> del <?php echo $desdeDias; ?></p>
<p>Vigencia Hasta: <?php echo $certificado['FechaHasta']; ?></p>

<p>Producto: <b><?php echo $producto['nombre']; ?></b></p>

<p>Tipo: <?php echo $producto['tipo']; ?></p>

<p>Motor: <?php echo $certificado['Motor']; ?></p>
<p>Marca: <?php echo $certificado['Marca']; ?></p>
<p>Chasis: <?php echo $certificado['Chasis']; ?></p>
<p>Modelo: <?php echo $certificado['Modelo']; ?></p>
<p>Uso: <?php echo $certificado['Uso']; ?></p>
<p>Año: <?php echo $certificado['Anio']; ?></p>
<p>Patente: <?php echo $certificado['Patente']; ?></p>
<p>Digito: <?php echo $certificado['digito']; ?></p>

<?php if($producto['trailer']): ?>
	<p>Trailer eje: <?php echo $certificado['trailer_eje']; ?></p>
	<p>Trailer Marca: <?php echo $certificado['trailer_marca']; ?></p>
	<p>Trailer Modelo: <?php echo $certificado['trailer_modelo']; ?></p>
	<p>Trailer Anio: <?php echo $certificado['trailer_anio']; ?></p>
	<p>Trailer Patente: <?php echo $certificado['trailer_patente']; ?></p>
	<p>Trailer Digito: <?php echo $certificado['trailer_digito']; ?></p>
	<p>Trailer Uso: <?php echo $certificado['trailer_uso']; ?></p>
	<p>Trailer Chasis: <?php echo $certificado['trailer_chasis']; ?></p>
	<p>Trailer Propietario: <?php echo $certificado['trailer_propietario']; ?></p>
<?php endif; ?>