<?php $this->load->view("template/header"); ?>
<div class="container">
<div class="row">
<div class="col-md-12">
	
	<h2>Imprimir Certificado</h2>
	
	<p class="alert alert-danger">Una vez que haya solicitado el Certificado ya no podrá modificarlo.</p>
	
	<div style="text-align: center;">
		<a href="http://get.adobe.com/reader/">
			<img src="<?php echo BASEURL;?>images/getReader_button.jpg" />
		</a>
		<br />
		<br />
	</div>
	<p class="alert alert-info">Para leer o imprimir los certificados, necesita tener instalado Acrobat Reader (gratuito).</p>

	<p class="boton"">
	    <a href="<?php echo BASEURL; ?>certificado/grilla" class="btn btn-default"><span class="">Cancelar</span></a> 
		<a id="" href="<?php echo BASEURL; ?>certificado/imprimir/<?php echo $certificado_id; ?>" class="btn btn-primary btn-lg"><span class=""> Solicitar Certificado a Argentina</span></a>

	</p>

</div><!-- col-md-12 -->
</div><!-- row -->
</div><!-- container -->
<?php $this->load->view("template/footer"); ?>