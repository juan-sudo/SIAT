<?php

namespace Controladores;

use Modelos\ModeloCarpeta;
use Conect\Conexion;
use PDO;

class ControladorCarpeta
{
  // REGISTRO DE CONTRIBUYENTE



  // MOSTRAR USUARIOS|
  public static function ctrMostrarCarpeta($item, $valor)
  {
   
    $tabla = 'carpeta';
    $respuesta = ModeloCarpeta::mdlMostrarCarpeta($tabla, $item, $valor);
    return $respuesta;
  }

  
  // EDITAR USUARIOS|
  public static function ctrEditarCarpetaProgreso($tabla,$datos)
  {   
   // echo '<pre>';
   // print_r($datos);
   // echo '</pre>';
   // exit;
        $respuesta = ModeloCarpeta::mdlEditarCarpetaProgreso($tabla, $datos);
        
        if ($respuesta == "ok") {
          $respuesta = array(
             "tipo" => 'correcto',
             "mensaje" => '<div class="alert success">
             <input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
             <span aria-hidden="true" class="letra">×</span>
             </button><p class="inner"><strong class="letra">Exito!</strong> <span class="letra">Se edito con exito al contribuyente</p></div>'
          );
       } else {
          $respuesta = array(
             "tipo" => 'error',
             "mensaje" => '<div class="alert error">
             <input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
             <span aria-hidden="true" class="letra">×</span>
             </button><p class="inner"><strong class="letra">Error!</strong> <span class="letra">Ocurrio un error Comunicate con el Administrador</span></p></div>'
          );
       }
       return $respuesta;
    
  }

}
