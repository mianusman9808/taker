<!-- 
<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#999999" class="tablaContenido">
  <tr>
    <td align="right" class="tdContenidoItem"><strong>Domicilio: </strong></td>
    <td colspan="4" bgcolor="#E9E9E9" class="tdContenido"><?php echo $Domicilio ?></td>
  </tr>
  <tr>
    <td align="right" class="tdContenidoItem"><strong>Localidad:</strong></td>
    <td colspan="4" bgcolor="#E9E9E9" class="tdContenido"><?php echo $Localidad ?></td>
  </tr>
  <tr>
    <td align="right" class="tdContenidoItem"><strong>Pa&iacute;s:</strong></td>
    <td colspan="2" bgcolor="#E9E9E9" class="tdContenido"><?php 
        //Corrige acentos y nombre de paises
        if ($Pais=="Chile"){
            echo "Rep&uacute;blica de Chile ";
        }elseif($Pais=="Perú"){
            echo "Per&uacute;";
        }elseif($Pais=="Canadá"){
            echo "Canad&aacute;";
        }elseif($Pais=="España"){
            echo "Espa&ntilde;a";
        }else{
            echo $Pais;
        }
        ?></td>
    <td align="right" class="tdContenidoItem"><strong>Tel&eacute;fono</strong></td>
    <td class="tdContenido" bgcolor="#E9E9E9" ><?php echo $Telefono ?></td>
  </tr>
  <tr>
    <td align="right" class="tdContenidoItem"><strong>Vigencia:</strong></td>
    <td bgcolor="#E9E9E9" class="tdContenidoItem">desde las <?php echo $desdeHoras ?> horas del </td>
    <td bgcolor="#E9E9E9" class="tdContenido" align="center"><strong><?php echo $desdeDias ?></strong></td>
    <td align="right" class="tdContenidoItem"><strong>hasta las <?php echo $hastaHoras ?> del </strong></td>
    <td bgcolor="#E9E9E9" class="tdContenido" align="center"><strong><?php echo $FechaHasta ?></strong></td>
  </tr>
</table> -->