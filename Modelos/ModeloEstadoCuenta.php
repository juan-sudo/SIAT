<?php

namespace Modelos;

use Conect\Conexion;
use Exception;
use PDO;


class ModeloEstadoCuenta
{

//PARA BOTON ANTERIOR


public static function mdlEstadoCuenta_anterior_carpeta($datos)
{
    $pdo = Conexion::conectar();

    // Obtener el Código Carpeta del parámetro recibido
    $codigoCarpeta = (int)$datos['anterior'];  // ejemplo: 161

    // Preparamos la consulta una sola vez
    $stmt = $pdo->prepare("SELECT Concatenado_id FROM carpeta WHERE Codigo_Carpeta = :codigo_carpeta LIMIT 1");

    $resultado = false;

    // Intentamos hasta 6 veces: codigo, codigo-1, ..., codigo-5
    for ($i = 0; $i < 8; $i++) {
        $codigoActual = $codigoCarpeta - $i; // Restando en cada iteración

        // Bind y ejecución solo una vez dentro del bucle
        $stmt->bindParam(':codigo_carpeta', $codigoActual, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener el resultado de la consulta
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            break; // Si encontramos un resultado, salimos del bucle
        }
    }

    if ($resultado) {
        $pdo = null;
        return [
            'concatenado' => $resultado['Concatenado_id']
        ];
    } else {
        $pdo = null;
        return [
            'mensaje' => 'No se encontró un Concatenado_id en los siguientes 6 intentos.'
        ];
    }
}

//OBTENER IDS DE UN ID


//PARA PAAR QUE VUELVA TODOS LOS VALORES
public static function mdlEstadoCuenta_ids_de_id($datos)
{
    $pdo = Conexion::conectar();

    $ids = $datos['idseleccionado']; // Ya es un array de enteros

    $todosLosIds = [];

    $stmt = $pdo->prepare("
        WITH datos_base AS (
            SELECT Concatenado_idc, Anio, Tipo_Tributo
            FROM estado_cuenta_corriente
            WHERE Id_Estado_Cuenta_Impuesto = :idseleccionado
        )
        SELECT Id_Estado_Cuenta_Impuesto
        FROM estado_cuenta_corriente ecc
        JOIN datos_base db ON ecc.Concatenado_idc = db.Concatenado_idc
                           AND ecc.Anio = db.Anio
                           AND ecc.Tipo_Tributo = db.Tipo_Tributo
    ");

    foreach ($ids as $id) {
        $stmt->bindValue(':idseleccionado', $id, PDO::PARAM_INT);
        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if ($resultados) {
            $todosLosIds = array_merge($todosLosIds, $resultados);
        }
    }

    $pdo = null;

    // Eliminar duplicados
    $todosLosIds = array_unique($todosLosIds);

    return $todosLosIds;
}




//PARA BOTON SIGUIENTE
public static function mdlEstadoCuenta_siguiente_carpeta($datos)
{
    $pdo = Conexion::conectar();

    // Obtener el Código Carpeta del parámetro recibido
    $codigoCarpeta = (int)$datos['siguiente'];  // ejemplo: 161

    // Preparamos la consulta una sola vez
    $stmt = $pdo->prepare("SELECT Concatenado_id FROM carpeta WHERE Codigo_Carpeta = :codigo_carpeta LIMIT 1");

    $resultado = false;

    // Intentamos hasta 6 veces: codigo, codigo+1, ..., codigo+5
    for ($i = 0; $i < 15; $i++) {
        $codigoActual = $codigoCarpeta + $i;

        $stmt->bindParam(':codigo_carpeta', $codigoActual, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            break; // si encontramos un resultado, salimos del bucle
        }
    }

    if ($resultado) {
        $pdo = null;
        return [
            'concatenado' => $resultado['Concatenado_id']
        ];
    } else {
        $pdo = null;
        return [
            'mensaje' => 'No se encontró un Concatenado_id en los siguientes 6 intentos.'
        ];
    }
}


		
public static function mdlEstadoCuenta_pdfcaA($propietarios, $id_cuenta, $condicion, $anio, $tipo_tributo)
{
    $valoresSeparadosPorComa = explode(',', $propietarios);
    sort($valoresSeparadosPorComa);
    $ids = implode("-", $valoresSeparadosPorComa); // Convierte en un string separado por guiones

    // Conexión a la base de datos
    $stmt = Conexion::conectar()->prepare("SELECT 
        Anio, 
        SUM(Importe) AS Total_Importe, 
        SUM(Gasto_Emision) AS Total_Gasto_Emision, 
        SUM(Saldo) AS Total_Saldo, 
        SUM(TIM) AS Total_TIM, 
        SUM(TIM_Descuento) AS Total_TIM_Descuento, 
        SUM(TIM_Aplicar) AS Total_TIM_Aplicar, 
        SUM(Total) AS Total_Pagado, 
        SUM(Descuento) AS Total_Descuento, 
        SUM(Total_Aplicar) AS Total_Aplicado 
    FROM estado_cuenta_corriente  
    WHERE Concatenado_idc = :ids and `Tipo_Tributo`='742'
    AND Id_Estado_Cuenta_Impuesto IN ($id_cuenta) 
    GROUP BY Anio 
    ORDER BY Anio;");

    $stmt->bindValue(":ids", $ids);

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = null; // Liberar la conexión

    return $result;
}


	
public static function mdlEstadoCuenta_pdfcaI($propietarios, $id_cuenta, $condicion, $anio, $tipo_tributo)
{
    $valoresSeparadosPorComa = explode(',', $propietarios);
    sort($valoresSeparadosPorComa);
    $ids = implode("-", $valoresSeparadosPorComa); // Convierte en un string separado por guiones

    // Conexión a la base de datos
    $stmt = Conexion::conectar()->prepare("SELECT 
        Anio, 
        SUM(Importe) AS Total_Importe, 
        SUM(Gasto_Emision) AS Total_Gasto_Emision, 
        SUM(Saldo) AS Total_Saldo, 
        SUM(TIM) AS Total_TIM, 
        SUM(TIM_Descuento) AS Total_TIM_Descuento, 
        SUM(TIM_Aplicar) AS Total_TIM_Aplicar, 
        SUM(Total) AS Total_Pagado, 
        SUM(Descuento) AS Total_Descuento, 
        SUM(Total_Aplicar) AS Total_Aplicado 
    FROM estado_cuenta_corriente  
    WHERE Concatenado_idc = :ids and `Tipo_Tributo`='006'
    AND Id_Estado_Cuenta_Impuesto IN ($id_cuenta) 
    GROUP BY Anio 
    ORDER BY Anio;");

    $stmt->bindValue(":ids", $ids);

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = null; // Liberar la conexión

    return $result;
}



	//MOSTRAR TODO DESDE TODOS LOS AÑOS JUNTO


	
public static function mdlEstadoCuenta_pdfanios($propietarios, $id_cuenta, $condicion, $anio, $tipo_tributo)
{
    $valoresSeparadosPorComa = explode(',', $propietarios);
    sort($valoresSeparadosPorComa);
    $ids = implode("-", $valoresSeparadosPorComa); // Convierte en un string separado por guiones

    // Conexión a la base de datos
    $stmt = Conexion::conectar()->prepare("SELECT 
        Anio, 
        SUM(Importe) AS Total_Importe, 
        SUM(Gasto_Emision) AS Total_Gasto_Emision, 
        SUM(Saldo) AS Total_Saldo, 
        SUM(TIM) AS Total_TIM, 
        SUM(TIM_Descuento) AS Total_TIM_Descuento, 
        SUM(TIM_Aplicar) AS Total_TIM_Aplicar, 
        SUM(Total) AS Total_Pagado, 
        SUM(Descuento) AS Total_Descuento, 
        SUM(Total_Aplicar) AS Total_Aplicado 
    FROM estado_cuenta_corriente  
    WHERE Concatenado_idc = :ids 
    AND Id_Estado_Cuenta_Impuesto IN ($id_cuenta) 
    GROUP BY Anio 
    ORDER BY Anio;");

    $stmt->bindValue(":ids", $ids);

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = null; // Liberar la conexión

    return $result;
}



	public static function mdlEstadoCuenta_pdfc($propietarios, $id_cuenta, $condicion, $anio, $tipo_tributo)
	{
		$valoresSeparadosPorComa = explode(',', $propietarios);
		sort($valoresSeparadosPorComa);
		$ids = implode("-", $valoresSeparadosPorComa); // CONVIERTE EN UN STRING 
	
		if ($condicion == "pdf") {
			$stmt = Conexion::conectar()->prepare("SELECT e.Periodo as Periodo,
												   e.Importe as Importe,
												   e.Gasto_Emision as Gasto_Emision,
												   e.Saldo as Saldo,
												   e.Total_Aplicar as Total, 
												   v.Fecha_Vence Fecha_Vence 
												   from estado_cuenta_corriente e 
												   inner join cuotas_vencimiento_impuesto v on v.Periodo=e.Periodo  
												   INNER JOIN anio a ON a.Id_Anio=v.Id_Anio
												   where Concatenado_idc=:ids and Anio=$anio and Tipo_Tributo=$tipo_tributo 
												   and year(Fecha_Vence)=$anio
												   order by Tipo_Tributo, Anio, Codigo_Catastral, Periodo");
			$stmt->bindValue(":ids", $ids);
			$stmt->bindValue(":anio", $anio, PDO::PARAM_INT);
			$stmt->bindValue(":tipo_tributo", $tipo_tributo, PDO::PARAM_INT);
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT * from estado_cuenta_corriente  
												   where Concatenado_idc=:ids and Id_Estado_Cuenta_Impuesto in ($id_cuenta) 
												   order by Tipo_Tributo, Anio, Codigo_Catastral, Periodo");
			$stmt->bindValue(":ids", $ids);
		}
	
		$stmt->execute();
		$resultado = $stmt->fetchall(PDO::FETCH_ASSOC); // Trae los resultados como un array asociativo
	
		var_dump($resultado); // Muestra los valores en pantalla
		die(); // Detiene la ejecución para que puedas ver la salida en la consola
	
		return $resultado;
	}
	

	// Lista para estado de cuenta coactivo
// public static function mdlEstadoCuentaCA($valor, $condicion)
// {
//     $pdo = Conexion::conectar();
//     $where = '';
//     $ids = '';

//     if ($condicion === 'estadocuentaC') {
//         sort($valor);
//         $ids = implode("-", $valor); // Convierte a string
//     }

//     $stmt = $pdo->prepare(
//         "SELECT 
// 		Id_Estado_Cuenta_Impuesto,
// 		Estado,
//             Anio,
//             Tipo_Tributo,
//             SUM(Importe) AS Total_Importe,
//             SUM(Gasto_Emision) AS Total_Gasto_Emision,
//             SUM(Saldo) AS Total_Saldo,
//             SUM(TIM) AS Total_TIM,
//             SUM(TIM_Descuento) AS Total_TIM_Descuento,
//             SUM(TIM_Aplicar) AS Total_TIM_Aplicar,
//             SUM(Total) AS Total_Total,
//             SUM(Descuento) AS Total_Descuento,
//             SUM(Total_Aplicar) AS Total_Aplicar_Anual
//         FROM estado_cuenta_corriente  
//         WHERE Concatenado_idc = :ids AND Estado = 'D' $where
//         GROUP BY Anio, Tipo_Tributo
//         ORDER BY Anio, Tipo_Tributo;"
//     );

//     $stmt->bindParam(":ids", $ids);
//     $stmt->execute();
//     $campos = $stmt->fetchAll();
//     $filas_afectadas = $stmt->rowCount();

//     $content = "";
//     if ($filas_afectadas > 0) {
//         foreach ($campos as $value) {
//             $tributo = ($value['Tipo_Tributo'] === '006') ? 'Imp. Predial' : 'Arb. Municipal';

//             $content .= '<tr id="' . $value['Id_Estado_Cuenta_Impuesto'] . '">
//                 <td class="text-center">
//                     <input type="checkbox" class="fila-checkbox custom-checkbox" style="width:15px; height:15px; margin:0;" disabled ' 
//                     . ($value['Estado'] === '1' ? 'checked' : '') . '>
//                 </td>
//                 <td class="text-center">' . $value['Tipo_Tributo'] . '</td>
//                 <td class="text-center">' . $tributo . '</td>      
//                 <td class="text-center">' . $value['Anio'] . '</td>
//                 <td class="text-center">' . ($value['Periodo'] ?? '-') . '</td>
//                 <td class="text-center">' . ($value['Total_Importe'] ?? '0') . '</td>
//                 <td class="text-center">' . ($value['Total_Gasto_Emision'] ?? '0') . '</td>
//                 <td class="text-center">' . ($value['Total_Saldo'] ?? '0') . '</td>';

//             if ($condicion === 'estadocuentaC') {
//                 $content .= '<td class="text-center">' . ($value['Total_Descuento'] ?? '0') . '</td>';
//             }

//             $content .= '
//                 <td class="text-center">' . ($value['Total_TIM_Aplicar'] ?? '0') . '</td>
//                 <td class="text-center">' . ($value['Total_Aplicar_Anual'] ?? '0') . '</td>
//             </tr>';
//         }
//     } else {
//         $content .= '<tr id="noseleccionar"><td colspan="10" class="text-center">No Registra Deuda</td></tr>';
//     }

//     $pdo = null;
//     return $content;
// }



	

//lista para estado de cuenta coactivo


    // public static function mdlEstadoCuentaC($valor, $condicion)
    // {
    //     $pdo =  Conexion::conectar();
    //     if ($condicion == 'estadocuentaC') {
    //         $where='';
    //         sort($valor);
    //         $ids = implode("-", $valor); //CONVIERTE EN UN STRING
    //     } else {
    //         $where='AND Tipo_Tributo='.$valor['tipo_tributo'];
    //         $idArray = explode('-', $valor['id_propietarios']);
    //         // Elimina elementos vacíos (por ejemplo, si hay varios guiones juntos)
    //         $idArray = array_filter($idArray);
    //         sort($idArray);
    //         $ids = implode("-", $idArray);
    //     }
    //     $stmt = $pdo->prepare("SELECT * from estado_cuenta_corriente  
	// 	where Concatenado_idc=:ids  AND Estado='D' $where order by Tipo_Tributo,Anio,Fecha_Registro ");
    //     $stmt->bindParam(":ids", $ids);
    //     $stmt->execute();
    //     $campos = $stmt->fetchall();
    //     $content = "";
    //     $filas_afectadas = $stmt->rowCount();

    //     // Verificar si hay filas afectadas
    //     if ($filas_afectadas > 0) {
    //         foreach ($campos as $key => $value) {
    //             if ($value['Tipo_Tributo'] == '006') {
    //                 $tributo = 'Imp. Predial';
    //             } else {
    //                 $tributo = 'Arb. Municipal';
    //             }
    //             $content .= '<tr id="' . $value['Id_Estado_Cuenta_Impuesto'] . '">
	// 								 <td class="text-center">
    //     <input type="checkbox" class="fila-checkbox custom-checkbox" style="width:15px; height:15px; margin: 0;" disabled ' 
    //     . ($value['Estado'] == 1 ? 'checked' : '') . '>
    // </td>

	// 								<td class="text-center">' . $value['Tipo_Tributo'] . '</td>
	// 								<td class="text-center">' . $tributo . '</td>      
	// 								<td class="text-center">' . $value['Anio'] . '</td>
	// 								<td class="text-center">' . $value['Periodo'] . '</td>
	// 								<td class="text-center">' . $value['Importe'] . '</td>
	// 								<td class="text-center">' . $value['Gasto_Emision'] . '</td>
	// 								<td class="text-center">' . $value['Saldo'] . '</td>';
    //             if ($condicion == 'estadocuentaC') {
    //                 $content .='	<td class="text-center">' . $value['Descuento'] . '</td>';
    //             }
    //             $content .='	<td class="text-center">' . $value['TIM_Aplicar'] . '</td>
	// 								<td class="text-center">' . $value['Total_Aplicar'] . '</td>
	// 								</tr>';
    //         }
    //     }
    //     else{
    //         $content .= '<tr id="noseleccionar"><td colspan="10" class="text-center"> No Registra Deuda </td></tr>';
    //     }
    //     $content .=  "";

    //     return $content;
    //     $pdo = null;
    // }




	

    public static function mdlEstadoCuenta($valor, $condicion)
	{
		$pdo =  Conexion::conectar();
        //$where='';
		if ($condicion == 'estadocuenta') {
			$where='';
			sort($valor);
			$ids = implode("-", $valor); //CONVIERTE EN UN STRING
		} 
		else {
			$where='AND Tipo_Tributo='.$valor['tipo_tributo'];
			$idArray = explode('-', $valor['id_propietarios']);
			// Elimina elementos vacíos (por ejemplo, si hay varios guiones juntos)
			$idArray = array_filter($idArray);
			sort($idArray);
			$ids = implode("-", $idArray);
		}	
		$stmt = $pdo->prepare("SELECT * from estado_cuenta_corriente  
		where Concatenado_idc=:ids  AND Estado='D' $where order by Tipo_Tributo,Anio,Fecha_Registro ");

		$stmt->bindParam(":ids", $ids);
		$stmt->execute();
		$campos = $stmt->fetchall();
		$content = "";
		$filas_afectadas = $stmt->rowCount();

		// Verificar si hay filas afectadas
		if ($filas_afectadas > 0) {
				foreach ($campos as $key => $value) {
					if ($value['Tipo_Tributo'] == '006') {
						$tributo = 'Imp. Predial';
					} else {
						$tributo = 'Arb. Municipal';
					}
					$content .= '<tr id="' . $value['Id_Estado_Cuenta_Impuesto'] . '">
					                <td class="text-center">' . $value['Tipo_Tributo'] . '</td>
									<td class="text-center">' . $tributo . '</td>      
									<td class="text-center">' . $value['Anio'] . '</td>
									<td class="text-center">' . $value['Periodo'] . '</td>
									<td class="text-center">' . $value['Importe'] . '</td>
									<td class="text-center">' . $value['Gasto_Emision'] . '</td>
									<td class="text-center">' . $value['Saldo'] . '</td>';
									if ($condicion == 'estadocuenta') {
				$content .='	<td class="text-center">' . $value['Descuento'] . '</td>';
									}
								$content .='	<td class="text-center">' . $value['TIM_Aplicar'] . '</td>
									<td class="text-center">' . $value['Total_Aplicar'] . '</td>
									<td class="text-center"></td></tr>';
				}
	   }
	   else{
		$content .= '<tr id="noseleccionar"><td colspan="10" class="text-center"> No Registra Deuda </td></tr>';
	   }
		$content .=  "";

		return $content;
		$pdo = null;
	}

	

//ESTADO DE CUENTA ORDEN PRUEBA PERIODO
public static function mdlEstadoCuenta_Orden_periodo($datos)
{   
	$pdo =  Conexion::conectar();
		$idArray = explode(',', $datos['id_propietarios']);
		// Elimina elementos vacíos (por ejemplo, si hay varios guiones juntos)
		$idArray = array_filter($idArray);
		sort($idArray);
		$ids = implode("-", $idArray);
	$anio_actual=date('Y');

	$stmt = $pdo->prepare(
		"SELECT 
		Id_Estado_Cuenta_Impuesto,
		Estado,
            Anio,
            Tipo_Tributo,
			Periodo,
            Importe AS Total_Importe,
            Gasto_Emision AS Total_Gasto_Emision,
            Saldo AS Total_Saldo,
            TIM AS Total_TIM,
            TIM_Descuento AS Total_TIM_Descuento,
            TIM_Aplicar AS Total_TIM_Aplicar,
            Total AS Total_Total,
            Descuento AS Total_Descuento,
            Total_Aplicar AS Total_Aplicar_Anual
		 
		 FROM estado_cuenta_corriente  
        WHERE Concatenado_idc = :ids AND Estado = 'D' 
        order by Tipo_Tributo,Anio,Fecha_Registro ");

	// $stmt = $pdo->prepare(
	// 	"SELECT `Periodo`, `Importe`, `Gasto_Emision`, `Saldo`, `TIM`, `TIM_Descuento`, `TIM_Aplicar`, `Total`, `Estado` from estado_cuenta_corriente  
	// 					   where Concatenado_idc='1001'  AND Estado='D' AND Tipo_Tributo='006' and Anio>='2023' AND Anio!=$anio_actual
	// 					   order by Anio,Fecha_Registro,Periodo,Id_Predio,Tipo_Tributo,Total_Aplicar"
						   
						

	// 					);
		 $stmt->bindParam(":ids", $ids);
		// $stmt->bindParam(":tipo_tributo", $datos["tipo_tributo"]);
		// $stmt->bindParam(":anio", $datos["anio"]);
				$stmt->execute();
				$campos = $stmt->fetchall();

				$stmt = $pdo->prepare("SELECT 
				SUM(Importe) AS Total_Importe,
				SUM(Gasto_Emision) AS Total_Gasto_Emision,
				SUM(Saldo) AS Total_Saldo,
				SUM(TIM) AS Total_TIM,
				SUM(TIM_Descuento) AS Total_TIM_Descuento,
				SUM(TIM_Aplicar) AS Total_TIM_Aplicar,
				SUM(Total) AS Total_Total,
				SUM(Descuento) AS Total_Descuento,
				SUM(Total_Aplicar) AS Total_Aplicar_Anual
			FROM estado_cuenta_corriente  
			WHERE Concatenado_idc = :ids AND Estado = 'D';
			");
			$stmt->bindParam(":ids", $ids);
			// $stmt->bindParam(":tipo_tributo", $datos["tipo_tributo"]);
			// $stmt->bindParam(":anio", $datos["anio"]);
			$stmt->execute();
			$totales = $stmt->fetchall();



			$response = [
				'campos' => $campos,
				'totales' => $totales
			];
			return $response;
			$pdo = null;
}







//siguiente
public static function mdlEstadoCuenta_siguiente($datos)
{
    $pdo = Conexion::conectar();
    $inicio = (int)$datos['siguiente']; // ejemplo: 10001

    $inicioStr = strval($inicio);
    $inicioMin = $inicio + 1;
    $inicioMax = $inicio + 4;

    $stmt = $pdo->prepare("
        SELECT Concatenado_idc
        FROM estado_cuenta_corriente
        WHERE
            CONCAT(Concatenado_idc, '') COLLATE utf8mb4_unicode_ci LIKE CONCAT(:inicio_str, '-%')
            AND CAST(SUBSTRING_INDEX(Concatenado_idc, '-', -1) AS UNSIGNED)
                BETWEEN :inicio_min AND :inicio_max
        LIMIT 1
    ");

    $stmt->bindParam(':inicio_str', $inicioStr);
    $stmt->bindParam(':inicio_min', $inicioMin, PDO::PARAM_INT);
    $stmt->bindParam(':inicio_max', $inicioMax, PDO::PARAM_INT);
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $ids = $resultado['Concatenado_idc'];

        $stmtTotales = $pdo->prepare("
            SELECT 
                SUM(Importe) AS Total_Importe,
                SUM(Gasto_Emision) AS Total_Gasto_Emision,
                SUM(Saldo) AS Total_Saldo,
                SUM(TIM) AS Total_TIM,
                SUM(TIM_Descuento) AS Total_TIM_Descuento,
                SUM(TIM_Aplicar) AS Total_TIM_Aplicar,
                SUM(Total) AS Total_Total,
                SUM(Descuento) AS Total_Descuento,
                SUM(Total_Aplicar) AS Total_Aplicar_Anual
            FROM estado_cuenta_corriente  
            WHERE Concatenado_idc = :ids AND Estado = 'D';
        ");

        $stmtTotales->bindParam(':ids', $ids);
        $stmtTotales->execute();
        $totales = $stmtTotales->fetchAll(PDO::FETCH_ASSOC);

        $pdo = null;

        return [
            'concatenado' => $ids,
            'totales' => $totales
        ];
    } else {
        $pdo = null;
        return [
            'mensaje' => 'No se encontró un siguiente Concatenado_idc dentro del rango.'
        ];
    }
}


//ESTADO DE CUENTA ORDEN PRUEBA
public static function mdlEstadoCuenta_Orden_anio($datos)
{   
	$pdo =  Conexion::conectar();
		$idArray = explode(',', $datos['id_propietarios']);
		// Elimina elementos vacíos (por ejemplo, si hay varios guiones juntos)
		$idArray = array_filter($idArray);
		sort($idArray);
		$ids = implode("-", $idArray);
	$anio_actual=date('Y');

	$stmt = $pdo->prepare(  
		"   SELECT 
    Id_Estado_Cuenta_Impuesto,
    Estado,
    Anio,
    Tipo_Tributo,
    SUM(Importe) AS Total_Importe,
    SUM(Gasto_Emision) AS Total_Gasto_Emision,
    SUM(Saldo) AS Total_Saldo,
    SUM(TIM) AS Total_TIM,
    SUM(TIM_Descuento) AS Total_TIM_Descuento,
    SUM(TIM_Aplicar) AS Total_TIM_Aplicar,
    SUM(Total) AS Total_Total,
    SUM(Descuento) AS Total_Descuento,
    SUM(Total_Aplicar) AS Total_Aplicar_Anual
FROM 
    estado_cuenta_corriente  
WHERE 
    Concatenado_idc = :ids
    AND Estado = 'D' 
GROUP BY 
    Tipo_Tributo, Anio
HAVING 
    COUNT(DISTINCT Periodo) BETWEEN 1 AND 4
ORDER BY 
    Tipo_Tributo, Anio;



						   "
						   
						
						   
						);

	// $stmt = $pdo->prepare(
	// 	"SELECT `Periodo`, `Importe`, `Gasto_Emision`, `Saldo`, `TIM`, `TIM_Descuento`, `TIM_Aplicar`, `Total`, `Estado` from estado_cuenta_corriente  
	// 					   where Concatenado_idc='1001'  AND Estado='D' AND Tipo_Tributo='006' and Anio>='2023' AND Anio!=$anio_actual
	// 					   order by Anio,Fecha_Registro,Periodo,Id_Predio,Tipo_Tributo,Total_Aplicar"
						   
						

	// 					);
		 $stmt->bindParam(":ids", $ids);
		// $stmt->bindParam(":tipo_tributo", $datos["tipo_tributo"]);
		// $stmt->bindParam(":anio", $datos["anio"]);
				$stmt->execute();
				$campos = $stmt->fetchall();

				

				$stmt = $pdo->prepare("SELECT 
				SUM(Importe) AS Total_Importe,
				SUM(Gasto_Emision) AS Total_Gasto_Emision,
				SUM(Saldo) AS Total_Saldo,
				SUM(TIM) AS Total_TIM,
				SUM(TIM_Descuento) AS Total_TIM_Descuento,
				SUM(TIM_Aplicar) AS Total_TIM_Aplicar,
				SUM(Total) AS Total_Total,
				SUM(Descuento) AS Total_Descuento,
				SUM(Total_Aplicar) AS Total_Aplicar_Anual
			FROM estado_cuenta_corriente  
			WHERE Concatenado_idc = :ids AND Estado = 'D';
			");
						$stmt->bindParam(":ids", $ids);
			// $stmt->bindParam(":tipo_tributo", $datos["tipo_tributo"]);
			// $stmt->bindParam(":anio", $datos["anio"]);
			$stmt->execute();
			$totales = $stmt->fetchall();
			$response = [
				'campos' => $campos,
				'totales' => $totales
			];
			return $response;
			$pdo = null;
}


//HISTORIAL DE ORDEN DE PAGO
public static function mdlEstadoCuenta_Orden_historial($datos)
{   
    $pdo = Conexion::conectar();
    
    // Separar los valores de id_propietarios por el guion
    $idArray = explode('-', $datos['id_propietarios']);
    
    // Elimina elementos vacíos (en caso de tener comas adicionales o guiones vacíos)
    $idArray = array_filter($idArray);
    
    // Ordenar los ID de menor a mayor
    sort($idArray);
    
    // Crear una lista de marcadores de posición para la consulta
    $placeholders = implode(',', array_fill(0, count($idArray), '?'));
    
    // Preparar la consulta SQL usando IN
    $stmt = $pdo->prepare("SELECT 
                            op.Orden_Pago, 
                            op.Tipo_Tributo, 
                            op.Anio, 
                            op.Base_Imponible, 
                            op.Importe, 
                            op.Gastos, 
                            op.Subtotal, 
                            op.TIM, 
                            op.Total, 
                            op.Fecha_Registro, 
                            op.Numero_Orden, 
                            ocd.id, 
                            ocd.Concatenado_idc,
                            ocd.anio_actual
                        FROM 
                            orden_pago op
                        JOIN 
                            orden_pago_detalle ocd ON op.Orden_Pago = ocd.id_orden_Pago
                        WHERE 
                            ocd.Concatenado_idc IN ($placeholders)");
    
    // Vincular los parámetros
    foreach ($idArray as $index => $id) {
        $stmt->bindValue($index + 1, $id, PDO::PARAM_INT);
    }

    // Ejecutar la consulta
    $stmt->execute();
    
    // Obtener los resultados
    $totales = $stmt->fetchAll();
    
    // Preparar la respuesta
    $response = [
        'totales' => $totales
    ];
    
    // Retornar la respuesta
    return $response;

    // Cerrar la conexión
    $pdo = null;
}




	//ESTADO DE CUENTA ORDEN
	public static function mdlEstadoCuenta_Orden($datos)
	{   
		$pdo =  Conexion::conectar();
			$idArray = explode(',', $datos['id_propietarios']);
			// Elimina elementos vacíos (por ejemplo, si hay varios guiones juntos)
			$idArray = array_filter($idArray);
			sort($idArray);
			$ids = implode("-", $idArray);
		$anio_actual=date('Y');
		$stmt = $pdo->prepare("SELECT * from estado_cuenta_corriente  
		                       where Concatenado_idc=:ids  AND Estado='D' AND Tipo_Tributo=:tipo_tributo and Anio>=:anio AND Anio!=$anio_actual
		                       order by Anio,Fecha_Registro,Periodo,Id_Predio,Tipo_Tributo,Total_Aplicar");
		$stmt->bindParam(":ids", $ids);
		$stmt->bindParam(":tipo_tributo", $datos["tipo_tributo"]);
		$stmt->bindParam(":anio", $datos["anio"]);
		$stmt->execute();
		$campos = $stmt->fetchall();
		
	
				$stmt = $pdo->prepare("SELECT sum(Importe) as Importe,
											sum(Gasto_Emision) as Gasto_Emision,
											sum(Saldo) as Saldo,
											sum(TIM_Aplicar)as TIM_Aplicar,
											sum(Total_Aplicar) as Total_Aplicar from estado_cuenta_corriente  
									where Concatenado_idc=:ids  AND Estado='D' AND Tipo_Tributo=:tipo_tributo and Anio>=:anio AND Anio!=$anio_actual");
				$stmt->bindParam(":ids", $ids);
				$stmt->bindParam(":tipo_tributo", $datos["tipo_tributo"]);
				$stmt->bindParam(":anio", $datos["anio"]);
				$stmt->execute();
				$totales = $stmt->fetchall();
				$response = [
					'campos' => $campos,
					'totales' => $totales
				];
				return $response;
				$pdo = null;
	  
	}

	//AGERGADO PARA REGISTRARV ESTADO_CUNETA

	// public static function mdlEstadoCuenta_Orden_pdf($datos)
	// {
	// 	$pdo =  Conexion::conectar();
	// 		$idArray = explode(',', $datos['id_propietarios']);
	// 		// Elimina elementos vacíos (por ejemplo, si hay varios guiones juntos)
	// 		$idArray = array_filter($idArray);
	// 		sort($idArray);
	// 		$ids = implode("-", $idArray);
	// 	$anio_actual=date('Y');
	// 	$stmt = $pdo->prepare("SELECT Tipo_Tributo,Anio,Autovaluo,sum(Importe) as Importe,sum(Gasto_Emision) as Gasto_Emision, sum(Saldo) as Saldo,sum(TIM_Aplicar) AS TIM_Aplicar,
    //                            sum(Total_Aplicar) as Total_Aplicar from estado_cuenta_corriente  
	// 	                       where Concatenado_idc=:ids  AND Estado='D' AND Tipo_Tributo=:tipo_tributo and Anio>=:anio AND Anio!=$anio_actual
	// 	                       GROUP BY Tipo_Tributo,Anio,Autovaluo;");
	// 	$stmt->bindParam(":ids", $ids, PDO::PARAM_STR);
	// 	$stmt->bindParam(":tipo_tributo", $datos["tipo_tributo"]);
	// 	$stmt->bindParam(":anio", $datos["anio"]);
	// 	$stmt->execute();
	// 	$campos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     $campos_insert=$campos;
	// 	// Obtener el último valor de Numero_Orden
	// 		$query = $pdo->query("SELECT MAX(Numero_Orden) AS max_orden FROM orden_pago");
	// 		$result = $query->fetch(PDO::FETCH_ASSOC);
	// 		$ultimo_orden = $result['max_orden'] ? $result['max_orden'] : 0;

	// 		// Incrementar el número de orden
	// 		$nuevo_orden = $ultimo_orden + 1;
			

			
	// 		// Preparar la consulta de inserción
	// 		$insert_stmt = $pdo->prepare("INSERT INTO orden_pago 
	// 									(Tipo_Tributo, Anio, Base_Imponible, Importe, Gastos, Subtotal, TIM, Total, Numero_Orden) 
	// 									VALUES (:Tipo_Tributo, :Anio, :Base_Imponible, :Importe, :Gastos, :Subtotal, :TIM, :Total, :Numero_Orden)");




	// 		// Iterar sobre los resultados de la consulta y realizar las inserciones
	// 		foreach ($campos_insert as $fila) {
	// 			$insert_stmt->bindParam(':Tipo_Tributo', $fila['Tipo_Tributo']);
	// 			$insert_stmt->bindParam(':Anio', $fila['Anio']);
	// 			$insert_stmt->bindParam(':Base_Imponible', $fila['Autovaluo']);
	// 			$insert_stmt->bindParam(':Importe', $fila['Importe']);
	// 			$insert_stmt->bindParam(':Gastos', $fila['Gasto_Emision']);
	// 			$insert_stmt->bindParam(':Subtotal', $fila['Saldo']);
	// 			$insert_stmt->bindParam(':TIM', $fila['TIM_Aplicar']);
	// 			$insert_stmt->bindParam(':Total', $fila['Total_Aplicar']);
	// 			$insert_stmt->bindParam(':Numero_Orden', $nuevo_orden);
	// 			$insert_stmt->execute();
	// 		}

	// 		$resultado = [
	// 			'campos' => $campos,
	// 			'nuevo_orden' => $nuevo_orden
	// 		];
    //    return $resultado;			
	// 	$pdo = null;
	  
	// }



    

//ORDEN DE PAGO HISTORIAL

public static function mdlEstadoCuenta_Orden_pdf_historial($datosH)
{
    $pdo = Conexion::conectar();
    
    // Preparar el array de IDs de propietarios
    $idArray = explode(',', $datosH['id_propietarios']);
    $idArray = array_filter($idArray); // Eliminar elementos vacíos
    sort($idArray);

    // Crear un array de parámetros para usar en la consulta
    $params = [];
    foreach ($idArray as $index => $id) {
        $params[':id' . $index] = $id;
    }
    
    // Crear la consulta SQL con parámetros nombrados
    $placeholders = implode(",", array_keys($params));  // Usar los nombres de los parámetros
    $stmt = $pdo->prepare("SELECT 
                            op.Orden_Pago, 
                            op.Tipo_Tributo, 
                            op.Anio, 
                            op.Base_Imponible, 
                            op.Importe, 
                            op.Gastos, 
                            op.Subtotal, 
                            op.TIM, 
                            op.Total, 
                            op.Fecha_Registro, 
                            op.Numero_Orden, 
                            ocd.id, 
                            ocd.Concatenado_idc
                        FROM 
                            orden_pago op
                        JOIN 
                            orden_pago_detalle ocd ON op.Orden_Pago = ocd.id_orden_Pago
                        WHERE 
                            ocd.Concatenado_idc IN ($placeholders) 
                            AND op.Numero_Orden = :numero_orden
                            ORDER BY op.Anio ASC; 
                            ");
    
    // Vincular los parámetros
    foreach ($params as $param => $value) {
        $stmt->bindValue($param, $value, PDO::PARAM_INT);  // Vincular cada parámetro nombrado
    }
    
    $stmt->bindParam(":numero_orden", $datosH["numero_orden"], PDO::PARAM_INT);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Obtener los resultados de la consulta
    $campos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($campos)) {
        return ['error' => 'No se encontraron registros para el tipo de tributo y año proporcionado.'];
    }

    // Calcular las sumas
    $totalImporte = 0;
    $totalGastos = 0;
    $totalSubtotal = 0;
    $totalTIM = 0;
    $totalTotal = 0;

    foreach ($campos as $campo) {
        $totalImporte += $campo['Importe'];
        $totalGastos += $campo['Gastos'];
        $totalSubtotal += $campo['Subtotal'];
        $totalTIM += $campo['TIM'];
        $totalTotal += $campo['Total'];
    }

    // Agregar las sumas y los campos al resultado
    $resultado = [
        'campos' => $campos,
        'suma_importe' => $totalImporte,
        'suma_gastos' => $totalGastos,
        'suma_subtotal' => $totalSubtotal,
        'suma_tim' => $totalTIM,
        'suma_total' => $totalTotal
    ];
    

    // Devolver los resultados
    return $resultado;
    
    $pdo = null;
}
















	public static function mdlEstadoCuenta_Orden_pdf($datos)
{
    $pdo = Conexion::conectar();
    
    // Preparar el array de IDs de propietarios
    $idArray = explode(',', $datos['id_propietarios']);
    $idArray = array_filter($idArray); // Eliminar elementos vacíos
    sort($idArray);
    $ids = implode("-", $idArray);
    
    $anio_actual = date('Y');
    
    // Consulta para obtener los datos necesarios
    $stmt = $pdo->prepare("SELECT Tipo_Tributo, Anio, Autovaluo,
                                      sum(Importe) as Importe,
                                      sum(Gasto_Emision) as Gasto_Emision, 
                                      sum(Saldo) as Saldo,
                                      sum(TIM_Aplicar) AS TIM_Aplicar, 
                                      sum(Total_Aplicar) as Total_Aplicar 
                               FROM estado_cuenta_corriente 
                               WHERE Concatenado_idc = :ids 
                                 AND Estado = 'D' 
                                 AND Tipo_Tributo = :tipo_tributo 
                                 AND Anio >= :anio 
                                 AND Anio != :anio_actual
                               GROUP BY Tipo_Tributo, Anio, Autovaluo");
    
    // Bind de parámetros
    $stmt->bindParam(":ids", $ids, PDO::PARAM_STR);
    $stmt->bindParam(":tipo_tributo", $datos["tipo_tributo"]);
    $stmt->bindParam(":anio", $datos["anio"]);
    $stmt->bindParam(":anio_actual", $anio_actual, PDO::PARAM_INT);
    $stmt->execute();
    
    // Obtener los resultados de la consulta
    $campos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($campos)) {
        return ['error' => 'No se encontraron registros para el tipo de tributo y año proporcionado.'];
    }
    
    // Obtener el último valor de Numero_Orden
   // $query = $pdo->query("SELECT MAX(Numero_Orden) AS max_orden FROM orden_pago");


   $query = $pdo->prepare("
    SELECT 
        MAX(op.Numero_Orden) AS max_orden,
        ocd.anio_actual
    FROM 
        orden_pago op
    LEFT JOIN 
        orden_pago_detalle ocd ON op.Orden_Pago = ocd.id_orden_Pago
    WHERE 
        ocd.anio_actual = :anio_actual
");
// Bind del parámetro para usar el valor de $anio_actual
$query->bindParam(':anio_actual', $anio_actual, PDO::PARAM_INT);

// Ejecutar la consulta
$query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);
    
    $ultimo_orden = $result['max_orden'] ? $result['max_orden'] : 0;

    $anio_actual_sistema = $result['anio_actual'];
    // Condición para verificar si el año actual del sistema es igual al año actual
   
    // Condición para verificar si el año actual del sistema es 2025
    if ($anio_actual_sistema === $anio_actual ) {
        // Si el año del sistema coincide con el registrado en la base de datos, incrementamos el último número de orden
        if ($ultimo_orden != 0) {
            $nuevo_orden = str_pad($ultimo_orden + 1, 3, '0', STR_PAD_LEFT);
            
        } else {
            // Si no existe un número de orden, iniciamos con 001
            $nuevo_orden = '001';
        }
    } else {
        // Si el año no es 2025 ni el año actual del sistema, podemos reiniciar el número de orden a 001 o manejarlo como desees
        $nuevo_orden = '001';
    }


  //  $nuevo_orden = $ultimo_orden + 1;

   // Calcular el nuevo orden
  
    // Preparar la consulta de inserción en orden_pago
    $insert_stmt = $pdo->prepare("INSERT INTO orden_pago 
                                  (Tipo_Tributo, Anio, Base_Imponible, Importe, Gastos, Subtotal, TIM, Total, Numero_Orden) 
                                  VALUES (:Tipo_Tributo, :Anio, :Base_Imponible, :Importe, :Gastos, :Subtotal, :TIM, :Total, :Numero_Orden)");

    // Insertar en la tabla orden_pago y obtener el id_orden_Pago generado
    foreach ($campos as $fila) {
        $insert_stmt->bindParam(':Tipo_Tributo', $fila['Tipo_Tributo']);
        $insert_stmt->bindParam(':Anio', $fila['Anio']);
        $insert_stmt->bindParam(':Base_Imponible', $fila['Autovaluo']);
        $insert_stmt->bindParam(':Importe', $fila['Importe']);
        $insert_stmt->bindParam(':Gastos', $fila['Gasto_Emision']);
        $insert_stmt->bindParam(':Subtotal', $fila['Saldo']);
        $insert_stmt->bindParam(':TIM', $fila['TIM_Aplicar']);
        $insert_stmt->bindParam(':Total', $fila['Total_Aplicar']);
        $insert_stmt->bindParam(':Numero_Orden', $nuevo_orden);
        $insert_stmt->execute();
    }

    // Obtener el id_orden_Pago recién insertado
   // $id_orden_Pago = $pdo->lastInsertId();  // Obtiene el id de la última fila insertada en orden_pago

      // Obtener todos los id_orden_Pago generados
	  $query_all_ids = $pdo->query("SELECT Orden_Pago FROM orden_pago ORDER BY Orden_Pago DESC LIMIT " . count($campos));
	  $id_orden_Pagos = $query_all_ids->fetchAll(PDO::FETCH_ASSOC);
  
	  // Ahora, insertamos en la tabla orden_cuenta_detalle con cada id_orden_Pago generado
	  $concatenado_idc = $ids;  // Este es el valor único de Concatenado_idc
  

    // Insertar en la tabla orden_cuenta_detalle con el id_orden_Pago recién insertado
    $insert_intermedia_stmt = $pdo->prepare("INSERT INTO orden_pago_detalle 
                                            (id_orden_Pago, Concatenado_idc,anio_actual) 
                                            VALUES (:id_orden_Pago, :Concatenado_idc,:anio_actual)");
    
	// Insertar un registro por cada id_orden_Pago
    foreach ($id_orden_Pagos as $id_orden) {
        // Usamos cada id_orden_Pago obtenido de la consulta
        $insert_intermedia_stmt->bindValue(':id_orden_Pago', $id_orden['Orden_Pago']);
        $insert_intermedia_stmt->bindValue(':Concatenado_idc', $concatenado_idc);  // El mismo Concatenado_idc para todos
        $insert_intermedia_stmt->bindValue(':anio_actual', $anio_actual);  // El mismo Concatenado_idc para todos

        // Ejecutar la inserción en orden_cuenta_detalle
        $insert_intermedia_stmt->execute();
    }
	
		
    // Ejecutar la inserción en orden_cuenta_detalle
 //   $insert_intermedia_stmt->execute();
    
    // Resultado final con el nuevo orden y los campos procesados
    $resultado = [
        'campos' => $campos,
        'nuevo_orden' => $nuevo_orden
    ];

    return $resultado;
    
    $pdo = null;
}






	public static function mdlEstadoCuenta_Pagado($valor, $condicion)
{
    try {
        $pdo = Conexion::conectar();
        
        $where = '';
        $ids = '';

        // Construir parámetros según la condición
        if ($condicion == 'estadocuenta') {
            sort($valor);
            $ids = implode("-", $valor); // Convertir el array en un string separado por guiones
        } else {
            $where = 'AND Tipo_Tributo = :tipo_tributo';
            $idArray = array_filter(explode('-', $valor['id_propietarios'])); // Eliminar elementos vacíos
            sort($idArray);
            $ids = implode("-", $idArray);
        }

        // Consulta con UNION ALL
        $query = "
            SELECT 
			    Estado,
                Id_Ingresos_Tributos,
				Codigo_Catastral ,
                Tipo_Tributo,
                Anio,
                Periodo,
                Fecha_Pago,
                Importe,
                Gasto_Emision,
                Saldo,
                TIM,
                Total_Pagar,
				cierre
            FROM ingresos_tributos 
            WHERE Concatenado_idc = :ids AND Estado = 'P' $where

            UNION ALL

            SELECT 
			    Estado,
                Id_Estado_Cuenta_Impuesto ,
				Codigo_Catastral ,
                Tipo_Tributo,
                Anio,
                Periodo,
                Fecha_Registro,
                Importe,
                Gasto_Emision,
                Saldo,
                TIM,
                Total_Aplicar,
				NULL AS cierre
            FROM estado_cuenta_corriente
            WHERE Concatenado_idc = :ids AND Estado = 'E'
            
            ORDER BY Tipo_Tributo, Anio, Codigo_Catastral, Periodo
        ";

        // Preparar la consulta
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":ids", $ids);

        // Agregar parámetro adicional si aplica
        if ($condicion != 'estadocuenta') {
            $stmt->bindParam(":tipo_tributo", $valor['tipo_tributo']);
        }

        // Ejecutar la consulta
        $stmt->execute();
        $campos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Construir contenido HTML
        if (count($campos) > 0) {
            $content = array_reduce($campos, function ($html, $value) {
                $tributo = ($value['Tipo_Tributo'] == '006') ? 'Imp. Predial' : 'Arb. Municipal';

				$html .= '<tr id="' . $value['Id_Ingresos_Tributos'] . '"';
				if ($value['Estado'] == 'E') {
					$html .= ' class="color_prescripcion"';
				}
				if ($value['cierre'] == 0) {
					$html .= ' class="color_coactivo"';
				}
				$html .='><td class="text-center">' . htmlspecialchars($value['Tipo_Tributo']) . '</td>
                              <td class="text-center">' . htmlspecialchars($tributo) . '</td>
                              <td class="text-center">' . htmlspecialchars($value['Anio']) . '</td>
                              <td class="text-center">' . htmlspecialchars($value['Periodo']) . '</td>
                              <td class="text-center">' . htmlspecialchars($value['Fecha_Pago']) . '</td>';

                 if($value['Estado']=='E'){
                     $html.='<td class="text-center">Prescrito</td>';
				 }
				 
				 else{
					$html.='<td class="text-center">Pagado</td>';
				 }
               
                         $html.='<td class="text-center">' . number_format($value['Importe'], 2) . '</td>
                              <td class="text-center">' . number_format($value['Gasto_Emision'], 2) . '</td>
                              <td class="text-center">' . number_format($value['Saldo'], 2) . '</td>
                              <td class="text-center">' . number_format($value['TIM'], 2) . '</td>
                              <td class="text-center">' . number_format($value['Total_Pagar'], 2) . '</td>
                              <td class="text-center"></td>
                          </tr>';
                return $html;
            }, '');
        } else {
            $content = '<tr id="noseleccionar"><td colspan="12" class="text-center"> No Registra Deuda </td></tr>';
        }

        return $content;
    } catch (Exception $e) {
        // Manejo de errores
        return '<tr><td colspan="12" class="text-center">Error: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
    } finally {
        // Liberar conexión
        $pdo = null;
    }
}

	public static function mdlEstadoCuenta_pdf($propietarios, $id_cuenta, $condicion, $anio, $tipo_tributo)
	{
		$valoresSeparadosPorComa = explode(',', $propietarios);
		sort($valoresSeparadosPorComa);
		$ids = implode("-", $valoresSeparadosPorComa); //CONVIERTE EN UN STRING 
		if ($condicion == "pdf") {
			$stmt = Conexion::conectar()->prepare("SELECT e.Periodo as Periodo,
			                                       e.Importe as Importe,
												   e.Gasto_Emision as Gasto_Emision,
												   e.Saldo as Saldo,
												   e.Total_Aplicar as Total, 
												   v.Fecha_Vence Fecha_Vence 
												   from estado_cuenta_corriente e 
												   inner join cuotas_vencimiento_impuesto v on v.Periodo=e.Periodo  
												   INNER JOIN anio a ON a.Id_Anio=v.Id_Anio
												   where Concatenado_idc=:ids and Anio=$anio and Tipo_Tributo=$tipo_tributo 
												   and year(Fecha_Vence)=$anio
												   order by Tipo_Tributo,Anio,Codigo_Catastral,Periodo");
			$stmt->bindValue(":ids", $ids);
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT * from estado_cuenta_corriente  
			where Concatenado_idc=:ids and  Id_Estado_Cuenta_Impuesto in ($id_cuenta) 
			order by Tipo_Tributo,Anio,Codigo_Catastral,Periodo");
			$stmt->bindValue(":ids", $ids);
		}
		$stmt->execute();
		return $stmt->fetchall();
		$stmt = null;
	}

    
	public static function mdlEstadoCuenta_pagados_pdf($propietarios, $id_cuenta)
	{
		$valoresSeparadosPorComa = explode(',', $propietarios);
		sort($valoresSeparadosPorComa);
		$ids = implode("-", $valoresSeparadosPorComa); //CONVIERTE EN UN STRING 
		
			$stmt = Conexion::conectar()->prepare("SELECT 
												e.Tipo_Tributo as tributo,
												e.Anio as anio,
											e.Codigo_Catastral as codigo_catastral,
												e.Periodo as periodo,
												e.Fecha_Pago as fecha_pago,
												e.Importe as importe,
												e.Gasto_Emision as gasto,
												e.Total as subtotal,
												e.TIM as tim,
												e.Total_Pagar as total,
												e.Estado as estado

											FROM ingresos_tributos e
											WHERE Concatenado_idc = :ids
											AND e.Id_Ingresos_Tributos IN ($id_cuenta) 
											AND e.Estado = 'P' 
											AND e.Cierre = 1

											UNION ALL

											SELECT 
												ecc.Tipo_Tributo as tributo,
												ecc.Anio as anio,
												ecc.Codigo_Catastral as codigo_catastral,
												ecc.Periodo as periodo,
												ecc.Fecha_Registro as fecha_pago,
												ecc.Importe as importe,
												ecc.Gasto_Emision as gasto,
												ecc.Total as subtotal,
												ecc.TIM as tim,
												ecc.Total_Aplicar as total,
												ecc.Estado as estado
											FROM estado_cuenta_corriente ecc
											WHERE Concatenado_idc =:ids 
											AND ecc.Id_Estado_Cuenta_Impuesto IN ($id_cuenta) 
											AND ecc.Estado = 'E'

											ORDER BY tributo, anio, codigo_catastral, periodo;  ");
			$stmt->bindValue(":ids", $ids);
		$stmt->execute();
		return $stmt->fetchall();
		$stmt = null;
	}

	public static function mdlEstadoCuenta_Total($propietarios, $anio, $tipo_tributo)
{
    $valoresSeparadosPorComa = explode(',', $propietarios);
    sort($valoresSeparadosPorComa);
    $ids = implode("-", $valoresSeparadosPorComa); //CONVIERTE EN UN STRING 

    $conexion = Conexion::conectar();
    $stmt = $conexion->prepare("SELECT sum(Importe) as importe,
                                       sum(Gasto_Emision) as gasto_emision,
                                       sum(Saldo) as saldo ,
                                       sum(Total_Aplicar) as total_aplicar
                                  FROM estado_cuenta_corriente  
                                 WHERE Concatenado_idc = :ids 
                                   AND Anio = :anio 
                                   AND Tipo_Tributo = :tipo_tributo 
                              ORDER BY Tipo_Tributo, Anio, Codigo_Catastral, Periodo");

    $stmt->bindValue(':ids', $ids);
    $stmt->bindValue(':anio', $anio, PDO::PARAM_INT);
    $stmt->bindValue(':tipo_tributo', $tipo_tributo, PDO::PARAM_INT);

    $stmt->execute();
    $resultado = $stmt->fetchAll();
    
    $stmt = null;
    $conexion = null;

    return $resultado;
}

/*public static function mdlPropietarios_pdf($propietarios)
{
    // Convertir la cadena de propietarios en un array
   // $valoresSeparadosPorComa = explode(',', $propietarios);
    // Ordenar los valores
    $ids=sort($valoresSeparadosPorComa);

    // Inicializar la variable de la cláusula WHERE
        if (count($valoresSeparadosPorComa) == 1) {
            // Si hay solo un valor, usar operador de igualdad
			$conexion = Conexion::conectar();
			$stmt = $conexion->prepare( "SELECT  
            c.Estado as Estado,
            c.Id_Contribuyente as id_contribuyente,
            td.descripcion as tipo_documento,
            c.Documento as documento,
            c.Direccion_completo as direccion_completo,
            c.Nombre_Completo as nombre_completo
            FROM contribuyente c 
            INNER JOIN tipo_documento_siat td ON td.Id_Tipo_Documento=c.Id_Tipo_Documento 
			where 
            c.Id_contribuyente=:id");
			$stmt->bindValue(':ids', $valoresSeparadosPorComa[0]);
        } else {
            // Si hay más de un valor, usar cláusula IN
			$valoresSeparadosPorComa = explode(',', $ids);
             // Si hay solo un valor, usar operador de igualdad
			$conexion = Conexion::conectar();
			$stmt = $conexion->prepare( "SELECT  
            c.Estado as Estado,
            c.Id_Contribuyente as id_contribuyente,
            td.descripcion as tipo_documento,
            c.Documento as documento,
            c.Direccion_completo as direccion_completo,
            c.Nombre_Completo as nombre_completo
            FROM contribuyente c 
            INNER JOIN tipo_documento_siat td ON td.Id_Tipo_Documento=c.Id_Tipo_Documento 
			where 
            c.Id_contribuyente in $valoresSeparadosPorComa");
			//$stmt->bindValue(':ids', $valoresSeparadosPorComa[0]);
        }
    $stmt->execute();

    // Obtener resultados como un arreglo asociativo
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $resultados;
}*/


public static function mdlPropietarios_pdf($propietarios) //optimizado
{
    // Convertir la cadena de propietarios en un array
    $valoresSeparadosPorComa = explode(',', $propietarios);
    // Ordenar los valores
    sort($valoresSeparadosPorComa);
    
    // Crear una cadena de parámetros para la cláusula IN (:val1, :val2, ...)
    $inClause = implode(', ', array_fill(0, count($valoresSeparadosPorComa), '?'));

    // Preparar la consulta con la cláusula IN
    $stmt = Conexion::conectar()->prepare("SELECT  
                                           c.Estado as Estado,
                                           c.Id_Contribuyente as id_contribuyente,
                                           td.descripcion as tipo_documento,
                                           c.Documento as documento,
                                           c.Direccion_completo as direccion_completo,
                                           c.Nombre_Completo as nombre_completo
                                           FROM contribuyente c 
                                           INNER JOIN tipo_documento_siat td ON td.Id_Tipo_Documento=c.Id_Tipo_Documento 
                                           WHERE C.Id_Contribuyente IN ($inClause)");
    
    // Asignar los valores de los parámetros
    foreach ($valoresSeparadosPorComa as $key => $valor) {
        $stmt->bindValue(($key + 1), $valor); // Los índices de los parámetros comienzan en 1
    }

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados y organizarlos en un array asociativo
    $resultados = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $resultados[$row['id_contribuyente']][] = $row;
    }

    return $resultados;
}



	public static function mdlPropietario_licencia_pdf($idlicencia)
	{
		
		
			$stmt = Conexion::conectar()->prepare("SELECT  la.*,c.Id_Contribuyente as id_contribuyente,
			                                               c.Documento as documento,
														   c.Nombre_Completo as nombre_completo,
														   la.Numero_Licencia as numero_licencia,
														   t.Codigo as tipo_via,
														   c.Direccion_Completo as direccion_completo,
															nv.Nombre_Via as nombre_calle,
															m.NumeroManzana as numManzana,
															cu.Numero_Cuadra as cuadra,
															z.Nombre_Zona as zona,
															h.Habilitacion_Urbana as habilitacion,
                                                             CONCAT(t.Codigo, ' ', nv.Nombre_Via, ' N°', la.Numero_Ubicacion, ' Mz.', m.NumeroManzana, ' Lt.', la.Lote, ' Nlz.', la.Numero_Ubicacion, ' Cdr.', cu.Numero_Cuadra, '-', z.Nombre_Zona, '-', h.Habilitacion_Urbana) AS direccion_predio
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
													where la.Id_Licencia_Agua =$idlicencia limit 1");
			//$stmt->bindParam(":Id_Licencia", $idlicencia);
			$stmt->execute();
			// Obtener los resultados y agregarlos al array de resultados
            //AFECTO
            // 




			return $stmt->fetch();
		    $stmt = null;
	}
    // Muestra el estado de Agua
	public static function mdlEstadoCuenta_agua($idlicenciaagua)
	{
		$pdo =  Conexion::conectar();
		$stmt = $pdo->prepare("SELECT * from estado_cuenta_agua   
		where Id_Licencia_Agua =$idlicenciaagua AND Estado='D'");
		$stmt->execute();
		return  $stmt->fetchall();
		
	}
	 // Muestra el estado pagados de Agua
	 public static function mdlEstadoCuenta_agua_pagados($idlicenciaagua)
	 {
		 $pdo =  Conexion::conectar();
		 $stmt = $pdo->prepare("SELECT * from ingresos_agua  
		 where Id_Licencia_Agua =$idlicenciaagua AND Estado='P'");
		 $stmt->execute();
		 return  $stmt->fetchall();
		 
	 }
     
     //DIRECCION DE PREDIO PARA PAGO DE AGUA

     	public static function mdlEstadoCuenta_agua_pdf_direccion_predio($idlicencia, $id_cuenta)
	{
		$pdo =  Conexion::conectar();
		$stmt = $pdo->prepare("SELECT ec.*,t.Codigo as tipo_via,
                                                      nv.Nombre_Via as nombre_calle,
                                                      m.NumeroManzana as numManzana,
                                                      cu.Numero_Cuadra as cuadra,
                                                      z.Nombre_Zona as zona,
                                                      h.Habilitacion_Urbana as habilitacion,
                                                      u.Id_Ubica_Vias_Urbano as id
                                                      
                                                      FROM estado_cuenta_agua ec 
                                INNER JOIN licencia_agua l  on l.Id_Licencia_Agua =ec.Id_Licencia_Agua
                                inner join categoria_agua ca  on ca.Id_Categoria_Agua =l.Id_Categoria_Agua
                                INNER JOIN ubica_via_urbano u ON u.Id_Ubica_Vias_Urbano = l.Id_Ubica_Vias_Urbano  
                                INNER JOIN direccion d ON u.Id_Direccion = d.Id_Direccion 
                                INNER JOIN tipo_via t ON t.Id_Tipo_Via = d.Id_Tipo_Via 
                                INNER JOIN zona z ON u.Id_Zona = z.Id_Zona
                                INNER JOIN manzana m ON u.Id_Manzana = m.Id_Manzana 
                                INNER JOIN cuadra cu ON cu.Id_cuadra = u.Id_Cuadra 
                                INNER JOIN habilitaciones_urbanas h ON h.Id_Habilitacion_Urbana = z.Id_Habilitacion_Urbana 
                                INNER JOIN nombre_via nv ON nv.Id_Nombre_Via = d.Id_Nombre_Via  
                                              
                                                WHERE l.Id_Licencia_Agua =$idlicencia and ec.Estado='H' and Id_Estado_Cuenta_Agua in ($id_cuenta) ORDER BY ec.Anio");
       // Ejecutamos la consulta
        $stmt->execute();
        
      //  Volcar el resultado para ver qué datos estamos obteniendo
        $result = $stmt->fetchAll();
        
        
     //   Mostrar el volcado
       // var_dump($result);

        return $result;
	 }



	public static function mdlEstadoCuenta_agua_pdf($idlicencia, $id_cuenta)
	{
		$pdo =  Conexion::conectar();
		$stmt = $pdo->prepare("SELECT * from estado_cuenta_agua  
		where Id_Licencia_Agua =$idlicencia AND Estado='H' AND Id_Estado_Cuenta_Agua in ($id_cuenta) ORDER BY Anio");
		$stmt->execute();
        
		return  $stmt->fetchall();
	}

//  public static function mdlEstadoCuenta_agua_pdf($idlicencia, $id_cuenta)
// {
//     $pdo = Conexion::conectar();
//     $stmt = $pdo->prepare("SELECT * from estado_cuenta_agua  
//     where Id_Licencia_Agua = :idlicencia AND Estado = 'H' AND Id_Estado_Cuenta_Agua in ($id_cuenta) ORDER BY Anio");
    
//     // Vinculamos el parámetro para evitar inyecciones SQL
//     $stmt->bindParam(':idlicencia', $idlicencia, PDO::PARAM_INT);
    
//     // Ejecutamos la consulta
//     $stmt->execute();
    
//     // Volcar el resultado para ver qué datos estamos obteniendo
//     $result = $stmt->fetchAll();
    
//     // Mostrar el volcado
//     var_dump($result);
    
//     return $result;
// }







	public static function mdlEstadoCuenta_agua_pdf_consulta($idlicencia, $id_cuenta)
	{
		//$valoresSeparadosPorComa = explode(',', $propietarios);
		//sort($valoresSeparadosPorComa);
		//$ids = implode("-", $valoresSeparadosPorComa); //CONVIERTE EN UN STRING 
		$pdo =  Conexion::conectar();
		$stmt = $pdo->prepare("SELECT * from estado_cuenta_agua  
		where Id_Licencia_Agua =$idlicencia AND Estado='D' AND Id_Estado_Cuenta_Agua in ($id_cuenta) ORDER BY Anio");
		$stmt->execute();
		return  $stmt->fetchall();
	}
	public static function mdlEstadoCuenta_agua_pdf_consulta_pagados($idlicencia, $id_cuenta)
	{
		//$valoresSeparadosPorComa = explode(',', $propietarios);
		//sort($valoresSeparadosPorComa);
		//$ids = implode("-", $valoresSeparadosPorComa); //CONVIERTE EN UN STRING 
		$pdo =  Conexion::conectar();
		$stmt = $pdo->prepare("SELECT * from ingresos_agua  
		where Id_Licencia_Agua =$idlicencia AND Estado='P' AND Id_Estado_Cuenta_Agua in ($id_cuenta) ORDER BY Anio,Periodo");
		$stmt->execute();
		return  $stmt->fetchall();
	}

	public static function mdlDeudasPrescritas($valor)
	{
		$pdo =  Conexion::conectar();
		sort($valor);
		$ids = implode("-", $valor);
		$stmt = $pdo->prepare("SELECT * from estado_cuenta_corriente  
		where Concatenado_idc=:ids  AND Estado='E'  order by Tipo_Tributo,Anio,Fecha_Registro ");
		$stmt->bindParam(":ids", $ids);
		$stmt->execute();
		$campos = $stmt->fetchall();
		$content = "";
		$filas_afectadas = $stmt->rowCount();
		if ($filas_afectadas > 0) {
				foreach ($campos as $key => $value) {
					if ($value['Tipo_Tributo'] == '006') {
						$tributo = 'Imp. Predial';
					} else {
						$tributo = 'Arb. Municipal';
					}
					$content .= '<tr id="' . $value['Id_Estado_Cuenta_Impuesto'] . '">
					                <td class="text-center">' . $value['Tipo_Tributo'] . '</td>
									<td class="text-center">' . $tributo . '</td>      
									<td class="text-center">' . $value['Anio'] . '</td>
									<td class="text-center">' . $value['Periodo'] . '</td>
									<td class="text-center">' . $value['Importe'] . '</td>
									<td class="text-center">' . $value['Gasto_Emision'] . '</td>
									<td class="text-center">' . $value['Saldo'] . '</td>';
								$content .='	<td class="text-center">' . $value['Descuento'] . '</td>';
								$content .='	<td class="text-center">' . $value['TIM_Aplicar'] . '</td>
									<td class="text-center">' . $value['Total_Aplicar'] . '</td>
									<td class="text-center"></td></tr>';
				}
	   }
	   else{
		$content .= '<tr id="noseleccionar"><td colspan="10" class="text-center"> No Registra Prescripcion </td></tr>';
	   }
		$content .=  "";

		return $content;
		$pdo = null;
	}
}
