<?php
class distribuir extends CI_Controller
{
	var $vendedor_valido;

	function index()
	{
	    
        if ( (getPerms()!='Vendedor_organizador'))
        {
            salir();
        }
        
		$this->form_validation->set_rules('usuario_id','Vendedor','required|callback__validar_vendedor');
		$this->form_validation->set_rules('cantidad','Cantidad','required|is_natural|callback__tiene_credito');
		
		if ($this->form_validation->run())
		{
			if ($this->input->post('agregar'))
			{
				$this->cuenta_model->movimiento($this->input->post('usuario_id'),$this->input->post('cantidad'),'Vendedor organizador (ID '.getUser_id().')','Acredita','Credito');
				$this->cuenta_model->movimiento(getUser_id(),(-$this->input->post('cantidad')),'Vendedor organizador (ID '.getUser_id().')','Debita','Debito');
				
				redirect('distribuir/index');
			}
			elseif($this->input->post('quitar'))
			{
				$this->cuenta_model->movimiento($this->input->post('usuario_id'),(-$this->input->post('cantidad')),'Vendedor organizador (ID '.getUser_id().')','Debita','Debito');
				$this->cuenta_model->movimiento(getUser_id(),$this->input->post('cantidad'),'Vendedor organizador (ID '.getUser_id().')','Acredita','Credito');
				redirect('distribuir/index');
			}
		}
		else
		{
			$data=array();
			$vendedor_organizador=$this->usuario_model->getById(getUser_id());
			
			//vendedores de su grupo
			$data['usuarios']=$this->usuario_model->getUsuariosYCreditosByGrupo($vendedor_organizador['Grupo']);
			
			echo "<!-- ";
			echo $this->db->last_query();
			print_r($data['usuarios']);
            echo "Uid: ".getUser_id();
			echo " -->";
			
			$total_grupo=0;
            
			foreach ($data['usuarios'] as $usuario)
			{
				if ($usuario['id']==getUser_id())
				{
					//total de plata del vendedor_organizador
					$data['total_vendedor_organizador']=$usuario['total'];
				}
				
				//total de plata de todo el grupo
				$total_grupo+=$usuario['total'];
			}
			$data['total_grupo']=$total_grupo;
			
			$this->load->view('distribuir/index',$data);
		}
		
	}
	
	function _validar_vendedor()
	{
		$vendedor=$this->usuario_model->getById($this->input->post('usuario_id'));
		$vendedor_organizador=$this->usuario_model->getById(getUser_id());
		
		if($vendedor['Grupo']==$vendedor_organizador['Grupo'])
		{
			$this->vendedor_valido=true;
			return true;
		}
		else
		{
			$this->vendedor_valido=false;
			$this->form_validation->set_message('_validar_vendedor', 'Vendedor incorrecto');
	        return false;			
		}
		
		

	}
	
	function _tiene_credito()
	{
		if (!$this->vendedor_valido)
		{
			$this->form_validation->set_message('_tiene_credito', 'Error');
        	return false;
		}
		
		if($this->input->post('agregar'))
		{		    
            if ($this->input->post('cantidad')>0)
            {
                if (usuario_tiene_credito_para_producto_o_valor('',$this->input->post('cantidad')))
                {
                    //echo "tiene crédito";
                    return true;
                }
                else
                {
                    //echo "No tiene crédito";
                    $this->form_validation->set_message('_tiene_credito', 'Importe mayor que su crédito.');
                    return false;
                }
            }
            else
            {
                //INGRESO UN 0 (CERO)
                $this->form_validation->set_message('_tiene_credito', 'Número incorrecto.');
                return false;
            }           
		}
        
        if($this->input->post('quitar'))
        {           
            if ($this->input->post('cantidad')>0)
            {
                echo $this->input->post('usuario_id');
               
                $credito_del_vendedor=$this->cuenta_model->getCreditoByUsuarioId($this->input->post('usuario_id')); ;
                //$credito_del_vendedor_organizador=$this->cuenta_model->getCreditoByUsuarioId(getUser_id()); ;
                
                if ($credito_del_vendedor['total']>=$this->input->post('cantidad'))
                {
                    //echo "tiene crédito";
                    return true;
                }
                else
                {
                    //echo "No tiene crédito";
                    $this->form_validation->set_message('_tiene_credito', 'El vendedor no tiene ese importe de crédito.');
                    return false;
                }
            }
            else
            {
                //INGRESO UN 0 (CERO)
                $this->form_validation->set_message('_tiene_credito', 'Número incorrecto.');
                return false;
            }           
        }
	}
}
///FIN