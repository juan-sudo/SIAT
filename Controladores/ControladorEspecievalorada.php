<?php

namespace Controladores;

use Modelos\ModeloEspecievalorada;

class ControladorEspecievalorada
{
  // REGISTRO DE USUARIO
  public static function ctrCrearEspecievalorada($datos)
  {
    $tabla = 'especie_valorada';
    $nombre = $datos['Nombre_Especie'];
    $checknombre = ModeloEspecievalorada::ejecutar_consulta_simple("SELECT Nombre_Especie FROM $tabla  WHERE Nombre_Especie='$nombre'");
    if ($checknombre->rowcount() > 0) {
      echo "<script>
                Swal.fire({
                    position: 'top-end',
                    title: '<p style=color:red;>ya se encuentra registrado<p>',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK'
                })</script>";
      exit();
    }
    $respuesta = ModeloEspecievalorada::mdlNuevoEspecievalorada($tabla, $datos);
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
                    window.location = 'especiesvaloradas';
                    }
                    if(window.history.replaceState){
                        window.history.replaceState(null,null, window.location.href);
                        }
                    })</script>";
    }
  }
  // MOSTRAR USUARIOS|
  public static function ctrMostrarEspecievalorada($item, $valor)
  {

    $tabla = 'especie_valorada';
    $respuesta = ModeloEspecievalorada::mdlMostrarEspecievalorada($tabla, $item, $valor);
    return $respuesta;
  }
  public static function ctrMostrarEspecievalorada_multa()
  {
    $respuesta = ModeloEspecievalorada::mdlMostrarEspecievalorada_multa();
    return $respuesta;
  }
  public static function ctrMostrarData($tabla)
  {
    $respuesta = ModeloEspecievalorada::mdlMostrarData($tabla);
    return $respuesta;
  }

  // EDITAR USUARIOS|
  public static function ctrEditarEspecievalorada()
  {

    if (isset($_POST["editar_especie"])) {

      if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nombre_especieEdit"])) {
        $tabla = "especie_valorada";
        $datos = array(
          'Id_Especie_Valorada' => $_POST["idEsp"],
          'Monto' => $_POST["monto_especieEdit"],
          'Id_Area' => $_POST["id_areaEdit"],
          'Id_Presupuesto' => $_POST["id_presupuestoEdit"],
          'Id_Instrumento_Gestion' => $_POST["id_instrumentoEdit"],
          'Detalle' => $_POST["detalle_instrumentoEdit"],
          'Nombre_Especie' => $_POST["nombre_especieEdit"],
          'Numero_Pagina' => $_POST["numPaginaEdit"],
          'requisito' => $_POST["requisitosEdit"]
        );

        $respuesta = ModeloEspecievalorada::mdlEditarEspecievalorada($tabla, $datos);

        if ($respuesta == "ok") {

          echo "<script>
                Swal.fire({
                    position: 'top-end',
                    title: '¡Especie se actualizo correctamente!',
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location = 'especiesvaloradas';
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
                    window.location = 'especiesvaloradas';
                    }
                })</script>";
        }
      }
    }
  }

  // BORRAR USUARIO
  public static function ctrBorrarEspecievalorada()
  {
    if (isset($_GET['idUsuario'])) {
      $tabla = 'especie_valorada';
      $datos = $_GET['idUsuario'];
      $respuesta = ModeloEspecievalorada::mdlBorrarEspecievalorada($tabla, $datos);
      if ($respuesta == 'ok') {
        echo "<script>
                        Swal.fire({
                        position: 'top-end',
                        title: '¡La especie valorada ha sido eliminado!',
                        text: '...',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Cerrar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                        window.location = 'especiesvaloradas';
                        }
                    })
                    </script>";
      } else {
        echo "<script>
              Swal.fire({
                position: 'top-end',
                title: '¡La especie valorada tiene registros asociados, no se puede eliminar!',
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
}
