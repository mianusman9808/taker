<?php
class certificado_boston_model extends CI_Model
{

	function get_by_certificado_id($certificado_id)
	{
		$this->db->select('*');
		$this->db->from('boston_certificado');
		$this->db->where('certificado_id',$certificado_id);
		$this->db->order_by("id","desc");
		$query=$this->db->get();
		return $query->row_array();
	}
	function agregar($certificado_id="",$solicitud='',$pdf){
	    $data=array(
            'certificado_id'    =>$certificado_id,
            'solicitud'         =>$solicitud,
            'pdf'               =>$pdf
        );
        $this->db->insert('boston_certificado',$data);
	}
}

//FIN
