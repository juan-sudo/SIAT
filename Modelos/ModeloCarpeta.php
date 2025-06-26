<?php

namespace Modelos;

use Conect\Conexion;
use PDO;
use PDOException;

class ModeloCarpeta
{
 

  public static function mdlMostrarCarpeta($tabla, $item, $valor)
  {

     $conexion = Conexion::conectar();

      // OBETNER EL ID DE CARPETA
    $stmtObtener = $conexion->prepare("SELECT Id_Carpeta FROM carpeta WHERE Codigo_Carpeta = :Codigo_Carpeta");
    $stmtObtener->bindParam(":Codigo_Carpeta" , $valor, PDO::PARAM_INT);
    $stmtObtener->execute();

    $resultado = $stmtObtener->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $idCarpeta = $resultado['Id_Carpeta'];
    }

   
    if ($item != null) {

     $stmt = $conexion->prepare(
      "SELECT c.*, p.* 
      FROM carpeta c
      LEFT JOIN progreso p ON c.Id_Carpeta = p.Id_Carpeta 
      WHERE c.Id_Carpeta = :id_Carpeta"
        );   
      $stmt->bindParam(":id_Carpeta" , $idCarpeta );
      $stmt->execute();
      return $stmt->fetch();


    } else {
      return "ocurrio un error";
    }
    $stmt = null;
  }



  // MOSTRAR USUARIOS

  public static function mdlEditarCarpetaProgreso($tabla, $datos)
{ 
    $conexion = Conexion::conectar();

    // OBETNER EL ID DE CARPETA
    $stmt = $conexion->prepare("SELECT Id_Carpeta FROM carpeta WHERE Codigo_Carpeta = :Codigo_Carpeta");
    $stmt->bindParam(":Codigo_Carpeta", $datos['Codigo_Carpeta'], PDO::PARAM_INT);
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $idCarpeta = $resultado['Id_Carpeta'];
    }

    // OBTENER NEGOCIO
    $stmt = $conexion->prepare("SELECT EXISTS (SELECT 1 FROM progreso WHERE Id_Carpeta = :id_Carpeta) AS exists_check");
    $stmt->bindParam(":id_Carpeta", $idCarpeta, PDO::PARAM_INT);
    $stmt->execute();
    
    // Recupera el resultado
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    // Asignar NULL a los valores vacíos o no definidos
    $id_usuario = isset($datos['id_usuario']) && !empty($datos['id_usuario']) ? $datos['id_usuario'] : null;
    $observacion_pendiente = isset($datos['observacion_pendiente']) && !empty($datos['observacion_pendiente']) ? $datos['observacion_pendiente'] : null;
    $observacion_progreso = isset($datos['observacion_progreso']) && !empty($datos['observacion_progreso']) ? $datos['observacion_progreso'] : null;
    $completado_oficina = isset($datos['completado_oficina']) && !empty($datos['completado_oficina']) ? $datos['completado_oficina'] : null;
    $completado_campo = isset($datos['completado_campo']) && !empty($datos['completado_campo']) ? $datos['completado_campo'] : null;

    // CUANDO SE ENCUENTRA REGISTRADO, HACER UPDATE
    if ($resultado['exists_check'] == 1) {
        
        // ACTUALIZAR CARPETA EL ESTADO
        $stmtUpdate = $conexion->prepare("UPDATE carpeta SET Estado_progreso = :Estado_progreso WHERE Id_Carpeta = :Id_Carpeta");
        $stmtUpdate->bindParam(":Estado_progreso", $datos['Estado_progreso'], PDO::PARAM_STR);
        $stmtUpdate->bindParam(":Id_Carpeta", $idCarpeta);
        $stmtUpdate->execute();

        // ACTUALIZAR TABLA PROGRESO
        $stmtInsert = $conexion->prepare("UPDATE progreso SET id_usuario = :id_usuario, observacion_pendiente = :observacion_pendiente, 
                                          observacion_progreso = :observacion_progreso, completado_oficina = :completado_oficina, 
                                          completado_campo = :completado_campo, fecha_registro = NOW() 
                                          WHERE Id_Carpeta = :Id_Carpeta");

        $stmtInsert->bindParam(":Id_Carpeta", $idCarpeta);
        $stmtInsert->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
        $stmtInsert->bindParam(":observacion_pendiente", $observacion_pendiente, PDO::PARAM_STR);
        $stmtInsert->bindParam(":observacion_progreso", $observacion_progreso, PDO::PARAM_STR);
        $stmtInsert->bindParam(":completado_oficina", $completado_oficina, PDO::PARAM_STR);
        $stmtInsert->bindParam(":completado_campo", $completado_campo, PDO::PARAM_STR);

        $stmtInsert->execute();
    } 
    // REGISTRAR SI NO ESTA REGISTRADO
    else {
        
        // ACTUALIZAR CARPETA EL ESTADO
        $stmtUpdate = $conexion->prepare("UPDATE carpeta SET Estado_progreso = :Estado_progreso WHERE Codigo_Carpeta = :Codigo_Carpeta");
        $stmtUpdate->bindParam(":Estado_progreso", $datos['Estado_progreso'], PDO::PARAM_STR);
        $stmtUpdate->bindParam(":Codigo_Carpeta", $datos['Codigo_Carpeta']);
        $stmtUpdate->execute();

        // REGISTRAR EN TABLA PROGRESO
        $stmtInsert = $conexion->prepare("INSERT INTO progreso (Id_Carpeta, id_usuario, observacion_pendiente, observacion_progreso, 
                                          completado_oficina, completado_campo, fecha_registro) 
                                          VALUES (:Id_Carpeta, :id_usuario, :observacion_pendiente, :observacion_progreso, 
                                                  :completado_oficina, :completado_campo, NOW())");

        $stmtInsert->bindParam(":Id_Carpeta", $idCarpeta);
        $stmtInsert->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
        $stmtInsert->bindParam(":observacion_pendiente", $observacion_pendiente, PDO::PARAM_STR);
        $stmtInsert->bindParam(":observacion_progreso", $observacion_progreso, PDO::PARAM_STR);
        $stmtInsert->bindParam(":completado_oficina", $completado_oficina, PDO::PARAM_STR);
        $stmtInsert->bindParam(":completado_campo", $completado_campo, PDO::PARAM_STR);

        $stmtInsert->execute();
    }

    // Verificar si la actualización fue exitosa
    if ($stmtUpdate->rowCount() > 0 || $stmtInsert->rowCount() > 0) {
        return 'ok';
    } else {
        return 'error';
    }
}




  
}
