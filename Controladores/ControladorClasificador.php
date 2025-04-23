<?php

namespace Controladores;

use Modelos\ModeloUsuarios;
use Modelos\ModeloClasificador;
use Controladores\ControladorEmpresa;
use Modelos\ModeloEmpresa;

class ControladorClasificador
{
  public static function ctrCrearClasificador($datos)
  {
    $tabla = 'presupuesto';
    $datoscodigo = $datos['codigo'];
    $datosdescripcion = $datos['descripcion'];
    $codigo = ModeloClasificador::ejecutar_consulta_simple("SELECT Codigo FROM $tabla  WHERE Codigo='$datoscodigo'");
    if ($codigo->rowcount() > 0) {
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
    $descripcion = ModeloClasificador::ejecutar_consulta_simple("SELECT Descripcion FROM $tabla  WHERE Descripcion='$datosdescripcion'");
    if ($descripcion->rowcount() > 0) {
      echo "<script>
				Swal.fire({
						position: 'top-end',
						title: '<p style=color:red;>Nombre del clasificador ya se encuentra registrado<p>',
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'OK'
					})</script>";
      exit();
    }
    $respuesta = ModeloClasificador::mdlNuevoClasificador($tabla, $datos);
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
								window.location = 'clasificadorMef';
							}
							if(window.history.replaceState){
								window.history.replaceState(null,null, window.location.href);
									}
						})</script>";
    }
  }

  public static function ctrMostrarClasificador($item, $valor)
  {
    $tabla = 'presupuesto';
    $respuesta = ModeloClasificador::mdlMostrarClasificador($tabla, $item, $valor);
    return $respuesta;
  }
  public static function ctrMostrarData($tabla)
  {
    $respuesta = ModeloClasificador::mdlMostrarData($tabla);
    return $respuesta;
  }
  // EDITAR USUARIOS|
  public static function ctrEditarClasificador()
  {

    if (isset($_POST["clasificador_editar"])) {

      if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombreCla"])) {

        $tabla = "presupuesto";
        $datos = array(
          "idp" => $_POST["idp"],
          "codigo" => $_POST["editarCodigoCla"],
          "descripcion" => $_POST["editarNombreCla"],
          "id_financiamiento" => $_POST["editarFinanciamiento"]
        );

        $respuesta = ModeloClasificador::mdlEditarClasificador($tabla, $datos);

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
															window.location = 'clasificadorMef';
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
																window.location = 'clasificadorMef';
																}
												})</script>";
        }
      }
    }
  }

  // BORRAR USUARIO
  public static function ctrBorrarClasificador()
  {
    if (isset($_GET['idClasificador'])) {
      $tabla = 'presupuesto';
      $datos = $_GET['idClasificador'];
      $respuesta = ModeloClasificador::mdlBorrarClasificador($tabla, $datos);
      if ($respuesta == 'ok') {
        echo "<script>
                Swal.fire({
                  position: 'top-end',
                  title: '¡El clasificador ha sido eliminado!',
                  text: '...',
                  icon: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',    
                  timer: 3000,  
                timerProgressBar: true, 
              }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                  window.location = 'clasificadorMef';
              }
              });
              </script>";
      } else {
        echo "<script>
              Swal.fire({
                position: 'top-end',
                title: '¡El clasificador tiene registros asociados, no se puede eliminar!',
                text: '...',
                icon: 'warning',
                showCancelButton: false, 
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',   
                timer: 3000, 
                timerProgressBar: true, 
              }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                  window.location = 'clasificadorMef';
              }
              });
            </script>";
      }
    }
  }
}
