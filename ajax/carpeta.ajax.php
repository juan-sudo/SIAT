<?php
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorCarpeta;

class AjaxCarpeta
{
   //AGREGAR CONTRIBUYENTE
   
   // EDITAR CONTRIBUYENTE
   public $idCarpeta;

   public function ajaxEditarCarpetaProgreso()
   {
      $item = 'Id_Carpeta';
      $valor = $this->idCarpeta;
      $respuesta = ControladorCarpeta::ctrMostrarCarpeta($item, $valor);
      echo json_encode($respuesta);
   }

      // EDITAR PROGRESO
      public function ajaxGuardar_editar_progreso()
      {

     
           // if (preg_match('/^[azAZ09ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["e_apellPaterno"])) {
              $tabla = "carpeta";
              $datos = array(
                "Codigo_Carpeta" => $_POST["codigo_carpeta"],
                "Estado_progreso" => $_POST["estado_progreso"],
                
              );
              $respuesta = ControladorCarpeta::ctrEditarCarpetaProgreso($tabla, $datos);
              $respuesta_json = json_encode($respuesta);
              header('Content-Type: application/json');
              echo $respuesta_json;
             
           // }
          
      }

}

// OBJETO EDITAR DATOS CARPETA--------------------------------------------
if (isset($_POST['idCarpeta'])) {
   $editar = new AjaxCarpeta();
   $editar->idCarpeta = $_POST['idCarpeta'];
   $editar->ajaxEditarCarpetaProgreso();
}

// guardar editar contribuyente
if (isset($_POST['guardar_estado_progreso'])) {
   $editar = new AjaxCarpeta();
   $editar->ajaxGuardar_editar_progreso();
}
