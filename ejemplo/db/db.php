<?php
date_default_timezone_set('America/Lima'); 

$fechaActual = date('Y-m-d');
$fechaFormato = date('d/m/Y');
$anioActual = date('Y');
$mesActual = date('m'); 
function fechaActual()
{
	date_default_timezone_set('America/Lima'); 

	return date('Y-m-d');
}
function conectar()
{
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	$host = "localhost";
	$db = "sem";
	$usuario = "root";	
	$pass  = "";
	$conexion = mysqli_connect($host, $usuario, $pass, $db) or die(mysqli_error($conexion));
	$conexion->set_charset("utf8");
	return $conexion;
}
