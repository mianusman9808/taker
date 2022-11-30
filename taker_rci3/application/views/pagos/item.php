<?php if (!$pagos):?>
    <div class="alert alert-success">
        <h4>No registra transferencias pendientes</h4>
    </div>
<?php endif ?>

<?php foreach($pagos as $pago):?>

        <?php if (!$pago['cancelado']):?>
            <div class="alert alert-danger">
                <p>Transferencia Pendiente: 
                    <b><?php echo fecha_humana($pago['fecha_hora_desde']) ?></b> al 
                    <b><?php echo fecha_humana($pago['fecha_hora_hasta']) ?></b>
                </p>
         <?php else: ?>
                <div class="alert alert-success">
                <p>Transferencia Recibida: 
                    <b><?php echo fecha_humana($pago['fecha_hora_desde']) ?></b> al 
                    <b><?php echo fecha_humana($pago['fecha_hora_hasta']) ?></b>
                </p>
         <?php endif; ?>
                <p>
                USD <?php echo $pago['total']?>, 
                $Chilenos <?php echo round($pago['total']*$pago['peso_chileno'],2);?>
                </p>

        <?php /*
        <p>Importe: USD <?php echo $pago['importe']?></p>
        */ ?>
        <p>
            <a href="<?php echo base_url(); ?>pagos/detalle/<?php echo $pago['id'] ?>" class="btn btn-default">Ver Detalle</a> 
            <small>Dolar: <?php echo $pago['dolar_oficial']?>, 
            <?php /*
            Cotización Dolar Paralelo: <?php echo $pago['dolar_paralelo']?>, 
            */ ?>
            Cotización Peso Chileno: <?php echo $pago['peso_chileno']?>
            <?php /*
            Descuento: <?php echo $pago['porcentaje_descuento']?>%
            */ ?>
            </small>
        </p>
        <?php /*
        <p>Total: USD <?php echo $pago['total']?></p>
        <p>Total: $chilenos <?php echo round($pago['total']*$pago['peso_chileno'],2);?></p>
        */ ?>
        
    </div>
<?php endforeach ?>