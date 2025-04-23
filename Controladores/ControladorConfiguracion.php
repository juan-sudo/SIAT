<?php
namespace Controladores;
use Modelos\ModeloConfiguracion;
use Conect\Conexion;

class ControladorConfiguracion
{
	public  static function ctrConfiguracion()
	{
		$respuesta = ModeloConfiguracion::mdlConfiguracion();
		return $respuesta;
	}
}
