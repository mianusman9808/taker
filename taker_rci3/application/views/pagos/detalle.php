<?php $this->load->view('template/header');?>
<div class="container">
<div class="row">
<div class="col-md-12">

        <h2>Detalle</h2>
        <h3><?php echo $usuario['Apellido']?> <?php echo $usuario['Nombre']?></h3>
        <h3>Facturación: <?php echo $usuario['facturacion']?></h3>
        
        <?php if ($cuentas): $total=0;?>
            <h3><?php echo fecha_humana($fecha_desde);?> / <?php echo fecha_humana($fecha_hasta);?></h3>
            <table class="table table-stripped">
                <tr>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Concepto</th>
                    <th>Importe USD</th>
                </tr>    
                <?php foreach ($cuentas as $cuenta):?>
                    <tr>
                        <td><?php echo $cuenta['fecha_hora'] ?></td>
                        <td><?php echo $cuenta['tipo'] ?></td>
                        <td><?php echo $cuenta['concepto'] ?></td>
                        <td><?php echo $cuenta['importe'];$total+=$cuenta['importe']; ?></td>
                    </tr>
                <?php endforeach; ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><h4>USD <?php echo $total?></h4></td>
                    </tr>
            </table>
        <?php endif ?>
        <p class="boton">
            <a href="javascript:history.back();" class="btn btn-default">Volver</a>
        </p>
</div><!-- col-12 -->
</div><!-- row -->
</div><!-- container -->

<?php $this->load->view('template/footer');?>