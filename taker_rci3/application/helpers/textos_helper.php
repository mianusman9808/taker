<?php 
function limpiar_html($string=""){
    $string = strip_tags($string);//quita el formato html
    return $string;
}
function escapear($string=""){
    $string=limpiar_html($string);
    $string=addslashes($string);
    $string= str_replace('"', '', $string);
    $string= str_replace('“', '', $string);
    $string= str_replace('”', '', $string);
    $string= str_replace('&nbsp;', '', $string);
    $string= str_replace('\r\n', '', $string);
    return $string;
}
function texto_planilla($texto=""){
    //quita  | que se usa para el sistema de facturacion...
    $texto= str_replace('|', '', $texto);
    $texto=escapear($texto);
    //return $texto;
    return utf8_decode($texto);
}
//LIMPIA LOS ESPACIOS DE UN VALOR ENVIADO POR URL
function limpiar_espacio_url($string=""){
    $string= str_replace('%20', ' ', $string);
    return $string;   
}
//FIN