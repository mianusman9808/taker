<?php
class utiles extends CI_Controller
{
    function parche(){
        exit;
        //parche orden de productos
        $sql="ALTER TABLE `producto` ADD COLUMN `orden` INT NOT NULL AFTER `aseguradora_id`";
        $this->db->query($sql);  
    }
    
    function correo_boston(){
        exit;
        //125727
        //Test de certificado de boston
        $this->correo->certificado_boston(125727);
        
    }
    
    /*
     * Permite descargar una planilla con los totales de ventas 
     * por vendedor y por mes
     * Se ejecuta manualmente por URL 
     * y se retoca manualmente, agregando los nombres de encabezado de columnas
     */
    function totales_mensuales(){
        if(!havePerm('Administrador')){
            exit;
        }
        //$mes=1;
        //$anio=2014;
        header("Content-type: application/octet-stream; charset=ISO-8859-1");
        header("Content-Disposition: attachment; filename=\"totales_mensuales.csv\"");

        $anio_desde=2012;
        $anio_hasta=2014;

        $vendedores=array();
        for ($anio=$anio_desde; $anio <=$anio_hasta ; $anio++) { 
            for ($mes=1; $mes <=12 ; $mes++) { 
                $certificados=$this->reporte_model->totales_by_anio_mes($anio,$mes);
                foreach ($certificados as $certificado){
                    $vendedores[$certificado['user_id']]['nombre']=$certificado['usuario_nombre'];
                    $vendedores[$certificado['user_id']]['fecha'][$anio][$mes]=$certificado['total'];
                }
            }
        }
        //print_r($vendores);
        foreach ($vendedores as $vendedor){

            echo '"'.texto_planilla($vendedor['nombre']).'",';
            for ($anio=$anio_desde; $anio <=$anio_hasta ; $anio++) { 
                for ($mes=1; $mes <=12 ; $mes++) {
                    if(empty($vendedor['fecha'][$anio][$mes])){
                        echo '0'.',';
                    }else{
                        echo $vendedor['fecha'][$anio][$mes].',';
                    }
    
                }
            }
            echo "\n";     
        }
     
    }
    
    
    
    /*
     * Revertir Anlacion
     * Permite volver a poner activo un certificado anulado
     * */
	function revertir_anulacion($Numero="",$aceptar=0)
    {
        if(!havePerm('Administrador')){
            exit;
        }
        if(!$Numero){
            show_error("Falta el numero de certificado");
        }
       
        
        if($aceptar){
            //Activa el certificado
            $data=array(
                'Estado'=>'Emitido'
            );
            $this->db->update('certificado',$data);
            
            //Borra la cuenta anulada
            $this->db->like("concepto",$Numero);
            $this->db->where('(tipo="Venta anulada" or tipo="Comision anulada")');
            $this->db->delete("cuenta");
            
            $this->db->select("*");
            $this->db->from("certificado");
            $this->db->where("Numero",$Numero);
            $this->db->where("Estado","Emitido");
            $query=$this->db->get();
            $certificado=$query->row_array();
            
            if(!$certificado){
                show_error("No se encontro certificado");
            }
            
            echo "<pre>";
            print_r($certificado);
            
            //Busca en la cuenta
            $this->db->select("*");
            $this->db->from("cuenta");
            $this->db->like("concepto",$Numero);

    
            $query=$this->db->get();
            $cuenta=$query->result_array();     
            
            print_r($cuenta);            
            echo "</pre>";  
        }else{
            
            $this->db->select("*");
            $this->db->from("certificado");
            $this->db->where("Numero",$Numero);
            $this->db->where("Estado","Anulado");
            $query=$this->db->get();
            $certificado=$query->row_array();
            
            if(!$certificado){
                show_error("No se encontro certificado para anular");
            }
            echo "<pre>";  
            print_r($certificado);
            
            //Busca en la cuenta
            $this->db->select("*");
            $this->db->from("cuenta");
            $this->db->like("concepto",$Numero);
            $this->db->where('(tipo="Venta anulada" or tipo="Comision anulada")');
    
            $query=$this->db->get();
            $cuenta=$query->result_array();     
            
            print_r($cuenta);
            echo "</pre>";  
            echo '<a href="'.base_url().'utiles/revertir_anulacion/'.$Numero.'/1">Aceptar Revertir</a>'; 
        }
                

        
         
          
    }

}
///FIN