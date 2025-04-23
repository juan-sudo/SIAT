<?php

namespace Controladores;

use Modelos\ModeloDireccion;

class ControladorDireccion
{
  public static function ctrCrearDireccion($datos)
  {
    $tabla = 'direccion';
    $respuesta = ModeloDireccion::mdlNuevaDireccion($tabla, $datos);
    if ($respuesta == 'ok') {
      echo "<script>
          Swal.fire({
            position: 'top-end',
            title: '¡ Direccion se registro exitosamente!',
            icon: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK'
            }).then((result) => {    
          window.location = 'direccion';      
        if(window.history.replaceState){
      window.history.replaceState(null,null, window.location.href);
      }  
    })</script>";
    } else {
      echo "error al insertar";
    }
  }
  // REGISTRAR DATOS PARA LA DIRECCION
  public static function ctrMostrarDatos($tabla)
  {
    $respuesta = ModeloDireccion::mdlMostrarData($tabla);
    return $respuesta;
  }

  public static function ctrMostrarDatos_via_calle()
  {
    $respuesta = ModeloDireccion::mdlMostrarData_via_calle();
    return $respuesta;
  }
  // MOSTRAR LAS DIRECCIONES
  public static function ctrMostrarDirecciones($item, $valor)
  {
    $tabla = 'direccion';
    $respuesta = ModeloDireccion::mdlMostrarDireccion($tabla, $item, $valor);
    return $respuesta;
  }
  // BORRAR
  public static function ctrBorrarDireccion()
  {
    if (isset($_GET['idDireccion'])) {
      $tabla = 'direccion';
      $datos = $_GET['idDireccion'];
      $respuesta = ModeloDireccion::mdlBorrarDireccion($tabla, $datos);
      if ($respuesta == 'ok') {
        echo "<script>
              Swal.fire({
              position: 'top-end',
              title: '¡La Direccion ha sido eliminado!',
              text: '....exito',
              icon: 'success',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Cerrar'
              }).then((result) => {
              if (result.isConfirmed) {
              window.location = 'direccion';
              }
          })
          </script>";
      } else {
        echo "<script>
              Swal.fire({
                position: 'top-end',
                title: '¡La direccion tiene registros asociados, no se puede eliminar!',
                text: '...',
                icon: 'warning',
                showCancelButton: false, 
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',   
                timer: 3000, 
                timerProgressBar: true, 
              }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
              }
              });
            </script>";
      }
    }
  }
  // EDITAR
  public static function ctrEditarDireccion()
  {
    if (isset($_POST["editar_direc"])) {
      //if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nombreVia_edit"])) {
      $tabla = "direccion";
      $datos = array(
        'Id_Direccion' => $_POST["ide"],
        'Id_Tipo_Via' => $_POST["tipoVia_edit"],
        'Id_Zona' => $_POST["zonaSel_edit"],
        'Id_Nombre_Via' => $_POST["nombreVia_edit"],
      );
      $respuesta = ModeloDireccion::mdlEditarDireccion($tabla, $datos);
      if ($respuesta == "ok") {
        echo "<script>
                      Swal.fire({
                          position: 'top-end',
                          title: '¡La Direccion se actualizo correctamente!',
                          icon: 'success',
                          showCancelButton: false,
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: 'OK'
                      }).then((result) => {
                          if (result.isConfirmed) {
                          window.location = 'direccion';
                          }
                          if(window.history.replaceState){
                              window.history.replaceState(null,null, window.location.href);
                              }
                  })</script>";
      } elseif ($respuesta == "error1") {
        echo "<script>
              Swal.fire({
                position: 'top-end',
                title: '¡La direccion tiene vias/calles, ya no se puede Editar!',
                text: '...',
                icon: 'warning',
                showCancelButton: false, 
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',   
                timer: 3000, 
                timerProgressBar: true, 
              }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
              }
              });
            </script>";
      } else {
        echo "<script>
              Swal.fire({
                  title: '¡Verificar los campos y no se permite caracteres especiales!',
                  text: '...',
                  icon: 'error',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Cerrar'
              }).then((result) => {
                  if (result.isConfirmed) {
                  window.location = 'direccion';
                  }
              })</script>";
      }
      //}
    }
  }
}
