<?php

if( !function_exists('item_titulo') )
{
	function item_titulo($texto=""){
	    return "<strong>".$texto."</strong>";
	}
}

if( !function_exists('_grid_surround_braces') )
{
	function _datagrid_surround_braces(&$str)
	{

		$str = '{'.$str.'}';
	}
}

if( !function_exists('datagrid_action') )
{

    function datagrid_action($actions, $rowitem,$imprimir_td=true)
    {
        if($actions){
            $output = '';
            foreach( $actions as $action )
            {
                $url = datagrid_replace($action['url'],$rowitem);   
                $output .= '<a href="'.$url.'" class="'.$action['class'].'" title="'.$action['text'].'" target="'.$action['target'].'"><span class="'.$action['icon'].'"></span> ';
                if($action['show_text']){
                    $output .=$action['text']; 
                }
    
                $output .='</a>&nbsp;';
            }
            if ($imprimir_td){
                echo '<td style="white-space: nowrap;">'.$output.'</td>';     
            }else{
                echo $output; 
            }
        }
    }
}



if( !function_exists('datagrid_data') )
{
    function datagrid_data($rowitem, $fields)
    { 
        foreach( $fields as $field )
        {

            if($field['grid']){
                if ($field['function']){
			         //Pasa el valor por la funcion y lo imprime                    
			         $nuevo_valor=call_user_func($field['function'],$rowitem);
			         echo '<td>'. $nuevo_valor.'</td>'."\n";  
                }else{
		
    		        //Remplaza por los valores
    		        if(!empty($field['values'][$rowitem[$field['alias']]])){
    		            echo '<td>'.$field['values'][$rowitem[$field['alias']]].'</td>'."\n";   
    		        }else{
    		            echo '<td>'.$rowitem[$field['alias']].'</td>'."\n";  
    		        }
		      }

            }
            
        }
    }
}
if( !function_exists('datagrid_heading') )
{

    function datagrid_heading($fields)
    {
        foreach( $fields as $field )
        {
            if($field['grid']){
                 echo '<th>'.$field['label'].'</th>';
            }
        }
    }
}



///////////////////////////////////////////////////////////////////
//DATA VIEW DE LOS EDIT Y DE LOS VIEWS

if( !function_exists('dataview_data') )
{

    function dataview_data($data, $field)
    {
        //Remplaza por los valores VALUES
        if(!empty($field['values'][$data])){
            echo $field['values'][$data];   
        }else{
          echo $data;
        }

    }
}

if( !function_exists('datagrid_replace') )
{

    function datagrid_replace($string="",$data=array())
    {

       $keys   = array_keys($data);
       $values = array_values($data);
       array_walk($keys, '_datagrid_surround_braces');
       $string = str_replace($keys, $values, $string);
       return $string;

    }
}

////////////////////////////////////////////
//UTILES
if( !function_exists('query_string_url') )
{
 function query_string_url()
    {

       $x="";
       if(count($_GET) > 0)
       {
          $get =  array();
          foreach($_GET as $key => $val)
          {
             $get[] = $key.'='.$val;
          }
          $x .= '?'.implode('&',$get);
       }
       return $x;
    }  
}

//convierte un arreglo retornado de una sql a un arreglo apto para un select

function array_to_select($data=array(),$item="item",$value="value",$requerido=true){

	if($item===null){$item="item";}
	if($value===null){$value="value";}

		if($requerido){
			$x=array();	
		}else{
			$x=array(""=>"");
		}
        foreach($data as $row){
            $x[$row[$item]]=$row[$value];
        }
        return $x;
}
