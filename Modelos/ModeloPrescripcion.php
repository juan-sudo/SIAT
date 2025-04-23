<?php

namespace Modelos;

use Conect\Conexion;
use PDO;
use PDOException;

class ModeloPrescripcion
{
    public static function mdlRegistrarPrescripcion($idDeuda, $data)
  {
    foreach($idDeuda as $id){
        $stmt = Conexion::conectar()->prepare("INSERT INTO prescripcion(`codigo`, `expediente`, `resolucion`, `asunto`, `fecha_registro`, `direccionIP`, `Id_Estado_Cuenta_impuesto`, `Id_Usuario`) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bindParam(1,$data["codigo_prescripcion"]);
        $stmt->bindParam(2,$data["expediente_prescripcion"]);
        $stmt->bindParam(3,$data["resolucion_prescripcion"]);
        $stmt->bindParam(4,$data["asunto_prescripcion"]);
        $stmt->bindParam(5,$data["fecha_prescripcion"]);
        $stmt->bindParam(6,$data["direccionIP"]);
        $stmt->bindParam(7,$id);
        $stmt->bindParam(8,$data["usuario"]);
        if(!$stmt->execute()){
            return false;
        }else{
            $sql = Conexion::conectar()->prepare("UPDATE estado_cuenta_corriente SET Estado='E' WHERE Id_Estado_Cuenta_Impuesto=?");
            $sql->bindParam(1,$id);
            if(!$sql->execute()){
                return false;
            }
        }
    }
    return true;
  }
}

?>