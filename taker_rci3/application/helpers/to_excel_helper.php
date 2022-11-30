<?php
function to_excel(
    $datos=array(), 
    $filename='exceloutput',
    $separador=";",
    $comillas='"',
    $linea="\n",
    $UTF8=false
    
    ){

    $data = '';
    foreach ($datos as $row) {
        $line = '';
        foreach($row as $value) {                                            
        if ((!isset($value)) OR ($value == "")) {
                 $value = $separador;
        } else {

                 if (is_numeric($value))
				 {
				 	$value = to_excel_format_number($value) . $separador;
				 }
				 else
				 {
				 	$value = $comillas . to_excel_format_text($value,$UTF8) . $comillas . $separador;
				 }
            }
            $line .= $value;
       }
       $data .= trim($line).$linea;
      }

		  
      header("Content-type: application/x-msdownload");
      header("Content-Disposition: attachment; filename=$filename");
      echo $data;

}
function to_excel_format_number($numero){
    return $numero;
}
function to_excel_format_text($texto,$UTF8=false){
    if(!$UTF8){
        return utf8_decode( $texto); 
    }else{
        return $texto;
    }
    
}

///FIN