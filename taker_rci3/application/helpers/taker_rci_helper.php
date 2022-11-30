<?php
 //dmolina
 function anio_fabricacion_select($name="",$value="")
 {
 	$anio_actual=date("Y");
 	$anio_maximo=$anio_actual+VEHICULO_ANIO_MAXIMO;
 	$anio_minimo=$anio_maximo-VEHICULO_ANIO_MINIMO;
 	
 	$html="";
 	$html.='<select name="'.$name.'" class="form-control">'."\n";
 	for($anio=$anio_maximo; $anio>=$anio_minimo; $anio--)
	{
 		$selected=false;
 		if($anio==$value)
 		{
 			$selected=true; //si está modificando viene el valor que estaba guardado
 		}
		elseif($anio==date('Y'))
		{
			$selected=true; //si no viene nada seteado por defecto ni por el post: muestra el año actual
		}
		
 		$html.='<option value="'.$anio.'" '.set_select($name,$anio,$selected).'>'.$anio.'</option>'."\n";
	}
 	$html.="</select>";
 	return $html;
 }
 
function usuario_tiene_credito_para_producto_o_valor($producto_id='',$valor='')
{	
	$CI =& get_instance();
	
	//SE FIJA SI TIENE CRÉDITO
	$credito=$CI->cuenta_model->getCreditoByUsuarioId(getUser_id()); //$credito['total']
	
	//SI VIENE UN PRODUCTO ID SE FIJA EL COSTO. SINO VIENE DIRECTAMENTE EL VALOR
	if ($producto_id)
	{
		$producto=$CI->producto_model->getById($producto_id);
		$valor=$producto['costo'];
	}
	
	if ( ($credito['total']-$valor) < 0 )
	{
		//NO TIENE CRÉDITO
		return false;
	}
	else
	{
		//TIENE CRÉDITO
		return true;
	}
}

function genera_numero_certificado($patente='',$certificado_id='')
{
	//SE MODIFICA PORQUE SE AGREGAN NUMEROS DE PATENTE QUE LA POSICION 4 PUEDE QUEDAR EN -
	//$numero1=substr($patente,-4,1); //OBTIENE EL 4 digito de atras hacia adelante
	$numero1=substr($patente,-6,1); //OBTIENE EL 6 digito de atras hacia adelante
	$numero2=substr($patente,-2,1); //OBTIENE EL 2 digito de atras hacia adelante
	
	$numero3=date("m"); //OBTIENE EL NUMERO DE MES
	$numero4=$certificado_id;
	
	$numero=$numero1.$numero2.$numero3."-".$numero4;
	return $numero;
}

function hace_movimientos($usuario_id="",$numero_certificado='',$producto_id="")
{
	$CI =& get_instance();
	
	$producto=$CI->producto_model->getById($producto_id);
	//Datos del usuario que vende
	$vendedor=$CI->usuario_model->getById($usuario_id);
	//debita el costo del producto
	$CI->cuenta_model->movimiento($usuario_id,(-$producto['costo']),$numero_certificado,'Certificado agregado','Venta');
	
	//se fija si otros vendedores comisionan de este
	$comisiones=$CI->comision_model->getByUsuarioId($usuario_id);
	
	if ($comisiones)
	{
		//otro/s vendedor/es comisiona/n
		
		$total_comisionado=0;
		foreach($comisiones as $comision)
		{
			//COMISIONISTAS
			
			$comisiona_vendedor_comisionista=$comision['porcentaje_comisionista']*$producto['comision']/100;
			//echo $comisiona_vendedor_comisionista;
			
			//DMOLINA SI LOS RESULTADOS DE LAS OPERACIONES NUMÉRICAS VIENEN CON COMA (POR LA CONFIGURACION REGIONAL) LOS PASAMOS A PUNTOS
			//ESTO PASA EN EL SERVIDOR DE TAKER
			$comisiona_vendedor_comisionista = str_replace(",", ".", $comisiona_vendedor_comisionista);
			//----------------------------------------------------------------------------------------------------------------------------
	
			$CI->cuenta_model->movimiento($comision['user_id_comisionista'],$comisiona_vendedor_comisionista,$numero_certificado,'Comision Certificado (comisiona de '.$vendedor['Nombre'].')','Comision');
			
			$total_comisionado+=$comisiona_vendedor_comisionista;
		}
		
		//LO QUE LE QUEDA AL VENDEDOR QUE VENDIÓ
		$comisiona_vendedor=$producto['comision']-$total_comisionado;
		//echo '<br />'.$comisiona_vendedor;
		
		if ($comisiona_vendedor>'0.00')
		{
			//comisiona el vendedor
			$CI->cuenta_model->movimiento($usuario_id,$comisiona_vendedor,$numero_certificado,'Comision Certificado','Comision');
		}
		//
	}
	else
	{
		//este vendedor se lleva toda la comisión
		$CI->cuenta_model->movimiento($usuario_id,$producto['comision'],$numero_certificado,'Comision Certificado','Comision');
	}
}

function deshace_movimientos($certificado_id="")
{
	$CI =& get_instance();
	
	$certificado=$CI->certificado_model->getById($certificado_id);
	$producto=$CI->producto_model->getById($certificado['id_tipo_certificado']);
	//Datos del usuario que vende
    $vendedor=$CI->usuario_model->getById($certificado['user_id']);
	//devuelve el costo del producto
	$CI->cuenta_model->movimiento($certificado['user_id'],$producto['costo'],$certificado['Numero'],'Venta Certificado ANULADO','Venta anulada');
	
	//se fija si alguien más había comisionado
    $comisiones=$CI->comision_model->getByUsuarioId($certificado['user_id']);
    if ($comisiones)
    {
		//otro/s vendedores habían comisionado
		
		$total_comisionado=0;
		foreach($comisiones as $comision)
		{
			//COMISIONISTAS
			
			$comisiona_vendedor_comisionista=$comision['porcentaje_comisionista']*$producto['comision']/100;
			//echo $comisiona_vendedor_comisionista;
			
			//DMOLINA SI LOS RESULTADOS DE LAS OPERACIONES NUMÉRICAS VIENEN CON COMA (POR LA CONFIGURACION REGIONAL) LOS PASAMOS A PUNTOS
			//ESTO PASA EN EL SERVIDOR DE TAKER
			$comisiona_vendedor_comisionista = str_replace(",", ".", $comisiona_vendedor_comisionista);
			//----------------------------------------------------------------------------------------------------------------------------
	
			//saca comisión del comisionista
            $CI->cuenta_model->movimiento($comision['user_id_comisionista'],(-$comisiona_vendedor_comisionista),$certificado['Numero'],'Comision Certificado (comisiona de '.$vendedor['Nombre'].') ANULADO','Comision anulada');
			
			$total_comisionado+=$comisiona_vendedor_comisionista;
		}
		
		//LO QUE LE QUEDARÍA AL VENDEDOR QUE HABÍA VENDIDO
		$comisiona_vendedor=$producto['comision']-$total_comisionado;
		//echo '<br />'.$comisiona_vendedor;
		
		if ($comisiona_vendedor>'0.00')
		{
			//saca comisión del vendedor
			$CI->cuenta_model->movimiento($certificado['user_id'],(-$comisiona_vendedor),$certificado['Numero'],'Comision Certificado ANULADO','Comision anulada');
		}
		//
	}
	else
	{
		//este vendedor se llevaba toda la comisión
		//saca la comisión del vendedor
		$CI->cuenta_model->movimiento($certificado['user_id'],(-$producto['comision']),$certificado['Numero'],'Comision Certificado ANULADO','Comision anulada');
	}
}
