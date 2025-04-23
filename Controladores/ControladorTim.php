<?php

namespace Controladores;

use Modelos\ModeloTim;

class ControladorTim
{
  // MOSTRAR TIM --------------------------------------
  public static function ctrMostrarTim($item, $valor)
  {
    $tabla = 'tim';
    $respuesta = ModeloTim::mdlMostrarTim($tabla, $item, $valor);
    return $respuesta;
  }
  // REGISTRO TIM ------------------------------------
  public static function ctrCrearTim($datos)
  {
    $tabla = 'tim';
    $anio = $datos['anio'];
    $chexkanio = ModeloTim::ejecutar_consulta_simple("SELECT Anio FROM $tabla WHERE Anio='$anio'");
    if ($chexkanio->rowCount() > 0) {
      echo "
      <script>
        Swal.fire({
        position: 'top-end',
        title: '<p style=color:red;>La Tasa ya se encuentra registrado<p>',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
        })
      </script>";
      exit();
    }
    $respuesta = ModeloTim::mdlNuevoTim($tabla, $datos);
    if ($respuesta == 'ok') {
      echo "<script>
      Swal.fire({
        position: 'top-end',
        title: '¡Se registro exitosamente!',
        icon: 'success',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
        }).then((result) => {
          if (result.isConfirmed) {
              window.location = 'tasaInteresMoratorio';
              }
              if(window.history.replaceState){
              window.history.replaceState(null,null, window.location.href);
              }
        })</script>";
    }
  }
  // EDITAR
  public static function ctrEditarTim()
  {
    if (isset($_POST["editar_tim"])) {
      if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editar_tim"])) {
        $tabla = "tim";
        $datos = array(
          'Id_TIM' => $_POST["ide"],
          'Porcentaje' => $_POST["editar_tim"],
        );
        $respuesta = ModeloTim::mdlEditarTim($tabla, $datos);
        if ($respuesta == "ok") {
          echo "<script>
                      Swal.fire({
                          position: 'top-end',
                          title: '¡Se actualizo correctamente!',
                          icon: 'success',
                          showCancelButton: false,
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: 'OK'
                      }).then((result) => {
                          if (result.isConfirmed) {
                          window.location = 'tasaInteresMoratorio';
                          }
                          if(window.history.replaceState){
                              window.history.replaceState(null,null, window.location.href);
                              }
                  })</script>";
        } else {

          echo "<script>
              Swal.fire({
                  title: '¡El campo no puede ir vacío o llevar caracteres especiales!',
                  text: '...',
                  icon: 'error',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Cerrar'
              }).then((result) => {
                  if (result.isConfirmed) {
                  window.location = 'tasaInteresMoratorio';
                  }
              })</script>";
        }
      }
    }
  }
  // BORRAR
  public static function ctrBorrarTim()
  {
    if (isset($_GET['idUsuario'])) {
      $tabla = 'tim';
      $datos = $_GET['idUsuario'];
      $respuesta = ModeloTim::mdlBorrarTim($tabla, $datos);
      if ($respuesta == 'ok') {
        echo "<script>
              Swal.fire({
              position: 'top-end',
              title: '¡La tasa ha sido eliminado!',
              text: '....exito',
              icon: 'success',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Cerrar'
              }).then((result) => {
              if (result.isConfirmed) {
              window.location = 'tasaInteresMoratorio';
              }
          })
          </script>";
      }
    }
  }

  public static function ctrEstadoCuentaTim($idContribuyente_tim)
  {
     $respuesta = ModeloTim::mdlMostrarEstadoCuenta($idContribuyente_tim);
     return $respuesta;
  }
  public static function ctrCalculartimpoanio($idContribuyente_tim)
  {
     $respuesta = ModeloTim::mdlCalcularTimporanio($idContribuyente_tim);
     return $respuesta;
  }
}
