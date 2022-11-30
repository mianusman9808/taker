<?php $this->load->view("template/header"); ?>



<?php

if (isset($anticipado))
{
    if ($anticipado)
    { 
        $anticipado=1; 
    }
    else 
    { 
        $anticipado=0; 
    }
}
else
{
    $anticipado=0;
}
?>
<div class="container">
<div class="row">
<div class="col-md-12">
    <h1>La Mercantil</h1>
    <h2 id="page-heading"><?php echo $producto['nombre']; ?></h2>
   <?php if($producto['tipo']=="Van-Combi"): ?> 
   <div class="alert alert-danger">
       <p>Se excluye de esta cobertura el  transporte de personas o pasajeros.</p>

        <p>Para cubrir transporte de personas o pasajeros contratar opciones de <b>Aseguradora 
            Boston</b> Micro-Buses hasta 25 asientos o hasta 40 asientos.</p>
   </div>
    <?php endif; ?>
     
    <form method="post">
    <fieldset>
         <legend>Datos del conductor</legend>
            <table class="table table-stripped" style="width: auto;">
                <tr>
                    <td><input type="radio" value="Propietario" name="conductor" <?php echo set_checkbox('conductor', 'Propietario', $certificado['conductor']=="Propietario"?true:false ); ?>  <?php if (isset($readonly)){ echo 'readonly="readonly"'; } ?>  /></td>
                    <td>Propietario</td>
                </tr>
               <tr>
                    <td><input type="radio" value="Autorizado" name="conductor" <?php echo set_checkbox('conductor', 'Autorizado', $certificado['conductor']=="Autorizado"?true:false ); ?>  <?php if (isset($readonly)){ echo 'readonly="readonly"'; } ?> /></td>
                    <td>Autorizado</td>
                </tr>
                <tr>
                    <td><input type="radio" value="Alquiler" name="conductor"  <?php echo set_checkbox('conductor', 'Alquiler', $certificado['conductor']=="Alquiler"?true:false ); ?>   <?php if (isset($readonly)){ echo 'readonly="readonly"'; } ?> /></td>
                    <td>Vehículo de alquiler</td>
                </tr>
            </table> 
    </fieldset>
        
    <fieldset>
    <legend>Datos del asegurado</legend>
        <table class="table table-stripped" style="width: auto">
            
            <tr>
                <td><label for="Nombre">Apellido y Nombre:</label></td>
                <td><input type="text" name="Nombre" value="<?php echo set_value('Nombre',$certificado['Nombre']); ?>" <?php if (isset($readonly)){ echo 'readonly="readonly"'; } ?> class="form-control" /></td>
            </tr>
            <tr>
                <td class="value" style="text-align: right">
                    
                    <select name="documento_tipo" <?php if (isset($readonly)){ echo 'disabled="disabled"'; } ?>  class="form-control">
                        <option <?php echo set_select('documento_tipo','Rut',$certificado['documento_tipo']=="Rut" ? true:false ); ?> value="Rut">RUT</option>
                        <?php if ($producto['template']!="puerto_natales"): //PUERTO NATALES NO PERMITE PASAPORTE SOLO RUT ?>
                            <option <?php echo set_select('documento_tipo','Pasaporte',$certificado['documento_tipo']=="Pasaporte" ? true:false ); ?> value="Pasaporte">Pasaporte</option>
                        <?php endif ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="Rut" id=""  value="<?php echo set_value('Rut',$certificado['Rut']); ?>" <?php if (isset($readonly)){ echo 'readonly="readonly"'; } ?> maxlength="25" class="form-control" />
                    <p class="alert alert-info">Usar números sin puntos. Usar el guión para RUT.</p>
                </td>
            </tr>

            <tr>
                <td><label for="Domicilio">Domicilio:</label></td>
                <td><input type="text" name="Domicilio"   value="<?php echo set_value('Domicilio',$certificado['Domicilio']); ?>" <?php if (isset($readonly)){ echo 'readonly="readonly"'; } ?> class="form-control" /></td>
            </tr>
            <tr>
                <td><label for="Loalidad">Localidad:</label></td>
                <td>
                    <?php if ($producto['template']=="puerto_natales"):?>

                        <select name="Localidad" <?php if (isset($readonly)){ echo 'disabled="disabled"'; } ?>  class="form-control" >
                            <option <?php echo set_select('Localidad','Puerto Natales',$certificado['Localidad']=="Puerto Natales" ? true:false ); ?> value="Puerto Natales">Puerto Natales</option>
                            <option <?php echo set_select('Localidad','Punta Arenas',$certificado['Localidad']=="Punta Arenas" ? true:false ); ?> value="Punta Arenas">Punta Arenas</option>
                            <option <?php echo set_select('Localidad','Chile Chico',$certificado['Localidad']=="Chile Chico" ? true:false ); ?> value="Chile Chico">Chile Chico</option>
                            <option <?php echo set_select('Localidad','Porvenir',$certificado['Localidad']=="Porvenir" ? true:false ); ?> value="Porvenir">Porvenir</option>
                            <option <?php echo set_select('Localidad','Isla Grande de Chiloe',$certificado['Localidad']=="Isla Grande de Chiloe" ? true:false ); ?> value="Isla Grande de Chiloe">Isla Grande de Chiloe</option>

                        </select>
                    <?php else: ?>
                        <input type="text" name="Localidad" value="<?php echo set_value('Localidad',$certificado['Localidad']); ?>" <?php if (isset($readonly)){ echo 'readonly="readonly"'; } ?> class="form-control" />
                    <?php endif; ?>
                </td>
            </tr>
           <tr>
                <td><label for="Pais">País:</label></td>
                <td>
                    <?php if ($producto['template']=="puerto_natales"): //PUERTO NATALES SOLO VENDE A NACIONALIDAD CHILENA ?>
                        Chile
                        <input type="hidden" value="Chile" name="Pais" class="form-control" />
                    <?php else: ?>
                        <select name="Pais" id="Pais" <?php if (isset($readonly)){ echo 'disabled="disabled"'; } ?> class="form-control">
                            <option <?php echo set_select('Pais','Chile',$certificado['Pais']=="Chile" ? true:false ); ?> value="Chile">Chile</option>
                            <option <?php echo set_select('Pais','Perú',$certificado['Pais']=="Perú" ? true:false ); ?> value="Perú" >Perú</option>
                            <option <?php echo set_select('Pais','Bolivia',$certificado['Pais']=="Bolivia" ? true:false ); ?> value="Bolivia">Bolivia</option>
                            <option <?php echo set_select('Pais','Estados Unidos',$certificado['Pais']=="Estados Unidos" ? true:false ); ?> value="Estados Unidos">Estados Unidos</option>
                            <option <?php echo set_select('Pais','Canadá',$certificado['Pais']=="Canadá" ? true:false ); ?> value="Canadá">Canadá</option>
                            <option <?php echo set_select('Pais','Francia',$certificado['Pais']=="Francia" ? true:false ); ?> value="Francia">Francia</option>
                            <option <?php echo set_select('Pais','Nueva Zelanda',$certificado['Pais']=="Nueva Zelanda" ? true:false ); ?> value="Nueva Zelanda">Nueva Zelanda</option>
                            <option <?php echo set_select('Pais','España',$certificado['Pais']=="España" ? true:false ); ?> value="España">España</option>
                            <option <?php echo set_select('Pais','Holanda',$certificado['Pais']=="Holanda" ? true:false ); ?> value="Holanda">Holanda</option>
                            <option <?php echo set_select('Pais','Bélgica',$certificado['Pais']=="Bélgica" ? true:false ); ?> value="Bélgica">Bélgica</option>
                            <option <?php echo set_select('Pais','Suiza',$certificado['Pais']=="Suiza" ? true:false ); ?> value="Suiza">Suiza</option>
                            <option <?php echo set_select('Pais','Polonia',$certificado['Pais']=="Polonia" ? true:false ); ?> value="Polonia">Polonia</option>
                            <option <?php echo set_select('Pais','Brasil',$certificado['Pais']=="Brasil" ? true:false ); ?> value="Brasil">Brasil</option>                        
                            <option <?php echo set_select('Pais','Eslovenia',$certificado['Pais']=="Eslovenia" ? true:false ); ?> value="Eslovenia">Eslovenia</option>
                        </select>
                        <p class="form-msg-info">Indicar el país del pasaporte. Chile si es RUT</p>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td><label for="Teléfono">Teléfono:</label></td>
                <td><input type="text" name="Telefono" value="<?php echo set_value('Telefono',$certificado['Telefono']); ?>" <?php if (isset($readonly)){ echo 'readonly="readonly"'; } ?> class="form-control" /></td>
            </tr>
        </table>
    </fieldset>


    <fieldset>
    <legend>Datos de la cobertura</legend>
        <table class="table table-stripped" style="width: auto">
            <tr>
                <td><label for="Tipo">Tipo:</label></td>
                <td><?php echo $producto['tipo']; ?></td>
            </tr>
            <tr>
                <td ><label for="Tipo">Validez:</label></td>
                <td><?php echo $producto['validez']; ?> días</td>
            </tr>
            <tr>
                <td><label for="Tipo">Costo:</label></td>
                <td><?php echo $producto['costo']; ?></td>
            </tr>

            <?php /*
            <tr>
                <td class="label"><label for="Tipo">Comisión:</label></td>
                <td class="value"><?php echo $producto['comision']; ?></td>
            </tr>
			*/ ?>
            <?php if ($anticipado): ?>
            <tr>
                <td><label for="FechaDesde">Fecha de inicio de cobertura:</label></td>
                <td>
                    <?php //HAGO EL SUBSTR() PARA MOSTRAR SOLAMENTE LA FECHA Y NO LAS HORAS MINUTOS Y SEGUNDOS ?>
                    <input type="text" name="FechaDesde" value="<?php echo set_value('FechaDesde',solo_fecha($certificado['FechaDesde'])); ?>" class="form-control calendario" />
                    
                    <p class="alert alert-info">Haga click para que se despliegue el calendario</p>
                </td>
            </tr>
            <?php elseif(getPerms()=='Beneficiario'): ?>
                <tr>
                    <td><label for="FechaDesde">Fecha de inicio de cobertura:</label></td>
                    <td >
                        A partir del momento en que emita el certificado
                    </td>
                </tr>
                <tr>
                    <td><label for="Fecha">Fecha de emisión del código de acceso:</label></td>
                    <td>
                        <?php //echo fecha_hora_humana($certificado['Fecha']); ?>
                        <input type="text" id="Fecha" name="Fecha" value="<?php echo set_value('Fecha',fecha_hora_humana($certificado['Fecha'])); ?>" readonly="readonly" class="form-control" />
                    </td>
                </tr>
            
            <?php endif; ?>
        </table>
    </fieldset>

    <fieldset>
    <legend>Datos del vehículo principal</legend>
        <table class="table table-stripped">
            
            <tr>
                <td><label for="Marca">Marca:</label></td>
                <td><input type="text" name="Marca" value="<?php echo set_value('Marca',$certificado['Marca']); ?>" class="form-control" /></td>
            </tr>
            
            <tr>
                <td><label for="Modelo">Modelo:</label></td>
                <td><input type="text" name="Modelo" value="<?php echo set_value('Modelo',$certificado['Modelo']); ?>" class="form-control" /></td>
            </tr>

            <tr>
                <td><label for="Año">Año de fabricación:</label></td>
                <td>
                    <?php echo anio_fabricacion_select('Anio',$certificado['Anio']); ?>
                </td>
            </tr>
            
            <tr>
                <td><label for="autorizacion">Vehiculos de más de <?php echo VEHICULO_ANIO_MINIMO_APROBADO;?> años:</label></td>
                <td>
                    <input type="checkbox" name="autorizacion" value="1" />
                    Solicito <strong>Autorización</strong> para asegurar vehiculo de fabricación anterior o igual a 
                    <strong>
                    <?php
                    echo date("Y")-VEHICULO_ANIO_MINIMO_APROBADO;
                    ?>
                    </strong>
                </td> 
            </tr>

            <tr>
                <td><label for="Patente">Patente:</label></td>
                <td><input type="text" name="Patente" value="<?php echo set_value('Patente',$certificado['Patente']); ?>" maxlength="9" class="form-control" />
				
                	<p class="form-msg-info">Usar guión entre las letras y los números, por ejemplo: HJ-2345</p>
                </td>
            </tr>

            <tr>
                <td><label for="digito">Dígito verificador:</label></td>
                <td><input type="text" name="digito" value="<?php echo set_value('digito',$certificado['digito']); ?>" maxlength="1" class="form-control" />
                    <p class="form-msg-info">Dato no obligatorio</p>
                </td>
            </tr>
            
            <tr>
                <td><label for="Motor">Número de Motor:</label></td>
                <td><input type="text" name="Motor" value="<?php echo set_value('Motor',$certificado['Motor']); ?>" maxlength="25" class="form-control" /></td>
            </tr>

            <tr>
                <td><label for="Chasis">Número de Chasis:</label></td>
                <td><input type="text" name="Chasis" value="<?php echo set_value('Chasis',$certificado['Chasis']); ?>" maxlength="30" class="form-control" /></td>
            </tr>
            
        </table>
    </fieldset>
    
    
    <?php if ($producto['trailer']): ?>
    <fieldset>
    <legend>Datos del trailer</legend>
        <table class="table table-stripped" style="width: auto">
        
            <tr>
                <td><label for="trailer_propietario">Apellido y nombre del propietario del trailer:</label></td>
                <td><input type="text" name="trailer_propietario" value="<?php echo set_value('trailer_propietario',$certificado['trailer_propietario']); ?>" class="form-control" /></td>
            </tr>
            
            <tr>

               <td style="text-align: right">
                    <select name="trailer_documento_tipo" class="form-control" >
                        <option <?php echo set_select('trailer_documento_tipo','Rut',$certificado['trailer_documento_tipo']=="Rut" ? true:false ); ?> value="Rut">RUT del Trailer</option>
                        <?php if ($producto['template']!="puerto_natales"): //PUERTO NATALES NO PERMITE PASAPORTE SOLO RUT ?>
                            <option <?php echo set_select('trailer_documento_tipo','Pasaporte',$certificado['trailer_documento_tipo']=="Pasaporte" ? true:false ); ?> value="Pasaporte">Pasaporte del Trailer</option>
                        <?php endif ?>
                    </select>
                </td>

                <td><input type="text" name="trailer_rut" value="<?php echo set_value('trailer_rut',$certificado['trailer_rut']); ?>" class="form-control" />
                    <p class="form-msg-info">Usar números sin puntos. Usar el guión para RUT.</p>
                </td>
            </tr>
            <tr>
                <td><label for="trailer_eje">Cantidad de ejes del trailer:</label></td>
                <td><input type="text" name="trailer_eje" value="<?php echo set_value('trailer_eje',$certificado['trailer_eje']); ?>" maxlength="2" class="form-control" /></td>
            </tr>
            
            <tr>
                <td><label for="trailer_marca">Marca del trailer:</label></td>
                <td><input type="text" name="trailer_marca" value="<?php echo set_value('trailer_marca',$certificado['trailer_marca']); ?>" class="form-control" /></td>
            </tr>
            
            <tr>
                <td><label for="trailer_modelo">Modelo del trailer:</label></td>
                <td><input type="text" name="trailer_modelo" value="<?php echo set_value('trailer_modelo',$certificado['trailer_modelo']); ?>" class="form-control" /></td>
            </tr>
            
            <tr>
                <td><label for="trailer_anio">Año de fabricación:</label></td>
                <td>
                    <?php echo  anio_fabricacion_select('trailer_anio',$certificado['trailer_anio']); ?>
                </td>
            </tr>
            
            <tr>
                <td><label for="trailer_patente">Patente del trailer:</label></td>
                <td><input type="text" name="trailer_patente" value="<?php echo set_value('trailer_patente',$certificado['trailer_patente']); ?>" maxlength="9" class="form-control" />
                    <p class="alert alert-info">Usar guión entre las letras y los números, por ejemplo: HJ-2345</p>
                </td>
            </tr>
            
            <tr>
                <td><label for="trailer_digito">Dígito verificador:</label></td>
                <td><input type="text" name="trailer_digito" value="<?php echo set_value('trailer_digito',$certificado['trailer_digito']); ?>" maxlength="1" class="form-control" />
                    <p class="alert alert-info">Dato no obligatorio</p>
                </td>
            </tr>
            
            <tr>
                <td><label for="trailer_chasis">Número de Chasis:</label></td>
                <td><input type="text" name="trailer_chasis" value="<?php echo set_value('trailer_chasis',$certificado['trailer_chasis']); ?>" maxlength="30" class="form-control" /></td>
            </tr>
            
        </table>
    </fieldset>
    <?php endif; ?>
    
    <?php if($producto['tipo']=="Van-Combi"): ?> 
       <div class="alert alert-danger">
           <p>Se excluye de esta cobertura el  transporte de personas o pasajeros.</p>
    
            <p>Para cubrir transporte de personas o pasajeros contratar opciones de <b>Aseguradora 
                Boston</b> Micro-Buses hasta 25 asientos o hasta 40 asientos.</p>
       </div>
    <?php endif; ?>
       
    <p class="boton">
        <?php if (getPerms()!='Beneficiario'): ?>
            <a href="<?php echo BASEURL; ?>certificado/grilla" class="btn btn-cancel" /> 
                <span class="ui-button-text">Cancelar</span>
            </a>
        <?php endif; ?>
        <input type="submit" value="Aceptar" class="btn btn-primary btn-lg"  />
    </p>    
    </form>
        
    

        <?php //print_r($certificado); ?>
        <?php //print_r($tipo_certificado); ?>
        <?php //print_r($campos); ?>

</div><!-- col-12 -->
</div><!-- row -->
</div><!-- container -->
<?php $this->load->view("template/footer"); ?>