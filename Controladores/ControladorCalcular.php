<?php

namespace Controladores;

use Modelos\ModeloCalcular;
use Conect\Conexion;

class ControladorCalcular
{
	// MOSTRAR EL IMPUESTO A PAGAR
	public static function ctrMostrar_calculo_impuesto($datos)
	{
		$respuesta = ModeloCalcular::mdlMostrar_calculo_impuesto($datos, "nulo", "nulo","null");
		return $respuesta;
	}
	public static function ctrMostrar_cuotas_la($datos)
{   $id_predio=$datos['id_predio'];
    $respuesta = ModeloCalcular::mdlMostrar_cuotas_la($datos, 'calcular', '', $id_predio, '');

    if (count($respuesta) > 0 and count($respuesta)<5) {
        $html = '';
        foreach ($respuesta as $fila) {
            $periodo = htmlspecialchars($fila['Periodo']);
            $fecha_vence = htmlspecialchars($fila['Fecha_Vence']);
            $importe = htmlspecialchars($fila['Importe']);
            $gasto_emision = htmlspecialchars($fila['Gasto_Emision']);
            $total = htmlspecialchars($fila['Total']);

            $html .= "<tr>
                        <td>{$periodo}</td>
                        <td>{$fecha_vence}</td>
                        <td>{$importe}</td>
                        <td>{$gasto_emision}</td>
                        <td>{$total}</td>
                      </tr>";
        }
        echo $html;
    } else {
        echo '<tr><td class="text-center" colspan="5">No Registra cuotas de vencimiento</td></tr>';
    }
}

	// REGISTRAR IMPUESTO
	public static function ctrRegistro_Impuesto($datos)
	{
		$valor = explode('-', $datos['contribuyente']);
		sort($valor);
		$ids = implode("-", $valor);
		$pdo = Conexion::conectar();
		$stmt = $pdo->prepare("SELECT Id_Estado_Cuenta_Impuesto from estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
		$stmt->bindParam(":ids", $ids);
		$stmt->bindParam(":anio", $datos['anio']);
		$stmt->execute();
        
		if($datos["predio_select"]=="no"){
		 if ($datos['recalcular'] == 'no') {
			if ($stmt->rowCount() > 0) {
				$respuesta = array(
					'tipo' => 'advertencia',
					'mensaje' => '<div class="alert alert-danger" role="alert">Ya existe registro calculado de impuesto o arbitrios del año ' . $datos['anio'] . '</div>'
				);
			} else {
				$respuesta = ModeloCalcular::mdlRegistrarimpuesto($datos);
				if ($respuesta == "ok") {
					$respuesta = array(
						'tipo' => 'correcto',
						'mensaje' => '<div class="alert alert-success" role="alert">Se Calculo el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
					);
				} else {
					$respuesta = array(
						'tipo' => 'correcto',
						'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
					);
				}
			}
		} else {
			$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
			$stmt->bindParam(":ids", $ids);
			$stmt->bindParam(":anio", $datos['anio']);
			$stmt->execute();
			$respuesta = ModeloCalcular::mdlRegistrarimpuesto($datos);
			if ($respuesta == "ok") {
				$respuesta = array(
					'tipo' => 'correcto',
					'mensaje' => '<div class="alert alert-success" role="alert">Se RECALCULO el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
				);
			} else {
				$respuesta = array(
					'tipo' => 'correcto',
					'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
				);
			}
		}
	 }
	 else{
		$respuesta = ModeloCalcular::mdlRegistrarimpuesto($datos);
		if ($respuesta == "ok") {
			$respuesta = array(
				'tipo' => 'correcto',
				'mensaje' => '<div class="alert alert-success" role="alert">Se Calculo el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
			);
		} else {
			$respuesta = array(
				'tipo' => 'correcto',
				'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
			);
		}
	 }
		return $respuesta;
	}
}
