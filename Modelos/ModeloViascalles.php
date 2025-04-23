<?php

namespace Modelos;

use Conect\Conexion;
use Exception;
use PDO;

class ModeloViascalles
{
  public static function mdlMostrarViascalles_edicontri($item, $valor)
  {
    if ($item != null) {
      $stmt = Conexion::conectar()->prepare("SELECT t.Codigo as tipo_via,n.Nombre_Via as nombre_calle,m.NumeroManzana as numManzana,c.Numero_Cuadra as cuadra,l.Lado as lado,z.Nombre_Zona as zona,h.Habilitacion_Urbana as habilitacion, a.Importe as arancel,u.Id_Ubica_Vias_Urbano as id,ca.Condicion_Catastral as condicion_catastral from ubica_via_urbano u inner join direccion d on u.Id_Direccion=d.Id_Direccion inner join tipo_via t on t.Id_Tipo_Via=d.Id_Tipo_Via inner join zona z on d.Id_Zona=z.Id_Zona inner join arancel a on a.Id_Arancel= u.Id_Arancel inner join manzana m on d.Id_Manzana=m.Id_Manzana inner join nombre_via n on n.Id_Nombre_Via=d.Id_Nombre_Via inner join cuadra c on c.Id_cuadra=u.Id_Cuadra inner join lado l on l.Id_Lado=u.Id_Lado inner JOIN habilitaciones_urbanas h on h.Id_Habilitacion_Urbana=z.Id_Habilitacion_Urbana inner join condicion_catastral ca on ca.Id_Condicion_Catastral=u.Id_Condicion_Catastral WHERE $item = :$item");
      $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetch();
    } else {
      return "algo salio mal :(";
    }
  }
  public static function mdlMostrarViascalles_edicontri2($item, $valor)
  {
    $stmt = Conexion::conectar()->prepare("SELECT Id_Ubica_Vias_Urbano FROM contribuyente WHERE $item = :$item");
    $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($resultado) {
      $idvia = $resultado['Id_Ubica_Vias_Urbano'];
      $stmt = Conexion::conectar()->prepare("SELECT * FROM ubica_via_urbano u INNER JOIN direccion d ON u.Id_Direccion= d.Id_Direccion INNER JOIN nombre_via n ON n.Id_Nombre_Via= d.Id_Nombre_Via INNER JOIN tipo_via t ON t.Id_Tipo_Via = d.Id_Tipo_Via INNER JOIN manzana m ON m.Id_Manzana = u.Id_Manzana INNER JOIN zona z ON z.Id_Zona = u.Id_Zona INNER JOIN habilitaciones_urbanas h ON h.Id_Habilitacion_Urbana = z.Id_Habilitacion_Urbana INNER JOIN cuadra c ON u.Id_Cuadra=c.Id_cuadra INNER JOIN lado l ON l.Id_Lado=u.Id_Lado WHERE u.Id_Ubica_Vias_Urbano = :idvia");
      $stmt->bindParam(":idvia", $idvia, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
      return false; // No se encontraron resultados en la tabla contribuyente
    }
  }

  public static function mdlMostrarViascalles_edipredio($datos)
  {
    $stmt = Conexion::conectar()->prepare("SELECT t.Codigo as tipo_via, nv.Nombre_Via as nombre_calle, m.NumeroManzana as numManzana, cu.Numero_Cuadra as cuadra,l.Lado as lado, z.Nombre_Zona as zona, h.Habilitacion_Urbana as habilitacion, a.Importe as arancel, u.Id_Ubica_Vias_Urbano as id, co.Condicion_Catastral as condicion
    from arancel_vias av
    inner join ubica_via_urbano u on u.Id_Ubica_Vias_Urbano= av.Id_Ubica_Vias_Urbano  
    inner join direccion d on u.Id_Direccion=d.Id_Direccion 
    inner join tipo_via t on t.Id_Tipo_Via=d.Id_Tipo_Via 
    inner join zona z on u.Id_Zona=z.Id_Zona
    inner join arancel a on a.Id_Arancel=av.Id_arancel
    inner join manzana m on u.Id_Manzana=m.Id_Manzana 
    inner join cuadra cu on cu.Id_cuadra=u.Id_Cuadra 
    inner join lado l on l.Id_Lado=u.Id_Lado 
    inner join habilitaciones_urbanas h on h.Id_Habilitacion_Urbana=z.Id_Habilitacion_Urbana 
    inner join condicion_catastral co on co.Id_Condicion_Catastral=u.Id_Condicion_Catastral 
    inner join nombre_via nv on nv.Id_Nombre_Via=d.Id_Nombre_Via WHERE U.Id_Ubica_Vias_Urbano=:valor1  and a.Id_Anio=:valor2");
    $stmt->bindParam(":valor1", $datos['Id_Ubica_Vias_Urbano'], PDO::PARAM_INT);
    $stmt->bindParam(":valor2", $datos['Id_Anio'], PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  public static function mdlMostrarPredioRustico($datos)
  {
    $stmt = Conexion::conectar()->prepare("SELECT z.Id_zona_rural as id_zona_rural, h.Id_valores_categoria_x_hectarea as id,
    a.NomAnio as anio, z.nombre_zona as nombre_zona, g.Altura as altura,
    ar.Arancel as arancel, c.Categoria_Calidad_Agricola as categoria_calidad,
    c.Nombre_Grupo_Tierra as grupo_tierra
    from arancel_rustico_hectarea arh 
    inner join valores_categoria_x_hectarea h on h.Id_valores_categoria_x_hectarea=arh.Id_valores_categoria_x_hectarea
    inner join arancel_rustico ar on ar.Id_Arancel_Rustico=arh.Id_Arancel_Rustico 
    inner join calidad_agricola c on c.Id_Calidad_Agricola=h.Id_Calidad_Agricola 
    inner join grupo_tierra g on g.Id_Grupo_Tierra=h.Id_Grupo_Tierra 
    inner join zona_rural z on z.Id_Zona_Rural=h.Id_Zona_Rural 
    inner join anio a on a.Id_Anio=ar.Id_Anio 
    where  h.Id_valores_categoria_x_hectarea=:valor1 and a.Id_Anio=:valor2");
    $stmt->bindParam(":valor1", $datos['Id_via_rus'], PDO::PARAM_INT);
    $stmt->bindParam(":valor2", $datos['Id_Anio'], PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // MOSTRAR USUARIOS
  public static function mdlMostrarViascalles($tabla, $item, $valor)
  {
    if ($item != null) {
      $stmt = Conexion::conectar()->prepare("SELECT u.Id_Ubica_Vias_Urbano, d.Id_Direccion, h.Habilitacion_Urbana, z.Nombre_Zona as Zona, v.Codigo as TipoVia,
       n.Nombre_Via, c.Numero_Cuadra, u.Id_Lado 
        FROM $tabla d
        INNER JOIN ubica_via_urbano u on u.Id_Direccion=d.Id_Direccion
        INNER JOIN cuadra c ON u.Id_Cuadra= c.Id_cuadra
        INNER JOIN tipo_via v on d.Id_Tipo_Via=v.Id_Tipo_Via 
        INNER JOIN zona z ON u.Id_Zona=z.Id_Zona
        INNER JOIN nombre_via n ON d.Id_Nombre_Via = n.Id_Nombre_Via
        INNER JOIN habilitaciones_urbanas h on h.Id_Habilitacion_Urbana = z.Id_Habilitacion_Urbana
        WHERE d.Id_Direccion=:Id_Direccion
        ORDER by n.Nombre_Via, c.Numero_Cuadra");
      $stmt->bindParam(":Id_Direccion", $valor);
      $stmt->execute();
      $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if (count($registros) > 0) {
        return $registros;
      } else {
        return 'nulo'; // o 'nulo'
      }
    } else {
      $stmt = Conexion::conectar()->prepare("SELECT u.Id_Ubica_Vias_Urbano, d.Id_Direccion, h.Habilitacion_Urbana, z.Nombre_Zona as Zona, v.Codigo as TipoVia, n.Nombre_Via, c.Numero_Cuadra, u.Id_Lado 
        FROM direccion d
        INNER JOIN ubica_via_urbano u on u.Id_Direccion=d.Id_Direccion
        INNER JOIN cuadra c ON u.Id_Cuadra= c.Id_cuadra
        INNER JOIN tipo_via v on d.Id_Tipo_Via=v.Id_Tipo_Via 
        INNER JOIN zona z ON u.Id_Zona=z.Id_Zona
        INNER JOIN nombre_via n ON d.Id_Nombre_Via = n.Id_Nombre_Via
        INNER JOIN habilitaciones_urbanas h on h.Id_Habilitacion_Urbana = z.Id_Habilitacion_Urbana
        ORDER by n.Nombre_Via, c.Numero_Cuadra;");
      //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
      $stmt->execute();
      return $stmt->fetchall();
    }
  }
  // MOSTRAR USUARIOS
  public static function mdlMostrarData($tabla)
  {
    $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
    //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
    $stmt->execute();
    return $stmt->fetchall();
    $stmt = null;
  }
  // REGISTRO DE USUARIOS
  public static function mdlNuevoViascalles($tabla, $datos)
  {
    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(Id_Tipo_Via,Id_Barrio,Id_Zona,Id_Manzana,Nombre,id_zona_catastro) VALUES (:id_tipovia, :id_barrio,:id_zona, :id_manzana,:nombre_direccion,:id_zona_c)");
    $stmt->bindParam(":id_tipovia", $datos['id_tipovia']);
    $stmt->bindParam(":id_barrio", $datos['id_barrio']);
    $stmt->bindParam(":id_zona", $datos['id_zona']);
    $stmt->bindParam(":id_manzana", $datos['id_manzana']);
    $stmt->bindParam(":nombre_direccion", $datos['nombre_direccion']);
    $stmt->bindParam(":id_zona_c", $datos['id_zona_c']);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
    $stmt = null;
  }
  //EDITAR USUARIOS
  public static function mdlEditarClasificador($tabla, $datos)
  {
    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET Codigo = :codigo, Descripcion = :descripcion, Id_financiamiento = :Id_financiamiento WHERE Id_Presupuesto  = :idp");
    $stmt->bindParam(":idp", $datos['idp'], PDO::PARAM_STR);
    $stmt->bindParam(":codigo", $datos['codigo'], PDO::PARAM_STR);
    $stmt->bindParam(":descripcion", $datos['descripcion'], PDO::PARAM_STR);
    $stmt->bindParam(":Id_financiamiento", $datos['id_financiamiento'], PDO::PARAM_INT);
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
  // BORRAR USUARIO
  public static function mdlBorrarViascalles($tabla, $datos)
  {
    $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) FROM catastro WHERE Id_Ubica_Vias_Urbano = :id");
    $stmt->bindParam(":id", $datos, PDO::PARAM_INT);
    $stmt->execute();
    $stmt = $stmt->fetchColumn();
    if ($stmt > 0) {
      return 'error';
    } else {
      $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE Id_Ubica_Vias_Urbano=:id");
      $stmt->bindParam(":id", $datos, PDO::PARAM_INT);
      if ($stmt->execute()) {
        return 'ok';
      } else {
        return 'error';
      }
      $stmt = null;
    }
  }
  public static function ejecutar_consulta_simple($consulta)
  {
    $sql = Conexion::conectar()->prepare($consulta);
    $sql->execute();
    return $sql;
  }
  public static function mdlListarViascalles()
  {
    $content =  "<tbody class='body-viascalles'></tbody>";
    return $content;
  }
  public static function mdlListarViascallesPredio()
  {
    $content =  "<tbody class='body-viascallesPredio'></tbody>";
    return $content;
  }
  public static function mdlMostrarSubVias($datos)
  {
    $pdo = Conexion::conectar();
    try {
      $stmt = $pdo->prepare("SELECT h.Habilitacion_Urbana, z.Nombre_Zona, t.Nomenclatura, n.Nombre_Via,d.Id_Direccion,t.Codigo FROM ubica_via_urbano uv
			    INNER JOIN zona z ON z.Id_Zona=uv.Id_Zona
			    INNER JOIN direccion d ON d.Id_Direccion = uv.Id_Direccion
          INNER JOIN tipo_via t ON d.Id_Tipo_Via=t.Id_Tipo_Via
          INNER JOIN nombre_via n ON n.Id_Nombre_Via=d.Id_Nombre_Via 
      		INNER JOIN habilitaciones_urbanas h ON h.Id_Habilitacion_Urbana=z.Id_Habilitacion_Urbana
      WHERE d.Id_Nombre_Via=:Id_Nombre_Via");
      $stmt->bindParam(":Id_Nombre_Via", $datos['Id_Nombre_Via']);
      $stmt->execute();
      $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if (count($registros) > 0) {
        return $registros;
      } else {
        return 'nulo'; // o 'nulo'
      }
      $stmt = null;
    } catch (Exception $e) {
      return "Error: " . $e->getMessage();
    }
  }
  public static function mdlRegistrarCuadras($datos)
  {
    $pdo = Conexion::conectar();
  /*  $stmt = $pdo->prepare("SELECT * FROM ubica_via_urbano WHERE Id_Cuadra=:Id_Cuadra AND Id_Lado=:Id_Lado AND Id_Direccion=:Id_Direccion AND Id_Zona=:Id_Zona" );
    $stmt->bindParam(":Id_Cuadra", $datos["Id_Cuadra"]);
    $stmt->bindParam(":Id_Lado", $datos["Id_Lado"]);
    $stmt->bindParam(":Id_Direccion", $datos["Id_Direccion"]);
    $stmt->bindParam(":Id_Zona", $datos["Id_Zona"]);
    $stmt->execute();
    $stmt->rowCount();
    if ($stmt->rowCount() > 0) {
      return "no";
    } else {*/
      try {
        $stmt = $pdo->prepare("INSERT INTO ubica_via_urbano(Id_Cuadra , Id_Lado, 	Id_Direccion,Id_Condicion_Catastral ,Id_Situacion_Cuadra ,Id_Parque_Distancia ,Id_Manzana, Id_Zona_Catastro, Id_Zona ) VALUES(:Id_Cuadra, :Id_Lado, :Id_Direccion, :Id_Condicion_Catastral,:Id_Situacion_Cuadra, :Id_Parque_Distancia, :Id_Manzana, :Id_Zona_Catastro, :Id_Zona)");
        $stmt->bindParam(":Id_Cuadra", $datos["Id_Cuadra"]);
        $stmt->bindParam(":Id_Lado", $datos["Id_Lado"]);
        $stmt->bindParam(":Id_Direccion", $datos["Id_Direccion"]);
        $stmt->bindParam(":Id_Condicion_Catastral", $datos["Id_Condicion_Catastral"]);
        $stmt->bindParam(":Id_Situacion_Cuadra", $datos["Id_Situacion_Cuadra"]);
        $stmt->bindParam(":Id_Parque_Distancia", $datos["Id_Parque_Distancia"]);
        $stmt->bindParam(":Id_Manzana", $datos["Id_Manzana"]);
        $stmt->bindParam(":Id_Zona_Catastro", $datos["Id_Zona_Catastro"]);
        $stmt->bindParam(":Id_Zona", $datos["Id_Zona"]);
        $stmt->execute();
        return "ok";
        $pdo = null;
      } catch (Exception $e) {
        throw new Exception("Error en la BD " . $e->getMessage());
      }
   /* }*/
  }
  public static function mdlRegistrarArancelVias($datos)
  {
    $pdo = Conexion::conectar();
    $stmt = $pdo->prepare("SELECT * FROM arancel_vias 
    WHERE Id_Arancel=:Id_Arancel AND Id_Ubica_Vias_Urbano =:Id_Ubica_Vias_Urbano");
    $stmt->bindParam(":Id_Arancel", $datos["Id_Arancel"]);
    $stmt->bindParam(":Id_Ubica_Vias_Urbano", $datos["Id_Ubica_Vias_Urbano"]);
    $stmt->execute();
    $stmt->rowCount();
    if ($stmt->rowCount() > 0) {
      return "no";
    } else {
      try {
        $stmt = $pdo->prepare("INSERT INTO arancel_vias(Id_Arancel, Id_Ubica_Vias_Urbano) VALUES(:Id_Arancel, :Id_Ubica_Vias_Urbano)");
        $stmt->bindParam(":Id_Arancel", $datos["Id_Arancel"]);
        $stmt->bindParam(":Id_Ubica_Vias_Urbano", $datos["Id_Ubica_Vias_Urbano"]);
        $stmt->execute();
        return "ok";
        $pdo = null;
      } catch (Exception $e) {
        throw new Exception("Error en la BD " . $e->getMessage());
      }
    }
  }
  public static function mdlMostrarUbicaVia($datos)
  {
    $pdo = Conexion::conectar();
    try {
      $stmt = $pdo->prepare("SELECT c.Numero_Cuadra, l.Lado, cc.Condicion_Catastral, s.Situacion_Cuadra, p.Parque_Distancia, m.NumeroManzana, u.Id_Ubica_Vias_Urbano, z.Nombre_Zona  
        FROM ubica_via_urbano u 
        INNER JOIN situacion_cuadra s ON u.Id_Situacion_Cuadra = s.Id_Situacion_Cuadra 
        INNER JOIN parque_distancia p ON u.Id_Parque_Distancia = p.Id_Parque_Distancia 
        INNER JOIN condicion_catastral cc ON u.Id_Condicion_Catastral = cc.Id_Condicion_Catastral
        INNER JOIN lado l ON u.Id_Lado = l.Id_Lado
        INNER JOIN cuadra c ON u.Id_Cuadra = c.Id_Cuadra
        INNER JOIN manzana m ON u.Id_Manzana = m.Id_Manzana
        INNER JOIN zona z ON z.Id_Zona = u.Id_Zona
        WHERE Id_Direccion=:Id_Direccion ORDER BY c.Numero_Cuadra, l.Lado");
      $stmt->bindParam(":Id_Direccion", $datos['Id_Direccion']);
      $stmt->execute();
      $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if (count($registros) > 0) {
        return $registros;
      } else {
        return 'nulo'; // o 'nulo'
      }
      $stmt = null;
    } catch (Exception $e) {
      return "Error: " . $e->getMessage();
    }
  }
  public static function mdlMostrarUbicaViaArancel($datos)
  {
    $pdo = Conexion::conectar();
    try {
      $stmt = $pdo->prepare("SELECT * FROM arancel_vias av INNER JOIN arancel a ON av.Id_Arancel=a.Id_Arancel INNER JOIN anio an ON an.Id_Anio= a.Id_Anio WHERE av.Id_Ubica_Vias_Urbano=:Id_Ubica_Vias_Urbano");
      $stmt->bindParam(":Id_Ubica_Vias_Urbano", $datos['Id_Ubica_Vias_Urbano']);
      $stmt->execute();
      $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if (count($registros) > 0) {
        return $registros;
      } else {
        return 'nulo'; // o 'nulo'
      }
      $stmt = null;
    } catch (Exception $e) {
      return "Error: " . $e->getMessage();
    }
  }
  public static function mdlMostrarArancelAnio($datos)
  {
    $pdo = Conexion::conectar();
    try {
      $stmt = $pdo->prepare("SELECT * FROM arancel WHERE Id_Anio=:Id_Anio");
      $stmt->bindParam(":Id_Anio", $datos['Id_Anio']);
      $stmt->execute();
      $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if (count($registros) > 0) {
        return $registros;
      } else {
        return 'nulo'; // o 'nulo'
      }
      $stmt = null;
    } catch (Exception $e) {
      return "Error: " . $e->getMessage();
    }
  }
  public static function mdlMostrarArancelVia($datos)
  {
    $pdo = Conexion::conectar();
    try {
      $stmt = $pdo->prepare("SELECT av.Id_Arancel_Vias, av.Id_Arancel, a.Id_Anio FROM arancel_vias av
		 INNER JOIN arancel a ON av.Id_Arancel= a.Id_Arancel
      	 WHERE Id_Arancel_Vias=:Id_Arancel_Vias");   
      $stmt->bindParam(":Id_Arancel_Vias", $datos['Id_Arancel_Vias']);
      $stmt->execute();
      $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if (count($registros) > 0) {
        return $registros;
      } else {
        return 'nulo'; // o 'nulo'
      }
      $stmt = null;
    } catch (Exception $e) {
      return "Error: " . $e->getMessage();
    }
  }

  public static function mdlEditarArancelVia($datos)
  {
    $pdo = Conexion::conectar();
    try {
      $stmt = $pdo->prepare("UPDATE arancel_vias SET Id_Arancel = :Id_Arancel WHERE Id_Arancel_Vias = :Id_Arancel_Vias;");   
      $stmt->bindParam(":Id_Arancel", $datos['Id_Arancel']);
      $stmt->bindParam(":Id_Arancel_Vias", $datos['Id_Arancel_Vias']);
      $stmt->execute();
      if ($stmt->execute()) {
        return 'ok';
      } else {
        return 'nulo'; // o 'nulo'
      }
      $stmt = null;
    } catch (Exception $e) {
      return "Error: " . $e->getMessage();
    }
  }



}
