<?php include('/inc/header.php');?>
<?php
// encabezado random
$bg = array('bg1', 'bg2', 'bg3' );
?>
<div class="seccion-encabezado-pg <?php echo $bg[array_rand($bg)]; ?> ">
    <div class="container">
        <div class="seccion_body">
            <div class="row no-gutters">
                <?php foreach($productos as $key => $producto):?>
                <div class="col-md-4">
                    <div class="card card-normal">
                      <a href="<?php echo $producto['link']?>">
                        <div class="card_img" style="background-image:url('<?php echo $taker_url; ?>assets/imgs/<?php echo $producto['imagen']?>');"></div>
                      </a>
                      <div class="card_body">
                        <h3 class="card_titulo"><?php echo $producto['titulo']?></h3>
                        <p  class="card_descripcion hidden-xs hidden-sm"><?php echo $producto['descripcion']?></p>
                      </div>
                      <div class="card_footer">
                          <a href="<?php echo $producto['link']?>" class="btn btn-primary btn-destacado btn-block">
                              Ingresar <span class="lnr lnr-arrow-right"></span>
                          </a>
                       </div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
       </div>
   </div>
</div>



<?php include('/inc/footer.php');?>
