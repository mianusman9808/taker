<?php $this->load->view('template/header'); ?>

<div class="container">
<div class="row">
<div class="col-md-6 col-md-offset-3">
 
    <h2>Sumatorias de importes</h2>
    <p class="alert alert-info">Sumatoria de importes de la cuenta del vendededor. 
        Crédito otorgado menos los productos que se venden.</p>
    <table class="table table-stripped">
    	<tr>
		    <th>Vendedor ID</th>
    		<th>Vendedor</th>
    		<th>Apellido y nombre</th>
    		<th>Importe total</th>

    	</tr>
    	<?php foreach ($vendedores as $vendedor): ?>
    	<tr>
			<td><?php echo $vendedor['id']; ?></td>
    		<td><?php echo $vendedor['username']; ?></td>
    		<td><?php echo $vendedor['nombre']; ?></td>
    		<td><?php echo $vendedor['importe_total']; ?></td>

    	</tr>
    	<?php endforeach; ?>
    </table>
    
</div>
</div>
</div>


<?php $this->load->view('template/footer'); ?>