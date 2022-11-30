<?php $this->load->view("template/header"); ?>

<div class="container">
<div class="row">
<div class="col-md-12">

    <h2>Anular Certificado</h2>
    <div class="well">
        <p>Titular: <b><?php echo $certificado['Apellido']." ".$certificado['Nombre'];?></b></p>
        <p>Patente: <b><?php echo $certificado['Patente']?></b></p>
        <p>Documento: <b><?php echo $certificado['Rut']?></b></p>
        <p>Fecha desde: <b><?php echo $certificado['FechaDesde']?></b></p>
        <p>Fecha hasta: <b><?php echo $certificado['FechaHasta']?></b></p>
    </div>
    <p class="boton">
        <a href="javascript:history.back();" class="btn btn-default">Cancelar</a>  
        <a href="<?php echo base_url();?>certificado/anular/<?php echo $certificado['id']?>/1" class="btn btn-danger btn-lg">Anular Certificado</a> 
        
    </p>

</div><!-- col-12 -->
</div><!-- row -->
</div><!-- container -->
<?php $this->load->view("template/footer"); ?>