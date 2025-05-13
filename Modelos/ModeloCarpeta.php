<?php

namespace Modelos;

use Conect\Conexion;
use PDO;
use PDOException;

class ModeloCarpeta
{
 

  public static function mdlMostrarCarpeta($tabla, $item, $valor)
  {

   
    if ($item != null) {
      $stmt = Conexion::conectar()->prepare("SELECT * FROM carpeta  WHERE Codigo_Carpeta = :Codigo_Carpeta");
      $stmt->bindParam(":Codigo_Carpeta" , $valor, PDO::PARAM_INT);
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
      // Conexión a la base de datos
      $conexion = Conexion::conectar();
  
      // Preparar la consulta UPDATE para modificar Estado_progreso según Concatenado_id
      $stmtUpdate = $conexion->prepare("UPDATE carpeta SET Estado_progreso = :Estado_progreso WHERE Codigo_Carpeta = :Codigo_Carpeta");
  
      // Enlazar los parámetros
      $stmtUpdate->bindParam(":Estado_progreso", $datos['Estado_progreso'], PDO::PARAM_STR);
      $stmtUpdate->bindParam(":Codigo_Carpeta", $datos['Codigo_Carpeta'], PDO::PARAM_INT);
  
      // Ejecutar la consulta
      if ($stmtUpdate->execute()) {
          return 'ok';
      } else {
          return 'error';
      }
  
      // IMPORTANTE: Esta línea nunca se ejecutará porque ya hiciste return arriba.
      // Para buenas prácticas, deberías cerrarlo antes del return.
      // Lo correcto sería mover esto arriba del return.
      $stmtUpdate = null;
  }
  
  

  
}
