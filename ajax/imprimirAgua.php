<?php
// Datos a enviar a la API
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorConfiguracion;
use Modelos\ModeloEstadoCuenta;


$idlicencia=$_POST['idlicencia'];
$id_cuenta=$_POST['id_cuenta']; 
$estado_cuenta = ModeloEstadoCuenta::mdlEstadoCuenta_agua_pdf($idlicencia,$id_cuenta);
$fila = ModeloEstadoCuenta::mdlPropietario_licencia_pdf($idlicencia);
$configuracion = ControladorConfiguracion::ctrConfiguracion();

$datos = array(
    'idlicencia'=>$idlicencia,
    'id_cuenta' => $id_cuenta,
    'estado_cuenta' => $estado_cuenta,
    'fila' => $fila,
    'configuracion' => $configuracion
);

var_dump($datos);
exit;

//$url_api = 'http://172.16.0.13/cliente/imprimirBoletaAgua.php'; //   CAJA
//$url_api = 'http://192.168.1.3/cliente/imprimirBoletaAgua.php'; // prueba

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
