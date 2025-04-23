<?php

namespace Modelos;

use Conect\Conexion;
use Exception;
use PDO;

class ModeloDireccion
{
  public static function mdlNuevaDireccion($tabla, $datos)
  {
    $pdo = Conexion::conectar();
    try {
      $stmt1 = $pdo->prepare("INSERT INTO $tabla(Id_Tipo_Via, Id_Nombre_Via ) VALUES (:Id_Tipo_Via, :Id_Nombre_Via)");
      $stmt1->bindParam(":Id_Tipo_Via", $datos['Id_Tipo_Via']);
      $stmt1->bindParam(":Id_Nombre_Via", $datos['Id_Nombre_Via']);
      $stmt1->execute();
      return "ok";
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
    }
    $pdo = null;
  }
  public static function mdlMostrarData($tabla)
  {
    $pdo = Conexion::conectar();
    if ($tabla != null) {
      $stmt = $pdo->prepare("SELECT * FROM $tabla");
      $stmt->execute();
      //  $stmt->close();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
      $pdo = null;
    } else {
      return "ocurrio un error";
    }
  }

  public static function mdlMostrarData_via_calle()
  {
    $pdo = Conexion::conectar();
      $stmt = $pdo->prepare("SELECT d.Id_Direccion as Id_Direccion,CONCAT( t.Codigo,' ', n.Nombre_Via) AS Nombre_Via 
                            FROM direccion d inner join nombre_via n ON d.Id_Nombre_Via=n.Id_Nombre_Via 
                            inner join tipo_via t on d.Id_Tipo_Via=t.Id_Tipo_Via; ");
      $stmt->execute();
      //  $stmt->close();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
   
  }
  public static function mdlMostrarDireccion($tabla, $item, $valor)
  {
    $pdo = Conexion::conectar();
    if ($item != null) {
      $stmt = $pdo->prepare("SELECT *	FROM $tabla WHERE $item=:$item");
      $stmt->bindParam(":" . $item, $valor);
      $stmt->execute();
      return $stmt->fetch();
    } else {
      $stmt = $pdo->prepare("SELECT h.Habilitacion_Urbana, z.Nombre_Zona, t.Nomenclatura, n.Nombre_Via,d.Id_Direccion FROM ubica_via_urbano uv
			    INNER JOIN zona z ON z.Id_Zona=uv.Id_Zona
			    INNER JOIN direccion d ON d.Id_Direccion = uv.Id_Direccion
          INNER JOIN tipo_via t ON d.Id_Tipo_Via=t.Id_Tipo_Via
          INNER JOIN nombre_via n ON n.Id_Nombre_Via=d.Id_Nombre_Via 
      		INNER JOIN habilitaciones_urbanas h ON h.Id_Habilitacion_Urbana=z.Id_Habilitacion_Urbana
          GROUP BY d.Id_Direccion, z.Id_Zona
			    ORDER BY d.Id_Nombre_Via");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $pdo = null;
  }
  public static function mdlBorrarDireccion($tabla, $datos)
  {
    $stmt_hijos = Conexion::conectar()->prepare("SELECT COUNT(*) FROM ubica_via_urbano WHERE Id_Direccion = :id");
    $stmt_hijos->bindParam(":id", $datos, PDO::PARAM_INT);
    $stmt_hijos->execute();
    $num_hijos = $stmt_hijos->fetchColumn();
    if ($num_hijos > 0) {
      return 'error';
    } else {
      $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE Id_Direccion =:id");
      $stmt->bindParam(":id", $datos, PDO::PARAM_INT);
      if ($stmt->execute()) {
        return 'ok';
      } else {
        return 'error';
      }
      $stmt = null;
    }
  }
  public static function mdlEditarDireccion($tabla, $datos)
  {
    $stmt_hijos = Conexion::conectar()->prepare("SELECT COUNT(*) FROM ubica_via_urbano WHERE Id_Direccion = :id");
    $stmt_hijos->bindParam(":id", $datos['Id_Direccion'], PDO::PARAM_INT);
    $stmt_hijos->execute();
    $num_hijos = $stmt_hijos->fetchColumn();
    if ($num_hijos > 0) {
      return 'error1';
    } else {
      $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET Id_Tipo_Via = :Id_Tipo_Via, Id_Zona = :Id_Zona, Id_Nombre_Via = :Id_Nombre_Via WHERE Id_Direccion = :Id_Direccion");
      $stmt->bindParam(":Id_Direccion", $datos['Id_Direccion']);
      $stmt->bindParam(":Id_Tipo_Via", $datos['Id_Tipo_Via']);
      $stmt->bindParam(":Id_Zona", $datos['Id_Zona']);
      $stmt->bindParam(":Id_Nombre_Via", $datos['Id_Nombre_Via']);
      if ($stmt->execute()) {
        return 'ok';
      } else {
        return 'error';
      }
    }
  }
}
