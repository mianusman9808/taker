<?php 
    function correo_configuracion(){
            $config['protocol'] = 'mail';
            //$config['mailpath'] = '/usr/sbin/sendmail';
            $config['charset'] = 'utf-8';
            $config['mailtype'] = 'html';
            $config['wordwrap'] = TRUE;
            return $config;
    }
    
////FIN