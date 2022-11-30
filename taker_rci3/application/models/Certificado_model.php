<?php
class certificado_model extends CI_Model
{
    function actualizar_solicitud_error($id="",$error="")
    {
        $this->db->where('id',$id);
        $this->db->update('certificado',array('solicitud_error'=>$error));
    }   
    
    
    function actualizar_solicitud($id="",$solicitud="")
    {
        $this->db->where('id',$id);
        //graba el mensaje y limpia el error
        $this->db->update('certificado',array('solicitud'=>$solicitud,'solicitud_error'=>''));
    }   
    
	function get($cantidad='500')
	{
		$this->db->select('*');
		$this->db->from('certificado');
		
		$this->db->limit($cantidad);
		
		$query=$this->db->get();
		return $query->result_array();
	}
	

	function getTodosParaExcel()
	{
		//$this->db->select('CONCAT (usuario.Nombre," ",usuario.Apellido) as nombre_apellido_vendedor, producto.nombre as producto_nombre,producto.validez as producto_validez,certificado.*',false);
		$this->db->select('usuario.Nombre as nombre_apellido_vendedor, producto.nombre as producto_nombre,producto.validez as producto_validez,certificado.*',false);
		
		$this->db->from('certificado');
		
		$this->db->join('usuario','usuario.id=certificado.user_id','left');
		$this->db->join('producto','producto.id=certificado.id_tipo_certificado','left');
		
		$this->db->where('certificado.Estado','Emitido');
		
		$this->db->order_by('Fecha','desc');
        $this->db->limit('1000');
		
        $query=$this->db->get();
        return $query->result_array();
	}
	//funcion para marsh
		function getTodosParaExcelMarsh()
	{
		//$this->db->select('CONCAT (usuario.Nombre," ",usuario.Apellido) as nombre_apellido_vendedor, producto.nombre as producto_nombre,producto.validez as producto_validez,certificado.*',false);
		$this->db->select('usuario.Nombre as nombre_apellido_vendedor, producto.nombre as producto_nombre,producto.validez as producto_validez,certificado.*',false);
		
		$this->db->from('certificado');
		
		$this->db->join('usuario','usuario.id=certificado.user_id');
		$this->db->join('producto','producto.id=certificado.id_tipo_certificado');
		
		$this->db->where('certificado.Estado','Emitido');
		$this->db->where('certificado.aseguradora_id',2);
		
		
		$this->db->order_by('Fecha','desc');
        $this->db->limit('1000');
		
        $query=$this->db->get();
        return $query->result_array();
	}
	
	//fin de funcion para marsh
	
	
	
	

	function get_by_id($certificado_id=''){
	    return $this->getById($certificado_id);
	}
	function getById($certificado_id='')
	{
		$this->db->select('*');
		$this->db->from('certificado');
		
		$this->db->where('id',$certificado_id);
		
		$query=$this->db->get();
		return $query->row_array();
	}
	
	function modificar($certificado_id='',$data=array())
	{
		$this->db->where('id',$certificado_id);
		$this->db->update('certificado',$data);
	}
	
	function agregar($data=array())
	{
		$this->db->insert('certificado',$data);
	}
	
	function anular($data=array())
	{
		//
	}
	
	function cambiar_estado($id="",$estado="")
	{
		$this->db->where('id',$id);
		$this->db->update('certificado',array('estado'=>$estado));
	}
	
