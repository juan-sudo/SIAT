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
            c.Numeracion_caja,
            c.Total_Predial
            



        FROM 
            ingreso_coactivo c
        JOIN 
             ingresos_tributos it ON c.Id_Ingreso_Coactivo = it.Id_Ingresos_Tributos
        WHERE 
            c.Fecha_Registro BETWEEN :fecha_inicio AND :fecha_fin AND it.Estado='P' AND c.Impuesto_Predial='006'
    ");

    $stmt->bindParam(":fecha_inicio", $datos["fecha_inicio"], PDO::PARAM_STR);
    $stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
    $stmt->execute();

    $resultado = $stmt->fetchAll(PDO::FETCH_NUM);

    // depuración opcional
    // var_dump($resultado);

    return $resultado;
}


public static function mdlMostrar_lista_coactivo_a($datos)
{
    // Fecha simple, sin horas, porque es tipo DATE
    $stmt = Conexion::conectar()->prepare("
        SELECT 
            c.Fecha_Registro,
            c.Numeracion_caja,
            c.Total_arbitrios
        FROM 
            ingreso_coactivo c
        JOIN 
             ingresos_tributos it ON c.Id_Ingreso_Coactivo = it.Id_Ingresos_Tributos
        WHERE 
            c.Fecha_Registro BETWEEN :fecha_inicio AND :fecha_fin AND it.Estado='P' AND c.Arbitrio_Municipal='742'
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
