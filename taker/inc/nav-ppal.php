<div class="container">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="<?php echo $server_url; ?>" alt="Marca Taker"><img src="<?php echo $taker_url ?>assets/imgs/brand.png" height="40"></a>
	</div>
	
	<div id="navbar" class="navbar-collapse collapse">
		<ul class="nav navbar-nav navbar-right"  style="background-color: #006699; display: none;">

			<!-- productos -->
			<?php if($_SERVER['SERVER_NAME']=="localhost") :?>
    			<li><a href="<?php echo $server_url ?>taker_ap_barrios">Accidentes Personales</a></li>
    			<li><a href="<?php echo $server_url ?>taker_rci3">RCI</a></li>
				<li><a href="<?php echo $server_url ?>taker_ap_turismo">Turismo</a></li>
				<!--
				<li><a href="<?php echo $server_url ?>taker_transporte">Transporte</a></li>
				-->
			<?php else: //TODO: activar sudominios luego de migrar  ?>

				<!--
			    <li><a href="http://ap.taker.com.ar">Accidentes Personales</a></li>
                <li><a href="http://rci.taker.com.ar">RCI</a></li>
				<li><a href="http://turismo.taker.com.ar">Turismo</a></li>
				-->
    			<li><a href="<?php echo $server_url ?>taker_ap_barrios">Accidentes Personales</a></li>
    			<li><a href="<?php echo $server_url ?>taker_rci3">RCI</a></li>
				<li><a href="<?php echo $server_url ?>taker_ap_turismo">Turismo</a></li>

				<!-- no se usa 
				<li><a href="http://transporte.taker.com.ar">Transporte</a></li>
				--> 
			<?php endif ?>

			<li><a href="<?php echo $taker_url ?>empresa.php">La Empresa</a></li>
            
            <li><a href="#contact">Contacto</a></li>

		</ul>
	</div>
</div>
