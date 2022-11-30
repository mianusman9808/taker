<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<style>
    body { 
        /* margin-top: 40px;
        margin-left:20px;
        margin-right: 20px;  */
    }
    td{
        margin:0px;
        padding:2px;
    }
    p,td{
        font-size: 9pt;
    }
    h1,h2,h3,p,td,tr{
        margin:0px;
    }
    table{
        border-collapse: collapse;
        
    }
</style>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<?php $this->load->view("pdf/template/logo_mercantil.php");?>
<?php $this->load->view("pdf/template/datos_poliza.php");?>
<?php $this->load->view("pdf/template/datos_persona.php");?>
<?php $this->load->view("pdf/template/datos_vehiculo.php");?>
<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#999999"  class="tablaContenido">
  <!-- <tr>
    <td colspan="4" class="tdContenidoItem"><strong>Cobertura: </strong></td>
  </tr> -->
  <!-- <tr>
    <td colspan="4" class="tdContenidoItem">
        
        <?php $this->load->view("pdf/template/cobertura");?>
      
      
    </td>
  </tr> -->
<?php $this->load->view("pdf/template/costos.php");?>

</table>
<?php $this->load->view("pdf/template/TIPO_DE_COBERTURA.php");?>
<div style="width:100%; height:0.3rem; background-color:#40ce18; margin-top:3px"></div>

<?php $this->load->view("pdf/template/contacto_siniestros.php");?>

<?php $this->load->view("pdf/template/pie.php");?>
<div style="width:120%; height:4rem;margin-left:-3rem; background-color:#40ce18; margin-top:3px">
<table style="color:white">
    <tr style="padding-top:2rem">
        <td style="padding-left: 5rem;font-weight: 300;">
      <span style="font-family: Arial, Helvetica, sans-serif;"> La Meridional Cía. Argentina de Seguros S.A.</span>
      <br>
      <span style="font-family: Arial, Helvetica, sans-serif;"> Tte. Gral. Juan D. Perón 646, 4° piso - CABA (C1038AAN)</span>
      <br>
        <span style="font-family: Arial, Helvetica, sans-serif;">Tel +54 (11) 4909 7000</span>
        </td>
        <td style="padding-left: 2rem;">
            <div style="background-color:white;width: 2px;height: 2rem;"></div>
        </td>
        <td>
            <table>
                <tr>
                    <td style="padding-left: 2rem;font-family: Arial, Helvetica, sans-serif;"><span><img style="width:1rem;height:1rem;" src="<?php echo PDF_IMAGES;?>website.png"></span><span> </span>meridionalseguros.com.ar</td>
                    <td style="padding-left: 2rem; font-family: Arial, Helvetica, sans-serif;"><span><img style="width:1rem;height:1rem;" src="<?php echo PDF_IMAGES;?>insta.png"></span><span> </span>/MeridionalSeguros</td>
                </tr>
                <tr>
                    <td style="padding-left: 2rem;font-family: Arial, Helvetica, sans-serif;"> <span><img style="width:1rem;height:1rem;" src="<?php echo PDF_IMAGES;?>facebook.png"></span><span> </span>/MeridionalSeguros</td>
                    <td style="padding-left: 2rem;font-family: Arial, Helvetica, sans-serif;"><span><img style="width:1rem;height:1rem;" src="<?php echo PDF_IMAGES;?>youtube.png"></span><span> </span>Meridional Seguros</td>
                </tr>
            </table>
        </td>
    </tr>

</table>
</div>
</body>
</html>


