<?php 
$numero="A310-120869";


/*
CETIFICADOS PARA ANULAR: 
A310-120869
A310-120870

*/

date_default_timezone_set('America/Buenos_Aires');
setlocale(LC_ALL,"es_AR.UTF8");
setlocale(LC_NUMERIC ,"en_US.UTF-8");

//ERRORES
error_reporting(E_ALL);
ini_set('display_errors', true);   

$fechahora=date("Y-m-d H:i:s", time());
$desde=$fechahora;
$hasta=date("Y-m-d H:i:s", time()+60*60*24*5); //5 dias

//TESTING
//$wsdl="https://gestionpas.mercantilandina.com.ar/ws_nuevoSeguroChileTST/NuevoSeguroChileServices/NuevoSeguroChileServices.wsdl";
//$canal='18';
//$token="canal18TRAC";

//PRODUCCION
$wsdl="https://gestionpas.mercantilandina.com.ar/ws_nuevoSeguroChilePRD/NuevoSeguroChileServices/wsdl";
$canal='18';
$token="7hGfT7UbFLd2";

$params=array(
    'propuestaRequest' => array(
        'auth'=>array(
            'canal'         =>$canal,
            'token'         =>$token,
        ),
        'certificado'    =>$numero,
        
        'diasvig'       =>'5',
        'conductor'     =>'PROPIETARIO',
        'titular'       =>'DEMO',
        'rut'           =>'',   //76180567-3
        'domicilio'     =>'DEMO',
        'localidad'     =>'COPIAPO',
        'pais'          =>'Chile',
        'telefono'      =>'123456789',
        'desde'         =>$desde,
        'hasta'         =>$hasta,
        'tipoveh'       =>'AUTOMOVIL',
        'marca'         =>'MC',         
        'modelo'        =>'NY',
        'anio'          =>'2013',
        // 3
        //'dominio'       =>'FKRP-33',
        'dominio'       =>'',    //ZA-1118
        'motor'         =>'',   //Z6A89189
        'chasis'        =>'',   //JM7BL12Z6D1367802
        'trailer'       =>'N',
        'trlTitular'    =>'',
        'trlrut'        =>'',
        'trlmarca'      =>'',
        'trlmodelo'     =>'',
        'trlanio'       =>'',
        'trldominio'    =>'',
        'trlchasis'     =>'',
        'prima'         =>'35.00',
        'premio'        =>'61.00',
        'fechahora'     =>$fechahora,
     )   
);




//////////////////////////////////////////////////////////
//USANDO NUSOAP
require_once('../application/nusoap/nusoap.php');

$client=new nusoap_client($wsdl, 'wsdl','','','','');
$client->response_timeout=60;

$err = $client->getError();
if ($err) {
            echo 'Constructor error ' . $err ;
}


$result = $client->call('nuevoSeguro', $params,'', '', false, true);

echo "<h1>Respuesta</h1>";
// Check for a fault
if ($client->fault) {
            echo 'FAULT';
            print_r($result);
} else {
        // Check for errors
        $err = $client->getError();
        if ($err) {
                    // Display the error
                    echo 'CLIENT ERROR ' . $err ;
        } else {
                    // Display the result
                    
                    echo 'RESULT ';
                    print_r($result);

        }
}

//echo 'Request ' . $client->request;
//echo 'Response ' . $client->response;
echo '<h1>Debug</h1> <pre>' . $client->debug_str, ENT_QUOTES."</pre>";
//print_r($client);
exit;

/////////////////////////////////////////////////////////////////////////////////////////////////
//USANDO SOAPCLIENT
/*
$client = new SoapClient($wsdl,['trace' => true]);
$res = $client->nuevoSeguro($params);


//echo "<pre>";
//print_r($res);
//echo "</pre>";
echo "REQUEST:\n" . $client->__getLastRequest() . "\n";
echo "RESPONSE:\n" . $client->__getLastResponse() . "\n";

exit;
*/

?>
