<?php
class browser extends CI_Controller {

    
    function index(){
        $this->load->library('user_agent');
        echo "PLATAFORMA: ".$this->agent->platform()."<br />";
        echo "BROWSER: ".$this->agent->browser()."<br />";
        echo "VERSION: ".$this->agent->version()."<br />";   
    }
}