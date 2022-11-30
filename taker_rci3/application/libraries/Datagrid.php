<?php	if (!defined('BASEPATH')) exit('No direct script access allowed');

class Datagrid
{

    //public $modo_compatible=true;
    public $title="Datagrid";
    public $limit=40;
    public $fields=array();
    public $primary_key="id";
    public $primary_key_alias="id";
    public $model="datagrid_model"; 
    public $prefix="g_" ;
    public $data=array();
    
    //vistas
    public $template_grid           ="datagrid/datagrid";
    public $template_view           ="datagrid/view";
    public $template_edit           ="datagrid/edit";
    public $template_add            ="datagrid/add";
    public $template_delete         ="datagrid/confirm_delete";
    public $template_search         ="datagrid/horizontal_search"; 
    
    //acciones globales
    public $add     =true;
    public $edit    =true;
    public $delete  =true;
    public $view    =false;
    
    //Acciones de los items de la grilla: ej: delete
    public $action_row=array();
    //Accionnes globales de la grilla: ej: add
    public $action_grid=array();   
    
    
    //public $add_button_enabled=true;        //Quita el boton de add, pero permite el metodo
    public $form_edit_buttom_top=false;     //Pone botones arriba del form de edit
    public $form_edit_buttom_bottom=true;   //Pone botones abajo
    
    //Callbacks
    public $functions=array(
            "insert"=>array(
                "pre"=>"",
                "post"=>""
            ),
            "update"=>array(
                "pre"=>"",
                "post"=>""
                ),
            "delete"=>array(
                "pre"=>"",
                "post"=>""
            ),
            "view"=>array(
                "pre"=>"",
            )
        );
    /*
    
    //Formato del arreglo de funciones y callbacks
    //El view solo tiene un pre antes de armar la vista
    
    array(
	    'insert'=>array(
	    	'pre'	=>"nombre_funcion",
	    	'post'	=>"nombre_funcion"
	    ),
	    'delete'=>array(
	    	'pre'	=>"nombre_funcion",
	    	'post'	=>"nombre_funcion"
	    ),
	    'update'=>array(
	    	'pre'	=>"nombre_funcion",
	    	'post'	=>"nombre_funcion"
	    ),
        'view'=>array(
            'pre'   =>"nombre_funcion",
        ),     
      
    );
    Puede ser una funcion global o un callback:
    
    'pre'	=>"nombre_funcion" 			//funcion global
    'pre'	=>array($this, '_mi_funcion') 	//callback
    
    */
    //atributos de la tabla
    public $grid_attributes=' class="table table-striped" ';
    public $descripcion="";
    public $alert="";
    
    //Variables que penvia en la url
    public $persist=array();
    public $show_search=false;  

    private $ci;
    private $gridID="Datagrid";
    private $total;     //total de registros    

    private $config;
    
    //SOLO LAS USA EL DATAGRID_MODEL
    public $from="";
    public $joins=array();
    public $wheres=array();
    public $or_wheres=array();
    public $likes=array();
    public $order_bys=array();
    public $redirect_url="";
    
	public function __construct()
	{

        	$this->ci=& get_instance();
        	$this->ci->load->language('datagrid');
        	$this->ci->load->helper('datagrid');
		$this->ci->load->helper('url');
		$this->ci->load->helper('form');
		$this->ci->load->helper('language');
		$this->ci->load->library('pagination');
		//$this->ci->load->library('input');
        	$this->ci->load->library('form_validation');
	}

