<?php 
class acceso extends MY_Controller
{
	function index()
	{
		//
		if (getPerms()=='Administrador' or getPerms()=='Aseguradora')
		{
			redirect('certificado/grilla');
		}elseif(getPerms()=='Vendedor' or getPerms()=='Vendedor_organizador' ){
		    //ANULADO BOSTON
		    //redirect('inicio');
		    redirect('certificado');
		}

		//validacion CAPTCHA ANULADO por pedido sebastian
        //$this->form_validation->set_rules('correo', 'Usuario', 'required|max_length[50]|callback__captcha_check|callback__check_username');
        $this->form_validation->set_rules('correo', 'Usuario', 'required|max_length[50]|callback__check_username');
		$this->form_validation->set_rules('password', 'Contraseña', 'required');

		if ($this->form_validation->run() == false)
		{
			//NO INGRESA
			$this->load->view('acceso/index');
		}
		else
		{
            if (getPerms()=='Administrador' or getPerms()=='Aseguradora')
            {
                redirect('certificado/grilla');
            }elseif(getPerms()=='Vendedor' or getPerms()=='Vendedor_organizador' ){
                //ANULADO BOSTON
                //redirect('inicio');
                redirect('certificado');
            }
        }
        
    }
	
	function _check_username($correo)
	{
		$password = $this->input->post('password');
		
		if(!$correo)
		{
			$this->form_validation->set_message('_check_username', 'Información Incorrecta' );
			return false;
		}
		
        if ($this->autenticar->try_login(array('username'=>$correo,'password'=>$password)))
		{
            //se fija el captcha antes de iniciar la session
            return true;
        }
		else
		{
            $this->form_validation->set_message('_check_username', 'Información Incorrecta');

            return false;
        }
    }
	

    
    function logout($rol='')
	{
        $this->autenticar->logout();
		
		if ($rol=='beneficiario')
		{
			redirect('acceso/beneficiario');
		}
		else
		{
			redirect('acceso/index');
		}
    }
    

    
}
///FIN