<?php 
class Certificado extends MY_Controller{
    
    function agregar($producto_id='',$rut='null',$patente='null',$digito='null'){
        if ((getPerms()=='Administrador') or (getPerms()=='Vendedor') or (getPerms()=='Vendedor_organizador') ){
            //OK
        }else{
            salir();
        }
        //Limpia espacios
        $rut=trim(urldecode($rut));
        $patente=trim(urldecode($patente));
        $digito=trim(urldecode($digito));
        //PREPARA LOS VALORES PRECARGADOS. SI VIENEN "NULL" LOS PASA A VACÍOS
        if ($rut=='null') $rut='';
        if ($patente=='null') $patente='';
        if ($patente=='null') $patente='';
        if ($digito=='null')  $digito='';
        
        //inicializa todas las variables vacías
        $data=$this->_inicializar_variables();
        
        
        //RUT PRECARGADO
        if ($rut){
            $data['certificado']['Rut']=$rut;
            
            //LIMPIAMOS EL RUT PARA QUE BUSQUE EN LA BASE DE DATOS
            $rut=$this->_rut_limpiar($rut);         
            
            $certificado_persona=$this->certificado_model->getByRut($rut);
            
            if ($certificado_persona)
            {
                $data['certificado']=array_merge($data['certificado'],$certificado_persona);
            }
        }
        
        //PATENTE PRECARGADO
        if ($patente)
        {
            $data['certificado']['Patente']=$patente;
            $data['certificado']['digito']=$digito;
            //SE FIJA SI ESTE VEHÍCULO YA HA SIDO INGRESADO EN LA BASE DE DATOS
            $certificado_vehiculo=$this->certificado_model->getByPatente($patente,$digito);
            
            if ($certificado_vehiculo)
            {
                $data['certificado']=array_merge($data['certificado'],$certificado_vehiculo);
            }
        }
        

        
        
        $data['producto']=$this->producto_model->getById($producto_id);
        $data['vendedor']=$this->usuario_model->getById(getUser_id());
        
        if(!$data['producto']){
            show_error('Producto no existe');
        }
        
        //ANTICIPADO
        $data['anticipado']=$this->usuario_model->puede_vender_anticipado(getUser_id());
        

        //VALIDACION
        if ($this->_validar($data['anticipado'],$data['producto']['trailer']))
        {       
            //SE FIJA SI EL USUARIO TIENE CRÉDITO
            if (usuario_tiene_credito_para_producto_o_valor($producto_id)){
                //PREPARA LOS DATOS
                $datos=$this->_preparar_para_bd($data['anticipado'],$data['producto']);
                
                $datos['user_id']=getUser_id();
                
                //estado de salida "Pendiente"
                $datos['estado']='Pendiente';
                
                //FECHA DE CREACIÓN
                $datos['Fecha']=date('Y-m-d H:i:s');
                
                //Aseguradora La Mercantil
                $datos['aseguradora_id']=1;
                
                //LOS CARGA EN LA BASE DE DATOS
                $this->certificado_model->agregar($datos);

                //UNA VEZ CREADO EL REGISTRO EN LA BASE DE DATOS TENEMOS EL ID CON EL QUE GENERAMOS EL NÚMERO DE CERTIFICADO
                //OBTENEMOS EL ID DEL REGISTRO CREADO
                $certificado_id=$this->db->insert_id();
                //GENERA NÚMERO DE CERTIFICADO
                $numero_certificado=genera_numero_certificado($this->input->post('Patente'),$certificado_id);
                
                //Y AHORA SÍ GRABAMOS EL NUMERO DE CERTIFICADO EN LA BASE DE DATOS
                $datos=array();
                $datos['Numero']=$numero_certificado;
                $this->certificado_model->modificar($certificado_id,$datos);

                //HACE LOS MOVIMIENTOS DE DEBITAR Y ACREDITAR
                hace_movimientos(getUser_id(),$numero_certificado,$producto_id);

                //VUELVE A LA GRILLA DE CERTIFICADOS
                $this->session->set_flashdata('success', 'Certificado agregado con éxito');
                redirect('certificado/grilla');
            }
            else
            {
                //NO TIENE CRÉDITO
                $this->session->set_flashdata('error', 'No tiene crédito suficiente');
                redirect('certificado/grilla');
            }
        }
        else
        {
            //NO VALIDA
            $this->load->view('certificado/la_mercantil/edit',$data);
        }

    }//AGREGAR


