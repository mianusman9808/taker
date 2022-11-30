<?php
//
class descargar_datos extends CI_Controller
{
	var $fecha_actual="";
	
	public function __construct()
	{
		parent::__construct();
        
        if ( (getPerms()!='Administrador'))
        {
            salir();
        }
		
		$this->fecha_actual=date('YmdHis');
	}
	
	function criterios()
	{
		$data['usuarios']=    $this->usuario_model->get(1); //solo trae usuarios "Vendedor" y "Vendedor_organizador"
		
		$data['valideces']=   $this->producto_model->getValideces();
		$data['tipos']=       $this->producto_model->getTipos();
		$data['dolar_oficial']=   $this->configuracion_model->getValor('dolar_oficial');

		
		if ($this->input->post('emision'))
		{
			$this->form_validation->set_rules('usuarios[]',      'Vendedor','required');
            $this->form_validation->set_rules('fecha_desde',    'Fecha desde','required');
            $this->form_validation->set_rules('fecha_hasta',    'Fecha hasta');//no es requerido
			//$this->form_validation->set_rules('tipo',            'Tipo');
			$this->form_validation->set_rules('validez',         'Validez');
            $this->form_validation->set_rules('solicitud',       'Solicitud');
			
			if ($this->form_validation->run())
			{
				//VALIDA
				$this->_certificados_emision();
			}
			else
			{
				$this->load->view('descargar_datos/formularios',$data);
			}
			
		}
		elseif ($this->input->post('facturacion'))
		{
			$this->form_validation->set_rules('usuarios[]','Vendedor','required');
			$this->form_validation->set_rules('fecha_desde','Fecha desde','required');
			$this->form_validation->set_rules('fecha_hasta','Fecha hasta');//no es requerido
			//$this->form_validation->set_rules('tipo','Tipo');
			$this->form_validation->set_rules('validez','Validez');

			
			if ($this->form_validation->run())
			{
				//VALIDA
				

				$this->_certificados_facturacion();
			}
			else
			{
				$this->load->view('descargar_datos/formularios',$data);
			}
		}
		elseif ($this->input->post('facturacion_puntos_venta'))
		{
			$this->form_validation->set_rules('fecha_desde','Fecha desde','required');
			$this->form_validation->set_rules('fecha_hasta','Fecha hasta');//no es requerido

			
			if ($this->form_validation->run())
			{
				//VALIDA
				$this->_certificados_facturacion_puntos_venta();
			}
			else
			{
				$this->load->view('descargar_datos/formularios',$data);
			}
		}
		else
		{
			$this->load->view('descargar_datos/formularios',$data);
		}
		
	}
	
	function usuarios()
	{
		$usuarios=$this->usuario_model->getTodosParaExcel();
		
		$this->excelgen->ExcelOutput($usuarios,'usuarios'.$this->fecha_actual);
	}
	

	
	function cuenta()
	{
		$cuentas=$this->cuenta_model->getTodosParaExcel();
		
		$this->excelgen->ExcelOutput($cuentas,'cuentas'.$this->fecha_actual);
	}
	
	function _certificados_emision()
	{
	    //print_r ($this->input->post('usuarios'));
        //exit;
		$certificados=$this->certificado_model->getEmisionParaExcel(
		  $this->input->post('usuarios'),
		  $this->input->post('fecha_desde'),
		  $this->input->post('fecha_hasta'),
		  //$this->input->post('tipo'),
		  $this->input->post('validez'),
		  $this->input->post('solicitud'),
		  $this->input->post('aseguradora_id')
        );

        
		
		if ($certificados)
		{
			

            $this->excelgen->ExcelOutput($certificados,'certificados_emision'.$this->fecha_actual);
		}
		else
		{
			$this->session->set_flashdata('error','No hay certificados emitidos con ese criterio.');
			redirect('descargar_datos/criterios');
		}
	}
	
	function _certificados_facturacion()
	{
	    $data['dolar_oficial']=$this->configuracion_model->getValor('dolar_oficial');
		$data['certificados']=$this->certificado_model->getFacturacionParaExcel(
		  $this->input->post('usuarios'),
		  $this->input->post('fecha_desde'),
		  $this->input->post('fecha_hasta'),
		  //$this->input->post('tipo'),
		  $this->input->post('validez'),
		  $data['dolar_oficial']
         );
	    $data['importar_a_sistema']=$this->input->post("importar_a_sistema");
        

		
		//print_r($data['certificados']);
		
		//exit;

		
		if ($data['certificados'])
		{
		    //$this->output->set_header("Content-type: application/octet-stream; charset=ISO-8859-1");
            //$this->output->set_header("Content-Disposition: attachment; filename=\"RCI_Facturacion_Asegurado.txt\"");
		    $this->load->view("descargar_datos/facturacion",$data);
			//$this->excelgen->ExcelOutput($certificados,'certificados_facturacion'.$this->fecha_actual);
		}
		else
		{
			$this->session->set_flashdata('error','No hay certificados emitidos con ese criterio.');
			redirect('descargar_datos/criterios');
		}
	}
	
	function _certificados_facturacion_puntos_venta()
	{
	    $data['dolar_oficial']=$this->configuracion_model->getValor('dolar_oficial');
		$data['certificados']=$this->certificado_model->getFacturacionPuntosVentaParaExcel($this->input->post('fecha_desde'),$this->input->post('fecha_hasta'),$data['dolar_oficial']);
		$data['importar_a_sistema']=$this->input->post("importar_a_sistema");		
		$data['fecha_desde']=$this->input->post('fecha_desde');
        $data['fecha_hasta']=$this->input->post('fecha_hasta');
        
		//print_r($data['certificados']);
        //exit;
		
		
		if ($data['certificados'])
		{
		    $this->load->view("descargar_datos/puntos_de_venta",$data);
			//$this->excelgen->ExcelOutput($certificados,'certificados_facturacion_puntos_venta'.$this->fecha_actual);
		}
		else
		{
			$this->session->set_flashdata('error','No hay certificados emitidos con ese criterio.');
			redirect('descargar_datos/criterios');
		}
	}
    function pagos(){
    	$data['usuarios']=    $this->usuario_model->get(1); //solo trae usuarios "Vendedor" y "Vendedor_organizador"

		$this->form_validation->set_rules('usuarios[]',      'Vendedor','required');
        $this->form_validation->set_rules('fecha_desde',    'Fecha desde','required');
        $this->form_validation->set_rules('fecha_hasta',    'Fecha hasta');//no es requerido
		$this->form_validation->set_rules('pagos_pendientes',    'pagos_pendientes');//no es requerido
			
			if ($this->form_validation->run())
			{
				//VALIDA
				$this->_exportar_pagos();
			}
			else
			{
				$this->load->view('descargar_datos/pagos',$data);
			}
		

    }

function _exportar_pagos()
	{

		$certificados=$this->pagos_model->getExportarPagosParaExcel(
		  $this->input->post('usuarios'),
		  $this->input->post('fecha_desde'),
		  $this->input->post('fecha_hasta'),
		  $this->input->post('pagos_pendientes')
        );

		if ($certificados)
		{
			

            $this->excelgen->ExcelOutput($certificados,'exportar_pagos'.$this->fecha_actual);
		}
		else
		{
			$this->session->set_flashdata('error','No hay certificados emitidos con ese criterio.');
			redirect('descargar_datos/pagos');
		}
	}
}
///FIN
