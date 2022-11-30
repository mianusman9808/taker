<?php
class comision_model extends CI_Model
{
	function getByUsuarioId($usuario_id='')
	{
		$this->db->select('*');
		$this->db->from('comision');
		
		$this->db->where('user_id_vendedor',$usuario_id);
		
		$query=$this->db->get();
        return $query->result_array();
	}
}

///FIN
