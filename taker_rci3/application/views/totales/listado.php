<?php $this->load->view('template/header'); ?>

<div class="container">
<div class="row">
<div class="col-md-6 col-md-offset-3">
 
    <h2>Totales por usuario</h2>
    
    <table class="table table-stripped">
    	<tr>
    		<th>Usuario</th>
    		<th>Apellido y nombre</th>
    		<th>Saldo</th>
    	</tr>
    	<?php foreach ($vendedores as $vendedor): ?>
    	<tr>
    		<td><?php echo $vendedor['username']; ?></td>
    		<td><?php echo $vendedor['Nombre']; ?></td>
    		<td><?php echo $vendedor['credito_total']; ?></td>
    	</tr>
    	<?php endforeach; ?>
    </table>
    
</div>
</div>
</div>


<?php $this->load->view('template/footer'); ?>