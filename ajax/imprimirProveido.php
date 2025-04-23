<?php
// Datos a enviar a la API
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorConfiguracion;
use Modelos\ModeloCaja;


$id_proveido=$_POST['id_proveido'];
$configuracion = ControladorConfiguracion::ctrConfiguracion();
$proveido = ModeloCaja::ctrProveido_caja_pdf($id_proveido);

$datos = array(
    'id_proveido'=>$id_proveido,
    'configuracion' => $configuracion,
    'proveido' => $proveido

);

$url_api = 'http://172.16.0.13/cliente/imprimirBoletaProveido.php'; // Reemplaza con la URL de tu script PHP
//$url_api = 'http://192.168.1.2/cliente/imprimirBoletaProveido.php'; 
$ch = curl_init($url_api);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($datos));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$resultado = curl_exec($ch);

if(curl_errno($ch)){
    echo 'Error al hacer la solicitud a la API: ' . curl_error($ch);
}

curl_close($ch);

echo $resultado;
?>
