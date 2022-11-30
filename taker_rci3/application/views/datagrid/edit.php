<form method="post" action="<?php echo $form_action; ?>" class="datagrid_post_form">

<?php if($title):?> 
    
<h3><?php echo $title ?></h3>
<?php endif; ?>

<?php if (validation_errors()):?>
    <div class="alert alert-danger">
        <?php echo validation_errors(); ?>
    </div>
<?php endif ?>


<?php if ($data):?>

        
       <?php echo form_hidden($action_name, $action_value);?>
       
       <?php if ($form_edit_buttom_top):?>
        <div class="form-actions text-right">   
            <input name="submit" type="submit" value="<?php echo lang('dt_edit'); ?>"  class="btn btn-large btn-primary"  />
            <a href="<?php echo $back_url; ?>" class="btn btn-large datagrid_link"><?php echo lang('dt_cancel'); ?></a>
        </div>
        <?php endif;?>
                

                
       <table class="table"> 

        <?php foreach( $fields as $key=>$field ): ?>

	    <?php 
		//Imprime hidden el primary para el edit
		if($field['primary']){echo form_hidden($field['alias'], $data[$field['alias']]);}
	    ?>
     
            <?php if ($field['edit']):
            
			        if ($field['form_control_edit']){
			            $field['form_control']=$field['form_control_edit'];
			        }
                    if(!$field['id']){
                        $field['id']=$field['alias'];
                    }
                    
                    if($field['function_values']){
                        $field['values']=call_user_func($field['function_values']);
                    }
                    $item= $field['alias'];
                    
                    $params=array(
                        'id'   =>$field['id'],
                    	'name'	=>$field['alias'],
                        'value' =>set_value($field['alias'],$data[$item],$field['escape']),
                   );

                    if(empty($field['edit_attributes']['class'])){
                        //default class
                        $params['class']="form-control";
                        $dropdown_params='class="form-control" id="'.$field['id'].'" ';  

                    }else{
                       
                        //custom class
                        $dropdown_params='class="'.$field['edit_attributes']['class'].'" id="'.$field['id'].'" ';

                       
                    }
                   if(!empty($field['edit_attributes']['multiple'])){
                        $dropdown_params.=' multiple="multiple" ';
                    }
				   $params=$params+$field['edit_attributes'];
                   
                   
                   

                    if ($field['form_control']=="hidden"):
    
                            echo form_hidden($field['alias'],set_value($field['alias'],$data[$item],$field['escape']));
                            continue;
                    endif;
                    ?>
                <?php  if ($field['titulo']):?>   
                    <tr>
                        <td colspan="2" class="titulo"><h3><?php echo $field['titulo']?></h3></td>
                    </tr>
                <?php  endif; ?>     
                    
                <tr>
                    <td style="vertical-align: top;text-align: right">
                        <?php echo form_label($field['label']); ?>
                        <?php
                        //REQUERIDO 
                        $pos = strpos($field['validation'], 'required');
                        if ($pos===false){
                        //nada          
                        }else{
                            echo '<span class="requerido">*</span>';            
                        }
                        ?>
                    </td>
                    <td>

                        <?php if ($field['form_control']=="input"):?>
                            <?php echo form_input($params); ?>
                        <?php endif; ?>
                        
                        <?php if ($field['form_control']=="textarea"):?>
                            <?php echo form_textarea($params); ?>
                        <?php endif; ?>

                        <?php if ($field['form_control']=="select"):
                                
                                echo form_dropdown(
                            	$field['alias'], 
                            	$field['values'] ,
                            	set_value($field['alias'],$data[$item],$field['escape']),
                            	$dropdown_params
                            	); 
                            	
                       endif; ?>  
                        <?php if ($field['form_control']=="chained"):?>
                                 <?php echo form_dropdown_chained(
                                    $field['alias'], 
                                    $field['values'] ,
                                    set_value($field['alias'],$data[$item],$field['escape']),
                                    $dropdown_params
                                    ); 
                                    
                                ?>
                            
                        <?php endif; ?>                       

                          
						<?php if ($field['form_control']=="upload"):?>
							<?php echo iframe_subir($field['alias'],$params['value']); ?>
                    	<?php endif; ?>
                         


                        <?php if ($field['form_control']=="none"):?>
                            <!-- no pone nada -->
                        <?php endif; ?>
                        
                        <?php if ($field['form_control']=="text"):?>
            			    <div class="alert alert-info">
                                	<?php echo $data[$item];  ?>
                                	<?php 
                                	//imprime un hidden para que no de error las validaciones
                                	echo form_hidden($field['alias'],$data[$item]);?>
            			    </div>
                        <?php endif ?>
                        
                    <?php if ($field['form_control']=="multiselect"):?>
                            <?php 
                            $items=set_value($field['alias'].'[]',$data[$item],$field['escape']);
                            
                            if(!is_array($items)){
                                $items=explode(',',$items);
                            }
                            
                            echo form_multiselect(
                                $field['alias'].'[]', 
                                $field['values'] ,
                                $items,
                                $dropdown_params
                            ); 
                                
                            ?>
                    <?php endif; ?>
 

		        <?php if ($field['help']):?>
				<span class="help-block"><?php echo $field['help']; ?></span>
		        <?php endif; ?>                             
                    </td>
                </tr>
             <?php endif ?>  
        <?php endforeach; ?>
        </table>
       <?php if ($form_edit_buttom_bottom):?>
           <hr>
           <p class="muted"><span class="requerido">*</span> <?php echo lang('dt_requerido'); ?></p>
        <div class="form-actions text-center">   
            <input name="submit" type="submit" value="<?php echo lang('dt_edit'); ?>"  class="btn btn-large btn-primary"  />
            <a href="<?php echo $back_url; ?>" class="btn btn-large datagrid_link"><?php echo lang('dt_cancel'); ?></a>
        </div>
	   <?php endif;?>
<?php else:?>
    <div class="alert alert-danger">
        <?php echo lang('dt_no_result'); ?>
        <a href="<?php echo $back_url; ?>" class="btn btn-default datagrid_link"><?php echo lang('dt_cancel'); ?></a>
    </div>
<?php endif;?>


</form> 