    function add_field($field=array()){
        

         
         $default=array(
            'label'     =>  '',
            'field'     =>  '',
            'alias'     =>  '',
            'id'        =>  '',
            'values'    =>  array(),    //arreglo bidimensional para los select (array('valor'=>'label'))
            'search'    =>  false,  
            //visibilidad del registro             
            'grid'          =>false,               
            'edit'          =>false,
            'view'          =>true,
            'delete'        =>true,
            'add'           =>false,
            
            'primary'       =>false,
            'default'       =>'',
            'form_control'  =>'input',     		   
            'form_control_edit'=>'',          
            'form_control_add'=>'',  
            
            //atributos que escribe en el html de los forms
            'attributes'         => array(),
            'edit_attributes'    => array(),
            'add_attributes'     => array(),
            'search_attributes'  => array(),
            //////
            'validation'        =>'',
            'validation_add'    =>null,
            'validation_edit'   =>null,    
            'validation_delete' =>null,
            'function'          =>'',      //pasa el row por la funcion antes de renderizar el valor en la grilla

            'disabled'  =>		false,
            'help'      =>'',
            'titulo'    =>"",               //Imprime un titulo separador en el formulario de edit y add
            'function_values'   =>array(),  //funcion que retorna values para el edit y el add
            'options'           =>"" ,
            'null'              =>false, //Envia valores nulos cuando es vacio 
            'escape'			=>true,
            'form_values'	    =>array(),
            "search_literal"        => false   //Para buscar con where en lugar de like, en el buscador

        );        
        $field =array_merge($default,$field);
 	//function_values obsoleto
	if($field['form_values']){
		$field['function_values']=$field['form_values'];
	}
	
        //alias
        if(!$field['alias']){

            $field['alias'] = str_replace(".", "_", $field['field']);
	    	//$field['alias'] = $field['field'];
        }
            
        //primary key
        if($field['primary']){
              $this->primary_key=$field['field'];
              $this->primary_key_alias=$field['alias'];
        }
        //validaciones default
        if($field['validation_add']===null){
            $field['validation_add']=$field['validation'];
        }
        if($field['validation_edit']===null){
            $field['validation_edit']=$field['validation'];
        }
	     
	
       
        //Attributos de los forms que pasan a la vista
        //si no tiene definidos usa los generales
        if(!$field['add_attributes']){
            $field['add_attributes']=$field['attributes'];
        }
        if(!$field['edit_attributes']){
            $field['edit_attributes']=$field['attributes'];
        }
        if(!$field['search_attributes']){
            $field['search_attributes']=$field['attributes'];
        }
        //Opciones que reescriben grid, view, add, delete, edit, hidden, search es independiente del hidden
        if($field['options']){
            
            $options=$field['options'];
            
            if(stristr($options, 'L')){
                $field['grid']=true;
            }
            if(stristr($options, 'A')){
                $field['add']=true;
            }
            if(stristr($options, 'C')){
                $field['edit']=true;
            }
            if(stristr($options, 'D')){
                $field['delete']= true;
            }
            if(stristr($options, 'V')){
                $field['view']=true;
            }

            if(stristr($options, 'S')){
                $field['search']=true;
            }

        }
        //prende el buscador si hay algun item para buscar
        if($field['search']){
            $this->show_search=true;
        }
  

        //agrega el campo al la grilla
        $this->fields[] =$field;

        
    }

    //////////////////////////////////////////////////////////////////////////////////////
    //INTERFACE PUBLICA
    public function title($title=""){
        $this->title=$title;
    }
    public function limit($limit=""){
        $this->limit=$limit;
    }
     public function from($from=""){
        $this->from=$from;
    }
	function where($condicion="",$valor=null,$escape=null){

	    $this->wheres[]=array($condicion,$valor,$escape); 
	}

    function or_where($condicion="",$valor=null,$escape=null){
        $this->or_wheres[]=array($condicion,$valor,$escape); 
    }

    function likes($param1="",$param2=""){

        $this->likes[]=array($param1,$param2); 
    }   
    function join($param1="",$param2="",$param3="INNER"){

        $this->joins[]=array($param1,$param2,$param3); 
    }
    function order_by($param1="",$param2=null){

        $this->order_bys[]=array($param1,$param2); 
    } 
    
    function add($add=true){

        $this->add=$add; 
    } 
    function view($view=true){

        $this->view=$view; 
    } 
    function delete($delete=true){

        $this->delete=$delete; 
    }
    function edit($edit=true){

        $this->edit=$edit; 
    } 
    function descripcion($descripcion=""){

        $this->descripcion=$descripcion; 
    }
    function alert($alert=""){

        $this->alert=$alert; 
    }
    //accion: insert, delete, update
    //momento: pre, post
    //funcion (callbacl): array($this,"callback")
    
