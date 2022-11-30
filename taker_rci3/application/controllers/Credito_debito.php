<?php
class credito_debito extends CI_Controller
{
	function grilla()
    {
        
		if ( (getPerms()=='Administrador') ){
			//nada
		}
		else
		{
		    salir();
		}

        $this->datagrid->title("Créditos y débitos");
        $this->datagrid->from('cuenta');

        $this->datagrid->view(true);

        
        $this->datagrid->limit('50');
        $this->datagrid->order_by('cuenta.fecha_hora','desc');

        //$this->datagrid->where("(tipo='Credito Admin' OR tipo='Debito Admin')",null,false);
        $this->datagrid->where("(tipo='Credito Admin')",null,false);
        
		$this->datagrid->join('usuario','cuenta.user_id=usuario.id');

 
            $this->datagrid->add_field(array(
                'label'         => 'ID',
                'field'         => 'cuenta.id',
                'search'        => false,
                'grid'          => false,
                'edit'          => false,
                'view'          => false,
                'primary'       => true
            ));
            
        //Grid
        $this->datagrid->add_field(array(
            'label'             => 'Vendedor ID',   
            'field'             => 'cuenta.user_id',    
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
            'field'             => 'cuenta.user_id',    
            'grid'              => false,    
            'add'               => true,    
            'edit'              => true,
            'validation'    => 'required',
            'default'       => $this->input->get('g_cuenta_user_id'),
            'function_values' =>array(&$this->usuario_model,'select'),
            'form_control'    =>'select',
              
        ));
            
	   $this->datagrid->add_field(array(
                'label'			=> 'Tipo',
                'field'         => 'tipo',
                'validation'    => 'required',
                'form_control'  => 'select',
                'grid'              => true,    
                'add'               => true,    
                'edit'              => true,
                //PAGUIAR: No entiendo para que sirve el debito admin
                //'values'		=> array('Credito Admin'=>'Credito Admin','Debito Admin'=>'Debito Admin'),
                'values'        => array('Credito Admin'=>'Credito Admin'),
                'search'		=> true,
		));
			
        $this->datagrid->add_field(array(
                'label'         => 'Crédito',
                'field'         => 'importe',
                'grid'              => true,    
                'add'               => true,    
                'edit'              => true,
                'search'        => false,
       ));
       /*
       $this->datagrid->add_field(array(
                'label'         => 'Débito',
                'field'         => 'debito_admin',

                'grid'              => true,    
                'add'               => true,    
                'edit'              => true,
                'search'        => false,
      ));
      */
       $this->datagrid->add_field(array(
                'label'         => 'Concepto',
                'field'         => 'concepto',
                'grid'              => true,    
                'add'               => true,    
                'edit'              => true,
                'validation'    => 'required',
                'search'		=> true,
                'default'       => 'anticipo'
      ));

       $this->datagrid->add_field(array(
				'label'				=> 'Fecha',
				'field'         	=> 'fecha_hora',
				'default'			=>  date('Y-m-d H:i:s'),
				'form_control'		=> 'text',
                'grid'              => true,    
                'add'               => true,    
                'edit'              => true,
				'search'			=> false,
		));
		 

  
        $data['datagrid']=$this->datagrid->run();
        $this->load->view("datagrid/template", $data); 
       
    }

	
}
///FIN
