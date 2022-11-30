<?php $this->load->view("template/header"); ?>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2>Sumatoria de pagos adeudados</h2>
            <table class="table table-stripped">
                <tr>
                    <th>Vendedor ID</th>
                    <th>Vendedor</th>

                    <th>Deuda total</th>
                    <th></th>
                </tr>
                <?php foreach ($pagos as $pago): ?>
                <tr>
                    <td><?php echo $pago['user_id']; ?></td>
                    <td><?php echo $pago['vendedor']; ?></td>

                    <td><?php echo $pago['importe']; ?></td>
                    <td><a href="<?php 
                        $url="pagos/index?g_action=search&g_pagos_user_id={$pago['user_id']}&g_pagos_cancelado=0";
                        echo base_url($url);?>" class="btn btn-default">Solicitudes de pago</td></td>
                </tr>
                <?php endforeach; ?>
            </table>
            
            
            <pre>
                <?php //print_r($pagos); ?>
            </pre>

        </div>

     </div>
</div>

<?php $this->load->view("template/footer"); ?>