    function functions($accion="",$momento="",$funcion=array()){
        $this->functions[$accion][$momento]=$funcion;     
    }
    
    //tipo de template= grid, view, edit, add, delete, search
    //archivo: datagrid/edit
    

    function template($tipo="",$archivo=""){
        $this->{"template_".$tipo}=$archivo;
    }

      
   //DATAGRID
    public function run($accion_get="",$item="",$redirect_url=""){
        $this->set_model();
        
		if(!$accion_get){
			$accion_get=$this->ci->input->get($this->prefix.'action');	
		}
		if(!$item){
			$item=$this->ci->input->get($this->prefix."item");	
		}
        
		if(!$redirect_url){
			$redirect_url=$this->ci->uri->uri_string()."/".$this->_url();
		}
        
		$this->redirect_url=$redirect_url;
        
        //////////////////////////////////////////////////////////////
        //ACCIONES DEL POST SAVE EDIT		
        if($this->ci->input->post($this->prefix.'action')=="save_edit" and $this->edit){
            $validar=false;
            foreach ($this->fields as $field){
                   if($field['validation_edit']){
                       $this->ci->form_validation->set_rules($field['alias'], $field['label'], $field['validation_edit']);
                       $validar=true;   
                   }
                   
                      
            }

            
            if ($this->ci->form_validation->run() == FALSE and $validar){

                return $this->build_editform($item);
                
            }else{
               //arreglo de datos para enviar a la db
               $data=array();
               foreach ($this->fields as $field){
                       if ($field['edit']){
      
                           //Envia valores nulos en lugar de cadenas vacias ""
                           if($field['null'] and !$this->ci->input->post($field['alias'])){
                               $data[$field['field']]=null;
                           }else{
                               $data[$field['field']]=$this->ci->input->post($field['alias']);
                           }
                       }
                }
                
                
                //Pre Callback
                if($this->functions['update']['pre']){
                    $data=call_user_func($this->functions['update']['pre'],$data);
                }
                //UPDATE DE LOS DATOS
                $this->ci->datagrid_model->update_item($item,$data);
                //Post Callback
                if($this->functions['update']['post']){
                
                    call_user_func($this->functions['update']['post'],$data);
                } 
                
                //REDIRECCIONA
 
                redirect ($this->redirect_url);
                
            } 
        }


        //////////////////////////////////////////////////////////////
        //ACCIONES DEL POST SAVE ADD
        elseif($this->ci->input->post($this->prefix.'action')=="save_add"  and $this->add){
            $validar=false;
            foreach ($this->fields as $field){
                if($field['validation_add']){              
                    $this->ci->form_validation->set_rules($field['alias'], $field['label'], $field['validation_add']);
                    $validar=true;  
                }
            }
            if ($this->ci->form_validation->run() == FALSE and $validar){
                //NO VALIDA
                return $this->build_addform();
            }else{
                //arreglo de datos para guardar en la db
                $data=array();
                foreach ($this->fields as $field){
                   if ($field['add']){         
                            //Envia valores nulos en lugar de cadenas vacias ""
                           if($field['null']and !$this->ci->input->post($field['alias'])){
                               $data[$field['field']]=null;
                           }else{
                               $data[$field['field']]=$this->ci->input->post($field['alias']);
                           }
                   }
                }
                //Pre Callback
                if($this->functions['insert']['pre']){
                    $data=call_user_func($this->functions['insert']['pre'],$data);
                }
                //INSERTA LOS DATOS
                $this->ci->datagrid_model->insert_item($data);
                
                //Post Callback
                if($this->functions['insert']['post']){
                    $item=$this->ci->db->insert_id(); 
                    call_user_func($this->functions['insert']['post'],$data);
                }             
                //REDIRECCIONA
                redirect ($this->redirect_url);
            } 
        
        }
        //////////////////////////////////////////////////////////////
        //ACCIONES DEL POST DELETE
        elseif($this->ci->input->post($this->prefix.'action')=="delete" and $this->delete){
             $validar=false;
             foreach ($this->fields as $field){
                 if($field['validation_delete']){         
                    $this->ci->form_validation->set_rules($field['alias'], $field['label'], $field['validation_delete']);
                    $validar=true;
                 }
            }
            if ($this->ci->form_validation->run() == FALSE and $validar){
                //NO VALIDA
                return $this->build_confirm_delete();
            }else{

                //Pre Callback
                if($this->functions['delete']['pre']){
                    call_user_func($this->functions['delete']['pre'],$item);
                }            
                //BORRA LOS DATOS
                
                $this->ci->datagrid_model->delete_item($item);
                //Post Callback
                if($this->functions['delete']['post']){

                    call_user_func($this->functions['delete']['post'],$item);
                }                 
                //REDIRECCIONA
                redirect ($this->redirect_url);
            }
        }
        

		
        elseif($accion_get=="edit" and $this->edit){
            return $this->build_editform($item); 
        }elseif($accion_get=="add" and $this->add){
            return $this->build_addform(); 
        }elseif($accion_get=="confirm_delete" and $this->delete){
            return $this->build_confirm_delete($item); 
        }elseif($accion_get=="view" and $this->view){

               return $this->build_view($item); 
        }else{
            return $this->build_datagrid(); 
        }              
    }

