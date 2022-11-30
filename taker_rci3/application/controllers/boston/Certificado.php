<?php 
class Certificado extends MY_Controller{
    
    function agregar($producto_id='',$rut='null',$patente='null'){
        if ((getPerms()=='Administrador') or (getPerms()=='Vendedor') or (getPerms()=='Vendedor_organizador') ){
            //OK
        }else{
            salir();
        }
        //Limpia espacios
        $rut=trim(urldecode($rut));
        $patente=trim(urldecode($patente));
        //Convierte los null en vacio
        if ($rut=='null') $rut='';
        if ($patente=='null') $patente='';
        
        //inicializa todas las variables vacías
        $data=$this->_inicializar_variables();
        
        
        //RUT PRECARGADO
        if ($rut){
            $data['certificado']['Rut']=$rut;
            
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
            
            $certificado_vehiculo=$this->certificado_model->getByPatente($patente);
            
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
            //echo "VALIDA !";
            //exit;   
                
            //SE FIJA SI EL USUARIO TIENE CRÉDITO
            if (usuario_tiene_credito_para_producto_o_valor($producto_id)){
                //PREPARA LOS DATOS
                $datos=$this->_preparar_para_bd($data['anticipado'],$data['producto']);
                
                $datos['user_id']=getUser_id();
                
                //estado de salida "Pendiente"
                $datos['estado']='Pendiente';
                
                //FECHA DE CREACIÓN
                $datos['Fecha']=date('Y-m-d H:i:s');
                
                //Aseguradora Boston
                $datos['aseguradora_id']=2;
                
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
            $this->load->view('certificado/boston/edit',$data);
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
        

        //PRODUCTO
        $data['producto']=$this->producto_model->getById($data['certificado']['id_tipo_certificado']);
        
        
        //VALIDACION
        if ($this->_validar($data['anticipado'],$data['producto']['trailer']))
        {
            //echo "VALIDA !";
            // exit;
            $datos=$this->_preparar_para_bd($data['anticipado'],$data['producto']);
            $this->certificado_model->modificar($certificado_id,$datos);

            $this->session->set_flashdata('success', 'Certificado modificado con éxito');
            redirect('certificado/grilla');
        }
        else
        {
            //NO VALIDA
            $this->load->view('certificado/boston/edit',$data);
        }
 
    }//MODIFICAR


    function imprimir($certificado_id=''){
        if ((getPerms()=='Beneficiario') or (getPerms()=='Administrador') or (getPerms()=='Vendedor') or (getPerms()=='Vendedor_organizador') or (getPerms()=='Aseguradora'))
        {
            //puede imprimir
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
        if(getPerms()=='Administrador' or getPerms()=="Aseguradora"){
            //Ok
        }else{
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
            //OK !
        }
        else
        {
            //NO valida
            $this->session->set_flashdata('error','Datos incompletos. Para imprimir un Certificado debe completar todos los datos.');
            redirect('certificado/grilla');
        }

        
        //Si no tiene solicitud se conecta el WS
        if($certificado['Estado']=="Pendiente")
        {
            if(ENVIRONMENT!="production"){
                show_error("No genera certificados en testing");
            }
  
            //AVISA LA VENTA AL WSERVICE
            //GRAGA EL PDF EN LA BASE DATOS
            //GRABA EL NUMERO DE SOLICITUD
            $this->load->library("ws_boston");
            $x=$this->ws_boston->nuevo_seguro($certificado,$producto);
            
            if(!is_array($x)){
                $this->certificado_model->actualizar_solicitud_error($certificado['id'],"Error de conexión con Boston");
                $this->session->set_flashdata('error', "Error de conexión con Boston");
                redirect('certificado/grilla');                
            }


            if($x['error']){
                $texto_error="";
                if(is_array($x['error'])){
                    foreach($x['error']as $error){
                        $texto_error.="<p>".$error."</p>";
                    }
                }else{
                    $texto_error=$texto_error.="<p>".$x['error']."</p>";
                }
                $this->certificado_model->actualizar_solicitud_error($certificado['id'],limpiar_html($texto_error));
                $this->session->set_flashdata('error', $texto_error);
                redirect('certificado/grilla');
            }else{
                //NO tiene error
                //Agrega el pdf a la tabla de certificados de boston
                $this->certificado_boston_model->agregar($certificado['id'],$x['solicitud'],$x['pdf']);
                //Actualiza el certificado con el numero de solicitud
                $this->certificado_model->actualizar_solicitud($certificado['id'],$x['solicitud']);
                //Cambia el estado del certificado a emitido
                $this->certificado_model->cambiar_estado($certificado['id'],'Emitido');  
                //ENVIA EL CORREO DE AVISO
                $this->correo->certificado_boston($certificado['id']); 
            }//SIN ERROR

        }//PENDIENTE
        
        //Busca el pdf en la base de datos de PDFs
        $certificado=$this->certificado_boston_model->get_by_certificado_id($certificado['id']);

        if($certificado){
            header("Content-type:application/pdf");
            header("Content-Disposition:attachment;filename=boston.pdf");
            echo $certificado['pdf'];
        }else{
            show_error("No se pudo obtener el certificado de cobertura");
        }//CERTIFICADO EN LA DB
        
        
    

    }//IMPRIMIR

    ///////////////////////////////////////////////////////////////////////////////////////////////
    //METODOS QUE USA LA MERCANTIL
    public function _inicializar_variables()
    {
        $data['certificado']['Nombre']='';
        $data['certificado']['Apellido']='';
        $data['certificado']['documento_tipo']=''; 
        $data['certificado']['Rut']='';
        $data['certificado']['Domicilio']='';
        $data['certificado']['Localidad']='';
        $data['certificado']['Pais']='46';  //Chile
        $data['certificado']['Telefono']='';
        $data['certificado']['Marca']='';
        $data['certificado']['Modelo']=''; 
        $data['certificado']['Anio']='';
        $data['certificado']['Patente']='';
        $data['certificado']['digito']='';
        $data['certificado']['Motor']='';
        $data['certificado']['Chasis']='';
        $data['certificado']['FechaDesde']=fecha();
        $data['certificado']['Uso']='';
        $data['certificado']['conductor']='';
        $data['certificado']['Fecha']=''; 
        $data['certificado']['Fecha_Nacimiento']='';             //BOSTON 
        $data['certificado']['boston_carroceria_id']='';         //BOSTON 
        return $data;
    }//INICIAR VARIABLES
    
    //SIEMPRE VALIDA LOS MISMOS CAMPOS
    public function _validar($anticipado='',$trailer='')
    {
       //print_r($_POST);

        //reglas de validación
        $this->form_validation->set_rules('conductor', 'Conductor', 'required');
        $this->form_validation->set_rules('Nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('Apellido', 'Apellido', 'required');
        $this->form_validation->set_rules('Rut', 'Rut', 'required|callback__validar_rut'); //A veces se da el caso de que presentan pasaporte y escriben: "1336122516 (PASAPORTE)"
        $this->form_validation->set_rules('documento_tipo', 'Tipo de documento','required'); 
        $this->form_validation->set_rules('Domicilio', 'Domicilio', 'required');
        $this->form_validation->set_rules('Localidad', 'Localidad', 'required');
        $this->form_validation->set_rules('Pais', 'Pais', 'required');
        $this->form_validation->set_rules('Telefono', 'Telefono', 'required|alpha_dash');
        $this->form_validation->set_rules('Uso', 'Uso', 'required');
        $this->form_validation->set_rules('Fecha_Nacimiento', 'Fecha de Nacimiento', 'required'); //BOSTON
        $this->form_validation->set_rules('boston_carroceria_id', 'Carroceria', 'required'); //BOSTON
        
        if ($anticipado)
        {
            $this->form_validation->set_rules('FechaDesde', 'Fecha desde', 'required|callback__fecha_desde_correcta');
        }
        

        
        $this->form_validation->set_rules('Marca', 'Marca', 'required|max_length[30]');
        if($this->input->post('boston_tipo_id')=="6" or $this->input->post('boston_tipo_id')=="14"){
            
            $this->form_validation->set_rules('Motor', 'Número de Motor');  //Acoplado o semirremolque motor no requerido
        }else{

            $this->form_validation->set_rules('Motor', 'Número de Motor', 'required|min_length[4]|max_length[25]|alphanumerico_guiones');   //LE SAQUÉ ALPAHNUMERIC. EJEMPLO ESCRIBEN 3E-1138898. CON GUIONES.
        }

        $this->form_validation->set_rules('Chasis', 'Número de Chasis', 'required|min_length[4]|max_length[30]|alphanumerico_guiones'); //LE SAQUÉ ALPAHNUMERIC. EJEMPLO ESCRIBEN EL42-0300263. CON GUIONES.
        $this->form_validation->set_rules('Modelo', 'Modelo', 'required|max_length[50]');
        
        //año actual
        $anio_actual=date('Y');
        $anio_maximo=$anio_actual+BOSTON_VEHICULO_ANIO_MAXIMO+1; //el codeigniter no hace el igual o menor que 2012 sino menor que 2012 y lo deja afuera por ejemplo. por eso sumo
        $anio_minimo=$anio_maximo-BOSTON_VEHICULO_ANIO_MINIMO-2; //y acá resto uno (leer linea de arriba)
        
        $this->form_validation->set_rules('Anio', 'Año de fabricación', 'required|is_natural|greater_than['.$anio_minimo.']|less_than['.$anio_maximo.']');
        //año actual
        
        $this->form_validation->set_rules('Patente', 'Patente', 'required|alpha_dash|max_length[9]|callback__validar_patente_auto');
        $this->form_validation->set_rules('digito', 'Dígito', 'alpha_numeric|max_length[1]'); //no es requerido
        
        
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
        //PERSONA
        $datos['conductor']=$this->input->post('conductor');    
        
        $datos['Nombre']=strtoupper($this->input->post('Nombre'));
        $datos['Apellido']=strtoupper($this->input->post('Apellido')); 
        $datos['documento_tipo']=$this->input->post('documento_tipo'); 
        $datos['Rut']=$this->_rut_limpiar($this->input->post('Rut'));
        $datos['documento_tipo']=$this->input->post('documento_tipo');
        $datos['Domicilio']=$this->input->post('Domicilio');
        $datos['Localidad']=$this->input->post('Localidad');
        $datos['Pais']=     $this->input->post('Pais');
        $datos['Telefono']= $this->input->post('Telefono');
        //BOSTON
        $datos['Fecha_Nacimiento']= $this->input->post('Fecha_Nacimiento'); //Boston
        $datos['boston_carroceria_id']=$this->input->post('boston_carroceria_id'); //Boston
        
        //FECHA DESDE
        //vendedor (anticipado)
        /*
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
        */
         
        //FIN FECHA DESDE
        

        
        //BOSTON SIEMPRE EMITE CERTIFICADOS DE DIAS COMPLETOS
        ///No tiene en cuenta la hora
        
        
        
        $datos['FechaDesde']=$this->input->post('FechaDesde').' 00:00:00';
        
        //////////////////////////////////////////////////////////////////
        //FECHA HASTA
        //calculamos el FechaHasta a partir de la duración de la cobertura (campo validez)
        $fecha_desde_segundos=strtotime($datos['FechaDesde']);
        $segundos_hasta = ((int)$producto['validez']*86400)-1;
        $fecha_hasta_segundos=$fecha_desde_segundos+$segundos_hasta;
        
        //Es hoy, entonces boston le suma un dia mas a la fecha
        //if ($this->input->post('FechaDesde')==date('Y-m-d')){
            //Siempre le suma un dia a la fecha  
            $fecha_hasta_segundos+=86400;
        //}

        $datos['FechaHasta']=date("Y-m-d H:i:s", $fecha_hasta_segundos);
        //FIN FECHA HASTA
        //////////////////////////////////////////////////////////////////////////////////
        
        $datos['id_tipo_certificado']=$producto['id'];
        $datos['MedioPago']='Cancelado en Efectivo'; 
        
        
        //DATOS DEL VEHÍCULO
        $datos['Uso']=$this->input->post('Uso');
        $datos['Motor']=$this->input->post('Motor');
        $datos['Marca']=$this->input->post('Marca');
        $datos['Chasis']=$this->input->post('Chasis');
        $datos['Modelo']=$this->input->post('Modelo');
        $datos['Anio']=$this->input->post('Anio');
        $datos['Patente']=strtoupper($this->input->post('Patente'));
        $datos['digito']=$this->input->post('digito');
        $datos['precio']="";//no tiene, no se usa mas
        
        
        return $datos;
    }//Preparar datos para la db

    public function _validar_certificado($certificado=array(),$trailer='')
    {

        if (
            $certificado['Nombre']!='' and 
            $certificado['Apellido']!='' and 
            $certificado['Rut']!='' and 
            $certificado['Domicilio']!='' and 
            $certificado['Localidad']!='' and 
            $certificado['Pais']!='' and 
            $certificado['Telefono']!='' and 
            $certificado['Fecha']!='' and 
            $certificado['FechaDesde']!='' and 
            $certificado['Uso']!='' and 
            $certificado['conductor']!='' and 
            $certificado['Marca']!='' and 
            //MOTOR ES OPTATIVO PARA ACOPLADOS Y SEMIRREMOLQUE
            //$certificado['Motor']!='' and 
            $certificado['Chasis']!='' and 
            $certificado['Modelo']!='' and 
            $certificado['Anio']!='' and 
            $certificado['id_tipo_certificado']!='' and
            $certificado['Patente']!=''){
                return true;
            }
            else
            {
                return false;
            }
       
    }//Validar certificado
}//Clase certificado