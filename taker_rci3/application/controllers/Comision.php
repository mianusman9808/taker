<?php
class comision extends CI_Controller
{
	function grilla()
    {
		if (getPerms()!='Administrador')
		{
			salir();
		}
        $this->datagrid->title("Comisiones");
        $this->datagrid->from('comision');


        $this->datagrid->limit='50';
        $this->datagrid->order_by('comision.user_id_comisionista','desc');

        $this->datagrid->join('usuario as vendedor','comision.user_id_vendedor=vendedor.id');
        $this->datagrid->join('usuario as comisionista','comision.user_id_comisionista=comisionista.id');

        
        
        $this->datagrid->add_field(array(
            'label'             => 'ID',   
            'field'             => 'comision.id',    
            'primary'           => true,    
            'grid'              => true,    
            //'add'               => true,    
            //'edit'              => true    
        ));
        
        //Grid
        $this->datagrid->add_field(array(
            'label'             => 'Vendedor',   
            'field'             => 'vendedor.Nombre',    
            'grid'              => true,    
            'add'               => false,    
            'edit'              => false,
            'search'            => true     
        ));
        $this->datagrid->add_field(array(
            'label'             => 'Comisionista',   
            'field'             => 'comisionista.Nombre',    
            'grid'              => true,    
            'add'               => false,    
            'edit'              => false,
            'search'            => true     
        ));
        //Edit
        $this->datagrid->add_field(array(
            'label'             => 'Vendedor',   
            'field'             => 'comision.user_id_vendedor',    
            'grid'              => false,    
            'add'               => true,    
            'edit'              => true,
            'validation'        => 'required',
            'function_values'   => array($this->usuario_model,'select'),
            'form_control'      =>'select',    
        ));
        $this->datagrid->add_field(array(
            'label'             => 'Comisionista',   
            'field'             => 'comision.user_id_comisionista',    
            'grid'              => false,    
            'add'               => true,    
            'edit'              => true,
            'validation'        => 'required',
            'function_values'   => array($this->usuario_model,'select'),
            'form_control'      =>'select',    
        ));
        ////////////
        $this->datagrid->add_field(array(
            'label'             => 'Porcentaje',   
            'field'             => 'comision.porcentaje_comisionista',    
            'grid'              => true,    
            'add'               => true,    
            'edit'              => true,
            'validation'        => 'required|is_natural|callback__porcentaje_posible|callback__ya_existe_relacion',

        ));
        

        

              
        $data['datagrid']=$this->datagrid->run();
        $this->load->view("datagrid/template", $data);  
    }

	//CALLBACK
	//SE FIJA SI HAY OTROS VENDEDORES QUE COMISIONAN DE ESTE VENDEDOR
	//Y NOS ASEGURAMOS QUE NO SUPEREN EL 100% DE LA COMISIÓN TOTAL DE PRODUCTO

	function _porcentaje_posible()
	{
        
        
		$user_id_vendedor=$this->input->post('comision_user_id_vendedor');
		$user_id_comisionista=$this->input->post('comision_user_id_comisionista');
		$porcentaje_comisionista=$this->input->post('comision_porcentaje_comisionista');
		
		$comisiones=$this->comision_model->getByUsuarioId($user_id_vendedor);
		
		if ($comisiones)
		{
			$porcentaje_total=0;
			foreach ($comisiones as $comision)
			{
				if ($comision['user_id_comisionista']!=$user_id_comisionista)
				{
					$porcentaje_total+=$comision['porcentaje_comisionista'];
				}
			}
			$porcentaje_total=$porcentaje_total+$porcentaje_comisionista;
			
			//Se permiten comisiones de hasta el 150%, parece absurdo pero 
			//Sebastian lo pide cambiar asi por un tema el negocio que no entiendo
			if ($porcentaje_total<=150 and $porcentaje_total>0) //válido entre 0 y 150
			//if ($porcentaje_total<=100 and $porcentaje_total>0) //válido entre 0 y 100
			{
				return true;
			}
			else
			{
				$this->form_validation->set_message('_porcentaje_posible', 'El porcentaje es incorrecto. Corrobar suma de comisiones sobre este vendedor.');
				return FALSE;
			}
		}
		else
		{
			if ($porcentaje_comisionista<=100 and $porcentaje_comisionista>0) //válido entre 0 y 100
			{
				return TRUE;
			}
			else
			{
				$this->form_validation->set_message('_porcentaje_posible', 'El porcentaje es incorrecto');
				return FALSE;
			}
		}
		
	}

	function _ya_existe_relacion()
	{
	    $id=0;
		if ($this->input->post('g_action')=="save_edit")
		{
			//ESTÁ MODIFICANDO
			$id=$this->input->post('comision_id');
		}

        $user_id_vendedor=$this->input->post('comision_user_id_vendedor');
        $user_id_comisionista=$this->input->post('comision_user_id_comisionista');
        $porcentaje_comisionista=$this->input->post('comision_porcentaje_comisionista');
		
		$comisiones=$this->comision_model->getByUsuarioId($user_id_vendedor);

		if ($comisiones)
		{
			foreach ($comisiones as $comision)
			{
				if ($comision['user_id_vendedor']==$user_id_vendedor and $comision['user_id_comisionista']==$user_id_comisionista)
				{
					if ($comision['id']!=$id) // si es distinta al id no esta editando la misma
					{
						$this->form_validation->set_message('_ya_existe_relacion', 'Ya existe relación entre estos 2 vendedores.');
						return FALSE;
					}
				}
			}
			return TRUE;
		}
		else
		{
			return TRUE;
		}
		
	}

}
///FIN
