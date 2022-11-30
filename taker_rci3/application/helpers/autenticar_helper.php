<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

function salir($rol='')
{
	if ($rol=='beneficiario')
	{
		redirect("acceso/logout/beneficiario");
	}
	else
	{
		redirect("acceso/logout");
	}
}

function getUser_id() {
	$CI =& get_instance();
	return $CI->autenticar->getUser_id();
}

//beneficiario
function getCertificado_id()
{
	$CI =& get_instance();
	return $CI->autenticar->getCertificado_id();
}

function get_id_certificado()
{
	$CI =& get_instance();
	return $CI->autenticar->get_id_certificado();
}

function getPerms()
{
	$CI =& get_instance();
	return $CI->autenticar->getPerms();
}

function havePerm($permiso)
{
	$CI =& get_instance();
	return $CI->autenticar->havePerm($permiso);
}

function getNombre()
{
	$CI =& get_instance();
	return $CI->autenticar->getnombre();
}

function usuario_casa_de_cambio()
{
	$CI =& get_instance();
	return $CI->autenticar->usuario_casa_de_cambio();
}
function usuario_facturacion()
{
    $CI =& get_instance();
    return $CI->autenticar->usuario_facturacion();
}