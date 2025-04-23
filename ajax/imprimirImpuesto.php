<?php
// Datos a enviar a la API
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorConfiguracion;
use Modelos\ModeloEstadoCuenta;
use Modelos\ModeloCaja;

$tipo_tributo = $_POST['tipo_tributo'];
$propietario_convert = $_POST['propietarios'];
$propietario_convert_2 = explode('-', $propietario_convert);
$propietarios_ = implode(',', $propietario_convert_2);
$id_cuenta = $_POST['id_cuenta'];

$propietarios = ModeloEstadoCuenta::mdlPropietarios_pdf($propietarios_);
$configuracion = ControladorConfiguracion::ctrConfiguracion();
$cuenta = ModeloCaja::ctrCuenta_caja_pdf($id_cuenta);
$datos = array(
    'tipo_tributo'=>$tipo_tributo,
    'configuracion' => $configuracion,
    'propietarios' => $propietarios,
    'cuenta' => $cuenta
);
$url_api = 'http://172.16.0.13/cliente/imprimirBoletaA5.php'; // Reemplaza con la URL de tu script PHP
//$url_api = 'http://192.168.1.2/cliente/imprimirBoletaA5.php'; 
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
