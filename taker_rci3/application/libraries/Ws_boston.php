<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

set_time_limit (300);      //5 minutos (60*5)


class ws_boston
 {
    //Contructor
    function __construct(){
                
        $this->CI =& get_instance();
        log_message('debug', 'WS Boston class initialized.');
    }
     
     function nuevo_seguro($certificado=array(),$producto=array()){

        //TRADUCCIONES
        //CONDUCTOR
        //A- Apoderado, T – Titular, P- Propietario, O - Autorizado
        switch ($certificado['conductor']) {
           case 'Apoderado':
                $conductor="A";
                break;
           case 'Titular':
                $conductor="T";
                break;
          case 'Propietario':
                $conductor="P";
                break;
          case 'Autorizado':
                $conductor="O";
                break;
           default:
                $conductor="P";
                break;
        }
        //TIPO DE DOCUMENTO
        //94 - RUT, 96 - DNI, 70 - Documentos Extranjeros
        switch ($certificado['documento_tipo']) {
           case 'Rut':
                $documento_tipo="94";
                break;
           case 'DNI':
                $documento_tipo="96";
                break;
          case 'Documento Extranjero':
                $documento_tipo="70";
                break;

           default:
                $documento_tipo="94";
                break;
        }

        
        $params = array(
            'emisionIn'=>array(
                 'FechaOperacion'           =>fecha(),
                 'IdentificadorCanal'       =>'9625',
                 'TitularApellido'          =>$certificado['Apellido'],
                 'TitularCalleDomicilio'             =>$certificado['Domicilio'],
                 'TitularFechaNacimiento'            =>$certificado['Fecha_Nacimiento'],
                 'TitularLocalidadDomicilio'         =>$certificado['Localidad'],
                 'TitularNacionalidad'               =>$certificado['Pais'], //ID          
                 'TitularNombre'                     =>$certificado['Nombre'],
                 'TitularNroCalleDomicilio'          =>0 ,
                 'TitularNroDocumento'               =>$certificado['Rut'],
                 'TitularPaisDomicilio'              =>$certificado['Pais'], //ID       
               
                 'TitularPisoDomicilio'              =>0,                //OPCIONAL
                 
                 'TitularTelefono'          =>$certificado['Telefono'],
                 'TitularTipoConductor'     =>$conductor,   //LETRA
                 'TitularTipoDocumento'     => $documento_tipo, //ID  
                 'Token'                    =>'V73SgtqtJySbp_htWCOL2lIGKHTLxT3o',
                 'VehiculoAnio'             => $certificado['Anio'],
                 'VehiculoChasis'           =>$certificado['Chasis'],
                 'VehiculoMarca'            =>$certificado['Marca'],
                 'VehiculoModelo'           =>$certificado['Modelo'],
                 'VehiculoMotor'            =>$certificado['Motor'],
                 'VehiculoPatente'          =>$certificado['Patente'], //No envia el digito verificador
                 'VehiculoTipoCarroceria'   =>$certificado['boston_carroceria_id'], //ID 
                 'VehiculoTipoUso'          =>$certificado['Uso'],                  //ID   
                 'VehiculoTipoVehiculo'     =>$producto['boston_tipo_id'],          //ID
                 'VigenciaDesde'            =>solo_fecha($certificado['FechaDesde']),
                 'VigenciaHasta'            =>solo_fecha($certificado['FechaHasta']),
                 
             )
        );   
        
        $url="https://seguros.boston.com.ar/ws/RCInternacional/RCInternacional.svc?wsdl";
        
        
        $client = new MyClient($url,array('soap_version' => SOAP_1_2));
        
         
        $res = $client->Emitir($params);
        /*
        echo "<pre>";
        print_r($params);
        print_r($res);
        echo "</pre>";
        exit;
        */

        $x=array();
        
        if(!empty($res->EmitirResult->CertificadoCobertura)){
            $x['solicitud']=$res->EmitirResult->NroCertificado;
            $x['error']=false;
            $x['pdf']=$res->EmitirResult->CertificadoCobertura;   
        }elseif($res->EmitirResult->Errores){
            $x['solicitud']="";
            $x['error']=$res->EmitirResult->Errores->string;
            $x['pdf']="";               
        }
        return $x;
        
                 
     }
 }

 