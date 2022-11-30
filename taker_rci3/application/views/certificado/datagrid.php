<?php $this->load->view("template/header"); ?>

<div class="container">
<script>
                        $(document).ready(function() {
                            $("#exampleModal").modal('show');
                        });
                    </script>
    <?php if ($pagos):?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <p>Usted tiene transferencias pendientes, <a href="<?php echo base_url()?>pagos/deuda" class="btn btn-default">Consultar Transferencias</a></p>
               </div>
           </div>
       </div>
    <?php endif ;?> 
    
    <div class="row">
        <div class="col-md-12" id="datagrid">
            <?php echo $datagrid;?>
        </div>
     </div>
    <?php if (getPerms()=="Vendedor" or getPerms()=="Vendedor_organizador"):?>
    <div class="row">
        <div class="col-md-12" id="datagrid">
            <div class="well">
                <p>Disponible: <strong><?php echo $cuenta['total']; ?></strong></p>
            </div>
        </div>
     </div>
    <?php endif ?> 
</div>

<?php $this->load->view("template/footer"); ?>