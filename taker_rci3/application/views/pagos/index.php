<?php $this->load->view("template/header"); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12" id="datagrid">
            <?php echo $datagrid;?>
        </div>
        <div class="col-md-12">
            <?php 
            $usuario_nombre=$this->input->get("g_usuario_Nombre");
            $cancelado=$this->input->get("g_pagos_cancelado");
            $item=$this->input->get("g_item");
            
            if(!$item){ //Esta en la grilla
                if($cancelado === "0"){ //Para dar el total de deduda
                    $total=$this->pagos_model->get_total_deuda($usuario_nombre);
                    echo '<div class="alert alert-info"><h4>Deuda: '.$total.'</h4></div>';
                    //echo $this->db->last_query();
                    
                }
            }
            ?>
        </div>
     </div>
</div>

<?php $this->load->view("template/footer"); ?>