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
                  "Codigo_Carpeta" => isset($_POST["codigo_carpeta"]) ? $_POST["codigo_carpeta"] : null,
                  "Estado_progreso" => isset($_POST["estado_progreso"]) ? $_POST["estado_progreso"] : null,
                  "completado_oficina" => isset($_POST["completado_oficina"]) ? $_POST["completado_oficina"] : null,
                  "completado_campo" => isset($_POST["completado_campo"]) ? $_POST["completado_campo"] : null,
                  "observacion_progreso" => isset($_POST["observacion_progreso"]) ? $_POST["observacion_progreso"] : null,
                  "observacion_pendiente" => isset($_POST["observacion_pendiente"]) ? $_POST["observacion_pendiente"] : null,
                  "id_usuario" => isset($_POST["id_usuario"]) ? $_POST["id_usuario"] : null,
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



// GUARDAR PROGRESO
if (isset($_POST['guardar_estado_progreso'])) {
   $editar = new AjaxCarpeta();
   $editar->ajaxGuardar_editar_progreso();
}
