<?php $this->load->view('template/header'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            
            <h2>Configuración</h2>
            
            <form method="post">
                <div class="form-group">
                    <label>Peso Chileno</label>
                    <input type="text" value="<?php echo set_value('peso_chileno',$peso_chileno)?>" name="peso_chileno" class="form-control" />
                    <p class="muted">Valor de cambio del Peso Chileno a Pesos Argentinos.</p>
                    <p class="muted">Separar decimales con punto.</p>
                </div>
                <div class="form-group">
                    <label>Dolar</label>
                    <input type="text" value="<?php echo set_value('dolar_oficial',$dolar_oficial)?>" name="dolar_oficial" class="form-control" />
                    <p class="muted">Valor de cambio del Dolar a Pesos Argentinos.</p>
                    <p class="muted">Separar decimales con punto.</p>
                </div>               
                <p style="text-align: center">
                    <input type="submit" value="Aceptar" class="btn btn-primary" />
                </p>
            </form>
            
        </div><!-- col-12 -->
    </div><!-- row -->
</div><!-- container -->
<?php $this->load->view('template/footer'); ?>
