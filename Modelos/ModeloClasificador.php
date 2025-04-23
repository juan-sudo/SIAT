<?php
namespace Modelos;
use Conect\Conexion;
use PDO;
class ModeloClasificador
{
    public static function mdlMostrarClasificador($tabla, $item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla p inner join financiamiento f on p.Id_financiamiento=f.Id_financiamiento  WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
            $stmt->execute();
            return $stmt->fetchall();
        }
        $stmt = null;
    }
    public static function mdlMostrarData($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
        $stmt->execute();
        return $stmt->fetchall();
        $stmt = null;
    }
    public static function mdlNuevoClasificador($tabla, $datos)
    {

        $datos['descripcion'] = strtoupper($datos['descripcion']);
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(Codigo,Descripcion,Estado, Id_financiamiento) VALUES (:codigo, :descripcion,:estado, :id_financiamiento)");
        $stmt->bindParam(":codigo", $datos['codigo'], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $datos['descripcion'], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos['estado'], PDO::PARAM_STR);
        $stmt->bindParam(":id_financiamiento", $datos['id_financiamiento'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt = null;
    }
    public static function mdlEditarClasificador($tabla, $datos)
    {
        $datos['descripcion'] = strtoupper($datos['descripcion']);
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET Codigo = :codigo, Descripcion = :descripcion, Id_financiamiento = :Id_financiamiento WHERE Id_Presupuesto  = :idp");
        $stmt->bindParam(":idp", $datos['idp'], PDO::PARAM_STR);
        $stmt->bindParam(":codigo", $datos['codigo'], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $datos['descripcion'], PDO::PARAM_STR);
        $stmt->bindParam(":Id_financiamiento", $datos['id_financiamiento'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
        $stmt = null;
    }

    public static function mdlActualizarClasificador($tabla, $item1, $valor1, $item2, $valor2)
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

    public static function mdlBorrarClasificador($tabla, $datos)
    {
        $stmt_hijos = Conexion::conectar()->prepare("SELECT COUNT(*) FROM especie_valorada WHERE Id_Presupuesto = :id");
        $stmt_hijos->bindParam(":id", $datos, PDO::PARAM_INT);
        $stmt_hijos->execute();
        $num_hijos = $stmt_hijos->fetchColumn();
        if ($num_hijos > 0) {
            return 'error'; 
        } else {
            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla  WHERE Id_Presupuesto=:id");
            $stmt->bindParam(":id", $datos, PDO::PARAM_INT);
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
