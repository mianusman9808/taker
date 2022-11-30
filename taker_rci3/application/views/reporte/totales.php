<?php $this->load->view("template/header"); 

    function imprimir_dia($validez=0,$certificados=array()){
            foreach ($certificados as $certificado){
                //print_r($certificado);
                if($certificado['producto_validez']==$validez){
                    return $certificado['total'];
                }
            }
            return 0;
  
    }
    function imprimir_total_vendedor($certificados=array()){
            $total=0;
            foreach ($certificados as $certificado){
      
                    $total +=$certificado['total'];
              
            }
        return $total;
    }
    function imprimir_total($vendedores=array()){
        $total=0;
        foreach ($vendedores as $vendedor){
            foreach ($vendedor['certificados'] as $certificado){
      
                    $total +=$certificado['total'];
              
            }                
        }
        return $total;
    }
    function imprimir_total_dia($validez=0,$vendedores=array()){
        $total=0;
        foreach ($vendedores as $vendedor){
            foreach ($vendedor['certificados'] as $certificado){
                if($certificado['producto_validez']==$validez){
                    $total +=$certificado['total'];
                }      
            }                
        }
        return $total;
    }    
?>
<style>
    h3{
        margin: 0px;
        padding: 0px;
    }
    table#resultados{
        *width: auto;
    }
    table#resultados td{
        padding: 10px;
    }

</style>

<div class="container">
<div class="row">
<div class="col-md-12">

    <h2 id="page-heading">Ventas Totales</h2>
        <div class="alert alert-info">
            <h3>Periodo: <?php echo fecha_humana($fecha_desde);?> / <?php echo fecha_humana($fecha_hasta);?></h3>
        </div>
        <form method="post" action="<?php echo base_url()?>reporte/totales" role="form" class="form-inline" >
            <table class="table table-striped">
            <tr>
                <td><label for="asegurado_id">Fecha Desde:</label>                
                <td><input type="text" name="fecha_desde" id="fecha_desde" value="<?php echo set_value('fecha_desde')?>" class="form-control calendario" /></td>
             </tr>
             <tr>   
                <td><label for="asegurado_id">Fecha Hasta:</label>                
                <td><input type="text" name="fecha_hasta" id="fecha_hasta"  value="<?php echo set_value('fecha_hasta')?>" class="form-control calendario" /></td>
            </tr>
            <tr> 
                <td>&nbsp;</td>              
                <td><input type="submit" name="Consultar" value="Consultar" class="btn btn-primary" /></td>
            </tr>
            </table>
        </form>    
        <br /><br /><br />
        <table class="table table-stripped">
        <tr>
                <td></td>
                <td><b>Certificados Días</b></td>
                <td><b>3</b></td>
                <td><b>5</b></td>
                <td><b>10</b></td>
                <td><b>30</b></td>

        </tr>    
        <tr>
                <td><h3>Total</h3></td>
                <td style="background-color: green"><h3 style="color:#ffffff;"><?php echo imprimir_total($vendedores)?></h3></td>
                <td style="background-color: green"><b><span style="color:#ffffff;"><?php echo imprimir_total_dia(3,$vendedores)?></span></b></td>
                <td style="background-color: green"><b><span style="color:#ffffff;"><?php echo imprimir_total_dia(5,$vendedores)?></span></b></td>
                <td style="background-color: green"><b><span style="color:#ffffff;"><?php echo imprimir_total_dia(10,$vendedores)?></span></b></td>
                <td style="background-color: green"><b><span style="color:#ffffff;"><?php echo imprimir_total_dia(30,$vendedores)?></span></b></td>

        </tr>             
        <?php 

            foreach ($vendedores as $vendedor):?>
            <tr>
                <td><h3><?php echo $vendedor['nombre']?></h3></td>
                <td><h3><?php echo imprimir_total_vendedor($vendedor['certificados'])?></h3></td>
                <td><?php echo imprimir_dia(3,$vendedor['certificados'])?></td>
                <td><?php echo imprimir_dia(5,$vendedor['certificados'])?></td>
                <td><?php echo imprimir_dia(10,$vendedor['certificados'])?></td>
                <td><?php echo imprimir_dia(30,$vendedor['certificados'])?></td>

            </tr>  

        <?php endforeach; ?>
        <tr>
                <td><h3>Total</h3></td>
                <td style="background-color: green"><h3 style="color:#ffffff;"><?php echo imprimir_total($vendedores)?></h3></td>
                <td style="background-color: green"><b><span style="color:#ffffff;"><?php echo imprimir_total_dia(3,$vendedores)?></span></b></td>
                <td style="background-color: green"><b><span style="color:#ffffff;"><?php echo imprimir_total_dia(5,$vendedores)?></span></b></td>
                <td style="background-color: green"><b><span style="color:#ffffff;"><?php echo imprimir_total_dia(10,$vendedores)?></span></b></td>
                <td style="background-color: green"><b><span style="color:#ffffff;"><?php echo imprimir_total_dia(30,$vendedores)?></span></b></td>

        </tr> 
        
        <tr>
                <td></td>
                <td></td></td>
                <td><b>3</b></td>
                <td><b>5</b></td>
                <td><b>10</b></td>
                <td><b>30</b></td>

        </tr> 
       </table>
</div><!-- col-12 -->
</div><!-- row -->
</div><!-- container -->

<?php $this->load->view("template/footer"); ?>