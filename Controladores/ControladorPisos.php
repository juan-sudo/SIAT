<?php

namespace Controladores;

use Modelos\ModeloPisos;

class ControladorPisos
{
	// REGISTRO DE CONTRIBUYENTE
	public static function ctrCrearPiso($datos)
	{
		$tabla = 'pisos';
		$respuesta = ModeloPisos::mdlNuevoPiso($tabla, $datos);
		if ($respuesta == 'ok') {
			$respuesta = array(
				"tipo" => "correcto",
				"mensaje" => '<div class="alert success">
			    <input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
		        <span aria-hidden="true" class="letra">×</span>
	            </button><p class="inner"><strong class="letra">Exito!</strong> <span class="letra">Se registro el piso de forma correcta</span></p></div>'
			);
			return $respuesta;
		} else {
			$respuesta = array(
				'tipo' => 'advertencia',
				'mensaje' => '<div class="alert error">
			    <input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
		        <span aria-hidden="true" class="letra_error">×</span>
	            </button><p class="inner"><strong class="letra_error">Error!</strong> <span class="letra_error">Algo salio mal comunicate con el Administrador</span></p></div>'
			);
			return $respuesta;
		}
	}
	public static function ctrModificarPiso($datos)
	{
  $respuesta = ModeloPisos::mdlModificarPiso($datos);
		if ($respuesta == 'ok') {
			$respuesta = array(
				"tipo" => "correcto",
				"mensaje" => "<div class='alert alert-success' role='alert'>Piso modificado con exito</div>"
			);
			return $respuesta;
		} else {
			$respuesta = array(
				'tipo' => 'advertencia',
				'mensaje' => '<div class="alert alert-danger" role="alert">Algo Salio Mal Comunica con el adminstrador</div>'
			);
			return $respuesta;
		}
	}
 public static function ctrEliminarPiso($datos)
 {
  $respuesta = ModeloPisos::mdlEliminarPiso($datos);
  if ($respuesta == 'ok') {
			$respuesta = array(
				"tipo" => "correcto",
				"mensaje" => "<div class='alert alert-success' role='alert'>Piso Elimado con Exito</div>"
			);
			return $respuesta;
   
		} else {
			$respuesta = array(
				'tipo' => 'advertencia',
				'mensaje' => '<div class="alert alert-danger" role="alert">Algo Salio Mal Comunica con el adminstrador</div>'
			);
			return $respuesta;
		}
 }
	public static function ctrMostrarValoresUnitarios($tabla, $anio)
	{
		$respuesta = ModeloPisos::mdlMostrarCategorias($tabla, $anio);
		return $respuesta;
	}
	public static function ctrMostrarValoresEdficacion($tabla, $datos)
	{
		$respuesta = ModeloPisos::mdlMostrarValorEdificacion($tabla, $datos);
		return $respuesta;
	}
	public static function ctrMostrarTasaDepresiacion($datos)
	{
		$tabla = 'depreciacion';
		$respuesta = ModeloPisos::mdlMostrarTasaDepreciacion($tabla, $datos);
		return $respuesta;
	}
	public static function ctrMostrarPisosDelPredio($datos)
	{
		$respuesta = ModeloPisos::mdlMostrarPisosDelPredio($datos);
		return $respuesta;
	}
	public static function ctrTraerpiso($datos)
	{
		$tabla = "pisos";
		$pisoRespuesta = ModeloPisos::mdlMostrarPiso($tabla, $datos);
		return $pisoRespuesta;
	}
}
