<?php
$productos = array(
	0 => array(
		'id' => 1, 
		'titulo' => 'Taker RCI',
		'subtitulo' => 'Seguros Automotores',
		'descripcion' => 'Ingreso a territorio argentino con cobertura obligatoria de seguro automotor.',
		
		'texto' => 'Esta herramienta ha sido desarrollada para obtener coberturas de Responsabilidad 
		Civil Automotores para todos aquellos vehículos extranjeros que ingresen a República Argentina, 
		que tengan la necesidad de cumplir con la obligatoriedad del seguro para pasar por aduana en 
		frontera. Si Usted es Productor de Seguros, Corredor de Seguros o Broker de Seguros, podrá obtener una clave y contraseña para acceder a la cobertura de manera instantánea, on-line, las 24 hs. de los 365 días del año.',
		
		'listas' => array(),
		'imagen' => 'automotores.jpg',
		'link' => $server_url.'taker_rci3',
	),
	/*
	1 => array(
		'id' => 2, 
		'titulo' => 'Taker 0Km',
		'subtitulo' => 'Seguros Automotores',
		'descripcion' => 'Cotización y contratación de seguros de automotor para concesionarias de venta de vehículos.',
		'texto' => 'Service que permite a las concesionarias de venta de vehículos obtener on-line cotizaciones comparativas de distintas compañías y la posterior contratación de la cobertura elegida.',
		'listas' => array(
			'i0' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
			'i1' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
			'i2' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
			'i3' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
			'i4' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
			'i5' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
		),
		'imagen' => '0km.jpg',
		'link' => 'automotores.php',
	),
    */
	2 => array(
		'id' => 3, 
		'titulo' => '¡HOLA! ESTAMOS FISCALIZANDO',
		'subtitulo' => 'Accidentes Personales',
		'descripcion'=> 'Única plataforma en el país destinada a fiscalizar coberturas de seguro y a controlar el ingreso de trabajadores a un barrio o predio determinado.',
		'texto' => 'Esta herramienta permite a los distintos usuarios acceder 
		a coberturas de accidentes personales para trabajadores autónomos.
        Esta aplicación está especialmente diseñada para permitir suscribir 
        seguros de forma ágil y sencilla.',
        

        'listas' => array(
            'i0' => '<h3>Procedimiento para el alta de cada trabajador en el sistema y su ingreso al barrio</h3>
                        <p>Para que el trabajador forme parte del sistema Taker, debe obtener su credencial en cualquiera de las terminales Taker ubicada en los distintos barrios en los que operamos. * Se detallan los mismos al final de la respuesta.</p>
                        <p>La credencial la obtiene concurriendo a la garita del barrio con su DNI (el nuevo), el cual deberá introducir en la terminal de autogestión y seguir los pasos que se detallan en la misma.</p>
                        <p>En caso de que sea la primera vez que el trabajador se incorpora al sistema Taker, podrá ingresar al barrio por 2 días corridos. Dentro de los dos días quien lo contrata deberá asignar el permiso correspondiente desde la web.</p>
                        <p>En caso de ser trabajadores que anteriormente ya pertenecieron al sistema Taker, el permiso deberá asignarse antes de querer ingresar al barrio.</p>',
            'i1' => '<h3>Costo mensual o diario del seguro accidente laboral por cada trabajador</h3>
                    <p>Los costos de los productos y cobertruras se informan en el sistema antes de contratarlos',
            
            //'i1' => '<h3>Costo mensual o diario del seguro accidente laboral por cada trabajador</h3>
            //        <p>Los costos de los productos y coberturas que ofrecemos, así como también el de las credenciales/acreditaciones se encuentran en la página en la parte superior derecha. Hacer click para visualizarlos.</p>',
            //'i2' => '<h3>Costo de las tarjetas para ingreso y por donde se retiran/envían</h3>
            //         <p>Los costos de los productos y coberturas que ofrecemos, así como también el de las credenciales/acreditaciones se encuentran en la página en la parte superior derecha. Hacer click para visualizarlos.</p>',

            'i3' => '<h3>Cuanto se demora en el alta de cada persona.</h3>
                    <p>El alta del trabajador en la terminal de autogestión demora 30 segundos.</p>',
            'i4' => '<h3>Métodos y forma de pago de/los seguros y tarjetas de acceso.</h3>
                    <p>Las formas de pago que poseemos en la actualidad son: 
                    Pago Fácil – Pagomiscuentas.com – Débito automático.</p>',
            'i5' => '<h3>En caso de contar con otro seguro, informar si es aceptado por el sistema y como se procede a su carga/envío de póliza.</h3>
                    <p>En caso de presentar un seguro contratado en forma particular, deberá consultar en Taker (vía mail o bien desde su usuario en la solapa de exigencias de barrios las exigencias establecidas por el barrio donde quiere ingresar.) La póliza deberá subirla a la web desde su usuario para que la misma sea fiscalizada por Taker ( El proceso de fiscalización se efectuará dentro de las 24 a 48 hs de subida la documentación a la web) El sistema le indicará como subir la documentación (Póliza con el detalle de las coberturas, nómina, comprobante de cancelación de la cuota correspondiente)</p>
                    <p>Una vez aprobada Taker asignará los permisos a todos los trabajadores que se encuentren en nómina o bien los que indique el cliente cuando las nóminas sean extensas.</p>
                    <p>Mensualmente deberá realizar el mismo proceso para que las credenciales siempre se encuentren activas.</p>',
            'i6'  => '<h3>Información de costos y procedimientos necesarios para el arranque y continuidad de la obra.</h3>
                        <p>Lo primero que deberá hacer es darse de alta en el formulario web que corresponda a su condición y luego recibirá usuario y contraseña para comenzar a operar y seguir los pasos anteriormente detallados.</p>
                        <p>Dentro de cada usuario se encuentra un instructivo para utilización del sistema Taker de seguros.</p>',
        ),
		'imagen' => 'accidentes-laboral.jpg',
		'link' => $server_url.'taker_ap_barrios',
	),
	3 => array(
		'id' => 4, 
		'titulo' => 'Taker Turismo Aventura',
		'subtitulo' => 'Accidentes Personales',
		'descripcion' => 'Cobertura de accidentes personales para turistas y guías que realizan turismo aventura.',
		'texto' => 'Esta herramienta permite a los distintos usuarios acceder a coberturas de accidentes personales para trabajadores autónomos.
            Esta aplicación está especialmente diseñada para permitir suscribir seguros de forma ágil y sencilla.
            Mediante el sistema Ud. obtiene una clave y contraseña que luego podrá entregar a sus clientes lo que le permitirá agilizar todo tipo de trámite, “olvidarse” de las altas y bajas vía fax o e-mail.',
		'listas' => array(),
		'imagen' => 'accidentes-turismo-aventura.jpg',
		'link' => $server_url.'taker_ap_turismo',
	),
	/*
	4 => array(
		'id' => 5, 
		'titulo' => 'Compulsa onLine',
		'subtitulo' => 'Comparativa de seguros',
		'descripcion' => 'Monitoreo y comparación de tarifas online.',
		'texto' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe, corporis necessitatibus adipisci totam magni pariatur, veniam voluptate fugiat quo delectus sequi iste exercitationem voluptas! Quos modi inventore quasi sit possimus.',
		'listas' => array(
			'i0' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
			'i1' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
			'i2' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
			'i3' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
			'i4' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
			'i5' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
		),
		'imagen' => 'compulsa.jpg',
		'link' => 'compulsa.php',
	),
    */
	/*
	5 => array(
		'id' => 6, 
		'titulo' => 'Transporte de cargas',
		'subtitulo' => 'Seguros de cargas',
		'descripcion' => 'Cobertura de seguro de carga por viaje.',
		'texto' => 'Acceda a coberturas instantáneas de carga por viaje. Como Productor de Seguros o Broker de Seguros con esta herramienta podrá ofrecer a sus clientes, que no cuenten con pólizas propias de transporte de mercaderías, coberturas en forma inmediata y sin límite de días u horarios.',
		'listas' => array(),
		'imagen' => 'transporte.jpg',
		'link' => $server_url.'taker_transporte',
	),
    */

);
if($_SERVER['SERVER_NAME']!="localhost" ){
	//TODO: Activar los subdominios luego de migrar

    //$productos[0]['link']="http://rci.taker.com.ar";
    //$productos[2]['link']="http://ap.taker.com.ar";
    //$productos[3]['link']="http://turismo.taker.com.ar";
    //$productos[5]['link']="http://transporte.taker.com.ar";
}

?>