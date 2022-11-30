<?php $this->load->view('template/header');?>

<div class="container">
<div class="row">
    <div class="col-md-6">

        <h2>Dolar: $ <?php echo $dolar_oficial ?></h2>
        <?php /* Dolar paralelo no se usa
        <table class="table table-stripped" style="width: auto">
            <tr><td style="text-align: right">Dolar:</td><td><h4>$ <?php echo $dolar_oficial ?></h4></td></tr>
            
            <tr><td style="text-align: right">Dolar Paralelo:</td><td><h4>$ <?php echo $dolar_paralelo ?></h4></td></tr>
            <tr><td style="text-align: right">Porcentaje Descuento:</td><td><h4>% <?php echo $porcentaje_descuento ?></h4></td></tr>
            
        </table>
        */ ?>
     </div><!-- col-md-6 -->
     <div class="col-md-6">
         <h2>Consultar movimientos</h2>       
        <form method="post" action="<?php echo base_url()?>pagos/consultar">
        <table class="table table-stripped" style="width: auto">      
                <tr>
                    <td><label for="fecha_desde_2">Desde:</label></td>
                    <td><input type="text" id="fecha_desde_2" name="fecha_desde" class="calendario" value="<?php echo set_value('fecha_desde')?>"></td>
                </tr>
                <tr>
                    <td><label for="fecha_hasta_2">Hasta:</label></td>
                    <td><input type="text" id="fecha_hasta_2" name="fecha_hasta" class="calendario" value="<?php echo set_value('fecha_hasta')?>"></td>
                </tr>
                <tr>
                    <td><label for="fecha_hasta_2">Facturación</label></td>
                    <td >
                        <select name="facturacion">
                            <option value="Mensual" <?php echo set_select('facturacion','Mensual')?>>Mensual</option>
                            <option value="Semanal" <?php echo set_select('facturacion','Semanal')?>>Semanal</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td></td>
                    <td><input type="submit" value="Aceptar" class="btn btn-primary" /></td>
                </tr>
        </table>
        </form>
        </div><!-- col-md-6 -->
        
        <div class="col-md-12">
        <?php if ($cuentas):?>
        <h2><?php echo $facturacion;?>: <?php echo fecha_humana($fecha_desde);?> / <?php echo fecha_humana($fecha_hasta);?></h2>
        
            <form method="post" action="<?php echo base_url()?>pagos/agregar">
            <input name="fecha_desde" type="hidden" value="<?php echo $fecha_desde;?>"  />
            <input name="fecha_hasta" type="hidden"  value="<?php echo $fecha_hasta;?>" />
            
            <table class="table table-stripped" >
                <tr>
                    <th></th>
                    <th>Vendedor</th>
                    <th>Saldo</th>
                    <!--
                    <th>Descuento</th>
                    -->
                    <th>Total</th>
                    <th></th>
                </tr>    
                <?php foreach ($cuentas as $cuenta):
                    //$descuento=round($cuenta['total']*$porcentaje_descuento/100,2);
                    //$total= round($cuenta['total']-$descuento,2);
                    $total= round($cuenta['total'],2);
                    ?>
                    <tr>
                        <td><input name="usuario_id[]" value="<?php echo $cuenta['user_id']?>" type="checkbox"  checked="checked" /></td>
                        <td><?php echo $cuenta['usuario_nombre'] ?></td>
                        <td>$<?php echo $cuenta['total'] ?></td>
                        <?php /* <td>$<?php echo $descuento;?></td> */ ?>
                        <td><b>$<?php echo $total ?></b></td>
                        <td><a href="<?php echo base_url();?>pagos/detalle_by_fecha/<?php echo $cuenta['user_id']?>/<?php echo solo_fecha($fecha_desde)?>/<?php echo solo_fecha($fecha_hasta)?>" class="btn btn-default">Detalle</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            
            <p class="boton">
                
                <input type="submit" class="btn btn-primary" value="Agregar Solicitudes de Pago" />
            </p>
            </form>
        <?php endif; //Cuentas ?>
        
</div><!-- col-12 -->
</div><!-- row -->
</div><!-- container -->

<?php $this->load->view('template/footer');?>