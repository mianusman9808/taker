<?php

class Datagrid_model extends CI_Model {
    
    public $from="";
    //public $limit="";
    public $fields=array();
    public $joins=array();
    public $wheres=array();
    public $or_wheres=array();
    public $likes=array();
    public $order_bys=array(
            array('id','asc')
        );
    public $primary_key='id';
    public $primary_key_alias='id';


    
    public function __construct()
    {

        parent::__construct();

    }
 

   public function insert_item($data=array()){

        $this->db->insert($this->from, $data);

           
    }
    public function delete_item($item=""){
        $x=$this->select_item($item);
        if(!$x){
            show_error('Operacion no permitida');
        }
        $this->db->where($this->primary_key,$item);

        $this->db->delete($this->from);
    }  
   
    public function update_item($item="",$data){  
        $x=$this->select_item($item);
        if(!$x){
            show_error('Operacion no permitida');
        }   
        $this->db->where($this->primary_key,$item);
        $this->db->update($this->from, $data); 
    }
        
    public function select_item($item=""){

        $this->db->from($this->from);
        
        $this->db->where($this->primary_key,$item);
        
        foreach ($this->fields as $field){
            //false para permitir funciones de concat y otras en el select          
           $this->db->select($field['field'] .' as '.$field['alias'], false);
        }
        foreach ($this->joins as $join){
            $this->db->join($join[0],$join[1],$join[2]);
  
        }
        foreach ($this->wheres as $where){
            $this->db->where($where[0],$where[1],$where[2]);
        }

        foreach ($this->or_wheres as $or_where){
                $this->db->or_where($or_where[0],$or_where[1],$or_where[2]);
        }


        foreach ($this->likes as $like){
            $this->db->like($like[0],$like[1]);
            
        } 
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function count_all(){

        $this->db->from($this->from);


        foreach ($this->joins as $join){

            $this->db->join($join[0],$join[1],$join[2]);
            
        }
        foreach ($this->wheres as $where)
        {
            $this->db->where($where[0],$where[1],$where[2]);
        }

        foreach ($this->or_wheres as $or_where)
        {
                $this->db->or_where($or_where[0],$or_where[1],$or_where[2]);
        }

        foreach ($this->likes as $like){

            $this->db->like($like[0],$like[1]);
            
        }
        
        return $this->db->count_all_results();
    
    }
    
    public function select($limit="10",$offset="0"){
	   
        foreach ($this->fields as $field){
            //false para permitir funciones de concat y otras en el select
            $this->db->select($field['field'] .' as '.$field['alias'],false);

        }
        
        $this->db->from($this->from);
        


        foreach ($this->joins as $join){

            $this->db->join($join[0],$join[1],$join[2]);
            
        }
        //print_r($this->wheres);
        foreach ($this->wheres as $where)
        {
            $this->db->where($where[0],$where[1],$where[2]);
        }

        foreach ($this->or_wheres as $or_where)
        {
                $this->db->or_where($or_where[0],$or_where[1],$or_where[2]);
        }


        foreach ($this->likes as $like){

            $this->db->like($like[0],$like[1]);
            
        }        


        $this->db->limit($limit,$offset);           
       
        foreach ($this->order_bys as $order_by){
            $this->db->order_by($order_by[0],$order_by[1]);
        }
        $query = $this->db->get();
        $resultado=$query->result_array();
		
        //echo $this->db->last_query();
        //print_r($resultado);
        
        return $resultado;
    }


}

/* End of file Example.php */
/* Location: /application/models/Example.php */
