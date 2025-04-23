<?php

namespace Modelos;

use Conect\Conexion;
use PDO;

class ModeloTim
{
  //REGISTRAR TIM--------------------------------------------
  public static function mdlNuevoTim($tabla, $datos)
  {
    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(`Anio`, `Porcentaje`) VALUES (:anio, :tim)");
    $stmt->bindParam(":anio", $datos['anio']);
    $stmt->bindParam(":tim", $datos['tim']);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
    $stmt = null;
  }
  // MOSTRAR TIM---------------------------------------------
  public static function mdlMostrarTim($tabla, $item, $valor)
  {
    if ($item != null) {
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:$item");
      $stmt->bindParam(":" . $item, $valor);
      $stmt->execute();
      return $stmt->fetch();
    } else {
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
      $stmt->execute();
      return $stmt->fetchAll();
    }
    $stmt = null;
  }
  //EDITAR TIM -----------------------------------------------
  public static function mdlEditarTim($tabla, $datos)
  {
    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET Porcentaje = :Porcentaje WHERE Id_TIM = :Id_TIM");
    $stmt->bindParam(":Id_TIM", $datos['Id_TIM']);
    $stmt->bindParam(":Porcentaje", $datos['Porcentaje']);
    if ($stmt->execute()) {
      return 'ok';
    } else {
      return 'error';
    }
    $stmt = null;
  }
  //CONSULTA SIMPLE -------------------------------------------
  public static function ejecutar_consulta_simple($consulta)
  {
    $sql = Conexion::conectar()->prepare($consulta);
    $sql->execute();
    return $sql;
  }
  // BORRAR TIM ----------------------------------------------
  public static function mdlBorrarTim($tabla, $datos)
  {
    $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla  WHERE Id_TIM =:id");
    $stmt->bindParam(":id", $datos, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return 'ok';
    } else {
      return 'error';
    }
    $stmt = null;
  }
  public static function mdlMostrarEstadoCuenta($datos)
  {
    $valor = $datos['Concatenado_idc'];

    // Convertir el string en un array utilizando explode
    $array = explode('-', $valor);
    
    // Ordenar el array de menor a mayor
    sort($array);
    
    // Convertir el array ordenado de nuevo en un string utilizando implode
    $ids = implode('-', $array);
    $stmt0 = Conexion::conectar()->prepare("SELECT Id_TIM, Porcentaje FROM tim WHERE Anio=:Anio");
    $stmt0->bindParam(":Anio", $datos['Anio']);
    $stmt0->execute();
    $resultado1 = $stmt0->fetchAll(PDO::FETCH_ASSOC);
    $stmt0 = null;

    $stmt = Conexion::conectar()->prepare("SELECT * FROM estado_cuenta_corriente
     WHERE (Concatenado_idc=:Concatenado_idc 
     AND Estado = 'D' 
     AND Tipo_Tributo='006' 
    AND Anio=:Anio)");
    $stmt->bindParam(":Concatenado_idc", $ids);
    $stmt->bindParam(":Anio", $datos['Anio']);
    $stmt->execute();
    $resultado2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = null;

    // Combinar los resultados en una sola matriz
    $resultado = array_merge($resultado1, $resultado2);
    return $resultado;
  }

  public static function mdlCalcularTimporanio($datos)
  {

    $valor = $datos['Concatenado_idc'];
    $array = explode('-', $valor);
    sort($array);
    $ids = implode('-', $array);
    $pdo = Conexion::conectar();

    $stmt0 = $pdo->prepare("SELECT Porcentaje FROM tim WHERE Anio=:Anio");
    $stmt0->bindParam(":Anio", $datos['Anio']);
    $stmt0->execute();
    $resultado0 = $stmt0->fetch(PDO::FETCH_ASSOC);
    $porcentaje = $resultado0['Porcentaje'];

    $stmt1 = $pdo->prepare("UPDATE estado_cuenta_corriente 
    SET TIM = Importe * :Porcentaje/100 ,
    TIM_Descuento =0,
    TIM_Aplicar =TIM,
     Total = Saldo + TIM_Aplicar,
     Total_Aplicar=Total-Descuento  WHERE Concatenado_idc=:Concatenado_idc AND Estado = 'D' AND Tipo_Tributo='006' AND Anio=:Anio");
    $stmt1->bindParam(":Porcentaje", $porcentaje);
    $stmt1->bindParam(":Concatenado_idc", $ids);
    $stmt1->bindParam(":Anio", $datos['Anio']);
    if ($stmt1->execute()) {
      return 'ok';
    } else {
      return 'error';
    }
  }

  public static function mdlMostrarData($tabla)
  {
    $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = null;
    return $resultado;
  }
}
