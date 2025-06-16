<?php

namespace Controladores;

use Modelos\ModeloReporte;
use Conect\Conexion;
use PDO;


class ControladorReporte
{

	// Muestra los ingresos de tributos y agua antes de cerrar caja
	public static function ctrMostrar_ingresos_tributosagua($fecha)
	{
		$respuesta = ModeloReporte::mdlMostrar_ingresos_tributosagua($fecha);
		$año = substr($fecha, 0, 4);
		$mes = substr($fecha, 5, 2);
		$dia = substr($fecha, 8, 2);
		if ($respuesta) {
			foreach ($respuesta as $cuadre_ta) {
				echo '<tr>
								<td class="text-center" style="width: 20px;">' . $cuadre_ta['contribuyente'] . '</td>
								<td class="" style="width: 490px;">' . $cuadre_ta['nombres'] . '</td>
								<td class="text-center" style="width: 40px;">' . $cuadre_ta['Tipo_Tributo'] . '</td> 
								<td class="text-center" style="width: 40px;">' . $cuadre_ta['Anio'] . '</td>
								<td class="text-center" style="width: 40px;">' . $cuadre_ta['Periodo'] . '</td>
								<td class="text-center" style="width: 80px;">' . $cuadre_ta['Numeracion_caja'] . '</td>
								<td class="text-center" style="width: 40px;">' . $cuadre_ta['Importe'] . '</td>
								<td class="text-center" style="width: 40px;">' . $cuadre_ta['Gasto_Emision'] . '</td>
								<td class="text-center" style="width: 40px;">' . $cuadre_ta['Total'] . '</td>
								<td class="text-center" style="width: 40px;">' . $cuadre_ta['Descuento'] . '</td>
								<td class="text-center" style="width: 40px;">' . $cuadre_ta['TIM'] . '</td>
								<td class="text-center" style="width: 40px;">' . $cuadre_ta['Total_Pagar'] . '</td>
								<td class="text-center" style="width: 40px;">' . $cuadre_ta['Estado'] . '</td>																	
						</tr>';
			}
		} else {
			echo '<tr>
                <td class="text-center" colspan="13">No hay registro de Pagos de fecha ' . $dia . '-' . $mes . '-' . $año . '</td>
                </tr>';
		}
	}
	public static function ctrMostrar_lista_extorno($fecha)
	{
		$respuesta = ModeloReporte::mdlMostrar_lista_extorno($fecha);
		return $respuesta;
	}
	// Muestra los ingresos de especie antes de cerrar caja
	public static function ctrMostrar_ingresos_especie($fecha)
	{
		$respuesta = ModeloReporte::mdlMostrar_ingresos_especie($fecha);
		$año = substr($fecha, 0, 4);
		$mes = substr($fecha, 5, 2);
		$dia = substr($fecha, 8, 2);
		if ($respuesta) {
			foreach ($respuesta as $cuadre_ta) {
				echo '<tr>
								<td class="text-center" style="width: 170px;">' . $cuadre_ta['Nombre_Area'] . '</td>
								<td class="" style="width: 300px;">' . $cuadre_ta['Nombre_Especie'] . '</td>
								<td class="text-center" style="width: 200px;">' . $cuadre_ta['Nombres'] . '</td> 
								<td class="text-center" style="width: 40px;">' . $cuadre_ta['Numero_Caja'] . '</td>
								<td class="text-center" style="width: 20px;">' . $cuadre_ta['Cantidad'] . '</td>
								<td class="text-center" style="width: 40px;">' . $cuadre_ta['Monto'] . '</td>
								<td class="text-center" style="width: 40px;">' . $cuadre_ta['Valor_Total'] . '</td>
								<td class="text-center" style="width: 30px;">' . $cuadre_ta['Estado'] . '</td>                                                        
						</tr>';
			}
		} else {
			echo '<tr>
                <td class="text-center" colspan="13">No hay registro de Pagos de fecha ' . $dia . '-' . $mes . '-' . $año . '</td>
                </tr>';
		}
	}

