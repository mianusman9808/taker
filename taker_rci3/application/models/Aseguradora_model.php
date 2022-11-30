<?php
class aseguradora_model extends CI_Model
{
    function select(){
        $this->db->select('id item,Nombre value');
        $this->db->from('aseguradora');

        $this->db->order_by('Nombre');
        $query = $this->db->get();
        return array_to_select($query->result_array());
    }
    

    
	function get_by_id($id=''){

		$this->db->select('*');
		$this->db->from('aseguradora');
		
		$this->db->where('id',$id);
		
		$query=$this->db->get();
		return $query->row_array();
	}

}

//FIN