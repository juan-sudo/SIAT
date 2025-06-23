<?php

namespace Controladores;

use Modelos\ModeloNegocio;
use Conect\Conexion;

class ControladorNegocio
{


     //VER NEGOCIO
    	public static function ctrEditar_negocio($datos)
	{
		$respuesta = ModeloNegocio::mdlEditarNegocio($datos);
		 // Verifica que la respuesta sea un objeto o cadena que pueda ser convertida en JSON
     
        // var_dump($respuesta);

         
    // Verificar la respuesta y devolverla en formato JSON
    if ($respuesta['status'] == 'ok') {
        echo json_encode([
            "status" => "ok",
            "message" => "Negocio encontrado exitosamente",
            "data" => $respuesta['data']  // Añadir los datos en la respuesta
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => $respuesta['message']  // Mostrar el mensaje de error correspondiente
        ]);
    }
		
     
	}
    

    //VER NEGOCIO
    	public static function ctrVer_negocio($datos)
	{
		$respuesta = ModeloNegocio::mdlVerNegocio($datos);
		 // Verifica que la respuesta sea un objeto o cadena que pueda ser convertida en JSON
     
        // var_dump($respuesta);

         
    // Verificar la respuesta y devolverla en formato JSON
    if ($respuesta['status'] == 'ok') {
        echo json_encode([
            "status" => "ok",
            "message" => "Negocio encontrado exitosamente",
            "data" => $respuesta['data']  // Añadir los datos en la respuesta
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => $respuesta['message']  // Mostrar el mensaje de error correspondiente
        ]);
    }
		
     
	}
	// REGISTRAR NEGOCIO
	public static function ctrRegistar_negocio($datos)
	{
		$respuesta = ModeloNegocio::mdlRegistrarNegocio($datos);
		 // Verifica que la respuesta sea un objeto o cadena que pueda ser convertida en JSON
     
		// Verificar la respuesta y devolverla en formato JSON
        // Verifica que la respuesta sea "ok" o "error"
        if ($respuesta == 'ok') {
            echo json_encode([
                "status" => "ok",
                "message" => "Negocio registrado exitosamente"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Error al registrar el negocio"
            ]);
        }
     
	}

	// LISTAR NEGOCIO
	public static function ctrListar_negocio($datos)
{
    $respuesta = ModeloNegocio::mdlListarNegocio($datos);
    return $respuesta;
}


	
	



}