    function modificar($certificado_id=''){
        if ((getPerms()=='Beneficiario') or  (getPerms()=='Administrador') or (getPerms()=='Vendedor') or (getPerms()=='Vendedor_organizador') )
        {
            //ok
        }
        else
        {
            salir();
        }
        $data=array();
        $data['certificado']=$this->certificado_model->getById($certificado_id);
        if(!$data['certificado']){
            show_error("Certificado no existe");
        }
        
        //CONTROLA EL PROPIETARIO    
        if (getPerms()!='Administrador')
        {      
            if(!$this->certificado_model->usuario_propietario_de_certificado(getUser_id(),$certificado_id))
            {
                show_error("No está permitido modificar este certificado");

            }
        }
        
        
        //ANTICIPADO
        $data['anticipado']=$this->usuario_model->puede_vender_anticipado($data['certificado']['user_id']);
        
        $data['vendedor']=$this->usuario_model->getById($data['certificado']['user_id']);

        //CASO DE EMITIDO. NO PUEDE MODIFICAR
        if ($data['certificado']['Estado']!='Pendiente')
        {
            show_error("No está permitido modificar certificado pendiente");
        }
        

        //TRAILER Y PRODUCTO
        $data['producto']=$this->producto_model->getById($data['certificado']['id_tipo_certificado']);
        
        
        //VALIDACION
        if ($this->_validar($data['anticipado'],$data['producto']['trailer']))
        {

            $datos=$this->_preparar_para_bd($data['anticipado'],$data['producto']);
            $this->certificado_model->modificar($certificado_id,$datos);

            $this->session->set_flashdata('success', 'Certificado modificado con éxito');
            redirect('certificado/grilla');
        }
        else
        {
            //NO VALIDA
            $this->load->view('certificado/la_mercantil/edit',$data);
        }
 
    }//MODIFICAR


    function imprimir($certificado_id=''){
        if ((getPerms()=='Beneficiario') or (getPerms()=='Administrador') or (getPerms()=='Vendedor') or (getPerms()=='Vendedor_organizador') )
        {
            //puede editar
        }
        else
        {
            salir();
        }
        $certificado=$this->certificado_model->getById($certificado_id);
        if (!$certificado){
            show_error("Certificado no existe");
        }
        $producto=$this->producto_model->getById($certificado['id_tipo_certificado']);
        if (!$producto){
            show_error("Producto no existe");
        }
        //VALIDA QUE EL USUARIO SEA PROPIETARIO O ADMIN
        if(getPerms()!='Administrador')
        {
            if (! $this->_usuario_propietario(getUser_id(),$certificado_id) )
            {
                show_error("Sin permisos para imprimir");
            }
        }
        //VALIDA QUE NO ESTE ANULADO
        if($certificado['Estado']=='Anulado'){
           show_error("Certificado anulado no se puede imprimir");
        }
        //VALIDA QUE ESTÉ COMPLETO EL CERTIFICADO PARA IMPRIMIRLO
        if ( $this->_validar_certificado($certificado,$producto['trailer']) )
        {
            //$this->load->view('certificado/imprimir',$data); //VALIDA. SIGUE
        }
        else
        {
            $this->session->set_flashdata('error','Datos incompletos. Para imprimir un Certificado debe completar todos los datos.');
            redirect('certificado/grilla');
        }
        
        //Descarga por primera vez
        //1-cambia el estado a Emitido
        //2-manda un correo avisando que se emitió una póliza
        if($certificado['Estado']=="Pendiente" or $certificado['Estado']=="Codigo")
        {
            //PRIMERO CAMBIA EL ESTADO, PORQUE PUEDE DEMORARSE EL ENVIO DE CORRO O CONSJULTA WS
            //Y APARENTEMENTE LE DAN UN NUEVO CLIKC Y VUELVE A ENTRAR AQUI...
            
            $this->certificado_model->cambiar_estado($certificado_id,'Emitido');    
            $this->correo->certificado_la_mercantil($certificado_id);            

            //AVISA LA VENTA AL WSERVICE
            //$this->load->library('ws_la_mercantil');
            //$this->ws_la_mercantil->nuevo_seguro($certificado, $producto);
        }

        //OPCION DOMPDF
        $certificado=$this->certificado_model->getById($certificado_id);
        $producto=$this->producto_model->getById($certificado['id_tipo_certificado']);
        if($certificado['Estado'] !="Emitido"){
            show_error("Certificado no esta emitido");
        }
        //Formatea fechas
        $certificado['desdeHoras']=strftime("%H : %M", strtotime ($certificado["FechaDesde"]));
        $certificado['hastaHoras']=strftime("%H : %M", strtotime ($certificado["FechaHasta"]));
        $certificado['desdeDias']=strftime("%d / %m / %Y", strtotime ($certificado["FechaDesde"]));
        $certificado['FechaHasta']=strftime("%d / %m / %Y", strtotime ($certificado["FechaHasta"]));
        $certificado['Tipo']=$producto['tipo'];
        $certificado['Costo']=$producto['costo'];
        //Quita el formato UTF8 parra que imprima bien el pdf
        foreach($certificado as $llave=>$valor)
        {
            $certificado[$llave]=utf8_decode($valor);
        }
        //  return $this->load->view('pdf/'.$producto['template'].'.php',$certificado);
        $html=$this->load->view('pdf/'.$producto['template'].'.php',$certificado,TRUE);
        require_once(DOMPDFPATH."dompdf/dompdf_config.inc.php");
        
        
        $dompdf = new DOMPDF();
        
        $dompdf->load_html($html);
        $dompdf->render();
        $dompdf->stream($certificado['Numero'].".pdf");
    

    }//IMPRIMIR

