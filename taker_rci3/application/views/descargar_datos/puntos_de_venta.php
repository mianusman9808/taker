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
header("Content-Disposition: attachment; filename=\"RCI_Facturacion_Puntos_Venta.".$extension."\"");




//print_r($certificados);
//exit;
echo
     $comillas."PUNTO DE VENTA ID".$comillas
     .$separador
     .$comillas."PUNTO DE VENTA NOMBRE".$comillas
     .$separador
    //.$comillas."Cantidad_Certifiados".$comillas
    //.$separador
    .$comillas."IMPORTE".$comillas
    .$separador
    .$comillas."DETALLE".$comillas
    .$separador
    .$comillas."PRODUCTO MINUS ID".$comillas
    .$linea;

foreach ($certificados as $arreglo){
    

    
    echo
        "3".$arreglo['user_id']
        .$separador
        .$comillas.texto_planilla($arreglo['Nombre']).$comillas
        .$separador
        //.$arreglo['Cantidad_Certificados']
        //.$separador
        .$arreglo['Importe']
        .$separador
        .$comillas."Periodo: ".texto_planilla(fecha_humana($fecha_desde))." hasta ".texto_planilla(fecha_humana($fecha_hasta)).$comillas
        .$separador
        ."2"        
        .$linea;
}

//////////FIN