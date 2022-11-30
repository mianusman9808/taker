

<table width="100%">
    <tr>
        <td><?php if($title):?><h3><?php echo $title ?></h3><?php endif; ?></td>
        <td>
          <div style="text-align: right">
               <?php foreach ($grid_actions as $action): ?>
                    <a href="<?php echo $action['url'];?>" target="<?php echo $action['target'];?>" class="<?php echo $action['class'];?> btn-large"><span class="<?php echo $action['icon'];?> icon-white"></span> <?php if($action['show_text']){echo $action['text'];} ?></a>
                    &nbsp;&nbsp;
               <?php endforeach;?>
            </div>  
        </td>
     </tr>
</table>


<?php if($descripcion) :?>
    <div class="alert alert-info">
        <?php echo $descripcion ?>   
    </div>
<?php endif ?>

<?php if($alert) :?>
    <div class="alert alert-danger">
        <?php echo $alert ?>   
    </div>
<?php endif ?>

<?php echo $search;?>


<?php if ($grid_data):?>



    <table id="<?php echo $grid_id; ?>" <?php echo $grid_attributes; ?> >
    
    	<thead>
    		<tr>
                <?php datagrid_heading($fields); ?>
                
                <?php if( $row_actions):?>
                    <th>&nbsp;</th>
                <?php endif;?>
            </tr>
    	</thead>
    
    	<tbody>
    		<?php foreach( $grid_data as $item ): ?>
    
    		<tr>
                <?php datagrid_data($item, $fields); ?>
                <?php datagrid_action($row_actions, $item);	?>
    		</tr>
    
    		<?php endforeach; ?>
    	
            
            
    	</tbody>
    </table>
    

   
    <table style="width: 100%">
        <tr>
            <td><div class="pagination"><?php echo $pagination;?></div></td> 
            <td style="text-align: right; white-space: nowrap"><?php echo lang('dt_total_rows'); ?>: <?php echo $total;?></td>
        </tr>
    </table>
    
    
<?php else:?>
    <div class="alert alert-info">
        <?php

			echo lang('dt_no_result');

		?>
    </div>
<?php endif;?>


