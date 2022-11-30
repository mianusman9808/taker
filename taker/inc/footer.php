<!-- CTA -->
<div class="section cta">
	<div class="container">
		
		<div class="row">
			
			<div class="col-sm-12 col-md-7 col-md-offset-1">
				<h3 class="cta-desc">Taker Accidentes Personales</h3>
			</div>
			<div class="col-sm-12 col-md-3">
				<a href="https://takerap.com/alta/empresa" title="" class="btn btn-orange-cta pull-right btn-view-all">REGISTRARSE</a>
			</div>

		</div>
	</div>
</div>

<div class="section contact">
	<div class="container">
		<div class="row">
			<div class="col-sm-4 col-md-4 col-md-push-8">
				<!--
				<div class="widget download">
					<a href="https://takerap.com/ayudas/ayuda_2.pdf" target="_blank" class="btn btn-secondary btn-block btn-sidebar"><span class="fa  fa-file-pdf-o"></span> Manual de usuario</a>
				</div>
				-->
				<div class="widget contact-info-sidebar">
					<div class="widget-title">
						Información de contacto
					</div>
					<ul class="list-info">
						<li>
							<div class="info-icon">
								<span class="fa fa-map-marker"></span>
							</div>
							<div class="info-text">Capitán de Fragata Moyano 371. CP 5500. Mendoza - Argentina</div> </li>
						<li>
							<div class="info-icon">
								<span class="fa fa-phone"></span>
							</div>
							<div class="info-text">+54 9 11 5254-0435</div>
						</li>
						<li>
							<div class="info-icon">
								<span class="fa fa-envelope"></span>
							</div>
							<div class="info-text">atencionalcliente@taker.com.ar</div>
						</li>
						<li>
							<div class="info-icon">
								<span class="fa fa-clock-o"></span>
							</div>
							<div class="info-text">Lunes a Viernes de 07:00 - 18:00 Hs. / Sábados 7:00 a 12:30 Hs.</div>
						</li>
					</ul>
				</div> 

			</div>
			<div class="col-sm-8 col-md-8 col-md-pull-4">
				<div class="content">
					<h2 class="section-heading">
						Contáctanos
					</h2>
					<p>Complete el siguiente formulario y a la brevedad nos pondremos en contacto con usted:</p>
					<div class="margin-bottom-30"></div>
					<?php include_once $contacto; ?>
			</div>

		</div>
		
	</div>
</div> 

<footer>
	<div class="footer fcopy">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<p class="ftex">© 2017 Taker. Logística para contratación de seguros - Todos los derechos reservados</p> 
				</div>
			</div>
		</div>
	</div>	
</footer>

<!-- For Slide Show -->
<script src="<?php echo $taker_url; ?>assets/js/easy_background.js"></script>
<script>
	if($(".newslider").length){
    easy_background(".newslider",

      {
        slide: ["<?php echo $taker_url; ?>assets/slider-img/2.webp",
        	"<?php echo $taker_url; ?>assets/slider-img/3.webp",
        	"<?php echo $taker_url; ?>assets/slider-img/4.webp",
        	"<?php echo $taker_url; ?>assets/slider-img/5.webp",
        	"<?php echo $taker_url; ?>assets/slider-img/6.webp"],

        delay: [5000, 5000, 5000, 5000, 5000]
      }
    );
}
  </script>
</body>
</html>
