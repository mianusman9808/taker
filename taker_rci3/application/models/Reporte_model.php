<?php
class reporte_model extends CI_Model{
    function totales_by_anio_mes($anio="",$mes=""){
        $this->db->select('COUNT(certificado.id) total',true);
        $this->db->select('certificado.user_id, usuario.Nombre as usuario_nombre');
        
        $this->db->from('certificado');
        
        $this->db->join('usuario','usuario.id=certificado.user_id');
        
        $this->db->where('certificado.Estado','Emitido');
        
        $this->db->where('MONTH(certificado.Fecha)',$mes);
        $this->db->where('YEAR(certificado.Fecha)',$anio);
        
        $this->db->order_by('total','desc');

        $this->db->group_by('user_id');
        $query=$this->db->get();
        return $query->result_array();   
    }

    function totales($fecha_desde="",$fecha_hasta="",$vendedores=array()){
        if ($fecha_desde){
            $fecha_desde.=' 00:00:00';  
        }
        if ($fecha_hasta){
            $fecha_hasta.=' 23:59:59';  
        }
        
        $this->db->select('COUNT(certificado.id) total',true);
        $this->db->select('
            certificado.user_id,
            certificado.id_tipo_certificado,
            usuario.Nombre as usuario_nombre,
            producto.validez producto_validez,
            producto.nombre producto_nombre');
        
        $this->db->from('certificado');
        
        $this->db->join('usuario','usuario.id=certificado.user_id');
        $this->db->join('producto','producto.id=certificado.id_tipo_certificado','left');
        
        $this->db->where('certificado.Estado','Emitido');
        
        $this->db->where('certificado.Fecha >=',$fecha_desde);
        $this->db->where('certificado.Fecha <=',$fecha_hasta);
        
        if($vendedores){
            $this->db->where_in('certificado.user_id',$vendedores);    
        }
        
        $this->db->order_by('total','desc');
        
        //$this->db->group_by('id_tipo_certificado,user_id');
        $this->db->group_by('producto.validez,user_id');
        $query=$this->db->get();
        return $query->result_array();
    }
}

//FIN