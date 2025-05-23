<?php

namespace Modelos;

use Conect\Conexion;
use PDO;
use PDOException;

class ModeloContribuyente
{
  public static function mdlNuevoContribuyente($tabla, $datos)
  {
      try {
        $stmt = Conexion::conectar()->prepare("SELECT t.Codigo as tipo_via, 
                                               n.Nombre_Via as  nombre_calle, 
                                               m.NumeroManzana as n_manzana, 
                                               cu.Numero_Cuadra as cuadra, 
                                               z.Nombre_Zona as zona, 
                                               h.Habilitacion_Urbana as habilitacion
        FROM ubica_via_urbano u 
        inner join direccion d on u.Id_Direccion=d.Id_Direccion 
        inner join zona z on u.Id_Zona=z.Id_Zona 
        inner join manzana m on u.Id_Manzana=m.Id_Manzana
        inner join cuadra cu on u.Id_cuadra=cu.Id_Cuadra 
        inner join tipo_via t on t.Id_Tipo_Via=d.Id_Tipo_Via 
        inner join nombre_via n on n.Id_Nombre_Via=d.Id_Nombre_Via 
        inner join habilitaciones_urbanas h on h.Id_Habilitacion_Urbana=z.Id_Habilitacion_Urbana
        WHERE u.Id_Ubica_Vias_Urbano=:Id_Ubica_Vias_Urbano");
        $stmt->bindParam(":Id_Ubica_Vias_Urbano", $datos['Id_Ubica_Vias_Urbano']);
        $stmt->execute();
        $direccion = $stmt->fetch();

        $direccion_completa = $direccion['tipo_via'] . ' ' . $direccion['nombre_calle'] . ' N°' . $datos['Numero_Ubicacion'] . ' Mz.' . $direccion['n_manzana'] . ' Lt.' . $datos['Lote']  . ' Nlz.' . $datos['Numero_Luz'] . ' Cdr.' . $direccion['cuadra'] .  '-' . $direccion['habilitacion'] . '-' . $direccion['zona'];
  
          $stmt = Conexion::conectar()->prepare("INSERT INTO contribuyente(Documento, Nombres, Apellido_Paterno, Apellido_Materno, Id_Ubica_Vias_Urbano, Numero_Ubicacion, Bloque, Numero_Departamento, Referencia, Telefono, Correo, Id_Condicion_Contribuyente, Observaciones, Codigo_sa, Id_Tipo_Contribuyente, Id_Condicion_Predio_Fiscal, Id_Clasificacion_Contribuyente, Estado, Coactivo, Numero_Luz, Lote, Id_Tipo_Documento, usuario_Id_Usuario, Nombre_Completo, Direccion_completo) VALUES (:Documento, :Nombres, :Apellido_Paterno, :Apellido_Materno, :Id_Ubica_Vias_Urbano, :Numero_Ubicacion, :Bloque, :Numero_Departamento, :Referencia, :Telefono, :Correo, :Id_Condicion_Contribuyente, :Observaciones, :Codigo_sa, :Id_Tipo_Contribuyente, :Id_Condicion_Predio_Fiscal, :Id_Clasificacion_Contribuyente, :Estado, :Coactivo, :Numero_Luz, :Lote, :Id_Tipo_Documento, :usuario_Id_Usuario, :Nombre_Completo, :Direccion_completo)");
          $nombreCompleto = $datos['Apellido_Paterno'] . ' ' . $datos['Apellido_Materno'] . ' ' . $datos['Nombres'];
          $stmt->bindParam(":Documento", $datos['Documento']);
          $stmt->bindParam(":Nombres", $datos['Nombres']);
          $stmt->bindParam(":Apellido_Paterno", $datos['Apellido_Paterno']);
          $stmt->bindParam(":Apellido_Materno", $datos['Apellido_Materno']);
          $stmt->bindParam(":Id_Ubica_Vias_Urbano", $datos['Id_Ubica_Vias_Urbano']);
          $stmt->bindParam(":Numero_Ubicacion", $datos['Numero_Ubicacion']);
          $stmt->bindParam(":Bloque", $datos['Bloque']);
          $stmt->bindParam(":Numero_Departamento", $datos['Numero_Departamento']);
          $stmt->bindParam(":Referencia", $datos['Referencia']);
          $stmt->bindParam(":Telefono", $datos['Telefono']);
          $stmt->bindParam(":Correo", $datos['Correo']);
          $stmt->bindParam(":Id_Condicion_Contribuyente", $datos['Id_Condicion_Contribuyente']);
          $stmt->bindParam(":Observaciones", $datos['Observaciones']);
          $stmt->bindParam(":Codigo_sa", $datos['Codigo_sa']);
          $stmt->bindParam(":Id_Tipo_Contribuyente", $datos['Id_Tipo_Contribuyente']);
          $stmt->bindParam(":Id_Condicion_Predio_Fiscal", $datos['Id_Condicion_Predio_Fiscal']);
          $stmt->bindParam(":Id_Clasificacion_Contribuyente", $datos['Id_Clasificacion_Contribuyente']);
          $stmt->bindParam(":Estado", $datos['Estado']);
          $stmt->bindParam(":Coactivo", $datos['Coactivo']);
          $stmt->bindParam(":Numero_Luz", $datos['Numero_Luz']);
          $stmt->bindParam(":Lote", $datos['Lote']);
          $stmt->bindParam(":Id_Tipo_Documento", $datos['Id_Tipo_Documento']);
          $stmt->bindParam(":usuario_Id_Usuario", $datos['usuario_Id_Usuario']);
          $stmt->bindParam(":Nombre_Completo", $nombreCompleto);
          $stmt->bindParam(":Direccion_completo", $direccion_completa);
  
          if ($stmt->execute()) {
              return "ok";
          } else {
              return "error";
          }
      } catch (PDOException $e) {
          return "error: " . $e->getMessage();
      }
  }
  // MOSTRAR DATA
  public static function mdlMostrarData($tabla)
  {
    $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
    //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
    $stmt->execute();
    return $stmt->fetchall();
    $stmt = null;
  }
  public static function mdlMostrarDataAnio()
  {
    $stmt = Conexion::conectar()->prepare("SELECT * FROM Anio order by Id_Anio desc ");
    //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
    $stmt->execute();
    return $stmt->fetchall();
    $stmt = null;
  }
  public static function ctrMostrarDataItems($tabla, $item)
  {
    $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE RU = :item");
    $stmt->bindParam(':item', $item, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt = null; // Close the prepared statement
  }


  public static function mdlEditarContribuyente($tabla, $datos)
  {
    $stmt = Conexion::conectar()->prepare("SELECT t.Codigo as tipo_via, n.Nombre_Via as  nombre_calle, m.NumeroManzana as n_manzana, cu.Numero_Cuadra as cuadra, ld.Lado as Lado, z.Nombre_Zona as zona, h.Habilitacion_Urbana as habilitacion
    FROM ubica_via_urbano u 
    inner join direccion d on u.Id_Direccion=d.Id_Direccion 
    inner join zona z on u.Id_Zona=z.Id_Zona 
    inner join manzana m on u.Id_Manzana=m.Id_Manzana
    inner join cuadra cu on u.Id_cuadra=cu.Id_Cuadra 
    inner join tipo_via t on t.Id_Tipo_Via=d.Id_Tipo_Via 
    inner join nombre_via n on n.Id_Nombre_Via=d.Id_Nombre_Via 
    inner join lado ld on u.Id_Lado=ld.Id_Lado
    inner join habilitaciones_urbanas h on h.Id_Habilitacion_Urbana=z.Id_Habilitacion_Urbana
    WHERE u.Id_Ubica_Vias_Urbano=:Id_Ubica_Vias_Urbano");
    $stmt->bindParam(":Id_Ubica_Vias_Urbano", $datos['Id_Ubica_Vias_Urbano']);
    $stmt->execute();
    $direccion = $stmt->fetch();

    $direccion_completa = $direccion['tipo_via'] . ' ' . $direccion['nombre_calle'] . ' N°' . $datos['Numero_Ubicacion'] . ' Mz.' . $direccion['n_manzana'] . ' Lt.' . $datos['Lote'] . ' Nlz.' . $datos['Numero_Luz'] . ' Cdr.' . $direccion['cuadra'] . '-' . $direccion['habilitacion'] . '-' . $direccion['zona'];

    $nombreCompleto = $datos['Apellido_Paterno'] . ' ' . $datos['Apellido_Materno'] . ' ' . $datos['Nombres'];
    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET Documento = :Documento, Nombres= :Nombres, Apellido_Paterno = :Apellido_Paterno,Apellido_Materno = :Apellido_Materno,Id_Ubica_Vias_Urbano=:Id_Ubica_Vias_Urbano,Numero_Ubicacion=:Numero_Ubicacion,Bloque=:Bloque,Numero_Departamento=:Numero_Departamento,Referencia=:Referencia,Telefono=:Telefono,Correo=:Correo,Observaciones=:Observaciones,Codigo_sa=:Codigo_sa,Id_Tipo_Contribuyente=:Id_Tipo_Contribuyente,Id_Condicion_Predio_Fiscal=:Id_Condicion_Predio_Fiscal,Id_Clasificacion_Contribuyente=:Id_Clasificacion_Contribuyente,Estado=:Estado,Coactivo=:Coactivo,Numero_Luz=:Numero_Luz,Fecha_Modificacion=:Fecha_Modificacion,Lote=:Lote,Id_Tipo_Documento=:Id_Tipo_Documento,usuario_Id_Usuario=:usuario_Id_Usuario,Nombre_Completo=:Nombre_Completo,Direccion_completo=:Direccion_completo, Fallecida=:Fallecida WHERE Id_Contribuyente = :Id_Contribuyente");
    $stmt->bindParam(":Id_Contribuyente", $datos['Id_Contribuyente']);
    $stmt->bindParam(":Documento", $datos['Documento']);
    $stmt->bindParam(":Nombres", $datos['Nombres']);
    $stmt->bindParam(":Apellido_Paterno", $datos['Apellido_Paterno']);
    $stmt->bindParam(":Apellido_Materno", $datos['Apellido_Materno']);
    $stmt->bindParam(":Id_Ubica_Vias_Urbano", $datos['Id_Ubica_Vias_Urbano']);
    $stmt->bindParam(":Numero_Ubicacion", $datos['Numero_Ubicacion']);
    $stmt->bindParam(":Bloque", $datos['Bloque']);
    $stmt->bindParam(":Numero_Departamento", $datos['Numero_Departamento']);
    $stmt->bindParam(":Referencia", $datos['Referencia']);
    $stmt->bindParam(":Telefono", $datos['Telefono']);
    $stmt->bindParam(":Correo", $datos['Correo']);
    $stmt->bindParam(":Observaciones", $datos['Observaciones']);
    $stmt->bindParam(":Codigo_sa", $datos['Codigo_sa']);
    $stmt->bindParam(":Id_Tipo_Contribuyente", $datos['Id_Tipo_Contribuyente']);
    $stmt->bindParam(":Id_Condicion_Predio_Fiscal", $datos['Id_Condicion_Predio_Fiscal']);
    $stmt->bindParam(":Id_Clasificacion_Contribuyente", $datos['Id_Clasificacion_Contribuyente']);
    $stmt->bindParam(":Estado", $datos['Estado']);
    $stmt->bindParam(":Coactivo", $datos['Coactivo']);
    $stmt->bindParam(":Fallecida", $datos['Fallecida']);
    $stmt->bindParam(":Numero_Luz", $datos['Numero_Luz']);
    $stmt->bindParam(":Fecha_Modificacion", $datos['Fecha_Modificacion']);
    $stmt->bindParam(":Lote", $datos['Lote']);
    $stmt->bindParam(":Id_Tipo_Documento", $datos['Id_Tipo_Documento']);
    $stmt->bindParam(":usuario_Id_Usuario", $datos['usuario_Id_Usuario']);
    $stmt->bindParam(":Nombre_Completo", $nombreCompleto);
    $stmt->bindParam(":Direccion_completo", $direccion_completa);
    if ($stmt->execute()) {
      return 'ok';
    } else {
      return 'error';
    }
    $stmt = null;
  }

  
  public static function mdlActualizarClasificador($tabla, $item1, $valor1, $item2, $valor2)
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
  public static function mdlBorrarContribuyente($tabla, $datos)
  {
    $stmt = Conexion::conectar()->prepare("UPDATE contribuyente SET Estado = 0, usuario_Id_Usuario =:usuario_Id_Usuario WHERE Id_Contribuyente=:id");
    $stmt->bindParam(":usuario_Id_Usuario", $_SESSION['id_usuario']);
    $stmt->bindParam(":id", $datos, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return 'ok';
    } else {
      return 'error';
    }
    $stmt = null;
  }
  public static function ejecutar_consulta_simple($consulta)
  {
    $sql = Conexion::conectar()->prepare($consulta);
    $sql->execute();
    return $sql;
  }
  public static function mdlMostrarContribuyente($tabla, $item, $valor)
  {
    if ($item != null) {
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE $item = :$item");
      $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetch();
    } else {
      return "ocurrio un error";
    }
    $stmt = null;
  }
  // MOSTRAR USUARIOS
  public static function mdlMostrarValores_parametro_get_impuesto($tabla, $datos)
  {
    $idArray = explode('-', $datos);
    $resultados = array(); // Aquí almacenaremos los resultados
    foreach ($idArray as $valor) {
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE Id_Contribuyente = :Id_Contribuyente");
      $stmt->bindParam(":Id_Contribuyente", $valor);
      $stmt->execute();
      // Obtener los resultados y agregarlos al array de resultados
      $resultados[$valor] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return $resultados;
    $stmt = null;
  }
  public static function mdlMostrarValores_parametro_get($tabla, $valor_id)
  {   sort($valor_id);
      $valores = $valor_id; // Puedes modificar esto según tus necesidades
      $carpeta = implode('-', $valor_id);
      $resultados = array(); // Aquí almacenaremos los resultados
  
      // Conexión a la base de datos
      $conexion = Conexion::conectar();
  
      // Preparar consulta para obtener contribuyentes
      $stmtContribuyentes = $conexion->prepare("SELECT Id_Contribuyente,
       Id_Ubica_Vias_Urbano, 
       Documento, 
       Nombre_Completo, 
       Direccion_completo, Codigo_sa, Fallecida,Telefono
        FROM $tabla WHERE Id_Contribuyente = :Id_Contribuyente");
  
      foreach ($valores as $valor) {
          $stmtContribuyentes->bindParam(":Id_Contribuyente", $valor);
          $stmtContribuyentes->execute();
          $resultados[$valor] = $stmtContribuyentes->fetchAll(PDO::FETCH_ASSOC);
      }
  
      // Preparar consulta para obtener el código de carpeta
      $stmtCarpeta = $conexion->prepare("SELECT Codigo_Carpeta FROM carpeta WHERE Concatenado_id = :carpeta");
      $stmtCarpeta->bindParam(":carpeta", $carpeta);
      $stmtCarpeta->execute();
      $carpetaResult = $stmtCarpeta->fetch(PDO::FETCH_ASSOC);
  
      // Agregar Codigo_Carpeta a cada contribuyente
      if ($carpetaResult) {
          foreach ($resultados as &$contribuyenteArray) {
              foreach ($contribuyenteArray as &$contribuyente) {
                  $contribuyente['Codigo_Carpeta'] = $carpetaResult['Codigo_Carpeta'];
                 
              }
          }
      }

      //PARA AGREGAR PROGRESO

         // Preparar consulta para obtener el código de carpeta
         $stmtCarpetap = $conexion->prepare("SELECT Estado_progreso FROM carpeta WHERE Concatenado_id = :carpeta");
         $stmtCarpetap->bindParam(":carpeta", $carpeta);
         $stmtCarpetap->execute();
         $carpetaResult = $stmtCarpetap->fetch(PDO::FETCH_ASSOC);
     
         // Agregar Codigo_Carpeta a cada contribuyente
         if ($carpetaResult) {
             foreach ($resultados as &$contribuyenteArray) {
                 foreach ($contribuyenteArray as &$contribuyente) {
                     $contribuyente['Estado_progreso'] = $carpetaResult['Estado_progreso'];
                    
                 }
             }
         }

     
      // Cerrar las conexiones
      $stmtContribuyentes = null;
      $stmtCarpeta = null;
      $stmtCarpetap = null;
      $conexion = null;


  
      return $resultados;
       // Mostrar resultados en formato legible
   
  }



  //LISTAEMOS EL CONTRIBUYENTE EN EL MODAL PARA AGREGAR PROPIETARIO EN REGISTRO PREDIO
  public static function mdlListarContribuyente_modal()
  {
    $content =  "<tbody class='body-propietario'></tbody>";
    return $content;
  }
}
