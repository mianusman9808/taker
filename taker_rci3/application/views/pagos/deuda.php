<?php $this->load->view('template/header');?>
<div class="container">
<div class="row">
    
<div class="col-md-12">
    
    <h2>Transferencias</h2>
    <div class="well">
        <p>Una vez realizada una transfencia, puede demorar hasta <b>72 horas</b> hasta actualizarse en el sistema. 
        Se muestran las últimas 10 transferencias realizadas</p>
    </div>
</div>

    <div class="col-md-12">
    
        <h2><?php echo getNombre()?></h2>
        <?php $this->load->view('pagos/item',array('pagos'=>$pagos)); ?>
    
         <?php foreach($vendedores as $vendedor):?>
            <h2><?php echo $vendedor['Nombre'];?></h2>
            <?php $this->load->view('pagos/item',array('pagos'=>$vendedor['pagos'])); ?>
        <?php endforeach ?>
    
    </div><!-- col-12 -->
</div><!-- row -->
</div><!-- container -->
<?php $this->load->view('template/footer');?>