<?php
class usuario extends CI_Controller
{

    function grilla()
    {
        if (getPerms()!='Administrador'){
            salir();
        } 
        $this->datagrid->title("Usuarios");
        //Nombre de la tabla
        $this->datagrid->from('usuario');
        //limit de registros para paginar
        $this->datagrid->limit('100');
        //Order by
        $this->datagrid->order_by('usuario.nombre','asc');
        $this->datagrid->template("search","datagrid/placeholder_search");
        $this->datagrid->add_field(array(
            'label'             => 'ID',    //Nombre que muestra
            'field'             => 'usuario.id',    //Nombre del campo en la base de datos
            'primary'           => true,    //es primary key?
            'grid'              => true,    //visible en grilla
            'add'               => false,    //visible en agregar
            'edit'              => false     //visible en edit
        ));
         

        $this->datagrid->add_field(array(
            'label'             => 'Nombre',
            'field'             => 'usuario.nombre',
            'validation'        => 'trim|required', 
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            'search'            => true             
        ));
        $this->datagrid->add_field(array(
            'label'             => 'Permisos',
            'field'             => 'usuario.perms',
            'validation'        => 'trim', 
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            'search'            => true ,
            'form_control'      => 'select',
            'values'            =>  array(
                'Administrador'         =>'Administrador',
                'Vendedor'              =>'Vendedor',
                'Vendedor_organizador'  =>'Vendedor_organizador',
                'Aseguradora'           =>'Aseguradora'),
        ));
        $this->datagrid->add_field(array(
            'label'             => 'Aseguradora ID',
            'field'             => 'usuario.aseguradora_id',
            'validation'        => 'trim|is_natural', 
            'grid'              => false,
            'edit'              => true,
            'add'               => true,
            'help'              => "Completar solo para usuarios Aseguradora"
        ));    
        $this->datagrid->add_field(array(
            'label'             => 'Username',
            'field'             => 'usuario.username',
            'validation'        => 'trim|required|alpha_numeric', 
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            'search'            => true             
        ));
        $this->datagrid->add_field(array(
            'label'             => 'Clave',
            'field'             => 'usuario.password',
            'validation'        => 'trim|required|alpha_numeric', 
            'grid'              => false,
            'edit'              => true,
            'add'               => true,
          
        ));
        $this->datagrid->add_field(array(
            'label'             => 'Email',
            'field'             => 'usuario.Email',
            'validation'        => 'trim|valid_email', 
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            'search'            => true             
        ));
        $this->datagrid->add_field(array(
            'label'             => 'Grupo',
            'field'             => 'usuario.Grupo',
            'validation'        => 'trim|alpha_numeric', 
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            'search'            => true,
            'help'              => "Completar solo para usuarios Vendedores y Organizadores"             
        ));
        /*
         * NO SE USA
       $this->datagrid->add_field(array(
            'label'             => 'Casa de cambio',
            'field'             => 'usuario.casa_de_cambio',
            'validation'        => 'trim', 
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            'form_control'      => 'select',
            'values'            => array(
                    '0'=>'0',
                    '1'=>'1',

             ),
        )); 
        */

        $this->datagrid->add_field(array(
            'label'             => 'Venta anticipada',
            'field'             => 'usuario.anticipado',
            'validation'        => 'trim', 
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            'form_control'      => 'select',
            'help'              => "Completar solo para usuarios Vendedores y Organizadores" , 
            'values'            => array(
                    '0'=>'No',
                    '1'=>'Si',

             ),
        ));  
        $this->datagrid->add_field(array(
            'label'             => 'Facturación',
            'field'             => 'usuario.facturacion',
            'validation'        => 'trim', 
            'grid'              => true,
            'edit'              => true,
            'add'               => true,
            'help'              => "Completar solo para usuarios Vendedores y Organizadores",   
            'form_control'      => 'select',
            'values'            => array(''=>'','Mensual'=>'Mensual','Semanal'=>'Semanal'),
        )); 
   
         $this->datagrid->add_field(array(
            'label'             => 'Dirección',
            'field'             => 'usuario.direccion',
            'grid'              => false,
            'edit'              => true,
            'add'               => true,
          
        ));
        $this->datagrid->add_field(array(
            'label'             => 'Localidad',
            'field'             => 'usuario.localidad',
            'grid'              => false,
            'edit'              => true,
            'add'               => true,
          
        ));
        $this->datagrid->add_field(array(
            'label'             => 'Provincia',
            'field'             => 'usuario.provincia',
            'grid'              => false,
            'edit'              => true,
            'add'               => true,
          
        ));
        $this->datagrid->add_field(array(
            'label'             => 'Teĺefono',
            'field'             => 'usuario.telefono',
            'grid'              => false,
            'edit'              => true,
            'add'               => true,
          
        ));
        $data['datagrid']=$this->datagrid->run();
        $this->load->view("datagrid/template", $data); 
    }

}
///FIN
