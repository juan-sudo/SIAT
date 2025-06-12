<?php
session_start();
require_once "../vendor/autoload.php";

//use Controladores\ControladorEstadoCuenta;
use Controladores\ControladorReporteGeneral;
class AjaxReporte
{
    // Mostrar estado cuenta en el modulo de caja
    public function ajaxMostrar_reporte_carpeta_total()
    {
     

      $respuesta = ControladorReporteGeneral::ctrMostrar_reporte_carpeta_total();
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;    
    }

   

     // Mostrar estado cuenta en el modulo de caja
    public function ajaxMostrar_reporte_general()
    {
      $respuesta = ControladorReporteGeneral::ctrMostrar_reporte_general();
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;    
    }

       // Mostrar estado cuenta en el modulo de caja
    public function ajaxMostrar_reporte_contribuyente_total()
    {
      $respuesta = ControladorReporteGeneral::ctrMostrar_reporte_contribuyente_total();
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;    
    }

     public function ajaxMostrar_reporte_predios_total()
    {
      $respuesta = ControladorReporteGeneral::ctrMostrar_reporte_predios_total();
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;    
    }

      public function ajaxMostrar_reporte_predios_total_u()
    {
      $respuesta = ControladorReporteGeneral::ctrMostrar_reporte_predios_total_u();
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;    
    }

      public function ajaxMostrar_reporte_predios_total_r()
    {
      $respuesta = ControladorReporteGeneral::ctrMostrar_reporte_predios_total_r();
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;    
    }
      public function ajaxMostrar_reporte_licencias_total()
    {
      $respuesta = ControladorReporteGeneral::ctrMostrar_reporte_licencias_total();
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;    
    }


     public function ajaxMostrar_reporte_estadistico_agua()
    {
      $respuesta = ControladorReporteGeneral::ctrMostrar_reporte_estadistico_licencias();
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;    
    }

      public function ajaxMostrar_reporte_ultima_carpeta()
    {
      $respuesta = ControladorReporteGeneral::ctrMostrar_reporte_ultima_carpeta();
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;    
    }

       public function ajaxMostrar_reporte_ultima_contribuyente()
    {
      $respuesta = ControladorReporteGeneral::ctrMostrar_reporte_ultima_contribuyente();
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;    
    }

       public function ajaxMostrar_reporte_total_fallecidas()
    {
      $respuesta = ControladorReporteGeneral::ctrMostrar_reporte_total_fallecidas();
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;    
    }

   public function ajaxMostrar_reporte_ultima_licencia()
    {
      $respuesta = ControladorReporteGeneral::ctrMostrar_reporte_licencias_ultimo();
      $respuesta_json = json_encode($respuesta);
      header('Content-Type: application/json');
      echo $respuesta_json;    
    }

    

    
    

}
// estado cuenta caja - modulo caja



// ARBITRIO MUNICIPAL
if (isset($_POST['reporte_general'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_reporte_general();
}


// TOTAL DE CARPETAS
if (isset($_POST['reporte_carpeta_total'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_reporte_carpeta_total();
}


// TOTAL DE CONTRIBUYENTES
if (isset($_POST['reporte_contribuyente_total'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_reporte_contribuyente_total();
}

// TOTAL DE PREDIOS
if (isset($_POST['reporte_predios_total'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_reporte_predios_total();
}

// TOTAL DE PREDIOS URBANOS
if (isset($_POST['reporte_predios_total_u'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_reporte_predios_total_u();
}
// TOTAL DE PREDIOS RUSTICO
if (isset($_POST['reporte_predios_total_r'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_reporte_predios_total_r();
}

// TOTAL DE LICENCIAS
if (isset($_POST['reporte_licencias_total'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_reporte_licencias_total();
}


// TOTAL DE LICENCIAS
if (isset($_POST['reporte_general_agua'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_reporte_estadistico_agua();

}
// ULTIMA CARPETA
if (isset($_POST['reporte_ultima_carpeta'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_reporte_ultima_carpeta();

}

// ULTIMA CONTRIBUYENTE
if (isset($_POST['reporte_ultima_contribuyente'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_reporte_ultima_contribuyente();

}


//TOTAL FALLECIDOS
if (isset($_POST['reporte_total_fallecidas'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_reporte_total_fallecidas();

}

//ULTIMA LICENCIA
if (isset($_POST['reporte_total_ultima_licencia'])) {
  $mostrar_cuadre = new AjaxReporte();
  $mostrar_cuadre->ajaxMostrar_reporte_ultima_licencia();

}








