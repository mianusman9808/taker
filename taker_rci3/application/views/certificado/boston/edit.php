<?php $this -> load -> view("template/header"); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Boston</h1>
            <h2 id="page-heading"><?php echo $producto['nombre']; ?></h2>
            
            
    <form method="post" class="form-horizontal">

    <legend>Datos del asegurado</legend>
                
      <div class="form-group">  
         <label for="uso" class="col-sm-4 control-label">Tipo de Conductor</label>
         <div class="col-sm-8">

          <!-- A- Apoderado, T – Titular, P- Propietario, O - Autorizado -->

            <table class="table table-stripped" style="width: auto;">
                <!--
                 <tr>
                    <td><input type="radio" value="Titular" name="conductor" <?php echo set_checkbox('conductor', 'Titular', $certificado['conductor']=="Titular"?true:false ); ?> </td>
                    <td>Titular</td>
                </tr>               
                -->
                <tr>
                    <td><input type="radio" value="Propietario" name="conductor" <?php echo set_checkbox('conductor', 'Propietario', $certificado['conductor']=="Propietario"?true:false ); ?></td>
                    <td>Propietario</td>
                </tr>
               <tr>
                    <td><input type="radio" value="Autorizado" name="conductor" <?php echo set_checkbox('conductor', 'Autorizado', $certificado['conductor']=="Autorizado"?true:false ); ?></td>
                    <td>Autorizado</td>
                </tr>
                <!-- 
                <tr>
                    <td><input type="radio" value="Apoderado" name="conductor"  <?php echo set_checkbox('conductor', 'Apoderado', $certificado['conductor']=="Apoderado"?true:false ); ?></td>
                    <td>Apoderado</td>
                </tr>
                -->
            </table> 

           </div>
      </div><!-- tipo_conductor -->

        <div class="form-group">  
           <label for="Nombre" class="col-sm-4 control-label">Nombre:</label>
             <div class="col-sm-8">
               <input type="text" name="Nombre"  class="form-control" value="<?php echo set_value('Nombre',$certificado['Nombre']); ?>" />
             </div>
       </div><!-- Nombre -->  
       <div class="form-group">  
           <label for="Apellido" class="col-sm-4 control-label">Apellido:</label>
             <div class="col-sm-8">
               <input type="text" name="Apellido"  class="form-control" value="<?php echo set_value('Apellido',$certificado['Apellido']); ?>" />
             </div>
       </div><!-- Apellido -->  
                          
       <div class="form-group">  
           <label for="documento_tipo" class="col-sm-4 control-label">Tipo de documento</label>
             <div class="col-sm-8">
                <select name="documento_tipo" class="form-control"  >
                        <option value="Rut" <?php echo set_select('documento_tipo','Rut',$certificado['documento_tipo']=="Rut"?true:false)?> >RUT</option>
                        <option value="DNI" <?php echo set_select('documento_tipo','DNI',$certificado['documento_tipo']=="DNI"?true:false)?>>DNI</option>
                        <option value="Documento Extranjero" <?php echo set_select('documento_tipo','Documento Extranjero',$certificado['documento_tipo']=="Documento Extranjero"?true:false)?>>Documento Extranjero</option>
                 </select>
                 <!-- 94 - Rut, 96 - DNI, 70 - Documento Extranjero -->                               
              </div>
          </div><!-- Documento tipo -->       

           <div class="form-group">  
           <label for="Rut" class="col-sm-4 control-label">Numero de documento</label>
             <div class="col-sm-8">
               <input type="text" name="Rut"  class="form-control" value="<?php echo set_value('Rut',$certificado['Rut']); ?>"/>
                      <span id="helpBlock" class="help-block">Usar números sin puntos. Usar el guión para RUT.</span>
                </div>

          </div><!-- Rut --> 

           <div class="form-group">  
           <label for="Domicilio" class="col-sm-4 control-label">Domicilio</label>
             <div class="col-sm-8">
               <input type="text" name="Domicilio"  class="form-control" value="<?php echo set_value('Domicilio',$certificado['Domicilio']); ?>" placeholder="Calle, Numero y incluir Piso"/>
                </div>
          </div><!-- Domicilio --> 

         <div class="form-group">  
           <label for="Localidad" class="col-sm-4 control-label">Localidad</label>
             <div class="col-sm-8">
               <input type="text" name="Localidad"  class="form-control" value="<?php echo set_value('Localidad',$certificado['Localidad']); ?>" />
                </div>
          </div><!-- Localidad --> 


            <div class="form-group">  
               <label for="Pais" class="col-sm-4 control-label">Nacionalidad</label>
                 <div class="col-sm-8">
                   <?php echo form_dropdown('Pais',$this->boston_pais_model->select(),set_value('Pais',$certificado['Pais']),'class="form-control"')?>
                </div>
            </div><!-- Pais --> 

            <div class="form-group">  
               <label for="Telefono" class="col-sm-4 control-label">Teléfono</label>
                 <div class="col-sm-8">
                   <input type="text" name="Telefono"  class="form-control" value="<?php echo set_value('Telefono',$certificado['Telefono']); ?>" />
                 </div>
            </div><!-- Telefono --> 

            <div class="form-group">  
               <label for="Fecha_Nacimiento" class="col-sm-4 control-label">Fecha de nacimiento</label>
                 <div class="col-sm-8">
                     
                   <!-- <input type="text" name="Fecha_Nacimiento"  class="form-control" id="dp1" value="<?php echo set_value('Fecha_Nacimiento'); ?>" /> -->
                   
                   <div id="fecha_nacimiento"></div>
           
                    <script language="JavaScript">
                        $( document ).ready(function() {
                            $("div#fecha_nacimiento").birthdaypicker(options={
                                      "maxAge"        : 90,
                                      "minAge"        : 18,
                                      "monthFormat"   : "long",
                                      "fieldName"     : "Fecha_Nacimiento",
                                      "dateFormat"    : "bigEndian"
                                      <?php if ($this->input->post('Fecha_Nacimiento')):?>
                                            ,"defaultDate"   : "<?php echo $this->input->post('Fecha_Nacimiento');?>"
                                      <?php elseif($certificado['Fecha_Nacimiento']): ?>
                                            ,"defaultDate"   : "<?php echo $certificado['Fecha_Nacimiento'];?>"
                                      <?php endif ?>                                 
                            });
                        });
                    </script>

                    <p class="form-msg-info">Solamente permitidos mayores de 18 años</p>

              
                </div>
            </div><!-- Fecha_Nacimiento --> 
            

                    

            <legend>Datos del vehiculo</legend>
      
                      
       <div class="form-group">  
                <label for="Marca" class="col-sm-4 control-label">Marca</label>
                     <div class="col-sm-8">
                       <input type="text" name="Marca"  class="form-control" value="<?php echo set_value('Marca',$certificado['Marca']); ?>" />
                   </div>
       </div><!-- Marca -->   
                  
        <div class="form-group">  
                   <label for="Modelo" class="col-sm-4 control-label">Modelo</label>
                     <div class="col-sm-8">
                       <input type="text" name="Modelo"  class="form-control" value="<?php echo set_value('Modelo',$certificado['Modelo']); ?>" />
                </div>
        </div><!-- Modelo -->                        
                               
         <div class="form-group">  
                   <label for="Anio" class="col-sm-4 control-label">Año de fabricación</label>
                     <div class="col-sm-8">
                       <p><?php echo anio_fabricacion_select('Anio',$certificado['Anio']); ?></p>
                       
                       <?php if ($producto['boston_tipo_id']==26 or $producto['boston_tipo_id']==27):   //Microbuses hasta 15 años ?>
                            <p class="form-msg-info">Hasta 15 años de antiguedad.</p>
                       <?php else: ?>
                           <p class="form-msg-info">Hasta 30 años de antiguedad.</p>
                       <?php endif ?>
                       
                    </div>
          </div><!-- Anio --> 
               
           <div class="form-group">  
                   <label for="Patente" class="col-sm-4 control-label">Patente</label>
                     <div class="col-sm-8">
                       <input type="text" name="Patente"  class="form-control" value="<?php echo set_value('Patente',$certificado['Patente']); ?>" maxlength="9" />
                        <p class="form-msg-info">Usar guión entre las letras y los números, por ejemplo: HJ-2345</p>
                    </div>
            </div><!-- Patente -->
            
             <div class="form-group">  
                   <label for="digito" class="col-sm-4 control-label">Dígito Vertificador</label>
                     <div class="col-sm-8">
                       <input type="text" name="digito"  class="" value="<?php echo set_value('digito',$certificado['digito']); ?>" maxlength="1" />
                    </div>
            </div><!-- digito -->


             <?php if ($producto['boston_tipo_id']==6 or $producto['boston_tipo_id']==14): //Acoplados y semirremolque no tienen motor ?>

                <input type="hidden" name="Motor" value="" />
             <?php else: ?>      
                 <div class="form-group">  
                       <label for="Motor" class="col-sm-4 control-label">Motor</label>
                         <div class="col-sm-8">
                           <input type="text" name="Motor"  class="form-control" value="<?php echo set_value('Motor',$certificado['Motor']); ?>"  maxlength="20" />
                        </div>
                  </div><!-- Motor -->
              <?php endif?>
                                                           
               <div class="form-group">  
                   <label for="Chasis" class="col-sm-4 control-label">Chasis</label>
                     <div class="col-sm-8">
                       <input type="text" name="Chasis"  class="form-control" value="<?php echo set_value('Chasis',$certificado['Chasis']); ?>"  maxlength="20"  />
                    </div>
               </div><!-- Chasis --> 
               

  
 <hr>

