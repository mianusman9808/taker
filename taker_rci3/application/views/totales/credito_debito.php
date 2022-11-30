<?php $this->load->view('template/header'); ?>

<div class="container">
<div class="row">
<div class="col-md-6 col-md-offset-3">
 
    <h2>Sumatoria de créditos y débitos</h2>
    <p class="alert alert-info">Sumatoria de importes crédito y depósitos en la cuenta de vendedores</p>
    <table class="table table-stripped">
        <tr>
            <th>Usuario</th>
            <th>Apellido y nombre</th>
            <th>Crédito</th>
            <th>Débito</th>
            <th>Saldo</th>
        </tr>
        <?php foreach ($vendedores as $vendedor): ?>
        <tr>
            <td><?php echo $vendedor['username']; ?></td>
            <td><?php echo $vendedor['nombre']; ?></td>
            <td><?php echo $vendedor['importe_total']; ?></td>
            <td><?php echo $vendedor['debito_admin_total']; ?></td>
            <td><span class="badge badge-info"><?php echo round((float)$vendedor['importe_total']-(float)$vendedor['debito_admin_total'],2); ?></span></td>
        </tr>
        <?php endforeach; ?>
    </table>
    
</div>
</div>
</div>


<?php $this->load->view('template/footer'); ?>