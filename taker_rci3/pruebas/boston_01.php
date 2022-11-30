<?php
require_once 'WSASoap.php';
//require_once 'vendor/autoload.php';
//namespace Examples;

use WS\WSASoap;

class MyClient extends \SoapClient
{
    public function __doRequest($request, $location, $saction, $version)
    {
        //echo $request;
        //exit;
        $dom = new DOMDocument();
        $dom->loadXML($request);
        //echo $saction;
        //exit;
        $wsa = new WSASoap($dom);
        $wsa->addAction($saction);
        $wsa->addTo($location);
        $wsa->addMessageID();
        $wsa->addReplyTo();

        $request = $wsa->saveXML();

        return parent::__doRequest($request, $location, $saction, $version);
    }

}

//ERRORES
error_reporting(E_ALL);
ini_set('display_errors', true);   

//phpinfo();
//exit;

// <soap:Header xmlns:wsa="http://www.w3.org/2005/08/addressing">
//<wsa:Action>http://tempuri.org/IRCInternacional/Emitir</wsa:Action>
//</soap:Header>

$fecha="2016-10-18";
$fecha_hasta="2016-11-01";

$params = array(
    'emisionIn'=>array(
         'FechaOperacion'           =>$fecha,
         'IdentificadorCanal'       =>'9825',
         'TitularApellido'          =>'Demo',
         'TitularCalleDomicilio'             =>'Demo',
         'TitularFechaNacimiento'            =>'1980-01-01',
         'TitularLocalidadDomicilio'         =>'Pucón',
         'TitularNacionalidad'      =>46,           //Chile
         'TitularNombre'            =>'Demo',
         'TitularNroCalleDomicilio'          =>123,
         'TitularNroDocumento'               =>'22029433',
         'TitularPaisDomicilio'              =>46,               //Chile
         
         'TitularPisoDomicilio'              =>2,                //OPCIONAL
         'TitularTelefono'          =>'4321233',
         'TitularTipoConductor'     =>'T',   //Titular
         'TitularTipoDocumento'     => 94,   //RUT
         'Token'                    =>'V73SgtqtJySbp_htWCOL2lIGKHTLxT3o',
         'VehiculoAnio'             => 2016,
         'VehiculoChasis'           =>'12345678',
         'VehiculoMarca'            =>'FORD',
         'VehiculoModelo'           =>'FOCUS',
         'VehiculoMotor'            =>'87654321',
         'VehiculoPatente'          =>'',       //FZ-DG-45
         'VehiculoTipoCarroceria'   =>1,    //Sedan
         'VehiculoTipoUso'          =>1,    //Particular
         'VehiculoTipoVehiculo'     =>23,   //Automovil Importado
         'VigenciaDesde'        =>$fecha,
         'VigenciaHasta'        =>$fecha_hasta,
         
     )
);   

$url="https://seguros.boston.com.ar/ws/RCInternacional/RCInternacional.svc?wsdl";


$client = new MyClient($url,array('soap_version' => SOAP_1_2));

 
$res = $client->Emitir($params);

echo "<pre>";
print_r($res);
echo "</pre>";
exit;

//header("Content-type:application/pdf");
//header("Content-Disposition:attachment;filename=boston.pdf");
//echo $res->EmitirResult->CertificadoCobertura;

exit;


//Algunos metodos se habilitan con la opcion trace del soapClient
//var_dump($client->__getLastRequest());
//var_dump($client->__getLastResponse());
