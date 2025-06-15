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
	{  
	 $id_predio=$datos['id_predio'];
	
	//  var_dump($datos);

	// exit;

    $respuesta = ModeloCalcular::mdlMostrar_cuotas_la($datos, 'calcular', '', $id_predio, '');


    if (count($respuesta) > 0 and count($respuesta)<5) {
        $html = '';
        foreach ($respuesta as $fila) {
            $periodo = htmlspecialchars($fila['Periodo']);
          //  $fecha_vence = htmlspecialchars($fila['Fecha_Vence']);
            $importe = htmlspecialchars($fila['Importe']);
            $gasto_emision = htmlspecialchars($fila['Gasto_Emision']);
            $total = htmlspecialchars($fila['Total']);
			
            $html .= "<tr>
                        <td>{$periodo}</td>
                        
                        <td>{$importe}</td>
                        <td>{$gasto_emision}</td>
                        <td>{$total}</td>
                      </tr>";
        }

        //     $html .= "<tr>
        //                 <td>{$periodo}</td>
        //                 <td>{$fecha_vence}</td>
        //                 <td>{$importe}</td>
        //                 <td>{$gasto_emision}</td>
        //                 <td>{$total}</td>
        //               </tr>";
        // }
        echo $html;
    } else {
        echo '<tr><td class="text-center" colspan="5">No Registra cuotas de vencimiento</td></tr>';
    }
}