    ///////////////////////////////////////////////////////////////////////////////////////////////
    //METODOS QUE USA LA MERCANTIL
    public function _inicializar_variables()
    {
        $data['certificado']['conductor']='';
        $data['certificado']['Nombre']='';
        $data['certificado']['Rut']='';
        $data['certificado']['documento_tipo']='';  //Agregado para permitir pasaportes
        $data['certificado']['Domicilio']='';
        $data['certificado']['Localidad']='';
        $data['certificado']['Pais']='';
        $data['certificado']['Telefono']='';
        $data['certificado']['FechaDesde']=fecha();
        $data['certificado']['Fecha']='';           
        $data['certificado']['Marca']='';
        $data['certificado']['Modelo']='';
        $data['certificado']['Anio']='';
        $data['certificado']['Patente']='';
        $data['certificado']['digito']='';
        $data['certificado']['Motor']='';
        $data['certificado']['Chasis']='';
        $data['certificado']['trailer_propietario']='';
        
        $data['certificado']['trailer_documento_tipo']=''; //Agregado para permitir pasaportes
        $data['certificado']['trailer_rut']='';
        //$data['certificado']['trailer_pais']=''; // NO SE USA 
        $data['certificado']['trailer_eje']='';
        $data['certificado']['trailer_marca']='';
        $data['certificado']['trailer_modelo']='';
        $data['certificado']['trailer_anio']='';
        $data['certificado']['trailer_patente']='';
        $data['certificado']['trailer_digito']='';
        $data['certificado']['trailer_chasis']='';
        $data['certificado']['precio']='';  //NO SE USA
        
        
        return $data;
    }//INICIAR VARIABLES
    
