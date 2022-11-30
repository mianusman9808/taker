<?php
class producto extends CI_Controller
{

    function grilla()
    {
        if (getPerms()!='Administrador'){
            salir();
        } 
       //Titulo de la grilla
        $this->datagrid->title("Productos");
        //Nombre de la tabla
        $this->datagrid->from('producto');
        //limit de registros para paginar
        $this->datagrid->limit('100');
        //Order by
        $this->datagrid->order_by('producto.nombre','asc');
        $this->datagrid->join("aseguradora","producto.aseguradora_id=aseguradora.id");
        
        $this->datagrid->add_field(array(
            'label'             => 'ID',    //Nombre que muestra
            'field'             => 'producto.id',    //Nombre del campo en la base de datos
            'primary'           => true,    //es primary key?
            'grid'              => true,    //visible en grilla
            'add'               => false,    //visible en agregar
            'edit'              => false     //visible en edit
        ));
         
        $this->datagrid->add_field(array(
            'label'             => 'Orden',
            'field'             => 'producto.orden',
            'validation'        => 'trim|is_natural', 
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            //'search'            => true             
        ));
        
        $this->datagrid->add_field(array(
            'label'             => 'Nombre',
            'field'             => 'producto.nombre',
            'validation'        => 'trim|required', 
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            'search'            => true             
        ));
         $this->datagrid->add_field(array(
            'label'             => 'Costo',
            'field'             => 'producto.costo',
            'validation'        => 'trim|required|numeric', 
            'grid'              => true,
            'edit'              => true,
            'add'               => true,

        ));
        $this->datagrid->add_field(array(
            'label'             => 'Comisión',
            'field'             => 'producto.comision',
            'validation'        => 'trim|required|numeric', 
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
        ));
        $this->datagrid->add_field(array(
            'label'             => 'Débito',
            'field'             => 'producto.debito',
            'validation'        => 'trim|required|numeric', 
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
        ));
                $this->datagrid->add_field(array(
            'label'             => 'Validez',
            'field'             => 'producto.validez',
            'validation'        => 'trim|required', //Validacion del add y el edit
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            'search'            => true             //Busca por este campo
        ));
        //GRILLA
        $this->datagrid->add_field(array(
            'label'             => 'Aseguradora',
            'field'             => 'aseguradora.nombre',
            'grid'              => true,
            'edit'              => false,
            'add'               => false,
            'search'            => true
        ));      
        //ADD
        $this->datagrid->add_field(array(
            'label'             => 'Aseguradora',
            'field'             => 'producto.aseguradora_id',
            'grid'              => false,
            'edit'              => true,
            'add'               => true,
            'function_values'   => array($this->aseguradora_model,'select'),
            'form_control'      => 'select'
        ));  
        
        //Datos de productos de La Mercantil
        $this->datagrid->add_field(array(
            'titulo'            => 'La Mercantil',
            'label'             => 'La Mecantil: Tipo de certificado',
            'field'             => 'producto.template',
            'validation'        => 'trim', 
            'grid'              => false,
            'edit'              => true,
            'add'               => true,
            'form_control'      => 'select',
            'help'              => 'Template del PDF',
            'values'            => array(
                        ''              =>'',      
                        'auto'          =>'auto',
                        'motocicleta'   =>'motocicleta',
                        'trailer'       =>'trailer',
                        'puerto_natales'    =>'puerto_natales')
        ));
        

        $this->datagrid->add_field(array(
            'label'             => 'La Mercantil: Tipo de vehiculo',
            'field'             => 'producto.tipo',
            'validation'        => 'trim', 
            'grid'              => false,
            'edit'              => true,
            'add'               => true,
            'form_control'      => 'select',
            'values'            => array(
                    ''                  =>'',
                    'Station Wagon'     =>'Station Wagon',
                    'Automovil'         =>'Automovil',
                    'Pickup o Camioneta'    =>'Pickup o Camioneta',
                    'Motocicleta'           =>'Motocicleta',
                    //'Motocicleta o Cuatriciclo'           =>'Motocicleta o Cuatriciclo',
                    'Van-Combi'             =>'Van-Combi',
                    'Casa Rodante o Motor-Home' =>'Casa Rodante o Motor-Home'
             ),
        ));
        
        
        
        $this->datagrid->add_field(array(
            'label'             => 'La Mercantil: Trailer',
            'field'             => 'producto.trailer',
            'validation'        => 'trim', 
            'grid'              => false,
            'edit'              => true,
            'add'               => true,
            'form_control'      => 'select',
            'values'            => array(
                    '0'=>'No',
                    '1'=>'Si',

             ),
        ));  
        
        //Datos de productos de Boston
        
        $this->datagrid->add_field(array(
            'titulo'            => 'Boston',
            'label'             => 'Boston: Tipo de Vehiculo',
            'field'             => 'producto.boston_tipo_id',
            'validation'        => 'trim', 
            'grid'              => false,
            'edit'              => true,
            'add'               => true,
            'form_control'      => 'select',
            'form_values'       => array($this->boston_tipo_vehiculo_model,'select')

        ));


        $data['datagrid']=$this->datagrid->run();
        $this->load->view("datagrid/template", $data); 
    }

}
///FIN
