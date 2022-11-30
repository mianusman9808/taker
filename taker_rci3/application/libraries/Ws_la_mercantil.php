<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

set_time_limit (300);      //5 minutos (60*5)

class ws_la_mercantil
 {
    //Contructor
    function __construct(){
        require_once(APPPATH.'nusoap/nusoap.php');
        
        $this->CI =& get_instance();
        log_message('debug', 'WS Mercantil class initialized.');
    }
     
     function nuevo_seguro($certificado=array(),$producto=array()){
         
            if (!$certificado){
                return;
            }
            if (!$producto){
                return;
            }
            //Por default enviar como cadena vacia los valores vacios NULL
            foreach ($certificado as $item=>$valor){
                if (empty($valor)){
                    $certificado[$item]='';
                }
            }
            

            $wsdl=WSDL_MERCANTIL;
            
            $client=@new nusoap_client($wsdl, 'wsdl','','','','',0,300);
            //configura para que envie el xml en utf8
            $client->soap_defencoding = 'UTF-8';
            $client->decode_utf8 = false;
            
            $err = $client->getError();   
            if ($err) {
                        echo 'Constructor error ' . $err ;
            }else{
                //ACOMODA LAS VARIABLES
                if($producto['trailer']){
                    $trailer="S";
                }else{
                    $trailer="N";
                }
                //Agrega el digito a la patente
                if($certificado['digito']){
                    $dominio=$certificado['Patente']." (".$certificado['digito'].")";
                }else{
                    $dominio=$certificado['Patente'];
                }

                if($certificado['trailer_digito']){
                    $trldominio=$certificado['trailer_patente']." (".$certificado['trailer_digito'].")";
                }else{
                    $trldominio=$certificado['trailer_patente'];
                }
                
                //Recodifica los tipos que son distintos...
                
                if($producto['tipo']=="Station Wagon"){
                    $tipo="STATION-WAGON";
                }elseif($producto['tipo']=="Van - Combi"){
                    $tipo="VAN-COMBI";
                }elseif($producto['tipo']=="Casa Rodante o Motor-Home"){
                   $tipo="MOTOR-HOME"; 
                }elseif($producto['tipo']=="Pickup o Camioneta"){
                    $tipo="PICKUP";   
                }else{
                    $tipo=strtoupper($producto['tipo']);
                }

                $param=array(
                    'propuestaRequest' => array(
                        'auth'=>array(
                            'canal'         =>WSDL_MERCANTIL_CANAL,
                            'token'         =>WSDL_MERCANTIL_TOKEN,
                        ),
                        'certificado'   =>$certificado['Numero'],
                        'diasvig'       =>$producto['validez'], //3,5,10,30
                        'conductor'     =>strtoupper($certificado['conductor']),
                        'titular'       =>$certificado['Nombre'],
                        'rut'           =>$certificado['Rut'],
                        'domicilio'     =>$certificado['Domicilio'],
                        'localidad'     =>$certificado['Localidad'],
                        'pais'          =>$certificado['Pais'],
                        'telefono'      =>$certificado['Telefono'],
                        'desde'         =>$certificado['FechaDesde'],
                        'hasta'         =>$certificado['FechaHasta'],
                        'tipoveh'       =>$tipo, 
                        'marca'         =>$certificado['Marca'],
                        'modelo'        =>$certificado['Modelo'],
                        'anio'          =>$certificado['Anio'],         //puede tener mas de 30 años...
                        'dominio'       =>$dominio,
                        'motor'         =>$certificado['Motor'],
                        'chasis'        =>$certificado['Chasis'],
                        'trailer'       =>$trailer,
                        
                        'trlTitular'    =>$certificado['trailer_propietario'],
                        'trlrut'        =>$certificado['trailer_rut'],
                        'trlmarca'      =>$certificado['trailer_marca'],
                        'trlmodelo'     =>$certificado['trailer_modelo'],
                        'trlanio'       =>$certificado['trailer_anio'],
                        'trldominio'    =>$trldominio,
                        'trlchasis'     =>$certificado['trailer_chasis'],
                        
                        
                        'prima'         =>$this->CI->configuracion_model->getValor('WSDL_MERCANTIL_PRIMA'),
                        'premio'        =>$this->CI->configuracion_model->getValor('WSDL_MERCANTIL_PREMIO'),
                        'fechahora'     =>$certificado['Fecha'],
                    )  
                );
                 //tiempo de espera al ws
                $client->response_timeout=60;            
                $result = $client->call('nuevoSeguro', $param,'', '', false, true);
                

                if ($client->fault) {

                            $this->CI->certificado_model->actualizar_solicitud_error($certificado['id'],'FAULT');
                } else {
                            // Check for errors
                            $err = $client->getError();
                            if ($err) {
                                    $this->CI->certificado_model->actualizar_solicitud_error($certificado['id'],'CLIENT_ERROR: '.addslashes($err));
                            } else {

                                        if(!empty($result['Respuesta']['error'])){
                                            $this->CI->certificado_model->actualizar_solicitud_error($certificado['id'],$result['Respuesta']['error']);
                                        }

                                        if(!empty($result['Respuesta']['solicitud'])){
                                            $this->CI->certificado_model->actualizar_solicitud($certificado['id'],$result['Respuesta']['solicitud']);
                                        }
                            }
                }                
            }

                        
                
     }
 }