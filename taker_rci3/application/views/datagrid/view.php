<?php if($title):?> 
    <h3><?php echo $title ?></h3>
<?php endif; ?>


<?php if ($data):?>
       <table class="table"> 
        <?php foreach( $fields as $field): ?>     
            <?php if ($field['view']):
                $item= $field['alias'];
                ?>
                <tr>TAKER</tr>
                <tr>
                    <td>
                        <?php echo form_label($field['label']); ?>
                    </td>
                    <td>
                        <?php echo dataview_data($data[$item], $field); ?>
                    </td>
                </tr>
             <?php endif ?>  
        <?php endforeach; ?>
	 
    <?php if ($back_url):?>
	<tr>
	    <td>&nbsp;</td>
	    <td>
	        <?php datagrid_action($row_actions, $data,false); ?>
	        <a href="<?php echo $back_url; ?>"  class="btn btn-default datagrid_link" ><?php echo lang('dt_return'); ?></a>
	    </td>
	</tr>
    <?php endif; ?>
    
    </table>
<?php else:?>
    <div class="alert alert-danger">
        <?php echo lang('dt_no_result'); ?>
        <a href="<?php echo $back_url; ?>" class="btn btn-default btn-large datagrid_link"><?php echo lang('dt_cancel'); ?></a>
    </div>
<?php endif;?>


