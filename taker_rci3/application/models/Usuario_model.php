<?php
class usuario_model extends CI_Model
{
    function select($grupo=""){
        $this->db->select('id item,Nombre value');
        $this->db->from('usuario');
        if($grupo){
            $this->db->where("Grupo",$grupo);
        }
        $this->db->order_by('Nombre');
        $query = $this->db->get();
        return array_to_select($query->result_array());
    }
    
	function get($solo_vendedores=false)
	{
		$this->db->select('*');
		$this->db->from('usuario');
		
		if ($solo_vendedores)
		{
			
			$this->db->where('perms','Vendedor');
			$this->db->or_where('perms','Vendedor_organizador');
            //El administrador puede vender
            $this->db->or_where('perms','Administrador');
		}
		
		$this->db->order_by('Nombre');
		
		$query=$this->db->get();
		return $query->result_array();
	}
	

	function getTodosParaExcel()
	{
		$this->db->select('*');
		$this->db->from('usuario');
		
		$this->db->order_by('Nombre');
		
        $query=$this->db->get();
        return $query->result_array();
	}
    
	function get_by_id($usuario_id=''){
	    return $this->getById($usuario_id);
	}
    
	function getById($usuario_id='')
	{
		$this->db->select('*');
		$this->db->from('usuario');
		
		$this->db->where('id',$usuario_id);
		
		$query=$this->db->get();
		return $query->row_array();
	}
	function get_vendedores_by_grupo($grupo="",$facturacion=""){
        $this->db->select('*');
        $this->db->from('usuario');
        //Excluye a los vendedores organizadores
        $this->db->where('perms',"Vendedor");
        $this->db->where('Grupo',$grupo);
        //Trae solo los vendedores de un tipo de facturacion
        if ($facturacion){
         $this->db->where('facturacion',$facturacion);           
        }

        $query=$this->db->get();
        return $query->result_array();	    
	}
	function getUsuariosYCreditosByGrupo($grupo='')
	{

		$this->db->select('usuario.id, usuario.Nombre, SUM(cuenta.importe) as total');
		$this->db->from('usuario');
		$this->db->join('cuenta','cuenta.user_id=usuario.id','left');
		
		$this->db->where('Grupo',$grupo);

		$this->db->group_by('usuario.id');
		
		$query=$this->db->get();
		return $query->result_array();
	}
	
	function getGrupos()
	{
		$this->db->select('grupo');
		$this->db->from('usuario');
		
		$this->db->group_by('usuario.grupo');
		
		$query=$this->db->get();
		return $query->result_array();
	}
	
	function puede_vender_anticipado($usuario_id='')
	{
		$this->db->select('anticipado');
		$this->db->from('usuario');
		$this->db->where('id',$usuario_id);
		$this->db->where('anticipado','1');
		
		if ($this->db->count_all_results())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function getConCorreo()
	{
		$this->db->select('*');
		$this->db->from('usuario');
		
		$this->db->where('Email !=','');
		$this->db->where('Email !=','-');
		
		$this->db->order_by('Nombre');
		
		$query=$this->db->get();
		return $query->result_array();
	}
	
	//DEVUELVE EL CORREO COMO STRING
	function getCorreoById($usuario_id='')
	{
		$this->db->select('Email');
		$this->db->from('usuario');
		
		$this->db->where('id',$usuario_id);
		
		$query=$this->db->get();
		$usuario=$query->row_array();
		
		return $usuario['Email'];
	}
}

//FIN