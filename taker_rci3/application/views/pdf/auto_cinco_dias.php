<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style>
    body { 
        margin-top: 40px;
        margin-left:20px;
        margin-right: 20px; 
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

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<?php $this->load->view("pdf/template/logo_mercantil.php");?>
<?php $this->load->view("pdf/template/datos_poliza.php");?>
<?php $this->load->view("pdf/template/datos_persona.php");?>
<?php $this->load->view("pdf/template/datos_vehiculo.php");?>
<?php $this->load->view("pdf/template/datos_vehiculo.php");?>
<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#999999"  class="tablaContenido">
  <tr>
    <td colspan="4" class="tdContenidoItem"><strong>Cobertura: </strong></td>
  </tr>
  <tr>
    <td colspan="4" class="tdContenidoItem">
        <?php $this->load->view("pdf/template/cobertura");?>
    </td>
  </tr>
  <?php $this->load->view("pdf/template/costos.php");?>
</table>

<?php $this->load->view("pdf/template/contacto_siniestros.php");?>
<?php $this->load->view("pdf/template/pie.php");?>

</body>
</html>

