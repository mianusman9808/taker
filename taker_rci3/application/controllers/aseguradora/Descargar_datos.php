<?php
//
class descargar_datos extends CI_Controller {

	var $fecha_actual = "";

	public function __construct() {
		parent::__construct();

		if ((getPerms() != 'Aseguradora')) {
			salir();
		}

	}


	function index() {
		if (getPerms() != 'Aseguradora') {
			salir();
		}


		$this -> form_validation -> set_rules('fecha_desde', 'Fecha desde', 'required|fecha|callback__validar_fecha');
		$this -> form_validation -> set_rules('fecha_hasta', 'Fecha hasta','fecha');

		if ($this -> form_validation -> run()) {
			//VALIDA
			$this -> _certificados_emision();
		} else {

			$this -> load -> view('descargar_datos/aseguradora');
		}
			
	}



	function _certificados_emision() {
        $yo=$this->usuario_model->get_by_id(getUser_id());
        if (empty($yo['aseguradora_id'])){
            show_error("Falta configurar aseguradora ID");
        }
        
		$certificados = $this -> certificado_model -> getEmisionParaExcel(
		      array(),    //Todos los usuarios
		      $this -> input -> post('fecha_desde'), 
		      $this -> input -> post('fecha_hasta'),
		      null,               //validez
		      'solicitud',         //con estado de la solicitud
		      $yo['aseguradora_id'],   //Id de la aseguradora,
		      false                    //Mostrasr el nombre del vendedor
        );

		if ($certificados) {

			$this -> excelgen -> ExcelOutput($certificados, 'certificados_emision' . $this -> fecha_actual);
		} else {
			$this -> session -> set_flashdata('error', 'No hay certificados emitidos con ese criterio.');
			redirect('aseguradora/Descargar_datos');
		}
	}
    
    function _validar_fecha(){
        $fecha_hasta=$this->input->post('fecha_hasta');
        $fecha_desde=$this->input->post('fecha_desde');
        
        if ($fecha_desde and $fecha_hasta)
        {
            if($fecha_desde > $fecha_hasta){
                $this->form_validation->set_message('_validar_fecha', 'La fecha desde es mayor que la fecha hasta.');
                return FALSE;    
            }
            if($fecha_desde > $fecha_hasta){
                $this->form_validation->set_message('_validar_fecha', 'La fecha desde es mayor que la fecha hasta.');
                return FALSE;    
            }
            $un_dia=$dia=60*60*24;
            $un_mes=$un_dia*31;
            
            if(restar_fechas($fecha_hasta,$fecha_desde)>=$un_mes){
                $this->form_validation->set_message('_validar_fecha', 'Máxima consulta de 31 días');
                return FALSE;       
            }
            return TRUE;
        }
        else
        {
            return TRUE;
        }
    }
}

///FIN
