<?php

namespace Modelos;
use Conect\Conexion;
use Exception;
use PDO;

class ModeloCoactivo
{
	

public static function mdlMostrar_lista_coactivo($datos)
{
    // Fecha simple, sin horas, porque es tipo DATE
    $stmt = Conexion::conectar()->prepare("
        SELECT 
            c.Fecha_Registro,
            c.Total,
            c.Numeracion_caja



        FROM 
            ingreso_coactivo c
        JOIN 
             ingresos_tributos it ON c.Id_Ingreso_Coactivo = it.Id_Ingresos_Tributos
        WHERE 
            c.Fecha_Registro BETWEEN :fecha_inicio AND :fecha_fin AND it.Estado='P'
    ");

    $stmt->bindParam(":fecha_inicio", $datos["fecha_inicio"], PDO::PARAM_STR);
    $stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
    $stmt->execute();

    $resultado = $stmt->fetchAll(PDO::FETCH_NUM);

    // depuración opcional
    // var_dump($resultado);

    return $resultado;
}

     
}
