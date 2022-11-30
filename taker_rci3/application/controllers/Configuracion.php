<?php
class configuracion extends CI_Controller
{
    function index(){
		if (getPerms()!='Administrador'){
			salir();
        }
        $data=array();

		$this->form_validation->set_rules('dolar_oficial','Dolar','required|numeric');
        $this->form_validation->set_rules('peso_chileno','Peso chileno','required|numeric');

		if ($this->form_validation->run()){

            $dolar_oficial= $this->input->post('dolar_oficial');
            $peso_chileno=  $this->input->post('peso_chileno');

            if($dolar_oficial){
                $this->configuracion_model->setValor('dolar_oficial',$dolar_oficial);
            }
            if($peso_chileno){
                $this->configuracion_model->setValor('peso_chileno',$peso_chileno);
            }
            $this->session->set_flashdata('success', 'Configuración actualizada');
            redirect('configuracion');

        }

        $data['dolar_oficial'] =$this->configuracion_model->getValor('dolar_oficial');
        $data['peso_chileno'] =$this->configuracion_model->getValor('peso_chileno');

        $this->load->view('configuracion/formulario',$data);
    }
	function grilla($grid=''){
		if (getPerms()!='Administrador'){
			salir();
		}
        $this->datagrid->title("Configuración");
        $this->datagrid->descripcion("USAR <b>PUNTO</b> PARA SEPARAR DECIMALES");
        $this->datagrid->from('configuracion');

        $this->datagrid->limit='50';
   
        
        //no agrega. solo modifica o borra
        $this->datagrid->add(false);
        $this->datagrid->delete(false);         

        
        
        $this->datagrid->add_field(array(
            'label'             => 'ID',   
            'field'             => 'id',    
            'primary'           => true,    
            //'grid'              => true,    
            //'add'               => true,    
            //'edit'              => true    
        ));
        
        $this->datagrid->add_field(array(
            'label'             => 'Item',   
            'field'             => 'item',    
            'grid'              => true,    
            'add'               => true,    
            'edit'              => true,
            'form_control'      => 'text',
            'validation'        => 'required',

        ));
        $this->datagrid->add_field(array(
            'label'             => 'Valor',   
            'field'             => 'valor',    
            'grid'              => true,    
            'add'               => true,    
            'edit'              => true,
            'validation'        => 'required',
            'help'              => '<b>VALORES DECIMALES SEPARAR CON PUNTO</b>'

        ));
              
        $data['datagrid']=$this->datagrid->run();
        $this->load->view("datagrid/template", $data);  
    }

}
///FIN