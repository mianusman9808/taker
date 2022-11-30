<?php echo form_open(null,array('method'=>'get','class'=>'well form-inline datagrid_search')); ?>

<?php echo form_hidden($prefix.'offset','0'); ?>
<?php echo form_hidden($action_name,$action_value); ?>

<?php foreach ($fields as $field):
	echo '<div class="form-group">';
	if ($field['search']):
		echo form_label($field['label'])."&nbsp;&nbsp;";
        
		if ($field['form_control']=="select"){
               if($field['function_values']){
                    $field['values']=call_user_func($field['function_values']);
               }
    
               $values=array(""=>"Todos")+$field['values'];
               
                if(empty($field['search_attributes']['class'])){
                    $dropdown_params='id="'.$field['alias'].'" class="form-control"';

                }else{    
                    $dropdown_params='id="'.$field['alias'].'" class="'.$field['search_attributes']['class'].'" " ';
                }
               
               echo form_dropdown(
                        $prefix.$field['alias'], 
                        $values ,
                        $this->input->get($prefix.$field['alias']),
                        $dropdown_params
                );
							
		}elseif ($field['form_control']=="chained"){
                                
                                echo '<select name="'.$prefix.$field['alias'].'" '.$dropdown_params.'  >';
                                echo '<option value="">---</option>';
                                foreach ($field['values'] as $value){
                                    if($this->input->get($prefix.$field['alias'])==$value['item']){
                                        $selected=' selected="selected" ';
                                    }else{
                                        $selected='';
                                    }
                                    echo '<option value="'.$value['item'].'" class="'.$value['chained'].'" '.$selected.'>'.$value['value'].'</option>';
                                }
                                echo '</select>';
        }else{
                            
                $atributes=array(
                    "name"=>$prefix.$field['alias'],
                    "value"=>$this->input->get($prefix.$field['alias']),
                    "class"=>"input-medium search-query"
                );

                $atributes=array_merge($atributes,$field['search_attributes']);

                echo form_input($atributes);
       	}
	endif;
	echo "&nbsp;&nbsp;";
	echo '</div>';
endforeach;                        
?>			

<?php 
    echo form_submit(array('name'=>'buscar','value'=>lang('dt_search'),'class'=>'btn btn-default'));
    echo form_close();

?>
