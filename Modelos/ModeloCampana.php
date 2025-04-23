<?php

namespace Modelos;

use Conect\Conexion;
use PDO;
use PDOException;

class ModeloCampana
{
   // MOSTRAR USUARIOS
   // REGISTRO DE USUARIOS
   public static function mdlNuevaCampana($tabla, $datos)
   {
      $datos['descripcion_descuento'] = strtoupper($datos['descripcion_descuento']);
      $datos['Documento'] = strtoupper($datos['Documento']);

      $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(Id_Anio, Id_Arbitrios, Id_Uso_Predio, Porcentaje ,Fecha_Inicio ,Fecha_Fin ,Documento,estado_descuento,descripcion_descuento, tipo_descuento) VALUES (:Id_Anio, :Id_Arbitrios, :Id_Uso_Predio, :Porcentaje,:Fecha_Inicio, :Fecha_Fin, :Documento,:estado_descuento,:descripcion_descuento, :tipo_descuento)");
      $stmt->bindParam(":Id_Anio", $datos['Id_Anio']);
      $stmt->bindParam(":Id_Arbitrios", $datos['Id_Arbitrios']);
      $stmt->bindParam(":Id_Uso_Predio", $datos['Id_Uso_Predio']);
      $stmt->bindParam(":Porcentaje", $datos['Porcentaje']);
      $stmt->bindParam(":Fecha_Inicio", $datos['Fecha_Inicio']);
      $stmt->bindParam(":Fecha_Fin", $datos['Fecha_Fin']);
      $stmt->bindParam(":Documento", $datos['Documento']);
      $stmt->bindParam(":estado_descuento", $datos['estado_descuento']);
      $stmt->bindParam(":descripcion_descuento", $datos['descripcion_descuento']);
      $stmt->bindParam(":tipo_descuento", $datos['tipo_descuento']);
      if ($stmt->execute()) {
         return "ok";
      } else {
         return "error";
      }
      $stmt = null;
   }
   public static function mdlMostrarData($tabla)
   {
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla d 
		INNER JOIN anio a on d.Id_Anio=a.Id_Anio");
      //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
      $stmt->execute();
      return $stmt->fetchall();
      $stmt = null;
   }
   public static function mdlBorrarCampana($tabla, $datos)
   {
      $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE Id_Descuento=:Id_Descuento");
      $stmt->bindParam(":Id_Descuento", $datos, PDO::PARAM_INT);
      if ($stmt->execute()) {
         return 'ok';
      } else {
         return 'error';
      }
      $stmt = null;
   }
   public static function mdlActualizarEstadoCampana($tabla, $item1, $valor1, $item2, $valor2)
   {
      try {
         $PDO = Conexion::conectar();
         $PDO->beginTransaction();
         // Primera actualización
         $stmt = $PDO->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");
         $stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
         $stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_STR);
         $stmt->execute();

         $id_descuento = $valor2;
         $stmt_descuento = $PDO->prepare("SELECT tipo_descuento,Porcentaje,NomAnio,Id_Uso_Predio FROM descuento d  Inner join Anio a on a.Id_Anio=d.Id_Anio 
                                          WHERE d.Id_Descuento = :Id_Descuento
                                         ");
         $stmt_descuento->bindParam(':Id_Descuento', $id_descuento, PDO::PARAM_INT);
         $stmt_descuento->execute();
         $descuento = $stmt_descuento->fetch(PDO::FETCH_ASSOC);
         if ($descuento) {
            // Obtener información del descuento
            $tipo_descuento = $descuento['tipo_descuento'];
            $porcentaje_descuento = $descuento['Porcentaje'];
            $anio_aplicacion = $descuento['NomAnio'];
            $id_usoPredio = $descuento['Id_Uso_Predio'];
            if ($tipo_descuento == 1) {
                  $stmt_update = $PDO->prepare("UPDATE estado_cuenta_corriente 
                                                SET Descuento = Total*($porcentaje_descuento/100), 
                                                Total_Aplicar = (Total-Total*($porcentaje_descuento/100))   
                                                WHERE Tipo_Tributo =742 and Anio=$anio_aplicacion AND Estado='D' ");
                  $stmt_update->execute();
               
            } else if ($tipo_descuento == 2) {

               $stmt_update = $PDO->prepare("UPDATE estado_cuenta_corriente 
                                             SET TIM_Descuento = TIM*($porcentaje_descuento/100), 
                                                TIM_Aplicar = TIM-(TIM*($porcentaje_descuento/100)),
                                                Total_Aplicar=Saldo+(TIM-(TIM*($porcentaje_descuento/100)))  
                                             WHERE Tipo_Tributo ='006' and Anio=$anio_aplicacion AND Estado='D' ");
               $stmt_update->execute();
               
            } else if ($tipo_descuento == 3) {
               $stmt_estado_cuenta = $PDO->prepare("SELECT e.Id_Estado_Cuenta_Impuesto, e.Tipo_Tributo, e.Id_Predio, e.Periodo, e.Importe, e.Id_Descuento, e.Descuento  FROM estado_cuenta_corriente e 
					INNER JOIN predio p on p.Id_Predio =e.Id_Predio 
					WHERE e.Tipo_Tributo = 742 AND e.Anio = :anio AND p.Id_Uso_Predio= :id_usoPredio AND e.Estado='D'");
               $stmt_estado_cuenta->bindParam(':anio', $anio_aplicacion);
               $stmt_estado_cuenta->bindParam(':id_usoPredio', $id_usoPredio);
               $stmt_estado_cuenta->execute();
               while ($estado_cuenta = $stmt_estado_cuenta->fetch(PDO::FETCH_ASSOC)) {
                  $descuento_aplicado = $estado_cuenta['Importe'] * ($porcentaje_descuento / 100);
                  $stmt_update = $PDO->prepare("UPDATE estado_cuenta_corriente SET Descuento = :Descuento, Id_Descuento = :Id_Descuento, Total_Aplicar = Total - :Descuento WHERE Id_Estado_Cuenta_Impuesto = :Id_Estado_Cuenta_Impuesto");
                  $stmt_update->bindParam(':Descuento', $descuento_aplicado);
                  $stmt_update->bindParam(':Id_Descuento', $id_descuento);
                  $stmt_update->bindParam(':Id_Estado_Cuenta_Impuesto', $estado_cuenta['Id_Estado_Cuenta_Impuesto']);
                  $stmt_update->execute();
               }
            }
            $PDO->commit();
            return "ok";
         } else {
            return "Error no encontró el descuento en la BD";
         }
      } catch (PDOException $e) {
         // Si hay algún error, revertir la transacción
        
         echo "Error: " . $e->getMessage();
      }
   }
   public static function mdlMostrarCampa($tabla, $item, $valor)
   {
      if ($item != null) {
         $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE $item = :$item");
         $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
         $stmt->execute();
         return $stmt->fetch();
      } else {
         $stmt = Conexion::conectar()->prepare("SELECT *,e.Estado as estado_especie FROM $tabla e inner join area a on e.Id_Area=a.Id_Area inner join presupuesto p on e.Id_Presupuesto=p.Id_Presupuesto");
         //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
         $stmt->execute();
         return $stmt->fetchall();
      }
      $stmt = null;
   }
   public static function mdlEditarCampana($tabla, $datos)
   {
      $datos['descripcion_descuento'] = strtoupper($datos['descripcion_descuento']);
      $datos['Documento'] = strtoupper($datos['Documento']);
      $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET Id_Anio=:Id_Anio, Id_Uso_Predio=:Id_Uso_Predio, Porcentaje=:Porcentaje,Fecha_Inicio=:Fecha_Inicio,Fecha_Fin=:Fecha_Fin,Documento=:Documento,descripcion_descuento=:descripcion_descuento WHERE Id_Descuento=:Id_Descuento");
      $stmt->bindParam(":Id_Descuento", $datos['Id_Descuento']);
      $stmt->bindParam(":Id_Anio", $datos['Id_Anio']);
      $stmt->bindParam(":Id_Uso_Predio", $datos['Id_Uso_Predio']);
      $stmt->bindParam(":Porcentaje", $datos['Porcentaje']);
      $stmt->bindParam(":Documento", $datos['Documento']);
      $stmt->bindParam(":Fecha_Inicio", $datos['Fecha_Inicio']);
      $stmt->bindParam(":Fecha_Fin", $datos['Fecha_Fin']);
      $stmt->bindParam(":descripcion_descuento", $datos['descripcion_descuento']);
      if ($stmt->execute()) {
         return 'ok';
      } else {
         return 'error';
      }
      $stmt = null;
   }
}
