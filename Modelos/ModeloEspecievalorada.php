<?php

namespace Modelos;

use Conect\Conexion;
use PDO;

class ModeloEspecievalorada
{
    // MOSTRAR USUARIOS
    public static function mdlMostrarEspecievalorada($tabla, $item, $valor)
    {
        $conexion = Conexion::conectar();
        if ($item != null) {
            $stmt = $conexion->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll();
        } else {
            $stmt = $conexion->prepare("SELECT *, e.Estado as estado_especie
            FROM especie_valorada e 
            INNER JOIN area a ON e.Id_Area = a.Id_Area 
            INNER JOIN presupuesto p ON e.Id_Presupuesto = p.Id_Presupuesto
            INNER JOIN instrumento_gestion i ON e.Id_Instrumento_Gestion= i.Id_Instrumento_Gestion
            ORDER BY Nombre_Area,Nombre_Especie")
            ;
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }

    public static function mdlMostrarEspecievalorada_multa()
    {
        $conexion = Conexion::conectar();
            $stmt = $conexion->prepare("SELECT *, e.Estado as estado_especie
            FROM especie_valorada e 
            INNER JOIN area a ON e.Id_Area = a.Id_Area 
            INNER JOIN presupuesto p ON e.Id_Presupuesto = p.Id_Presupuesto
            INNER JOIN instrumento_gestion i ON e.Id_Instrumento_Gestion= i.Id_Instrumento_Gestion where e.Id_Instrumento_Gestion=4
            ORDER BY Nombre_Area,Nombre_Especie");
            $stmt->execute();
            return $stmt->fetchAll();
        
    }

    public static function mdlMostrarData($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
        $stmt->execute();
        return $stmt->fetchall();
        $stmt = null;
    }
    // REGISTRO DE USUARIOS
    public static function mdlNuevoEspecievalorada($tabla, $datos)
    {
        $datos['Nombre_Especie'] = strtoupper($datos['Nombre_Especie']);
        $datos['Detalle'] = strtoupper($datos['Detalle']);
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(Monto, Estado, Id_Area, Id_Presupuesto ,Nombre_Especie ,Detalle ,Id_Instrumento_Gestion,Numero_Pagina,requisito) VALUES (:Monto, :Estado,:Id_Area, :Id_Presupuesto,:Nombre_Especie,:Detalle,:Id_Instrumento_Gestion,:Numero_Pagina,:requisito)");
        $stmt->bindParam(":Monto", $datos['Monto']);
        $stmt->bindParam(":Estado", $datos['Estado']);
        $stmt->bindParam(":Id_Area", $datos['Id_Area']);
        $stmt->bindParam(":Id_Presupuesto", $datos['Id_Presupuesto']);
        $stmt->bindParam(":Nombre_Especie", $datos['Nombre_Especie']);
        $stmt->bindParam(":Detalle", $datos['Detalle']);
        $stmt->bindParam(":Id_Instrumento_Gestion", $datos['Id_Instrumento_Gestion']);
        $stmt->bindParam(":Numero_Pagina", $datos['Numero_Pagina']);
        $stmt->bindParam(":requisito", $datos['requisito']);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt = null;
    }
    //EDITAR USUARIOS
    public static function mdlEditarEspecievalorada($tabla, $datos)
    {
        $datos['Nombre_Especie'] = strtoupper($datos['Nombre_Especie']);
        $datos['Detalle'] = strtoupper($datos['Detalle']);
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET Monto=:Monto, Id_Area=:Id_Area, Id_Presupuesto=:Id_Presupuesto,Nombre_Especie=:Nombre_Especie,Id_Instrumento_Gestion=:Id_Instrumento_Gestion,Detalle=:Detalle,Numero_Pagina=:Numero_Pagina,requisito=:requisito  WHERE Id_Especie_Valorada=:Id_Especie_Valorada");
        $stmt->bindParam(":Id_Especie_Valorada", $datos['Id_Especie_Valorada'], PDO::PARAM_INT);
        $stmt->bindParam(":Monto", $datos['Monto']);
        $stmt->bindParam(":Id_Instrumento_Gestion", $datos['Id_Instrumento_Gestion']);
        $stmt->bindParam(":Detalle", $datos['Detalle']);
        $stmt->bindParam(":Id_Area", $datos['Id_Area'], PDO::PARAM_INT);
        $stmt->bindParam(":Id_Presupuesto", $datos['Id_Presupuesto'], PDO::PARAM_INT);
        $stmt->bindParam(":Nombre_Especie", $datos['Nombre_Especie'], PDO::PARAM_STR);
        $stmt->bindParam(":Numero_Pagina", $datos['Numero_Pagina'], PDO::PARAM_INT);
        $stmt->bindParam(":Numero_Pagina", $datos['Numero_Pagina'], PDO::PARAM_INT);
        $stmt->bindParam(":requisito", $datos['requisito']);
        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
        $stmt = null;
    }
    // ACTUALIZAR USUARIO ESTADO
    public static function mdlActualizarEstadoEspecievalorada($tabla, $item1, $valor1, $item2, $valor2)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");
        $stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
        $stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
        $stmt = null;
    }

    // BORRAR USUARIO
    public static function mdlBorrarEspecievalorada($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) FROM proveido WHERE Id_Especie_Valorada = :id");
        $stmt->bindParam(":id", $datos, PDO::PARAM_INT);
        $stmt->execute();
        $stmt = $stmt->fetchColumn();
        if ($stmt > 0) {
            return 'error'; 
        } else {
            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla  WHERE Id_Especie_Valorada=:Id_Especie_Valorada");
            $stmt->bindParam(":Id_Especie_Valorada", $datos, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return 'ok';
            } else {
                return 'error';
            }
            $stmt = null;
        }
    }

    public static function ejecutar_consulta_simple($consulta)
    {
        $sql = Conexion::conectar()->prepare($consulta);
        $sql->execute();
        return $sql;
    }
}
