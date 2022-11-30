<?php
class pagos_model extends CI_Model{

    function adeudados(){
        $this->db->select("SUM(importe) importe, pagos.cancelado, pagos.user_id");
        $this->db->select('CONCAT(trim(usuario.Apellido)," ",trim(usuario.Nombre)) as vendedor' );
        
        $this->db->from('pagos');
        $this->db->where('cancelado',0);   
        $this->db->group_by('user_id');
        $this->db->join('usuario','pagos.user_id=usuario.id');
        $this->db->order_by('importe');
        $query=$this->db->get();
        return $query->result_array();       
    }
    function get_total_deuda($usuario_nombre=""){
            //no se usa
            $this->db->select("SUM(importe) importe");
            
            $this->db->from('pagos');

            $this->db->where('cancelado',0);   

            if($usuario_nombre){
                $this->db->join('usuario','pagos.user_id=usuario.id');
                $this->db->like('usuario.nombre',$usuario_nombre);
            }
            $query=$this->db->get();
            $x=$query->row_array();
            return $x['importe'];          
    }
    function get_by_id($pago_id='')
    {
        $this->db->select('*');
        $this->db->from('pagos');
        $this->db->where('id',$pago_id);
        
        $query=$this->db->get();
        return $query->row_array();
    }
    
    function get_deuda_by_user_id($user_id=""){
        if(getPerms()=="Vendedor_organizador"){
            //Si es organizador, revisa el pago de sus vendedores de su Grupo
            $organizador=$this->usuario_model->get_by_id(getUser_id());
            
            
            $this->db->select('pagos.*');
            $this->db->from('pagos');
            $this->db->join('usuario','pagos.user_id=usuario.id');
            
            $this->db->order_by('pagos.fecha_hora','desc');
            $this->db->where('pagos.cancelado',0);
            $this->db->where('usuario.Grupo',$organizador['Grupo']);
            
            $query=$this->db->get();
            return $query->result_array();   
            
        }else{
            $this->db->select('*');
            $this->db->from('pagos');
            $this->db->order_by('fecha_hora','desc');
            $this->db->where('cancelado',0);
            $this->db->where('user_id',$user_id);
            
            $query=$this->db->get();
            return $query->result_array();            
        }

    }
    
    function get_by_user_id($user_id="",$limite=10){
        $this->db->select('*');
        $this->db->from('pagos');
        $this->db->order_by('cancelado asc, fecha_hora desc');
    
        $this->db->where('user_id',$user_id);
        
        if(getPerms()=='Vendedor' or getPerms()=='Vendedor_organizador'){
            $this->db->where('(fecha_hora >="2018-09-15" or cancelado=0)'); //pedido x sebastian
        }
        
        
        $this->db->limit($limite);
        $query=$this->db->get();
        return $query->result_array();
    }
    
    function agregar($data=array()){
        $this->db->insert('pagos', $data); 
    }
    
    function getExportarPagosParaExcel(
       $usuarios=array(),
       $fecha_desde='',
       $fecha_hasta='',
       $pagos_pendientes=''
       )
       {
           
             
        //si no trae fecha_hasta, (que es optativa) define fecha_hasta=fecha_desde para que traiga un dia
        if ($fecha_desde and !$fecha_hasta){
            $fecha_hasta=$fecha_desde;
        }

        //FORMATO A LAS FECHAS CON HORAS:MINUTOS:SEGUNDOS
        if ($fecha_desde)
        {
            $fecha_desde.=' 00:00:00';  //principio del dia
        }
        if ($fecha_hasta)
        {
            $fecha_hasta.=' 23:59:59';  //final del dia
        }
        $this->db->select('     
        CONCAT(trim(usuario.Apellido)," ",trim(usuario.Nombre)) as Nombre_vendedor, 
        pago.id,
        pago.user_id as id_vendedor ,
        pago.importe , 
        pago.peso_chileno, 
        pago.total,
        pago.fecha_hora_desde, 
        pago.fecha_hora_hasta,
        pago.detalle,
        pago.cancelado, 
        pago.fecha_hora'
        );
                 

        $this->db->from('pagos as pago');
            
        $this->db->join('usuario','usuario.id=pago.user_id');
        
        
        if ($fecha_desde and $fecha_hasta){

            
            $this->db->where('pago.fecha_hora_desde >=',$fecha_desde);
            $this->db->where('pago.fecha_hora_desde <=',$fecha_hasta);
            
        }
		
		//Optativo trae solo pendientes de pagos o todos
		 if ($pagos_pendientes){
 			
		 	$this->db->where('pago.cancelado',0);
 			
		 }
		 
        //Optativo o trae todos los usarios
        if ($usuarios)
        {
            $this->db->where_in('pago.user_id',$usuarios);
        }
		

        
    
        $this->db->order_by('pago.fecha_hora_desde');
        
        $query=$this->db->get();

        $resultado=$query->result_array();
        
        //print_r($resultado);
        //exit;
        return $resultado;
    }
    
    
}