	function getEmisionParaExcel(
	   $usuarios=array(),
	   $fecha_desde='',
	   $fecha_hasta='',
	   //$tipo='',
	   $validez='',
	   $solicitud="solicitud",
       $aseguradora_id=1,           //1: La Mercantil, 2: Boston
       $mostrar_vendededor=true     //Cuado las aseguradoras descargan datos, no ven el vendedor
       ){
           
        if($aseguradora_id!=1){
        //    show_error('Aseguradora pendiente');
        }
           
		//si no trae fecha_hasta, (que es optativa) define fecha_hasta=fecha_desde para que traiga un dia
		if ($fecha_desde and !$fecha_hasta){
		   	$fecha_hasta=$fecha_desde;
		}

		//FORMATO A LAS FECHAS CON HORAS:MINUTOS:SEGUNDOS
		if ($fecha_desde)
		{
			$fecha_desde.=' 00:00:00';	//principio del dia
		}
		if ($fecha_hasta)
		{
			$fecha_hasta.=' 23:59:59';	//final del dia
		}
        
        if($mostrar_vendededor){
            $this->db->select('usuario.nombre as vendedor_nombre');
        }  else{
            $this->db->select('usuario.Localidad as punto_venta');
        } 
        
		$this->db->select('
		      certificado.Numero,
		      producto.nombre as producto_nombre,
		      producto.validez as producto_validez,
		      certificado.Nombre,
		      certificado.Rut,
		      certificado.Domicilio,
		      certificado.Localidad,
		      certificado.Pais,
		      certificado.FechaDesde,
		      certificado.FechaHasta');
              
        if ($aseguradora_id==1){
            //La mercantil      
            $this->db->select('producto.tipo');
        }
        if ($aseguradora_id==2){
            //Boston     
            $this->db->select('boston_tipo_vehiculo.nombre tipo');
            
        }
        $this->db->select('certificado.Motor,
		      certificado.Marca,
		      certificado.Chasis,
		      certificado.Modelo,
		      certificado.Uso,
		      certificado.Anio,
		      certificado.Patente,
		      certificado.digito');
        
        //Trailer solo para la mercantil    
		if ($aseguradora_id==1){
             $this->db->select('
              certificado.trailer_eje,
              certificado.trailer_marca,
              certificado.trailer_modelo,
              certificado.trailer_anio,
              certificado.trailer_patente,
              certificado.trailer_digito,
              certificado.trailer_chasis,
              certificado.trailer_uso,
              certificado.trailer_propietario,
              certificado.trailer_rut');
		    
		}
        $this->db->select('
              certificado.conductor,
              certificado.Estado,
              certificado.solicitud,
              certificado.solicitud_error');

		$this->db->from('certificado');
		
		$this->db->join('producto','producto.id=certificado.id_tipo_certificado');
		
		$this->db->join('usuario','usuario.id=certificado.user_id');
        
        if ($aseguradora_id==2){
            //Boston     
            $this->db->join('boston_tipo_vehiculo','boston_tipo_vehiculo.id=producto.boston_tipo_id');
            
        }		

		
		if ($fecha_desde and $fecha_hasta){
			//$this->db->where('certificado.Fecha >=',$fecha_desde);
		   	//$this->db->where('certificado.Fecha <=',$fecha_hasta);
            
            //LA EMISION TIENE QUE TOMAR LA FECHA DE INICIO COBERTURA
            //Y NO LA FECHA DE VENTA DEL CERTIFICADO
            
            $this->db->where('certificado.FechaDesde >=',$fecha_desde);
            $this->db->where('certificado.FechaDesde <=',$fecha_hasta);
            
		}
		//Optativo o trae todos los usarios
		if ($usuarios)
		{
			$this->db->where_in('certificado.user_id',$usuarios);
		}
		
		//if ($tipo)
		//{
		//	$this->db->where('producto.tipo',$tipo);
		//}
		
		if ($validez)
		{
			$this->db->where('producto.validez',$validez);
		}

		if($solicitud=="solicitud"){
		    $this->db->where('certificado.solicitud !=','');  
		}
        if($solicitud=="sin_solicitud"){
            $this->db->where('certificado.solicitud','');  
        }
        if($solicitud=="anulada"){
            $this->db->where('certificado.solicitud !=','');
            $this->db->where('certificado.Estado','Anulado');  
        }
        if($solicitud=="con_error"){
            $this->db->where('certificado.solicitud_error !=','');  
        }
        if($solicitud!="anulada"){
            $this->db->where('certificado.Estado','Emitido');
        }
		$this->db->where('certificado.aseguradora_id',$aseguradora_id);
		$this->db->order_by('FechaDesde');
		
		$query=$this->db->get();

        $resultado=$query->result_array();
        
        //print_r($resultado);
        //exit;
        return $resultado;
	}


	function getFacturacionParaExcel(
	   $usuarios=array(),
	   $fecha_desde='',
	   $fecha_hasta='',
	   //$tipo='',
	   $validez='',
	   $cambio=''){
		//si no trae fecha_hasta, (que es optativa) define fecha_hasta=fecha_desde para que traiga un dia
		if ($fecha_desde and !$fecha_hasta){
		   	$fecha_hasta=$fecha_desde;
		}

		//FORMATO A LAS FECHAS CON HORAS:MINUTOS:SEGUNDOS
		if ($fecha_desde)
		{
			$fecha_desde.=' 00:00:00';	//principio del dia
		}
		if ($fecha_hasta)
		{
			$fecha_hasta.=' 23:59:59';	//final del dia
		}
		
		
		$this->db->select('
		  certificado.id,
		  certificado.user_id,
		  certificado.Nombre, 
		  certificado.Domicilio, 
		  certificado.Localidad, 
		  certificado.Fecha,
		  certificado.solicitud
		  ');

		$this->db->select('usuario.Nombre usuario_nombre');
        $this->db->select('producto.nombre producto_nombre');
		if ($cambio)
		{
			//ROUND(numero, cantidad_decimales)
			$this->db->select('ROUND((producto.Costo * '.$cambio.'),2) Importe',FALSE);
		}
		else
		{
			$this->db->select('ROUND((producto.Costo),2) Importe',FALSE);
		}
		
		$this->db->from('certificado');
		$this->db->join('producto',     'producto.id=certificado.id_tipo_certificado');
        $this->db->join('usuario',      'usuario.id=certificado.user_id');
        
		
		$this->db->where('certificado.Estado','Emitido');
		
		if ($fecha_desde and $fecha_hasta){
            //$this->db->where('certificado.Fecha >=',$fecha_desde);
            //$this->db->where('certificado.Fecha <=',$fecha_hasta);
            
            //LA EMISION TIENE QUE TOMAR LA FECHA DE INICIO COBERTURA
            //Y NO LA FECHA DE VENTA DEL CERTIFICADO
            
            $this->db->where('certificado.FechaDesde >=',$fecha_desde);
            $this->db->where('certificado.FechaDesde <=',$fecha_hasta);
		}

		if ($usuarios)
		{
			$this->db->where_in('user_id',$usuarios);
		}
		
		//if ($tipo)
		//{
		//	$this->db->where('producto.tipo',$tipo);
		//}
		
		if ($validez)
		{
			$this->db->where('producto.validez',$validez);
		}
		
		//$this->db->order_by('Fecha','desc');
		$this->db->order_by('FechaDesde','asc'); 
		
        $query=$this->db->get();
        return $query->result_array();
	}

	function getFacturacionPuntosVentaParaExcel($fecha_desde='',$fecha_hasta='',$cambio=''){

		//si no trae fecha_hasta, (que es optativa) define fecha_hasta=fecha_desde para que traiga un dia
		if ($fecha_desde and !$fecha_hasta)
		{
		   	$fecha_hasta=$fecha_desde;
		}

		//FORMATO A LAS FECHAS CON HORAS:MINUTOS:SEGUNDOS
		if ($fecha_desde)
		{
			$fecha_desde.=' 00:00:00';	//principio del dia
		}
		if ($fecha_hasta)
		{
			$fecha_hasta.=' 23:59:59';	//final del dia
		}
		
		
		//ROUND(numero, cantidad_decimales)
		

		$this->db->select('certificado.user_id,
		usuario.Nombre, 
		count(certificado.id) Cantidad_Certificados, 
		ROUND(SUM(producto.costo * '.$cambio.'),2) Importe',FALSE);
		
		$this->db->from('certificado');
        $this->db->group_by('certificado.user_id');
        
		$this->db->join('usuario','usuario.id=certificado.user_id');
		$this->db->join('producto','producto.id=certificado.id_tipo_certificado');
		
		$this->db->where('certificado.Estado','Emitido');

		
		if ($fecha_desde and $fecha_hasta){
            $this->db->where('certificado.FechaDesde >=',$fecha_desde);
            $this->db->where('certificado.FechaDesde <=',$fecha_hasta);
		}
		
		$this->db->order_by('usuario.Nombre','asc'); 
		
        $query=$this->db->get();
        $resultado= $query->result_array();
        
        //Ordena el resultado por user_id
        
        $resultado_1=array();
        
        foreach($resultado as $item){
            $resultado_1[$item['user_id']]=$item;
        }
        return $resultado_1;
	}


	function usuario_propietario_de_certificado($usuario_id='',$certificado_id=''){
		$this->db->select('id');
		$this->db->from('certificado');
		$this->db->where('id',$certificado_id);
		$this->db->where('user_id',$usuario_id);
		
		if ($this->db->count_all_results())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	
	
	function beneficiario_propietario_de_certificado($codigo_correo='',$codigo='',$certificado_id='')
	{
		$this->db->select('id');
		$this->db->from('certificado');
		$this->db->where('id',$certificado_id);
		$this->db->where('codigo_correo',$codigo_correo);
		$this->db->where('codigo',$codigo);
		
		if ($this->db->count_all_results())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function getByRut($rut='')
	{
		//$this->db->select('Nombre, Domicilio, Localidad, Pais, Telefono, conductor, Marca, Modelo, Anio,Patente, digito, Motor, Chasis');
		//Solo datos de la perona
		$this->db->select('Nombre, Domicilio, Localidad, Pais, Telefono');

		$this->db->from('certificado');
		
		$this->db->where('Rut',$rut);
		
		$this->db->where('Estado','Emitido');
		
		$this->db->order_by('id','desc');
		
		$query=$this->db->get();
		return $query->row_array();
	}
	
	function getByPatente($patente='',$patente_digito='')
	{
		//$this->db->select('Nombre, Domicilio, Localidad, Pais, Telefono,conductor, Marca, Modelo, Anio,Patente, digito, Motor, Chasis');

		//Solo datos del vehiculo
		$this->db->select('Marca, Modelo, Anio,Patente, digito, Motor, Chasis');

		$this->db->from('certificado');
		
		$this->db->where('Patente',$patente);
		if ($patente_digito)
		{
			$this->db->where('digito',$patente_digito);
		}
		
		$this->db->where('Estado','Emitido');
		
		$this->db->order_by('id','desc');
		
		$query=$this->db->get();
		return $query->row_array();
	}

	function getByTrailerPatente($trailer_patente='',$trailer_digito='')
	{
		$this->db->select('trailer_propietario, trailer_rut, trailer_eje, trailer_marca, trailer_modelo, trailer_anio, trailer_digito, trailer_chasis');
		$this->db->from('certificado');
		
		$this->db->where('trailer_patente',$trailer_patente);
		if ($trailer_digito)
		{
			$this->db->where('trailer_digito',$trailer_digito);
		}
		
		$this->db->where('Estado','Emitido');
		
		$this->db->order_by('id','desc');
		
		$query=$this->db->get();
		return $query->row_array();
	}
	
	
	
	
}

//FIN
