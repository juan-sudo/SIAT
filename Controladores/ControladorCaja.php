<?php

namespace Controladores;

use Modelos\ModeloCaja;
use Conect\Conexion;

class ControladorCaja
{
	// MOSTRAR EL IMPUESTO A PAGAR
	public static function ctrMostrar_n_recibo()
	{
		$respuesta = ModeloCaja::mdlMostrar_nrecibo();
		return $respuesta;
	}
	public static function ctrReimprimir($numero_recibo,$tipo)
	{
		$respuesta = ModeloCaja::mdlReimprimir($numero_recibo,$tipo);
		return $respuesta;
	}
	// MOSTRAR EL IMPUESTO A PAGAR
	public static function ctrLista_Proveidos($datos)
	{
		$respuesta = ModeloCaja::mdlLista_Proveidos($datos);

		if (!empty($respuesta)) {
			foreach ($respuesta as $proveido) {
				echo '<tr n_proveido="' . $proveido['numero_proveido'] . '" total_proveido="' . $proveido['valor_total'] . '" idproveido="' . $proveido['idproveido'] . '">
						<td style="width:80px;" class="text-center">' . $proveido['numero_proveido'] . '</td>
						<td style="width:100px;">' . $proveido['nombre_area'] . '</td>
						<td style="width:250px;">' . $proveido['nombre_especie'] . '</td>
						<td style="width:150px;">' . $proveido['nombres'] . '</td>
						<td style="width:80px;" class="text-center">' . number_format($proveido['valor_total'] / $proveido['cantidad'], 2) . '</td>
						
						<td style="width:80px;" class="text-center">' . $proveido['cantidad'] . '</td>
						<td style="width:80px;" class="text-center">' . $proveido['valor_total'] . '</td>
					  </tr>';
			}
		} else {
			echo '<tr>
					<td colspan="7" class="text-center">No hay registros disponibles de proveidos</td>
				  </tr>';
		}
	}

	public static function ctrExtornar($datos)
	{
		$respuesta = ModeloCaja::mdlExtornar($datos);

		if ($respuesta == 'ok') {
			$respuesta = array(
				"tipo" => 'correcto',
				"mensaje" => '<div class="alert success">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
				<span aria-hidden="true" class="letra">×</span>
				</button><p class="inner"><strong class="letra">Exito!</strong> <span class="letra">Se realizo el Extorno del N° Recibo '.$datos['numero_caja'].'</span></p></div>'
			);
			return $respuesta;
		} else {
			$respuesta = array(
				'tipo' => 'error',
				'mensaje' =>'<div class="alert error">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
				<span aria-hidden="true" class="letra_error">×</span>
				</button><p class="inner"><strong class="letra_error">Error!</strong> <span class="letra_error">
				Algo salio mal Comunicarce con el Administrador de Sistemas</span></p></div>'
			);
			return $respuesta;
		}
	}
	// tipo papel
	public static function ctrTipo_papel()
	{
		$respuesta = ModeloCaja::mdlTipo_papel();
		return $respuesta;
	}
	// Registro de Ingresos tributos y arbitrios
	public static function ctrRegistro_ingresos($datos)
	{
		$respuesta = ModeloCaja::mdlRegistro_ingresos($datos);
		if ($respuesta == 'ok') {
			$respuesta = array(
				"tipo" => "correcto",
				"mensaje" => '<div class="col-sm-30">
					<div class="alert alert-success">
					  <button type="button" class="close font__size-18" data-dismiss="alert">
					  </button>
					  <i class="start-icon far fa-check-circle faa-tada animated"></i>
					  <strong class="font__weight-semibold">Alerta!</strong>Se cancelo correctamente.
					</div>
				  </div>'
			);
			return $respuesta;
		} else {
			$respuesta = array(
				'tipo' => 'advertencia',
				'mensaje' => '<div class="col-sm-30">
					<div class="alert alert-warning">
					  <button type="button" class="close font__size-18" data-dismiss="alert">
					  </button>
					  <i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>
					  <strong class="font__weight-semibold">Alerta!</strong>Algo salio mal comunicarce con el Administrador.
					</div>
				  </div>'
			);
			return $respuesta;
		}
	}

	// Registro de Ingresos agua
	public static function ctrRegistro_ingresos_agua($datos)
	{
		$respuesta = ModeloCaja::mdlRegistro_ingresos_agua($datos);
		if ($respuesta == 'ok') {
			$respuesta = array(
				"tipo" => "correcto",
				"mensaje" => '<div class="col-sm-30">
					 <div class="alert alert-success">
					   <button type="button" class="close font__size-18" data-dismiss="alert">
					   </button>
					   <i class="start-icon far fa-check-circle faa-tada animated"></i>
					   <strong class="font__weight-semibold">Alerta!</strong>Se cancelo correctamente.
					 </div>
				   </div>'
			);
			return $respuesta;
		} else {
			$respuesta = array(
				'tipo' => 'advertencia',
				'mensaje' => '<div class="col-sm-30">
					 <div class="alert alert-warning">
					   <button type="button" class="close font__size-18" data-dismiss="alert">
					   </button>
					   <i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>
					   <strong class="font__weight-semibold">Alerta!</strong>Algo salio mal, comunicarce con el Administrador.
					 </div>
				   </div>'
			);
			return $respuesta;
		}
	}

	// Registro de Ingresos de proveidos
	public static function ctrRegistro_ingresos_proveidos($datos)
	{
		$respuesta = ModeloCaja::mdlRegistro_ingresos_proveido($datos);
		if ($respuesta == 'ok') {
			$respuesta = array(
				"tipo" => "correcto",
				"mensaje" => '<div class="col-sm-30">
					 <div class="alert alert-success">
					   <button type="button" class="close font__size-18" data-dismiss="alert">
					   </button>
					   <i class="start-icon far fa-check-circle faa-tada animated"></i>
					   <strong class="font__weight-semibold">Alerta!</strong>Se cancelo correctamente el proveido.
					 </div>
				   </div>'
			);
			return $respuesta;
		} else {
			$respuesta = array(
				'tipo' => 'advertencia',
				'mensaje' => '<div class="col-sm-30">
					 <div class="alert alert-warning">
					   <button type="button" class="close font__size-18" data-dismiss="alert">
					   </button>
					   <i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>
					   <strong class="font__weight-semibold">Alerta!</strong>Algo salio mal, comunicarce con el Administrador.
					 </div>
				   </div>'
			);
			return $respuesta;
		}
	}
}
