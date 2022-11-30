<?php
class pagos extends CI_Controller
{
    /*
     * Informa al vendedor los pagos pendientes y los no pendientes
     * Solo lo usan para vendedores con ciclo de pago semanal o mensual
     */
    function deuda(){
        if((getPerms()=='Vendedor') or getPerms()=='Vendedor_organizador'){
            //ok
        }else{
            salir();
        }
        //$vendedor=$this->usuario_model->get_by_id();
        $data['pagos']=$this->pagos_model->get_by_user_id(getUser_id());
        $data['vendedores']=array();
        //Si es Vendedor Organizador, trae los pagos de los vendedores del grupo
        if (getPerms()=='Vendedor_organizador'){
            $organizador=$this->usuario_model->get_by_id(getUser_id());
            $grupo=$organizador['Grupo'];
            $facturacion=$organizador['facturacion'];
            //Los vendedores tienen el mismo ciclo de facturacion del organizador
            $data['vendedores']=$this->usuario_model->get_vendedores_by_grupo($grupo,$facturacion);
            //print_r($organizador);
            
            foreach ($data['vendedores'] as $key=>$vendedor){
                $data['vendedores'][$key]['pagos']=$this->pagos_model->get_by_user_id($vendedor['id']);    
            }
            //print_r($data['vendedores']);
        }
        //print_r($pagos);
        $this->load->view('pagos/deuda',$data);
    }
    
