<?php
class enviar_correo extends MY_Controller
{
	function index()
	{
	    if(!havePerm('Administrador')){
            salir();
        }
		$data['usuarios']=$this->usuario_model->getConCorreo();
		
		$this->form_validation->set_rules('usuarios[]','Usuarios','required');
		$this->form_validation->set_rules('asunto','Asunto','required');
		$this->form_validation->set_rules('mensaje','Mensaje','required');
		
		if ($this->form_validation->run())
		{			
			//recorre los id de los usuarios y busca sus correos
			foreach ($this->input->post('usuarios') as $usuarios_llave => $usuarios_valor)
			{
				$correo=$this->usuario_model->getCorreoById($usuarios_valor);
				
				//si el usuario tiene correo y si el correo es válido lo agregamos a los destinatarios
				if ( $correo and $this->form_validation->valid_email($correo) )
				{
					$destinatarios[]=$correo;
				}
			}
			
			/*
			echo "<pre>";
			print_r($destinatarios);
			echo "</pre>";
			exit;
			*/
			
			$this->correo->enviar($this->input->post('asunto'),$this->input->post('mensaje'),$destinatarios);
			
			$this->load->view('enviar_correo/mensaje_enviado');
			
			//SI MOSTRARAMOS UN ERROR...
			//$this->load->view('enviar_correo/error');
		}
		else
		{
			$this->load->view('enviar_correo/formulario',$data);
		}
		
	}
}