	public function set_model(){

	       if(empty($this->ci->datagrid_model)){
	           $this->ci->load->model($this->model,'datagrid_model');
	       }

	        
	    $this->ci->datagrid_model->from=$this->from;
            $this->ci->datagrid_model->fields=$this->fields;
            $this->ci->datagrid_model->joins=$this->joins;
            $this->ci->datagrid_model->wheres=$this->wheres;
            $this->ci->datagrid_model->or_wheres=$this->or_wheres;
            $this->ci->datagrid_model->likes=$this->likes;
            $this->ci->datagrid_model->order_bys=$this->order_bys;
        
            $this->ci->datagrid_model->primary_key=$this->primary_key;
            $this->ci->datagrid_model->primary_key_alias=$this->primary_key_alias;        	
	}


    
    //agrega botones con acciones a la grilla, como el ADD
    public function add_action_grid($name, $url, $text, $icon="", $show_text=true, $class="btn btn-success datagrid_link",$target=""){
        $new_action = array(
            'url'           => $url,
            'text'          => $text,
            'icon'          => $icon,
            'show_text'     => $show_text,
            'class'         => $class,
	    'target'	    => $target
        
        );

        
        if (!empty($this->action_grid[$name])){
           $this->action_grid[$name]=array_merge($new_action,$this->action_grid[$name]);
        }else{
           $this->action_grid[$name]= $new_action;
        }
    }
    

    //agrega botones con acciones a los ROWS de la grilla, como el delete.
	public function add_action_row($name="", $url="", $text, $icon="", $show_text=true, $class="btn btn-default  datagrid_link",$target="")
	{
	    
		$new_action = array(
			'url'			=> $url,
			'text'			=> $text,
			'icon'          => $icon,
			'show_text'     => $show_text,
			'class'			=> $class,
			'target'		=> $target
		
		);
        
        
        if (!empty($this->action_row[$name])){
           $this->action_row[$name]=array_merge($new_action,$this->action_row[$name]);
        }else{
           $this->action_row[$name]= $new_action;
        }
        
	}