    function index(){
        if(!havePerm('Administrador')){
            salir();
        }
        
        //grilla
        $this->load->library("datagrid");
        $this->datagrid->title("Pagos");
        $this->datagrid->from('pagos');

        $this->datagrid->limit='100';
        $this->datagrid->order_by('pagos.id','desc');
        
        
        //no agrega. solo  borra
        $this->datagrid->add    =false;
        $this->datagrid->view   =false;
        $this->datagrid->edit   =true;
        
        $this->datagrid->add_action_row('detalle',base_url()."pagos/detalle/{pagos_id}","Detalle",'icon-eye-open',true,'btn btn-default datagrid_link');
        $this->datagrid->join('usuario','pagos.user_id=usuario.id');
        
        $this->datagrid->add_field(array(
                'label'         => 'ID',
                'field'         => 'pagos.id',
                'search'        => false,
                'grid'          => false,
                'edit'          => false,
                'view'          => false,
                'primary'       => true
            ));
        //Grid
        $this->datagrid->add_field(array(
            'label'             => 'Vendedor ID',   
            'field'             => 'pagos.user_id',    
            'grid'              => true,    
            'add'               => false,    
            'edit'              => false,
            'search'            =>  true,
            'search_literal'    => true   
        ));
       
        $this->datagrid->add_field(array(
            'label'             => 'Vendedor',   
            'field'             => 'usuario.Nombre',    
            'grid'              => true,    
            'add'               => false,    
            'edit'              => false,
            'search'          =>  true   
        ));
        //Edit
        
        $this->datagrid->add_field(array(
            'label'             => 'Vendedor',   
            'field'             => 'pagos.user_id',    
            'grid'              => false,    
            'add'               => true,    
            'edit'              => true,
            'validation'    => 'required',
            'default'       => $this->input->get('g_cuenta_user_id'),
            'function_values' =>array(&$this->usuario_model,'select'),
            'form_control'    =>'select',
              
        ));
        
        $this->datagrid->add_field(array(
                        'label'         => 'Importe',
                        'field'         => 'pagos.importe',

                        'validation'    => 'required',
                        'search'        => false,
                        'grid'              => true,    
                        'add'               => true,    
                        'edit'              => true,
                        
        ));
        /*
        $this->datagrid->add_field(array(
                        'label'         => 'Descuento %',
                        'field'         => 'pagos.porcentaje_descuento',
                        'grid'              => true,    
                        'add'               => true,    
                        'edit'              => true,
                        'validation'    => 'required',
        ));
        */
        /*
        $this->datagrid->add_field(array(
                        'label'         => 'Dolar Paralelo',
                        'field'         => 'pagos.dolar_paralelo',
                        'grid'              => true,    
                        'add'               => true,    
                        'edit'              => true,
                        'validation'    => 'required',
        ));
        */
        $this->datagrid->add_field(array(
                        'label'         => 'Dolar',
                        'field'         => 'pagos.dolar_oficial',
                        'grid'              => true,    
                        'add'               => true,    
                        'edit'              => true,
                        'validation'    => 'required',
        ));         
        $this->datagrid->add_field(array(
                        'label'         => 'Peso Chileno',
                        'field'         => 'pagos.peso_chileno',
                        'grid'              => true,    
                        'add'               => true,    
                        'edit'              => true,
                        'validation'    => 'required',
        ));            
        $this->datagrid->add_field(array(
                        'label'         => 'Total',
                        'field'         => 'pagos.total',
                        'grid'              => true,    
                        'add'               => true,    
                        'edit'              => true,
                        'validation'    => 'required',
                        'search'        => false,
        ));
        $this->datagrid->add_field(array(
                        'label'           => 'Periodo Desde',
                        'field'           => 'pagos.fecha_hora_desde',
                        'grid'              => true,    
                        'add'               => true,    
                        'edit'              => true,
                        'validation'      => 'required',
                        'default'         =>  fecha_hora(),
        ));
        $this->datagrid->add_field(array(
                        'label'           => 'Periodo Hasta',
                        'field'           => 'pagos.fecha_hora_hasta',
                        'grid'              => true,    
                        'add'               => true,    
                        'edit'              => true,
                        'validation'      => 'required',
                        'default'         =>  fecha_hora(),
                        'search'          =>  false,
        ));
        $this->datagrid->add_field(array(
                        'label'           => 'Cancelado',
                        'field'           => 'pagos.cancelado',
                        'form_control'    => 'select',
                        'validation'      => 'required',
                        'default'         =>  0,
                        'values'          =>array(
                                '0'=>'No',
                                '1'=>'Si'
                            ),
                        'search'          =>  true,
                        'grid'              => true,    
                        'add'               => true,    
                        'edit'              => true,
        ));
        $this->datagrid->add_field(array(
                        'label'           => 'Fecha',
                        'field'           => 'pagos.fecha_hora',
                        'grid'              => true,    
                        'add'               => true,    
                        'edit'              => true,
                        'validation'      => 'required',
                        'default'         =>  fecha_hora(),
                        'search'          =>  true,
        ));
        
        $data['datagrid']=$this->datagrid->run();             
        //no se usa mas la vista especial de pagos
        //$this->load->view("pagos/index", $data);
        $this->load->view("datagrid/template", $data);  
        
                   
    }
    

    
    function detalle($pago_id=""){
        
        $pago=$this->pagos_model->get_by_id($pago_id);
        if (!$pago){
           show_error('Pago no existe'); 
        }
        
        if((getPerms()=='Vendedor')){
             //OK, solo pueden ver el detalle propio
            if ($pago['user_id']!=getUser_id()){
                show_error('Sin permisos para ver el pago'); 
            }
         }elseif(getPerms()=='Vendedor_organizador'){
             //Solo puede ver los de su grupo
            $organizador=$this->usuario_model->get_by_id(getUser_id());
            $vendedor=$this->usuario_model->get_by_id($pago['user_id']);
            if(!$organizador){
                show_error('Organizador no existe'); 
            }
            if(!$vendedor){
                show_error('Vendedor no existe'); 
            }
            if($organizador['Grupo']!=$vendedor['Grupo']){
                show_error('Grupos de organizador y vendedor no son iguales'); 
            }
            
             
         }elseif(getPerms()=='Administrador'){
             //OK
         }else{
             salir();
         }

        $data['fecha_desde']=$pago['fecha_hora_desde'];
        $data['fecha_hasta']=$pago['fecha_hora_hasta'];
        $data['usuario']=$this->usuario_model->get_by_id($pago['user_id']);
        $data['cuentas']=$this->cuenta_model->get_ventas_by_user_id($pago['user_id'],$data['fecha_desde'],$data['fecha_hasta']);       
        $this->load->view("pagos/detalle",$data);        
    }
    
