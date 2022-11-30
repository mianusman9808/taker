  <style>
    #polizo .hot {
        background-color:#E9E9E9;
        border:1px solid white;
        font-family: Arial, Helvetica, sans-serif;
    }
    #polizo .cool{
      background-color:#c1bfbf !important;
      border:1px solid white;
      font-family: Arial, Helvetica, sans-serif;
    }

  </style>
  <table  id="polizo" width="100%"   cellpadding="1" cellspacing="0"  class="tablaContenido" style="margin-top:-2.5rem;">
    <tr style="background-color:#40ce18; width:90%;">
      <th colspan="4" class="tdContenido" ><h3 style="color:white; text-align:left">DATOS DEL ASEGURADO</h3></th>
    </tr>
    <!-- <tr>
      <td width="50%" valign="top" class="tdContenido" >
        <p><strong>Asegurado: <?php echo $Nombre ?></strong></p>
        <p>
          <strong>
          <?php echo $documento_tipo ?>: 
          <?php echo $Rut ?>
          </strong>
          <br />
          <small>Conductor: <?php echo $conductor ;?></small> 
      </p></td>
      <td width="50%" valign="top" class="tdContenido"><p>
          
          <?php if($solicitud){
              echo "<strong>Solicitud Nro:</strong>  ".$solicitud;
          }else{
              echo "<strong>Solicitud en tr&aacute;mite</strong> ";
          }?></p>
      </td>
    </tr> -->
    <tr style="width:90%;">
      <td class="cool" colspan="1">Nombre y Apellido:</td>
      <td class="hot" colspan="3">  <span style="background-color: yellow"><?php echo $Nombre ?> </span></td>
    </tr>
    <tr style="width:90%;">
      <td class="cool" colspan="1"> Propietario: </td>
      <td class="hot" colspan="3"></td>
    </tr>
    <tr style="width:90%;">
      <td class="cool" colspan="1">Ubicación: </td>
      <td class="hot" colspan="1"><span style="background-color: yellow"><?php echo $Domicilio ?></span></td>
      <td class="cool" colspan="1"> Localidad: </td>
      <td class="hot" colspan="1"><span style="background-color: yellow"><?php echo $Localidad ?> </span></td>
    </tr>
    <tr style="width:90%;">
      <td class="cool" colspan="1"> Número de Póliza: </td>
      <td class="hot" colspan="1"><?php echo $Numero ?></td>
      <td class="cool" colspan="1"> Vigencia Desde:</td>
      <td class="hot" colspan="1"><span style="background-color: yellow"><?php echo $desdeDias ?></span></td>
    </tr>
    <tr style="width:90%;">
      <td class="cool" colspan="1"></td>
      <td class="hot" colspan="1"></td>
      <td class="cool" colspan="1"> Vigencia Hasta:</td>
      <td class="hot" colspan="1"><span style="background-color: yellow"><?php echo $FechaHasta ?></span></td>
    </tr>
  </table>
