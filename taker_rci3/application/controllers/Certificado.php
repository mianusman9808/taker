<?php 
class Certificado extends MY_Controller{
    function index(){
        $this->grilla();
    }
    function grilla(){
        if ( (getPerms()=='Administrador') or (getPerms()=='Vendedor') or (getPerms()=='Vendedor_organizador') or (getPerms()=='Aseguradora') ){
            //OK
        }else{
            salir();
        }
        $this->datagrid->title("Certificados");
        $this->datagrid->from('certificado');
        $this->datagrid->limit('20');
        $this->datagrid->order_by('certificado.id','desc');
        
        $this->datagrid->join("usuario","certificado.user_id=usuario.id");
        //$this->datagrid->join("aseguradora","certificado.aseguradora_id=aseguradora.id");
        $this->datagrid->join("producto as producto","certificado.id_tipo_certificado=producto.id");
         
        $this->datagrid->template("search","datagrid/placeholder_search");
        $this->datagrid->add(false);
        $this->datagrid->edit(false);
        $this->datagrid->delete(false);
        
        //el admin ve todos los certificados
        //cada vendedor ve solo sus operaciones
        if (getPerms()=='Vendedor' or getPerms()=="Vendedor_organizador")
        {
            $this->datagrid->where('certificado.user_id',getUser_id());
        }
        //La aseguradora no agrega y solo ve sus certificados
        //Solo ve los emitidos
        if(getPerms()=="Aseguradora"){
            //no agrega
            //Solamente ve los certificados de su aseguradora
            $yo=$this->usuario_model->get_by_id(getUser_id());
            if(empty($yo['aseguradora_id'])){
                show_error("Falta aseguradora ID en la configuración del usuario");
            }
            $this->datagrid->where('certificado.aseguradora_id',$yo['aseguradora_id']);
            //Solamente ve los emitidos o anulados
            $this->datagrid->where('(certificado.estado="Emitido" or certificado.estado="Anulado")');
        }else{
            $this->datagrid->add_action_grid('agregar',BASEURL.'certificado/seleccionar_producto',"Agregar Certificado");
        }
        
        $this->datagrid->add_field(array(
            'label'             => 'ID',   
            'field'             => 'certificado.id',    
            'primary'           => true,    
            'grid'              => true,    
            'add'               => true,    
            'edit'              => true,
            'search'            => true
        ));
        
        if(getPerms()=="Aseguradora"){
            //La aseguradora no ve el nombre, ve la localidad
            $this->datagrid->add_field(array(
                'label'             => 'Localidad',
                'field'             => 'usuario.Localidad',
                'grid'              => true,
                'edit'              => true,
                'add'               => true,
                'search'            => true           
            ));
        }else{
            $this->datagrid->add_field(array(
                'label'             => 'Usuario',
                'field'             => 'usuario.Nombre',
                'grid'              => true,
                'edit'              => true,
                'add'               => true,
                'search'            => true           
            ));            
        }
        $this->datagrid->add_field(array(
            'label'             => 'Número',
            'field'             => 'certificado.Numero',
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            'search'            => true           
        ));
        $this->datagrid->add_field(array(
            'label'             => 'Nombre',
            'field'             => 'certificado.Nombre',
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            'search'            => true           
        ));
        $this->datagrid->add_field(array(
            'label'             => 'Rut',
            'field'             => 'certificado.Rut',
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            'search'            => true           
        ));
        $this->datagrid->add_field(array(
            'label'             => 'Patente',
            'field'             => 'certificado.Patente',
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            'search'            => true           
        ));
        $this->datagrid->add_field(array(
            'label'             => 'Digito',
            'field'             => 'certificado.digito',
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            'search'            => true           
        ));
         
        $this->datagrid->add_field(array(
            'label'             => 'Desde',
            'field'             => 'certificado.FechaDesde',
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            'search'            => false           
        ));
        $this->datagrid->add_field(array(
            'label'             => 'Hasta',
            'field'             => 'certificado.FechaHasta',
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            'search'            => false           
        ));
        $this->datagrid->add_field(array(
            'label'             => 'Creado',
            'field'             => 'certificado.Fecha',
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            'search'            => false           
        ));
         $this->datagrid->add_field(array(
            'label'             => 'Producto',
            'field'             => 'producto.nombre',
            'grid'              => true,
            'edit'              => false,
            'add'               => false,
            'search'            => true           
        ));
        
        $this->datagrid->add_field(array(
            'label'             => 'Estado',
            'field'             => 'certificado.Estado',
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            'search'            => true,
            'values'            => array(
                'Pendiente' =>'Pendiente',
                'Emitido'   =>'Emitido',
                'Anulado'   =>'Anulado'
                ),
             'form_control'      => 'select',              
        ));
        if (getPerms()=='Administrador'){
            $this->datagrid->add_field(array(
                'label'             => 'Solicitur',
                'field'             => 'certificado.solicitud',
                'grid'              => true,
                'edit'              => true,
                'add'               => true,
                'search'            => true           
            ));
            $this->datagrid->add_field(array(
                'label'             => 'Error',
                'field'             => 'certificado.solicitud_error',
                'grid'              => true,
                'edit'              => true,
                'add'               => true,
                'search'            => false           
            ));
             
        }
        /* hace muy lenta la quiery
        $this->datagrid->add_field(array(
            'label'             => 'Aseguradora',
            'field'             => 'aseguradora.nombre',
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            'search'            => true

        )); 
        */
        //ACCIONES
        $this->datagrid->add_field(array(
            'label'             => 'Acciones',   
            'field'             => 'certificado.id',    
            'grid'              => true,    
            'add'               => false,    
            'edit'              => false,
            'function'          =>array(&$this,"_acciones")    
        ));        
        
        $data['cuenta']=$this->cuenta_model->getCreditoByUsuarioId(getUser_id());
        

        
        if (usuario_facturacion()){
            $data['pagos']=$this->pagos_model->get_deuda_by_user_id(getUser_id());
        }else{
            $data['pagos']=array();                
        }


        $data['datagrid']=$this->datagrid->run();
        $this->load->view("certificado/datagrid", $data);        
       
    }
    function seleccionar_producto()
    {
        if ( (getPerms()=='Administrador') or (getPerms()=='Vendedor') or (getPerms()=='Vendedor_organizador') )
        {
            //OK
        }
        else
        {
            salir();
        }
        
        $data['operacion']='certificado'; //????         
        $data['productos']=$this->producto_model->get();
        $this->load->view('certificado/seleccionar_producto',$data);
    }
    

    
    function anular($certificado_id='',$confirmar=false)
    {
        //TIENE QUE VOLVER TODOS LOS PASOS PARA ATRÁS:
        //SI DEBITÓ PLATA DEVOLVERLA,
        //SI ALGUIEN COMISIONÓ SACARLA.
        //Y PONER ESTADO='ANULADO'
        
       if ((getPerms()=='Administrador') or (getPerms()=='Vendedor') or (getPerms()=='Vendedor_organizador') )
        {
            //puede editar
        }
        else
        {
            salir();
        }
        
        $certificado=$this->certificado_model->getById($certificado_id);
         if(!$certificado){
            show_error("Certificado no existe");
        }       
        
        //CONTROLA EL PROPIETARIO
        if (getPerms()!='Administrador')
        {       
            if(!$this->certificado_model->usuario_propietario_de_certificado(getUser_id(),$certificado_id))
            {
                show_error("No está permitido anular este certificado");
            }
            
            //SOLO SE PUEDEN ANULAR LOS PENDIENTES
            //(EL ADMIN SI PUEDE ANULAR CUALQUIER CERTIFICADO)
            if ($certificado['Estado']!='Pendiente')
            {
                show_error("No está permitido anular este certificado");
            }
        }
        

        $producto=$this->producto_model->getById($certificado['id_tipo_certificado']);
        if(!$producto){
            show_error("Producto no existe");
        } 
        if($confirmar){
            //DESHACE LOS MOVIMIENTOS DE DEBITAR Y ACREDITAR (MODO INVERSO A LA VENTA)
            deshace_movimientos($certificado['id']);
            
            
            $this->certificado_model->cambiar_estado($certificado_id,'Anulado');
            
            $this->session->set_flashdata('success', 'Certificado anulado con éxito');
            redirect('certificado/grilla');
        }else{
            $data['certificado']=$certificado;
            $this->load->view("certificado/confirmar_borrar",$data);
        }
    }
    function imprimir_previa($certificado_id='')
    {
        
        if ((getPerms()=='Beneficiario') or (getPerms()=='Administrador') or (getPerms()=='Vendedor') or (getPerms()=='Vendedor_organizador')  or (getPerms()=='Aseguradora') )
        {
            //ok
        }
        else
        {
            salir();
        }
        
        $certificado=$this->certificado_model->getById($certificado_id);
        if (!$certificado){
           show_error("Certificado no existe");
        }
        
        //VALIDA QUE EL USUARIO SEA PROPIETARIO O ADMIN O ASEGURADORA
        if(getPerms()=='Administrador' or getPerms()=='Aseguradora'){
            //OK
        }else{
            if (! $this->_usuario_propietario(getUser_id(),$certificado_id) )
            {
                show_error("No tiene permisos para imprimir este certificado");
            }
        }
        
        $data['certificado_id']=$certificado_id;
        
        
        //VALIDA QUE NO ESTE ANULADO
        if($certificado['Estado']=='Anulado'){
            show_error("No tiene permisos para imprimir certificados anulados");
        }
        
        
        $producto=$this->producto_model->getById($certificado['id_tipo_certificado']);
        if(!$producto){
            show_error("El producto no existe");
        }
        

        $this->load->view('certificado/imprimir',$data);
        
    }

