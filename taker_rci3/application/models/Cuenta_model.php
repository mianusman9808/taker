<?php
class cuenta_model extends CI_Model
{
    //Obtiene el estado de cuenta de los usuarios en un periodo de tiempo
    //No tiene en cuenta los creditos del admin, solo las ventas
    //La facturacion puede ser mensual o semanal
    function get_ventas($fecha_desde="",$fecha_hasta="",$facturacion="Mensual"){
            
        $this->db->select("cuenta.user_id");
        //$this->db->select("usuario.id usuario_id");
        $this->db->select("usuario.nombre usuario_nombre");
        $this->db->select('SUM(cuenta.importe) as total');
        $this->db->from('cuenta');

        if ($fecha_desde)
        {
            $this->db->where('fecha_hora >=',$fecha_desde);
        }
        if ($fecha_hasta)
        {
            $this->db->where('fecha_hora <=',$fecha_hasta);
        }
        //SOLO VENTAS !!
        //NO tiene en cuenta los creditos y debitos 
        //del admin
        $this->db->where('tipo !=','Credito Admin');
        $this->db->where('tipo !=','Debito Admin');
        //SOLO VENTAS !!
        //NO tiene en cuenta los movimientos de Creditos y debitos que 
        //el organizador hace con sus vendedores
        $this->db->where('tipo !=','Credito');
        $this->db->where('tipo !=','Debito');
        
        $this->db->where('usuario.facturacion',$facturacion);
        $this->db->join('usuario','usuario.id=cuenta.user_id','INNER');
        //$this->db->order_by('fecha_hora','desc');
        $this->db->group_by('cuenta.user_id');
        $this->db->order_by("total");
        $query=$this->db->get();
        return $query->result_array();
     
    }
    function get_ventas_by_user_id(
            $usuario_id="",
            $fecha_desde="",
            $fecha_hasta=""){
            
        $this->db->select("cuenta.*");

        $this->db->from('cuenta');

        if ($fecha_desde)
        {
            $this->db->where('fecha_hora >=',$fecha_desde);
        }
        if ($fecha_hasta)
        {
            $this->db->where('fecha_hora <=',$fecha_hasta);
        }
        
        $this->db->where('cuenta.user_id',$usuario_id);
        //SOLO VENTAS !!
        //NO tiene en cuenta los creditos y debitos 
        //del admin
        $this->db->where('tipo !=','Credito Admin');
        $this->db->where('tipo !=','Debito Admin');
        //SOLO VENTAS !!
        //NO tiene en cuenta los movimientos de Creditos y debitos que 
        //el organizador hace con sus vendedores
        $this->db->where('tipo !=','Credito');
        $this->db->where('tipo !=','Debito');

        $this->db->order_by("cuenta.id",'desc');
        $this->db->limit(1000); //Por las dudas...
        $query=$this->db->get();
        return $query->result_array();
     
    }
    function get_total_ventas_by_user_id(
            $usuario_id="",
            $fecha_desde="",
            $fecha_hasta=""){
            
        $this->db->select("cuenta.user_id");
        $this->db->select('SUM(cuenta.importe) as total');
        $this->db->from('cuenta');

        if ($fecha_desde)
        {
            $this->db->where('fecha_hora >=',$fecha_desde);
        }
        if ($fecha_hasta)
        {
            $this->db->where('fecha_hora <=',$fecha_hasta);
        }
        
        //SOLO VENTAS !!
        //NO tiene en cuenta los creditos y debitos 
        //del admin
        
        $this->db->where('tipo !=','Credito Admin');
        $this->db->where('tipo !=','Debito Admin');
        //SOLO VENTAS !!
        //NO tiene en cuenta los movimientos de Creditos y debitos que 
        //el organizador hace con sus vendedores
        $this->db->where('tipo !=','Credito');
        $this->db->where('tipo !=','Debito');
        
        $this->db->where('cuenta.user_id',$usuario_id);
        $this->db->group_by('cuenta.user_id');

        $query=$this->db->get();
        return $query->row_array();
     
    }
    
        
    //////////////////
    //RETORNA LOS SALDO DE CUENTA DE TODOS LOS VENDEDORES
    function get_saldo(){
        $this->db->select("usuario.id,usuario.nombre,usuario.username,SUM(cuenta.importe) as importe_total");
        $this->db->from('cuenta');
        $this->db->join('usuario','usuario.id=cuenta.user_id','INNER');
        $this->db->where('(usuario.perms="Vendedor" or usuario.perms="Vendedor_organizador")');
        $this->db->group_by("cuenta.user_id");
        $this->db->order_by("importe_total",'desc');
        $query=$this->db->get();
        //echo $this->db->last_query();
        //exit;
        return $query->result_array();

    }
    function get_debito_credito(){
        $this->db->select("usuario.id,usuario.nombre,usuario.username,SUM(cuenta.importe) as importe_total, SUM(cuenta.debito_admin) debito_admin_total");
        $this->db->from('cuenta');
        $this->db->join('usuario','usuario.id=cuenta.user_id','INNER');
        $this->db->where('(usuario.perms="Vendedor" or usuario.perms="Vendedor_organizador")');
        $this->db->where('(cuenta.tipo="Credito Admin" or cuenta.tipo="Debito Admin")');
        $this->db->group_by("cuenta.user_id");
        $this->db->order_by("importe_total",'desc');
        $query=$this->db->get();

        return $query->result_array();

    }    
	function getCreditoByUsuarioId($usuario_id='')
	{
		$this->db->select('SUM(importe) as total');
		$this->db->from('cuenta');
		
		$this->db->where('user_id',$usuario_id);
		
		$query=$this->db->get();
		return $query->row_array();
	}
	
	
	function getTodosParaExcel()
	{
		//$this->db->select('CONCAT (usuario.Nombre," ",usuario.Apellido) as nombre_apellido_vendedor,cuenta.*',false);
		$this->db->select('usuario.Nombre as nombre_apellido_vendedor, cuenta.*',false);
		$this->db->from('cuenta');
        $this->db->join('usuario','usuario.id=cuenta.user_id','left');
        
		$this->db->limit('1000');
		$this->db->order_by('fecha_hora','desc');
		
		$query=$this->db->get();
		return $query->result_array();
	}
	
