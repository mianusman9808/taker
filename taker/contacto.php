<?php 
///ENVIO DE CORREO
$nombre="";
$empresa="";
$correo="";
$provincia="";
$mensaje="";
$telefono="";


if (!empty($_POST['nombre'])){
    $nombre=$_POST['nombre'];
}
if (!empty($_POST['empresa'])){
    $empresa=$_POST['empresa'];
}
if (!empty($_POST['provincia'])){
    $provincia=$_POST['provincia'];
}
if (!empty($_POST['correo'])){
    $correo=$_POST['correo'];
}
if (!empty($_POST['mensaje'])){
    $mensaje=$_POST['mensaje'];
}

if (!empty($_POST['telefono'])){
    $telefono=$_POST['telefono'];
}
$error=false;
$success=false;

if($_POST){
    if($nombre and $mensaje and $provincia and $telefono){
        //OK
        $to      = 'nordelta@taker.com.ar';
        $subject = 'TAKER CONSULTA';
        $message = $nombre
            ."\r\nEmpresa: ".$empresa
            ."\r\nProvincia: ".$provincia
            ."\r\nCorreo: ".$correo
            ."\r\nTelefono: ".$telefono
            ."\r\n\r\n".$mensaje;
            
        $headers = 'From: nordelta@taker.com.ar' . "\r\n" .
        'Reply-To: '.$correo ;

        mail($to, $subject, $message, $headers);
        $success=true;

    }else{
        $error=true;
    }
}

include('inc/header.php');


?>

<?php
// encabezado random
$bg = array('bg1', 'bg2', 'bg3' );
?>

<div class="seccion-encabezado-pg <?php echo $bg[array_rand($bg)]; ?>">
    <div class="container">
        <div class="seccion_body">
            <div class="row">
                <div class="col-md-8">
                    <?php if ($error):?>
                        <div class="alert alert-danger">
                            <h2>Datos incompletos</h2>
                            <p>Completar nombre, teléfono, provincia y correo</p>
                            <p>Luego enviar nuevamenrte</p>
                        </div>
                    <?php elseif($success): ?>
                        <h1 class="seccion_titulo">Recibimos su consulta</h1>
                        <p class="lead">En breve nos comunicaremos con usted. Gracias.</p>
                     <?php else: ?>
                        <h1 class="seccion_titulo">Contacto</h1>
                        <p class="lead">Completar el formulario y en breve nos contactaremos con usted</p>
                    <?php endif; ?>
                </div>
            </div>
       </div>
   </div>
</div>


<?php include('inc/footer.php');?>