<?php

namespace Controladores;

use Modelos\ModeloReporteGeneral;
use Conect\Conexion;
use PDO;


class ControladorReporteGeneral
{
	public static function ctrMostrar_reporte_general()
	{
		$respuesta = ModeloReporteGeneral::mdlMostrar_reporte_general();

		return $respuesta;
	}

		public static function ctrMostrar_reporte_carpeta_total()
	{
		$respuesta = ModeloReporteGeneral::mdlMostrar_reporte_carpeta_total();

		return $respuesta;
	}

		public static function ctrMostrar_reporte_contribuyente_total()
	{
		$respuesta = ModeloReporteGeneral::mdlMostrar_reporte_contribuyente_total();

		return $respuesta;
	}

		public static function ctrMostrar_reporte_predios_total()
	{
		$respuesta = ModeloReporteGeneral::mdlMostrar_reporte_predio_total();

		return $respuesta;
	}
		public static function ctrMostrar_reporte_predios_total_u()
	{
		$respuesta = ModeloReporteGeneral::mdlMostrar_reporte_predio_total_u();

		return $respuesta;
	}

		public static function ctrMostrar_reporte_predios_total_r()
	{
		$respuesta = ModeloReporteGeneral::mdlMostrar_reporte_predio_total_r();

		return $respuesta;
	}



		public static function ctrMostrar_reporte_licencias_total()
	{
		$respuesta = ModeloReporteGeneral::mdlMostrar_reporte_licencia_total();

		return $respuesta;
	}

	public static function ctrMostrar_reporte_licencias_ultimo()
	{
		$respuesta = ModeloReporteGeneral::mdlMostrar_reporte_ultima_licencia();

		return $respuesta;
	}



			public static function ctrMostrar_reporte_estadistico_licencias()
	{
		$respuesta = ModeloReporteGeneral::mdlMostrar_reporte_estadistico_licencia();

		return $respuesta;
	}

	public static function ctrMostrar_reporte_ultima_carpeta()
	{
		$respuesta = ModeloReporteGeneral::mdlMostrar_reporte_ultima_carpeta();

		return $respuesta;
	}
	
	public static function ctrMostrar_reporte_ultima_contribuyente()
	{
		$respuesta = ModeloReporteGeneral::mdlMostrar_reporte_ultima_contribuyente();

		return $respuesta;
	}

	public static function ctrMostrar_reporte_total_fallecidas()
	{
		$respuesta = ModeloReporteGeneral::mdlMostrar_reporte_total_fallecidas();

		return $respuesta;
	}


	
	
	

	

	

	
	

	

}
