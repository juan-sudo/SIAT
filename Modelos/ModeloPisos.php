<?php

namespace Modelos;

use Conect\Conexion;
use Exception;
use PDO;

class ModeloPisos
{
   public static function mdlNuevoPiso($tabla, $datos)
   {
      $pdo1 = Conexion::conectar();
      //----Obtener Id_Catastro
      $stmtcatastro = $pdo1->prepare("SELECT Id_Catastro FROM catastro WHERE Codigo_Catastral=:Codigo_Catastral");
      $stmtcatastro->bindParam(":Codigo_Catastral", $datos['Catastro_Piso']);
      $stmtcatastro->execute();
      $idCatastro = $stmtcatastro->fetch();
      $idCatastro = $idCatastro['Id_Catastro'];
      //------Obtener Id_Predio
      $stmt = $pdo1->prepare("SELECT Id_Predio FROM predio WHERE Id_Catastro=:Id_Catastro AND Id_Anio=:Id_Anio");
      $stmt->bindParam(":Id_Catastro", $idCatastro); // Utilizar ['Id_Catastro'] para obtener el valor
      $stmt->bindParam(":Id_Anio", $datos['idAnioFiscal']);
      if ($stmt->execute()) {
         $idPredio = $stmt->fetch();
         $idPredio = $idPredio['Id_Predio'];
      }
      //----Contar el número de pisos*/
      $stmt0 = $pdo1->prepare("SELECT COUNT(*) FROM pisos WHERE Id_Predio=:Id_Predio");
      $stmt0->bindParam(":Id_Predio", $idPredio);
      $stmt0->execute();
      $numeroPiso = $stmt0->fetchColumn();
      //var_dump($numeroPiso);
      if ($numeroPiso > 0) {
         $numeroPiso = $numeroPiso + 1;
      } else {
         $numeroPiso = 1;
      }
      //Obteniendo el ID del valor Columna
      $stmt = $pdo1->prepare("SELECT Id_Valores_Edificacion FROM valores_edificacion WHERE Id_Anio=:Id_Anio AND Id_Categoria=:Id_Categoria AND Id_Parametro=:Id_Parametro");
      $stmt->bindParam(":Id_Anio", $datos['idAnioFiscal']);
      $stmt->bindParam(":Id_Categoria", $datos['murosColumnas']);
      $stmt->bindValue(":Id_Parametro", 1); //Muros y Columnas
      $stmt->execute();
      $resultadoC = $stmt->fetch();
      $idValorColumna = $resultadoC['Id_Valores_Edificacion'];
      //Obteniendo el ID del valor Techo
      $stmt = $pdo1->prepare("SELECT Id_Valores_Edificacion FROM valores_edificacion WHERE Id_Anio=:Id_Anio AND Id_Categoria=:Id_Categoria AND Id_Parametro=:Id_Parametro");
      $stmt->bindParam(":Id_Anio", $datos['idAnioFiscal']);
      $stmt->bindParam(":Id_Categoria", $datos['techos']);
      $stmt->bindValue(":Id_Parametro", 2); //Techos
      $stmt->execute();
      $resultadoT = $stmt->fetch();
      $idValorTecho = $resultadoT['Id_Valores_Edificacion'];
      //Obteniendo el ID del valor Puertas y Ventanas
      $stmt = $pdo1->prepare("SELECT Id_Valores_Edificacion FROM valores_edificacion WHERE Id_Anio=:Id_Anio AND Id_Categoria=:Id_Categoria AND Id_Parametro=:Id_Parametro");
      $stmt->bindParam(":Id_Anio", $datos['idAnioFiscal']);
      $stmt->bindParam(":Id_Categoria", $datos['puertasVentanas']);
      $stmt->bindValue(":Id_Parametro", 4); //Puertas y Ventanas
      $stmt->execute();
      $resultadoP = $stmt->fetch();
      $idValorPuertas = $resultadoP['Id_Valores_Edificacion'];

      //--- Insertar Piso
      try {
         $stmt1 = $pdo1->prepare("INSERT INTO $tabla(Catastro_Piso, Numero_Piso, Incremento, Fecha_Construccion, Cantidad_Anios, Valores_Unitarios, Porcentaje_Depreciacion,	Valor_Unitario_Depreciado,	Area_Construida, Valor_Area_Construida, Areas_Comunes, Valor_Areas_Comunes, Valor_Construida, Categorias_Edificacion, Id_Estado_Conservacion, Id_Clasificacion_Piso, Id_Material_Piso, Id_Predio) VALUES (:Catastro_Piso, :Numero_Piso, :Incremento, :Fecha_Construccion, :Cantidad_Anios, :Valores_Unitarios, :Porcentaje_Depreciacion, :Valor_Unitario_Depreciado, :Area_Construida, :Valor_Area_Construida, :Areas_Comunes, :Valor_Areas_Comunes, :Valor_Construida, :Categorias_Edificacion, :Id_Estado_Conservacion, :Id_Clasificacion_Piso, :Id_Material_Piso, :Id_Predio)");
         $stmt1->bindParam(":Catastro_Piso", $datos['Catastro_Piso']);
         $stmt1->bindParam(":Numero_Piso", $numeroPiso);
         $stmt1->bindParam(":Incremento", $datos['Incremento']);
         $stmt1->bindParam(":Fecha_Construccion", $datos['Fecha_Construccion']);
         $stmt1->bindParam(":Cantidad_Anios", $datos['Cantidad_Anios']);
         $stmt1->bindParam(":Valores_Unitarios", $datos['Valores_Unitarios']);
         $stmt1->bindParam(":Porcentaje_Depreciacion", $datos['Porcentaje_Depreciacion']);
         $stmt1->bindParam(":Valor_Unitario_Depreciado", $datos['Valor_Unitario_Depreciado']);
         $stmt1->bindParam(":Area_Construida", $datos['Area_Construida']);
         $stmt1->bindParam(":Valor_Area_Construida", $datos['Valor_Area_Construida']);
         $stmt1->bindParam(":Areas_Comunes", $datos['Areas_Comunes']);
         $stmt1->bindParam(":Valor_Areas_Comunes", $datos['Valor_Areas_Comunes']);
         $stmt1->bindParam(":Valor_Construida", $datos['Valor_Construida']);
         $stmt1->bindParam(":Categorias_Edificacion", $datos['Categorias_Edificacion']);
         $stmt1->bindParam(":Id_Estado_Conservacion", $datos['Id_Estado_Conservacion']);
         $stmt1->bindParam(":Id_Clasificacion_Piso", $datos['Id_Clasificacion_Piso']);
         $stmt1->bindParam(":Id_Material_Piso", $datos['Id_Material_Piso']);
         $stmt1->bindParam(":Id_Predio", $idPredio);

         if (($stmt1->execute()) and (sumar_area($idPredio) == 'ok')) {
            $id_ultimoPiso = $pdo1->lastInsertId();
            if ((InsertarValorEdificacionPiso($idValorColumna, $id_ultimoPiso) == "oks") and (InsertarValorEdificacionPiso($idValorTecho, $id_ultimoPiso) == "oks") and (InsertarValorEdificacionPiso($idValorPuertas, $id_ultimoPiso) == "oks")) {
               return 'ok';
            }
         }
         $pdo1 = null;
      } catch (Exception $e) {
         echo "Error en BD al registrar piso : " . $e->getMessage();
      }
   }
   public static function mdlModificarPiso($datos)
   {
      $pdo1 = Conexion::conectar();
      //Obteniendo el ID del valor Columna
      $stmt = $pdo1->prepare("SELECT Id_Valores_Edificacion FROM valores_edificacion WHERE Id_Anio=:Id_Anio AND Id_Categoria=:Id_Categoria AND Id_Parametro=:Id_Parametro");
      $stmt->bindParam(":Id_Anio", $datos['idAnioFiscal']);
      $stmt->bindParam(":Id_Categoria", $datos['IdMurosColumnas']);
      $stmt->bindValue(":Id_Parametro", 1); //Muros y Columnas
      $stmt->execute();
      $resultadoC = $stmt->fetch();
      $idValorColumna = $resultadoC['Id_Valores_Edificacion'];
      //Obteniendo el ID del valor Techo
      $stmt = $pdo1->prepare("SELECT Id_Valores_Edificacion FROM valores_edificacion WHERE Id_Anio=:Id_Anio AND Id_Categoria=:Id_Categoria AND Id_Parametro=:Id_Parametro");
      $stmt->bindParam(":Id_Anio", $datos['idAnioFiscal']);
      $stmt->bindParam(":Id_Categoria", $datos['IdTechos']);
      $stmt->bindValue(":Id_Parametro", 2); //Techos
      $stmt->execute();
      $resultadoT = $stmt->fetch();
      $idValorTecho = $resultadoT['Id_Valores_Edificacion'];
      //Obteniendo el ID del valor Puertas y Ventanas
      $stmt = $pdo1->prepare("SELECT Id_Valores_Edificacion FROM valores_edificacion WHERE Id_Anio=:Id_Anio AND Id_Categoria=:Id_Categoria AND Id_Parametro=:Id_Parametro");
      $stmt->bindParam(":Id_Anio", $datos['idAnioFiscal']);
      $stmt->bindParam(":Id_Categoria", $datos['IdPuertaspuertasVentanas']);
      $stmt->bindValue(":Id_Parametro", 4); //Puertas y Ventanas
      $stmt->execute();
      $resultadoP = $stmt->fetch();
      $idValorPuertas = $resultadoP['Id_Valores_Edificacion'];
      try {
         $stm1 = $pdo1->prepare("UPDATE pisos SET 
      Fecha_Construccion = :Fecha_Construccion, 
      Cantidad_Anios = :Cantidad_Anios, 
      Valores_Unitarios = :Valores_Unitarios, 
      Porcentaje_Depreciacion = :Porcentaje_Depreciacion, 
      Valor_Unitario_Depreciado = :Valor_Unitario_Depreciado, 
      Area_Construida = :Area_Construida, 
      Valor_Area_Construida = :Valor_Area_Construida, 
      Areas_Comunes = :Areas_Comunes, 
      Valor_Areas_Comunes = :Valor_Areas_Comunes, 
      Valor_Construida = :Valor_Construida, 
      Categorias_Edificacion = :Categorias_Edificacion, 
      Id_Estado_Conservacion = :Id_Estado_Conservacion, 
      Id_Clasificacion_Piso = :Id_Clasificacion_Piso, 
      Id_Material_Piso = :Id_Material_Piso
      WHERE Id_Piso = :Id_Piso");
         $stm1->bindParam(":Fecha_Construccion", $datos['Fecha_Construccion']);
         $stm1->bindParam(":Cantidad_Anios", $datos['Cantidad_Anios']);
         $stm1->bindParam(":Valores_Unitarios", $datos['Valores_Unitarios']);
         $stm1->bindParam(":Porcentaje_Depreciacion", $datos['Porcentaje_Depreciacion']);
         $stm1->bindParam(":Valor_Unitario_Depreciado", $datos['Valor_Unitario_Depreciado']);
         $stm1->bindParam(":Area_Construida", $datos['Area_Construida']);
         $stm1->bindParam(":Valor_Area_Construida", $datos['Valor_Area_Construida']);
         $stm1->bindParam(":Areas_Comunes", $datos['Areas_Comunes']);
         $stm1->bindParam(":Valor_Areas_Comunes", $datos['Valor_Areas_Comunes']);
         $stm1->bindParam(":Valor_Construida", $datos['Valor_Construida']);
         $stm1->bindParam(":Categorias_Edificacion", $datos['Categorias_Edificacion']);
         $stm1->bindParam(":Id_Estado_Conservacion", $datos['Id_Estado_Conservacion']);
         $stm1->bindParam(":Id_Clasificacion_Piso", $datos['Id_Clasificacion_Piso']);
         $stm1->bindParam(":Id_Material_Piso", $datos['Id_Material_Piso']);
         $stm1->bindParam(":Id_Piso", $datos['Id_Piso']);
         if (($stm1->execute()) and (sumar_area($datos['Id_Predio']) == 'ok')) {
            if ((ActualizarValorEdificacionPiso($idValorColumna, $datos['Id_Piso']) == "oks") and (ActualizarValorEdificacionPiso($idValorTecho, $datos['Id_Piso']) == "oks") and (ActualizarValorEdificacionPiso($idValorPuertas, $datos['Id_Piso']) == "oks")) {
               return 'ok';
            }
         }
         $pdo1 = null;
      } catch (Exception $e) {
         echo "Error en BD al modificar piso : " . $e->getMessage();
      }
   }
   public static function mdlEliminarPiso($datos)
   {
      $pdo1 = Conexion::conectar();
      $pdo1->beginTransaction(); // Iniciar una transacción

      try {
         $stmt1 = $pdo1->prepare("SELECT Id_Predio FROM pisos WHERE Id_Piso=:Id_Piso");
         $stmt1->bindParam(":Id_Piso", $datos['Id_Piso']);
         $stmt1->execute();
         $resultap = $stmt1->fetch(PDO::FETCH_ASSOC);
         $stmt1 = $pdo1->prepare("SELECT Area_Construida FROM pisos WHERE Id_Piso=:Id_Piso");
         $stmt1->bindParam(":Id_Piso", $datos['Id_Piso']);
         $stmt1->execute();
         $resultaa = $stmt1->fetch(PDO::FETCH_ASSOC);
         $stmt1 = $pdo1->prepare("SELECT Valor_Construida FROM pisos WHERE Id_Piso=:Id_Piso");
         $stmt1->bindParam(":Id_Piso", $datos['Id_Piso']);
         $stmt1->execute();
         $resultav = $stmt1->fetch(PDO::FETCH_ASSOC);
         if ($resultap) {
            $idpredio = $resultap['Id_Predio'];
            $areacons = $resultaa['Area_Construida'];
            $valcons = $resultav['Valor_Construida'];

            $stmt = $pdo1->prepare("SELECT Area_Construccion, Valor_Construccion, Valor_predio, Valor_Predio_Aplicar   FROM predio WHERE Id_Predio = :Id_Predio");
            $stmt->bindParam(":Id_Predio", $idpredio);
            $stmt->execute();
            $resultado2 = $stmt->fetch();
            $areconspre = $resultado2['Area_Construccion'];
            $valconspre = $resultado2['Valor_Construccion'];
            $valpre = $resultado2['Valor_predio'];
            $valpredioap = $resultado2['Valor_Predio_Aplicar'];
            $areconspre = $areconspre -$areacons;
            $valconspre = $valconspre -$valcons;
            $valpre = $valpre -$valcons;
            $valpredioap = $valpre;
            $stmt = $pdo1->prepare("UPDATE predio SET Area_Construccion=:Area_Construccion, 
                                   Valor_Construccion=:Valor_Construccion, 
                                   Valor_predio=:Valor_predio,Valor_Predio_Aplicar=:Valor_Predio_Aplicar WHERE Id_Predio = :Id_Predio");
            $stmt->bindParam(":Area_Construccion", $areconspre);
            $stmt->bindParam(":Valor_Construccion", $valconspre);
            $stmt->bindParam(":Valor_predio", $valpre);
            $stmt->bindParam(":Valor_Predio_Aplicar", $valpredioap);
            $stmt->bindParam(":Id_Predio", $idpredio);
            $stmt->execute();
         }

         $stmt0 = $pdo1->prepare("DELETE FROM edificacion_piso WHERE Id_Piso=:Id_Piso");
         $stmt0->bindParam(":Id_Piso", $datos['Id_Piso']);
         $stmt0->execute();

         // Eliminar registros de la tabla "pisos"
         $stmt1 = $pdo1->prepare("DELETE FROM pisos WHERE Id_Piso=:Id_Piso");
         $stmt1->bindParam(":Id_Piso", $datos['Id_Piso']);
         $stmt1->execute();

         $pdo1->commit(); // Confirmar la transacción
         return "ok";
      } catch (Exception $e) {
         $pdo1->rollBack(); // Deshacer la transacción en caso de error
         throw new Exception("Error al eliminar piso: " . $e->getMessage());
      }
   }
   public static function mdlMostrarCategorias($tabla, $anio)
   {
      if ($anio != null) {
         $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE Anio=:Anio");
         $stmt->bindParam(":Anio", $anio);
         $stmt->execute();
         return $stmt->fetchAll();
      } else {
         return "ocurrio un error";
      }
      $stmt = null;
   }
   public static function mdlMostrarValorEdificacion($tabla, $datos)
   {
      if ($datos != null) {
         $stmt = Conexion::conectar()->prepare("SELECT Monto  FROM $tabla v inner JOIN anio a on v.Id_Anio= a.Id_Anio WHERE a.NomAnio=:nomAnio AND Id_Categoria=:Id_Categoria and Id_Parametro=:Id_Parametro");
         $stmt->bindParam(":nomAnio", $datos['nomAnio']);
         $stmt->bindParam(":Id_Categoria", $datos['Id_Categoria']);
         $stmt->bindParam(":Id_Parametro", $datos['Id_Parametro']);
         if ($stmt->execute()) {
            return $stmt->fetch();
         } else {
            return "Ocurrió un error";
         }
         $stmt = null;
      }
   }
   public static function mdlMostrarTasaDepreciacion($tabla, $datos)
   {
      if ($datos != null) {
         $stmt = Conexion::conectar()->prepare("SELECT Porcentaje  FROM $tabla WHERE Id_Anio_Antiguedad =:Id_Anio_Antiguedad  and Id_Material_Piso=:Id_Material_Piso and Id_Clasificacion_Piso=:Id_Clasificacion_Piso and Id_Estado_Conservacion=:Id_Estado_Conservacion");
         $stmt->bindParam(":Id_Anio_Antiguedad", $datos['Id_Anio_Antiguedad']);
         $stmt->bindParam(":Id_Material_Piso", $datos['Id_Material_Piso']);
         $stmt->bindParam(":Id_Clasificacion_Piso", $datos['Id_Clasificacion_Piso']);
         $stmt->bindParam(":Id_Estado_Conservacion", $datos['Id_Estado_Conservacion']);
         if ($stmt->execute()) {
            $valor = $stmt->fetch();
            $valor_porcentaje = $valor['Porcentaje'];

            return $valor_porcentaje;
         } else {
            return "Error al buscar Tasa";
         }

         $stmt = null;
      }
   }
   public static function mdlMostrarPisosDelPredio($datos)
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
            $stmt = $pdo->prepare("SELECT Id_Predio FROM predio WHERE Id_Catastro=:Id_Catastro AND Id_Anio=:Id_Anio ORDER BY Fecha_Registro DESC 
                               LIMIT 1");
            $stmt->bindParam(":Id_Catastro", $idCatastro); // Utilizar $registro['Id_Catastro'] para obtener el valor
            $stmt->bindParam(":Id_Anio", $datos['Id_Anio']);
            $stmt->execute();


            //$idPredio = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $idPredio = $stmt->fetch(PDO::FETCH_ASSOC);
            $idPredio = $idPredio['Id_Predio'];

           //  var_dump($idPredio);

            $stmt0 = $pdo->prepare("SELECT * FROM pisos WHERE Id_Predio=:Id_Predio order by Numero_Piso");
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
   public static function mdlMostrarPiso($tabla, $datos)
   {
      $pdo = Conexion::conectar();
      try {
         $stmt = $pdo->prepare("SELECT * FROM $tabla WHERE Id_Piso=:Id_Piso");
         $stmt->bindParam(":Id_Piso", $datos['Id_Piso']);
         $stmt->execute();
         $pisorResul = $stmt->fetchAll(PDO::FETCH_ASSOC);
         $stmt = null;
         return $pisorResul;
      } catch (Exception $e) {
         return "Error: " . $e->getMessage();
      }
   }
}
function sumar_area($idPredio)
{
   try {
      // Establecer la conexión a la base de datos
      $pdo = Conexion::conectar();

      // Calcular la suma del área construida y el valor de área construida
      $stmt = $pdo->prepare("SELECT SUM(Area_Construida) as areaC, SUM(Valor_Area_Construida) as valorC FROM pisos WHERE Id_Predio = :Id_Predio");
      $stmt->bindParam(":Id_Predio", $idPredio);
      $stmt->execute();
      $resultado = $stmt->fetch();
      $areaConstruccion = $resultado['areaC'];
      $valorConstruccion = $resultado['valorC'];
      //calculo del valor del predio 
      $stmt = $pdo->prepare("SELECT Valor_Otras_Instalacions, Valor_Terreno FROM predio WHERE Id_Predio = :Id_Predio");
      $stmt->bindParam(":Id_Predio", $idPredio);
      $stmt->execute();
      $resultado2 = $stmt->fetch();
      $valOtrasInstalaciones = $resultado2['Valor_Otras_Instalacions'];
      $valTerreno = $resultado2['Valor_Terreno'];
      $valorPredio = $valorConstruccion + $valTerreno + $valOtrasInstalaciones;
      // Actualizar el campo "Area_Construccion" en la tabla "predio"
      $stmt = $pdo->prepare("UPDATE predio SET Area_Construccion=:Area_Construccion, 
                             Valor_Construccion=:Valor_Construccion, 
                             Valor_predio=:Valor_predio,Valor_Predio_Aplicar=:Valor_Predio_Aplicar WHERE Id_Predio = :Id_Predio");
      $stmt->bindParam(":Area_Construccion", $areaConstruccion);
      $stmt->bindParam(":Valor_Construccion", $valorConstruccion);
      $stmt->bindParam(":Valor_predio", $valorPredio);
      $stmt->bindParam(":Valor_Predio_Aplicar", $valorPredio);
      $stmt->bindParam(":Id_Predio", $idPredio);
      $stmt->execute();
      // Cerrar la conexión a la base de datos
      $pdo = null;
      return 'ok';
   } catch (Exception $e) {
      throw new Exception("Error en la base de datos al actualizar el area de construccion y valor de construccion: " . $e->getMessage());
   }
}
function InsertarValorEdificacionPiso($idValorEdifica, $id_Piso)
{
   try {
      $pdo = Conexion::conectar();
      $stmt = $pdo->prepare("INSERT INTO edificacion_piso(Id_Valores_Edificacion, Id_Piso) VALUES(:Id_Valores_Edificacion,:Id_Piso)");
      $stmt->bindParam(":Id_Valores_Edificacion", $idValorEdifica);
      $stmt->bindParam(":Id_Piso", $id_Piso);
      $stmt->execute();
      return "oks";
      $pdo = null;
   } catch (Exception $e) {
      throw new Exception("Error en la base de datos al insertar los valores de Edificacion: " . $e->getMessage());
   }
}
function ActualizarValorEdificacionPiso($idValorEdifica, $id_Piso)
{
   try {
      $pdo = Conexion::conectar();
      $stmt = $pdo->prepare("UPDATE edificacion_piso SET Id_Valores_Edificacion = :Id_Valores_Edificacion WHERE Id_Piso = :Id_Piso");
      $stmt->bindParam(":Id_Valores_Edificacion", $idValorEdifica);
      $stmt->bindParam(":Id_Piso", $id_Piso);
      $stmt->execute();
      $pdo = null; // Mueve esta línea al final para cerrar la conexión después de ejecutar la consulta
      return "oks";
   } catch (Exception $e) {
      throw new Exception("Error en la base de datos al modificar los valores de Edificacion: " . $e->getMessage());
   }
}
