<?php

namespace Modelos;
use Conect\Conexion;
use Exception;
use PDO;

class ModeloCaja
{
	public static function mdlMostrar_nrecibo()
	{
		$stmt = Conexion::conectar()->prepare("SELECT Numero_Recibo FROM configuracion; ");
		//$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
		$stmt->execute();
		return $stmt->fetch();
		$stmt = null;
	}
	public static function mdlReimprimir($numero_recibo,$tipo)
	{   if($tipo=='006'){
		    $conexion = Conexion::conectar();

			// Consulta inicial para obtener los datos de ingresos_tributos
			$stmt_impuesto = $conexion->prepare("SELECT * FROM ingresos_tributos WHERE Numeracion_caja = :numero_recibo");
			$stmt_impuesto->bindParam(":numero_recibo", $numero_recibo);
			$stmt_impuesto->execute();
			$impuestoResult = $stmt_impuesto->fetchAll(PDO::FETCH_ASSOC); // Suponiendo que solo hay un resultado

			// Explode para obtener los valores separados
			$valores = explode('-', $impuestoResult[0]['Concatenado_idc']);

			// Inicializamos el array donde almacenaremos los resultados
			$resultados = array();

			// Preparar consulta para obtener contribuyentes
			$stmtContribuyentes = $conexion->prepare("SELECT Id_Contribuyente, Nombre_Completo FROM contribuyente WHERE Id_Contribuyente = :Id_Contribuyente");

			// Recorremos los valores obtenidos para buscar los contribuyentes correspondientes
			foreach ($valores as $valor) {
				$stmtContribuyentes->bindParam(":Id_Contribuyente", $valor);
				$stmtContribuyentes->execute();
				$resultados[$valor] = $stmtContribuyentes->fetchAll(PDO::FETCH_ASSOC);
			}

			// Consulta para obtener el código de carpeta
			$stmtCarpeta = $conexion->prepare("SELECT Codigo_Carpeta FROM carpeta WHERE Concatenado_id = :carpeta");
			$stmtCarpeta->bindParam(":carpeta", $impuestoResult[0]['Concatenado_idc']);
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

			// Cerrar las conexiones
			$stmtContribuyentes = null;
			$stmtCarpeta = null;
			$conexion = null;

			// Estructurar los arrays para ser devueltos en un array combinado
			$response = array(
				'impuesto' => $impuestoResult,         // Primer array separado
				'resultados' => $resultados    // Segundo array separado
			);
				
			return $response;
		
	    }
		elseif($tipo=='009'){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM ingresos_especies_valoradas WHERE Numero_Caja=$numero_recibo ");
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt = null;
			}
		else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM ingresos_agua WHERE Numeracion_caja = :numero_recibo");
			$stmt->bindParam(":numero_recibo", $numero_recibo, PDO::PARAM_INT);
			$stmt->execute();
			$ingresos_agua = $stmt->fetchAll(PDO::FETCH_ASSOC); // Guardamos los datos

			if (!empty($ingresos_agua)) { // Verificamos que hay resultados
				$idContribuyente = $ingresos_agua[0]['Id_Contribuyente']; // Extraemos el ID

				$stmtContri = Conexion::conectar()->prepare("SELECT Id_Contribuyente,Nombre_Completo FROM contribuyente WHERE Id_Contribuyente = :idcontribuyente");
				$stmtContri->bindParam(":idcontribuyente", $idContribuyente, PDO::PARAM_INT);
				$stmtContri->execute();
				$contribuyente_agua = $stmtContri->fetch(PDO::FETCH_ASSOC); // Obtenemos los datos
			} else {
				$contribuyente_agua = null; // Si no hay datos, asignamos null
			}

			// Devolvemos la respuesta con datos válidos
			$response = array(
				'agua' => $ingresos_agua,        
				'contribuyente' => $contribuyente_agua  
			);

			return $response;

		}
		
	}
	public static function mdlTipo_papel()
	{
	
		$stmt = Conexion::conectar()->prepare("SELECT * FROM tipo_papel WHERE Estado=1; ");
		//$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
		$stmt->execute();
		return $stmt->fetch();
		$stmt = null;
	}

	//AQUI ENCONTRO
	public static function mdlRegistro_ingresos($datos)
	{  
		
		try {
			$ids_cuenta = $datos['id_cuenta'];
			$array = explode('-',$datos['id_propietarios']);
            sort($array);
			$id_contribuyente = $array[0];
            $id_propietario=implode('-', $array);
			//obteniedo el numero de caja
			$pdo  = Conexion::conectar();
			$pdo->beginTransaction();
			$fecha_actual = date("Y-m-d H:i:s"); 
			$stmt = $pdo->prepare("SELECT Numero_Recibo FROM configuracion; ");
		    $stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$numeracion = $row['Numero_Recibo']+1;	

			$stmt = $pdo->prepare("INSERT INTO ingresos_tributos
			     (Concatenado_idc,
				  Codigo_Catastral,
				  Numeracion_Caja,
				  Id_Area, 
				  Id_Presupuesto, 
				  Id_Financiamiento,
				  Tipo_Tributo,
				  Anio,
				  Periodo,
				  Importe,
				  Gasto_Emision,
				  Saldo,
				  TIM,
				  Total,
				  Descuento,
				  Total_Pagar,
				  Id_Estado_Cuenta_Impuesto,
				  Estado,
				  Cierre)
				  SELECT 
				Concatenado_idc,
				Codigo_Catastral,
				:numero_caja,
				:id_area,
				CASE
					WHEN Tipo_Tributo = 006 THEN
					CASE
						WHEN Anio < EXTRACT(YEAR FROM CURRENT_DATE) THEN 81 -- nuevo valor para Tipo_Tributo 742
						ELSE 41 -- nuevo valor para Tipo_Tributo 742
					END
	
				ELSE
				CASE
						WHEN Anio < EXTRACT(YEAR FROM CURRENT_DATE) THEN 48
						ELSE 48
						END
						END AS id_presupuesto,
						CASE
							WHEN Tipo_Tributo = 006 THEN 1
							WHEN Tipo_Tributo = 742 THEN 2
							ELSE 48
				END 
				
				AS id_financiamiento,
				Tipo_Tributo,
				Anio,
				Periodo,
				Importe,
				Gasto_Emision,
				Saldo,
				TIM_Aplicar,
				Total,
				Descuento,
				Total_Aplicar,
				Id_Estado_Cuenta_Impuesto,
				:estado,
				:cierre
				FROM estado_cuenta_corriente
				WHERE Id_Estado_Cuenta_Impuesto IN ($ids_cuenta) AND Concatenado_idc = '$id_propietario';
			");

			//Vincular parámetros
			$stmt->bindParam(':numero_caja',$numeracion);
			$stmt->bindValue(':id_area',1);
		//	$stmt->bindValue(':id_presupuesto',1);
			//$stmt->bindValue(':id_financiamiento',1);
			$stmt->bindValue(':estado','P');
			$stmt->bindValue(':cierre','0');
			$stmt->execute();


			// OBTENER TODO LO QUE SE INSERTO EN LA TABLA INGRESOS TRIBUTOS
			$stmt = $pdo->prepare("
					SELECT COALESCE(SUM(Total_Pagar), 0) AS Total,
					Numeracion_caja
					FROM ingresos_tributos
					WHERE Numeracion_Caja = :numero_caja
				");
				$stmt->bindValue(':numero_caja', $numeracion); 
				$stmt->execute();
				$rowTotal = $stmt->fetch(PDO::FETCH_ASSOC);
				$Total = $rowTotal['Total'];
				$Numeracion_caja = $rowTotal['Numeracion_caja'];

			// OBTENER TODO LO QUE SE INSERTO EN LA TABLA INGRESOS TRIBUTOS FIN


			$stmt = $pdo->prepare("UPDATE configuracion set Numero_Recibo=$numeracion; ");
		    $stmt->execute();
			//actulizar estado de cuenta como pagado y poner el numero de recibo
			$stmt = $pdo->prepare("UPDATE estado_cuenta_corriente 
			SET Numero_Recibo = $numeracion, Estado = 'H', Fecha_pago = '$fecha_actual'
			WHERE Id_Estado_Cuenta_Impuesto IN ($ids_cuenta) ");
		    $stmt->execute();



			//INSERTAR PARA COACTIVO

			// Verificar si el contribuyente tiene coactivo activado
			$stmt = $pdo->prepare("SELECT Coactivo FROM contribuyente WHERE Id_Contribuyente = :id");
			$stmt->bindValue(':id', $id_contribuyente, PDO::PARAM_INT); // Usamos el primer ID del array, ya que es el contribuyente base
			$stmt->execute();
			$coactivoData = $stmt->fetch(PDO::FETCH_ASSOC);

			$coactivoActivo = $coactivoData && $coactivoData['Coactivo'] == 1;

	
			if ($coactivoActivo) {
    $stmt = $pdo->prepare("INSERT INTO ingreso_coactivo (Fecha_Registro, Total, Numeracion_caja) 
                           VALUES (:Fecha_Registro, :Total, :Numeracion_caja)");
    $stmt->bindValue(':Fecha_Registro', date('Y-m-d'));
    $stmt->bindValue(':Total', $Total);
    $stmt->bindValue(':Numeracion_caja', $Numeracion_caja);
    $stmt->execute();

    // Obtener el ID del último registro insertado
    $idCoactivo = $pdo->lastInsertId();

    $stmt = $pdo->prepare("UPDATE ingresos_tributos 
                           SET Id_Ingreso_Coactivo = :idCoactivo 
                           WHERE Concatenado_idc = :Concatenado_idc 
                             AND Numeracion_caja = :Numeracion_caja");
    $stmt->bindValue(':idCoactivo', $idCoactivo, PDO::PARAM_INT);
    $stmt->bindValue(':Concatenado_idc', $id_propietario, PDO::PARAM_INT);
    $stmt->bindValue(':Numeracion_caja', $Numeracion_caja, PDO::PARAM_INT);
    $stmt->execute();
}

			
			//END INSERTAR PARA OCATIVO




			$pdo->commit();

			return "ok";
		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
		}
	}

	public static function mdlRegistro_ingresos_agua($datos)
	{  
		try {
			$ids_cuenta = $datos['id_cuenta'];
			$idlicencia=$datos['idlicencia'];
			//obteniedo el numero de caja
			$pdo  = Conexion::conectar();
			$pdo->beginTransaction();
			$fecha_actual = date("Y-m-d H:i:s"); 
			$stmt = $pdo->prepare("SELECT Numero_Recibo FROM configuracion; ");
		    $stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$numeracion = $row['Numero_Recibo']+1;	
			$stmt = $pdo->prepare("INSERT INTO ingresos_agua
			     (Id_Contribuyente,
				  Numeracion_Caja,
				  Id_Area, 
				  Id_Presupuesto, 
				  Id_Financiamiento,
				  Id_Licencia_Agua,
				  DNI,
				  Nombres,
				  Tipo_Tributo,
				  Anio,
				  Periodo,
				  Importe,
				  Gasto_Emision,
				  Saldo,
				  Total,
				  Descuento,
				  Total_Pagar,
				  Id_Estado_Cuenta_Agua,
				  Estado,
				  Cierre)
				SELECT Id_Contribuyente,
					   :numero_caja,
					   :id_area,
					   :id_presupuesto,
					   :id_financiamiento,
					   Id_Licencia_Agua,
					   DNI,
					   Nombres,
					   Tipo_Tributo,
					   Anio,
					   Periodo,
					   Importe,
					   Gasto_Emision,
					   Saldo,
					   Total,
					   Descuento,
					   Total_Aplicar,
					   Id_Estado_Cuenta_Agua,
					   :estado,
					   :cierre
				FROM estado_cuenta_agua
				WHERE Id_Estado_Cuenta_Agua IN ($ids_cuenta) AND Id_Licencia_Agua = '$idlicencia';
			");
			//Vincular parámetros
			$stmt->bindParam(':numero_caja',$numeracion);
			$stmt->bindValue(':id_area',24);
			$stmt->bindValue(':id_presupuesto',68);
			$stmt->bindValue(':id_financiamiento',2);
			$stmt->bindValue(':estado','P');
			$stmt->bindValue(':cierre','0');
			$stmt->execute();
			$stmt = $pdo->prepare("UPDATE configuracion set Numero_Recibo=$numeracion; ");
		    $stmt->execute();
			//actulizar estado de cuenta como pagado y poner el numero de recibo
			$stmt = $pdo->prepare("UPDATE estado_cuenta_agua 
			SET Numero_Recibo = $numeracion, Estado = 'H', Fecha_pago = '$fecha_actual'
			WHERE Id_Estado_Cuenta_Agua IN ($ids_cuenta) ");
		    $stmt->execute();
			$pdo->commit();

			return "ok";
		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
		}
	}

    //registro de ingresos proveido 
	public static function mdlRegistro_ingresos_proveido($datos)
	{  
		try {
			$id_proveido = $datos['id_proveido'];
			$id_usuario= $datos['id_usuario'];
			$pdo  = Conexion::conectar();
			//$pdo->beginTransaction();
			$fecha_actual = date("Y-m-d H:i:s"); 
			$stmt = $pdo->prepare("SELECT Numero_Recibo FROM configuracion;");
		    $stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$numeracion = $row['Numero_Recibo']+1;	
			$stmt = $pdo->prepare("INSERT INTO ingresos_especies_valoradas
			     (Id_Proveido,
				  Id_Especie_Valorada,
				  Cantidad,
				  Valor_Total, 
				  Descripcion, 
				  DNI,
				  Nombres,
				  Numero_Proveido,
				  Id_Area,
				  Id_Usuario,
				  Estado,
				  Cierre,
				  Numero_Caja)
				SELECT Id_Proveido,
				  Id_Especie_Valorada,
				  Cantidad,
				  Valor_Total, 
				  Descripcion, 
				  DNI,
				  Nombres,
				  Numero_Proveido,
				  Id_Area,
				  :id_usuario,
				  :estado,
				  :cierre,
				  :numero_caja
				FROM proveido
				WHERE Id_Proveido=$id_proveido;
			");
			//Vincular parámetros
			$stmt->bindParam(':numero_caja',$numeracion);
			$stmt->bindParam(':id_usuario',$id_usuario);
			$stmt->bindValue(':estado','P');
			$stmt->bindValue(':cierre','0');
			$stmt->execute();
			$id_ultimo_proveido = $pdo->lastInsertId();
			$stmt = $pdo->prepare("UPDATE configuracion set Numero_Recibo=$numeracion; ");
		    $stmt->execute();
			//actulizar estado de cuenta como pagado y poner el numero de recibo
			$stmt = $pdo->prepare("UPDATE proveido 
			SET Estado_Caja =1, Id_Cuenta_Especie_Valorada=$id_ultimo_proveido,Numero_Recibo=$numeracion
			WHERE Id_Proveido=$id_proveido ");
		    $stmt->execute();
			//$pdo->commit();

			return "ok";
		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
		}
	}



	public static function ctrCuenta_caja_pdf($id_cuenta)
	{  
		try {
			//obteniedo el numero de caja
			$pdo  = Conexion::conectar(); 
			$stmt = $pdo->prepare("SELECT Anio,Periodo,Importe,Gasto_Emision,TIM,Total,Descuento,Total_Pagar FROM ingresos_tributos
			                       WHERE Id_Estado_Cuenta_Impuesto in ($id_cuenta) AND Estado='P'; ");
		    $stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
		}	
	}

	

	public static function mdlLista_Proveidos($datos)
	{   
		try {
			$fecha=$datos['fecha'];
			//obteniedo el numero de caja
			$pdo  = Conexion::conectar(); 
			if($fecha!=null){
				$stmt = $pdo->prepare("SELECT   p.Id_Proveido as idproveido,
				                                p.Nombres as nombres,
												e.Nombre_Especie as nombre_especie,
												a.Nombre_Area as nombre_area,
												p.Descripcion as descripcion,
												e.Monto as monto,
												p.Cantidad as cantidad,
												p.Valor_Total as valor_total,
												p.Numero_Proveido as numero_proveido,
												a.Nombre_Iniciales as nombre_iniciales
												FROM proveido p 
												INNER JOIN area a ON a.Id_Area=p.Id_Area
												iNNER JOIN especie_valorada e on e.Id_Especie_Valorada=p.Id_Especie_Valorada 
												WHERE  date(p.Fecha_Registro)='${fecha}' and p.Estado_Caja=0 and Estado_Registro='R'");
			}
			else{
            $stmt = $pdo->prepare("SELECT   p.Id_Proveido as idproveido,
				                                p.Nombres as nombres,
												e.Nombre_Especie as nombre_especie,
												a.Nombre_Area as nombre_area,
												p.Descripcion as descripcion,
												e.Monto as monto,
												p.Cantidad as cantidad,
												p.Valor_Total as valor_total,
												p.Numero_Proveido as numero_proveido,
												a.Nombre_Iniciales as nombre_iniciales
												FROM proveido p 
												INNER JOIN area a ON a.Id_Area=p.Id_Area
												iNNER JOIN especie_valorada e on e.Id_Especie_Valorada=p.Id_Especie_Valorada
												WHERE p.Estado_Caja=0 and Estado_Registro='R'
				");
			}
		    $stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
		}	
	}
	//Mostrar el proveido cancelado en caja 
	
	public static function ctrProveido_caja_pdf($id_proveido)
	{   
		try {
			$pdo  = Conexion::conectar(); 
				$stmt = $pdo->prepare("SELECT   e.Id_Especie_Valorada as codigo,
				                                p.Id_Proveido as idproveido,
				                                p.DNI as dni,
				                                p.Nombres as nombres,
												e.Nombre_Especie as nombre_especie,
												a.Nombre_Area as nombre_area,
												p.Descripcion as descripcion,
												e.Monto as monto,
												p.Cantidad as cantidad,
												p.Valor_Total as valor_total,
												p.Numero_Proveido as numero_proveido,
												a.Nombre_Iniciales as nombre_iniciales,
												pro.Observaciones as observaciones
												FROM ingresos_especies_valoradas  p 
												INNER JOIN area a ON a.Id_Area=p.Id_Area
												iNNER JOIN especie_valorada e on e.Id_Especie_Valorada=p.Id_Especie_Valorada 
												INNER JOIN proveido pro on pro.Id_Proveido=p.Id_Proveido
												WHERE  p.Id_Proveido=$id_proveido AND p.Estado='P'");
			
		    $stmt->execute();
			return $stmt->fetch();
		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
		}	
	}

	public static function mdlExtornar($datos)
{
    try {
        $pdo = Conexion::conectar();

        // Iniciar la transacción
        $pdo->beginTransaction();
        $fechaHoraActual = date('Y-m-d H:i:s');

        // Lista de tablas y sus respectivas columnas de recibo
        $tablasIniciales = [
            ['nombre' => 'ingresos_tributos', 'columna' => 'Numeracion_caja'],
            ['nombre' => 'ingresos_agua', 'columna' => 'Numeracion_caja'],
            ['nombre' => 'ingresos_especies_valoradas', 'columna' => 'Numero_Caja']
        ];

        // Iterar sobre cada tabla inicial y realizar la actualización
        foreach ($tablasIniciales as $tabla) {
            $sql = "UPDATE {$tabla['nombre']} SET Estado = 'E', Fecha_Anula = :fecha WHERE {$tabla['columna']} = :numero_caja";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':numero_caja' => $datos['numero_caja'],
                ':fecha' => $fechaHoraActual
            ]);
            if ($stmt->rowCount() > 0) {
                // Si se realizó una actualización en una tabla inicial, proceder con las tablas secundarias
                $tablasSecundarias = [
                    ['nombre' => 'estado_cuenta_corriente', 'columna_recibo' => 'Numero_recibo', 'columna_estado' => 'Estado', 'valor_estado' => 'D'],
                    ['nombre' => 'estado_cuenta_agua', 'columna_recibo' => 'Numero_recibo', 'columna_estado' => 'Estado', 'valor_estado' => 'D'],
                    ['nombre' => 'proveido', 'columna_recibo' => 'Numero_recibo', 'columna_estado' => 'Estado_Caja', 'valor_estado' => '0']
                ];

                // Iterar sobre cada tabla secundaria y realizar la actualización
                foreach ($tablasSecundarias as $tablaSecundaria) {
                    $sqlSecundaria = "UPDATE {$tablaSecundaria['nombre']} SET {$tablaSecundaria['columna_recibo']} = '', {$tablaSecundaria['columna_estado']} = :estado WHERE {$tablaSecundaria['columna_recibo']} = :numero_recibo";
                    $stmtSecundaria = $pdo->prepare($sqlSecundaria);
                    $stmtSecundaria->execute([
                        ':numero_recibo' => $datos['numero_caja'],
                        ':estado' => $tablaSecundaria['valor_estado']
                    ]);
                }
				if ($stmt->rowCount() > 0) {
					$pdo->commit();
					return "ok";
				}

                // Confirmar la transacción y retornar 'ok'
                $pdo->commit();
                return "ok";
            }
        }

        // Si no se encontró el número de caja en ninguna tabla inicial, hacer rollback
        $pdo->rollBack();
        return "Número de caja no encontrado";

    } catch (Exception $e) {
        // En caso de error, hacer rollback y retornar el mensaje de error
        $pdo->rollBack();
        return "Error: " . $e->getMessage();
    }
}

	
}
