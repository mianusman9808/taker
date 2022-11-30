<?php
class correo{
    function __construct(){
        $this->CI =& get_instance();
    }
    

    function enviar($subject='',$message='',$to=array()){
        if($_SERVER['SERVER_NAME']=="localhost")
        {
            //DEBUG
            //echo $message;
            return;
        }
		
        $this->CI->load->helper('correo');
        $this->CI->email->initialize(correo_configuracion());
            
        $this->CI->email->from(FROM_CORREO,FROM_NAME);
        
		
		if ($to)
		{
			$this->CI->email->to(array(MAIL_ADMIN));
			$this->CI->email->bcc($to); //VAN OCULTOS (CONTEMPLANDO LA SITUACIÓN DEL ENVÍO DE CORREOS MASIVOS)
		}
		else
		{

			$this->CI->email->to(array(MAIL_ADMIN));
		}
		
       	$this->CI->email->subject($subject);
       	$this->CI->email->message($message);
		
       	if (! $this->CI->email->send() )
       	{
        	// Generate error
          	$this->CI->email->print_debugger();
       	}
    }

    
    function certificado_la_mercantil($certificado_id){

		$data['certificado']=$this->CI->certificado_model->getById($certificado_id);
		$data['producto']=$this->CI->producto_model->getById($data['certificado']['id_tipo_certificado']);

		$data['desdeHoras']=strftime("%H : %M", strtotime ($data['certificado']['FechaDesde']));
		$data['hastaHoras']=strftime("%H : %M", strtotime ($data['certificado']['FechaHasta']));
		$data['desdeDias']=strftime("%d / %m / %Y", strtotime ($data['certificado']['FechaDesde']));
		$data['FechaHasta']=strftime("%d / %m / %Y", strtotime ($data['certificado']['FechaHasta']));

		
		$subject='TAKER RCI: La Mercantil nuevo certificado '.$data['certificado']['Numero'];
		$message=$this->CI->load->view('correo/la_mercantil/certificado_emitido',$data,true);

        //$to=array(JMYA_CORREO_1,MERCANTIL_CORREO_1,MERCANTIL_CORREO_2);
        $to=array(MERCANTIL_CORREO_1);
		
		$this->enviar($subject,$message,$to);
        
        // Enví el correo de Solicitar aprobacion para vehiculos viejos (mas vejos que 25 años)
        if ($data['certificado']['Anio'] <= date("Y")-VEHICULO_ANIO_MINIMO_APROBADO){
            
           //Obtiene los datos del punto de venta para enviar el correo.
           
           $data['usuario']=$this->CI->usuario_model->getById(getUser_id());

           if ($this->CI->form_validation->valid_email($data['usuario']['Email'])){
                $subject='TAKER RCI: La Mercantil autorizar certificado '.$data['certificado']['Numero'];
                $message=$this->CI->load->view('correo/la_mercantil/autorizacion_solicitar',$data,true);
               
               //envia el correo de autorizacion
               $to=array(
                    MERCANTIL_CORREO_AUTORIZACION,
                    $data['usuario']['Email']
               );
               $this->enviar($subject,$message,$to);
               
               //envia el correo de respuesta, al mismo grupo de personas
               
               $subject='TAKER RCI:  La Mercantil certificado autorizado '.$data['certificado']['Numero'];
               $message=$this->CI->load->view('correo/la_mercantil/autorizacion_solicitar',$data,true);
               $this->enviar($subject,$message,$to);
           }
        }
        
    }
	
    function certificado_boston($certificado_id){

        
        $data['certificado']=$this->CI->certificado_model->getById($certificado_id);
        $data['producto']=$this->CI->producto_model->getById($data['certificado']['id_tipo_certificado']);

        $data['desdeHoras']=strftime("%H : %M", strtotime ($data['certificado']['FechaDesde']));
        $data['hastaHoras']=strftime("%H : %M", strtotime ($data['certificado']['FechaHasta']));
        $data['desdeDias']=strftime("%d / %m / %Y", strtotime ($data['certificado']['FechaDesde']));
        $data['FechaHasta']=strftime("%d / %m / %Y", strtotime ($data['certificado']['FechaHasta']));

        
        $subject='TAKER RCI: Boston nuevo certificado '.$data['certificado']['Numero'];
        $message=$this->CI->load->view('correo/boston/certificado_emitido',$data,true);

        $to=array();

        $this->enviar($subject,$message,$to);

        
    }	

    
}


///FIN