	public function build_datagrid( )
	{
        //ACCIONES DEFAULT
       if($this->add ){

            $url=base_url().$this->ci->uri->uri_string().$this->_url()."&".$this->prefix."action=add";
            $this->add_action_grid("add", $url, lang('dt_add'),'glyphicon glyphicon-plus');
        }
        
        if($this->view){
            $url=base_url().$this->ci->uri->uri_string().$this->_url()."&".$this->prefix.'action=view&'.$this->prefix.'item={'.$this->primary_key_alias.'}';
            $this->add_action_row('view',$url,lang('dt_view'),'glyphicon glyphicon-eye-open',false);            
        }else{
            unset ($this->action_row['view']);
        }
        if($this->edit){
            $url=base_url().$this->ci->uri->uri_string().$this->_url()."&".$this->prefix.'action=edit&'.$this->prefix.'item={'.$this->primary_key_alias.'}';
            $this->add_action_row('edit',$url,lang('dt_edit'),'glyphicon glyphicon-pencil',false); 
        }else{
            unset ($this->action_row['edit']);
        }
        if($this->delete){
            $url=base_url().$this->ci->uri->uri_string().$this->_url()."&".$this->prefix.'action=confirm_delete&'.$this->prefix.'item={'.$this->primary_key_alias.'}';
            $this->add_action_row('delete',$url,lang('dt_delete'),"glyphicon  glyphicon-remove",false);
        }else{
            unset ($this->action_row['delete']);
        }
        //ENVIA AL DATAGRID LOS FILTROS DEL SEARCH
        foreach ($this->fields as $field){
            if ($field['search']){
                if($this->ci->input->get($this->prefix.$field['alias']) or $this->ci->input->get($this->prefix.$field['alias'])==="0"){
                    if ($field['form_control']=="form_dropdown"  or $field['search_literal']){
                        $this->ci->datagrid_model->wheres[]=array($field['field'], $this->ci->input->get($this->prefix.$field['alias']),true);                        
                    }else{
                         $this->ci->datagrid_model->likes[]=array($field['field'], $this->ci->input->get($this->prefix.$field['alias']));
                        
                    }  
                }
               
            }
        }
        
        
             
         //select de datos
        $offset=$this->ci->input->get($this->prefix.'offset');
        $this->data=$this->ci->datagrid_model->select($this->limit,$offset);

		// pasa las variables al template
		$templateData = array(
			'grid_id'				=> $this->gridID,
			'row_actions'			=> $this->action_row,
			'grid_attributes'		=> $this->grid_attributes,
			'grid_data'				=> $this->data,
			'fields'                 =>$this->fields,
			'pagination'             =>$this->build_pagination(),
			'search'                 =>'',
			'primary_key'            =>$this->primary_key,
			'primary_key_alias'      =>$this->primary_key_alias,
			'title'                  =>$this->title,
			'total'                  =>$this->total,
			'alert'                  =>$this->alert,
			'descripcion'            =>$this->descripcion

		);
        
        if($this->show_search){
            $templateData['search'] =$this->build_search();
        } 

        
        $templateData['grid_actions']=$this->action_grid;
		return $this->ci->load->view($this->template_grid, $templateData, TRUE);
	}

    public function build_view($item=""){
       
        //select de datos
        //$item=$this->ci->input->get($this->prefix."item");
        $data=$this->ci->datagrid_model->select_item($item);
	
        $templateData = array(

            'data'                  => $data,
            'fields'                =>  $this->fields,
            'back_url'              =>  base_url().$this->redirect_url,
            'title'                 =>  $this->title,
            'item_id'               =>  $item,
            'redirect_url'          =>  $this->redirect_url,
            //Para imprimir botones de acciones del row en el view...
            'row_actions'           => $this->action_row,

        );
       //Pre Callback del view
       if($this->functions['view']['pre']){
            $data=call_user_func($this->functions['view']['pre'],$data);
       }
       
        return $this->ci->load->view($this->template_view, $templateData, TRUE);

    }
	
    public function build_confirm_delete($item=""){
        //$item=$this->ci->input->get($this->prefix."item");
        $data=$this->ci->datagrid_model->select_item($item);
        $templateData = array(

            'data'                  =>  $data,
            'fields'                =>  $this->fields,
            'form_action'           => base_url().$this->ci->uri->uri_string().$this->_url()."&".$this->prefix."item=".$item,
            'action_name'           =>  $this->prefix."action",
            'action_value'          =>  "delete",
            'back_url'              =>  base_url().$this->redirect_url,
            'title'                  => $this->title,
            'form_edit_buttom_top'                 =>  $this->form_edit_buttom_top,
            'form_edit_buttom_bottom'                 =>  $this->form_edit_buttom_bottom,
            'item_id'                                 =>$item,
            'redirect_url'			=>$this->redirect_url

        );
        
        return $this->ci->load->view($this->template_delete, $templateData, TRUE);
    }
    