    //SIEMPRE VALIDA LOS MISMOS CAMPOS
    public function _validar($anticipado='',$trailer='')
    {
        
        //reglas de validación
        $this->form_validation->set_rules('conductor', 'Conductor', 'required');
        $this->form_validation->set_rules('Nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('Rut', 'Rut', 'required|callback__validar_rut'); //A veces se da el caso de que presentan pasaporte y escriben: "1336122516 (PASAPORTE)"
        $this->form_validation->set_rules('documento_tipo', 'Tipo de documento'); 
        $this->form_validation->set_rules('Domicilio', 'Domicilio', 'required');
        $this->form_validation->set_rules('Localidad', 'Localidad', 'required');
        $this->form_validation->set_rules('Pais', 'Pais', 'required');
        $this->form_validation->set_rules('Telefono', 'Telefono', 'required|alpha_dash');

        
        if ($anticipado)
        {
            $this->form_validation->set_rules('FechaDesde', 'Fecha desde', 'required|callback__fecha_desde_correcta');
        }
        

        
        $this->form_validation->set_rules('Marca', 'Marca', 'required|max_length[30]');
        $this->form_validation->set_rules('Motor', 'Número de Motor', 'required|min_length[4]|max_length[25]|alphanumerico_guiones');   //LE SAQUÉ ALPAHNUMERIC. EJEMPLO ESCRIBEN 3E-1138898. CON GUIONES.
        $this->form_validation->set_rules('Chasis', 'Número de Chasis', 'required|min_length[4]|max_length[30]|alphanumerico_guiones'); //LE SAQUÉ ALPAHNUMERIC. EJEMPLO ESCRIBEN EL42-0300263. CON GUIONES.
        $this->form_validation->set_rules('Modelo', 'Modelo', 'required|max_length[50]');
        
        //año actual
        $anio_actual=date('Y');
        $anio_maximo=$anio_actual+VEHICULO_ANIO_MAXIMO+1; //el codeigniter no hace el igual o menor que 2012 sino menor que 2012 y lo deja afuera por ejemplo. por eso sumo
        $anio_minimo=$anio_maximo-VEHICULO_ANIO_MINIMO-2; //y acá resto uno (leer linea de arriba)
        
        $this->form_validation->set_rules('Anio', 'Año de fabricación', 'required|is_natural|greater_than['.$anio_minimo.']|less_than['.$anio_maximo.']');
        //año actual
        
        $this->form_validation->set_rules('Patente', 'Patente', 'required|alpha_dash|max_length[9]|callback__validar_patente_auto');
        $this->form_validation->set_rules('digito', 'Dígito', 'alpha_numeric|max_length[1]'); //no es requerido
        
        //Solicitar aprobacion para vehiculos viejos (mas vejos que 25 años)
        if ($this->input->post('Anio') <= date("Y")-VEHICULO_ANIO_MINIMO_APROBADO){
           $this->form_validation->set_rules('autorizacion', 'Autorización vehiculos viejos', 'required'); 
        }
        
        //trailer
        if ($trailer)
        {
            $this->form_validation->set_rules('trailer_digito', 'Dígito del trailer', 'alpha_numeric|max_length[1]'); //no es requerido
            $this->form_validation->set_rules('trailer_eje', 'Cantidad de ejes del trailer', 'required|is_natural|max_length[2]');
            $this->form_validation->set_rules('trailer_marca', 'Marca del trailer', 'required|max_length[50]');
            $this->form_validation->set_rules('trailer_modelo', 'Modelo del trailer', 'required|max_length[50]');
            $this->form_validation->set_rules('trailer_anio', 'Año de fabricación del trailer', 'required|is_natural|greater_than['.$anio_minimo.']|less_than['.$anio_maximo.']');
            $this->form_validation->set_rules('trailer_chasis', 'Número de chasis del trailer', 'required|max_length[30]');
            $this->form_validation->set_rules('trailer_propietario', 'Apellido y nombre del propietario del trailer', 'required|max_length[50]');
            $this->form_validation->set_rules('trailer_rut', 'RUT del propietario del trailer', 'required|max_length[13]'); //TODO: puede ser 816.343.543-k
            $this->form_validation->set_rules('trailer_patente', 'Patente del trailer', 'required|alpha_dash|max_length[9]|callback__validar_patente_trailer');
            $this->form_validation->set_rules('trailer_documento_tipo', 'Tipo de documento del trailer');
            //$this->form_validation->set_rules('trailer_pais', 'Pais del trailer'); //NO SE USA 
        }
        
        
        if ($this->form_validation->run())
        {
            return true;
        }
        else
        {
            return false;
        }
    }//VALIDAR
    


    public function _preparar_para_bd($anticipado='',$producto=array())
    {
        $datos['conductor']=$this->input->post('conductor');    
        //DATOS DE LA PERSONA
        $datos['Nombre']=$this->input->post('Nombre');
        
        //RUT. LIMPIAMOS CON LA FUNCION _RUT_LIMPIAR
        $datos['Rut']=$this->_rut_limpiar($this->input->post('Rut'));
        $datos['documento_tipo']=$this->input->post('documento_tipo');
        $datos['Domicilio']=$this->input->post('Domicilio');
        $datos['Localidad']=$this->input->post('Localidad');
        $datos['Pais']=$this->input->post('Pais');
        $datos['Telefono']=$this->input->post('Telefono');
                
        
        //FECHA DESDE
        //vendedor (anticipado)
        if ($anticipado)
        {
            if ($this->input->post('FechaDesde')==date('Y-m-d'))
            {
                //es hoy
                $datos['FechaDesde']=$this->input->post('FechaDesde').' '.date('H:i:s');
            }
            else
            {
                //no es hoy. es para el futuro.
                $datos['FechaDesde']=$this->input->post('FechaDesde').' 00:00:00';
            }
        }
        else //vendedor (NO anticipado)
        {
            $datos['FechaDesde']=date('Y-m-d H:i:s'); //fecha actual
        }
        //FIN FECHA DESDE
        
        
        //FECHA HASTA
        //calculamos el FechaHasta a partir de la duración de la cobertura (campo validez)
        $fecha_desde_segundos=strtotime($datos['FechaDesde']);
        $segundos_hasta = ($producto['validez']*86400)-1;
        $fecha_hasta_segundos=$fecha_desde_segundos+$segundos_hasta;
        
        $datos['FechaHasta']=date("Y-m-d H:i:s", $fecha_hasta_segundos);
        //FIN FECHA HASTA
        
        
        //PRODUCTO
        $datos['id_tipo_certificado']=$producto['id'];


        //MEDIO DE PAGO
        $datos['MedioPago']='Cancelado en Efectivo'; //HARDCODIADO
        
        
        //DATOS DEL VEHÍCULO
        //$datos['Uso']='Particular';   //HARDCODIADO
        $datos['Uso']='Particular y/o comercial';   //HARDCODIADO
        $datos['Motor']=$this->input->post('Motor');
        $datos['Marca']=$this->input->post('Marca');
        $datos['Chasis']=$this->input->post('Chasis');
        $datos['Modelo']=$this->input->post('Modelo');
        $datos['Anio']=$this->input->post('Anio');
        $datos['Patente']=strtoupper($this->input->post('Patente'));
        $datos['digito']=$this->input->post('digito');

        
        $datos['precio']="";    //NO SE USA
        
        //TRAILER
        if ($producto['trailer'])
        {
            $datos['trailer_digito']=$this->input->post('trailer_digito');
            $datos['trailer_eje']=$this->input->post('trailer_eje');
            $datos['trailer_marca']=$this->input->post('trailer_marca');
            $datos['trailer_modelo']=$this->input->post('trailer_modelo');
            $datos['trailer_anio']=$this->input->post('trailer_anio');
            $datos['trailer_chasis']=$this->input->post('trailer_chasis');
            $datos['trailer_propietario']=$this->input->post('trailer_propietario');
            $datos['trailer_rut']=$this->_rut_limpiar($this->input->post('trailer_rut'));
            $datos['trailer_documento_tipo']=$this->input->post('trailer_documento_tipo');
            //$datos['trailer_pais']=$this->input->post('trailer_pais'); //NO SE USA
            $datos['trailer_patente']=$this->input->post('trailer_patente');
        }
        
        return $datos;
    }//Preparar datos para la db

    public function _validar_certificado($certificado=array(),$trailer='')
    {

        if ($trailer)
        {
            if (
            $certificado['Nombre']!='' and 
            $certificado['Rut']!='' and 
            $certificado['Domicilio']!='' and 
            $certificado['Localidad']!='' and 
            $certificado['Pais']!='' and 
            $certificado['Telefono']!='' and 
            $certificado['Fecha']!='' and 
            $certificado['FechaDesde']!='' and 
            $certificado['Marca']!='' and 
            $certificado['Motor']!='' and 
            $certificado['Chasis']!='' and 
            $certificado['Modelo']!='' and 
            $certificado['Anio']!='' and 
            $certificado['Patente']!='' and 
            //trailer
            $certificado['trailer_eje']!='' and 
            $certificado['trailer_marca']!='' and 
            $certificado['trailer_modelo']!='' and 
            $certificado['trailer_anio']!='' and 
            $certificado['trailer_chasis']!='' and 
            $certificado['trailer_propietario']!='' and 
            $certificado['trailer_rut']!='' and 
            $certificado['trailer_patente']!=''
            //trailer
            )
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            if (
            
            $certificado['Nombre']!='' and 
            $certificado['Rut']!='' and 
            $certificado['Domicilio']!='' and 
            $certificado['Localidad']!='' and 
            $certificado['Pais']!='' and 
            $certificado['Telefono']!='' and 
            $certificado['Fecha']!='' and 
            $certificado['FechaDesde']!='' and 
            $certificado['Marca']!='' and 
            $certificado['Motor']!='' and 
            $certificado['Chasis']!='' and 
            $certificado['Modelo']!='' and 
            $certificado['Anio']!='' and 
            $certificado['Patente']!=''
            )
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }//Validar certificado
}//Clase certificado