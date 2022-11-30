<?php $this->load->view('template/header');?>
<div class="container">
<div class="row">
<div class="col-md-6 col-md-offset-3">

<h3>Cuenta Corriente</h3>
<ul>
    <li><a href="<?php echo base_url(); ?>cuenta_corriente/grilla">Cuenta Corriente</a></li>
    <li><a href="<?php echo base_url(); ?>credito_debito/grilla">Créditos</a></li>
    <li><a href="<?php echo base_url(); ?>totales/listado">Totales</a></li> 
    <li><a href="<?php echo base_url(); ?>pagos/index">Pagos</a></li> 
    <li><a href="<?php echo base_url(); ?>pagos/consultar">Agregar Solicitud de Pago</a></li>
</ul>

</div>
</div>
</div>
<?php $this->load->view('template/footer');?>