<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

    function __construct()
    {

        parent::__construct();

        $this->CI = & get_instance();

    }
    /*
     * ALPHANUMERICO CON GUIONES, para validar chasis y motor
    */
    function alphanumerico_guiones($str){
        $this->set_message('alphanumerico_guiones', '%s solo se permiten numeros, letras y guiones');
        return ( ! preg_match("/^([a-z0-9-])+$/i", $str)) ? FALSE : TRUE;
    }
    
    //FECHA HORA MYSQL VALIDA
    public function fecha_hora( $date="" ){
        $this->set_message('fecha_hora', '%s fecha y hora no válida');
         
        if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $date, $matches)) { 
    
            if (checkdate($matches[2], $matches[3], $matches[1])) { 
                return true; 
            } 
        } 
        return false; 
    } 
    
    //FECHA MYSQL VALIDA
    public function fecha( $date="" ){
        $this->set_message('fecha', '%s fecha no válida'); 
        if (preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $date, $matches)) { 
    
            if (checkdate($matches[2], $matches[3], $matches[1])) { 
                return true; 
            } 
        } 
        return false; 
    } 
}

/* End of file MY_Form_validation.php */
/* Location: ./system/application/libraries/MY_Form_validation.php */
