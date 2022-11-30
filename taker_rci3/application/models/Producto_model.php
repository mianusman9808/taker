<?php
class producto_model extends CI_Model
{
	function get()
	{
		$this->db->select('producto.*');
        $this->db->select("aseguradora.nombre aseguradora");
		$this->db->from('producto');
        $this->db->join("aseguradora",'producto.aseguradora_id=aseguradora.id');
        //SOLO TRAE LOS PRODUCTOS DE LA MERCANTIL HASTA EL ALTA DE BOSTON
        
        if(getPerms()!="Administrador"){
		  $this->db->where('producto.aseguradora_id',1);
        }
		
		$this->db->order_by('producto.orden asc, producto.nombre asc');
		
		$query=$this->db->get();
		return $query->result_array();
	}
    
	function get_by_id($producto_id=''){
	   return $this->getById($producto_id);
	}
	function getById($producto_id='')
	{
		$this->db->select('*');
		$this->db->from('producto');
		
		$this->db->where('id',$producto_id);
		
		$query=$this->db->get();
		return $query->row_array();
	}
	
	function getValideces()
	{
		$this->db->select('validez');
		$this->db->from('producto');
		
		$this->db->group_by('validez');
		$this->db->order_by('validez');
		
		$query=$this->db->get();
		return $query->result_array();
	}
	
	function getTipos()
	{
		$this->db->select('tipo');
		$this->db->from('producto');
		
		$this->db->group_by('tipo');
		$this->db->order_by('tipo');
		
		$query=$this->db->get();
		return $query->result_array();
	}
}


//FIN