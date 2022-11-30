<?php if (getPerms()) : ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <nav class="navbar navbar-default" role="navigation">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <?php if (getPerms() == 'Administrador') : ?>
                                <li><a href="<?php echo base_url(); ?>certificado/grilla">Certificados</a></li>
                                <li><a href="<?php echo base_url(); ?>usuario/grilla">Usuarios</a></li>
                                <li><a href="<?php echo base_url(); ?>producto/grilla">Productos</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cuenta corriente <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo base_url(); ?>cuenta_corriente/grilla">Cuenta Corriente</a></li>
                                        <li><a href="<?php echo base_url(); ?>totales/saldo">Sumatorias de cuenta corriente</a></li>
                                        <li class="divider"></li>
                                        <li><a href="<?php echo base_url(); ?>credito_debito/grilla">Créditos del administrador</a></li>
                                        <!--
                         <li><a href="<?php echo base_url(); ?>totales/credito_debito">Sumatorias de crédito del administrador</a></li>
                         -->
                                        <li class="divider"></li>
                                        <li><a href="<?php echo base_url(); ?>pagos/index">Pagos</a></li>
                                        <li><a href="<?php echo base_url(); ?>pagos/consultar">Agregar solicitud de pago</a></li>
                                        <li><a href="<?php echo base_url(); ?>pagos/adeudados">Sumatoria de pagos adeudados</a></li>
                                        <!-- MODAL COVID -->


                                        <!-- FIN MODAL COVID -->
                                        <style>
                                            .covid:hover {
                                                color: #5cb85c !important;
                                            }

                                            .covid {
                                                padding-top: 10px !important;
                                                padding-bottom: 10px !important;
                                                margin: 0.5rem;
                                                color: white !important;
                                            }
                                        </style>
                                        <li><a class="btn btn-success covid" target="_blank" href="https://rail.ar/covidrci/public/">Emitir Certificado Covid</a></li>
                                    </ul>
                                </li>
                                <script>
                                    $(document).ready(function() {
                                        $("#exampleModal").modal('show');
                                    });
                                </script>
                                <!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center" id="exampleModalLabel">AHORA PODES OFRECER EL SEGURO PARA COVID</h5>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="text-center">Registrate en la<strong> Plataforma Covid </strong>para emitir los Certificados</h5>
                                                <div class="row text-center">
                                                    <a class="btn btn-success covid" target="_blank" href="https://rail.ar/covidrci/public/">INGRESAR EN TAKER COVID</a>

                                                </div>
                                            </div>
                                            <div class="modal-footer text-center">
                                                <div class="row text-center">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                <li><a href="<?php echo base_url(); ?>reporte/totales">Reporte</a></li>

                                <li><a href="<?php echo base_url(); ?>comision/grilla">Comisiones</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Exportar <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo base_url(); ?>descargar_datos/criterios">Emisión y facturación</a></li>
                                        <li><a href="<?php echo base_url(); ?>descargar_datos/pagos">Pagos</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?php echo base_url(); ?>enviar_correo/index">Correo</a></li>
                                <li><a href="<?php echo base_url(); ?>configuracion/grilla">Configuración</a></li>


                            <?php elseif (getPerms() == 'Vendedor') : ?>

                                <li><a href="<?php echo base_url(); ?>certificado/grilla">Certificados</a></li>
                                <li><a href="<?php echo base_url(); ?>cuenta_corriente/grilla">Cuenta corriente</a></li>

                                <?php if (usuario_facturacion()) : ?>
                                    <li><a href="<?php echo base_url(); ?>pagos/deuda">Transferencias</a></li>
                                <?php endif; ?>
                                <li><a href="<?php echo base_url(); ?>reporte/totales">Ventas</a></li>
                                <style>
                                    .covid:hover {
                                        color: #5cb85c !important;
                                    }

                                    .covid {
                                        padding-top: 10px !important;
                                        padding-bottom: 10px !important;
                                        margin: 0.5rem;
                                        color: white !important;
                                    }
                                </style>
                                <!-- MODAL COVID 

                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center" id="exampleModalLabel">AHORA PODES OFRECER EL SEGURO PARA COVID</h5>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="text-center">Ingresá tu Usuario y Contraseña en la <strong> Plataforma Covid </strong> para emitir el Certificado</h5>
                                                <div class="row text-center">
                                                    <a class="btn btn-success covid" target="_blank" href="https://rail.ar/covidrci/public/">INGRESAR EN TAKER COVID</a>

                                                </div>
                                            </div>
                                            <div class="modal-footer text-center">
                                                <div class="row text-center">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                FIN MODAL COVID -->
                                <li><a class="btn btn-success covid" target="_blank" href="https://rail.ar/covidrci/public/">Emitir Certificado Covid</a></li>


                            <?php elseif (getPerms() == 'Vendedor_organizador') : ?>


                                <li><a href="<?php echo base_url(); ?>certificado/grilla">Certificados</a></li>
                                <li><a href="<?php echo base_url(); ?>cuenta_corriente/grilla">Cuenta corriente</a></li>
                                <li><a href="<?php echo base_url(); ?>distribuir/index">Distribuir certificados</a></li>

                                <?php if (usuario_casa_de_cambio()) : ?>
                                    <li><a href="<?php echo base_url(); ?>codigo/seleccionar_producto">Códigos</a></li>
                                <?php endif; ?>

                                <?php if (usuario_facturacion()) : ?>
                                    <li><a href="<?php echo base_url(); ?>pagos/deuda">Transferencias</a></li>
                                <?php endif; ?>
                                <li><a href="<?php echo base_url(); ?>reporte/totales">Ventas</a></li>
                                <style>
                                    .covid:hover {
                                        color: #5cb85c !important;
                                    }

                                    .covid {
                                        padding-top: 10px !important;
                                        padding-bottom: 10px !important;
                                        margin: 0.5rem;
                                        color: white !important;
                                    }
                                </style>
                                <li><a class="btn btn-success covid" target="_blank" href="https://rail.ar/covidrci/public/">Emitir Certificado Covid</a></li>
                            <?php endif; ?>

                            <?php if (getPerms() == 'Aseguradora') : ?>
                                <li><a href="<?php echo base_url(); ?>certificado/grilla">Certificados</a></li>
                                <li><a href="<?php echo base_url(); ?>aseguradora/descargar_datos">Exportar datos</a></li>
                            <?php endif ?>
                        </ul><!-- NAV-->

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="<?php echo base_url(); ?>acceso/logout"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
                        </ul>
                        
                    </div>
                </nav>
            </div><!-- COL -->
        </div><!-- ROW -->

        <?php if (getNombre()) : ?>
            <div class="row">
                <div class="col-md-12">
                    <div style="text-align: right">
                        <span class="glyphicon glyphicon-user"></span>
                        <div class="label label-default"><?php echo getNombre(); ?> - <?php echo getPerms(); ?></div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="alert alert-info">
                        <b>Aviso Importante:</b> Para consultas comerciales comunicarse con <b>Josè Irañeta</b>:
                        <a href="mailto:jiraneta@taker.com.ar">jiraneta@taker.com.ar</a>, Tel: +54 9 261 5404220
                    </div>
                </div>
            </div>
        <?php endif; //nombre 
        ?>
        <!-- MODAL COVID
        <div class="modal fade" id="exampleModal" style="width: 100vw;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLabel">AHORA PODES OFRECER EL SEGURO PARA COVID</h5>

                    </div>
                    <div class="modal-body">
                        <h5 class="text-center">Ingresá tu Usuario y Contraseña en la <strong> Plataforma Covid </strong> para emitir el Certificado</h5>
                        <div class="row text-center">
                            <a class="btn btn-success covid" target="_blank" href="https://rail.ar/covidrci/public/">INGRESAR EN TAKER COVID</a>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <div class="row text-center">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        FIN MODAL COVID -->
    </div><!-- CONTAINER -->

<?php endif; //getperms 
?>