    public function build_editform($item=""){
       
        //select de datos
        //$item=$this->ci->input->get($this->prefix."item");
        $data=$this->ci->datagrid_model->select_item($item);
        $templateData = array(

            'data'                  =>  $data,
            'fields'                =>  $this->fields,
            'form_action'           =>  base_url().$this->ci->uri->uri_string().$this->_url()."&".$this->prefix."item=".$item,
            'action_name'           =>  $this->prefix."action",
            'action_value'          =>  "save_edit",
            'back_url'              =>  base_url().$this->redirect_url,
            'title'                 =>  $this->title,
            'form_edit_buttom_top'                =>  $this->form_edit_buttom_top,
            'form_edit_buttom_bottom'             =>  $this->form_edit_buttom_bottom,
            //'template_edit_extras'                =>  $this->template_edit_extras,
            'item_id'                             =>$item,


        );
        
        return $this->ci->load->view($this->template_edit, $templateData, TRUE);
    }
    



    public function build_addform(){

       $data=array();
       //Setea los default values
       foreach ($this->fields as $field){          
           $data[$field['alias']]=$field['default'];
        }

        
        $templateData = array(

            'data'                  =>  $data,
            'fields'                =>  $this->fields,
            'form_action'           =>  base_url().$this->ci->uri->uri_string().$this->_url(),
            'action_name'           =>  $this->prefix."action",
            'action_value'          =>  "save_add",
            'back_url'              =>  base_url().$this->redirect_url,
            'title'                 =>  $this->title,
            'form_edit_buttom_top'      =>  $this->form_edit_buttom_top,
            'form_edit_buttom_bottom'   =>  $this->form_edit_buttom_bottom,
            //'template_add_extras'      =>  $this->template_add_extras,
            'redirect_url'			=>$this->redirect_url

        );
        return $this->ci->load->view($this->template_add, $templateData, TRUE);
    }	    


	private  function build_search(){
        $templateData = array(
            'fields'                =>  $this->fields,
            'form_action'           =>  base_url().$this->ci->uri->uri_string().$this->_url(),
            'action_name'           =>  $this->prefix."action",
            'action_value'          =>  "search",
            'prefix'              =>    $this->prefix,

        );
        return $this->ci->load->view($this->template_search, $templateData, TRUE);		

	}
    
	private function build_pagination(){

        $this->total=$this->ci->datagrid_model->count_all();
        
            //TEMPLATE DEL PAGINADOR
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            
            $config['anchor_class'] = ' class="datagrid_link" '; 
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
        
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
        
            $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
            $config['cur_tag_close'] = '</a></li>';
        
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
        
             //FIN TEMPLATE PAGINADOR 

        $config['base_url'] = current_url().$this->_pagination_url();

    	  
        $config['total_rows'] = $this->total;
        $config['per_page'] =	$this->limit;
        $offset=$this->ci->input->get($this->prefix.'offset');

        $config['cur_page'] = $offset;
        $config['page_query_string'] = true;
        $config['query_string_segment'] = $this->prefix.'offset';
        $config['num_links'] = 4;
        $this->ci->pagination->initialize($config);
        return $this->ci->pagination->create_links();
	
	}

    
    ///////////
    //FUNCIONES QUE CONSTRUYEN LAS URL
    
    
    private function _pagination_url(){
        $terms= $this->_search_terms();
        //print_r($terms); 
        $x= "?".implode('&',$terms);
        return $x;
    }
    
    private function _url(){
        
        $offset=$this->ci->input->get($this->prefix.'offset');
        $terms= $this->_search_terms();

        if($offset){
            $terms[]=$this->prefix."offset=".$offset;
        }
        $x= "?".implode('&',$terms);
        return $x;
    }

    private function _search_terms(){

        $terms=array();         
        foreach ($this->fields as $field){
            
            if ($field['search']){
                
                if($this->ci->input->get($this->prefix.$field['alias'])){

                  $terms[]=$this->prefix.$field['alias']."=".$this->ci->input->get($this->prefix.$field['alias']);  
                }
            }
        }
        foreach ($this->persist as $var=>$val){
            $terms[]=$var."=".$val;
        }
        
        return $terms;
    }

	

    
}//END
