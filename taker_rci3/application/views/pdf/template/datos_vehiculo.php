<style>
 

 #diem .hot {
        background-color:#E9E9E9;
        border:1px solid white;
        font-family: Arial, Helvetica, sans-serif;
    }
    #diem .cool{
      background-color:#c1bfbf !important;
      border:1px solid white;
      font-family: Arial, Helvetica, sans-serif;
    }
</style>
<table id="diem" width="100%"  cellpadding="2" cellspacing="0" class="tablaContenido">
  <tr>
    <td colspan="4" class="tdContenidoItem" style="background-color:#40ce18;"><h2 style="color:white">DATOS DEL VEHÍCULO:</h2></td>
  </tr>
  <tr>
    <td   colspan="1" class=" cool tdContenidoItem">Vehículo:</td>
    <td bgcolor="#E9E9E9" colspan="3" class="tdContenido"><span style="background-color: yellow"><?php echo $Tipo ?> </span></td>
  </tr>
  <tr>
    <td  class="tdContenidoItem cool">Uso:</td>
    <td bgcolor="#E9E9E9" class="tdContenido hot"><?php echo $Uso ?></td>
    <td  class="tdContenidoItem cool">Patente:</td>
    <td bgcolor="#E9E9E9" class="tdContenido hot"><span style="background-color: yellow"><?php echo $Patente ?> <?php echo $digito ?></span></td>
  </tr>
  <tr>
    <td  class="tdContenidoItem cool">Año: </td>
    <td bgcolor="#E9E9E9" class="tdContenido hot"><span style="background-color: yellow"><?php echo $Anio ?></span></td>
    <td class="tdContenidoItem cool">Motor Nro.: </td>
    <td bgcolor="#E9E9E9" class="tdContenido hot"><span style="background-color: yellow"><?php echo $Motor ?></span></td>
  </tr>
  <tr>
    <td   class="tdContenidoItem cool">Suma Asegurada:</td>
    <td bgcolor="#E9E9E9" class="tdContenido hot"></td>
    <td  class="tdContenidoItem cool">Chasis Nro.: </td>
    <td bgcolor="#E9E9E9" class="tdContenido hot"><span style="background-color: yellow"><?php echo $Chasis ?></span></td>
  </tr>
</table>