<style type="text/css">
    .newslider {
       
      -webkit-transition: all 0.5s ease-in;
      -moz-transition: all 0.5s ease-in;
      -ms-transition: all 0.5s ease-in;
      -o-transition: all 0.5s ease-in;
      transition: all 0.5s ease-in;
      background-color: rgba(0,0,0,.5);
      background-blend-mode: darken;
    }
</style>
<div class="seccion-encabezado-pg newslider seccion-encabezado-">
	<div class="container">
		<div class="seccion_body">
			<div class="row">
				<div class="col-md-8">
					<h1 class="seccion_titulo"><?php echo $item['titulo']; ?></h1>
					<p class="lead hidden-xs hidden-sm"><?php echo $item['descripcion']; ?>
					    
					    
					</p>
				</div><!-- col-8 -->
                <div class="col-md-4">
                    <div class="panel panel-default panel-login">
                        <div class="panel-heading">
                            <h3 class="panel-title">Acceder al sistema</h3>
                        </div>
                        <div class="panel-body">
                            <?php include_once $formulario; ?>
                            <!--
                            <form accept-charset="UTF-8" role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="text">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me"> Recordarme
                                    </label>
                                </div>
                                <p><input class="btn btn-lg btn-success btn-destacado btn-block" type="submit" value="Ingresar"></p>
                                <p><a href="#" class="btn btn-default btn-block">??olvid?? password?</a></p>
                            </fieldset>
                            </form>
                            -->
                        </div>
                    </div>
                </div><!-- col-4 -->
			</div><!-- row -->
		</div>
	</div>
</div>
<!-- WHY -->
<div class="section why section-border">
    <div class="container">
        <div class="row">
            
            <div class="col-sm-6 col-md-6">
                <h2 class="section-heading">
                    ??Qui??nes somos?
                </h2>
                <div class="section-subheading">Somos la ??nica plataforma en el pa??s que fiscaliza coberturas de seguros. Pod??s cargar tu p??liza de seguro ART o AP seg??n corresponda con sus respectivos comprobantes de pago, luego nosotros la fiscalizamos. Tendr??s tu respuesta en un m??ximo de 24 hs.</div> 
                <p>Es importante que tu p??liza iguale o supere las exigencias m??nimas propuestas por el barrio.</p> 
                <p>De no tener p??liza, el sistema de la opci??n de contratar una cobertura de AP jornalizada y el trabajador puede ingresar de inmediato. Esto quiere decir que s??lo se cobra el d??a que el trabajador ingresa.</p> 
                <a href="https://takerap.com/alta/empresa" class="btn btn-primary">??Registrate!</a>
                <div class="margin-bottom-30"></div>
            </div>
            <div class="col-sm-6 col-md-6 hidden-xs hidden-sm">
                <img src="<?php echo $taker_url; ?>assets/imgs/why-img.webp" alt="" class="img-responsive">
            </div>
            
        </div>
    </div>
</div>
    
    

<!-- FAQ --> 
<div class="section testimony">
    <div class="container">
        
        <div class="row">
            
            <div class="col-sm-10 col-md-10">
                <h2 class="section-heading">
                    Preguntas frecuentes
                </h2>
                <p>Para obtener una respuesta inmediata, pod??s entrar a las siguientes preguntas frecuentes, donde encontrar??s informaci??n sobre los temas m??s consultados:</p>
                <div class="margin-bottom-70"></div>
            </div>
            <div class="col-sm-12 col-md-5 hidden-xs hidden-sm">
                <div class="people">
                    <img class="user-pic" src="<?php echo $taker_url; ?>assets/imgs/13.webp" alt="">
                </div>
            </div>
            <div class="col-sm-12 col-md-7">

                <div class="margin-bottom-10"></div>
                <div class="panel-group panel-faq" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                    <div class="panel-heading active" role="tab" id="heading1">
                        <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1" class="">
                        ??El costo por el seguro de AP es mensual o diario?
                        </a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1" aria-expanded="true">
                        <div class="panel-body">
                        <p>Si contrat??s el seguro por TAKER, s??lo pagar??s la cantidad de jornales cubiertos.</p>
                        </div>
                    </div>
                    </div>
                    <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading2">
                        <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" aria-controls="collapse2">
                        ??Cu??nto se demora dar de alta una persona?
                        </a>
                        </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2" aria-expanded="false" style="height: 0px;">
                        <div class="panel-body">
                        <p>Si tiene seguro TAKER es inmediato.</p>
                        <p>Si cuenta con p??liza propia, hay que fiscalizarla por lo tanto puede tener una demora de 24 hs. como m??ximo.</p>
                        <!--
                        <ul class="list-unstyled">
                            <li><i class="fa fa-check"></i> Ready for all devices.</li>
                            <li><i class="fa fa-check"></i> HTML template</li>
                            <li><i class="fa fa-check"></i> Made with Bootstrap Framework.</li>
                            <li><i class="fa fa-check"></i> Easy Costumizable.</li>
                            <li><i class="fa fa-check"></i> Affordable Price.</li>
                        </ul>
                        -->
                        </div>
                    </div>
                    </div>
                    <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading3">
                        <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
                        ??Cu??les son los m??todos y formas de pago?
                        </a>
                        </h4>
                    </div>
                    <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3" aria-expanded="false" style="height: 0px;">
                        <div class="panel-body">
                        <p>Contamos con PAGOSMISCUENTAS, PAGO F??CIL, RAPIPAGO, RAPIPAGO VIA WAPP y D??BITO AUTOM??TICO.</p>
                        </div>
                    </div>
                    </div>                
                </div>
                <div class="margin-bottom-50"></div>
                
            </div>

        </div>
    </div>
</div> 