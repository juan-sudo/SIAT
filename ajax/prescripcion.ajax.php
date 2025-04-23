<?php
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorPrescripcion;

class AjaxPrescripcion
{
    public function registrarPrescripcion()
    {
       date_default_timezone_set("America/Lima");
       $string = $_POST['ids_deudas'];
       $stringSinComillas = trim($string, '"');
       $idDeuda = explode(',', $stringSinComillas);
       $data = array(
       "codigo_prescripcion" => $_POST['codigo_prescripcion'],
       "resolucion_prescripcion" => $_POST['resolucion_prescripcion'],
       "asunto_prescripcion" => $_POST['asunto_prescripcion'],
       "expediente_prescripcion" => $_POST['expediente_prescripcion'],
       "fecha_prescripcion" => date("Y-m-d H:i:s"),
       "direccionIP" => $_SERVER["REMOTE_ADDR"],
       "usuario" => $_SESSION['id']
       );
       $respuesta = ControladorPrescripcion::ctrRegistrarPrescripcion($idDeuda, $data);
       echo json_encode($respuesta);
    }
}

if (isset($_POST['registrar_prescripcion'])) {
    $nuevo = new AjaxPrescripcion();
    $nuevo->registrarPrescripcion();
 }