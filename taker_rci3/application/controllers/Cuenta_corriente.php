<?php
class cuenta_corriente extends CI_Controller
{
    var $vendedor_organizador=array();
    var $buscar_usuarios=true;
    

    function grilla()
    {
        
        if ( (getPerms()=='Administrador') or (getPerms()=='Vendedor') or (getPerms()=='Vendedor_organizador') )
        {
            //ok
        }
        else
        {
            salir();
        }
        



        //$this->datagrid->title("Cuenta corriente");
        $this->datagrid->title("Crédito");
        $this->datagrid->from('cuenta');
        //$this->datagrid->wheres=array();
        $this->datagrid->view=true;

        $this->datagrid->limit='50';
        $this->datagrid->order_by('cuenta.fecha_hora','desc');
        
        //no agrega. solo modifica o borra
        $this->datagrid->add(false);
                
        //EN LA CUENTA CORRIENTE NO SE VEN LOS  LOS DEBITOS 
        $this->datagrid->where('cuenta.tipo !=','Debito Admin');
        $this->datagrid->join('usuario','cuenta.user_id=usuario.id');
        
        if (getPerms()=='Vendedor_organizador'){
            $this->vendedor_organizador=$this->usuario_model->getById(getUser_id());
            
            $this->datagrid->view=false;
            $this->datagrid->edit=false;
            $this->datagrid->delete=false;
            //filtro de la grilla
            $this->datagrid->where('usuario.Grupo',$this->vendedor_organizador['Grupo']);
            $this->datagrid->where('cuenta.fecha_hora >=','2018-09-15'); //pedido x sebastian
        }
        elseif(getPerms()=='Vendedor'){
            //solo muestra sus movimientos
            $this->datagrid->where('cuenta.user_id',getUser_id());
            $this->datagrid->where('cuenta.importe !=','0.00');
            $this->buscar_usuarios=false;
            $this->datagrid->view=false;
            $this->datagrid->edit=false;
            $this->datagrid->delete=false;
            $this->datagrid->where('cuenta.fecha_hora >=','2018-09-15'); //pedido x sebastian
        }
        elseif(getPerms()=='Administrador'){
            $this->datagrid->view=true;
            $this->datagrid->edit=true;
            $this->datagrid->delete=true;
        }
        
        
        
        $this->datagrid->add_field(array(
            'label'             => 'ID',   
            'field'             => 'cuenta.id',    
            'primary'           => true,    
            //'grid'              => true,    
            //'add'               => true,    
            //'edit'              => true    
        ));
        //Grid
        $this->datagrid->add_field(array(
            'label'             => 'Vendedor ID',   
            'field'             => 'cuenta.user_id',    
            'grid'              => true,    
            'add'               => false,    
            'edit'              => false,
            'search'          =>   $this->buscar_usuarios,
            'search_literal'    => true     
        ));
        $this->datagrid->add_field(array(
            'label'             => 'Vendedor',   
            'field'             => 'usuario.Nombre',    
            'grid'              => true,    
            'add'               => false,    
            'edit'              => false,
            'search'          =>   $this->buscar_usuarios     
        ));


        //Edit
        
        $this->datagrid->add_field(array(
            'label'             => 'Vendedor',   
            'field'             => 'cuenta.user_id',    
            'grid'              => false,    
            'add'               => true,    
            'edit'              => true,
            'validation'    => 'required',
            'default'       => $this->input->get('g_cuenta_user_id'),
            'function_values' =>array(&$this,'_select_usuarios'),
            'form_control'    =>'select',
              
        ));
        
        $this->datagrid->add_field(array(
            'label'             => 'Importe',   
            'field'             => 'cuenta.importe',    
            'grid'              => true,    
            'add'               => true,    
            'edit'              => true,
            'validation'    => 'required',

        ));
        $this->datagrid->add_field(array(
            'label'             => 'Concepto',   
            'field'             => 'cuenta.concepto',    
            'grid'              => true,    
            'add'               => true,    
            'edit'              => true,
            'default'           => 'Credito',
            'validation'        => 'required',

        ));
        $this->datagrid->add_field(array(
            'label'             => 'Fecha',   
            'field'             => 'cuenta.fecha_hora',    
            'grid'              => true,    
            'add'               => true,    
            'edit'              => true,
            'validation'        => 'required',
            'default'           => fecha_hora(),
            'search'            => true

        ));
        
       $this->datagrid->add_field(array(
            'label'             => 'Tipo',   
            'field'             => 'cuenta.tipo',    
            'grid'              => true,    
            'add'               => true,    
            'edit'              => true,
            'search'            => true,
            'form_control'   => 'select',
            'values'         => array('Credito'=>'Credito','Debito'=>'Debito','Venta'=>'Venta','Comision'=>'Comision','Comision anulada'=>'Comision anulada','Venta anulada'=>'Venta anulada','Credito Admin'=>'Credito Admin'),

        ));
        


              
        $data['datagrid']=$this->datagrid->run();
        $this->load->view("datagrid/template", $data);  
       
    }
    function _select_usuarios(){
        if ($this->vendedor_organizador){
            return $this->usuario_model->select($this->vendedor_organizador['Grupo']);
        }else{
            return $this->usuario_model->select();
        }    
    }
}
///FIN
