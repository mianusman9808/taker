<?php if($title):?> 
    <h3>
        <?php echo $title ?>
    </h3>
<?php endif; ?>

<?php if (validation_errors()):?>
    <div class="alert alert-danger">
        <?php echo validation_errors(); ?>
    </div>
<?php endif ?>

<?php if ($data):?>
    <form method="post" action="<?php echo $form_action; ?>" class="datagrid_post_form">
        
        <?php echo form_hidden($action_name, $action_value);?>
        
        <table class="table"> 
	<?php if ($form_edit_buttom_top):?> 
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input name="submit" type="submit" value="<?php echo lang('dt_delete'); ?>"  class="btn btn-danger"  />
                    
                    <a href="<?php echo $back_url; ?>" class="btn datagrid_link"><?php echo lang('dt_cancel'); ?></a>
                </td>
            </tr>

	<?php endif ?>



            <?php foreach( $fields as $field ): ?>    
                <?php if ($field['delete']):
                    $item= $field['alias'];
                    if ($field['form_control']=="hidden"):
                            echo form_hidden($field['alias'],$field['default']);
                            continue;
                    endif;
                    
                    ?>
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
             
	<?php if ($form_edit_buttom_bottom):?> 
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input name="submit" type="submit" value="<?php echo lang('dt_delete'); ?>"  class="btn btn-large btn-danger"  />
                    
                    <a href="<?php echo $back_url; ?>" class="btn btn-large datagrid_link"><?php echo lang('dt_cancel'); ?></a>
                </td>
            </tr>
             
        </table>
	<?php endif ?>
	
    </form>
<?php else:?>
    <div class="alert alert-danger">
        <?php echo lang('dt_no_result'); ?>
        <a href="<?php echo $back_url; ?>" class="btn btn-default btn-large datagrid_link"><?php echo lang('dt_cancel'); ?></a>
    </div>
<?php endif;?>
