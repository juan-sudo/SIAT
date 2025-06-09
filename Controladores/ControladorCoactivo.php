<?php

namespace Controladores;

use Modelos\ModeloCoactivo;
use Conect\Conexion;
use PDO;


class ControladorCoactivo
{
	public static function ctrMostrar_lista_coactivo($datos)
	{
	
		$respuesta = ModeloCoactivo::mdlMostrar_lista_coactivo($datos);


		

		return $respuesta;
	}


	

}
