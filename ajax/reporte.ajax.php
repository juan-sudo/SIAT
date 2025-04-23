<?php
session_start();
require_once "../vendor/autoload.php";

//use Controladores\ControladorEstadoCuenta;
use Controladores\ControladorReporte;
class AjaxReporte
{
    // Mostrar estado cuenta en el modulo de caja
    public function ajaxMostrar_Ingresos_tributosagua()
    {
      $fecha=$_POST['fecha'];
      $respuesta = ControladorReporte::ctrMostrar_ingresos_tributosagua($fecha);
      echo $respuesta;
    }

    // Mostrar estado cuenta en el modulo de caja
    public function ajaxMostrar_lista_extorno()
    {
      $fecha=$_POST['fecha'];
      $respuesta = ControladorReporte::ctrMostrar_lista_extorno($fecha);
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;    
    }
    // Mostrar estado cuenta en el modulo de caja - Especie
    public function ajaxMostrar_Ingresos_especie()
    {
      $fecha=$_POST['fecha_especie'];
      $respuesta = ControladorReporte::ctrMostrar_ingresos_especie($fecha);
      echo $respuesta;
    }
    // Mostrar estado cuenta en el modulo de caja total
    public function ajaxMostrar_Ingresos_tributosagua_total()
    {
      $fecha=$_POST['fecha'];
      $respuesta = ControladorReporte::ctrMostrar_ingresos_tributosagua_total($fecha);
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;    
    }
    public function ajaxMostrar_Ingresos_especie_total()
    {
      $fecha=$_POST['fecha'];
      $respuesta = ControladorReporte::ctrMostrar_ingresos_especie_total($fecha);
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;    
    }
    // Mostrar estado cuenta en el modulo de consolidado reporte
    public function ajaxMostrar_Ingresos_tributosagua_report()
    {
      $fecha=$_POST['fecha'];
      $respuesta = ControladorReporte::ctrMostrar_ingresos_tributosagua_report($fecha);
      echo $respuesta;    
    }
    public function ajaxMostrar_Ingresos_especie_report()
    {
      $fecha=$_POST['fecha'];
      $respuesta = ControladorReporte::ctrMostrar_ingresos_especie_report($fecha);
      echo $respuesta;    
    }
    public function ajaxMostrar_Ingresos_tributosagua_presu()
    {
      $fecha=$_POST['fecha'];
      $respuesta = ControladorReporte::ctrMostrar_ingresos_tributosagua_presu($fecha);
      echo $respuesta;    
    }
    public function ajaxMostrar_Ingresos_especie_area()
    {
      $fecha=$_POST['fecha'];
      $respuesta = ControladorReporte::ctrMostrar_ingresos_especie_area($fecha);
      echo $respuesta;    
    }
    public function ajaxCierre_Ingresos()
    {
      $fecha=$_POST['fecha'];
      $respuesta = ControladorReporte::ctrCierre_Ingresos($fecha);
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;     
    }
    public function ajaxReport_Finan()
    {
      $fecha=$_POST['fecha'];
      $respuesta = ControladorReporte::ctrMostrar_Report_Finan($fecha);
      echo $respuesta;    
    }
    public function ajaxReport_Finan_total()
    {
      $fecha=$_POST['fecha'];
      $respuesta = ControladorReporte::ctrMostrar_Report_Finan_total($fecha);
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;     
    }
    public function ajaxReport_Ingreso_Diario()
    {
      $fecha=$_POST['fechaReporte'];
      $respuesta = ControladorReporte::ctrMostrar_Reporte_Ingreso_Diario($fecha);
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;     
    }
}
// estado cuenta caja - modulo caja
if (isset($_POST['cuadre_tributoagua'])) {
    $mostrar_cuadre = new AjaxReporte();
    $mostrar_cuadre->ajaxMostrar_Ingresos_tributosagua();
}
// extorno - modulo caja
if (isset($_POST['lista_extorno'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_lista_extorno();
}

// estado cuenta caja - modulo caja- especie
if (isset($_POST['cuadre_especie'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_Ingresos_especie();
}

if (isset($_POST['cuadre_tributoagua_total'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_Ingresos_tributosagua_total();
}
if (isset($_POST['cuadre_especie_total'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_Ingresos_especie_total();
}
if (isset($_POST['cuadre_tributoagua_report'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_Ingresos_tributosagua_report();
}
if (isset($_POST['cuadre_especie_report'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_Ingresos_especie_report();
}
if (isset($_POST['cuadre_tributoagua_presu'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_Ingresos_tributosagua_presu();
}
if (isset($_POST['cuadre_especie_area'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_Ingresos_especie_area();
}
if (isset($_POST['cierre_ingresos'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxCierre_Ingresos();
}
if (isset($_POST['report_finan'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxReport_Finan();
}
if (isset($_POST['report_finan_total'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxReport_Finan_total();
}

if (isset($_POST['reporteIngresoDiario'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxReport_Ingreso_Diario();
}