<!DOCTYPE html>
<html lang="es">
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo METADESCRIPCION; ?>" />
    <meta name="abstract" content="<?php echo METADESCRIPCION; ?>" />
    <meta name="keywords" content="<?php echo METAKEYWORDS; ?>" />

    <title><?php echo NOMBRESITIO; ?></title>
    
    <script src="<?php echo base_url();?>assets/js/jquery-1.12.2.min.js"></script>
    <link href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo FRONTURL; ?>assets/css/taker.css" />
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <link rel="stylesheet" href="<?php echo BASEURL; ?>assets/css/font-awesome.css" />
    
    <!-- DATETIME - ANULAD CALENDARIO NUEVO QUE TRAE PROBLEMAS CON LOS VENDEDORES...
    <script type="text/javascript" src="<?php echo FRONTURL;?>assets/js/jquery.datetimepicker.js"></script>    
    <link rel="stylesheet" href="<?php echo FRONTURL;?>assets/css/jquery.datetimepicker.css">
    ->
    
    <!-- CALENDARIO VIEJO JQUERY UI -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery-ui/jquery-ui.css" type="text/css" media="all" />
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery-ui/jquery-ui.js"></script>
    <script src="<?php echo base_url(); ?>assets/jquery-ui/jquery.ui.datepicker-es.js" type="text/javascript"></script>

    <!-- fecha de cumple -->
    <script type="text/javascript" src="<?php echo FRONTURL;?>assets/js/bday-picker.js"></script>    
    
    <script type="text/javascript"> 
        $(document).ready(function()
        {
            //Oculta el boton al imprimir
            $("a#link_imprimir_certificado").click(function(){
                $(this).hide();
            });
            //Botón de "cancelar" en agregar/modificar de certificados
            $('.certificado_cancelar').click(function()
            {
                location.href='<?php echo BASEURL; ?>certificado/grilla';
            });
            
            $('input.calendario').datepicker({
                inline: true,
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true
            });
            /*
            CALENDARIO NUEVO ANULADO
         
            $("input.calendario").datetimepicker(
               {    
                  timepicker:false,
                    lang:'es',
                    format:'Y-m-d',
                } 
           );
            $("input.datetimepicker").datetimepicker(
               {    
                   format:'Y-m-d H:i:00',
                     lang:'es',
                } 
            );
            */
            
            //CASO SELECCIÓN DE PRODUCTO. POSIBILIDAD DE CARGAR UN RUT PARA PRECARGAR DATOS
            

            
            $('.producto_link').click(function(e){
                producto_link=$(this).attr('href');
                
                if ($('#campoRut').val()==''){ rut='null'; } else { rut=$('#campoRut').val(); }
                if ($('#patente').val()==''){ patente='null'; } else { patente=$('#patente').val(); }
                if ($('#patente_digito').val()==''){ patente_digito='null'; } else { patente_digito=$('#patente_digito').val(); }
                //if ($('#trailer_patente').val()==''){ trailer_patente='null'; } else { trailer_patente=$('#trailer_patente').val(); }
                //if ($('#trailer_digito').val()==''){ trailer_digito='null'; } else { trailer_digito=$('#trailer_digito').val(); }
                

                if ($('#campoRut').val()==undefined){ rut='null'; }
                if ($('#patente').val()==undefined){ patente='null'; }
                if ($('#patente_digito').val()==undefined){ patente_digito='null'; }
                //if ($('#trailer_patente').val()==undefined){ trailer_patente='null'; }
                //if ($('#trailer_digito').val()==undefined){ trailer_digito='null'; }
                
                producto_link_con_precargados=$(this).attr('href') + '/' + rut + '/' + patente + '/' + patente_digito ;

                e.preventDefault(); 

                location.href=producto_link_con_precargados;
            })
            

            


            $("input.todos").change(function()
            {
                grupo=$(this).attr("data-grupo");
                //alert(grupo);
                if($(this).is(':checked'))
                {

                    $("input.usuario[data-grupo='" + grupo + "']").prop('checked', true);
                }
                else
                {

                    $("input.usuario[data-grupo='" + grupo + "']").prop('checked', false);
                }
            });
            
            $("input.usuario").change(function(){
                 grupo=$(this).attr("data-grupo");
                 $("input.todos[data-grupo='" + grupo + "']").prop('checked', false);
                 }
                
            );
            


            

            
            //se fija el valor que tiene forma_pago al cargarse la página
            $('input[name=cuenta_importe]').prop('disabled',true);
            $('input[name=cuenta_debito_admin]').prop('disabled',true);
            
            if ($('select[name=cuenta_tipo]').val()=='Credito Admin'){
                $('input[name=cuenta_importe]').prop('disabled',false);
            }
            if ($('select[name=cuenta_tipo]').val()=='Debito Admin'){
                $('input[name=cuenta_debito_admin]').prop('disabled',false);
            }           
            
            //cambia tipo entonces habilita el campo necesario
            $('select[name=cuenta_tipo]').change (function(){
                $('input[name=cuenta_importe]').prop('disabled',true);
                $('input[name=cuenta_debito_admin]').prop('disabled',true);
                
                if ( $(this).val()=='Credito Admin' ){
                    $('input[name=cuenta_importe]').prop('disabled',false);
                }
                if ( $(this).val()=='Debito Admin' ){
                    $('input[name=cuenta_debito_admin]').prop('disabled',false);
                }
            });
        });
    </script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 header">
                <a href="http://www.taker.com.ar/"><img src="<?php echo FRONTURL; ?>assets/css/img/solapa_taker.jpg" /></a>
            </div>
            
            <div class="col-md-6">
                <a href="http://www.taker.com.ar/taker_rci2"><img src="<?php echo FRONTURL;?>assets/css/img/logo-rci.gif"></a>
            </div>
        </div>
    </div><!-- container --> 
        
    <?php $this->load->view("template/menu");?>
    
    <div class="container">
        <?php if (validation_errors()):?>
            <?php if (!$this->input->post('g_action'))://No imprime los errores del datagrid ?>
                <div class="row">
                    <div class="col-md-12">       
                        <div class="alert alert-danger">
                            <?php echo validation_errors(); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        
        <!-- AVISO -->
        <?php if (!empty($aviso)): ?>
        <div class="row">
            <div class="col-md-12">  
                <div class="alert alert-danger">
                    <?php echo $aviso; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    
        <!-- FLASHDATA -->
        <?php if ($this->session->flashdata('error')): ?>
        <div class="row">
            <div class="col-md-12">  
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('success')): ?>
        <div class="row">
            <div class="col-md-12">  
                <div class="alert alert-success">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            </div>
         </div>
        <?php endif; ?>
</div><!-- container -->            
