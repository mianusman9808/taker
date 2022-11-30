<?php
class Boston_pais_model extends CI_Model {
    function select(){
        
        $this->db->select('id item, nombre value');
        $this->db->from('boston_pais');
        $this->db->order_by('nombre');
                
        $query=$this->db->get();
        $resultado= $query->result_array();

        $resultado=array_to_select($resultado);
        return $resultado;
      
    }
}

?>