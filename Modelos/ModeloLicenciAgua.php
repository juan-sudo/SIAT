<?php

namespace Modelos;

use Conect\Conexion;
use Exception;
use PDO;
use PDOException;

class ModeloLicenciAgua
{
  public static function mdlNuevaLicencia($tabla, $datos)
  {
    $stmt = Conexion::conectar()->prepare("SELECT * FROM proveido WHERE Id_Proveido=:Id_Proveido");
    $stmt->bindParam(":Id_Proveido", $datos['idproveidor']);
    $stmt->execute();
    $resultado = $stmt->fetch();
    if ($resultado) {
      $resultado = $resultado['Estado_Uso'];
      
      if ($resultado == 0) {
        $stmt0 = Conexion::conectar()->prepare("UPDATE proveido SET Estado_Uso = 0 WHERE Id_Proveido=:Id_Proveido");
        $stmt0->bindParam(":Id_Proveido", $datos['idproveidor']);
        $stmt0->execute();

   
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(Numero_Licencia,Tipo_Licencia,
                                                           Permanencia, 
                                                           Extension_Suministro, 
                                                           PVC_Diametro, 
                                                           Numero_Expediente, 
                                                           Fecha_Expediente, 
                                                           Fecha_Expedicion, 
                                                           Estado, 
                                                           Id_Contribuyente, 
                                                           DNI_Licencia, 
                                                           Nombres_Licencia, 
                                                           Id_Categoria_Agua, 
                                                           Observacion, 
                                                           Inspeccion, 
                                                           Rotura_vereda, 
                                                           Numero_Recibo, 
                                                           Numero_Proveido,
                                                           codigo_sa,
                                                           Id_Ubica_Vias_Urbano ,
                                                           Numero_Ubicacion,
                                                           Lote,
                                                           Luz,
                                                           Descuento_sindicato,
                                                           Numero_Resolucion_Sindicato,
                                                           Descuento_pago_servicio,
                                                           Numero_Pago_Servicio,
                                                           Referencia ) 
                                                           VALUES ( 
                                                           :Numero_Licencia, 
                                                           :Tipo_Licencia, 
                                                           :Permanencia, 
                                                           :Extension_Suministro, 
                                                           :PVC_Diametro, 
                                                           :Numero_Expediente, 
                                                           :Fecha_Expediente, 
                                                           :Fecha_Expedicion, 
                                                           :Estado, 
                                                           :Id_Contribuyente, 
                                                           :DNI_Licencia, 
                                                           :Nombres_Licencia, 
                                                           :Id_Categoria_Agua, 
                                                           :Observacion, 
                                                           :Inspeccion, 
                                                           :Rotura_vereda, 
                                                           :Numero_Recibo, 
                                                           :Numero_Proveido,
                                                           :codigo_sa,
                                                           :Id_Ubica_Vias_Urbano,
                                                           :Numero_Ubicacion,
                                                           :Lote,
                                                           :Luz,
                                                           :Descuento_sindicato,
                                                           :Numero_Resolucion_Sindicato,
                                                           :Descuento_pago_servicio,
                                                           :Numero_Pago_Servicio,
                                                           :Referencia)");
        $stmt->bindParam(":Numero_Licencia", $datos['Numero_Licencia']);
        $stmt->bindParam(":Tipo_Licencia", $datos['Tipo_Licencia']);
        $stmt->bindParam(":Permanencia", $datos['Permanencia']);
        $stmt->bindParam(":Extension_Suministro", $datos['Extension_Suministro']);
        $stmt->bindParam(":PVC_Diametro", $datos['PVC_Diametro']);
        $stmt->bindParam(":Numero_Expediente", $datos['Numero_Expediente']);
        $stmt->bindParam(":Fecha_Expediente", $datos['Fecha_Expediente']);
        $stmt->bindParam(":Fecha_Expedicion", $datos['Fecha_Expedicion']);
        $stmt->bindParam(":Estado", $datos['Estado']);

        
        if ($datos['Id_Contribuyente'] == "OTROS") {
          $Id_Contribuyente = "NULL";
        } else {
          $Id_Contribuyente = $datos['Id_Contribuyente'];
        }
        $stmt->bindParam(":Id_Contribuyente", $Id_Contribuyente);
        $stmt->bindParam(":DNI_Licencia", $datos['DNI_Licencia']);
        $stmt->bindParam(":Nombres_Licencia", $datos['Nombres_Licencia']);
        $stmt->bindParam(":Id_Categoria_Agua", $datos['Id_Categoria_Agua']);
        $stmt->bindParam(":Observacion", $datos['Observacion']);
        $stmt->bindParam(":Inspeccion", $datos['Inspeccion']);
        $stmt->bindParam(":Rotura_vereda", $datos['Rotura_vereda']);
        $stmt->bindParam(":Numero_Recibo", $datos['Numero_Recibo']);
        $stmt->bindParam(":Numero_Proveido", $datos['Numero_Proveido']);
        $stmt->bindParam(":codigo_sa", $datos['codigo_sa']);
        $stmt->bindParam(":Id_Ubica_Vias_Urbano", $datos['id_via'], PDO::PARAM_INT);
        $stmt->bindParam(":Numero_Ubicacion", $datos['nroUbicacion']);
        $stmt->bindParam(":Lote", $datos['nroLote']);
        $stmt->bindParam(":Luz", $datos['nroLuz']);
        $stmt->bindParam(":Referencia", $datos['ref']);
        $stmt->bindParam(":Descuento_sindicato", $datos['Descuento_sindicato']);
        $stmt->bindParam(":Numero_Resolucion_Sindicato", $datos['Numero_Resolucion_Sindicato']);
        $stmt->bindParam(":Descuento_pago_servicio", $datos['Descuento_pago_servicio']);
        $stmt->bindParam(":Numero_Pago_Servicio", $datos['Numero_Pago_Servicio']);
 

        if ($stmt->execute()) {
          $stmt = null;
          return "ok";
        } else {
          $stmt = null;
          return "error";
        }
      }else{
       return "bad";
       }
    }
  }
  public static function mdlMostrarLicencias($datos)
  {
        $stmt = Conexion::conectar()->prepare("SELECT l.*,t.Codigo as tipo_via,
                                                      nv.Nombre_Via as nombre_calle,
                                                      m.NumeroManzana as numManzana,
                                                      cu.Numero_Cuadra as cuadra,
                                                      z.Nombre_Zona as zona,
                                                      h.Habilitacion_Urbana as habilitacion,
                                                      u.Id_Ubica_Vias_Urbano as id
                                                      FROM licencia_agua l 
                inner join categoria_agua ca  on ca.Id_Categoria_Agua =l.Id_Categoria_Agua
                INNER JOIN ubica_via_urbano u ON u.Id_Ubica_Vias_Urbano = l.Id_Ubica_Vias_Urbano  
                INNER JOIN direccion d ON u.Id_Direccion = d.Id_Direccion 
                INNER JOIN tipo_via t ON t.Id_Tipo_Via = d.Id_Tipo_Via 
                INNER JOIN zona z ON u.Id_Zona = z.Id_Zona
                INNER JOIN manzana m ON u.Id_Manzana = m.Id_Manzana 
                INNER JOIN cuadra cu ON cu.Id_cuadra = u.Id_Cuadra 
                INNER JOIN habilitaciones_urbanas h ON h.Id_Habilitacion_Urbana = z.Id_Habilitacion_Urbana 
                INNER JOIN nombre_via nv ON nv.Id_Nombre_Via = d.Id_Nombre_Via  
                                              
                                                WHERE Id_Contribuyente =:id_condtribuyente AND Estado=1");
     $stmt->bindParam(":id_condtribuyente",$datos['id_contribuyente_agua']);
      $stmt->execute();
      return $stmt->fetchAll();
    
  }

  public static function mdlMostrarLicencias_calcular($datos)
  {
        $stmt = Conexion::conectar()->prepare("SELECT l.*,t.Codigo as tipo_via,
                                                      nv.Nombre_Via as nombre_calle,
                                                      m.NumeroManzana as numManzana,
                                                      cu.Numero_Cuadra as cuadra,
                                                      z.Nombre_Zona as zona,
                                                      h.Habilitacion_Urbana as habilitacion,
                                                      u.Id_Ubica_Vias_Urbano as id,
                                                      ca.Monto as Monto,
                                                      a.Importe as importe
                                                      FROM licencia_agua l 
                inner join categoria_agua ca  on ca.Id_Categoria_Agua =l.Id_Categoria_Agua
                INNER JOIN ubica_via_urbano u ON u.Id_Ubica_Vias_Urbano = l.Id_Ubica_Vias_Urbano  
                INNER JOIN direccion d ON u.Id_Direccion = d.Id_Direccion 
                INNER JOIN tipo_via t ON t.Id_Tipo_Via = d.Id_Tipo_Via 
                INNER JOIN zona z ON u.Id_Zona = z.Id_Zona
                INNER JOIN manzana m ON u.Id_Manzana = m.Id_Manzana 
                INNER JOIN cuadra cu ON cu.Id_cuadra = u.Id_Cuadra 
                INNER JOIN habilitaciones_urbanas h ON h.Id_Habilitacion_Urbana = z.Id_Habilitacion_Urbana 
                INNER JOIN nombre_via nv ON nv.Id_Nombre_Via = d.Id_Nombre_Via  
                INNER JOIN arancel_vias av ON av.Id_Ubica_Vias_Urbano=U.Id_Ubica_Vias_Urbano
                INNER JOIN arancel a ON a.Id_Arancel=av.Id_Arancel 
                                              
                                                WHERE Id_Licencia_Agua =:id_licencia AND Estado=1");
     $stmt->bindParam(":id_licencia",$datos['id_licencia']);
      $stmt->execute();
      return $stmt->fetchAll();
    
  }

  public static function mdlMostrarLicencias_deuda($idcatastro)
  {
      $stmt = Conexion::conectar()->prepare("SELECT * FROM licencia_agua l 
                                             inner join categoria_agua c on l.Id_Categoria_Agua=c.Id_Categoria_Agua 
                                             where Estado=1 AND Id_Catastro=$idcatastro");
      $stmt->execute();
      return $stmt->fetchall();
   
  }
  public static function mdlConsultaGenerica($tabla, $item, $valor)
  {
    $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla 
                                          WHERE $item = :$item AND Id_Especie_Valorada=127 AND Estado='P'");
    $stmt->bindParam(":" . $item, $valor);
    $stmt->execute();
    $results = $stmt->fetchAll();

    // Verificar si hay resultados
    if (count($results) > 0) {
      array_push($results, "OK");
    } else {
      $results = array("NO");
    }
    return $results;
  }

  public static function mdlLastRegistro($tabla, $valor)
  {
    $stmt = Conexion::conectar()->prepare("SELECT MAX(Numero_Licencia) as Numero_Licencia FROM $tabla WHERE YEAR(Fecha_Registro)=:datee; ");
    $stmt->bindParam(":datee", $valor);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;
  }

  //BARRA DE PROGRESO AAGUA
  public static function mdlMostrarBarraProgreso($idContribuyente)
  {
    $stmt = Conexion::conectar()->prepare("SELECT Estado_progreso FROM contribuyente WHERE Id_Contribuyente=:idContribuyente;");
    $stmt->bindParam(":idContribuyente", $idContribuyente);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;
    
  }


  //EDITAR BARRA DE PROGRESO DE AGUA
   public static function mdlEditarCarpetaProgresoAgua($tabla, $datos)
  {
      // Conexión a la base de datos
      $conexion = Conexion::conectar();
  
      // Preparar la consulta UPDATE para modificar Estado_progreso según Concatenado_id
      $stmtUpdate = $conexion->prepare("UPDATE contribuyente SET Estado_progreso = :Estado_progreso WHERE Id_Contribuyente = :Id_contribuyente");
  
      // Enlazar los parámetros
      $stmtUpdate->bindParam(":Estado_progreso", $datos['Estado_progreso'], PDO::PARAM_STR);
      $stmtUpdate->bindParam(":Id_contribuyente", $datos['Id_contribuyente'], PDO::PARAM_INT);
  
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
  

  
 


  public static function mdlEditarLiciencia($tabla, $datos)
  {
    //var_dump( $datos);

    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET Numero_Expediente =:Numero_Expediente,
    Fecha_Expediente =:Fecha_Expediente,
    Fecha_Expedicion =:Fecha_Expedicion,
    Permanencia =:Permanencia,
    PVC_Diametro =:PVC_Diametro,
    Id_Categoria_Agua =:Id_Categoria_Agua,
    Extension_Suministro =:Extension_Suministro,
    Inspeccion =:Inspeccion,
    Rotura_vereda =:Rotura_vereda,
    Observacion =:Observacion,
    Id_Ubica_Vias_Urbano=:idvia,
    Numero_Ubicacion=:numeracion,
    Lote=:lote,
    Luz=:luz,
    Descuento_sindicato=:Descuento_sindicato,
    Descuento_pago_servicio=:Descuento_pago_servicio,
    Numero_Resolucion_Sindicato=:Numero_Resolucion_Sindicato,
    Numero_Pago_Servicio=:Numero_Pago_Servicio,
    
    Referencia=:referencia  WHERE Id_Licencia_Agua=:Id_Licencia_Agua");

    $stmt->bindParam(":Numero_Expediente", $datos['Numero_Expediente']);
    $stmt->bindParam(":Fecha_Expediente", $datos['Fecha_Expediente']);
    $stmt->bindParam(":Fecha_Expedicion", $datos['Fecha_Expedicion']);
    $stmt->bindParam(":Permanencia", $datos['Permanencia']);
    $stmt->bindParam(":PVC_Diametro", $datos['PVC_Diametro']);
    $stmt->bindParam(":Id_Categoria_Agua", $datos['Id_Categoria_Agua']);
    $stmt->bindParam(":Extension_Suministro", $datos['Extension_Suministro']);
    $stmt->bindParam(":Inspeccion", $datos['Inspeccion']);
    $stmt->bindParam(":Rotura_vereda", $datos['Rotura_vereda']);
    $stmt->bindParam(":Observacion", $datos['Observacion']);
    $stmt->bindParam(":Id_Licencia_Agua", $datos['Id_Licencia_Agua']);
    $stmt->bindParam(":idvia", $datos['idvia']);
    $stmt->bindParam(":numeracion", $datos['numeracion']);
    $stmt->bindParam(":lote", $datos['lote']);
    $stmt->bindParam(":luz", $datos['luz']);
    $stmt->bindParam(":referencia", $datos['referencia']);
    $stmt->bindParam(":Descuento_sindicato", $datos['Descuento_sindicato']);
    $stmt->bindParam(":Descuento_pago_servicio",  $datos['Descuento_pago_servicio']);
    $stmt->bindParam(":Numero_Resolucion_Sindicato", $datos['Numero_Resolucion_Sindicato']);
    $stmt->bindParam(":Numero_Pago_Servicio", $datos['Numero_Pago_Servicio']);


    if ($stmt->execute()) {
      return 'ok';
    } else {
      return 'error';
    }
  }


  public static function mdlTranferirLiciencia($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET 
                                                             Id_Contribuyente=:idcontribuyente_nuevo,
                                                             Observacion=:obs
                                                             WHERE Id_Licencia_Agua=:Id_Licencia_Agua");
    $stmt->bindParam(":idcontribuyente_nuevo", $datos['idcontribuyente_nuevo']);
    $stmt->bindParam(":Id_Licencia_Agua", $datos['idlicencia']);
    $stmt->bindParam(":obs", $datos['obs']);
    if ($stmt->execute()) {
      return 'ok';
    } else {
      return 'error';
    }
  }
  public static function mdlDeleteLicence($tabla, $datos)
  {
    $pdo1 = Conexion::conectar();
    try {
      $stmt0 = $pdo1->prepare("UPDATE $tabla SET Estado = :Estado WHERE Id_Licencia_Agua=:Id_Licencia_Agua");
      $stmt0->bindValue(":Estado",  $datos['Estado']);
      $stmt0->bindParam(":Id_Licencia_Agua", $datos['Id_Licencia_Agua']);
      $stmt0->execute();
      return "ok";
    } catch (Exception $e) {
      throw new Exception("Error al eliminar Licencia: " . $e->getMessage());
    }
  }

  
  public static function mdlCalcular_Agua($datos)
  {

    
    
    try {
      $pdo = Conexion::conectar();

      //DESCUENTO COACTIVO
        // Asignación predeterminada
        // $descuento = 0.00;
        // $montoAplicar = 0.00;
        // Verificar si las claves existen antes de acceder a ellas
      $descuento = isset($datos['descuento']) ? $datos['descuento'] : 0.00;

      if($descuento==0.5){

        $montoAplicar = isset($datos['monto']) ? $datos['monto'] : 0.00;

        // Ahora, puedes usar estas variables sin generar errores
        
        
                // Verificar si las claves existen en el arreglo
                if (isset($datos['descuento'])) {
                    $descuento = $datos['descuento'];
                }
        
                if (isset($datos['monto'])) {
                    $montoAplicar = $datos['monto'];
                }
        
                // Lógica de asignación
                if ($descuento > 0 ) {
        
                    
                    $descuento = $datos['descuento'];
        
                    $montoAplicar = $datos['monto']*$descuento;
        
                } else {
                    $montoAplicar = $datos['monto'] ?? 0.00;  // Asignar 0 si no está definido
                    $descuento = 0.00;
                }

      }
      elseif($descuento ==2.00){
        
        $montoAplicar = isset($datos['monto']) ? $datos['monto'] : 0.00;

        // Ahora, puedes usar estas variables sin generar errores
        
        
                // Verificar si las claves existen en el arreglo
                if (isset($datos['descuento'])) {
                    $descuento = $datos['descuento'];
                }
        
                if (isset($datos['monto'])) {
                    $montoAplicar = $datos['monto'];
                }
        
                // Lógica de asignación
                if ($descuento > 0 ) {
        
                    
                    $descuento = $datos['descuento'];
        
                    $montoAplicar = $datos['monto']-$descuento;
        
                } else {
                    $montoAplicar = $datos['monto'] ?? 0.00;  // Asignar 0 si no está definido
                    $descuento = 0.00;
                }


      }
      else{
        
      $montoAplicar = isset($datos['monto']) ? $datos['monto'] : 0.00;

      // Ahora, puedes usar estas variables sin generar errores
      
      
              // Verificar si las claves existen en el arreglo
              if (isset($datos['descuento'])) {
                  $descuento = $datos['descuento'];
              }
      
              if (isset($datos['monto'])) {
                  $montoAplicar = $datos['monto'];
              }
      
              // Lógica de asignación
              if ($descuento > 0 ) {
      
                  
                  $descuento = $datos['descuento'];
      
                  $montoAplicar = $datos['monto']-$descuento;
      
              } else {
                  $montoAplicar = $datos['monto'] ?? 0.00;  // Asignar 0 si no está definido
                  $descuento = 0.00;
              }



      }


     

         //DESCUENTO PAGO SERVICIO
        
      $fechaString = $datos['fecha_expedicion'];

// Utiliza completamente la clase DateTime de PHP
$fecha = new \DateTime($fechaString);
$pdo->beginTransaction();   
    if($datos['anio']==$fecha->format('Y')){
          if ($fecha->format('d') >= 15) {
            $meses = range($fecha->format('m')+1, 12); // Si es mayor o igual a 15, considera los meses restantes hasta diciembre
        } else {
            $meses = range($fecha->format('m') , 12); // Si es menor a 15, considera los meses siguientes a partir del próximo mes
        }
    } 
    else{
      $meses = range(1, 12);
    }  
    //validando si existe informacion calculado
   
      foreach ($meses as $mes) {
        $stmt = $pdo->prepare("INSERT INTO estado_cuenta_agua(
                                                                Tipo_Tributo,
                                                                Anio,
                                                                Periodo, 
                                                                Importe, 
                                                                Gasto_Emision, 
                                                                Saldo, 
                                                                Total,
                                                                Estado, 
                                                                Id_Contribuyente,
                                                                Descuento, 
                                                                Total_Aplicar,
                                                                DNI, 
                                                                Nombres,
                                                                Id_Licencia_Agua) 
                                                                VALUES ( 
                                                                         :Tipo_Tributo,
                                                                         :Anio,
                                                                         :Periodo, 
                                                                         :Importe, 
                                                                         :Gasto_Emision, 
                                                                         :Saldo, 
                                                                         :Total,
                                                                         :Estado, 
                                                                         :Id_Contribuyente,
                                                                         :Descuento, 
                                                                         :Total_Aplicar, 
                                                                         :DNI, 
                                                                         :Nombres,
                                                                         :id_licencia)");
        
       
        $stmt->bindValue(":Tipo_Tributo", '005');
        $stmt->bindParam(":Anio", $datos['anio']);
        $stmt->bindValue(":Periodo", $mes);
        $stmt->bindParam(":Importe", $datos['monto']);
        $stmt->bindValue(":Gasto_Emision", 0);
        $stmt->bindParam(":Saldo", $datos['monto']);
        $stmt->bindParam(":Total", $datos['monto']);
        $stmt->bindValue(":Estado", "D");
        $stmt->bindParam(":Id_Contribuyente", $datos['id_contribuyente']);
        $stmt->bindValue(":Descuento", $descuento);
       // $stmt->bindValue(":Descuento",0);
        $stmt->bindParam(":Total_Aplicar", $montoAplicar);
       //  $stmt->bindParam(":Total_Aplicar", $datos['monto']);
        $stmt->bindParam(":DNI", $datos['dni']);
        $stmt->bindParam(":Nombres", $datos['nombres']);
        $stmt->bindParam(":id_licencia", $datos['id_licencia']);
        
        $stmt->execute();
      
    }
    $pdo->commit();
      return "ok";
    } catch (Exception $e) {
      throw new Exception("Error al querer calcular el estado de cuenta de agua: " . $e->getMessage());
    }
  }

  //listado de los años de acuerdo a la fecha de expedicion de la licencias
  public static function mdlAnio_Agua($anio,$mes,$dia)
  {
    if($mes==12){
      if($dia>=15){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM anio where NomAnio>$anio");
      }
       else {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM anio where NomAnio>=$anio");
       }
    }
    else{
      $stmt = Conexion::conectar()->prepare("SELECT * FROM anio where NomAnio>=$anio");
    }
    $stmt->execute();
    return $stmt->fetchall(PDO::FETCH_ASSOC);
    $stmt = null;
  }
}
