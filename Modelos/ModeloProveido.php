<?php
namespace Modelos;
use Conect\Conexion;
use Exception;
use PDO;
use PDOException;
class ModeloProveido
{
   public static function mdlNuevoProveido($datos)
{
    // Decodificar los items del JSON
    $items = json_decode($datos['items'], true);
    // Preparar y ejecutar la consulta para obtener Id_Area
    $stmtSelect = Conexion::conectar()->prepare("SELECT Id_Area FROM area WHERE Nombre_Area = :area");
    $stmtSelect->bindParam(":area", $datos['area'], PDO::PARAM_STR);
    $stmtSelect->execute(); // Ejecutar la consulta
    $area_oficina = $stmtSelect->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró un resultado
    if (!$area_oficina) {
        return "error"; // Retornar error si no se encontró el área
    }
    foreach ($items as $item) {
        // Preparar la sentencia SQL para la inserción
       
        $stmtInsert = Conexion::conectar()->prepare("INSERT INTO proveido(Id_Especie_Valorada,
                                                                    Cantidad, 
                                                                    Valor_Total,
                                                                    Descripcion, 
                                                                    Estado_Caja, 
                                                                    Estado_Uso, 
                                                                    Id_Cuenta_Especie_Valorada, 
                                                                    DNI, 
                                                                    Nombres, 
                                                                    Numero_Proveido,
                                                                    Id_Area,
                                                                    Estado_Registro,
                                                                    Observaciones ) 
                                                                    VALUES (:Id_Especie_Valorada, 
                                                                    :Cantidad, 
                                                                    :Valor_Total, 
                                                                    :Descripcion, 
                                                                    :Estado_Caja, 
                                                                    :Estado_Uso, 
                                                                    :Id_Ingreso_Especie, 
                                                                    :DNI, 
                                                                    :Nombres, 
                                                                    :Numero_Proveido,
                                                                    :Id_Area,
                                                                    'R',
                                                                    :observaciones)");

        // Asignar los valores a cada parámetro
        $stmtInsert->bindParam(":Id_Especie_Valorada", $item['id']);
        $stmtInsert->bindParam(":Cantidad", $item['cantidad']);
        $stmtInsert->bindParam(":Valor_Total", $item['monto']);
        $descripcion = strtoupper($item['nombreEspecie']);
        $stmtInsert->bindParam(":Descripcion", $descripcion);
        $stmtInsert->bindParam(":Estado_Caja", $datos['Estado_Caja']);
        $stmtInsert->bindParam(":Estado_Uso", $datos['Estado_Uso']);
        $stmtInsert->bindParam(":Id_Ingreso_Especie", $datos['Id_Ingreso_Especie']);
        $stmtInsert->bindParam(":DNI", $datos['DNI']);
        $Nombres = strtoupper($datos['Nombres']);
        $stmtInsert->bindParam(":Nombres", $Nombres);
        $stmtInsert->bindParam(":Numero_Proveido", $datos['Numero_Proveido']);
        $stmtInsert->bindParam(":Id_Area", $area_oficina['Id_Area']);
        $stmtInsert->bindParam(":observaciones", $datos['observaciones']);

        // Ejecutar la inserción
        if (!$stmtInsert->execute()) {
            return "error";
        }
    }

    // Actualizar Numero_Proveido en la tabla area
    $numero_proveido = $datos['Numero_Proveido'] + 1;
    $stmtUpdate = Conexion::conectar()->prepare("UPDATE area SET Numero_Proveido = :numero_proveido WHERE Nombre_Area = :area");
    $stmtUpdate->bindParam(":numero_proveido", $numero_proveido, PDO::PARAM_INT);
    $stmtUpdate->bindParam(":area", $datos['area'], PDO::PARAM_STR);
    $stmtUpdate->execute();

    // Si todas las inserciones fueron exitosas
    return "ok";
}


public static function mdlNuevoProveido_editar($datos)
{    
    
    // Decodificar los items del JSON
    $items = json_decode($datos['items'], true);
    // Preparar y ejecutar la consulta para obtener Id_Area
    $stmtSelect = Conexion::conectar()->prepare("SELECT Id_Area FROM area WHERE Nombre_Area = :area");
    $stmtSelect->bindParam(":area", $datos['area'], PDO::PARAM_STR);
    $stmtSelect->execute(); // Ejecutar la consulta
    $area_oficina = $stmtSelect->fetch(PDO::FETCH_ASSOC);
    

    $stmtDelete = Conexion::conectar()->prepare("DELETE FROM proveido  WHERE Numero_Proveido = :numero_proveido and Id_Area=:id_area");
    $stmtDelete->bindParam(":numero_proveido", $datos['Numero_Proveido']);
    $stmtDelete->bindParam(":id_area", $area_oficina['Id_Area']);
    $stmtDelete->execute(); // Ejecutar la consulta
    // Verificar si se encontró un resultado
    if (!$area_oficina) {
        return "error"; // Retornar error si no se encontró el área
    }
    foreach ($items as $item) {
        // Preparar la sentencia SQL para la inserción
       
        $stmtInsert = Conexion::conectar()->prepare("INSERT INTO proveido(Id_Especie_Valorada,
                                                                    Cantidad, 
                                                                    Valor_Total,
                                                                    Descripcion, 
                                                                    Estado_Caja, 
                                                                    Estado_Uso, 
                                                                    Id_Cuenta_Especie_Valorada, 
                                                                    DNI, 
                                                                    Nombres, 
                                                                    Numero_Proveido,
                                                                    Id_Area,
                                                                    Estado_Registro,
                                                                    Observaciones ) 
                                                                    VALUES (:Id_Especie_Valorada, 
                                                                    :Cantidad, 
                                                                    :Valor_Total, 
                                                                    :Descripcion, 
                                                                    :Estado_Caja, 
                                                                    :Estado_Uso, 
                                                                    :Id_Ingreso_Especie, 
                                                                    :DNI, 
                                                                    :Nombres, 
                                                                    :Numero_Proveido,
                                                                    :Id_Area,
                                                                    'R',
                                                                    :observaciones)");

        // Asignar los valores a cada parámetro
        $stmtInsert->bindParam(":Id_Especie_Valorada", $item['id']);
        $stmtInsert->bindParam(":Cantidad", $item['cantidad']);
        $stmtInsert->bindParam(":Valor_Total", $item['monto']);
        $descripcion = strtoupper($item['nombreEspecie']);
        $stmtInsert->bindParam(":Descripcion", $descripcion);
        $stmtInsert->bindParam(":Estado_Caja", $datos['Estado_Caja']);
        $stmtInsert->bindParam(":Estado_Uso", $datos['Estado_Uso']);
        $stmtInsert->bindParam(":Id_Ingreso_Especie", $datos['Id_Ingreso_Especie']);
        $stmtInsert->bindParam(":DNI", $datos['DNI']);
        $Nombres = strtoupper($datos['Nombres']);
        $stmtInsert->bindParam(":Nombres", $Nombres);
        $stmtInsert->bindParam(":Numero_Proveido", $datos['Numero_Proveido']);
        $stmtInsert->bindParam(":Id_Area", $area_oficina['Id_Area']);
        $stmtInsert->bindParam(":observaciones", $datos['observaciones']);

        // Ejecutar la inserción
        if (!$stmtInsert->execute()) {
            return "error";
        }
    }

    // Si todas las inserciones fueron exitosas
    return "ok";
}