    //METODOS QUE REDIRECCIONAN A LOS FORMULARIOS DE CADA ASEGURADORA
    function agregar($producto_id='',$rut='null',$patente='null',$digito=null){
        $producto=$this->producto_model->get_by_id($producto_id);
        if(!$producto){
            show_error("Producto no existe");
        }
        if($producto['aseguradora_id']==1){
            //La Mercantil
            redirect ('la_mercantil/certificado/agregar/'.$producto_id.'/'.$rut.'/'.$patente.'/'.$digito);
        }else{
            //Boston
            redirect ('boston/certificado/agregar/'.$producto_id.'/'.$rut.'/'.$patente.'/'.$digito);
        }
    }
    function modificar($certificado_id=''){
        $certificado=$this->certificado_model->get_by_id($certificado_id);
        if($certificado['aseguradora_id']==1){
            redirect ('la_mercantil/certificado/modificar/'.$certificado_id);
        }else{
            redirect ('boston/certificado/modificar/'.$certificado_id);
        }
    }  
    function imprimir($certificado_id=''){

        $certificado=$this->certificado_model->get_by_id($certificado_id);
        if($certificado['aseguradora_id']==1){
            redirect ('la_mercantil/certificado/imprimir/'.$certificado_id);
        }else{
            redirect ('boston/certificado/imprimir/'.$certificado_id);
        }
    }
    