// REGISTRAR IMPUESTO
	public static function ctrRegistro_Impuesto($datos)
	{

		//var_dump($datos);
		//die();


		$valor = explode('-', $datos['contribuyente']);
		sort($valor);
		$ids = implode("-", $valor);
		$pdo = Conexion::conectar();
		$stmt = $pdo->prepare("SELECT Id_Estado_Cuenta_Impuesto from estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
		$stmt->bindParam(":ids", $ids);
		$stmt->bindParam(":anio", $datos['anio']);
		$stmt->execute();
        


		
	
		

		//TODO EXONRADO TEMPORALEMENTE
		
		// $id_Regimen_Afecto = $datos['id_Regimen_Afecto'];
		// $validRegimen = true;
		// $regimenArray = explode(',', $id_Regimen_Afecto); // Convierte en un array

		// foreach ($regimenArray as $regimen) {
		// 	if ($regimen !== 'EXONERADO PARCIALMENTE') {
		// 		$validRegimen = false; // Si hay un valor que no sea 'EXONERADO PARCIALMENTE'
		// 		break;
		// 	}
		// }
		//TODO EXONRADO TEMPORALEMENTE FIN

		//--------------------------------------------PREDIOS SIN SELECIONAR-----------------------
		if($datos["predio_select"]=="no"){

			//IANAFECTO
				// Verificar que 'id_Regimen_Afecto' solo contenga 'INAFECTO' y 'EXONERADO PARCIALMENTE'
				$id_Regimen_Afecto = $datos['id_Regimen_Afecto'];
				$validRegimen = true;
				$regimenArray = explode(',', $id_Regimen_Afecto); // Convierte en un array

				$containsInafecto = false;
				$containsExonerado = false;

				foreach ($regimenArray as $regimen) {
					if ($regimen === 'INAFECTO') {
						$containsInafecto = true;
					} elseif ($regimen === 'EXONERADO PARCIALMENTE') { 
						$containsExonerado = true;
					} else {
						$validRegimen = false; // Si hay un valor que no sea 'INAFECTO' o 'EXONERADO PARCIALMENTE'
						break;
					}
				}

		//END INAFECFTO


			//SIN REACALCULAR
		 if ($datos['recalcular'] == 'no') {


			//EXONERADO ADULTO MAYOR ---------------------------
			if (substr_count($datos["predios_totales"], "U") == 1 && strpos($datos["id_Regimen_Afecto"], "EXONERADO ADULTO MAYOR") !== false) {
    		
					if ($stmt->rowCount() > 0) {
						$respuesta = array(
							'tipo' => 'advertencia',
							'mensaje' => '<div class="alert alert-danger" role="alert">Ya existe registro calculado de impuesto o arbitrios del año ' . $datos['anio'] . '</div>'
						);
					} else {
						$respuesta = ModeloCalcular::mdlRegistrarimpuestoExoneradoMayor($datos);
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
			}

			//INAFECTO---------------------------

			// elseif ( $validRegimen){
			// 			if ($stmt->rowCount() > 0) {
			// 			$respuesta = array(
			// 				'tipo' => 'advertencia',
			// 				'mensaje' => '<div class="alert alert-danger" role="alert">Ya existe registro calculado de impuesto o arbitrios del año ' . $datos['anio'] . '</div>'
			// 			);
			// 		} else {
			// 			$respuesta = ModeloCalcular::mdlRegistrarimpuestoInafecto($datos);
			// 			if ($respuesta == "ok") {
			// 				$respuesta = array(
			// 					'tipo' => 'correcto',
			// 					'mensaje' => '<div class="alert alert-success" role="alert">Se Calculo el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
			// 				);
			// 			} else {
			// 				$respuesta = array(
			// 					'tipo' => 'correcto',
			// 					'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
			// 				);
			// 			}
			// 		}

			// }

			//INAFECTO---------------------------
			elseif ( $containsInafecto && $containsExonerado){



						$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
						$stmt->bindParam(":ids", $ids);
						$stmt->bindParam(":anio", $datos['anio']);
						$stmt->execute();
						
						$respuesta = ModeloCalcular::mdlRegistrarimpuestoInafecto($datos);
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

				//INAFECTO SOLO---------------------------
			elseif ( $containsInafecto ){

				

						$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
						$stmt->bindParam(":ids", $ids);
						$stmt->bindParam(":anio", $datos['anio']);
						$stmt->execute();
						
						$respuesta = ModeloCalcular::mdlRegistrarimpuestoInafecto($datos);
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
		

			//EXONERACION PENSIONISTA ---------------------------
			elseif (substr_count($datos["predios_totales"], "U") == 1 && strpos($datos["id_Regimen_Afecto"], "EXONERADO PENSIONISTA") !== false) {
    			if ($stmt->rowCount() > 0) {
						$respuesta = array(
							'tipo' => 'advertencia',
							'mensaje' => '<div class="alert alert-danger" role="alert">Ya existe registro calculado de impuesto o arbitrios del año ' . $datos['anio'] . '</div>'
						);
					} else {
						$respuesta = ModeloCalcular::mdlRegistrarimpuestoExoneradoPencionista($datos);
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

			}


			else{

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

		}
	
		} 
		//RECALCULAR
		else {

			//EXONERACION ADULTO MAYOR ---------------------------
			
			if (substr_count($datos["predios_totales"], "U") == 1 && strpos($datos["id_Regimen_Afecto"], "EXONERADO ADULTO MAYOR") !== false) {
    			// El código aquí se ejecutará solo si ambas condiciones son verdaderas

						$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
						$stmt->bindParam(":ids", $ids);
						$stmt->bindParam(":anio", $datos['anio']);
						$stmt->execute();
						
						$respuesta = ModeloCalcular::mdlRegistrarimpuestoExoneradoMayor($datos);
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
				


			
			//EXONERADO PARCIALMENTE ---------------------------

			// elseif ( $validRegimen){
			// 			if ($stmt->rowCount() > 0) {
			// 			$respuesta = array(
			// 				'tipo' => 'advertencia',
			// 				'mensaje' => '<div class="alert alert-danger" role="alert">Ya existe registro calculado de impuesto o arbitrios del año ' . $datos['anio'] . '</div>'
			// 			);
			// 		} else {
			// 			$respuesta = ModeloCalcular::mdlRegistrarimpuesto($datos);
			// 			if ($respuesta == "ok") {
			// 				$respuesta = array(
			// 					'tipo' => 'correcto',
			// 					'mensaje' => '<div class="alert alert-success" role="alert">Se Calculo el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
			// 				);
			// 			} else {
			// 				$respuesta = array(
			// 					'tipo' => 'correcto',
			// 					'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
			// 				);
			// 			}
			// 		}

			// }


			//INAFECTO CON EXONERACION ---------------------------
			//elseif ( $validRegimen){


			elseif ( $containsInafecto && $containsExonerado){

						$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
						$stmt->bindParam(":ids", $ids);
						$stmt->bindParam(":anio", $datos['anio']);
						$stmt->execute();
						
						$respuesta = ModeloCalcular::mdlRegistrarimpuestoInafecto($datos);
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
			//INAFECTO SOLO---------------------------
			elseif ( $containsInafecto ){

				

						$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
						$stmt->bindParam(":ids", $ids);
						$stmt->bindParam(":anio", $datos['anio']);
						$stmt->execute();
						
						$respuesta = ModeloCalcular::mdlRegistrarimpuestoInafecto($datos);
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
			//EXONERACION PENSIONISTA ---------------------------
			elseif (substr_count($datos["predios_totales"], "U") == 1 && strpos($datos["id_Regimen_Afecto"], "EXONERADO PENSIONISTA") !== false) {
    			// El código aquí se ejecutará solo si ambas condiciones son verdaderas

						$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
						$stmt->bindParam(":ids", $ids);
						$stmt->bindParam(":anio", $datos['anio']);
						$stmt->execute();
						
						$respuesta = ModeloCalcular::mdlRegistrarimpuestoExoneradoPencionista($datos);
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
			
			//AFECTO
			else{

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





			//CALCULO AFECTO


			





		}



	 }

	 
	 //-------------------------------------------------------PREDIOS SELECIONADOS-------------------
	 else{


		//ORIGINAL ----------------------------------
		// $respuesta = ModeloCalcular::mdlRegistrarimpuesto($datos);
		// if ($respuesta == "ok") {
		// 	$respuesta = array(
		// 		'tipo' => 'correcto',
		// 		'mensaje' => '<div class="alert alert-success" role="alert">Se Calculo el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
		// 	);
		// } else {
		// 	$respuesta = array(
		// 		'tipo' => 'correcto',
		// 		'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
		// 	);
		// }


					//IANAFECTO
				// Verificar que 'id_Regimen_Afecto' solo contenga 'INAFECTO' y 'EXONERADO PARCIALMENTE'
				$id_Regimen_Afectoa = $datos['id_Regimen_Afecto'];
				$validRegimen = true;
				$regimenArraya = explode(',', $id_Regimen_Afectoa); // Convierte en un array

				$containsInafectoa = false;
				$containsExoneradoa = false;

				foreach ($regimenArraya as $regimen) {
					if ($regimen === 'INAFECTO') {
						$containsInafectoa = true;
					} elseif ($regimen === 'EXONERADO PARCIALMENTE') { 
						$containsExoneradoa = true;
					} else {
						$validRegimen = false; // Si hay un valor que no sea 'INAFECTO' o 'EXONERADO PARCIALMENTE'
						break;
					}
				}

		//END INAFECFTO


			//SIN REACALCULAR
		 if ($datos['recalcular'] == 'no') {




			//EXONERADO ADULTO MAYOR ---------------------------
			// if (substr_count($datos["predios_totales"], "U") == 1 && strpos($datos["id_Regimen_Afecto"], "EXONERADO ADULTO MAYOR") !== false) {
    		
			// 		if ($stmt->rowCount() > 0) {
			// 			$respuesta = array(
			// 				'tipo' => 'advertencia',
			// 				'mensaje' => '<div class="alert alert-danger" role="alert">Ya existe registro calculado de impuesto o arbitrios del año ' . $datos['anio'] . '</div>'
			// 			);
			// 		} else {
			// 			$respuesta = ModeloCalcular::mdlRegistrarimpuestoExoneradoMayor($datos);
			// 			if ($respuesta == "ok") {
			// 				$respuesta = array(
			// 					'tipo' => 'correcto',
			// 					'mensaje' => '<div class="alert alert-success" role="alert">Se Calculo el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
			// 				);
			// 			} else {
			// 				$respuesta = array(
			// 					'tipo' => 'correcto',
			// 					'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
			// 				);
			// 			}
			// 		}
			// }

		
			//INAFECTO---------------------------
			if ( $containsInafectoa && $containsExoneradoa){

					
				
					$stmt = $pdo->prepare("SELECT * FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio and Numero_Recibo IS NULL;");
					$stmt->bindParam(":ids", $ids);
					$stmt->bindParam(":anio", $datos['anio']);
					$stmt->execute();

					if ($stmt->rowCount() > 0) {
							$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio and Numero_Recibo IS NULL;");
							$stmt->bindParam(":ids", $ids);
							$stmt->bindParam(":anio", $datos['anio']);
							$stmt->execute();

							

							$respuesta = ModeloCalcular::mdlRegistrarimpuestoInafecto($datos);
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



					}else{


							$respuesta = ModeloCalcular::mdlRegistrarimpuestoInafecto($datos);
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

			//INAFECTO SOLO---------------------------
			elseif ( $containsInafectoa ){

				

				
					$stmt = $pdo->prepare("SELECT * FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio and Numero_Recibo IS NULL;");
					$stmt->bindParam(":ids", $ids);
					$stmt->bindParam(":anio", $datos['anio']);
					$stmt->execute();

					if ($stmt->rowCount() > 0) {
							$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio and Numero_Recibo IS NULL;");
							$stmt->bindParam(":ids", $ids);
							$stmt->bindParam(":anio", $datos['anio']);
							$stmt->execute();

							

							$respuesta = ModeloCalcular::mdlRegistrarimpuestoInafecto($datos);
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



					}else{


							$respuesta = ModeloCalcular::mdlRegistrarimpuestoInafecto($datos);
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
		

			//EXONERACION PENSIONISTA ---------------------------
			// elseif (substr_count($datos["predios_totales"], "U") == 1 && strpos($datos["id_Regimen_Afecto"], "EXONERADO PENSIONISTA") !== false) {
    		// 	if ($stmt->rowCount() > 0) {
			// 			$respuesta = array(
			// 				'tipo' => 'advertencia',
			// 				'mensaje' => '<div class="alert alert-danger" role="alert">Ya existe registro calculado de impuesto o arbitrios del año ' . $datos['anio'] . '</div>'
			// 			);
			// 		} else {
			// 			$respuesta = ModeloCalcular::mdlRegistrarimpuestoExoneradoPencionista($datos);
			// 			if ($respuesta == "ok") {
			// 				$respuesta = array(
			// 					'tipo' => 'correcto',
			// 					'mensaje' => '<div class="alert alert-success" role="alert">Se Calculo el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
			// 				);
			// 			} else {
			// 				$respuesta = array(
			// 					'tipo' => 'correcto',
			// 					'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
			// 				);
			// 			}
			// 		}

			// }


			else{



				
					$stmt = $pdo->prepare("SELECT * FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio and Numero_Recibo IS NULL;");
					$stmt->bindParam(":ids", $ids);
					$stmt->bindParam(":anio", $datos['anio']);
					$stmt->execute();

					if ($stmt->rowCount() > 0) {
							$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio and Numero_Recibo IS NULL;");
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



					}else{


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
					// if ($stmt->rowCount() > 0) {
					// 	$respuesta = array(
					// 		'tipo' => 'advertencia',
					// 		'mensaje' => '<div class="alert alert-danger" role="alert">Ya existe registro calculado de impuesto o arbitrios del año ' . $datos['anio'] . '</div>'
					// 	);
					// } else {
					// 	$respuesta = ModeloCalcular::mdlRegistrarimpuesto($datos);
					// 	if ($respuesta == "ok") {
					// 		$respuesta = array(
					// 			'tipo' => 'correcto',
					// 			'mensaje' => '<div class="alert alert-success" role="alert">Se Calculo el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
					// 		);
					// 	} else {
					// 		$respuesta = array(
					// 			'tipo' => 'correcto',
					// 			'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
					// 		);
					// 	}
					// }

		}
	
		} 

		//RECALCULAR SELECIONADO PREDIO------------
		else {

			//EXONERACION ADULTO MAYOR ---------------------------
			
			// if (substr_count($datos["predios_totales"], "U") == 1 && strpos($datos["id_Regimen_Afecto"], "EXONERADO ADULTO MAYOR") !== false) {
    		// 	// El código aquí se ejecutará solo si ambas condiciones son verdaderas

			// 			$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
			// 			$stmt->bindParam(":ids", $ids);
			// 			$stmt->bindParam(":anio", $datos['anio']);
			// 			$stmt->execute();
						
			// 			$respuesta = ModeloCalcular::mdlRegistrarimpuestoExoneradoMayor($datos);
			// 		if ($respuesta == "ok") {
			// 			$respuesta = array(
			// 				'tipo' => 'correcto',
			// 				'mensaje' => '<div class="alert alert-success" role="alert">Se RECALCULO el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
			// 			);
			// 		} else {
			// 			$respuesta = array(
			// 				'tipo' => 'correcto',
			// 				'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
			// 			);
			// 		}



			// } 
				


			
			

			//INAFECTO CON EXONERACION ---------------------------
			//elseif ( $validRegimen){


			if ( $containsInafectoa && $containsExoneradoa){


				
				
					$stmt = $pdo->prepare("SELECT * FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio and Numero_Recibo IS NULL;");
					$stmt->bindParam(":ids", $ids);
					$stmt->bindParam(":anio", $datos['anio']);
					$stmt->execute();

					if ($stmt->rowCount() > 0) {
							$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio and Numero_Recibo IS NULL;");
							$stmt->bindParam(":ids", $ids);
							$stmt->bindParam(":anio", $datos['anio']);
							$stmt->execute();

							

							$respuesta = ModeloCalcular::mdlRegistrarimpuestoInafecto($datos);
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



					}else{


							$respuesta = ModeloCalcular::mdlRegistrarimpuestoInafecto($datos);
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


				//ORIGINAL
					// 	$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
					// 	$stmt->bindParam(":ids", $ids);
					// 	$stmt->bindParam(":anio", $datos['anio']);
					// 	$stmt->execute();
						
					// 	$respuesta = ModeloCalcular::mdlRegistrarimpuestoInafecto($datos);
					// if ($respuesta == "ok") {
					// 	$respuesta = array(
					// 		'tipo' => 'correcto',
					// 		'mensaje' => '<div class="alert alert-success" role="alert">Se RECALCULO el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
					// 	);
					// } else {
					// 	$respuesta = array(
					// 		'tipo' => 'correcto',
					// 		'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
					// 	);
					// }




			}


			//INAFECTO SOLO---------------------------
			elseif ( $containsInafectoa ){

				
					$stmt = $pdo->prepare("SELECT * FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio and Numero_Recibo IS NULL;");
					$stmt->bindParam(":ids", $ids);
					$stmt->bindParam(":anio", $datos['anio']);
					$stmt->execute();

					if ($stmt->rowCount() > 0) {
							$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio and Numero_Recibo IS NULL;");
							$stmt->bindParam(":ids", $ids);
							$stmt->bindParam(":anio", $datos['anio']);
							$stmt->execute();

							

							$respuesta = ModeloCalcular::mdlRegistrarimpuestoInafecto($datos);
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



					}else{


							$respuesta = ModeloCalcular::mdlRegistrarimpuestoInafecto($datos);
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

				//ORIGINAL
					// 	$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
					// 	$stmt->bindParam(":ids", $ids);
					// 	$stmt->bindParam(":anio", $datos['anio']);
					// 	$stmt->execute();
						
					// 	$respuesta = ModeloCalcular::mdlRegistrarimpuestoInafecto($datos);
					// if ($respuesta == "ok") {
					// 	$respuesta = array(
					// 		'tipo' => 'correcto',
					// 		'mensaje' => '<div class="alert alert-success" role="alert">Se RECALCULO el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
					// 	);
					// } else {
					// 	$respuesta = array(
					// 		'tipo' => 'correcto',
					// 		'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
					// 	);
					// }




			}


			
			//EXONERACION PENSIONISTA ---------------------------
			// elseif (substr_count($datos["predios_totales"], "U") == 1 && strpos($datos["id_Regimen_Afecto"], "EXONERADO PENSIONISTA") !== false) {
    		// 	// El código aquí se ejecutará solo si ambas condiciones son verdaderas

			// 			$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
			// 			$stmt->bindParam(":ids", $ids);
			// 			$stmt->bindParam(":anio", $datos['anio']);
			// 			$stmt->execute();
						
			// 			$respuesta = ModeloCalcular::mdlRegistrarimpuestoExoneradoPencionista($datos);
			// 		if ($respuesta == "ok") {
			// 			$respuesta = array(
			// 				'tipo' => 'correcto',
			// 				'mensaje' => '<div class="alert alert-success" role="alert">Se RECALCULO el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
			// 			);
			// 		} else {
			// 			$respuesta = array(
			// 				'tipo' => 'correcto',
			// 				'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
			// 			);
			// 		}



			// } 
			

			//AFECTO
			else{


					$stmt = $pdo->prepare("SELECT * FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio and Numero_Recibo IS NULL;");
					$stmt->bindParam(":ids", $ids);
					$stmt->bindParam(":anio", $datos['anio']);
					$stmt->execute();

					if ($stmt->rowCount() > 0) {
							$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio and Numero_Recibo IS NULL;");
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



					}else{


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





			//CALCULO AFECTO


			





		}







	 }
		return $respuesta;
	}


	// REGISTRAR IMPUESTO
	// public static function ctrRegistro_Impuesto($datos)
	// {
	
	// 	//var_dump($datos);
	// 	// exit;

	// 	$respuesta = array();  // Inicializar la variable respuesta al inicio
	// 	$valor = explode('-', $datos['contribuyente']);
	// 	$id_regiemen_afecto = $datos['id_Regimen_Afecto'];
	
		
	// 	sort($valor);
	// 	$ids = implode("-", $valor);
	// 	$pdo = Conexion::conectar();
	// 	$stmt = $pdo->prepare("SELECT Id_Estado_Cuenta_Impuesto from estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
	// 	$stmt->bindParam(":ids", $ids);
	// 	$stmt->bindParam(":anio", $datos['anio']);
	// 	$stmt->execute();

	// 	// REGIMEN AFECTO
	// 	//$id_regiemen_afecto = $datos['id_Regimen_Afecto'];
	// 	$id_regimen_afecto = isset($datos['id_Regimen_Afecto']) ? $datos['id_Regimen_Afecto'] : null;
    // 	$regimenes = array_map('trim', explode(",", $id_regiemen_afecto));
    // 	$regimenes_unicos = array_unique($regimenes);

		

	// 	// REGIMEN TIPO PREDIO
	// //	$id_tipo_predio = $datos['tipo_predio'];
	// 	$id_tipo_predio = isset($datos['tipo_predio']) ? $datos['tipo_predio'] : null;
    // 	$prediosP = array_map('trim', explode(",", $id_tipo_predio));
    // 	$tipos_predios = array_unique($prediosP);

	// 	// PREDIOS SELECCIONADOS
	// 		$selecionados = isset($datos['selecionados']) ? $datos['selecionados'] : null;

	// 		$predios_seleccionados = isset($datos['predios_seleccionados']) ? $datos['predios_seleccionados'] : null;


		


        
	// 	if($datos["predio_select"]=="no"){
			

	// 	 if ($datos['recalcular'] == 'no') {

				


	// 		if ($stmt->rowCount() > 0) {

	// 		if (empty($predios_seleccionados) && empty($tipo_predio) && empty($id_regimen_afecto)) {
    //     // Si las variables están vacías o no definidas, proceder con la eliminación
	// 			$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente WHERE Concatenado_idc = :ids AND Anio = :anio");
	// 			$stmt->bindParam(":ids", $ids);
	// 			$stmt->bindParam(":anio", $datos['anio']);
	// 			$stmt->execute();
	// 		}


	// 			$respuesta = array(
	// 				'tipo' => 'advertencia',
	// 				'mensaje' => '<div class="alert alert-danger" role="alert">Ya existe registro calculado de impuesto o arbitrios del año ' . $datos['anio'] . '</div>'
	// 			);
	// 		} else {
	// 			$respuesta = ModeloCalcular::mdlRegistrarimpuesto($datos);
	// 			if ($respuesta == "ok") {
	// 				$respuesta = array(
	// 					'tipo' => 'correcto',
	// 					'mensaje' => '<div class="alert alert-success" role="alert">Se Calculo el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
	// 				);
	// 			} else {
	// 				$respuesta = array(
	// 					'tipo' => 'correcto',
	// 					'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
	// 				);
	// 			}
	// 		}



	// 		} else {
	// 			$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
	// 			$stmt->bindParam(":ids", $ids);
	// 			$stmt->bindParam(":anio", $datos['anio']);
	// 			$stmt->execute();

	// 			$respuesta = ModeloCalcular::mdlRegistrarimpuesto($datos);
	// 			if ($respuesta == "ok") {
	// 				$respuesta = array(
	// 					'tipo' => 'correcto',
	// 					'mensaje' => '<div class="alert alert-success" role="alert">Se RECALCULO el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
	// 				);
	// 			} else {
	// 				$respuesta = array(
	// 					'tipo' => 'correcto',
	// 					'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
	// 				);
	// 			}
	// 		}
	// 	 }


		 

	 
	//  elseif($datos["predio_select"]=="si"){


	// 	 if ($datos['recalcular'] == 'si') {


	// 		// EXONERADO ADULTO MAYOR ---------------------------
	// 		 if ($regimenes_unicos[0] === 'EXONERADO ADULTO MAYOR' & $tipos_predios[0] === 'U') {

	// 			$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
	// 			$stmt->bindParam(":ids", $ids);
	// 			$stmt->bindParam(":anio", $datos['anio']);
	// 			$stmt->execute();

	// 			$respuesta = ModeloCalcular::mdlRegistrarimpuestoExoneradoMayor($datos);
	// 			if ($respuesta == "ok") {
	// 				$respuesta = array(
	// 					'tipo' => 'correcto',
	// 					'mensaje' => '<div class="alert alert-success" role="alert">Se Calculo el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
	// 				);
	// 			} else {
	// 				$respuesta = array(
	// 					'tipo' => 'correcto',
	// 					'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
	// 				);
	// 			}

	// 		 }

	// 		 // EXONERADO PENSIONISTA ---------------------------
	// 		 if ($regimenes_unicos[0] === 'EXONERADO PENSIONISTA' & $tipos_predios[0] === 'U') {

	// 			$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
	// 			$stmt->bindParam(":ids", $ids);
	// 			$stmt->bindParam(":anio", $datos['anio']);
	// 			$stmt->execute();

	// 			$respuesta = ModeloCalcular::mdlRegistrarimpuestoExoneradoPencionista($datos);
	// 			if ($respuesta == "ok") {
	// 				$respuesta = array(
	// 					'tipo' => 'correcto',
	// 					'mensaje' => '<div class="alert alert-success" role="alert">Se Calculo el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
	// 				);
	// 			} else {
	// 				$respuesta = array(
	// 					'tipo' => 'correcto',
	// 					'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
	// 				);
	// 			}

	// 		 }


	// 		 //INAFECTO---------------------------
			 	
	// 		if (!empty($regimenes) && count(array_unique($regimenes)) === 1 && $regimenes[0] === 'INAFECTO') {

	// 			$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
	// 			$stmt->bindParam(":ids", $ids);
	// 			$stmt->bindParam(":anio", $datos['anio']);
	// 			$stmt->execute();

	// 			$respuesta = ModeloCalcular::mdlRegistrarimpuestoInafecto($datos);
	// 			if ($respuesta == "ok") {
	// 				$respuesta = array(
	// 					'tipo' => 'correcto',
	// 					'mensaje' => '<div class="alert alert-success" role="alert">Se Calculo el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
	// 				);
	// 			} else {
	// 				$respuesta = array(
	// 					'tipo' => 'correcto',
	// 					'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
	// 				);
	// 			}


	// 		}
			

 	// 		if (!empty($regimenes) && $regimenes_unicos[0] !== 'EXONERADO ADULTO MAYOR' && $regimenes_unicos[0] !== 'EXONERADO PENSIONISTA' && $regimenes[0] !== 'INAFECTO'){
	// 			$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
	// 			$stmt->bindParam(":ids", $ids);
	// 			$stmt->bindParam(":anio", $datos['anio']);
	// 			$stmt->execute();


	// 			$respuesta = ModeloCalcular::mdlRegistrarimpuesto($datos);
	// 			if ($respuesta == "ok") {
	// 				$respuesta = array(
	// 					'tipo' => 'correcto',
	// 					'mensaje' => '<div class="alert alert-success" role="alert">Se Calculo el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
	// 				);
	// 			} else {
	// 				$respuesta = array(
	// 					'tipo' => 'correcto',
	// 					'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
	// 				);
	// 			}
	// 		}


		



	// 		// if ($id_regiemen_afecto == 'INAFECTO') {
	// 		// 	$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
	// 		// 	$stmt->bindParam(":ids", $ids);
	// 		// 	$stmt->bindParam(":anio", $datos['anio']);
	// 		// 	$stmt->execute();

	// 		// 	$respuesta = ModeloCalcular::mdlRegistrarimpuestoInafecto($datos);
	// 		// 	if ($respuesta == "ok") {
	// 		// 		$respuesta = array(
	// 		// 			'tipo' => 'correcto',
	// 		// 			'mensaje' => '<div class="alert alert-success" role="alert">Se Calculo el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
	// 		// 		);
	// 		// 	} else {
	// 		// 		$respuesta = array(
	// 		// 			'tipo' => 'correcto',
	// 		// 			'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
	// 		// 		);
	// 		// 	}


	// 		// }



			
	// 		// if ($id_regiemen_afecto == 'EXONERADO PARCIALMENTE') {


	// 		// 	$stmt = $pdo->prepare("DELETE FROM estado_cuenta_corriente  where Concatenado_idc=:ids and Anio=:anio");
	// 		// 	$stmt->bindParam(":ids", $ids);
	// 		// 	$stmt->bindParam(":anio", $datos['anio']);
	// 		// 	$stmt->execute();

	// 		// 	$respuesta = ModeloCalcular::mdlRegistrarimpuestoExoneradoParcialmente($datos);
	// 		// 	if ($respuesta == "ok") {
	// 		// 		$respuesta = array(
	// 		// 			'tipo' => 'correcto',
	// 		// 			'mensaje' => '<div class="alert alert-success" role="alert">Se Calculo el impuesto y Arbitrios con exito del año ' . $datos['anio'] . '</div>'
	// 		// 		);
	// 		// 	} else {
	// 		// 		$respuesta = array(
	// 		// 			'tipo' => 'correcto',
	// 		// 			'mensaje' => '<div class="alert alert-danger" role="alert">Algo salio Mal,comunicarce con el Administrador</div>'
	// 		// 		);
	// 		// 	}


	// 		// }
		

	// 	}
	//  }



	// 	return $respuesta;
	// }






}