	public static function ctrMostrar_ingresos_tributosagua_total($fecha)
	{
		$respuesta = ModeloReporte::mdlMostrar_ingresos_tributosagua_total($fecha);
		return $respuesta;
	}
	public static function ctrMostrar_ingresos_especie_total($fecha)
	{
		$respuesta = ModeloReporte::mdlMostrar_ingresos_especie_total($fecha);
		return $respuesta;
	}
	public static function ctrMostrar_ingresos_tributosagua_report($fecha)
	{
		$respuesta = ModeloReporte::mdlMostrar_ingresos_tributosagua_report($fecha);
		$año = substr($fecha, 0, 4);
		$mes = substr($fecha, 5, 2);
		$dia = substr($fecha, 8, 2);
		if ($respuesta) {
			foreach ($respuesta as $cuadre_ta) {
				echo '<tr>
								<td class="" style="width:250px;">' . $cuadre_ta['Descripcion'] . '</td>
								<td class="text-center" style="width: 40px;">' . $cuadre_ta['registros'] . '</td> 
								<td class="text-center" style="width: 40px;">' . $cuadre_ta['Suma_Importe'] . '</td>
								<td class="text-center" style="width: 40px;">' . $cuadre_ta['Suma_Gasto_Emision'] . '</td>
								<td class="text-center" style="width: 20px;">' . $cuadre_ta['Suma_TIM'] . '</td>
								<td class="text-center" style="width: 40px;">' . $cuadre_ta['Suma_Total_Pagar'] . '</td>
						</tr>';
			}
		} else {
			echo '<tr>
                <td class="text-center" colspan="13">No hay registro de Pagos de fecha ' . $dia . '-' . $mes . '-' . $año . '</td>
                </tr>';
		}
	}
	public static function ctrMostrar_ingresos_especie_report($fecha)
	{
		$respuesta = ModeloReporte::mdlMostrar_ingresos_especie_report($fecha);
		$año = substr($fecha, 0, 4);
		$mes = substr($fecha, 5, 2);
		$dia = substr($fecha, 8, 2);
		if ($respuesta) {
			foreach ($respuesta as $cuadre_ta) {
				echo '<tr>
									<td class="" style="width:30px;">' . $cuadre_ta['Codigo'] . '</td>
									<td class="text-center" style="width: 270px;">' . $cuadre_ta['Nombre_Especie'] . '</td> 
									<td class="text-center" style="width: 30px;">' . $cuadre_ta['item'] . '</td>
									<td class="text-center" style="width: 40px;">' . $cuadre_ta['Monto'] . '</td>
									<td class="text-center" style="width: 40px;">' . $cuadre_ta['Total'] . '</td>
							</tr>';
			}
		} else {
			echo '<tr>
                <td class="text-center" colspan="13">No hay registro de Pagos de fecha ' . $dia . '-' . $mes . '-' . $año . '</td>
            </tr>';
		}
	}

