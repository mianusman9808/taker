<?php
function rut_formatear($rut)
{
	//SE FIJA SI VIENE EL GUIÓN
	if ($rut[strlen($rut)-2]=='-')
	{
		$rut_partes=explode('-',$rut);
	
		$rut_numero=$rut_partes[0];
		$rut_extension=strtoupper($rut_partes[1]);
		
		//SEPARAMOS LOS MILES CON UN PUNTO
		if (is_numeric($rut_numero))
		{
			$rut_numero=number_format($rut_numero,0,'','.');
		}
		
		$rut_formato=$rut_numero.'-'.$rut_extension;
	
		return $rut_formato;
	}
	else
	{
		//CASOS VIEJOS EN QUE SE GRABÓ DE ALGUNA OTRA FORMA LO MOSTRAMOS COMO FUE GRABADO
		return $rut;
	}
	
}