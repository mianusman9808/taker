<?php
class totales extends CI_Controller
{
	function saldo()
	{
        if (getPerms()!='Administrador'){
           salir();
        }


        $data['vendedores']=$this->cuenta_model->get_saldo();
		$this->load->view('totales/saldo',$data);
	}
    function credito_debito()
    {
        //no se usa...no se entiende la columna "debito
        exit;
        if (getPerms()!='Administrador'){
           salir();
        }

        $data['vendedores']=$this->cuenta_model->get_debito_credito();
        $this->load->view('totales/credito_debito',$data);
    }

}

///FIN
