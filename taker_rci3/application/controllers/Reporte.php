<?php
class reporte extends CI_Controller
{
    
    
    function totales(){
        $data=array();
        if(getPerms()=='Administrador'){
            //Ve todos los vendedores
            $vendedores=array();
        }elseif(getPerms()=='Vendedor_organizador'){
            //Los propios y los de sus vendedores
            $organizador=$this->usuario_model->get_by_id(getUser_id());
            
            $x1=$this->usuario_model->get_vendedores_by_grupo($organizador['Grupo']);
            //Agrega su id
            $vendedores=array(getUser_id());
            //Agrega el id de los vendedores
            foreach ($x1 as $x2){
                $vendedores[]=$x2['id'];
            }
        }elseif(getPerms()=='Vendedor'){
            //Solo sus certificados
            $vendedores=array(getUser_id());
        }else{
           salir(); 
        }
        
       
        $this->form_validation->set_rules('fecha_desde', 'Fecha Desde', 'trim|fecha|required');
        $this->form_validation->set_rules('fecha_hasta', 'Fecha hasta', 'trim|required|fecha|callback__validar_fecha');
        
        if ($this->form_validation->run())
        {
            $fecha_desde=$this->input->post('fecha_desde');
            $fecha_hasta=$this->input->post('fecha_hasta');    
        }else{
            //Si no se indican fechas, trae los ingresos de ayer
            //$fecha_desde=sumar_dias_a_fecha(fecha(),-1);
            //$fecha_hasta=sumar_dias_a_fecha(fecha(),-1);
            $fecha_desde=fecha();
            $fecha_hasta=fecha();            
        }
        
        
        $data['fecha_desde']=$fecha_desde;
        $data['fecha_hasta']=$fecha_hasta;
        
        //echo $fecha_desde;
        //echo $fecha_hasta;
        
        $certificados=$this->reporte_model->totales($fecha_desde,$fecha_hasta,$vendedores);
        
        //print_r($certificados);

        //Los ordena por vendedor
        $vendedores=array();
        foreach($certificados as $certificado){
            $vendedores[$certificado['user_id']]['nombre']=$certificado['usuario_nombre'];
            if (empty($vendedores[$certificado['user_id']]['total'])){
                $vendedores[$certificado['user_id']]['total']=0;
            }
            $vendedores[$certificado['user_id']]['total']+=$certificado['total'];
            $vendedores[$certificado['user_id']]['certificados'][]=$certificado;
        }
        //print_r($vendedores);
        //exit;
        
        //Ordena el arreglo de total mayor a total menor
        $aux=array();
        foreach ($vendedores as $key => $row) {
            $aux[$key] = $row['total'];
        }
        array_multisort($aux, SORT_DESC, $vendedores);
       
        $data['vendedores']=$vendedores;
        //print_r($vendedores);
        $this->load->view('reporte/totales',$data);
    }
    
    function _validar_fecha(){
        $fecha_desde=$this->input->post('fecha_desde');
        $fecha_hasta=$this->input->post('fecha_hasta');
        if ($fecha_desde >$fecha_hasta){
            $this->form_validation->set_message('_validar_fecha', 'Fechas inválidas');
            return false;
        }else{
            return true;
        }
    }
    
}