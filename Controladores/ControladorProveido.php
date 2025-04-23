<?php
namespace Controladores;

use Modelos\ModeloProveido;
class ControladorProveido
{
  public static function ctrMostrarProveido($area,$fecha)
  {
    $respuesta = ModeloProveido::mdlMostrarProveido($area,$fecha);
    return $respuesta;
  }
  public static function ctrMostrarUltimoProveido($area)
  {
    $respuesta = ModeloProveido::mdlMostrarUltimoProveido($area);
    return $respuesta;
  }                                                   
  public static function ctrCrearProveido($datos)
  {
   
    $respuesta = ModeloProveido::mdlNuevoProveido($datos);
    
    if ($respuesta == "ok") {
      $respuesta = array(
        'tipo' => 'correcto',
        'mensaje' => '<div class="alert success">
        <input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
        <span aria-hidden="true" class="letra">×</span>
        </button><p class="inner"><strong class="letra">Exito!</strong> 
        <span class="letra">Se Registro los datos del proveido de forma Correcta</span></p></div>'
      );
      return $respuesta;
    } else {
      $respuesta = array(
        'tipo' => 'advertencia',
        'mensaje' => '<div class="alert warning">
        <input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
        <span aria-hidden="true" class="letra">×</span>
        </button><p class="inner"><strong class="letra">Exito!</strong> 
        <span class="letra">Algo salio mal comunicate con el Administrador</span></p></div>'
      );
      return $respuesta;
    }
  }

  public static function ctrCrearProveido_editar($datos)
  {
   
    $respuesta = ModeloProveido::mdlNuevoProveido_editar($datos);
  
      if ($respuesta == "ok") {
        $respuesta = array(
          'tipo' => 'correcto',
          'mensaje' => '<div class="alert success">
          <input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
          <span aria-hidden="true" class="letra">×</span>
          </button><p class="inner"><strong class="letra">Exito!</strong> 
          <span class="letra">Se modifico los datos del proveido de forma Correcta</span></p></div>'
        );
        return $respuesta;
      } else {
        $respuesta = array(
          'tipo' => 'advertencia',
          'mensaje' => '<div class="alert warning">
          <input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
          <span aria-hidden="true" class="letra">×</span>
          </button><p class="inner"><strong class="letra">Exito!</strong> 
          <span class="letra">Algo salio mal comunicate con el Administrador</span></p></div>'
        );
        return $respuesta;
      }
    
  }
  public static function ctrMostrarProveidosDeEspecie($datos)
  {
    $respuesta = ModeloProveido::mdlMostrarProveidosPiso($datos);
    return $respuesta;
  }
  public static function ctrMostrar_detalle_pago($numero_proveido,$area)
  {
    $respuesta = ModeloProveido::mdlMostrar_detalle_pago($numero_proveido,$area);
    return $respuesta;
  }
  public static function ctrEditarProveido($datos)
  {
    $tabla = 'proveido';
    $respuesta = ModeloProveido::mdlEditarProveido($tabla, $datos);
    if ($respuesta == 'ok') {
      echo "<script>
        Swal.fire({
            position: 'top-end',
            title: '¡Proveido Modificado exitosamente!',
            icon: 'success',
            showConfirmButton: false, 
            timer: 1500
        })
      </script>";
    }
  }
  public static function ctrEliminarrProveido($datos)
  {
    $tabla = 'proveido';
    $respuesta = ModeloProveido::mdlEliminarProveido($tabla, $datos);
    if ($respuesta == 'ok') {
      echo "<script>
        Swal.fire({
          position: 'top-end',
          title: '¡Proveido Eliminado exitosamente!',
          icon: 'success',
          showConfirmButton: false, 
          timer: 1500
        })
      </script>";
    }
  }
}