    /*
     * Muestra el detalle por rango de fechas y usuario
     */
    function detalle_by_fecha($usuario_id="",$fecha_desde="",$fecha_hasta=""){
        if(!havePerm('Administrador')){
            salir();
        }
        $data['fecha_desde']=$fecha_desde." 00:00:00";
        $data['fecha_hasta']=$fecha_hasta." 23:59:59";
        $data['usuario']=$this->usuario_model->get_by_id($usuario_id);
        $data['cuentas']=$this->cuenta_model->get_ventas_by_user_id($usuario_id,$data['fecha_desde'],$data['fecha_hasta']);       
        $this->load->view("pagos/detalle",$data);
    }
    
    
     function consultar(){
        if(!havePerm('Administrador')){
            salir();
        }

        $data=array();

        $data['dolar_oficial']=$this->configuracion_model->getValor('dolar_oficial');
        //$data['dolar_paralelo']=$this->configuracion_model->getValor('dolar_paralelo');
        //$data['porcentaje_descuento']=   round(-($data['dolar_oficial']-$data['dolar_paralelo'])/$data['dolar_paralelo']*100,2); 
        
        $this->form_validation->set_rules('fecha_desde','Fecha desde','required');
        $this->form_validation->set_rules('fecha_hasta','Fecha hasta','required|callback__validar_fecha');//no es requerido
        $this->form_validation->set_rules('facturacion','Facturacion','required');
        
        $data['cuentas']=array();
            
        if ($this->form_validation->run())
        {
            
            $data['fecha_desde']=$this->input->post('fecha_desde')." 00:00:00";
            $data['fecha_hasta']=$this->input->post('fecha_hasta')." 23:59:59";
            $data['facturacion']=$this->input->post('facturacion');
            $data['cuentas']=$this->cuenta_model->get_ventas($data['fecha_desde'],$data['fecha_hasta'],$data['facturacion']);

        }
        
        $this->load->view("pagos/consultar",$data);

    }

    //Agrega solicitudes de pago
    function agregar(){
        if(!havePerm('Administrador')){
            salir();
        }

        $usuarios=array();
        
        $usuarios=$this->input->post('usuario_id');
        $fecha_desde=$this->input->post("fecha_desde")." 00:00:00";
        $fecha_hasta=$this->input->post("fecha_hasta")." 23:59:59";

        $dolar_oficial=$this->configuracion_model->getValor('dolar_oficial');
        //$dolar_paralelo=$this->configuracion_model->getValor('dolar_paralelo');
        $peso_chileno=$this->configuracion_model->getValor('peso_chileno');
        
        //$porcentaje_descuento=   round(-($dolar_oficial-$dolar_paralelo)/$dolar_paralelo*100,2);
        
        foreach ($usuarios as $user_id){

            $cuenta=$this->cuenta_model->get_total_ventas_by_user_id($user_id,$fecha_desde,$fecha_hasta);
            $importe=$cuenta['total'];
            //$descuento=round($total*$porcentaje_descuento/100,2);
            //$total=round($total-$descuento,2);
            //echo $total;
            //echo $descuento;
            $data=array(
                "user_id"               =>$user_id,
                "importe"               =>$importe,
                //"porcentaje_descuento"  =>$porcentaje_descuento,
                //"total"                 =>round($importe-($importe*$porcentaje_descuento/100),2),
                "total"                 =>round($importe,2),
                "fecha_hora_desde"      =>$fecha_desde,
                "fecha_hora_hasta"      =>$fecha_hasta,
                "fecha_hora"             =>fecha_hora(),
                'dolar_oficial'         =>$dolar_oficial,
                //'dolar_paralelo'        =>$dolar_paralelo,
                'peso_chileno'          =>$peso_chileno
         
            );
            
            $this->pagos_model->agregar($data);

        }
        $this->session->set_flashdata('success', 'Solicitud de Pagos Agregadas');
        redirect("pagos/index");
    }
    function adeudados(){
        if(!havePerm('Administrador')){
            salir();
        }
        $data=array();
        $data['pagos']=$this->pagos_model->adeudados();
        $this->load->view("pagos/adeudados",$data);
        
    }
    
    function _validar_fecha(){
        $fecha_desde=$this->input->post('fecha_desde');
        $fecha_hasta=$this->input->post('fecha_hasta');
        

        
        if ($fecha_desde >=$fecha_hasta){

            $this->form_validation->set_message('_validar_fecha', 'Fechas inválidas');
            return false;
        }elseif(segundos_a_dias(restar_fechas($fecha_hasta, $fecha_desde))>31){
            $this->form_validation->set_message('_validar_fecha', 'No se debe seleccionar más de 31 días');
            return false;            
            
        }else{
            return true;
        }
    }

}