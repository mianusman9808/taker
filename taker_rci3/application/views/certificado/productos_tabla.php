<!-- BOSTON ANULADO --------------------------- -->	
<?php //$this->load->view("certificado/boston/productos_boston");?>

	
<!-- LA MERCANTIL --------------------------- --> 
	
    <p><img src="<?php echo base_url()?>images/mercantil_andina.jpg" /></p>
    <div class="clearfix"></div>
	<table class="table table-bordered">
		<tbody>
			<tr>
				<td style="background-color: rgb(255, 249, 198);">
					<h3>3 días</h3>
					<table class="table  table-striped table-bordered">
					<?php foreach ($productos as $producto): ?>
					    
						<?php if($producto['validez']=='3'  and $producto['aseguradora_id']==1): ?>
						    <?php if($producto['template']=='trailer'){continue;}?>
							<tr><td><a href="<?php echo BASEURL; ?><?php echo $operacion;?>/agregar/<?php echo $producto['id']; ?>" class="producto_link"><?php echo $producto['nombre']; ?></a></td><td><?php echo number_format($producto['debito']+$producto['comision'],2); ?></td></tr>
						<?php endif; ?>
						
					<?php endforeach; ?>
				    </table>
				</td>
				<td>
					<h3>5 días</h3>
					<table class="table  table-striped table-bordered">
					<?php foreach ($productos as $producto): ?>
						<?php if($producto['validez']=='5' and $producto['aseguradora_id']==1): ?>
						    <?php if($producto['template']=='trailer'){continue;}?>
							<tr><td><a href="<?php echo BASEURL; ?><?php echo $operacion;?>/agregar/<?php echo $producto['id']; ?>" class="producto_link"><?php echo $producto['nombre']; ?></a></td><td><?php echo number_format($producto['debito']+$producto['comision'],2); ?></td></tr>
						<?php endif; ?>
					<?php endforeach; ?>
                    </table>
				</td>
				<td style="background-color: rgb(255, 249, 198);">
					<h3>10 días</h3>
					<table class="table  table-striped table-bordered">
					<?php foreach ($productos as $producto): ?>
						<?php if($producto['validez']=='10' and $producto['aseguradora_id']==1): ?>
						    <?php if($producto['template']=='trailer'){continue;}?>
							<tr><td><a href="<?php echo BASEURL; ?><?php echo $operacion;?>/agregar/<?php echo $producto['id']; ?>" class="producto_link"><?php echo $producto['nombre']; ?></a></td><td><?php echo number_format($producto['debito']+$producto['comision'],2); ?></td></tr>
						<?php endif; ?>
					<?php endforeach; ?>
                    </table>
				</td>
				<td>
					<h3>30 días</h3>
					<table class="table  table-striped table-bordered">
					<?php foreach ($productos as $producto): ?>
						<?php 
						   if($producto['validez']=='30'  and $producto['aseguradora_id']==1): 
                           //saltea puerto natales
						   if($producto['template']=="puerto_natales"){continue;}
                           if($producto['template']=='trailer'){continue;} 
						   ?>
							<tr><td><a href="<?php echo BASEURL; ?><?php echo $operacion;?>/agregar/<?php echo $producto['id']; ?>" class="producto_link"><?php echo $producto['nombre']; ?></a></td><td><?php echo number_format($producto['debito']+$producto['comision'],2); ?></td></tr>
						<?php endif; ?>
					<?php endforeach; ?>
					</table>
				
					
				
				</td>
			</tr>
		</tbody>
	</table>
	

    <p><img src="<?php echo base_url()?>images/mercantil_andina.jpg" /></p>
    <h2>Vehículos con Trailer</h2>
    <div class="clearfix"></div>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td style="background-color: rgb(255, 249, 198);">
                    
                    <h3>3 días con Trailer</h3>
                    <table class="table  table-striped table-bordered">
                    <?php foreach ($productos as $producto): ?>
                        <?php if($producto['validez']=='3'): ?>
                            <?php if($producto['template']!='trailer'){continue;}?>
                            <tr><td><a href="<?php echo BASEURL; ?><?php echo $operacion;?>/agregar/<?php echo $producto['id']; ?>" class="producto_link"><?php echo $producto['nombre']; ?></a></td><td><?php echo number_format($producto['debito']+$producto['comision'],2); ?></td></tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </table>                    
                </td>
                <td>

                    <h3>5 días con Trailer</h3>
                    <table class="table  table-striped table-bordered">
                    <?php foreach ($productos as $producto): ?>
                        <?php if($producto['validez']=='5'): ?>
                            <?php if($producto['template']!='trailer'){continue;}?>
                            <tr><td><a href="<?php echo BASEURL; ?><?php echo $operacion;?>/agregar/<?php echo $producto['id']; ?>" class="producto_link"><?php echo $producto['nombre']; ?></a></td><td><?php echo number_format($producto['debito']+$producto['comision'],2); ?></td></tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </table>
                </td>
                <td style="background-color: rgb(255, 249, 198);">
   
                    <h3>10 días con Trailer</h3>
                    <table class="table  table-striped table-bordered">
                    <?php foreach ($productos as $producto): ?>
                        <?php if($producto['validez']=='10'): ?>
                            <?php if($producto['template']!='trailer'){continue;}?>
                            <tr><td><a href="<?php echo BASEURL; ?><?php echo $operacion;?>/agregar/<?php echo $producto['id']; ?>" class="producto_link"><?php echo $producto['nombre']; ?></a></td><td><?php echo number_format($producto['debito']+$producto['comision'],2); ?></td></tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </table>
                </td>
                <td>

                    
                    <h3>30 días con Trailer</h3>
                    <table class="table  table-striped table-bordered">
                    <?php foreach ($productos as $producto): ?>
                        <?php if($producto['validez']=='30'): ?>
                            <?php if($producto['template']!='trailer'){continue;}?>
                            <tr><td><a href="<?php echo BASEURL; ?><?php echo $operacion;?>/agregar/<?php echo $producto['id']; ?>" class="producto_link"><?php echo $producto['nombre']; ?></a></td><td><?php echo number_format($producto['debito']+$producto['comision'],2); ?></td></tr>
                        <?php endif; ?>
                    <?php endforeach; ?>                    
                    </table>
                
                </td>
            </tr>
        </tbody>
    </table>



	

<p><img src="<?php echo base_url()?>images/mercantil_andina.jpg" /></p>
<h2>Puerto Natales, Punta Arenas, Chile Chico, Porvenir, Chiloe</h2>
<h3>30 días</h3>
<div class="clearfix"></div>
<table class="table table-bordered" style="width: auto">
<?php foreach ($productos as $producto): ?>
    <?php 
       //Solo muestra puerto natales para 30 días
       if($producto['validez']=='30'): 
       
       if($producto['template']!="puerto_natales"){continue;} 
       ?>
       <tr><td><a href="<?php echo BASEURL; ?><?php echo $operacion;?>/agregar/<?php echo $producto['id']; ?>" class="producto_link"><?php echo $producto['nombre']; ?></a></td><td><?php echo number_format($producto['debito']+$producto['comision'],2); ?></td></tr>
    <?php endif; ?>
<?php endforeach; ?>
</table>    

