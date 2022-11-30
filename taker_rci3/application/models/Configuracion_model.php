<?php
class configuracion_model extends CI_Model
{
	function getValor($item='')
	{
		$this->db->select('valor');
		$this->db->from('configuracion');
		
		$this->db->where('item',$item);
		
		$query=$this->db->get();
		$configuracion=$query->row_array();
		
		return $configuracion['valor']; 
	}
	function setValor($item="",$valor=""){
		$this->db->where('item',$item);
		$this->db->update('configuracion',array('valor'=>$valor));
	}

}