	//MOVIMIENTO: puede ser débito o comisión
	
	//Posibles conceptos:
	//Comision Certificado
	//Comision Certificado Anulado
	//Venta Certificado
	//Venta Certificado Anulado
	function movimiento($usuario_id='',$valor='',$nombre_identificador='',$concepto='',$tipo='')
	{
		$concepto=$concepto.' '.$nombre_identificador;
		$fecha_hora=date('Y-m-d H:i:s'); //fecha actual
		
		//PAGUIAR: a veces viene valor con coma, por las dudas lo reemplazo por .
		$valor=str_replace(',','.',$valor);
		
		$this->db->insert('cuenta',array('user_id'=>$usuario_id,'importe'=>$valor,'concepto'=>$concepto,'fecha_hora'=>$fecha_hora,'tipo'=>$tipo));
	}
	
	function asignar_fecha_hora($id="",$fecha_hora="")
	{
		$this->db->where('id',$id);
		$this->db->update('cuenta',array('fecha_hora'=>$fecha_hora));
	}


	function getImporteTotalByCriterios($fecha_desde="",$fecha_hasta="",$usuario_id="",$solo_comisiones="",$organizador_grupo="")
	{
        $this->db->select('SUM(importe) as total');
        $this->db->from('cuenta');
        
        if ($fecha_desde)
        {
            $this->db->where('fecha_hora >=',$fecha_desde);
        }
        if ($fecha_hasta)
        {
            $this->db->where('fecha_hora <=',$fecha_hasta);
        }
        if ($usuario_id)
        {
            $this->db->where('user_id',$usuario_id);
        }
        if ($solo_comisiones)
        {
            $this->db->like('concepto','comision');
        }
        if ($organizador_grupo)
        {
            $this->db->join('usuario','usuario.id=cuenta.user_id','left');
            $this->db->where('usuario.Grupo',$organizador_grupo);
            
        }
        $this->db->order_by('fecha_hora','desc');
        $this->db->limit('10');
        
        $query=$this->db->get();
        $cuenta=$query->row_array();
                
        return $cuenta['total'];
	}
}

//FIN