<?php

if(empty($importar_a_sistema)){
    $importar_a_sistema=0;
}

if($importar_a_sistema){
    $separador="|";
    $comillas='';
    $linea="\n";
    $extension="txt";   
}else{
    $separador=";";
    $comillas='"';
    $linea="\n";
    $extension="csv";     
}


header("Content-type: application/octet-stream; charset=ISO-8859-1");
header("Content-Disposition: attachment; filename=\"RCI_Facturacion_Asegurado.".$extension."\"");

echo
     $comillas."CERTIFICADO ID".$comillas
    .$separador
    .$comillas."ASEGURADO NOMBRE".$comillas
     .$separador
    //.$comillas."Domicilio".$comillas
    //.$separador
    //.$comillas."Localidad".$comillas
    //.$separador
    .$comillas."IMPORTE".$comillas
    .$separador
    .$comillas."DETALLE".$comillas
    .$separador
    .$comillas."PRODUCTO MINUS ID".$comillas
    .$linea;

foreach ($certificados as $arreglo){

    echo
        "2".$arreglo['id']
        .$separador
        .$comillas.texto_planilla($arreglo['Nombre']).$comillas
        .$separador
        //.$comillas.utf8_decode($arreglo['Domicilio']).$comillas
        //.$separador
        //.$comillas.utf8_decode($arreglo['Localidad']).$comillas
        //.$separador
        .$arreglo['Importe']
        .$separador
        .$comillas."Punto de venta: ".texto_planilla($arreglo['usuario_nombre']).", Producto: ".texto_planilla($arreglo['producto_nombre']).", Fecha:".fecha_hora_humana($arreglo['Fecha']).", Solicitud: ".$arreglo['solicitud'].$comillas
        .$separador
        ."2"        
        .$linea;
}

//////////FIN