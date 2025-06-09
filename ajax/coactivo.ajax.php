<?php
session_start();
require_once "../vendor/autoload.php";

//use Controladores\ControladorEstadoCuenta;
use Controladores\ControladorCoactivo;
class AjaxReporte
{
   
    // Mostrar estado cuenta en el modulo de caja
    public function ajaxMostrar_lista_coactivo()
    {
      $fechaInicio=$_POST['fecha_inicio'];
      $fechaFin=$_POST['fecha_fin'];

       $datos = array(
        "fecha_inicio" => $fechaInicio,
        "fecha_fin" => $fechaFin
    );

      $respuesta = ControladorCoactivo::ctrMostrar_lista_coactivo($datos);
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;    
    }



}
// estado cuenta caja - modulo caja


// extorno - modulo caja
if (isset($_POST['lista_coactivo'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_lista_coactivo();
}