	public static function ctrMostrar_ingresos_tributosagua_presu($fecha)
	{
		$respuesta = ModeloReporte::mdlMostrar_ingresos_tributosagua_presu($fecha);
		
		$año = substr($fecha, 0, 4);
		$mes = substr($fecha, 5, 2);
		$dia = substr($fecha, 8, 2);
		if ($respuesta) {
			foreach ($respuesta as $cuadre_ta) {
				echo '<tr>
								<td class="" style="width:40px;">' . $cuadre_ta['Codigo'] . '</td>
								<td class="" style="width: 220px;">' . $cuadre_ta['Descripcion'] . '</td> 
								<td class="text-center" style="width: 40px;">' . $cuadre_ta['registros'] . '</td>
								<td class="text-center" style="width: 40px;">' . $cuadre_ta['Suma_Total_Pagar'] . '</td>
						</tr>';
			}
		} else {
			echo '<tr>
                <td class="text-center" colspan="13">No hay registro de Pagos de fecha ' . $dia . '-' . $mes . '-' . $año . '</td>
                </tr>';
		}
	}
	public static function ctrMostrar_ingresos_especie_area($fecha)
	{
		$respuesta = ModeloReporte::mdlMostrar_ingresos_especie_area($fecha);
		$año = substr($fecha, 0, 4);
		$mes = substr($fecha, 5, 2);
		$dia = substr($fecha, 8, 2);
		if ($respuesta) {
			foreach ($respuesta as $cuadre_ta) {
				echo '<tr>
								<td class="" style="width:300px;">' . $cuadre_ta['Nombre_Area'] . '</td>
								<td class="text-center" style="width: 20px;">' . $cuadre_ta['item'] . '</td> 
								<td class="text-center" style="width: 40px;">' . $cuadre_ta['Total'] . '</td>
						</tr>';
			}
		} else {
			echo '<tr>
                <td class="text-center" colspan="13">No hay registro de Pagos de fecha ' . $dia . '-' . $mes . '-' . $año . '</td>
                </tr>';
		}
	}
	public static function ctrCierre_Ingresos($fecha)
	{
		$pdo = Conexion::conectar();
		$stmt = $pdo->prepare("SELECT * FROM cierre_fecha WHERE Fecha = '${fecha}' AND Estado = 1");
		// $stmt->bindParam(":fecha", $fecha);
		$stmt->execute();
		$stmt1 = $pdo->prepare("SELECT 
                        COUNT(conteo) as conteo
                    FROM
                        (
                            SELECT
                                Id_Ingresos_Tributos  as conteo
                            FROM
                                ingresos_agua
                            WHERE
                                DATE(Fecha_Pago) = '${fecha}' AND Estado = 'P'
                        
                            UNION ALL
                            SELECT
                                Id_Ingresos_Tributos as conteo
                            FROM
                                ingresos_tributos
                            WHERE
                                DATE(Fecha_Pago) = '${fecha}' AND Estado = 'P'
                            UNION ALL
                            SELECT
                                Id_Cuenta_Especie_Valorada as conteo
                            FROM
                                ingresos_especies_valoradas
                            WHERE
                                DATE(Fecha_Pago) = '${fecha}' AND Estado = 'P'    
                        
                        ) AS Subconsulta");
		$stmt1->execute();
		$row = $stmt1->fetch(PDO::FETCH_ASSOC); // Obtener fila como array asociativo
		$valor = $row['conteo'];
		if ($stmt->rowCount() > 0) {
			$respuesta = array(
				'tipo' => 'advertencia',
				'mensaje' => '<div class="alert alert-info" role="alert">Ya se cerró la caja para la fecha ' . $fecha . '</div>'
			);
			return $respuesta;
		} else {
			if ($valor == 0) {
				$respuesta = array(
					'tipo' => 'advertencia',
					'mensaje' => '<div class="alert alert-danger" role="alert">No existe registros de ingresos de fecha  ' . $fecha . '</div>'
				);
				return $respuesta;
			} else {
				$respuesta = ModeloReporte::mdlCierre_Ingresos($fecha);
				if ($respuesta == 'ok') {
					$respuesta = array(
						"tipo" => "correcto",
						"mensaje" => '<div class="col-sm-30">
													<div class="alert alert-success">
															<button type="button" class="close font__size-18" data-dismiss="alert">
															</button>
															<i class="start-icon far fa-check-circle faa-tada animated"></i>
															<strong class="font__weight-semibold">Alerta!</strong>Se cerro caja de forma correcta de fecha ' . $fecha . '
													</div>
													</div>'
					);
					return $respuesta;
				} else {
					$respuesta = array(
						'tipo' => 'advertencia',
						'mensaje' => '<div class="col-sm-30">
													<div class="alert alert-warning">
															<button type="button" class="close font__size-18" data-dismiss="alert">
															</button>
															<i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>
															<strong class="font__weight-semibold">Alerta!</strong>Algo salio mal, comunicarce con el Administrador.
													</div>
													</div>'
					);
					return $respuesta;
				}
			}
		}
	}
	public static function ctrMostrar_Report_Finan($fecha)
	{
		$respuesta = ModeloReporte::mdlMostrar_Report_Finan($fecha);
		$año = substr($fecha, 0, 4);
		$mes = substr($fecha, 5, 2);
		$dia = substr($fecha, 8, 2);
		if ($respuesta) {
			foreach ($respuesta as $report) {
				echo '<tr>
									<td class="text-center" style="width:40px;">' . $report['codigo'] . '</td>
									<td class="text-center" style="width: 310px;">' . $report['descripcion'] . '</td> 
									<td class="text-center" style="width: 40px;">' . $report['subtotal'] . '</td>
									<td class="text-center" style="width: 40px;">' . $report['financia'] . '</td>
							</tr>';
			}
		} else {
			echo '<tr>
                <td class="text-center" colspan="4">No hay registro de cierre de caja de fecha ' . $dia . '-' . $mes . '-' . $año . '</td>
                </tr>';
		}
	}

	public static function ctrMostrar_Report_Finan_total($fecha)
	{
		$respuesta = ModeloReporte::mdlMostrar_Report_Finan_total($fecha);
		return $respuesta;
	}

	public static function ctrMostrar_Reporte_Ingreso_Diario($fecha)
	{
		$respuesta = ModeloReporte::mdlMostrar_Ingreso_Diarios($fecha);
		return $respuesta;
	}

}