    //ACCIONES DE LA GRILLA
    function _acciones($data=array()){
        //Si esta pendiente se puede anular o editar
        $html='<div style="white-space:nowrap">';
        //Modificar
        if($data['certificado_Estado']=='Pendiente'){
            
            $html.='<a href="'.base_url().'certificado/modificar/'.$data['certificado_id'].'" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></a> ';
            
        }
        //IMPRIMIR
        if($data['certificado_Estado']=='Pendiente' or $data['certificado_Estado']=='Emitido'){
            
            $html.='<a href="'.base_url().'certificado/imprimir_previa/'.$data['certificado_id'].'" class="btn btn-default"><span class="glyphicon glyphicon-print"></a> ';
 
        }
        //Anular
        if (getPerms()=='Administrador'){
            //Los administradores anulan todos los que no estan anulados
            if($data['certificado_Estado']!='Anulado'){
                
                $html.='<a href="'.base_url().'certificado/anular/'.$data['certificado_id'].'" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></a>';   
                
            }            
        }else{
            //Los vendedores anulan los Pendientes
            if($data['certificado_Estado']=='Pendiente'){
                
                $html.='<a href="'.base_url().'certificado/anular/'.$data['certificado_id'].'" class="btn btn-danger">Anular</a>';   
                
            }
        }
        
        $html.='</div>';
        
        return $html;
    }
}