   public static function mdlMostrarProveido($area,$fecha)
   {
      if ($area != null) {

         $stmt = Conexion::conectar()->prepare("SELECT p.Numero_Proveido,p.Nombres,sum(p.Valor_Total) as Valor_Total
                                               FROM proveido p INNER JOIN area a on p.Id_Area=a.Id_Area
                                                WHERE a.Nombre_Area=:area
                                                AND DATE(p.Fecha_Registro) =:fecha AND p.Estado_Registro='R'
                                                GROUP BY p.Numero_Proveido,p.Nombres order by p.Numero_Proveido desc;");
         $stmt->bindParam(":area",$area,PDO::PARAM_STR);
         $stmt->bindParam(":fecha",$fecha,PDO::PARAM_STR);
         $stmt->execute();
         return $stmt->fetchall();
      } else {
         $stmt = Conexion::conectar()->prepare("SELECT * FROM proveido WHERE Estado_Registro='R'");
         //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
         $stmt->execute();
         return $stmt->fetchall();
      }
      $stmt = null;
   }
   public static function mdlMostrarProveido2($numero_proveido,$area)
   {
      if ($numero_proveido != null) {
         $anio = date('Y');
         $stmt = Conexion::conectar()->prepare("SELECT p.*,a.Nombre_Area as Nombre_Area,e.editable as Editable
                                               ,e.Id_Especie_Valorada as  Id_Especie_Valorada
                                                FROM proveido p 
                                                INNER JOIN area a on a.Id_Area=p.Id_Area
                                                INNER JOIN especie_valorada e on e.Id_Especie_Valorada=p.Id_Especie_Valorada
                                                 where p.Numero_Proveido=:numero_proveido and a.Nombre_Area=:area and  YEAR(p.Fecha_Registro)=$anio");
         $stmt->bindParam(":numero_proveido",$numero_proveido);
         $stmt->bindParam(":area",$area);
         $stmt->execute();
         return $stmt->fetchall();
      } else {
         $stmt = Conexion::conectar()->prepare("SELECT * FROM proveido");
         //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
         $stmt->execute();
         return $stmt->fetchall();
      }
      $stmt = null;
   }
   public static function mdlMostrarUltimoProveido($area)
   {
      try {
         // Consulta para obtener el número de registros
        
         $stmt = Conexion::conectar()->prepare("SELECT Numero_Proveido FROM area WHERE Nombre_Area = :area");
         $stmt->bindParam(":area", $area, PDO::PARAM_STR);
         $stmt->execute();
         $resultado = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener el resultado
         return $resultado; // Devolver el resultado como un array asociativo
      } catch (Exception $e) {
         return "Error: " . $e->getMessage();
      }
   }

   public static function mdlMostrar_detalle_pago($numero_proveido,$area)
   {
      try {
         // Consulta para obtener el número de registros
         $anio = date('Y');
         $stmt = Conexion::conectar()->prepare("SELECT p.*,a.Nombre_Area FROM proveido p inner join area a
                                                on a.Id_Area=p.Id_Area 
                                                WHERE p.Numero_Proveido = $numero_proveido And a.Nombre_Area=:area  and  YEAR(p.Fecha_Registro)=$anio");
         $stmt->bindParam(":area", $area, PDO::PARAM_STR);
         $stmt->execute();
         $resultado = $stmt->fetchall(PDO::FETCH_ASSOC); // Obtener el resultado
         return $resultado; // Devolver el resultado como un array asociativo
      } catch (Exception $e) {
         return "Error: " . $e->getMessage();
      }
   }
   public static function mdlMostrarProveidosPiso($datos)
   {
      if ($datos != null) {
         $pdo = Conexion::conectar();
         try {
            $stmtcatastro = $pdo->prepare("SELECT Id_Catastro FROM catastro WHERE Codigo_Catastral=:Codigo_Catastral");
            $stmtcatastro->bindParam(":Codigo_Catastral", $datos['Catastro_Piso']);
            $stmtcatastro->execute();
            //$idCatastro = $stmtcatastro->fetchAll(PDO::FETCH_ASSOC);
            $idCatastro = $stmtcatastro->fetch();
            $idCatastro = $idCatastro['Id_Catastro'];

            // Obtener Id_Predio de acuerdo al año solicitado
            $stmt = $pdo->prepare("SELECT Id_Predio FROM predio WHERE Id_Catastro=:Id_Catastro AND Id_Anio=:Id_Anio");
            $stmt->bindParam(":Id_Catastro", $idCatastro); // Utilizar $registro['Id_Catastro'] para obtener el valor
            $stmt->bindParam(":Id_Anio", $datos['Id_Anio']);
            $stmt->execute();
            //$idPredio = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idPredio = $stmt->fetch(PDO::FETCH_ASSOC);
            $idPredio = $idPredio['Id_Predio'];
            $stmt0 = $pdo->prepare("SELECT * FROM pisos WHERE Id_Predio=:Id_Predio");
            $stmt0->bindParam(":Id_Predio", $idPredio);
            $stmt0->execute();
            $registros = $stmt0->fetchAll(PDO::FETCH_ASSOC);
            if (count($registros) > 0) {
               return $registros;
            } else {
               return 'nulo'; // o 'nulo'
            }
         } catch (Exception $e) {
            return "Error: " . $e->getMessage();
         }
      }
   }
   public static function mdlEditarProveido($tabla, $datos)
   {
      $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET Cantidad=:Cantidad, Valor_Total=:Valor_Total, Descripcion=:Descripcion WHERE Id_Proveido=:Id_Proveido");
      $stmt->bindParam(":Cantidad", $datos['Cantidad'], PDO::PARAM_INT);
      $stmt->bindParam(":Valor_Total", $datos['Valor_Total']);
      $stmt->bindParam(":Descripcion", $datos['Descripcion']);
      $stmt->bindParam(":Id_Proveido", $datos['Id_Proveido']);
      if ($stmt->execute()) {
         return 'ok';
      } else {
         return 'error';
      }
      $stmt = null;
   }
   public static function mdlEliminarProveido($tabla, $datos)
   {   
      $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET Estado_Registro='E' WHERE Id_Proveido=:Id_Proveido");
      $stmt->bindParam(":Id_Proveido", $datos['Id_Proveido']);
      if ($stmt->execute()) {
         return 'ok';
      } else {
         return 'error';
      }
      $stmt = null;
   }
   public static function mdlMostrar_Proveido($numero_proveido,$area)
   {   
      try {
         $anio = date('Y');
         $stmt = Conexion::conectar()->prepare("SELECT p.Nombres as nombres,
                                                       e.Nombre_Especie as nombre_especie,
                                                       e.Id_Especie_Valorada as codigo,
                                                       a.Nombre_Area as nombre_area,
                                                       p.Descripcion as descripcion,
                                                      (p.Valor_Total/p.Cantidad) as monto,
                                                       p.Cantidad as cantidad,
                                                       p.Valor_Total as valor_total,
                                                       p.Numero_Proveido as numero_proveido,
                                                       a.Nombre_Iniciales as nombre_iniciales,
                                                       p.Observaciones as observaciones
                                               FROM proveido p
                                               INNER JOIN area a ON a.Id_Area=p.Id_Area
                                               iNNER JOIN especie_valorada e on e.Id_Especie_Valorada=p.Id_Especie_Valorada 
                                               WHERE p.Numero_Proveido = :numero_proveido AND Estado_Registro='R'
                                               AND a.Nombre_Area=:area and  YEAR(p.Fecha_Registro)=$anio");
         $stmt->bindParam(':numero_proveido', $numero_proveido, PDO::PARAM_INT);
         $stmt->bindParam(':area', $area, PDO::PARAM_STR);
         $stmt->execute();
         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
         $stmt = null;   
         if (!$result) {
             return "Algo salio mal, comunicate con el Administrador del Sistema";
         } else {
            return $result;
         }
     } catch (PDOException $e) {
         echo "Error: " . $e->getMessage();
     }
   }
}