<legend>Producto con Vigencia <?php echo $producto['validez']; ?> días</legend> 
  
        <input type="hidden" name="id_tipo_certificado" value="<?php echo $producto['id'] ?>"   />
        <input type="hidden" name="boston_tipo_id" value="<?php echo $producto['boston_tipo_id']?>" />  
            
    
            <?php if ($anticipado): ?>
            <div class="form-group">  
            <label for="FechaDesde" class="col-sm-4 control-label">Fecha de inicio de la cobertura</label>
                <div class="col-sm-8"> 
                    <input type="text" name="FechaDesde" value="<?php echo set_value('FechaDesde',solo_fecha($certificado['FechaDesde'])) ?>" class="calendario"   />
                 </div>
             </div>
             <?php endif;?>
               

            <!-- Condicionales del tipo de vehiculo --> 
            
           
            
                                    
          <?php if ($producto['boston_tipo_id']==23): //automovil importado ?>

			     <input type="hidden" name="Uso" value="2" />
			     <!-- uso comercial -->
                 <input type="hidden" name="boston_carroceria_id" value="3" />
                <!-- carroceria rural -->
            
          <?php elseif ($producto['boston_tipo_id']==25): ?> <!--camion de 10tn o +-->
                <input type="hidden" name="Uso" value="2" />
                <!-- uso comercial -->
                <input type="hidden" name="boston_carroceria_id" value="32" />
                <!-- carroceria cerrada -->
                <div class="alert alert-danger"> CAMIONES, REMOLQUES O SEMIS: Se excluyen cargas pelligrosas</div>

         <?php elseif ($producto['boston_tipo_id']==15): ?><!--camion de menos de 10tn-->
                <input type="hidden" name="Uso" value="2" />
                <!-- uso comercial -->
                <input type="hidden" name="boston_carroceria_id" value="32" />
                <!-- carroceria cerrada -->
                <div class="alert alert-danger"> CAMIONES, REMOLQUES O SEMIS: Se excluyen cargas pelligrosas</div>
            
          <?php elseif ($producto['boston_tipo_id']==27): ?><!--microbus de mas de 25 asientos-->
                <input type="hidden" name="Uso" value="20" />
                <!-- Uso servicio Especial -->
                <input type="hidden" name="boston_carroceria_id" value="81" />
                <!-- Microbus de mas de 25 asientos -->
                <div class="alert alert-danger">MICROBUS: Máximo 45 asientos</div>
          <?php elseif ($producto['boston_tipo_id']==26): ?><!--microbus de menos de 25 asientos-->
                <input type="hidden" name="Uso" value="20" />
                <!-- Uso servicio Especial -->
                <input type="hidden" name="boston_carroceria_id" value="80" />
                <!-- Microbus de menos de 25 asientos -->
                <div class="alert alert-danger">MICROBUS: Máximo 25 asientos</div>
          <?php elseif ($producto['boston_tipo_id']==6 or $producto['boston_tipo_id']==14): ?><!--Acoplado o semirremolque-->
                <input type="hidden" name="Uso" value="2" />
                <!-- Uso comercial -->
                <div class="form-group">  
                   <label for="boston_carroceria_id" class="col-sm-4 control-label">Carroceria</label>
                     <div class="col-sm-8">
                        <select name="boston_carroceria_id" class="form-control"  >
                                <option value="5" <?php echo set_select('boston_carroceria_id','5',$certificado['boston_carroceria_id']=="5"?true:false)?> >Furgon</option>
                                <option value="12" <?php echo set_select('boston_carroceria_id','12',$certificado['boston_carroceria_id']=="12"?true:false)?>>Abierta</option>
                                <option value="7" <?php echo set_select('boston_carroceria_id','7',$certificado['boston_carroceria_id']=="7"?true:false)?>>Playo</option>
                         </select>                            
                      </div>
                  </div><!-- Carroceria -->  
                  <div class="alert alert-danger"> CAMIONES, REMOLQUES O SEMIS: Se excluyen cargas pelligrosas</div>
           <?php elseif ($producto['boston_tipo_id']==5): ?><!--moto -->
                <input type="hidden" name="Uso" value="1" />
                <!-- Uso particular -->
                <input type="hidden" name="boston_carroceria_id" value="86" />
                <!-- moto -->               
           <?php elseif ($producto['boston_tipo_id']==20): ?><!--pickup importada -->
                <input type="hidden" name="Uso" value="2" />
                <!-- Uso comercial -->
                <div class="form-group">  
                   <label for="boston_carroceria_id" class="col-sm-4 control-label">Carroceria</label>
                     <div class="col-sm-8">
                        <select name="boston_carroceria_id" class="form-control"  >
                                <!--
                                <option value="13" <?php echo set_select('boston_carroceria_id','13',$certificado['boston_carroceria_id']=="13"?true:false)?>>Cabina simple</option>
                                <option value="3" <?php echo set_select('boston_carroceria_id','3',$certificado['boston_carroceria_id']=="3"?true:false)?> >Rural</option>
                                <option value="5" <?php echo set_select('boston_carroceria_id','5',$certificado['boston_carroceria_id']=="5"?true:false)?> >Furgon</option>
                                -->
                                <option value="12" <?php echo set_select('boston_carroceria_id','12',$certificado['boston_carroceria_id']=="1"?true:false)?>>Abierta</option>
                                <option value="32" <?php echo set_select('boston_carroceria_id','32',$certificado['boston_carroceria_id']=="32"?true:false)?>>Cerrada o Station Wagon</option>
                         </select>                            
                      </div>
                  </div><!-- Carroceria -->       
                  <div class="alert alert-info">Si es Station Wagon, seleccionar carrocería cerrada </div>  
           <?php else:?>
               <?php 
               echo $producto['boston_tipo_id'];
               show_error("Tipo de vehiculo no permitido");exit;?>
           <?php endif ;?>

            
            
                    

            <!-- Uso 1 - Particular, 2 – Comercial, 20 – Especial (solo Tipo Veh 26 y 27) -->       
            <div style="text-align: center">
                <?php if (getPerms()!='Beneficiario'): ?>
                    <a href="<?php echo BASEURL; ?>certificado/grilla" class="btn btn-cancel" /> 
                        <span class="ui-button-text">Cancelar</span>
                    </a>
                <?php endif; ?>
                <input class="btn btn-primary btn-lg" type="submit" value="Enviar">
			</div>

            </form>
        </div>
    </div>
</div>


<?php $this -> load -> view("template/footer"); ?>