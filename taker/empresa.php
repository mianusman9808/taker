<?php include('inc/header.php');?>

<?php
// encabezado random
$bg = array('bg1', 'bg2', 'bg3' );
?>

<div class="seccion-encabezado-pg <?php echo $bg[array_rand($bg)]; ?>">
    <div class="container">
        <div class="seccion_body">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="seccion_titulo">Lo hacemos simple, fácil y accesible.</h1>
                    <p class="lead">Somos una empresa dedicada, desde hace más de 12 años, 
                al desarrollo de software de logísticas para contratación de seguros.</p>
                </div>
            </div>
       </div>
   </div>
</div>


<div class="seccion seccion-productos">
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="pagina_header">
                <h2 class="pagina_titulo">Desarrollamos herramientas de logística para la contratación de seguros</h2>
                <h3  class="pagina_subtitulo">Contamos con profesionales con más de 30 años de experiencia en el rubro.</h3>
            </div>
            <div class="pagina_descripcion">
            <p>Nos especializamos en el desarrollado de aplicaciones web orientadas a solucionar todas aquellas problemáticas que surgen al momento de contratar seguros, buscando el modo más eficiente de estar en el lugar adecuado, las 24 horas on-line y simplificando los modelos y procesos de cotización y contratación de seguros.</p>
        </div>
        </div>
    </div>
        <?php
$i = 0;
        foreach($productos as $key => $producto): ?>
        <div id="id_producto_<?php echo $key; ?>" class="destacado">

        <?php
        $i++;
        if($i % 2 != 0):?>
            <div class="row">
                <div class="col-md-6">
                        <div class="box_titulo"><?php echo $producto['titulo']?></div>
                        <div class="box_subtitulo"><?php echo $producto['subtitulo']?></div>
                        <p><?php echo $producto['descripcion']?></p>
                        <div class="box_footer">
                            <p>
                                <!--<a href="<?php echo $producto['link']?>" class="btn btn-default btn-destacado"><span class="lnr lnr-select"></span> Contratar ahora.</a>-->
                                <a href="<?php echo $producto['link']?>" class="btn btn-default btn-destacado">Ingresar <span class="lnr lnr-arrow-right"></span></a>
                            </p>
                        </div>
                </div>
                <div class="col-md-6">
                        <img src="<?php echo $taker_url; ?>assets/imgs/<?php echo $producto['imagen']?>" alt="" class="center-cropped img-responsive" />
                </div>
            </div>
        <?php else: ?>
        <div class="row">
            <div class="col-md-6">
                    <img src="<?php echo $taker_url; ?>assets/imgs/<?php echo $producto['imagen']?>" alt="" class="center-cropped img-responsive" />
                </div>
                <div class="col-md-6">
                        <div class="box_titulo"><?php echo $producto['titulo']?></div>
                        <div class="box_subtitulo"><?php echo $producto['subtitulo']?></div>
                        <p><?php echo $producto['descripcion']?></p>
                        <div class="box_footer">
                            <p>
                               <!--<a href="<?php echo $producto['link']?>" class="btn btn-default btn-destacado"><span class="lnr lnr-select"></span> Contratar ahora.</a>-->
                               <a href="<?php echo $producto['link']?>" class="btn btn-default btn-destacado">Ingresar <span class="lnr lnr-arrow-right"></span></a>
                            </p>
                        </div>
                </div>

            </div>
        <?php endif; ?>

        </div>
        <?php endforeach; ?>

    </div>
</div>
<?php include('inc/footer.php');?>
