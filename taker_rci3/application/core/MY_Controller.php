<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');



class MY_Controller extends CI_Controller {
        

        
	function __construct()
    {	
        parent::__construct();   
   	}
    
   
    //////////////////////////////////////////////////////////////
    //VALIDACIONES
    public function _usuario_propietario($usuario_id='',$certificado_id='')
    {
        if (getPerms()=='Administrador')
        {
            return true;
        }
        else
        {
            return $this->certificado_model->usuario_propietario_de_certificado($usuario_id,$certificado_id);
        }
    }
    
    public function _rut_limpiar($rut)
    {
        //BORRAMOS LOS PUNTOS
        $rut_limpio=str_replace('.','',$rut);
        
        //PASAMOS A MAYÚSCULAS
        $rut_limpio=strtoupper($rut_limpio);
        
        return $rut_limpio;
    }
    
    
    public function _validar_rut()
    {
        //saco los puntos
        $rut=$this->_rut_limpiar($this->input->post('Rut'));
        
        //Valida el Rut si el tipo de documento es RUT
        if ($this->input->post('documento_tipo')=="Rut"){
            //SE FIJA SI VIENE EL GUIÓN
            if ($rut[strlen($rut)-2]=='-')
            {
                //SE FIJA QUE EL LARGO DEL RUT SEA CORRECTO
                if ( strlen($rut)>=9 and strlen($rut)<=10 )
                {
                    $rut_partes=explode('-',$rut);
                    
                    //SE FIJA QUE LA PRIMERA PARTE SEA NUMÉRICA Y LA SEGUNDA ALFANUMÉRICA
                    if ( $this->form_validation->numeric($rut_partes[0]) and $this->form_validation->alpha_numeric($rut_partes[1]) )
                    {
                        //OK
                        return TRUE;
                    }
                }
            }else{
                $this->form_validation->set_message('_validar_rut', 'El RUT es incorrecto.');
                return FALSE;    
            }
        }else{
            //ES PASAPORTE...LO DEJA PASAR
            return true;
        }

    }
 

    function _fecha_desde_correcta()
    {

        
        if ($this->input->post('FechaDesde') < date('Y-m-d'))
        {
             
            //NUNCA PUEDE SER ANTERIOR AL MOMENTO PRESENTE. SI HOY. SI FUTURO. NUNCA PASADO.
            $this->form_validation->set_message('_fecha_desde_correcta', 'La fecha de inicio de cobertura es incorrecta.');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    function _validar_patente($Patente)
    {
        if (substr($Patente,-5,1) == "-" and strlen($Patente) == 7){        //controla ormato xx-xxxx
            //ok
            return true;
        }elseif(substr($Patente,-3,1) == "-" and strlen($Patente) == 7){    //controla formato xxxx-xx
            //ok
            return true;
        }elseif(substr($Patente,-4,1) == "-" and strlen($Patente) == 7){    //controla formato xxx-xxx
            //ok
            return true;
        }elseif(substr($Patente,-4,1) == "-" and strlen($Patente) == 8){    //controla formato xxxx-xxx
            //ok
            return true;
        }elseif($this->form_validation->is_natural($Patente) and strlen($Patente) == 9 ){               //controla formato 123456789
            //ok, si es de 9 digitos
             return true;
        }else{
            //Entonces no es válida
            return false;
        }   
    }

    function _validar_patente_auto()
    {
        if ($this->_validar_patente($this->input->post('Patente')))
        {
            return true;
        }
        else
        {
            $this->form_validation->set_message('_validar_patente_auto', 'Número de patente inválido.');
            return false;   
        }
    }
    
    function _validar_patente_trailer()
    {
        if ($this->_validar_patente($this->input->post('Patente')))
        {
            return true;
        }
        else
        {
            $this->form_validation->set_message('_validar_patente_trailer', 'Número de patente del trailer inválido.');
            return false;
        }
    }  
}
////FIN