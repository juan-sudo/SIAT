<?php

namespace Controladores;

use Modelos\ModeloViascalles;
use Modelos\ModeloClasificador;
use Controladores\ControladorEmpresa;
use Modelos\ModeloEmpresa;

class ControladorViascalles
{
	public static function ctrMostrarDireccion_edicontri($item, $valor)
	{
		$tabla = "ubica_via_urbano";
		$via = ModeloViascalles::mdlMostrarViascalles_edicontri($tabla, $item, $valor);
		return $via;
	}

	public static function ctrMostrarDireccion_edicontri2($item, $valor)
	{
		$via = ModeloViascalles::mdlMostrarViascalles_edicontri2($item, $valor);
		return $via;
	}

	public static function ctrMostrarViasEditarPredio($datos)
	{
		$via = ModeloViascalles::mdlMostrarViascalles_edipredio($datos);
		return $via;
	}

	public static function ctrMostrarViasEditarPredior($datos)
	{
		$via = ModeloViascalles::mdlMostrarPredioRustico($datos);
		return $via;
	}

	public static function ctrCrearViascalles($datos)
	{
		$tabla = 'direccion';
		$datoscodigo = $datos['nombre_direccion'];
		$codigo = ModeloViascalles::ejecutar_consulta_simple("SELECT Nombre FROM $tabla  WHERE Nombre='$datoscodigo'");
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
		$respuesta = ModeloViascalles::mdlNuevoViascalles($tabla, $datos);
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
								window.location = 'viascalles';
							}
							if(window.history.replaceState){
									window.history.replaceState(null,null, window.location.href);
									}
						})</script>";
		}
	}

	public static function ctrMostrarViascalles($item, $valor)
	{
		$tabla = 'direccion';
		$respuesta = ModeloViascalles::mdlMostrarViascalles($tabla, $item, $valor);

		if ($respuesta != 'nulo') {
			return $respuesta;
		} else {
		return 'vacio';	
		}
	}

	public static function ctrMostrarData($tabla)
	{
		$respuesta = ModeloClasificador::mdlMostrarData($tabla);
		return $respuesta;
	}

	public static function ctrEditarClasificador()
	{
		if (isset($_POST["editarCodigo"])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])) {
				$tabla = "presupuesto";
				$datos = array(
					"idp" => $_POST["idp"],
					"codigo" => $_POST["editarCodigo"],
					"descripcion" => $_POST["editarNombre"],
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
										window.location = 'usuarios';
										}
								})</script>";
				}
			}
		}
	}
	public static function ctrBorrarViascalles()
	{
		if (isset($_GET['idDireccion'])) {
			$tabla = 'ubica_via_urbano';
			$datos = $_GET['usuario'];
			$respuesta = ModeloViascalles::mdlBorrarViascalles($tabla, $datos);
			if ($respuesta == 'ok') {
				echo "<script>
							Swal.fire({
										position: 'top-end',
							title: '¡La via ha sido eliminado!',
							text: '...',
							icon: 'success',
							showCancelButton: false,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: 'Cerrar'
							}).then((result) => {
							if (result.isConfirmed) {
							window.location = 'viascalles';
							}
						})
					</script>";
			} else {
				echo "<script>
										Swal.fire({
												position: 'top-end',
												title: '¡La via tiene registros asociados, no se puede eliminar!',
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
	public static function ctrListarViascalles()
	{
		$respuesta = ModeloViascalles::mdlListarViascalles();
		echo $respuesta;
	}
	public static function ctrListarViascallesPredio()
	{
		$respuesta = ModeloViascalles::mdlListarViascallesPredio();
		echo $respuesta;
	}
	public static function ctrMostrarSubVias($datos)
	{
		$respuesta = ModeloViascalles::mdlMostrarSubVias($datos);
		return $respuesta;
	}
	public static function ctrRegistrarCuadras($datos)
	{
		$respuesta = ModeloViascalles::mdlRegistrarCuadras($datos);
		return $respuesta;
	}
	public static function ctrRegistrarArancelVias($datos)
	{
		$respuesta = ModeloViascalles::mdlRegistrarArancelVias($datos);
		return $respuesta;
	}
	public static function ctrMostrarUbicaVia($datos)
	{
		$respuesta = ModeloViascalles::mdlMostrarUbicaVia($datos);
		return $respuesta;
	}
	public static function ctrMostrarUbicaViaAracel($datos)
	{
		$respuesta = ModeloViascalles::mdlMostrarUbicaViaArancel($datos);
		return $respuesta;
	}
	public static function ctrMostrarArancelYear($datos)
	{
		$respuesta = ModeloViascalles::mdlMostrarArancelAnio($datos);
		return $respuesta;
	}
	public static function ctrMostrarArancelVia($datos)
	{
		$respuesta = ModeloViascalles::mdlMostrarArancelVia($datos);
		return $respuesta;
	}
	public static function ctrEditarArancelViaEdit($datos)
	{		
		$respuesta = ModeloViascalles::mdlEditarArancelVia($datos);
		  if ($respuesta == 'ok') {
     	$respuesta = array(
					"tipo" => "correcto",
					"mensaje" => '<div class="col-sm-30">
																	<div class="alert alert-success">
																			<button type="button" class="close font__size-18" data-dismiss="alert">
																			</button>
																			<i class="start-icon far fa-check-circle faa-tada animated"></i>
																			<strong class="font__weight-semibold">Alerta!</strong>Se Modifico correctamente.
																	</div>
				  					</div>'
				);
        return $respuesta;
    }
	}

}
