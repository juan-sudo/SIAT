<?php
namespace Modelos;
use Conect\Conexion;
use PDO;
class ModeloGiroComercial
{
    //---------------------- MOSTRAR GIRO COMERCIAL -------------------------------
    public static function mdlMostrarGiroComercial($tabla, $item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE $item = :$item");
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
//-------------------- REGISTRO DE GIRO COMERCIAL -----------------------------
    public static function mdlNuevoGiroComercial($tabla, $datos)
    {
        $datos['Nombre'] = strtoupper($datos['Nombre']);
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla( `Nombre`, `Estado`) 
        VALUES (:nombre, :estado)");
        $stmt->bindParam(":nombre", $datos['Nombre'], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos['Estado'], PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt = null;
    }
//---------------- EDITAR GRIO COMERCIAL -------------------------------------
    public static function mdlEditarGiroComercial($tabla, $datos)
    {
        $datos['nombreGiro'] = strtoupper($datos['nombreGiro']);
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET Nombre = :nombre WHERE Id_Giro_Comercial  = :ide");
        $stmt->bindParam(":ide", $datos['ide']);
        $stmt->bindParam(":nombre", $datos['nombreGiro']);
        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
        $stmt = null;
    }
//-------------- BORRAR GIRO COMERCIAL------------------------------------
    public static function mdlBorrarGiroComercial($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla  WHERE Id_Giro_Establecimiento =:id");
        $stmt->bindParam(":id", $datos, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
        $stmt = null;
    }
//---------------- SE USA PARA VALIDAR --------------------------------
    public static function ejecutar_consulta_simple($consulta)
    {
        $sql = Conexion::conectar()->prepare($consulta);
        $sql->execute();
        return $sql;
    }
//---------------- ACTUALIZAR  ESTADO ----------------------------------
    public static function mdlActualizarEstadoGiroComercial($tabla, $item1, $valor1, $item2, $valor2)
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
    public static function mdlMostrarData($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
        $stmt->execute();
        return $stmt->fetchall();
        $stmt = null;
    }
}
