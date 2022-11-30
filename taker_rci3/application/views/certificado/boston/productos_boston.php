    <p><img src="<?php echo base_url()?>images/boston_seguros.jpg"/></p>
    <div class="clearfix"></div>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td style="background-color: rgb(255, 249, 198);width: 25%">
                    <h3>3 días</h3>
                    <table class="table  table-striped table-bordered">
                    <?php foreach ($productos as $producto): ?>
                        <?php if($producto['validez']=='3' and $producto['aseguradora_id']==2): ?>
                            
                            <tr><td><a href="<?php echo BASEURL; ?><?php echo $operacion;?>/agregar/<?php echo $producto['id']; ?>" class="producto_link"><?php echo $producto['nombre']; ?></a></td><td><?php echo number_format($producto['debito']+$producto['comision'],2); ?></td></tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </table>
                </td>

                <td style="width: 25%;">
                    <h3>10 días</h3>

                    <table class="table  table-striped table-bordered">
                    <?php foreach ($productos as $producto): ?>
                        <?php if($producto['validez']=='10'  and $producto['aseguradora_id']==2): ?>
                            
                            <tr>
                               <td>
                                    <a href="<?php echo BASEURL; ?><?php echo $operacion;?>/agregar/<?php echo $producto['id']; ?>" class="producto_link"><?php echo $producto['nombre']; ?></a>

                               </td>
                               <td><?php echo number_format($producto['debito']+$producto['comision'],2); ?></td>
                            </tr>

                        <?php endif; ?>
                    <?php endforeach; ?>
                    </table>

                </td><!-- 10 dias-->
                
                <td style="width: 25%;background-color: rgb(255, 249, 198);">
                    <h3>15 días</h3>
                    <table class="table  table-striped table-bordered">
                    <?php foreach ($productos as $producto): ?>
                        <?php if($producto['validez']=='15' and $producto['aseguradora_id']==2): ?>
                            
                            <tr><td><a href="<?php echo BASEURL; ?><?php echo $operacion;?>/agregar/<?php echo $producto['id']; ?>" class="producto_link"><?php echo $producto['nombre']; ?></a></td><td><?php echo number_format($producto['debito']+$producto['comision'],2); ?></td></tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </table>
                </td><!-- 15 dias -->                
                
                <td style="width: 25%">
                    <h3>30 días</h3>
                    <!--
                    <div class="alert alert-danger">MICROBUS: Máximo 45 asientos</div>
                    <div class="alert alert-danger"> CAMIONES, REMOLQUES O SEMIS: Se excluyen cargas pelligrosas</div>
                    -->
                    <table class="table  table-striped table-bordered">
                    <?php foreach ($productos as $producto): ?>
                        <?php 
                           if($producto['validez']=='30'  and $producto['aseguradora_id']==2): ?>
                            <tr>
                                <td><a href="<?php echo BASEURL; ?><?php echo $operacion;?>/agregar/<?php echo $producto['id']; ?>" class="producto_link"><?php echo $producto['nombre']; ?></a>

                                </td>
                                <td><?php echo number_format($producto['debito']+$producto['comision'],2); ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </table>
                    

                </td>
            </tr>
        </tbody>
    </table>