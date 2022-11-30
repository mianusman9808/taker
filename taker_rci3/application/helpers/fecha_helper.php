<?php
//Convierte fecha y hora en fecha
function solo_fecha($fecha_hora=""){
    $fecha_unix=strtotime($fecha_hora);
    $fecha=date("Y-m-d", $fecha_unix);
    return $fecha;   
}

//Retorna la diferencia de fechas en seguntos
function restar_fechas($fecha_1,$fecha_2){
    $fecha_1=strtotime($fecha_1);
    $fecha_2=strtotime($fecha_2);
    return $fecha_1-$fecha_2;
}
//Retorna la cantidad de dias de los segundos
function segundos_a_dias($segundos=0){
    $dia=60*60*24;
    return intval($segundos/$dia);
}
function sumar_dias_a_fecha($fecha="",$dias=""){
    //pasa los dias a segundos
    $tiempo=$dias*24*60*60;
    $fecha_unix=strtotime($fecha)+$tiempo;
    $fecha=date("Y-m-d", $fecha_unix);
    return $fecha;
}
function fecha_humana($fecha='',$margen="")
{
	if(!$fecha){
		$fecha=time()+$margen;
	}else{
		$fecha=strtotime($fecha);
	}
	$fecha_hora=strtoupper(strftime("%d de %B %Y", $fecha));	
	return $fecha_hora;
}

function fecha_hora_humana($fecha='',$margen="")
{
	if(!$fecha){
		$fecha=time()+$margen;
	}else{
		$fecha=strtotime($fecha);
	}
	$fecha_hora=strtoupper(strftime("%d de %B %Y ( %H : %M : %S )", $fecha));	
	return $fecha_hora;
}

function fecha($margen=0)
{
	//margen es un incremento en segudos
	$fecha=date("Y-m-d", time()+$margen);
	return $fecha;
}


function fecha_hora($margen=0)
{
	//margen establece un incremento de tiempo en segundos
	$fecha_hora=date("Y-m-d H:i:s", time()+$margen);
	return $fecha_hora;
}

function meses_select()
{
	$meses=array(
				'01'=>'Enero',
				'02'=>'Febrero',
				'03'=>'Marzo',
				'04'=>'Abril',
				'05'=>'Mayo',
				'06'=>'Junio',
				'07'=>'Julio',
				'08'=>'Agosto',
				'09'=>'Septiembre',
				'10'=>'Octubre',
				'11'=>'Noviembre',
				'12'=>'Diciembre'
	);
	
	echo '<select id="mes" name="mes">\n';
	foreach ($meses as $mes_llave => $mes_valor)
	{
		echo '<option value="'.$mes_llave.'">'.$mes_valor."</option>\n";
	}
	echo "</select>\n";
}

