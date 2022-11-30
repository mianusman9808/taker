<!doctype html>
<html lang="es">
<head>
    <?php
	// RMARTINEZ
     //if($_SERVER['SERVER_NAME']=="localhost") {
        $server_url=    "http://localhost:81/";        //url del servidor
        $taker_url  =   "http://localhost/ramiro3/taker/";  //url del sitio publico
        $taker_path=    "C:/xampp/htdocs/ramiro3/taker/";  //paths del servidor
	/*
    }else{
		//URL ABSOLUTAS
		//TODO: Activar luego de migrar
		//$server_url=    "https://www.taker.com.ar/";
        //$taker_url=     "https://www.taker.com.ar/taker/";
        
        $server_url=    "/";
        $taker_url=     "/taker/";
        
        $taker_path=    "/var/www/www.taker.com.ar/html/taker/";
	}
	*/
    include($taker_path."config/functions.php");
    include($taker_path."config/productos_db.php");
    
    ?>
	<meta charset="utf-8">
	<!--[if IE]>
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <![endif]-->
	<meta name="viewport" content="initial-scale=1.0, width=device-width">
	<title>Taker. Herramientas de logística para la contratación de seguros.</title>
	<meta name="description" content="Contratación de seguros: automotor, accidentes personales. Coberturas para personal. Transporte y Conscionarias 0km.">
	<meta name="keywords" content="Seguros, accidentes, ART, barrios privados, country, mendoza, turismo aventura">
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $taker_url; ?>assets/imgs/fav/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo $taker_url; ?>assets/imgs/fav/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $taker_url; ?>assets/imgs/fav/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $taker_url; ?>assets/imgs/fav/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $taker_url; ?>assets/imgs/fav/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $taker_url; ?>assets/imgs/fav/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $taker_url; ?>assets/imgs/fav/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $taker_url; ?>assets/imgs/fav/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $taker_url; ?>assets/imgs/fav/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="<?php echo $taker_url; ?>assets/imgs/fav/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $taker_url; ?>assets/imgs/fav/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo $taker_url; ?>assets/imgs/fav/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $taker_url; ?>assets/imgs/fav/favicon-16x16.png">
	<meta name="msapplication-TileImage" content="<?php echo $taker_url; ?>assets/imgs/fav/ms-icon-144x144.png">

	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Expires" content="0">	
	
	<!-- Google Fonts -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Titillium+Web:400,700,700i" rel="stylesheet"> -->
	
	<!-- Linear icons -->
	<!--  <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css"> -->
	
	<link rel="preload" href="<?php echo $taker_url; ?>assets/bootstrap/glyphicons-halflings-regular.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="<?php echo $taker_url; ?>assets/bootstrap/fontawesome-webfont.woff" as="font" type="font/woff" crossorigin>

	<!-- Estilos -->
	<link rel="stylesheet" href="<?php echo $taker_url; ?>assets/bootstrap/css/bootstrap.min.css" type="text/css" media="all" />

	<link rel="stylesheet" href="<?php echo $taker_url; ?>assets/css/font-awesome.min.css" type="text/css" media="all" />

	<link rel="stylesheet" href="<?php echo $taker_url; ?>assets/css/estilos.css?release=2" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo $taker_url; ?>assets/css/custom.css" type="text/css" media="all" />
	<!-- Scripts -->
	<script src="<?php echo $taker_url; ?>assets/js/jquery-3.1.1.min.js"></script>
	<script src="<?php echo $taker_url; ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<!--
	<script src="<?php echo $taker_url; ?>assets/js/custom.js"></script>
	-->
	<!--[if lt IE 9]> <script src="js/html5.js"></script> <script src="js/respond.min.js"></script> <![endif]-->
</head>
<body id="page-top">
    
<?php //include($taker_path.'inc/nav-scroll.php');?>

<nav id="nav-taker" class="navbar navbar-ppal navbar-inverse">
	<?php include($taker_path.'inc/nav-ppal.php');?>
</nav>
