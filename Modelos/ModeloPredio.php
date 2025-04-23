<?php

namespace Modelos;

use Conect\Conexion;
use Exception;
use PDO;

class ModeloPredio
{

	public static function mdlNuevoPredio($tabla, $datos)
	{
		$catastro = Conexion::conectar()->prepare("SELECT d.Id_Direccion as campo1,
										d.Id_Tipo_Via as campo2,
										u.Id_Zona as campo3,
										u.Id_Manzana as campo4,
										d.Id_Nombre_Via as campo5,
										u.id_zona_catastro as campo6,
											u.Id_Ubica_Vias_Urbano as campo7
											FROM ubica_via_urbano u 
											INNER JOIN direccion d ON u.Id_Direccion=d.Id_Direccion
											WHERE Id_Ubica_Vias_Urbano = :IdVia");
		$catastro->bindParam(":IdVia", $datos['Id_Ubica_Vias_Urbano'], PDO::PARAM_INT);
		$catastro->execute();
		$resultado = $catastro->fetch(); // Obtener la única fila de resultados
		//formar el codigoCatastro del predio
		if ($resultado) {
			$codigoCatastral = 'U' . $resultado['campo1'] . '' . $resultado['campo2'] . '' . $resultado['campo3'] . '' . $resultado['campo4'] . '' . $resultado['campo5'] . '' . $resultado['campo6'] . '' . $resultado['campo7'];
		} else {
			$codigoCatastral = 'Fuera De Via';
		}
		try {
			$pdo  = Conexion::conectar();
			$pdo->exec("LOCK TABLES $tabla WRITE");
			$pdo->beginTransaction();

			$stmt1 = $pdo->prepare("INSERT INTO catastro(Codigo_Catastral, Numero_Bloque, Numero_Ubicacion, Numero_Lote, Codigo_COFOPRI, Referencia, Id_Ubica_Vias_Urbano, Numero_Departamento) VALUES (:Codigo_Catastral, :Numero_Bloque, :Numero_Ubicacion, :Numero_Lote, :Codigo_COFOPRI, :Referencia, :Id_Ubica_Vias_Urbano, :Numero_Departamento)");

			$stmt1->bindParam(":Codigo_Catastral", $codigoCatastral);
			$stmt1->bindParam(":Numero_Bloque", $datos['Numero_Bloque']);
			$stmt1->bindParam(":Numero_Ubicacion", $datos['Numero_Ubicacion']);
			$stmt1->bindParam(":Numero_Lote", $datos['Numero_Lote']);
			$stmt1->bindParam(":Codigo_COFOPRI", $datos['Codigo_COFOPRI']);
			$stmt1->bindParam(":Referencia", $datos['Referencia']);
			$stmt1->bindParam(":Id_Ubica_Vias_Urbano", $datos['Id_Ubica_Vias_Urbano']);
			$stmt1->bindParam(":Numero_Departamento", $datos['Numero_Departamento']);

			$stmt1->execute();
			$id_ultimo = $pdo->lastInsertId();
			//---
			$stmt12 = $pdo->prepare("SELECT Codigo_Catastral FROM catastro WHERE Id_Catastro = :Id_Catastro");
			$stmt12->bindParam(":Id_Catastro", $id_ultimo);
			$stmt12->execute();
			$resultado2 = $stmt12->fetch(); // Obtener la única fila de resultados

			$codigoCatastral = ''; // Variable para almacenar el nuevo código catastral

			if ($stmt12->rowCount() > 0) {
				$codigoCatastral = $resultado2['Codigo_Catastral'] . '-' . $id_ultimo; // Concatenar el ID al código existente
			} else {
				$codigoCatastral = 'Fuera De Via'; // No se encontró ningún registro con el ID_Catastro igual a $id_ultimo
			}
			//------------------
			$stmt2 = $pdo->prepare("UPDATE catastro SET Codigo_Catastral = :Codigo_Catastral WHERE Id_Catastro = :Id_Catastro");
			$stmt2->bindParam(":Codigo_Catastral", $codigoCatastral);
			$stmt2->bindParam(":Id_Catastro", $id_ultimo, PDO::PARAM_INT);
			$stmt2->execute();

			$pdo->exec("UNLOCK TABLES");
			$pdo->commit();
			$valorPredioAplicarU = ($datos['Valor_predio'] - $datos['Valor_Inaf_Exo']);
			$pdo->exec("LOCK TABLES predio WRITE");
			$pdo->beginTransaction();

			$stmtx = $pdo->prepare("SELECT CONCAT(t.Codigo, ' ', n.Nombre_Via, ' Nº.', ca.Numero_Ubicacion, ' Mz.', m.NumeroManzana, ' Lt.',ca.Numero_Lote, ' Cdr.', cu.Numero_Cuadra,'-', h.Habilitacion_Urbana, '-', z.Nombre_Zona, ' - ',ca.Referencia) AS Nuevo_Direccion_completo
			FROM catastro ca 
			INNER JOIN ubica_via_urbano u ON ca.Id_Ubica_Vias_Urbano=u.Id_Ubica_Vias_Urbano 
			INNER JOIN direccion d ON u.Id_Direccion=d.Id_Direccion 
			INNER JOIN zona z ON u.Id_Zona=z.Id_Zona 
			INNER JOIN manzana m ON u.Id_Manzana=m.Id_Manzana 
			INNER JOIN cuadra cu ON u.Id_cuadra=cu.Id_Cuadra 
			INNER JOIN tipo_via t ON t.Id_Tipo_Via=d.Id_Tipo_Via 
			INNER JOIN nombre_via n ON n.Id_Nombre_Via=d.Id_Nombre_Via 
			INNER JOIN habilitaciones_urbanas h ON h.Id_Habilitacion_Urbana=z.Id_Habilitacion_Urbana 
			WHERE ca.Id_Catastro=:Id_Catastro");
			$stmtx->bindParam(":Id_Catastro", $id_ultimo);
			$stmtx->execute();
			$direccion = $stmtx->fetch();
			$direccionCompleto = $direccion['Nuevo_Direccion_completo'];

			// aqui debe formarse la direccion completa

			$stmt3 = $pdo->prepare("INSERT INTO predio(Fecha_Adquisicion ,Numero_Luz ,Area_Terreno , Valor_Terreno ,Valor_Construccion ,Valor_Otras_Instalacions ,Valor_predio ,Expediente_Tramite ,Observaciones ,predio_UR ,Area_Construccion, Id_Tipo_Predio, Id_Giro_Establecimiento, Id_Uso_Predio, Id_Estado_Predio,Id_Regimen_Afecto,Id_inafecto ,Id_Arbitrios ,Id_Condicion_Predio ,Id_Catastro , Id_Anio, Valor_Inaf_Exo,Valor_Predio_Aplicar, id_usuario, Direccion_completo)VALUES(:Fecha_Adquisicion, :Numero_Luz, :Area_Terreno, :Valor_Terreno, :Valor_Construccion, :Valor_Otras_Instalacions, :Valor_predio, :Expediente_Tramite, :Observaciones, :predio_UR, :Area_Construccion, :Id_Tipo_Predio,:Id_Giro_Establecimiento,  :Id_Uso_Predio, :Id_Estado_Predio, :Id_Regimen_Afecto, :Id_inafecto, :Id_Arbitrios, :Id_Condicion_Predio, :Id_Catastro, :Id_Anio, :Valor_Inaf_Exo,:Valor_Predio_Aplicar,:id_usuario,:Direccion_completo)");

			$stmt3->bindParam(":Fecha_Adquisicion", $datos['Fecha_Adquisicion']);
			$stmt3->bindParam(":Numero_Luz", $datos['Numero_Luz']);
			$stmt3->bindParam(":Area_Terreno", $datos['Area_Terreno']);
			$stmt3->bindParam(":Valor_Terreno", $datos['Valor_Terreno']);
			$stmt3->bindParam(":Valor_Construccion", $datos['Valor_Construccion']);
			$stmt3->bindParam(":Valor_Otras_Instalacions", $datos['Valor_Otras_Instalacions']);
			$stmt3->bindParam(":Valor_predio", $datos['Valor_predio']);
			$stmt3->bindParam(":Expediente_Tramite", $datos['Expediente_Tramite']);
			$stmt3->bindParam(":Observaciones", $datos['Observaciones']);
			$stmt3->bindParam(":predio_UR", $datos['predio_UR']);
			$stmt3->bindParam(":Area_Construccion", $datos['Area_Construccion']);
			$stmt3->bindParam(":Id_Tipo_Predio", $datos['Id_Tipo_Predio']);
			$stmt3->bindParam(":Id_Giro_Establecimiento", $datos['Id_Giro_Establecimiento']);
			$stmt3->bindParam(":Id_Uso_Predio", $datos['Id_Uso_Predio']);
			$stmt3->bindParam(":Id_Estado_Predio", $datos['Id_Estado_Predio']);
			$stmt3->bindParam(":Id_Regimen_Afecto", $datos['Id_Regimen_Afecto']);
			$stmt3->bindParam(":Id_inafecto", $datos['Id_inafecto']);
			$stmt3->bindParam(":Id_Arbitrios", $datos['Id_Arbitrios']);
			$stmt3->bindParam(":Id_Condicion_Predio", $datos['Id_Condicion_Predio']);
			$stmt3->bindValue(":Valor_Inaf_Exo", 0);
			$stmt3->bindParam(":Id_Catastro", $id_ultimo);
			$stmt3->bindParam(":Id_Anio", $datos['Id_Anio']);
			$stmt3->bindParam(":Valor_Predio_Aplicar", $valorPredioAplicarU);
			$stmt3->bindParam(":id_usuario", $datos['id_usuario']);
			$stmt3->bindParam(":Direccion_completo", $direccionCompleto);

			$stmt3->execute();
			$id_predio = $pdo->lastInsertId(); //captura el id del ultimo predio insertado
			$pdo->exec("UNLOCK TABLES");
			$pdo->commit();
			// ---------------
			$pdo->exec("LOCK TABLES detalle_transferencia WRITE");
			$pdo->beginTransaction();
			$stmt4 = $pdo->prepare("INSERT INTO detalle_transferencia(Id_Documento_Inscripcion , Numero_Documento_Inscripcion, Id_Tipo_Escritura , Fecha_Escritura) VALUES (:Id_Documento_Inscripcion, :Numero_Documento_Inscripcion, :Id_Tipo_Escritura, :Fecha_Escritura)");
			$stmt4->bindParam(":Id_Documento_Inscripcion", $datos['Id_Documento_Inscripcion']);
			$stmt4->bindParam(":Numero_Documento_Inscripcion", $datos['Numero_Documento_Inscripcion']);
			$stmt4->bindParam(":Id_Tipo_Escritura", $datos['Id_Tipo_Escritura']);
			$stmt4->bindParam(":Fecha_Escritura", $datos['Fecha_Escritura']);
			$stmt4->execute();
			$id_detalle = $pdo->lastInsertId();
			//--
			$propietaroios = $datos['Id_Contribuyente'];
			$baja = '1';
			$propietarios_array = explode(",", $propietaroios);
			sort($propietarios_array);
			foreach ($propietarios_array as $valor) {
				$stmt5 = $pdo->prepare("INSERT INTO propietario(Id_Predio ,Id_Contribuyente ,Estado_Transferencia ,Id_Detalle_Transferencia,Baja)VALUES(:Id_Predio,:Id_Contribuyente,:Estado_Transferencia,:Id_Detalle_Transferencia,'1')");
				$stmt5->bindParam(":Id_Predio", $id_predio);
				$stmt5->bindParam(":Id_Contribuyente", $valor);
				$stmt5->bindParam(":Estado_Transferencia", $datos['Estado_Transferencia']);
				$stmt5->bindParam(":Id_Detalle_Transferencia", $id_detalle);
				$stmt5->execute();
			}

			/* Generando el codigo de carpeta*/

			$stmt = $pdo->prepare("
							SELECT 
								(SELECT Codigo_Carpeta FROM Configuracion) AS Codigo_Carpeta, 
								(SELECT COUNT(*) FROM carpeta WHERE Concatenado_id = :concatenado_id) AS con
						");
			$propietarios_array = array_map('trim', $propietarios_array);
			$propietarios_array = array_filter($propietarios_array);

			sort($propietarios_array);
			$propietarios_carpeta = implode("-", $propietarios_array);
			$stmt->bindParam(':concatenado_id', $propietarios_carpeta, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$codigo_carpeta = $result['Codigo_Carpeta'];
			$exists = $result['con'];
			if ($exists == 0) {
				$codigo_carpeta += 1;

				try {
					// Insertar el nuevo registro en la tabla carpeta
					$stmt_insert = $pdo->prepare("INSERT INTO carpeta (Concatenado_id,Codigo_Carpeta) VALUES (:concatenado_id,:codigo_carpeta)");
					$stmt_insert->bindParam(':concatenado_id', $propietarios_carpeta, PDO::PARAM_STR);
					$stmt_insert->bindParam(':codigo_carpeta', $codigo_carpeta, PDO::PARAM_INT);
					$stmt_insert->execute();
					$stmt_update = $pdo->prepare("UPDATE Configuracion SET Codigo_Carpeta = :codigo_carpeta");
					$stmt_update->bindParam(':codigo_carpeta', $codigo_carpeta, PDO::PARAM_INT);
					$stmt_update->execute();
				} catch (Exception $e) {
					// Revertir la transacción en caso de error
					$pdo->rollBack();
					throw $e;
				}
			}

			/* fin de generacion de codigo de carpeta */
			$pdo->exec("UNLOCK TABLES");
			$pdo->commit();
			return "ok";
		} catch (Exception $e) {
			$pdo->rollBack();
			echo "Error: " . $e->getMessage();
		}
	}

	public static function mdlEditarPredio($datos)
	{
		$pdo  = Conexion::conectar();

		$stmt = $pdo->prepare("SELECT DISTINCT Id_Detalle_Transferencia FROM propietario 
		WHERE Id_Predio = :Id_Predio AND Baja=1");
		$stmt->bindParam(":Id_Predio", $datos['Id_Predio']);
		//$estadoTransferencia = 'R'; // Variable que contiene el valor a vincular
		//$stmt->bindParam(":Estado_Transferencia", $estadoTransferencia);
		$stmt->execute();
		$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($resultado) {
			$idDetalleT = $resultado['Id_Detalle_Transferencia'];
			$stmt = $pdo->prepare("UPDATE detalle_transferencia SET 
               Numero_Documento_Inscripcion=:Numero_Documento_Inscripcion,
               Fecha_Escritura=:Fecha_Escritura,
               Id_Tipo_Escritura=:Id_Tipo_Escritura,
               Id_Documento_Inscripcion=:Id_Documento_Inscripcion
               WHERE Id_Detalle_Transferencia = :Id_Detalle_Transferencia");
			$stmt->bindParam(":Id_Detalle_Transferencia", $idDetalleT);
			$stmt->bindParam(":Numero_Documento_Inscripcion", $datos['Numero_Documento_Inscripcion']);
			$stmt->bindParam(":Fecha_Escritura", $datos['Fecha_Escritura']);
			$stmt->bindParam(":Id_Tipo_Escritura", $datos['Id_Tipo_Escritura']);
			$stmt->bindParam(":Id_Documento_Inscripcion", $datos['Id_Documento_Inscripcion']);
			$stmt->execute();
		}
		$stmt = $pdo->prepare("SELECT Id_Catastro FROM predio WHERE Id_Predio = :Id_Predio");
		$stmt->bindParam(":Id_Predio", $datos['Id_Predio']);
		$stmt->execute();
		$resultadok = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($resultado) {
			$idCatastro = $resultadok['Id_Catastro'];

			$stmt = $pdo->prepare("UPDATE catastro SET 
               Numero_Bloque=:Numero_Bloque,
               Numero_Ubicacion=:Numero_Ubicacion,
               Numero_Lote=:Numero_Lote,
               Codigo_COFOPRI=:Codigo_COFOPRI,
               Referencia=:Referencia,
               Id_Ubica_Vias_Urbano=:Id_Ubica_Vias_Urbano,
               Numero_Departamento=:Numero_Departamento
               WHERE Id_Catastro = :Id_Catastro");
			$stmt->bindParam(":Numero_Bloque", $datos['Numero_Bloque']);
			$stmt->bindParam(":Numero_Ubicacion", $datos['Numero_Ubicacion']);
			$stmt->bindParam(":Numero_Lote", $datos['Numero_Lote']);
			$stmt->bindParam(":Codigo_COFOPRI", $datos['Codigo_COFOPRI']);
			$stmt->bindParam(":Referencia", $datos['Referencia']);
			$stmt->bindParam(":Id_Ubica_Vias_Urbano", $datos['Id_Ubica_Vias_Urbano']);
			$stmt->bindParam(":Numero_Departamento", $datos['Numero_Departamento']);
			$stmt->bindParam(":Id_Catastro", $idCatastro, PDO::PARAM_INT);
			$stmt->execute();
			/*------------ */

			$stmtx = $pdo->prepare("SELECT CONCAT(t.Codigo, ' ', n.Nombre_Via, ' Nº.', ca.Numero_Ubicacion, ' Mz.', m.NumeroManzana, ' Lt.',ca.Numero_Lote, ' Cdr.', cu.Numero_Cuadra,'-', h.Habilitacion_Urbana, '-', z.Nombre_Zona, ' - ',ca.Referencia) AS Nuevo_Direccion_completo
				FROM catastro ca 
				INNER JOIN ubica_via_urbano u ON ca.Id_Ubica_Vias_Urbano=u.Id_Ubica_Vias_Urbano 
				INNER JOIN direccion d ON u.Id_Direccion=d.Id_Direccion 
				INNER JOIN zona z ON u.Id_Zona=z.Id_Zona 
				INNER JOIN manzana m ON u.Id_Manzana=m.Id_Manzana 
				INNER JOIN cuadra cu ON u.Id_cuadra=cu.Id_Cuadra 
				INNER JOIN tipo_via t ON t.Id_Tipo_Via=d.Id_Tipo_Via 
				INNER JOIN nombre_via n ON n.Id_Nombre_Via=d.Id_Nombre_Via 
				INNER JOIN lado ld ON u.Id_Lado=ld.Id_Lado 
				INNER JOIN habilitaciones_urbanas h ON h.Id_Habilitacion_Urbana=z.Id_Habilitacion_Urbana 
				WHERE ca.Id_Catastro=:Id_Catastro");
			$stmtx->bindParam(":Id_Catastro", $idCatastro);
			$stmtx->execute();
			$direccion = $stmtx->fetch();
			$direccionCompleto = $direccion['Nuevo_Direccion_completo'];

			/*------------ */
		}

		$stmt3 = $pdo->prepare("UPDATE predio
                    SET Fecha_Adquisicion = :Fecha_Adquisicion,
                        Numero_Luz = :Numero_Luz,
                        Area_Terreno = :Area_Terreno,
                        Valor_Terreno = :Valor_Terreno,
                        Valor_Construccion = :Valor_Construccion,
                        Valor_Otras_Instalacions = :Valor_Otras_Instalacions,
                        Valor_predio = :Valor_predio,
                        Expediente_Tramite = :Expediente_Tramite,
                        Observaciones = :Observaciones,
                        Area_Construccion = :Area_Construccion,
                        Id_Tipo_Predio = :Id_Tipo_Predio,
                        Id_Giro_Establecimiento = :Id_Giro_Establecimiento,
                        Id_Uso_Predio = :Id_Uso_Predio,
	                    Id_Estado_Predio = :Id_Estado_Predio,
		                Id_Regimen_Afecto = :Id_Regimen_Afecto,
                        Id_inafecto = :Id_inafecto,
                        Id_Arbitrios = :Id_Arbitrios,
                        Id_Condicion_Predio = :Id_Condicion_Predio,
						Valor_Predio_Aplicar =:Valor_predio_total,
                        id_usuario = :id_usuario,
						Direccion_completo=:Direccion_completo
                     WHERE Id_Predio = :Id_Predio");
		$stmt3->bindParam(":Fecha_Adquisicion", $datos['Fecha_Adquisicion']);
		$stmt3->bindParam(":Numero_Luz", $datos['Numero_Luz']);
		$stmt3->bindParam(":Area_Terreno", $datos['Area_Terreno']);
		$stmt3->bindParam(":Valor_Terreno", $datos['Valor_Terreno']);
		$stmt3->bindParam(":Valor_Construccion", $datos['Valor_Construccion']);
		$stmt3->bindParam(":Valor_Otras_Instalacions", $datos['Valor_Otras_Instalacions']);
		$stmt3->bindParam(":Valor_predio", $datos['Valor_predio']);
		$stmt3->bindParam(":Expediente_Tramite", $datos['Expediente_Tramite']);
		$stmt3->bindParam(":Observaciones", $datos['Observaciones']);
		$stmt3->bindParam(":Area_Construccion", $datos['Area_Construccion']);
		$stmt3->bindParam(":Id_Tipo_Predio", $datos['Id_Tipo_Predio']);
		$stmt3->bindParam(":Id_Giro_Establecimiento", $datos['Id_Giro_Establecimiento']);
		$stmt3->bindParam(":Id_Uso_Predio", $datos['Id_Uso_Predio']);
		$stmt3->bindParam(":Id_Estado_Predio", $datos['Id_Estado_Predio']);
		$stmt3->bindParam(":Id_Regimen_Afecto", $datos['Id_Regimen_Afecto']);
		$stmt3->bindParam(":Id_inafecto", $datos['Id_inafecto']);
		$stmt3->bindParam(":Id_Arbitrios", $datos['Id_Arbitrios']);
		$stmt3->bindParam(":Id_Condicion_Predio", $datos['Id_Condicion_Predio']);
		$stmt3->bindParam(":Valor_predio_total", $datos['Valor_predio']);
		$stmt3->bindParam(":id_usuario", $datos['id_usuario']);
		$stmt3->bindParam(":Id_Predio", $datos['Id_Predio']);
		$stmt3->bindParam(":Direccion_completo", $direccionCompleto);
		if ($stmt3->execute()) {
			$stmt = $pdo->prepare("UPDATE predio SET Direccion_completo = :Direccion_completo WHERE Id_Catastro = :id_catastro");
			$stmt->bindParam(":id_catastro", $idCatastro);
		    $stmt->bindParam(":Direccion_completo", $direccionCompleto);
			$stmt->execute();
			return 'ok';
		} else {
			return 'error';
		}
	}

	public static function mdlEditarPredioR($datos)
	{
		$pdo  = Conexion::conectar();

		$stmt = $pdo->prepare("SELECT DISTINCT Id_Detalle_Transferencia FROM propietario 
		WHERE Id_Predio = :Id_Predio AND Baja =1");
		$stmt->bindParam(":Id_Predio", $datos['id_predio']);
		//$estadoTransferencia = 'R'; // Variable que contiene el valor a vincular
		//$stmt->bindParam(":Estado_Transferencia", $estadoTransferencia);
		$stmt->execute();
		$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($resultado) {
			$idDetalleT = $resultado['Id_Detalle_Transferencia'];
			$stmt = $pdo->prepare("UPDATE detalle_transferencia SET 
               Numero_Documento_Inscripcion=:Numero_Documento_Inscripcion,
               Fecha_Escritura=:Fecha_Escritura,
               Id_Tipo_Escritura=:Id_Tipo_Escritura,
               Id_Documento_Inscripcion=:Id_Documento_Inscripcion
               WHERE Id_Detalle_Transferencia = :Id_Detalle_Transferencia");
			$stmt->bindParam(":Id_Detalle_Transferencia", $idDetalleT);
			$stmt->bindParam(":Numero_Documento_Inscripcion", $datos['Numero_doc_inscripcion']);
			$stmt->bindParam(":Fecha_Escritura", $datos['fecha_escritura']);
			$stmt->bindParam(":Id_Tipo_Escritura", $datos['tipo_escritura']);
			$stmt->bindParam(":Id_Documento_Inscripcion", $datos['tipo_doc_inscripcion']);
			$stmt->execute();
		}
		$stmt = $pdo->prepare("SELECT Id_Catastro_Rural FROM predio WHERE Id_Predio = :Id_Predio");
		$stmt->bindParam(":Id_Predio", $datos['id_predio']);
		$stmt->execute();
		$resultadok = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($resultado) {
			$idCatastro = $resultadok['Id_Catastro_Rural'];

			$stmt = $pdo->prepare(" UPDATE catastro_rural
									SET Id_valores_categoria_x_hectarea = :idvalcat
									WHERE Id_Catastro_Rural = :Id_Catastro_Rural");
			$stmt->bindParam(":idvalcat", $datos['idvalcat']);
			$stmt->bindParam(":Id_Catastro_Rural", $idCatastro);
			$stmt->execute();
			$stmt = $pdo->prepare(" UPDATE denominacion_rural
									SET Denominacion = :Denominacion
									WHERE Id_Denominacion_Rural = :Id_Denominacion_Rural");
			$stmt->bindParam(":Denominacion", $datos['Denominacion']);
			$stmt->bindParam(":Id_Denominacion_Rural", $datos['idDenominacionR']);
			$stmt->execute();
			if (isset($datos['idColindenominacion']) && !empty($datos['idColindenominacion']) && is_numeric($datos['idColindenominacion']) && intval($datos['idColindenominacion']) > 0){
				// Actualizar registro existente
				$sql = "UPDATE colindante_denominacion 
						SET Denominacion_Rural = :Denominacion_Rural,Colindante_Sur_Nombre = :Colindante_Sur_Nombre,Colindante_Sur_Denominacion = :Colindante_Sur_Denominacion,Colindante_Norte_Nombre = :Colindante_Norte_Nombre,Colindante_Norte_Denominacion = :Colindante_Norte_Denominacion,Colindante_Este_Nombre = :Colindante_Este_Nombre,Colindante_Este_Denominacion = :Colindante_Este_Denominacion,Colindante_Oeste_Nombre = :Colindante_Oeste_Nombre,Colindante_Oeste_Denominacion = :Colindante_Oeste_Denominacion
						WHERE Id_Colindante_Denominacion = :Id_Colindante_Denominacion";
				$stmt = $pdo->prepare($sql);
				$id_Col_denominacion=$datos['idColindenominacion'];
				$stmt->bindParam(":Denominacion_Rural", $datos['Denominacion']);
				$stmt->bindParam(":Colindante_Sur_Nombre", $datos['Colindante_Sur_Nombre']);
				$stmt->bindParam(":Colindante_Sur_Denominacion", $datos['Colindante_Sur_Denominacion']);
				$stmt->bindParam(":Colindante_Norte_Nombre", $datos['Colindante_Norte_Nombre']);
				$stmt->bindParam(":Colindante_Norte_Denominacion", $datos['Colindante_Norte_Denominacion']);
				$stmt->bindParam(":Colindante_Este_Nombre", $datos['Colindante_Este_Nombre']);
				$stmt->bindParam(":Colindante_Este_Denominacion", $datos['Colindante_Este_Denominacion']);
				$stmt->bindParam(":Colindante_Oeste_Nombre", $datos['Colindante_Oeste_Nombre']);
				$stmt->bindParam(":Colindante_Oeste_Denominacion", $datos['Colindante_Oeste_Denominacion']);
				$stmt->bindParam(":Id_Colindante_Denominacion", $id_Col_denominacion);
				$stmt->execute();
				$stmt = $pdo->prepare("SELECT  CONCAT(z.nombre_zona,' - ', d.Denominacion)AS Nuevo_Direccion_completo from  predio p
				INNER JOIN denominacion_rural d ON p.Id_Denominacion_Rural = d.Id_Denominacion_Rural 
				INNER JOIN catastro_rural cr ON p.Id_Catastro_Rural = cr.Id_Catastro_Rural
				INNER JOIN valores_categoria_x_hectarea vc ON cr.Id_valores_categoria_x_hectarea = vc.Id_valores_categoria_x_hectarea
				INNER JOIN zona_rural z ON vc.Id_Zona_Rural = z.Id_zona_rural
				WHERE p.Id_Predio =:Id_Predio");
				$stmt->bindParam(":Id_Predio", $datos['id_predio']);
				$stmt->execute();
				$direccion = $stmt->fetch();
				$direccionCompleto = $direccion['Nuevo_Direccion_completo'];

				$sql = "UPDATE predio SET Id_Colindante_Denominacion=:Id_Colindante_Denominacion,Direccion_completo=:Direccion_completo
				WHERE Id_Catastro_Rural = :Id_Catastro_Rural";
				$stmt = $pdo->prepare($sql);
				$stmt->bindParam(":Id_Catastro_Rural", $idCatastro);
				$stmt->bindParam(":Id_Colindante_Denominacion", $id_Col_denominacion);
				$stmt->bindParam(":Direccion_completo", $direccionCompleto);
				$stmt->execute();
			} else {
				// Insertar nuevo registro
				$sql = "INSERT INTO colindante_denominacion (Denominacion_Rural,Colindante_Sur_Nombre,Colindante_Sur_Denominacion, Colindante_Norte_Nombre,Colindante_Norte_Denominacion,Colindante_Este_Nombre,Colindante_Este_Denominacion,Colindante_Oeste_Nombre,Colindante_Oeste_Denominacion) VALUES (:Denominacion_Rural,:Colindante_Sur_Nombre,:Colindante_Sur_Denominacion,:Colindante_Norte_Nombre,:Colindante_Norte_Denominacion,:Colindante_Este_Nombre,:Colindante_Este_Denominacion,:Colindante_Oeste_Nombre,:Colindante_Oeste_Denominacion)";
			
				$stmt = $pdo->prepare($sql);
			
				// Asignar valores a los parámetros
				$stmt->bindParam(":Denominacion_Rural", $datos['Denominacion']);
				$stmt->bindParam(":Colindante_Sur_Nombre", $datos['Colindante_Sur_Nombre']);
				$stmt->bindParam(":Colindante_Sur_Denominacion", $datos['Colindante_Sur_Denominacion']);
				$stmt->bindParam(":Colindante_Norte_Nombre", $datos['Colindante_Norte_Nombre']);
				$stmt->bindParam(":Colindante_Norte_Denominacion", $datos['Colindante_Norte_Denominacion']);
				$stmt->bindParam(":Colindante_Este_Nombre", $datos['Colindante_Este_Nombre']);
				$stmt->bindParam(":Colindante_Este_Denominacion", $datos['Colindante_Este_Denominacion']);
				$stmt->bindParam(":Colindante_Oeste_Nombre", $datos['Colindante_Oeste_Nombre']);
				$stmt->bindParam(":Colindante_Oeste_Denominacion", $datos['Colindante_Oeste_Denominacion']);			
				if ($stmt->execute()) {
					$id_Col_denominacion = $pdo->lastInsertId();
				$stmt3 = $pdo->prepare("UPDATE predio SET Id_Colindante_Denominacion = :Id_Colindante_Denominacion WHERE Id_Predio = :Id_Predio");
				$stmt3->bindParam(":Id_Predio", $datos['id_predio']);
				$stmt3->bindParam(":Id_Colindante_Denominacion", $id_Col_denominacion);
				$stmt3->execute();

				$stmt = $pdo->prepare("SELECT  CONCAT(z.nombre_zona,' - ', d.Denominacion)AS Nuevo_Direccion_completo from  predio p
				INNER JOIN denominacion_rural d ON p.Id_Denominacion_Rural = d.Id_Denominacion_Rural 
				INNER JOIN catastro_rural cr ON p.Id_Catastro_Rural = cr.Id_Catastro_Rural
				INNER JOIN valores_categoria_x_hectarea vc ON cr.Id_valores_categoria_x_hectarea = vc.Id_valores_categoria_x_hectarea
				INNER JOIN zona_rural z ON vc.Id_Zona_Rural = z.Id_zona_rural
				WHERE p.Id_Predio =:Id_Predio");
				$stmt->bindParam(":Id_Predio", $datos['id_predio']);
				$stmt->execute();
				$direccion = $stmt->fetch();
				$direccionCompleto = $direccion['Nuevo_Direccion_completo'];

				$sql = "UPDATE predio SET Id_Colindante_Denominacion=:Id_Colindante_Denominacion,Direccion_completo=:Direccion_completo
				WHERE Id_Catastro_Rural = :Id_Catastro_Rural";
				$stmt = $pdo->prepare($sql);
				$stmt->bindParam(":Id_Catastro_Rural", $idCatastro);
				$stmt->bindParam(":Id_Colindante_Denominacion", $id_Col_denominacion);
				$stmt->bindParam(":Direccion_completo", $direccionCompleto);
				$stmt->execute();
				}

			}


			/*------------ */
		}
		$stmt3 = $pdo->prepare("UPDATE predio
                    SET Fecha_Adquisicion = :fecha_adquisicion,
                        Area_Terreno = :area_terreno,
                        Valor_Terreno = :valor_terreno,
                        Valor_predio = :Valor_predio,
                        Expediente_Tramite = :expediente,
                        Observaciones = :observacion,
                        Id_Tipo_Predio = :tipo_predio,
                        Id_Uso_Predio = :uso_predio,
                        Id_Estado_Predio = :estado_predio,
                        Id_Regimen_Afecto = :regimen_inafecto,
                        Id_inafecto = :inafecto,
                        Id_Condicion_Predio = :condicion_predio ,
						Id_Uso_Terreno=:uso_terreno,
						Id_Tipo_Terreno =:tipo_terreno,
						Valor_Predio_Aplicar=:valor_predio_aplicar
                     WHERE Id_Predio = :Id_Predio");
		$stmt3->bindParam(":fecha_adquisicion", $datos['fecha_adquisicion']);
		$stmt3->bindParam(":area_terreno", $datos['area_terreno']);
		$stmt3->bindParam(":valor_terreno", $datos['valor_terreno']);
		$stmt3->bindParam(":Valor_predio", $datos['valor_predio']);
		$stmt3->bindParam(":expediente", $datos['expediente']);
		$stmt3->bindParam(":observacion", $datos['observacion']);
		$stmt3->bindParam(":tipo_predio", $datos['tipo_predio']);
		$stmt3->bindParam(":uso_predio", $datos['uso_predio']);
		$stmt3->bindParam(":estado_predio", $datos['estado_predio']);
		$stmt3->bindParam(":regimen_inafecto", $datos['regimen_inafecto']);
		$stmt3->bindParam(":inafecto", $datos['inafecto']);
		$stmt3->bindParam(":condicion_predio", $datos['condicion_predio']);
		$stmt3->bindParam(":uso_terreno", $datos['uso_terreno']);
		$stmt3->bindParam(":tipo_terreno", $datos['tipo_terreno']);
		$stmt3->bindParam(":valor_predio_aplicar", $datos['valor_predio']);
		//	$stmt3->bindParam(":id_usuario", $datos['id_usuario']);
		$stmt3->bindParam(":Id_Predio", $datos['id_predio']);
		if ($stmt3->execute()) {
			return 'ok';
		} else {
			return 'error';
		}
	}


	public static function ndlNuevoPredioR($datos)
	{
		$pdo = Conexion::conectar();
		$catastroRural = $pdo->prepare("SELECT v.Id_zona_rural as campo1, v.Id_Grupo_Tierra as campo2 , v.Id_Calidad_Agricola as campo3, v.Id_valores_categoria_x_hectarea as campo4, a.Id_Anio as campo5 FROM valores_categoria_x_hectarea v INNER JOIN arancel_rustico_hectarea ar ON ar.Id_valores_categoria_x_hectarea =v.Id_valores_categoria_x_hectarea INNER JOIN arancel_rustico a  ON ar.Id_Arancel_Rustico=a.Id_Arancel_Rustico WHERE v.Id_valores_categoria_x_hectarea=:Id_valores_categoria_x_hectarea");
		$catastroRural->bindParam(":Id_valores_categoria_x_hectarea", $datos['Id_valores_categoria_x_hectarea'], PDO::PARAM_INT);
		$catastroRural->execute();
		$resultado = $catastroRural->fetch(); // Obtener la única fila de resultados
		//formar el codigoCatastro del predio
		if ($resultado) {
			$codigoCatastral = 'R' . $resultado['campo1'] . '' . $resultado['campo2'] . '' . $resultado['campo3'] . '' . $resultado['campo4'] . '' . $resultado['campo5'] . '';
		} else {
			$codigoCatastral = 'Fuera de Grupo Tierra';
		}
		//---
		$pdo->exec("LOCK TABLES catastro_rural WRITE");
		$pdo->beginTransaction();
		$stmt1 = $pdo->prepare("INSERT INTO catastro_rural(Codigo_Catastral, Id_valores_categoria_x_hectarea) VALUES (:Codigo_Catastral, :Id_valores_categoria_x_hectarea)");
		$stmt1->bindParam(":Codigo_Catastral", $codigoCatastral);
		$stmt1->bindParam(":Id_valores_categoria_x_hectarea", $datos['Id_valores_categoria_x_hectarea']);
		$stmt1->execute();
		$id_ultimo = $pdo->lastInsertId();
		$stmt12 = $pdo->prepare("SELECT Codigo_Catastral FROM catastro_rural WHERE Id_Catastro_Rural = :Id_Catastro_Rural");
		$stmt12->bindParam(":Id_Catastro_Rural", $id_ultimo);
		$stmt12->execute();
		$resultado2 = $stmt12->fetch(); // Obtener la única fila de resultados
		$codigoCatastral = ''; // Variable para almacenar el nuevo código catastral

		if ($stmt12->rowCount() > 0) {
			$codigoCatastral = $resultado2['Codigo_Catastral'] . '-' . $id_ultimo; // Concatenar el ID al código existente
		} else {
			$codigoCatastral = 'Fuera de sector rural'; // No se encontró ningún registro con el ID_Catastro igual a $id_ultimo
		}
		$stmt2 = $pdo->prepare("UPDATE catastro_rural SET Codigo_Catastral = :Codigo_Catastral WHERE Id_Catastro_Rural = :Id_Catastro_Rural");
		$stmt2->bindParam(":Codigo_Catastral", $codigoCatastral);
		$stmt2->bindParam(":Id_Catastro_Rural", $id_ultimo, PDO::PARAM_INT);
		$stmt2->execute();
		$pdo->exec("UNLOCK TABLES");
		$pdo->commit();
		//------------------
		//BUSCAR EL ID DE LA DENOMINACION RURAL
		$stmt = $pdo->prepare("SELECT Id_Denominacion_Rural FROM denominacion_rural WHERE Denominacion=:Denominacion");
		$stmt->bindParam(":Denominacion", $datos['Denominacion']);

		if ($stmt->execute()) {
			$idDenoRural = $stmt->fetch();
			if (is_array($idDenoRural) && isset($idDenoRural['Id_Denominacion_Rural'])) {
				$idDenoRural = $idDenoRural['Id_Denominacion_Rural'];
			} else {
				$stmt = $pdo->prepare(" INSERT INTO denominacion_rural(Denominacion,Id_Zona_Rural) VALUES(:Denominacion,:Id_Zona_Rural) ");
				$stmt->bindParam(":Denominacion", $datos['Denominacion']);
				$stmt->bindParam(":Id_Zona_Rural", $datos['Id_Zona_Rural']);
				$stmt->execute();
				$idDenoRural = $pdo->lastInsertId();
			}
		}
		//
		$stmt = $pdo->prepare(" INSERT INTO colindante_denominacion(Denominacion_Rural, Id_Denominacion_Rural, Colindante_Sur_Nombre, Colindante_Sur_Denominacion, Colindante_Norte_Nombre, Colindante_Norte_Denominacion, Colindante_Este_Nombre, Colindante_Este_Denominacion, Colindante_Oeste_Nombre, Colindante_Oeste_Denominacion)VALUES(:Denominacion_Rural ,:Id_Denominacion_Rural ,:Colindante_Sur_Nombre ,:Colindante_Sur_Denominacion ,:Colindante_Norte_Nombre ,:Colindante_Norte_Denominacion ,:Colindante_Este_Nombre ,:Colindante_Este_Denominacion ,:Colindante_Oeste_Nombre ,:Colindante_Oeste_Denominacion)");

		$stmt->bindParam(":Denominacion_Rural", $datos['Denominacion_Rural']);
		$stmt->bindParam(":Id_Denominacion_Rural", $idDenoRural);
		$stmt->bindParam(":Colindante_Sur_Nombre", $datos['Colindante_Sur_Nombre']);
		$stmt->bindParam(":Colindante_Sur_Denominacion", $datos['Colindante_Sur_Denominacion']);
		$stmt->bindParam(":Colindante_Norte_Nombre", $datos['Colindante_Norte_Nombre']);
		$stmt->bindParam(":Colindante_Norte_Denominacion", $datos['Colindante_Norte_Denominacion']);
		$stmt->bindParam(":Colindante_Este_Nombre", $datos['Colindante_Este_Nombre']);
		$stmt->bindParam(":Colindante_Este_Denominacion", $datos['Colindante_Este_Denominacion']);
		$stmt->bindParam(":Colindante_Oeste_Nombre", $datos['Colindante_Oeste_Nombre']);
		$stmt->bindParam(":Colindante_Oeste_Denominacion", $datos['Colindante_Oeste_Denominacion']);
		if ($stmt->execute()) {
			$id_Col_denominacion = $pdo->lastInsertId();
		} else {
			$id_Col_denominacion = null;
		}

		try {
			$valorPredioAplicar = ($datos['Valor_predio'] - $datos['Valor_Inaf_Exo']);
			$stmt = $pdo->prepare("INSERT INTO predio(Fecha_Adquisicion, Area_Terreno, Valor_Terreno, Valor_predio, Expediente_Tramite, Observaciones, predio_UR, Id_Tipo_Predio, Id_Uso_Predio, Id_Estado_Predio, Id_Regimen_Afecto, Id_inafecto , Id_Condicion_Predio, Id_Anio ,Id_Uso_Terreno ,Id_Tipo_Terreno ,Id_Colindante_Denominacion ,Id_Colindante_Propietario, id_usuario, Valor_Inaf_Exo, Id_Catastro_Rural,	Id_Denominacion_Rural,Valor_Construccion,Valor_Otras_Instalacions,Area_Construccion,Valor_Predio_Aplicar,Direccion_completo)VALUES(:Fecha_Adquisicion, :Area_Terreno, :Valor_Terreno, :Valor_predio, :Expediente_Tramite, :Observaciones, :predio_UR, :Id_Tipo_Predio, :Id_Uso_Predio, :Id_Estado_Predio, :Id_Regimen_Afecto, :Id_inafecto, :Id_Condicion_Predio, :Id_Anio,:Id_Uso_Terreno ,:Id_Tipo_Terreno,  :Id_Colindante_Denominacion,:Id_Colindante_Propietario ,:id_usuario,:Valor_Inaf_Exo,:Id_Catastro_Rural,:Id_Denominacion_Rural,:Valor_Construccion,:Valor_Otras_Instalacions,:Area_Construccion,:Valor_Predio_Aplicar,:Direccion_completo)");

			$stmt->bindParam(":Fecha_Adquisicion", $datos['Fecha_Adquisicion']);
			$stmt->bindParam(":Area_Terreno", $datos['Area_Terreno']);
			$stmt->bindParam(":Valor_Terreno", $datos['Valor_Terreno']);
			$stmt->bindParam(":Valor_predio", $datos['Valor_predio']);
			$stmt->bindParam(":Expediente_Tramite", $datos['Expediente_Tramite']);
			$stmt->bindParam(":Observaciones", $datos['Observaciones']);
			$stmt->bindParam(":predio_UR", $datos['predio_UR']);
			$stmt->bindParam(":Id_Tipo_Predio", $datos['Id_Tipo_Predio']);
			$stmt->bindParam(":Id_Uso_Predio", $datos['Id_Uso_Predio']);
			$stmt->bindParam(":Id_Estado_Predio", $datos['Id_Estado_Predio']);
			$stmt->bindParam(":Id_Regimen_Afecto", $datos['Id_Regimen_Afecto']);
			$stmt->bindParam(":Id_inafecto", $datos['Id_inafecto']);
			$stmt->bindParam(":Id_Condicion_Predio", $datos['Id_Condicion_Predio']);
			$stmt->bindParam(":Id_Anio", $datos['Id_Anio']);
			$stmt->bindValue(":Valor_Construccion", 0);
			$stmt->bindValue(":Valor_Otras_Instalacions", 0);
			$stmt->bindValue(":Area_Construccion", 0);
			$stmt->bindParam(":Id_Uso_Terreno", $datos['Id_Uso_Terreno']);
			$stmt->bindParam(":Id_Tipo_Terreno", $datos['Id_Tipo_Terreno']);
			$stmt->bindParam(":Id_Colindante_Denominacion", $id_Col_denominacion); //se tiene que crear el id
			$stmt->bindParam(":Id_Colindante_Propietario", $datos['Id_Colindante_Propietario']);
			$stmt->bindParam(":id_usuario", $datos['id_usuario']);
			$stmt->bindParam(":Valor_Inaf_Exo", $datos['Valor_Inaf_Exo']);
			$stmt->bindParam(":Id_Catastro_Rural", $id_ultimo);
			$stmt->bindParam(":Id_Denominacion_Rural", $idDenoRural);
			$stmt->bindParam(":Valor_Predio_Aplicar", $valorPredioAplicar);
			$stmt->bindParam(":Direccion_completo", $direccionCompleto);
			$stmt->execute();
			$id_predio = $pdo->lastInsertId(); //captura el id del ultimo predio insertado

			//ACTUALIZAR EL NOMBRE COMPLETO
			$stmt = $pdo->prepare("UPDATE predio p
			INNER JOIN denominacion_rural d ON p.Id_Denominacion_Rural = d.Id_Denominacion_Rural 
			INNER JOIN catastro_rural cr ON p.Id_Catastro_Rural = cr.Id_Catastro_Rural
			INNER JOIN valores_categoria_x_hectarea vc ON cr.Id_valores_categoria_x_hectarea = vc.Id_valores_categoria_x_hectarea
			INNER JOIN zona_rural z ON vc.Id_Zona_Rural = z.Id_zona_rural
			SET p.Direccion_completo = CONCAT(z.nombre_zona, ' - ', d.Denominacion)
			WHERE p.Id_Predio =:Id_Predio");
			$stmt->bindParam("Id_Predio", $id_predio);
			$stmt->execute();

			// ---------------
			$pdo->exec("LOCK TABLES detalle_transferencia WRITE");
			$pdo->beginTransaction();
			$stmt4 = $pdo->prepare("INSERT INTO detalle_transferencia(Id_Documento_Inscripcion , Numero_Documento_Inscripcion, Id_Tipo_Escritura , Fecha_Escritura) VALUES (:Id_Documento_Inscripcion, :Numero_Documento_Inscripcion, :Id_Tipo_Escritura, :Fecha_Escritura)");
			$stmt4->bindParam(":Id_Documento_Inscripcion", $datos['Id_Documento_Inscripcion']);
			$stmt4->bindParam(":Numero_Documento_Inscripcion", $datos['Numero_Documento_Inscripcion']);
			$stmt4->bindParam(":Id_Tipo_Escritura", $datos['Id_Tipo_Escritura']);
			$stmt4->bindParam(":Fecha_Escritura", $datos['Fecha_Escritura']);
			$stmt4->execute();
			$id_detalle = $pdo->lastInsertId();
			//--
			$propietaroios = $datos['Id_Contribuyente'];
			$propietarios_array = explode(",", $propietaroios);


			foreach ($propietarios_array as $valor) {
				$stmt5 = $pdo->prepare("INSERT INTO propietario(Id_Predio ,Id_Contribuyente ,Estado_Transferencia ,Id_Detalle_Transferencia,Baja )VALUES(:Id_Predio,:Id_Contribuyente,:Estado_Transferencia ,:Id_Detalle_Transferencia,'1')");
				$stmt5->bindParam(":Id_Predio", $id_predio);
				$stmt5->bindParam(":Id_Contribuyente", $valor);
				$stmt5->bindParam(":Estado_Transferencia", $datos['Estado_Transferencia']);
				$stmt5->bindParam(":Id_Detalle_Transferencia", $id_detalle);

				$stmt5->execute();
			}

			/* Generando el codigo de carpeta*/
			$stmt = $pdo->prepare("
						SELECT 
							(SELECT Codigo_Carpeta FROM Configuracion) AS Codigo_Carpeta, 
							(SELECT COUNT(*) FROM carpeta WHERE Concatenado_id = :concatenado_id) AS con
									");
			$propietarios_array = array_map('trim', $propietarios_array);
			$propietarios_array = array_filter($propietarios_array);
			sort($propietarios_array);
			$propietarios_carpeta = implode("-", $propietarios_array);
			$stmt->bindParam(':concatenado_id', $propietarios_carpeta, PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$codigo_carpeta = $result['Codigo_Carpeta'];
			$exists = $result['con'];
			if ($exists == 0) {
				$codigo_carpeta += 1;

				try {
					// Insertar el nuevo registro en la tabla carpeta
					$stmt_insert = $pdo->prepare("INSERT INTO carpeta (Concatenado_id, Codigo_Carpeta) VALUES (:concatenado_id, :codigo_carpeta)");
					$stmt_insert->bindParam(':concatenado_id', $propietarios_carpeta, PDO::PARAM_STR);
					$stmt_insert->bindParam(':codigo_carpeta', $codigo_carpeta, PDO::PARAM_INT);
					$stmt_insert->execute();
					$stmt_update = $pdo->prepare("UPDATE Configuracion SET Codigo_Carpeta = :codigo_carpeta");
					$stmt_update->bindParam(':codigo_carpeta', $codigo_carpeta, PDO::PARAM_INT);
					$stmt_update->execute();
				} catch (Exception $e) {
					// Revertir la transacción en caso de error
					$pdo->rollBack();
					throw $e;
				}
			}
			/* fin de generacion de codigo de carpeta */
			$pdo->exec("UNLOCK TABLES");
			$pdo->commit();

			return "ok";
		} catch (Exception $e) {
			echo "Error al egistrar predio rural: " . $e->getMessage();
		}
	}

	// ACTUALIZAR USUARIO ESTADO
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
	public static function mdlBorrarContribuyente($tabla, $datos)
	{
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla  WHERE Id_Contribuyente=:id");
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


	
	public static function mdlListarPredio($valor, $anio_actual)
	{
		$pdo = Conexion::conectar();
		//$anio_actual = implode(',', $anio);

		// Preparar la consulta SQL TRAE PREDIOS DE CADA CONTRIBUYENTE
		if (count($valor) === 1) {
			$id = $valor[0];
			$query = "SELECT 
						p.predio_UR as tipo_ru, 
						p.Direccion_completo as direccion_completo,
						IF(p.predio_UR = 'U', ca.Codigo_Catastral, car.Codigo_Catastral) as catastro,
						p.Id_Predio as id_predio,
						p.Area_Terreno as a_terreno,
						p.Area_Construccion as a_construccion,
						p.Valor_Predio_Aplicar as v_predio_aplicar
					FROM 
						predio p 
						LEFT JOIN catastro ca ON p.predio_UR = 'U' AND ca.Id_Catastro = p.Id_Catastro 
						LEFT JOIN catastro_rural car ON p.predio_UR = 'R' AND car.Id_Catastro_Rural = p.Id_Catastro_Rural 
						INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
						INNER JOIN anio an ON an.Id_Anio = p.Id_Anio 
					WHERE 
						pro.Id_Contribuyente = :id AND an.NomAnio =:anio
						AND p.ID_Predio NOT IN (
							SELECT ID_Predio 
							FROM Propietario 
							WHERE ID_Contribuyente <> :id AND Baja='1'
						)and pro.Baja='1';";

			$stmt = $pdo->prepare($query);
			$stmt->bindParam(":id", $id);
			$stmt->bindParam(":anio", $anio_actual);
		} else {
			$ids = implode(",", $valor);
			$count = count($valor);
			$query = "SELECT
			p.predio_UR as tipo_ru, 
						p.Direccion_completo as direccion_completo,
						IF(p.predio_UR = 'U', ca.Codigo_Catastral, car.Codigo_Catastral) as catastro,
						p.Id_Predio as id_predio,
						p.Area_Terreno as a_terreno,
						p.Area_Construccion as a_construccion,
						p.Valor_Predio_Aplicar as v_predio_aplicar
		  FROM 
			predio p 
			LEFT JOIN catastro ca ON p.predio_UR = 'U' AND ca.Id_Catastro = p.Id_Catastro 
            LEFT JOIN catastro_rural car ON p.predio_UR = 'R' AND car.Id_Catastro_Rural = p.Id_Catastro_Rural 
			INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
			INNER JOIN anio an ON an.Id_Anio = p.Id_Anio
			WHERE pro.Id_Contribuyente IN ($ids) and an.NomAnio=:anio  AND pro.Baja='1' 
			GROUP BY p.ID_Predio HAVING COUNT(DISTINCT pro.ID_Contribuyente) = " . count($valor) . " ORDER BY p.predio_UR";
			
			$stmt = $pdo->prepare($query);
			$stmt->bindParam(":anio", $anio_actual);
		}
		// Ejecutar la consulta
		$stmt->execute();
		$campos = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// Generar el contenido HTML
		$content = '';
		if (count($campos) > 0) {
			foreach ($campos as $key => $value) {
				$content .= self::generateRowHTML($value, $key + 1);
			}
		} else {
			$content .= "<td colspan='10' style='text-align:center;'>No hay Registro de Predio(s) en el año <b>" . $anio_actual . "</b></td>";
		}

		$pdo = null;
		return $content;
	}

	

	private static function generateRowHTML($value, $key)
	{

		return sprintf(
			'<tr id_predio="%s" id_catastro="%s" id_tipo="%s" id="fila">
                <td class="text-center">%d</td>
                <td class="text-center">%s</td>
                <td>%s</td>
                <td class="text-center" style="display:none;">%s</td>
                <td class="text-center">%s</td>
                <td class="text-center">%s</td>
                <td class="text-center">%s</td>
				<td class="text-center"><i class="bi bi-image" id="id_predio_foto" data-id_predio_foto="%s"></i></td>
            </tr>',
			$value['id_predio'],
			$value['catastro'],
			$value['tipo_ru'],
			$key,
			$value['tipo_ru'],
			$value['direccion_completo'],
			$value['catastro'],
			$value['a_terreno'],
			$value['a_construccion'],
			$value['v_predio_aplicar'],
			$value['id_predio']
		);
	}



	private static function generateRowHTML_licencia_agua($value, $key)
	{

		return sprintf(
			'<tbody class="body-predio"><tr id_predio="%s" idcatastro="%s" id_tipo="%s" id="fila">
                <td class="text-center">%d</td>
                <td class="text-center">%s</td>
                <td>%s</td>
                <td class="text-center">%s</td>
                <td class="text-center">%s</td>
                <td class="text-center">%s</td>
            </tr></tbody>',
			$value['id_predio'],
			$value['idcatastro'],
			$value['tipo_ru'],
			$key,
			$value['tipo_ru'],
			$value['direccion_completo'],
			$value['id_predio'],
			$value['a_terreno'],
			$value['a_construccion'],
		);
	}


	public static function mdlListarPredioAgua($valor, $anio_actual)
	{
		$pdo =  Conexion::conectar();
		if (count($valor) === 1) {
			$id = $valor[0];
			$query = "SELECT 
						p.predio_UR as tipo_ru, 
						p.Direccion_completo as direccion_completo,
						p.Id_Predio as id_predio,
						ca.Codigo_Catastral as catastro,
						ca.Id_Catastro as idcatastro,
						p.Area_Terreno as a_terreno,
						p.Area_Construccion as a_construccion
					
					FROM 
						predio p 
						INNER  JOIN catastro ca ON  ca.Id_Catastro = p.Id_Catastro 
						INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
						INNER JOIN anio an ON an.Id_Anio = p.Id_Anio 
					WHERE 
						pro.Id_Contribuyente = :id AND an.NomAnio =:anio
						AND p.ID_Predio NOT IN (
							SELECT ID_Predio 
							FROM Propietario 
							WHERE ID_Contribuyente <> :id AND Baja='1'
						)and pro.Baja='1';";
			$stmt = $pdo->prepare($query);
			$stmt->bindParam(":id", $id);
			$stmt->bindParam(":anio", $anio_actual);
		} else {
			$ids = implode(",", $valor);
			$count = count($valor);
			$query = "SELECT
			p.predio_UR as tipo_ru, 
						p.Direccion_completo as direccion_completo,
						ca.Codigo_Catastral as catastro,
						ca.Id_Catastro as idcatastro,
						p.Id_Predio as id_predio,
						p.Area_Terreno as a_terreno,
						p.Area_Construccion as a_construccion
						
		  FROM 
			predio p 
			INNER  JOIN catastro ca ON  ca.Id_Catastro = p.Id_Catastro 
           -- LEFT JOIN catastro_rural car ON p.predio_UR = 'R' AND car.Id_Catastro_Rural = p.Id_Catastro_Rural 
			INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
			INNER JOIN anio an ON an.Id_Anio = p.Id_Anio
			WHERE pro.Id_Contribuyente IN ($ids) and an.NomAnio=:anio  AND pro.Baja='1' and p.predio_UR='U'
			GROUP BY p.ID_Predio HAVING COUNT(DISTINCT pro.ID_Contribuyente) = " . count($valor) . " ORDER BY p.predio_UR";
			$stmt = $pdo->prepare($query);
			$stmt->bindParam(":anio", $anio_actual);
		}
		// Ejecutar la consulta
		$stmt->execute();
		$campos = $stmt->fetchAll(PDO::FETCH_ASSOC);

		//	$campos = $stmt->fetchall();
		$content = "<tbody class='body-predio'>";
		foreach ($campos as $key => $value) {
			if ($value['tipo_ru'] == 'U') {
				$content .= '<tr id="fila" idcatastro="' . $value['idcatastro'] . '"><td>' . ++$key . '</td> 
         <td>' . $value['tipo_ru'] . '</td>
         <td>' . $value['direccion_completo'] . '</td> 
		 <td>' . $value['catastro'] . '</td>
		  <td>' . $value['a_terreno'] . '</td>';
			}
		}
		$content .=  "</tbody>";
		return $content;
		$pdo = null;


		$pdo = null;
		return $content;
	}

	public static function mdlListarPredioAgua_caja($valor, $year)
	{
		$pdo =  Conexion::conectar();
		if (count($valor) === 1) {
			// Cuando $valor tiene un solo valor
			$stmt = $pdo->prepare("SELECT  

															la.*,
																la.Id_Licencia_Agua as idlicenciaagua,
																c.Id_Contribuyente as id_contribuyente,
			                                               c.Documento as documento,
														   c.Nombre_Completo as nombre_completo,
														   la.Numero_Licencia as numero_licencia,
														   t.Codigo as tipo_via,
														   c.Direccion_Completo as direccion_completo,
															nv.Nombre_Via as nombre_calle,
															m.NumeroManzana as numManzana,
															cu.Numero_Cuadra as cuadra,
															z.Nombre_Zona as zona,
															h.Habilitacion_Urbana as habilitacion
														    from licencia_agua la 
													inner join contribuyente c on la.Id_Contribuyente=c.Id_Contribuyente
			    INNER JOIN ubica_via_urbano u ON u.Id_Ubica_Vias_Urbano = la.Id_Ubica_Vias_Urbano  
                INNER JOIN direccion d ON u.Id_Direccion = d.Id_Direccion 
                INNER JOIN tipo_via t ON t.Id_Tipo_Via = d.Id_Tipo_Via 
                INNER JOIN zona z ON u.Id_Zona = z.Id_Zona
                INNER JOIN manzana m ON u.Id_Manzana = m.Id_Manzana 
                INNER JOIN cuadra cu ON cu.Id_cuadra = u.Id_Cuadra 
                INNER JOIN habilitaciones_urbanas h ON h.Id_Habilitacion_Urbana = z.Id_Habilitacion_Urbana 
                INNER JOIN nombre_via nv ON nv.Id_Nombre_Via = d.Id_Nombre_Via  
													where
               la.Id_Contribuyente =:id and la.Estado=1");
			$stmt->bindParam(":id", $valor[0]);
			$stmt->execute();
		}
		$campos = $stmt->fetchall();
		$content = "<tbody class='body-predio'>";



		$num = 0;
		foreach ($campos as $key => $value) {

			$num += 1;
			// Si es diferente, mostrar la dirección y reiniciar la variable auxiliar
			$content .= '<tr id="fila" idlicenciaagua_caja="' . $value['idlicenciaagua'] . '"><td class="text-center">' . $num . '</td> 
            
                         <td>'.
						 $value['tipo_via'].
						 $value['nombre_calle'].
						 $value['Numero_Ubicacion'].
						 " Mz. " .$value['numManzana'].
						 " Lt. " .$value['Lote'].
						 " Luz " .$value['Luz'].
						 " Cdr " .$value['cuadra'].
						 " " .$value['habilitacion'].
						 "-" .$value['zona']. '</td>'.
                         '<td class="text-center">' . $value['numero_licencia'] . '</td></tr>';
			
		}
		$content .=  "</tbody>";
		return $content;
		$pdo = null;
	}


	//ELIMINAR ORDNE PAGO
	public static function mdlEliminarOrdenPago($valor)
	{

		try {
			// Obtener la conexión a la base de datos
			$pdo = Conexion::conectar();
	
			// Iniciar una transacción
			$pdo->beginTransaction();
	
			// Consulta para eliminar de orden_cuenta_detalle
			$query1 = $pdo->prepare("
				DELETE FROM orden_cuenta_detalle
				WHERE anio_actual = :anio_actual
				AND id_orden_Pago IN (
					SELECT Orden_Pago FROM orden_pago WHERE Numero_Orden = :numero_orden
				)
			");
			// Vinculamos los parámetros
			$query1->bindParam(':anio_actual', $valor['anio'], PDO::PARAM_INT);
			$query1->bindParam(':numero_orden', $valor['id_selecionado'], PDO::PARAM_INT);
			
			$query1->execute();
	
			// Consulta para eliminar de orden_pago
			$query2 = $pdo->prepare("
				DELETE FROM orden_pago
				WHERE Numero_Orden = :numero_orden
			");
			// Vinculamos el parámetro
			$query2->bindParam(':numero_orden', $valor['id_selecionado'], PDO::PARAM_INT);
			$query2->execute();
	
			// Si ambas consultas se ejecutan correctamente, hacemos commit
			$pdo->commit();
	
			// Devolver éxito
			return array("status" => "success", "message" => "Orden de pago eliminada exitosamente");
		} catch (Exception $e) {
			// Si ocurre algún error, deshacemos la transacción
			$pdo->rollBack();
	
			// Devolver error
			return array("status" => "error", "message" => $e->getMessage());
		}
	}
	

	// 
	// BUSCAR CONTRIBUYENTE PARA EL REGISTRO DE PREDIO
	public static function mdlBuscarContribuyente($tabla, $valor)
	{
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE (Id_Contribuyente LIKE :valor OR Documento LIKE :valor) OR (Nombres LIKE :valor OR Apellido_Paterno LIKE :valor OR Apellido_Materno Like :valor) LIMIT 50");
		$parametros = array(':valor' => '%' . $valor . '%');

		$stmt->execute($parametros);
		return $stmt->fetchall();
	}
	// LISTA PREDIO PARA IMPUESTO
	public static function mdlPredio_impuesto($datos, $anio, $predios_arbitrio) //optimizado
	{
		$pdo =  Conexion::conectar();
		$valor = explode('-', $datos);
		$anio_ = $anio;
		//condicion para listar los predios para arbitrios
		if ($predios_arbitrio == 'lista_predio_arbitrios') {
			$predio_UR = 'and p.predio_UR="U"';
		} else {
			$predio_UR = '';
		}
		$resultados = array(); // Aquí almacenaremos los resultados
		if (count($valor) === 1) {
			// Cuando $valor tiene un solo valor
			//	$stmt = $pdo->prepare("CREATE TEMPORARY TABLE temp_propietarios AS SELECT * FROM propietario
			//	                       WHERE Estado_Transferencia IN ('T', 'R');");
			//	$stmt->execute();
			$stmt = $pdo->prepare("SELECT 
                p.Id_Predio as id_predio,
                p.predio_UR as tipo_ru, 
                p.Direccion_completo as direccion_completo,
                IF(p.predio_UR = 'U', ca.Codigo_Catastral, car.Codigo_Catastral) as catastro,
				r.Regimen as regimen
            FROM 
                predio p 
                LEFT JOIN catastro ca ON p.predio_UR = 'U' AND ca.Id_Catastro = p.Id_Catastro 
                LEFT JOIN catastro_rural car ON p.predio_UR = 'R' AND car.Id_Catastro_Rural = p.Id_Catastro_Rural 
                INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
                INNER JOIN anio an ON an.Id_Anio = p.Id_Anio 
				INNER JOIN regimen_afecto r ON r.Id_Regimen_Afecto=p.Id_Regimen_Afecto
            WHERE 
                pro.Id_Contribuyente = :id AND an.NomAnio =$anio_  
                AND p.ID_Predio NOT IN (
                    SELECT ID_Predio 
                    FROM Propietario 
                    WHERE ID_Contribuyente <> :id AND Baja='1' 
                ) and pro.Baja='1' $predio_UR ORDER BY p.predio_UR DESC;");
			//NOT IN (SELECT ID_Predio FROM Propietario WHERE ID_Contribuyente <> :id)
			$stmt->bindParam(":id", $valor[0]);
			$stmt->execute();
		} else {
			// Cuando $valor tiene más de un valor
			//$stmt = $pdo->prepare("CREATE TEMPORARY TABLE temp_propietarios AS SELECT * FROM propietario WHERE Estado_Transferencia IN ('T', 'R');");
			//$stmt->execute();
			$ids = implode(",", $valor); // Convierte el array en una cadena de IDs separados por comas
			$stmt = $pdo->prepare("SELECT
			p.Id_Predio as id_predio,
			p.predio_UR as tipo_ru,
			p.Direccion_completo as direccion_completo,
			IF(p.predio_UR = 'U', ca.Codigo_Catastral, car.Codigo_Catastral) as catastro,
			r.Regimen as regimen
		  FROM 
			predio p 
			LEFT JOIN catastro ca ON p.predio_UR = 'U' AND ca.Id_Catastro = p.Id_Catastro 
            LEFT JOIN catastro_rural car ON p.predio_UR = 'R' AND car.Id_Catastro_Rural = p.Id_Catastro_Rural 
			INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
			INNER JOIN anio an ON an.Id_Anio = p.Id_Anio
			INNER JOIN regimen_afecto r ON r.Id_Regimen_Afecto=p.Id_Regimen_Afecto
			WHERE pro.Id_Contribuyente IN ($ids) $predio_UR and an.NomAnio=$anio_  AND pro.Baja='1' 
			GROUP BY p.ID_Predio HAVING COUNT(DISTINCT pro.ID_Contribuyente) = " . count($valor) . " ORDER BY p.predio_UR");
			$stmt->execute();
		}
		$campos = $stmt->fetchall();
		$content = "";
		if ($stmt->rowCount() > 0) {
			foreach ($campos as $key => $value) {
				$content .= '<tr id="fila" id_catastro="' . $value['catastro'] . '"  id_tipo="' . $value['tipo_ru'] . '" id_predio="' . $value['id_predio'] . '">';
				$content .= '<td class="text-center" id_predio=' . $value['id_predio'] . '>' . $value['id_predio'] . '</td> 
				<td class="text-center">' . $value['tipo_ru'] . '</td>
				<td>' . $value['direccion_completo'] . '</td>      
				<td class="text-center">' . $value['regimen'] . '</td>
				<td  id_predio_select="' . $value['id_predio'] . '" class="text-center action-column"><input type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" id="select_predio_calcular" data-size="mini" data-id="' . $value['id_predio'] . '" ></td>';
				$content .= '</tr>';
			}
		} else {
			$content .= "<tr id_catastro='nulo'><td colspan='5' style='text-align:center;'>No registra predio(s)</td></tr>";
		}
		return $content;
	}
	// EDITAR TRANSFERIR PREDIO
	public static function mdlEditarTransferirPredio($datos)
	{
		$ano_actual = date("Y");
		$ano_pasado = $datos['anio'];
		$array_anios = range($ano_pasado, $ano_actual);
		$propietarios = $datos['propietarios'];
		$propietarios_array = explode(",", $propietarios);


		try {
			$pdo = Conexion::conectar();
			// Bloquear la tabla
			//$pdo->query("LOCK TABLES detalle_transferencia WRITE");
			//$pdo->beginTransaction();
			// Realizar la inserción en detalle_transferencia
			$stmt = $pdo->prepare("INSERT INTO detalle_transferencia
				                       (Id_Documento_Inscripcion, 
									   Numero_Documento_Inscripcion, 
									   Id_Tipo_Escritura, 
									   Fecha_Escritura) 
									   VALUES
									   (:Id_Documento_Inscripcion, 
									   :Numero_Documento_Inscripcion,
									   :Id_Tipo_Escritura,
									   :Fecha_Escritura)");
			$stmt->bindParam(":Id_Documento_Inscripcion", $datos['tipo_documento']);
			$stmt->bindParam(":Numero_Documento_Inscripcion", $datos['n_documento']);
			$stmt->bindParam(":Id_Tipo_Escritura", $datos['tipo_escritura']);
			$stmt->bindParam(":Fecha_Escritura", $datos['fecha_escritura']);
			$stmt->execute();
			$id_ultimo = $pdo->lastInsertId();
			$Fecha_Transferencia = date("Y-m-d H:i:s");
			// Realizar la actualización
			for ($i = 0; $i < count($array_anios); $i++) {

				if ($datos['tipo'] == 'U') {
					$stmt = $pdo->prepare("SELECT pr.Id_Predio as id_predio 
				FROM propietario AS p JOIN predio AS pr ON p.Id_Predio = pr.Id_Predio 
				JOIN catastro AS c ON pr.Id_Catastro = c.Id_Catastro 
				JOIN anio AS a ON a.Id_Anio=pr.Id_Anio 
				WHERE c.Codigo_Catastral =:catastro and a.NomAnio=:anio");
					$stmt->bindParam(":catastro", $datos['catastro']);
					$stmt->bindParam(":anio", $array_anios[$i]);
					$stmt->execute();
				} else {
					$stmt = $pdo->prepare("SELECT pr.Id_Predio as id_predio 
				FROM propietario AS p JOIN predio AS pr ON p.Id_Predio = pr.Id_Predio 
				JOIN catastro_rural AS c ON pr.Id_Catastro_Rural = c.Id_Catastro_Rural 
				JOIN anio AS a ON a.Id_Anio=pr.Id_Anio 
				WHERE c.Codigo_Catastral =:catastro and a.NomAnio=:anio");
					$stmt->bindParam(":catastro", $datos['catastro']);
					$stmt->bindParam(":anio", $array_anios[$i]);
					$stmt->execute();
				}

				if ($stmt->rowCount() > 0) {
					if ($datos['tipo'] == 'U') {
						// Realizar la primera consulta
						$stmt = $pdo->prepare("SELECT pr.Id_Predio as id_predio 
							FROM propietario AS p JOIN predio AS pr ON p.Id_Predio = pr.Id_Predio 
							JOIN catastro AS c ON pr.Id_Catastro = c.Id_Catastro 
							JOIN anio AS a ON a.Id_Anio=pr.Id_Anio 
							WHERE c.Codigo_Catastral =:catastro and a.NomAnio=:anio");
						$stmt->bindParam(":catastro", $datos['catastro']);
						$stmt->bindParam(":anio", $array_anios[$i]);
						$stmt->execute();
						$resultado = $stmt->fetch();
						$id_predio = $resultado['id_predio'];
					} else {
						// Realizar la primera consulta
						$stmt = $pdo->prepare("SELECT pr.Id_Predio as id_predio 
							FROM propietario AS p JOIN predio AS pr ON p.Id_Predio = pr.Id_Predio 
							JOIN catastro_rural AS c ON pr.Id_Catastro_Rural = c.Id_Catastro_Rural 
							JOIN anio AS a ON a.Id_Anio=pr.Id_Anio 
							WHERE c.Codigo_Catastral =:catastro and a.NomAnio=:anio");
						$stmt->bindParam(":catastro", $datos['catastro']);
						$stmt->bindParam(":anio", $array_anios[$i]);
						$stmt->execute();
						$resultado = $stmt->fetch();
						$id_predio = $resultado['id_predio'];
					}


					if ($datos['tipo'] == 'U') {
						$stmt = $pdo->prepare("UPDATE propietario AS p
					JOIN predio AS pr ON p.Id_Predio = pr.Id_Predio
					JOIN catastro AS c ON pr.Id_Catastro = c.Id_Catastro
					JOIN anio AS a ON a.Id_Anio=pr.Id_Anio
					SET p.Estado_Transferencia ='O',p.Fecha_Transferencia=:Fecha_Transferencia,
					p.Baja='0'
					WHERE c.Codigo_Catastral = :catastro and a.NomAnio = :anio");
						$stmt->bindParam(":catastro", $datos['catastro']);
						$stmt->bindParam(":anio", $array_anios[$i]);
						$stmt->bindParam(":Fecha_Transferencia", $Fecha_Transferencia);
						$stmt->execute();
					} else {
						$stmt = $pdo->prepare("UPDATE propietario AS p
					JOIN predio AS pr ON p.Id_Predio = pr.Id_Predio
					JOIN catastro_rural AS c ON pr.Id_Catastro_Rural = c.Id_Catastro_Rural
					JOIN anio AS a ON a.Id_Anio=pr.Id_Anio
					SET p.Estado_Transferencia ='O',p.Fecha_Transferencia=:Fecha_Transferencia,
					p.Baja='0'
					WHERE c.Codigo_Catastral = :catastro and a.NomAnio = :anio");
						$stmt->bindParam(":catastro", $datos['catastro']);
						$stmt->bindParam(":anio", $array_anios[$i]);
						$stmt->bindParam(":Fecha_Transferencia", $Fecha_Transferencia);
						$stmt->execute();
					}

					// Insertar los nuevos propietarios relacionados con el registro en detalle_transferencia
					foreach ($propietarios_array as $valor) {
						$stmt = $pdo->prepare("INSERT INTO propietario
					                                   (Id_Predio, 
													   Id_Contribuyente,
													   Estado_Transferencia, 
													   Id_Detalle_Transferencia, 
													   Baja) 
													   VALUES
													   (:Id_Predio, 
													   :Id_Contribuyente,
													   :Estado_Transferencia, 
													   :Id_Detalle_Transferencia,
													   '1')");
						$stmt->bindParam(":Id_Predio", $id_predio);
						$stmt->bindParam(":Id_Contribuyente", $valor);
						$stmt->bindValue(":Estado_Transferencia", 'T');
						$stmt->bindParam(":Id_Detalle_Transferencia", $id_ultimo);
						$stmt->execute();
					}


					/* Generando el codigo de carpeta*/
					$stmt = $pdo->prepare("
								SELECT 
									(SELECT Codigo_Carpeta FROM Configuracion) AS Codigo_Carpeta, 
									(SELECT COUNT(*) FROM carpeta WHERE Concatenado_id =:concatenado_id) AS con
											");

					sort($propietarios_array);
					$propietarios_array = array_map('trim', $propietarios_array);
					$propietarios_array = array_filter($propietarios_array);
					//	$propietarios_array = array_map('trim', $propietarios_array);
					$propietarios_carpeta = implode("-", $propietarios_array);
					$stmt->bindParam(':concatenado_id', $propietarios_carpeta);
					$stmt->execute();
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					$codigo_carpeta = $result['Codigo_Carpeta'];


					$exists = $result['con'];

			
					

					if ($exists == 0) {
						$codigo_carpeta += 1;

						try {
							// Insertar el nuevo registro en la tabla carpeta
							$stmt_insert = $pdo->prepare("INSERT INTO carpeta (Concatenado_id,Codigo_Carpeta) VALUES (:concatenado_id,:codigo_carpeta)");
							$stmt_insert->bindParam(':concatenado_id', $propietarios_carpeta);
							$stmt_insert->bindParam(':codigo_carpeta', $codigo_carpeta, PDO::PARAM_INT);
							$stmt_insert->execute();
							$stmt_update = $pdo->prepare("UPDATE Configuracion SET Codigo_Carpeta =:codigo_carpeta");
							$stmt_update->bindParam(':codigo_carpeta', $codigo_carpeta, PDO::PARAM_INT);
							$stmt_update->execute();


								//INSERTAR TABLA HISTORIAL
						$stmt = $pdo->prepare("
						INSERT INTO historial_predio 
						(Id_Predio, Fecha_Hora_Registro, Estado, Numero_Carpeta) 
						VALUES (:Id_Predio, :Fecha_Hora_Registro, :Estado, :Numero_Carpeta)
						");
						$stmt->bindParam(":Id_Predio", $id_predio);
						$stmt->bindParam(":Fecha_Hora_Registro", date("Y-m-d H:i:s"));
						$stmt->bindValue(":Estado", 'T');  // 'T' para indicar que está transferido
						$stmt->bindParam(":Numero_Carpeta", $codigo_carpeta);
						$stmt->execute();
						//END TABLA HISTORIAL

						} catch (Exception $e) {
							// Revertir la transacción en caso de error
							$pdo->rollBack();
							throw $e;
						}
				
						} 
						if ($exists != 0) {
							try {
								

					/* Generando el codigo de carpeta*/
					$stmt = $pdo->prepare("
								SELECT 
									(SELECT Codigo_Carpeta FROM Configuracion) AS Codigo_Carpeta, 
									(SELECT COUNT(*) FROM carpeta WHERE Concatenado_id =:concatenado_id) AS con
											");

							sort($propietarios_array);
							$propietarios_array = array_map('trim', $propietarios_array);
							$propietarios_array = array_filter($propietarios_array);
							//	$propietarios_array = array_map('trim', $propietarios_array);
							$propietarios_carpeta = implode("-", $propietarios_array);
							$stmt->bindParam(':concatenado_id', $propietarios_carpeta);
							$stmt->execute();
							$result = $stmt->fetch(PDO::FETCH_ASSOC);
							$codigo_carpeta = $result['Codigo_Carpeta'];



							//INSERTAR TABLA HISTORIAL
						$stmt = $pdo->prepare("
						INSERT INTO historial_predio 
						(Id_Predio, Fecha_Hora_Registro, Estado, Numero_Carpeta) 
						VALUES (:Id_Predio, :Fecha_Hora_Registro, :Estado, :Numero_Carpeta)
						");
						$stmt->bindParam(":Id_Predio", $id_predio);
						$stmt->bindParam(":Fecha_Hora_Registro", date("Y-m-d H:i:s"));
						$stmt->bindValue(":Estado", 'T');  // 'T' para indicar que está transferido

						 // Asigna el valor a una variable antes de usar bindParam
						 $numero_carpeta = '7';  
						$stmt->bindParam(":Numero_Carpeta", $numero_carpeta);
						$stmt->execute();
						} catch (Exception $e) {
							// Revertir la transacción en caso de error
							$pdo->rollBack();
							throw $e;
						}
						//END TABLA HISTORIAL
						}
						
					/* fin de generacion de codigo de carpeta */
				}
			}


			// Después de la generación del código de carpeta
			


			//LEYEN O->OTORGADO -> no debe mostrar por ya son los antiguos dueños
			// T TRANSFERIDO  -> si debe mostrar ya que es el nuevo propietario
			// R REGISTRADO   -> si debe mostrar por que se registro el predio
			// E ELIMINADO  -> no debe mostrar ya que fue eliminado el predio
			// Liberar el bloqueo de la tabla
			//	$pdo->query("UNLOCK TABLES");

			//	$pdo->commit();
			return 'ok';
		} catch (Exception $e) {
			// Manejo de errores
			//	$pdo->rollBack();
			$pdo = Null;
			return '<div>Error: ' . $e->getMessage() . '</div>';
		}
	}




	// ELIMINAR PREDIO
	public static function mdlEliminarPredio($datos)
	{
		try {
			$pdo = Conexion::conectar();
			// Bloquear la tabla
			$pdo->query("LOCK TABLES detalle_eliminar WRITE");
			$pdo->beginTransaction();

			// Realizar la inserción en detalle_eliminar
			$stmt = $pdo->prepare("INSERT INTO detalle_eliminar(Detalle_Eliminar,id_usuario) VALUES(:Detalle_Eliminar,:id_usuario)");
			$stmt->bindParam(":Detalle_Eliminar", $datos['documento']);
			$stmt->bindParam(":id_usuario", $datos['id_usuario']);
			$stmt->execute();
			$id_ultimo = $pdo->lastInsertId();
			// Realizar la actualización
			$stmt = $pdo->prepare("UPDATE propietario AS p
            SET p.Estado_Transferencia ='E',p.Id_Detalle_Eliminar=$id_ultimo
		    ,p.Baja='0'
            WHERE p.Id_Predio=:id_predio");
			$stmt->bindParam(":id_predio", $datos['id_predio']);
			$stmt->execute();
			//session
			//LEYEN O->OTORGADO -> no debe mostrar por ya son los antiguos dueños
			// T TRANSFERIDO  -> si debe mostrar ya que es el nuevo propietario
			// R REGISTRADO   -> si debe mostrar por que se registro el predio
			// E ELIMINADO  -> no debe mostrar ya que fue eliminado el predio
			// Liberar el bloqueo de la tabla

			$pdo->query("UNLOCK TABLES");
			$pdo->commit();
			return "ok";
		} catch (Exception $e) {
			// Manejo de errores
			$pdo->rollBack();

			return '<div>Error: ' . $e->getMessage() . '</div>';
		}
	}
	// COPIAR PREDIO
	public static function mdlCopiarPredio($datos, $id_predio)
	{
		$anoActual = $datos['anio_actual'];
		$anoCopiar = $datos['anio_copiar'];
		$propietarios = $datos['propietarios'];
		$propietarios_array = explode(",", $propietarios);
		sort($propietarios_array);
		try {
			$pdo = Conexion::conectar();
			if ($datos['forzar_copear'] == 'forzar') {
				foreach ($propietarios_array as $valor) {
					$stmt = $pdo->prepare("INSERT INTO propietario (Id_Predio,
						                                               Id_Contribuyente,
																	   Estado_Transferencia,
																	   Fecha_Transferencia,
																	   Id_Detalle_Transferencia,
																	   Baja)
		                                               SELECT $id_predio,
													          $valor,
															  pro.Estado_Transferencia,
															  pro.Fecha_Transferencia,
															  pro.Id_Detalle_Transferencia,
															  pro.Baja
															  FROM propietario pro 
															  inner join predio p on p.Id_Predio=pro.Id_Predio 
															 -- inner join catastro_rural ca on ca.Id_Catastro_Rural=p.Id_Catastro_Rural  
															  inner join anio a on a.Id_Anio=p.Id_Anio 
															 -- where ca.Codigo_Catastral=:catastro 
															 where pro.Id_Predio=:id_predio
															  and pro.Id_Contribuyente IN ($propietarios) 
															  and pro.Baja='1'
															  and a.NomAnio=:anio_actual GROUP BY pro.Id_Predio;");
					$stmt->bindParam(":id_predio", $datos["id_predio"]);
					$stmt->bindParam(":anio_actual", $anoActual);
					$stmt->execute();
				}
				return "ok";
			} else {
				if ($datos["tipo"] == 'U') {
					$stmt = $pdo->prepare("SELECT Id_Anio FROM `anio` where NomAnio=$anoCopiar;");
					$stmt->execute();
					$id_anio_copear = $stmt->fetchColumn();
					$stmt = $pdo->prepare("INSERT INTO predio 
											(Fecha_Adquisicion, 
											Numero_Luz, 
											Area_Terreno, 
											Valor_Terreno, 
											Valor_Construccion, 
											Valor_Otras_Instalacions, 
											Valor_predio, 
											Expediente_Tramite, 
											Observaciones, 
											predio_UR, 
											Area_Construccion, 
											Id_Tipo_Predio, 
											Id_Giro_Establecimiento, 
											Id_Uso_Predio, 
											Id_Estado_Predio, 
											Id_Regimen_Afecto, 
											Id_inafecto, 
											Id_Arbitrios, 
											Id_Condicion_Predio, 
											Id_Catastro, 
											Id_Anio,
											Valor_Inaf_Exo,
											Valor_Predio_Aplicar, 
											id_usuario,
											Direccion_completo)
                                        SELECT Fecha_Adquisicion,
			                                   Numero_Luz, 
											   Area_Terreno, 
											   Valor_Terreno, 
											   Valor_Construccion,
                                               Valor_Otras_Instalacions, 
											   Valor_predio, 
											   Expediente_Tramite, 
											   Observaciones, 
											   predio_UR, 
											   Area_Construccion, 
											   Id_Tipo_Predio, 
											   Id_Giro_Establecimiento, 
											   Id_Uso_Predio, 
											   Id_Estado_Predio, 
											   Id_Regimen_Afecto,
											   Id_inafecto, 
											   Id_Arbitrios, 
											   Id_Condicion_Predio, 
											   Id_Catastro, 
											   :anio_p,
											   Valor_Inaf_Exo,
											   Valor_Predio_Aplicar,
											   id_usuario,
											   Direccion_completo
											FROM
											predio
											INNER JOIN
											anio ON anio.Id_Anio = predio.Id_Anio
											WHERE
											predio.Id_Predio = :id_predio
											AND anio.NomAnio = :anio_actual");
					$stmt->bindParam(":id_predio", $datos['id_predio']);
					$stmt->bindParam(":anio_p", $id_anio_copear);
					$stmt->bindParam(":anio_actual", $anoActual);
					$stmt->execute();
					$id_ultimo_predio = $pdo->lastInsertId(); // Capturamos el Id_Predio de la última inserción
                    

					//actualizando el valor de Predio
                    $stmt_v = $pdo->prepare("UPDATE predio p
												INNER JOIN catastro c ON c.Id_Catastro = p.Id_Catastro
												INNER JOIN ubica_via_urbano u ON u.Id_Ubica_Vias_Urbano = c.Id_Ubica_Vias_Urbano
												INNER JOIN arancel_vias a ON a.Id_Ubica_Vias_Urbano = c.Id_Ubica_Vias_Urbano
												INNER JOIN arancel ar ON ar.Id_Arancel = a.Id_Arancel
												INNER JOIN anio an ON an.Id_Anio=ar.Id_Anio
												SET 
													p.Valor_Terreno = p.Area_Terreno *ar.Importe,
													p.Valor_predio = (p.Valor_Terreno + p.Valor_Construccion + p.Valor_Otras_Instalacions),
													p.Valor_Predio_Aplicar = (p.Valor_predio - p.Valor_Inaf_Exo)
												WHERE p.Id_Predio = :id_predio and an.Id_Anio=:anio_p;");
					$stmt_v->bindParam(":id_predio", $id_ultimo_predio);
					$stmt_v->bindParam(":anio_p", $id_anio_copear);
					$stmt_v->execute();

					// Realizar la inserción de pisos por años
					$stmt_p = $pdo->prepare("SELECT Id_Piso  FROM pisos where Id_Predio=:id_predio ");
					$stmt_p->bindParam(":id_predio", $datos["id_predio"]);
					$stmt_p->execute();
					if ($stmt_p->rowCount() > 0) {
						$stmt = $pdo->prepare("INSERT INTO pisos 
					                                  (Catastro_Piso,
													  Numero_Piso,
													  Incremento, 	
													  Fecha_Construccion,
													  Cantidad_Anios,
													  Valores_Unitarios,	
													  Porcentaje_Depreciacion,
													  Valor_Unitario_Depreciado,
													  Area_Construida,
													  Valor_Area_Construida,
													  Areas_Comunes,
													  Valor_Areas_Comunes,
													  Valor_Construida,
													  Fecha_Registro,
													  Categorias_Edificacion,
													  Id_Estado_Conservacion,
													  Id_Clasificacion_Piso,
													  Id_Material_Piso,
													  Id_Predio)
		                                        SELECT   Catastro_Piso,
												         Numero_Piso,
														 Incremento, 	
														 Fecha_Construccion,
														 Cantidad_Anios,
														 Valores_Unitarios,	
														 Porcentaje_Depreciacion,
														 Valor_Unitario_Depreciado,
														 Area_Construida,
														 Valor_Area_Construida,
														 Areas_Comunes,
														 Valor_Areas_Comunes,
														 Valor_Construida,
														 Fecha_Registro,
														 Categorias_Edificacion,
														 Id_Estado_Conservacion,
														 Id_Clasificacion_Piso,
														 Id_Material_Piso,
														 $id_ultimo_predio
		                                       FROM pisos WHERE Id_Predio =:id_predio");
						$stmt->bindParam(":id_predio", $datos["id_predio"]);
						$stmt->execute();
					}
					// Insertar los nuevos propietarios relacionados con el detalle_transferencia
					foreach ($propietarios_array as $valor) {
						$stmt = $pdo->prepare("INSERT INTO propietario 
												(Id_Predio,
												Id_Contribuyente,
												Estado_Transferencia,
												Fecha_Transferencia,
												Id_Detalle_Transferencia,
												Baja)
		                                    SELECT $id_ultimo_predio,
											       $valor,
												   pro.Estado_Transferencia,
												   pro.Fecha_Transferencia,
												   pro.Id_Detalle_Transferencia,
												   pro.Baja
												   FROM propietario pro 
												   inner join predio p 
												   on p.Id_Predio=pro.Id_Predio 
												  -- inner join catastro ca on ca.Id_Catastro=p.Id_Catastro  
												   inner join anio a on a.Id_Anio=p.Id_Anio 
												 --  where ca.Codigo_Catastral=:catastro 
												 where pro.Id_Predio=:id_predio
												   and pro.Id_Contribuyente IN ($propietarios) 
												   and Baja='1' 
												   and a.NomAnio=:anio_actual GROUP BY pro.Id_Predio;");
						$stmt->bindParam(":id_predio", $datos["id_predio"]);
						$stmt->bindParam(":anio_actual", $anoActual);
						$stmt->execute();
					}
				} else {
					$stmt = $pdo->prepare("SELECT Id_Anio FROM `anio` where NomAnio=$anoCopiar;");
					$stmt->execute();
					$anio_p = $stmt->fetchColumn();
					$stmt = $pdo->prepare("INSERT INTO predio 
					                      (Fecha_Adquisicion, 
										  Area_Terreno, 
										  Valor_Terreno, 
										  Valor_Construccion, 
										  Valor_Otras_Instalacions, 
										  Valor_predio, 
										  Expediente_Tramite, 
										  Observaciones, 
										  predio_UR, 
										  Area_Construccion, 
										  Id_Tipo_Predio, 
										  Id_Uso_Predio, 
										  Id_Estado_Predio, 
										  Id_Regimen_Afecto, 
										  Id_inafecto, 
										  Id_Condicion_Predio, 
										  Id_Anio, id_usuario, 
										  Id_Uso_Terreno, 
										  Id_Tipo_Terreno, 
										  Id_Colindante_Denominacion,
										  Valor_Inaf_Exo, 
										  Id_Catastro_Rural, 
										  Id_Denominacion_Rural, 
										  Valor_Predio_Aplicar,
										  Direccion_completo)

                                   SELECT Fecha_Adquisicion, 
								          Area_Terreno, 
										  Valor_Terreno, 
										  Valor_Construccion,
                                          Valor_Otras_Instalacions, 
										  Valor_predio, 
										  Expediente_Tramite, 
										  Observaciones, 
										  predio_UR, Area_Construccion, 
										  Id_Tipo_Predio, 
										  Id_Uso_Predio, 
										  Id_Estado_Predio, 
										  Id_Regimen_Afecto, 
										  Id_inafecto, 
										  Id_Condicion_Predio, 
										  :idAnio, 
										  id_usuario, 
										  Id_Uso_Terreno, 
										  Id_Tipo_Terreno, 
										  Id_Colindante_Denominacion,
										  Valor_Inaf_Exo,  
										  Id_Catastro_Rural, 
										  Id_Denominacion_Rural, 
										  Valor_Predio_Aplicar,
										  Direccion_completo
									FROM
									predio
									INNER JOIN
									anio ON anio.Id_Anio = predio.Id_Anio
									WHERE
									predio.Id_predio = :id_predio
									AND anio.NomAnio = :anio_actual");
					$stmt->bindParam(":id_predio", $datos["id_predio"]);
					$stmt->bindParam(":idAnio", $anio_p);
					$stmt->bindParam(":anio_actual", $anoActual);
					$stmt->execute();
					$id_ultimo_predio = $pdo->lastInsertId();
					
						//actualizando el valor de Predio
						$stmt_v = $pdo->prepare("UPDATE predio p
						INNER JOIN catastro_rural c ON c.Id_Catastro_Rural = p.Id_Catastro_Rural
						INNER JOIN arancel_rustico_hectarea a ON a.Id_valores_categoria_x_hectarea = c.Id_valores_categoria_x_hectarea
						INNER JOIN arancel_rustico ar ON ar.Id_Arancel_Rustico = a.Id_Arancel_Rustico
						SET 
							p.Valor_Terreno = p.Area_Terreno *ar.Arancel,
							p.Valor_predio = (p.Valor_Terreno + p.Valor_Construccion + p.Valor_Otras_Instalacions),
							p.Valor_Inaf_Exo=p.Valor_predio/2,
							p.Valor_Predio_Aplicar = (p.Valor_predio - p.Valor_Inaf_Exo)
						WHERE p.Id_Predio = :id_predio and ar.Id_Anio=:anio_p;");
						$stmt_v->bindParam(":id_predio", $id_ultimo_predio);
						$stmt_v->bindParam(":anio_p", $anio_p);
						$stmt_v->execute();
					
					// Insertar los nuevos propietarios relacionados con el detalle_transferencia
					foreach ($propietarios_array as $valor) {
						$stmt = $pdo->prepare("INSERT INTO propietario (Id_Predio,
						                                               Id_Contribuyente,
																	   Estado_Transferencia,
																	   Fecha_Transferencia,
																	   Id_Detalle_Transferencia,
																	   Baja)
		                                               SELECT $id_ultimo_predio,
													          $valor,
															  pro.Estado_Transferencia,
															  pro.Fecha_Transferencia,
															  pro.Id_Detalle_Transferencia,
															  pro.Baja
															  FROM propietario pro 
															  inner join predio p on p.Id_Predio=pro.Id_Predio 
															 -- inner join catastro_rural ca on ca.Id_Catastro_Rural=p.Id_Catastro_Rural  
															  inner join anio a on a.Id_Anio=p.Id_Anio 
															 -- where ca.Codigo_Catastral=:catastro 
															 where pro.Id_Predio=:id_predio
															  and pro.Id_Contribuyente IN ($propietarios) 
															  and pro.Baja='1'
															  and a.NomAnio=:anio_actual GROUP BY pro.Id_Predio;");
						$stmt->bindParam(":id_predio", $datos["id_predio"]);
						$stmt->bindParam(":anio_actual", $anoActual);
						$stmt->execute();
					}
				}
				// Liberar el bloqueo de la tabla

				//	$pdo->query("UNLOCK TABLES");

				//	$pdo->commit();
				return 'ok';
			}
		} catch (Exception $e) {
			// Manejo de errores
			$pdo->rollBack();
			return '<div>Error: ' . $e->getMessage() . '</div>';
		}
	}
	public static function mdlMostrarPredio($tabla, $item1, $valor1)
	{
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item1 = :valor");
		$stmt->bindParam(":valor", $valor1, PDO::PARAM_STR);
		$stmt->execute();
		$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
		$stmt = null;
		return $resultado;
	}
	public static function mdlMostrarPredioT($table, $item1, $valor1)
	{
		$conexion = Conexion::conectar();
		$predio = [];
		$catastro = [];
		$ubicacion = [];
		$resulta4 = [];
		try {
			$stmt = $conexion->prepare("SELECT * FROM $table WHERE $item1 = :valor");
			$stmt->bindParam(":valor", $valor1, PDO::PARAM_INT);
			$stmt->execute();
			$predio = $stmt->fetch(PDO::FETCH_ASSOC);
			if (!empty($predio)) {
				$idCatastastroU = $predio['Id_Catastro'];
				$idCatastastroR = $predio['Id_Catastro_Rural'];
				$idColDenomi = $predio['Id_Colindante_Denominacion'];

				if ($idCatastastroU != null) {
					$stmt = $conexion->prepare("SELECT * FROM catastro WHERE Id_Catastro = :valor");
					$stmt->bindParam(":valor", $idCatastastroU, PDO::PARAM_INT);
					$stmt->execute();
					$catastro = $stmt->fetch(PDO::FETCH_ASSOC);

					$idUbicaVia = $catastro['Id_Ubica_Vias_Urbano'];
					$stmt = $conexion->prepare("SELECT * FROM ubica_via_urbano WHERE Id_Ubica_Vias_Urbano = :valor");
					$stmt->bindParam(":valor", $idUbicaVia, PDO::PARAM_INT);
					$stmt->execute();
					$ubicacion = $stmt->fetch(PDO::FETCH_ASSOC);
				}
				if ($idCatastastroR != null) {
					$stmt = $conexion->prepare("SELECT * FROM catastro_rural WHERE Id_Catastro_Rural = :valor");
					$stmt->bindParam(":valor", $idCatastastroR, PDO::PARAM_INT);
					$stmt->execute();
					$catastro = $stmt->fetch(PDO::FETCH_ASSOC);
				}
				$stmt = $conexion->prepare("SELECT DISTINCT Id_Detalle_Transferencia FROM propietario WHERE $item1 = :valor");
				$stmt->bindParam(":valor", $valor1);
				$stmt->execute();
				$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
				if ($resultado) {
					$idDetalleT = $resultado['Id_Detalle_Transferencia'];
					$stmt = $conexion->prepare("SELECT * FROM detalle_transferencia WHERE Id_Detalle_Transferencia = :idDetalleTransferencia");
					$stmt->bindParam(":idDetalleTransferencia", $idDetalleT, PDO::PARAM_INT);
					$stmt->execute();
					$resultado2 = $stmt->fetch(PDO::FETCH_ASSOC);
				} else {
					// No associated details found
					$resultado2 = null;
				}
				if ($idColDenomi != null) {
					$stmt4 = $conexion->prepare("SELECT * FROM colindante_denominacion WHERE Id_Colindante_Denominacion=:valor");
					$stmt4->bindParam(":valor", $idColDenomi);
					$stmt4->execute();
					$resulta4 = $stmt4->fetch(PDO::FETCH_ASSOC);
				}
				$predio = $predio + $resultado2 + $catastro + $ubicacion + $resulta4;
			} else {
				$predio = null;
			}
		} catch (Exception $e) {
			// Handle database error
			error_log("Error de base de datos: " . $e->getMessage());
			return null;
		} finally {
			// Close connection
			$conexion = null;
		}
		return $predio;
	}
	public static function mdlMostrarPropietarios($tabla, $item1, $valor1)
	{
		try {
			$conexion = Conexion::conectar();
			$stmt1 = $conexion->prepare("SELECT DISTINCT Id_Detalle_Transferencia FROM $tabla WHERE $item1  = :valor");
			$stmt1->bindParam(":valor", $valor1);
			$stmt1->execute();
			$resultado1 = $stmt1->fetch(PDO::FETCH_ASSOC);
			if ($resultado1) {
				$idDetalleTransferencia = $resultado1['Id_Detalle_Transferencia'];
				$stmt2 = $conexion->prepare("SELECT * FROM detalle_transferencia WHERE Id_Detalle_Transferencia = :idDetalleTransferencia");
				$stmt2->bindParam(":idDetalleTransferencia", $idDetalleTransferencia, PDO::PARAM_INT);
				$stmt2->execute();
				$resultado2 = $stmt2->fetch(PDO::FETCH_ASSOC);
				$conexion = null;
				return $resultado2;
			} else {
				return null;
			}
		} catch (Exception $e) {
			error_log("Error de base de datos: " . $e->getMessage());
			return null;
		}
	}
	public static function mdlMostrar_foto_carrusel($id_predio)
	{   $pdo = Conexion::conectar();
		$query = "SELECT ruta_foto FROM fotos_predios WHERE id_predio = :id_predio";
		$stmt = $pdo->prepare($query);
		$stmt->bindParam(':id_predio', $id_predio, PDO::PARAM_INT);
		$stmt->execute();

		$fotos = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $fotos;
	}
	public static function mdlGuardarfoto($datos, $id_predio)
	{
		$pdo = Conexion::conectar();
		$upload_dir = '../vistas/img/foto_predios/';
		$upload_dir_bd = './vistas/img/foto_predios/';
	
		// Asegúrate de que la carpeta de destino exista
		if (!is_dir($upload_dir)) {
			mkdir($upload_dir, 0755, true);
		}
	
		
	
		// Eliminar registros antiguos de la base de datos
		$sql = "DELETE FROM fotos_predios WHERE id_predio = :id_predio";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(['id_predio' => $id_predio]);
	
		$respuesta = ['tipo' => 'success', 'mensaje' => 'Fotos guardadas exitosamente'];
	
		// Iniciar contador de imágenes
		$contador_imagen = 1;
	
		foreach ($datos['name'] as $key => $name) {
			// Obtener la extensión del archivo
			$file_extension = pathinfo($name, PATHINFO_EXTENSION);
	
			// Asignar el nuevo nombre de archivo con el formato id_predio-n.extension
			$new_file_name = $id_predio . '-' . $contador_imagen . '.' . $file_extension;
			$upload_file = $upload_dir . $new_file_name;

			$new_file_name = $id_predio . '-' . $contador_imagen . '.' . $file_extension;
			$upload_file_db = $upload_dir_bd . $new_file_name;
	
			// Obtener el nombre temporal del archivo
			$tmp_name = $datos['tmp_name'][$key];
	
			// Mover el archivo al directorio de destino
			if (move_uploaded_file($tmp_name, $upload_file)) {
				// Guardar la ruta en la base de datos
				$sql = "INSERT INTO fotos_predios (id_predio, ruta_foto) VALUES (:id_predio, :ruta_foto)";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([
					'id_predio' => $id_predio, // ID del predio
					'ruta_foto' => $upload_file_db
				]);
	
				// Incrementar el contador de imágenes para la próxima iteración
				$contador_imagen++;

	         
			} else {
				// Si ocurre un error, detener el proceso y devolver el mensaje de error
				$respuesta = "error";
				break;
			}
		}
	
		return $respuesta;
	}

	public static function mdlAgregar_ContribuyentePredio($contribuyentes,$predios,$id_propietario,$carpeta)
	{	
	
		$pdo = Conexion::conectar();
		foreach($contribuyentes as $contribuyente){
			$concat_contribuyentes = $id_propietario . '-' .$contribuyente;
			foreach ($predios as $predio) {
				$query = "SELECT Estado_Transferencia,Id_Detalle_Transferencia FROM propietario WHERE id_predio = :id_predio";
				$stmt = $pdo->prepare($query);
				$stmt->bindParam(':id_predio', $predio, PDO::PARAM_INT);
				$stmt->execute();
				$estadoTransferencia =$stmt->fetch(PDO::FETCH_ASSOC);
				$stmt5 = $pdo->prepare("INSERT INTO propietario(Id_Predio ,Id_Contribuyente ,Estado_Transferencia ,Id_Detalle_Transferencia,Baja)VALUES(:Id_Predio,:Id_Contribuyente,:Estado_Transferencia,:Id_Detalle_Transferencia,'1')");
				$stmt5->bindParam(":Id_Predio", $predio);
				$stmt5->bindParam(":Id_Contribuyente", $contribuyente);
				$stmt5->bindParam(":Estado_Transferencia", $estadoTransferencia['Estado_Transferencia']);
				$stmt5->bindParam(":Id_Detalle_Transferencia", $estadoTransferencia['Id_Detalle_Transferencia']);
				if(!$stmt5->execute()){
					$respuesta = ([false,"Error al Registrar al Contribuyente"]);
					return $respuesta;
				}
			}
		}
		$numbers = explode('-', $concat_contribuyentes);

		sort($numbers, SORT_NUMERIC);
		$concat_contribuyentes_ordenado = implode('-', $numbers);
		$stmt_update = $pdo->prepare("UPDATE carpeta SET Concatenado_id =:Concatenado_id WHERE 	Codigo_Carpeta = $carpeta");
		$stmt_update->bindParam(':Concatenado_id', $concat_contribuyentes_ordenado, PDO::PARAM_STR);
		if(!$stmt_update->execute()){
			$respuesta = ([false,"Error al actualizar la carpeta"]);
			return $respuesta;
		}
		$stmt_update2 = $pdo->prepare("UPDATE estado_cuenta_corriente SET Concatenado_idc=:Concatenado_idcD WHERE Concatenado_idc = '$id_propietario'");
		$stmt_update2->bindParam(':Concatenado_idcD', $concat_contribuyentes_ordenado, PDO::PARAM_STR);
		if(!$stmt_update2->execute()){
			$respuesta = ([false,"Error al pasar la deuda a los nuevos contribuyentes"]);
			return $respuesta;
		}
		$stmt_update3 = $pdo->prepare("UPDATE ingresos_tributos SET Concatenado_idc =:Concatenado_idcP WHERE Concatenado_idc = '$id_propietario'");
		$stmt_update3->bindParam(':Concatenado_idcP', $concat_contribuyentes_ordenado, PDO::PARAM_STR);
		if(!$stmt_update3->execute()){
			$respuesta = ([false,"Error al pasar los pagos a los nuevos contribuyentes"]);
			return $respuesta;
		}
		$respuesta = ([true,$concat_contribuyentes_ordenado]);
		return $respuesta;
	}
}
