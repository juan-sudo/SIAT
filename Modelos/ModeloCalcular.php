<?php

namespace Modelos;

use Conect\Conexion;
use Exception;
use PDO;

class ModeloCalcular
{

	

	//REEGISTRAR IMPUESTO CALCULADO INAFECTO
	public static function mdlRegistrarimpuestoInafecto($datos)
	{
	
		try {
			$pdo = Conexion::conectar();
			$valor = explode('-', $datos['contribuyente']); //CONVIERTE EN UN ARRAY
			sort($valor);
			$ids = implode("-", $valor); //CONVIERTE EN UN STRING
			$periodo = array(1, 2, 3, 4);
			$periodoUnPerido=array(1);
			//ARBITRIOS 
			
			//OBTENER ID PREDIOS
			if($datos["predio_select"]=='si'){
				$array = explode(',', $datos["predios_seleccionados"]); // ['3', '45']
                $array_numeros = array_map('intval', $array); // [3, 45]
				$cadena_numeros = implode(',', $array_numeros); // '3,45'
				$where = "AND p.Id_Predio IN (".$cadena_numeros.")";
			}
			
			else{
                $where="";
			}


			//UN SOLO CONTRIBUYENTE
			if (count($valor) === 1) {

				// Cuando $valor tiene un solo valor
				if($datos['anio']<2017) {

						$stmt = $pdo->prepare("SELECT ar.Categoria as categoria,
																p.Area_Construccion as area_construccion,
																p.Id_Predio as id_predio,
																ar.Monto as monto 
																FROM predio p 
																INNER JOIN propietario pro on pro.Id_Predio=p.Id_Predio 
																inner join anio an on an.Id_Anio=p.Id_Anio 
																INNER JOIN arbitrios ar on p.Id_Arbitrios=ar.Id_Arbitrios 
																WHERE pro.Id_Contribuyente=:id and an.NomAnio=:anio 
																AND p.ID_Predio NOT IN (SELECT ID_Predio FROM Propietario 
																WHERE ID_Contribuyente <>:id AND pro.Baja='1')and pro.Baja='1' $where ;");
						$stmt->bindParam(":id", $valor[0]);
						$stmt->bindParam(":anio", $datos['anio']);
						$stmt->execute();
				}

				else{
						$stmt = $pdo->prepare("SELECT ar.Categoria as categoria,
											p.Area_Construccion as area_construccion,
											p.Id_Predio as id_predio,
											SUM(t.Monto) as monto 
											FROM predio p 
											INNER JOIN propietario pro on pro.Id_Predio=p.Id_Predio 
											inner join anio an on an.Id_Anio=p.Id_Anio 
											INNER JOIN arbitrios ar on p.Id_Arbitrios=ar.Id_Arbitrios
											INNER JOIN tasa_arbitrio t on t.Id_Arbitrios=ar.Id_Arbitrios AND t.Id_Anio=an.Id_Anio
											WHERE pro.Id_Contribuyente=:id and an.NomAnio=:anio 
											AND p.ID_Predio NOT IN (SELECT ID_Predio FROM Propietario 
											WHERE ID_Contribuyente <>:id AND Baja='1')
											and pro.Baja='1' $where
											GROUP BY p.Id_Predio;");
						$stmt->bindParam(":id", $valor[0]);
						$stmt->bindParam(":anio", $datos['anio']);
						$stmt->execute();
				}
				$campos = $stmt->fetchall();

				foreach ($campos as $campo) {

					// SIN AREA DE CONSTRUCCION
					if ($campo['area_construccion'] == 0) {

						if($datos['anio']>2016){

							if ($campo['categoria'] === 'A') {

								$campo['monto'] = 5;

							} elseif ($campo['categoria'] === 'B') {

								$campo['monto'] = 4;

							} else {

								$campo['monto'] = 3;
								
							}

							for ($i = 0; $i < count($periodo); $i++) {
								$monto = $campo['monto']*3;
								$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
								(Id_Predio,
								Tipo_Tributo, 
								Periodo, 
								Importe, 
								Gasto_Emision, 
								Saldo,
								TIM,
								TIM_Descuento,
								TIM_Aplicar,  
								Total, 
								Estado, 
								Concatenado_idc, 
								Anio,
								Id_Usuario,
								Descuento,
								Total_Aplicar) 
								VALUES 
								(:id_predio,
								'742', 
								:periodo, 
								:impuesto_trimestral,
								0, 
								:saldo,
								0,
								0,
								0, 
								:total, 
								'D', 
								:ids, 
								:anio, 
								:Id_Usuario,
								0,
								:total_aplicar)");
								$stmt->bindParam(":id_predio", $campo['id_predio']);
								$stmt->bindParam(":periodo", $periodo[$i]);
								$stmt->bindParam(":impuesto_trimestral", $monto);
								$stmt->bindParam(":saldo", $monto);
								$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
								$stmt->bindParam(":ids", $ids);
								$stmt->bindParam(":anio", $datos['anio']);
								 $stmt->bindParam(":Id_Usuario",$_SESSION['id']);
								$stmt->bindParam(":total_aplicar", $monto);
								$stmt->execute();
							}

						}
						else{

							if ($campo['categoria'] === 'A') {

								$campo['monto'] = 5;

							} elseif ($campo['categoria'] === 'B') {

								$campo['monto'] = 4;

							} else {

								$campo['monto'] = 3;
								
							}

							for ($i = 0; $i < count($periodo); $i++) {
								$monto = $campo['monto'];
								$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
								(Id_Predio,
								Tipo_Tributo, 
								Periodo, 
								Importe, 
								Gasto_Emision, 
								Saldo,
								TIM,
								TIM_Descuento,
								TIM_Aplicar,  
								Total, 
								Estado, 
								Concatenado_idc, 
								Anio,
								Id_Usuario,
								Descuento,
								Total_Aplicar) 
								VALUES 
								(:id_predio,
								'742', 
								:periodo, 
								:impuesto_trimestral,
								0, 
								:saldo,
								0,
								0,
								0, 
								:total, 
								'D', 
								:ids, 
								:anio, 
								:Id_Usuario,
								0,
								:total_aplicar)");
								$stmt->bindParam(":id_predio", $campo['id_predio']);
								$stmt->bindParam(":periodo", $periodo[$i]);
								$stmt->bindParam(":impuesto_trimestral", $monto);
								$stmt->bindParam(":saldo", $monto);
								$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
								$stmt->bindParam(":ids", $ids);
								$stmt->bindParam(":anio", $datos['anio']);
								 $stmt->bindParam(":Id_Usuario",$_SESSION['id']);
								$stmt->bindParam(":total_aplicar", $monto);
								$stmt->execute();
							}

						}
					}
					else{
						for ($i = 0; $i < count($periodo); $i++) {
							$monto = $campo['monto']*3;
							$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
							(Id_Predio,
							Tipo_Tributo, 
							Periodo, 
							Importe, 
							Gasto_Emision, 
							Saldo,
							TIM,
							TIM_Descuento,
							TIM_Aplicar,  
							Total, 
							Estado, 
							Concatenado_idc, 
							Anio,
							Id_Usuario,
							Descuento,
							Total_Aplicar) 
							VALUES 
							(:id_predio,
							'742', 
							:periodo, 
							:impuesto_trimestral,
							0, 
							:saldo,
							0,
							0,
							0, 
							:total, 
							'D', 
							:ids, 
							:anio, 
							:Id_Usuario,
							0,
							:total_aplicar)");
							$stmt->bindParam(":id_predio", $campo['id_predio']);
							$stmt->bindParam(":periodo", $periodo[$i]);
							$stmt->bindParam(":impuesto_trimestral", $monto);
							$stmt->bindParam(":saldo", $monto);
							$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
							$stmt->bindParam(":ids", $ids);
							$stmt->bindParam(":anio", $datos['anio']);
							 $stmt->bindParam(":Id_Usuario",$_SESSION['id']);
							$stmt->bindParam(":total_aplicar", $monto);
							$stmt->execute();
						}
					}
					

              
					
				  
					
				}
			} 
			
			else {
				// Cuando $valor tiene más de un valor
				$ids_array = implode(",", $valor); // Convierte el array en una cadena de IDs separados por comas
				if($datos['anio']<2017) {
					$stmt = $pdo->prepare("SELECT  ar.Categoria as categoria,
															p.Area_Construccion as area_construccion,
															ar.Monto as monto,
															p.Id_Predio as id_predio
														FROM predio p 
														INNER JOIN propietario pro on pro.Id_Predio=p.Id_Predio 
														inner join anio an on an.Id_Anio=p.Id_Anio 
														INNER JOIN arbitrios ar on p.Id_Arbitrios=ar.Id_Arbitrios  
														WHERE pro.Id_Contribuyente IN ($ids_array) and an.NomAnio=:anio and  pro.Baja='1' $where
														GROUP BY p.ID_Predio HAVING COUNT(DISTINCT pro.ID_Contribuyente) = " . count($valor));
					$stmt->bindParam(":anio", $datos['anio']);
					$stmt->execute();
				}
				else{
					$stmt = $pdo->prepare("CREATE TEMPORARY TABLE temp_arbitrios AS SELECT Id_Arbitrios,sum(Monto) as monto FROM tasa_arbitrio t 
						                    INNER JOIN anio  a  on  a.Id_Anio=t.Id_anio
											where a.NomAnio=:anio
											GROUP BY Id_Arbitrios");
					$stmt->bindParam(":anio", $datos['anio']);
				    $stmt->execute();
                    $stmt = $pdo->prepare("SELECT  ab.Categoria as categoria,
															p.Area_Construccion as area_construccion,
															ar.Monto as monto,
															p.Id_Predio as id_predio
														FROM predio p 
														INNER JOIN propietario pro on pro.Id_Predio=p.Id_Predio 
														inner join anio an on an.Id_Anio=p.Id_Anio 
														INNER JOIN temp_arbitrios ar on p.Id_Arbitrios=ar.Id_Arbitrios 
														INNER JOIN arbitrios ab ON ab.Id_Arbitrios=ar.Id_Arbitrios 
														WHERE pro.Id_Contribuyente IN ($ids_array) and an.NomAnio=:anio and pro.Baja='1'  $where
														GROUP BY p.ID_Predio HAVING COUNT(DISTINCT pro.ID_Contribuyente) = " . count($valor));
					$stmt->bindParam(":anio", $datos['anio']);
					$stmt->execute();
				}
				$campos = $stmt->fetchall();

				foreach ($campos as $campo) {

					if ($campo['area_construccion'] == 0) {
						
						if($datos['anio']>2016){
							if ($campo['categoria'] === 'A') {
								$campo['monto'] = 5;
							} elseif ($campo['categoria'] === 'B') {
								$campo['monto'] = 4;
							} else {
								$campo['monto'] = 3;
							}
							for ($i = 0; $i < count($periodo); $i++) {
								$monto = $campo['monto'] * 3;
								$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
								(Id_Predio,
								Tipo_Tributo,
								Periodo,
								Importe,
								Gasto_Emision, 
								Saldo,
								TIM,
								TIM_Descuento,
								TIM_Aplicar,   
								Total, 
								Estado, 
								Concatenado_idc,
								Anio,
								Id_Usuario,
								Descuento,
								Total_Aplicar) 
								VALUES 
								(:id_predio,
								'742', 
								:periodo, 
								:impuesto_trimestral,
								0, 
								:saldo,
								0,
								0,
								0,  
								:total, 
								'D', 
								:ids, 
								:anio,
								:Id_Usuario,
								0,
								:total_aplicar)");
								$stmt->bindParam(":id_predio", $campo['id_predio']);
								$stmt->bindParam(":periodo", $periodo[$i]);
								$stmt->bindParam(":impuesto_trimestral", $monto);
								$stmt->bindParam(":saldo", $monto);
								$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
								$stmt->bindParam(":ids", $ids);
								$stmt->bindParam(":anio", $datos['anio']);
								 $stmt->bindParam(":Id_Usuario", $_SESSION['id']);
								$stmt->bindParam(":total_aplicar", $monto);
								$stmt->execute();
							}
					    }
							else{
									if ($campo['categoria'] === 'A') {
										$campo['monto'] = 5;
									} elseif ($campo['categoria'] === 'B') {
										$campo['monto'] = 4;
									} else {
										$campo['monto'] = 3;
									}
									for ($i = 0; $i < count($periodo); $i++) {
										$monto = $campo['monto'] * 3;
										$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
										(Id_Predio,
										Tipo_Tributo,
										Periodo,
										Importe,
										Gasto_Emision, 
										Saldo,
										TIM,
										TIM_Descuento,
										TIM_Aplicar,   
										Total, 
										Estado, 
										Concatenado_idc,
										Anio,
										Id_Usuario,
										Descuento,
										Total_Aplicar) 
										VALUES 
										(:id_predio,
										'742', 
										:periodo, 
										:impuesto_trimestral,
										0, 
										:saldo,
										0,
										0,
										0,  
										:total, 
										'D', 
										:ids, 
										:anio,
										:Id_Usuario,
										0,
										:total_aplicar)");
										$stmt->bindParam(":id_predio", $campo['id_predio']);
										$stmt->bindParam(":periodo", $periodo[$i]);
										$stmt->bindParam(":impuesto_trimestral", $monto);
										$stmt->bindParam(":saldo", $monto);
										$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
										$stmt->bindParam(":ids", $ids);
										$stmt->bindParam(":anio", $datos['anio']);
										$stmt->bindParam(":Id_Usuario", $_SESSION['id']);
										$stmt->bindParam(":total_aplicar", $monto);
										$stmt->execute();
							}
					    }


					}
					else{
						for ($i = 0; $i < count($periodo); $i++) {
							$monto = $campo['monto'] * 3;
							$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
							(Id_Predio,
							Tipo_Tributo,
							Periodo,
							Importe,
							Gasto_Emision, 
							Saldo,
							TIM,
							TIM_Descuento,
							TIM_Aplicar,   
							Total, 
							Estado, 
							Concatenado_idc,
							Anio,
							Id_Usuario,
							Descuento,
							Total_Aplicar) 
							VALUES 
							(:id_predio,
							'742', 
							:periodo, 
							:impuesto_trimestral,
							0, 
							:saldo,
							0,
							0,
							0,  
							:total, 
							'D', 
							:ids, 
							:anio,
							:Id_Usuario,
							0,
							:total_aplicar)");
							$stmt->bindParam(":id_predio", $campo['id_predio']);
							$stmt->bindParam(":periodo", $periodo[$i]);
							$stmt->bindParam(":impuesto_trimestral", $monto);
							$stmt->bindParam(":saldo", $monto);
							$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
							$stmt->bindParam(":ids", $ids);
							$stmt->bindParam(":anio", $datos['anio']);
							 $stmt->bindParam(":Id_Usuario", $_SESSION['id']);
							$stmt->bindParam(":total_aplicar", $monto);
							$stmt->execute();
						}
					}
					
				}
			}




			//if ($datos['base_imponible'] == 0) {
			
				

				//$saldo = 5;

				//$gasto_emision = 5;

				$gasto_emision = $datos['gasto_emision'];

				$saldo = $gasto_emision;
				$total=$saldo;
				$total_aplicar=$total;
				$periodoUnPerido="1";

				$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente
				                       (Tipo_Tributo,
									    Periodo, 
										Importe, 
										Gasto_Emision, 
										Saldo,
										TIM,
										TIM_Descuento,
						                TIM_Aplicar,    
										Total,
										Estado, 
										Concatenado_idc, 
										Anio, 
										Id_Usuario,
										Descuento,
										Total_Aplicar,
										Autovaluo) 
										VALUES 
										('006', 
										:periodo, 
										0, 
										:gasto_emision, 
										:saldo,
										0,
										0,
										0, 
										:total,
										'D', 
										:ids, 
										:anio, 
										:Id_Usuario,
										0,
										:total_aplicar,
										:autovaluo)");
				$stmt->bindParam(":periodo", $periodoUnPerido);
				//$stmt->bindParam(":impuesto_trimestral", 0);
				$stmt->bindParam(":gasto_emision", $gasto_emision);
				$stmt->bindParam(":saldo", $saldo);
				$stmt->bindParam(":total", $total); // En este caso, total es igual a saldo
				$stmt->bindParam(":ids", $ids);
				$stmt->bindParam(":anio", $datos['anio']);
			    $stmt->bindParam(":Id_Usuario", $_SESSION['id'] );
			    $stmt->bindParam(":total_aplicar", $total_aplicar); 
				$stmt->bindParam(":autovaluo", $datos['base_imponible']); 

				
				$stmt->execute();


			return 'ok';
		} catch (Exception $excepcion) {
			// Manejo de la excepción
			echo "Se ha producido un error: " . $excepcion->getMessage();
		}
	}

	//REGISTRAR IMPUESTO CALCULAD EXONERADOADULTO MAYOR
	public static function mdlRegistrarimpuestoExoneradoMayor($datos)
	{
	
		try {
			$pdo = Conexion::conectar();
			$valor = explode('-', $datos['contribuyente']); //CONVIERTE EN UN ARRAY
			sort($valor);
			$ids = implode("-", $valor); //CONVIERTE EN UN STRING
			$periodo = array(1, 2, 3, 4);
			$periodoUnPerido=array(1);
			//ARBITRIOS 
			
			//OBTENER ID PREDIOS
			if($datos["predio_select"]=='si'){
				$array = explode(',', $datos["predios_seleccionados"]); // ['3', '45']
                $array_numeros = array_map('intval', $array); // [3, 45]
				$cadena_numeros = implode(',', $array_numeros); // '3,45'
				$where = "AND p.Id_Predio IN (".$cadena_numeros.")";
			}
			
			else{
                $where="";
			}


			//UN SOLO CONTRIBUYENTE
			if (count($valor) === 1) {

				// Cuando $valor tiene un solo valor
				if($datos['anio']<2017) {

						$stmt = $pdo->prepare("SELECT ar.Categoria as categoria,
																p.Area_Construccion as area_construccion,
																p.Id_Predio as id_predio,
																ar.Monto as monto 
																FROM predio p 
																INNER JOIN propietario pro on pro.Id_Predio=p.Id_Predio 
																inner join anio an on an.Id_Anio=p.Id_Anio 
																INNER JOIN arbitrios ar on p.Id_Arbitrios=ar.Id_Arbitrios 
																WHERE pro.Id_Contribuyente=:id and an.NomAnio=:anio 
																AND p.ID_Predio NOT IN (SELECT ID_Predio FROM Propietario 
																WHERE ID_Contribuyente <>:id AND pro.Baja='1')and pro.Baja='1' $where ;");
						$stmt->bindParam(":id", $valor[0]);
						$stmt->bindParam(":anio", $datos['anio']);
						$stmt->execute();
				}

				else{
						$stmt = $pdo->prepare("SELECT ar.Categoria as categoria,
											p.Area_Construccion as area_construccion,
											p.Id_Predio as id_predio,
											SUM(t.Monto) as monto 
											FROM predio p 
											INNER JOIN propietario pro on pro.Id_Predio=p.Id_Predio 
											inner join anio an on an.Id_Anio=p.Id_Anio 
											INNER JOIN arbitrios ar on p.Id_Arbitrios=ar.Id_Arbitrios
											INNER JOIN tasa_arbitrio t on t.Id_Arbitrios=ar.Id_Arbitrios AND t.Id_Anio=an.Id_Anio
											WHERE pro.Id_Contribuyente=:id and an.NomAnio=:anio 
											AND p.ID_Predio NOT IN (SELECT ID_Predio FROM Propietario 
											WHERE ID_Contribuyente <>:id AND Baja='1')
											and pro.Baja='1' $where
											GROUP BY p.Id_Predio;");
						$stmt->bindParam(":id", $valor[0]);
						$stmt->bindParam(":anio", $datos['anio']);
						$stmt->execute();
				}
				$campos = $stmt->fetchall();

				foreach ($campos as $campo) {

					// SIN AREA DE CONSTRUCCION
					if ($campo['area_construccion'] == 0) {

						if($datos['anio']>2016){

							if ($campo['categoria'] === 'A') {

								$campo['monto'] = 5;

							} elseif ($campo['categoria'] === 'B') {

								$campo['monto'] = 4;

							} else {

								$campo['monto'] = 3;
								
							}

							for ($i = 0; $i < count($periodo); $i++) {
								$monto = $campo['monto']*3;
								$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
								(Id_Predio,
								Tipo_Tributo, 
								Periodo, 
								Importe, 
								Gasto_Emision, 
								Saldo,
								TIM,
								TIM_Descuento,
								TIM_Aplicar,  
								Total, 
								Estado, 
								Concatenado_idc, 
								Anio,
								Id_Usuario,
								Descuento,
								Total_Aplicar) 
								VALUES 
								(:id_predio,
								'742', 
								:periodo, 
								:impuesto_trimestral,
								0, 
								:saldo,
								0,
								0,
								0, 
								:total, 
								'D', 
								:ids, 
								:anio, 
								:Id_Usuario,
								0,
								:total_aplicar)");
								$stmt->bindParam(":id_predio", $campo['id_predio']);
								$stmt->bindParam(":periodo", $periodo[$i]);
								$stmt->bindParam(":impuesto_trimestral", $monto);
								$stmt->bindParam(":saldo", $monto);
								$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
								$stmt->bindParam(":ids", $ids);
								$stmt->bindParam(":anio", $datos['anio']);
								 $stmt->bindParam(":Id_Usuario",$_SESSION['id']);
								$stmt->bindParam(":total_aplicar", $monto);
								$stmt->execute();
							}

						}
						else{

							if ($campo['categoria'] === 'A') {

								$campo['monto'] = 5;

							} elseif ($campo['categoria'] === 'B') {

								$campo['monto'] = 4;

							} else {

								$campo['monto'] = 3;
								
							}

							for ($i = 0; $i < count($periodo); $i++) {
								$monto = $campo['monto'];
								$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
								(Id_Predio,
								Tipo_Tributo, 
								Periodo, 
								Importe, 
								Gasto_Emision, 
								Saldo,
								TIM,
								TIM_Descuento,
								TIM_Aplicar,  
								Total, 
								Estado, 
								Concatenado_idc, 
								Anio,
								Id_Usuario,
								Descuento,
								Total_Aplicar) 
								VALUES 
								(:id_predio,
								'742', 
								:periodo, 
								:impuesto_trimestral,
								0, 
								:saldo,
								0,
								0,
								0, 
								:total, 
								'D', 
								:ids, 
								:anio, 
								:Id_Usuario,
								0,
								:total_aplicar)");
								$stmt->bindParam(":id_predio", $campo['id_predio']);
								$stmt->bindParam(":periodo", $periodo[$i]);
								$stmt->bindParam(":impuesto_trimestral", $monto);
								$stmt->bindParam(":saldo", $monto);
								$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
								$stmt->bindParam(":ids", $ids);
								$stmt->bindParam(":anio", $datos['anio']);
								 $stmt->bindParam(":Id_Usuario",$_SESSION['id']);
								$stmt->bindParam(":total_aplicar", $monto);
								$stmt->execute();
							}

						}
					}
					else{
						for ($i = 0; $i < count($periodo); $i++) {
							$monto = $campo['monto']*3;
							$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
							(Id_Predio,
							Tipo_Tributo, 
							Periodo, 
							Importe, 
							Gasto_Emision, 
							Saldo,
							TIM,
							TIM_Descuento,
							TIM_Aplicar,  
							Total, 
							Estado, 
							Concatenado_idc, 
							Anio,
							Id_Usuario,
							Descuento,
							Total_Aplicar) 
							VALUES 
							(:id_predio,
							'742', 
							:periodo, 
							:impuesto_trimestral,
							0, 
							:saldo,
							0,
							0,
							0, 
							:total, 
							'D', 
							:ids, 
							:anio, 
							:Id_Usuario,
							0,
							:total_aplicar)");
							$stmt->bindParam(":id_predio", $campo['id_predio']);
							$stmt->bindParam(":periodo", $periodo[$i]);
							$stmt->bindParam(":impuesto_trimestral", $monto);
							$stmt->bindParam(":saldo", $monto);
							$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
							$stmt->bindParam(":ids", $ids);
							$stmt->bindParam(":anio", $datos['anio']);
							 $stmt->bindParam(":Id_Usuario",$_SESSION['id']);
							$stmt->bindParam(":total_aplicar", $monto);
							$stmt->execute();
						}
					}
					

              
					
				  
					
				}
			} 
			
			else {
				// Cuando $valor tiene más de un valor
				$ids_array = implode(",", $valor); // Convierte el array en una cadena de IDs separados por comas
				if($datos['anio']<2017) {
					$stmt = $pdo->prepare("SELECT  ar.Categoria as categoria,
															p.Area_Construccion as area_construccion,
															ar.Monto as monto,
															p.Id_Predio as id_predio
														FROM predio p 
														INNER JOIN propietario pro on pro.Id_Predio=p.Id_Predio 
														inner join anio an on an.Id_Anio=p.Id_Anio 
														INNER JOIN arbitrios ar on p.Id_Arbitrios=ar.Id_Arbitrios  
														WHERE pro.Id_Contribuyente IN ($ids_array) and an.NomAnio=:anio and  pro.Baja='1' $where
														GROUP BY p.ID_Predio HAVING COUNT(DISTINCT pro.ID_Contribuyente) = " . count($valor));
					$stmt->bindParam(":anio", $datos['anio']);
					$stmt->execute();
				}
				else{
					$stmt = $pdo->prepare("CREATE TEMPORARY TABLE temp_arbitrios AS SELECT Id_Arbitrios,sum(Monto) as monto FROM tasa_arbitrio t 
						                    INNER JOIN anio  a  on  a.Id_Anio=t.Id_anio
											where a.NomAnio=:anio
											GROUP BY Id_Arbitrios");
					$stmt->bindParam(":anio", $datos['anio']);
				    $stmt->execute();
                    $stmt = $pdo->prepare("SELECT  ab.Categoria as categoria,
															p.Area_Construccion as area_construccion,
															ar.Monto as monto,
															p.Id_Predio as id_predio
														FROM predio p 
														INNER JOIN propietario pro on pro.Id_Predio=p.Id_Predio 
														inner join anio an on an.Id_Anio=p.Id_Anio 
														INNER JOIN temp_arbitrios ar on p.Id_Arbitrios=ar.Id_Arbitrios 
														INNER JOIN arbitrios ab ON ab.Id_Arbitrios=ar.Id_Arbitrios 
														WHERE pro.Id_Contribuyente IN ($ids_array) and an.NomAnio=:anio and pro.Baja='1'  $where
														GROUP BY p.ID_Predio HAVING COUNT(DISTINCT pro.ID_Contribuyente) = " . count($valor));
					$stmt->bindParam(":anio", $datos['anio']);
					$stmt->execute();
				}
				$campos = $stmt->fetchall();

				foreach ($campos as $campo) {

					if ($campo['area_construccion'] == 0) {
						
						if($datos['anio']>2016){
							if ($campo['categoria'] === 'A') {
								$campo['monto'] = 5;
							} elseif ($campo['categoria'] === 'B') {
								$campo['monto'] = 4;
							} else {
								$campo['monto'] = 3;
							}
							for ($i = 0; $i < count($periodo); $i++) {
								$monto = $campo['monto'] * 3;
								$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
								(Id_Predio,
								Tipo_Tributo,
								Periodo,
								Importe,
								Gasto_Emision, 
								Saldo,
								TIM,
								TIM_Descuento,
								TIM_Aplicar,   
								Total, 
								Estado, 
								Concatenado_idc,
								Anio,
								Id_Usuario,
								Descuento,
								Total_Aplicar) 
								VALUES 
								(:id_predio,
								'742', 
								:periodo, 
								:impuesto_trimestral,
								0, 
								:saldo,
								0,
								0,
								0,  
								:total, 
								'D', 
								:ids, 
								:anio,
								:Id_Usuario,
								0,
								:total_aplicar)");
								$stmt->bindParam(":id_predio", $campo['id_predio']);
								$stmt->bindParam(":periodo", $periodo[$i]);
								$stmt->bindParam(":impuesto_trimestral", $monto);
								$stmt->bindParam(":saldo", $monto);
								$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
								$stmt->bindParam(":ids", $ids);
								$stmt->bindParam(":anio", $datos['anio']);
								 $stmt->bindParam(":Id_Usuario", $_SESSION['id']);
								$stmt->bindParam(":total_aplicar", $monto);
								$stmt->execute();
							}
					    }
							else{
									if ($campo['categoria'] === 'A') {
										$campo['monto'] = 5;
									} elseif ($campo['categoria'] === 'B') {
										$campo['monto'] = 4;
									} else {
										$campo['monto'] = 3;
									}
									for ($i = 0; $i < count($periodo); $i++) {
										$monto = $campo['monto'] * 3;
										$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
										(Id_Predio,
										Tipo_Tributo,
										Periodo,
										Importe,
										Gasto_Emision, 
										Saldo,
										TIM,
										TIM_Descuento,
										TIM_Aplicar,   
										Total, 
										Estado, 
										Concatenado_idc,
										Anio,
										Id_Usuario,
										Descuento,
										Total_Aplicar) 
										VALUES 
										(:id_predio,
										'742', 
										:periodo, 
										:impuesto_trimestral,
										0, 
										:saldo,
										0,
										0,
										0,  
										:total, 
										'D', 
										:ids, 
										:anio,
										:Id_Usuario,
										0,
										:total_aplicar)");
										$stmt->bindParam(":id_predio", $campo['id_predio']);
										$stmt->bindParam(":periodo", $periodo[$i]);
										$stmt->bindParam(":impuesto_trimestral", $monto);
										$stmt->bindParam(":saldo", $monto);
										$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
										$stmt->bindParam(":ids", $ids);
										$stmt->bindParam(":anio", $datos['anio']);
										$stmt->bindParam(":Id_Usuario", $_SESSION['id']);
										$stmt->bindParam(":total_aplicar", $monto);
										$stmt->execute();
							}
					    }


					}
					else{
						for ($i = 0; $i < count($periodo); $i++) {
							$monto = $campo['monto'] * 3;
							$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
							(Id_Predio,
							Tipo_Tributo,
							Periodo,
							Importe,
							Gasto_Emision, 
							Saldo,
							TIM,
							TIM_Descuento,
							TIM_Aplicar,   
							Total, 
							Estado, 
							Concatenado_idc,
							Anio,
							Id_Usuario,
							Descuento,
							Total_Aplicar) 
							VALUES 
							(:id_predio,
							'742', 
							:periodo, 
							:impuesto_trimestral,
							0, 
							:saldo,
							0,
							0,
							0,  
							:total, 
							'D', 
							:ids, 
							:anio,
							:Id_Usuario,
							0,
							:total_aplicar)");
							$stmt->bindParam(":id_predio", $campo['id_predio']);
							$stmt->bindParam(":periodo", $periodo[$i]);
							$stmt->bindParam(":impuesto_trimestral", $monto);
							$stmt->bindParam(":saldo", $monto);
							$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
							$stmt->bindParam(":ids", $ids);
							$stmt->bindParam(":anio", $datos['anio']);
							 $stmt->bindParam(":Id_Usuario", $_SESSION['id']);
							$stmt->bindParam(":total_aplicar", $monto);
							$stmt->execute();
						}
					}
					
				}
			}




			$saldo = 5;
				$gasto_emision = 5;

				$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente
									(Tipo_Tributo,
										Periodo, 
										Importe, 
										Gasto_Emision, 
										Saldo,
										TIM,
										TIM_Descuento,
										TIM_Aplicar,    
										Total,
										Estado, 
										Concatenado_idc, 
										Anio, 
										Id_Usuario,
										Descuento,
										Total_Aplicar,
										Autovaluo) 
									VALUES 
									('006', 
										1, 
										0, 
										:gasto_emision, 
										:saldo,
										0,
										0,
										0, 
										:total,
										'D', 
										:ids, 
										:anio, 
										:Id_Usuario,
										0,
										:total_aplicar,
										:autovaluo)");

				$stmt->bindParam(":gasto_emision", $gasto_emision);
				$stmt->bindParam(":saldo", $saldo);
				$stmt->bindParam(":total", $saldo); // En este caso, total es igual a saldo
				$stmt->bindParam(":ids", $ids);
				$stmt->bindParam(":anio", $datos['anio']);
				$stmt->bindParam(":Id_Usuario", $_SESSION['id']);
				$stmt->bindParam(":total_aplicar", $saldo); 
				$stmt->bindParam(":autovaluo", $datos['base_imponible']); 

				$stmt->execute();



		
			
			
			
			return 'ok';
		} catch (Exception $excepcion) {
			// Manejo de la excepción
			echo "Se ha producido un error: " . $excepcion->getMessage();
		}
	}

	//REGISTRAR IMPUESTO CALCULAD EXONERADOADULTO PENSIONISTA
	public static function mdlRegistrarimpuestoExoneradoPencionista($datos)
	{
	
		try {
			$pdo = Conexion::conectar();
			$valor = explode('-', $datos['contribuyente']); //CONVIERTE EN UN ARRAY
			sort($valor);
			$ids = implode("-", $valor); //CONVIERTE EN UN STRING
			$periodo = array(1, 2, 3, 4);
			$periodoUnPerido=array(1);
			//ARBITRIOS 
			
			//OBTENER ID PREDIOS
			if($datos["predio_select"]=='si'){
				$array = explode(',', $datos["predios_seleccionados"]); // ['3', '45']
                $array_numeros = array_map('intval', $array); // [3, 45]
				$cadena_numeros = implode(',', $array_numeros); // '3,45'
				$where = "AND p.Id_Predio IN (".$cadena_numeros.")";
			}
			
			else{
                $where="";
			}


			//UN SOLO CONTRIBUYENTE
			if (count($valor) === 1) {

				// Cuando $valor tiene un solo valor
				if($datos['anio']<2017) {

						$stmt = $pdo->prepare("SELECT ar.Categoria as categoria,
																p.Area_Construccion as area_construccion,
																p.Id_Predio as id_predio,
																ar.Monto as monto 
																FROM predio p 
																INNER JOIN propietario pro on pro.Id_Predio=p.Id_Predio 
																inner join anio an on an.Id_Anio=p.Id_Anio 
																INNER JOIN arbitrios ar on p.Id_Arbitrios=ar.Id_Arbitrios 
																WHERE pro.Id_Contribuyente=:id and an.NomAnio=:anio 
																AND p.ID_Predio NOT IN (SELECT ID_Predio FROM Propietario 
																WHERE ID_Contribuyente <>:id AND pro.Baja='1')and pro.Baja='1' $where ;");
						$stmt->bindParam(":id", $valor[0]);
						$stmt->bindParam(":anio", $datos['anio']);
						$stmt->execute();
				}

				else{
						$stmt = $pdo->prepare("SELECT ar.Categoria as categoria,
											p.Area_Construccion as area_construccion,
											p.Id_Predio as id_predio,
											SUM(t.Monto) as monto 
											FROM predio p 
											INNER JOIN propietario pro on pro.Id_Predio=p.Id_Predio 
											inner join anio an on an.Id_Anio=p.Id_Anio 
											INNER JOIN arbitrios ar on p.Id_Arbitrios=ar.Id_Arbitrios
											INNER JOIN tasa_arbitrio t on t.Id_Arbitrios=ar.Id_Arbitrios AND t.Id_Anio=an.Id_Anio
											WHERE pro.Id_Contribuyente=:id and an.NomAnio=:anio 
											AND p.ID_Predio NOT IN (SELECT ID_Predio FROM Propietario 
											WHERE ID_Contribuyente <>:id AND Baja='1')
											and pro.Baja='1' $where
											GROUP BY p.Id_Predio;");
						$stmt->bindParam(":id", $valor[0]);
						$stmt->bindParam(":anio", $datos['anio']);
						$stmt->execute();
				}
				$campos = $stmt->fetchall();

				foreach ($campos as $campo) {

					// SIN AREA DE CONSTRUCCION
					if ($campo['area_construccion'] == 0) {

						if($datos['anio']>2016){

							if ($campo['categoria'] === 'A') {

								$campo['monto'] = 5;

							} elseif ($campo['categoria'] === 'B') {

								$campo['monto'] = 4;

							} else {

								$campo['monto'] = 3;
								
							}

							for ($i = 0; $i < count($periodo); $i++) {
								$monto = $campo['monto']*3;
								$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
								(Id_Predio,
								Tipo_Tributo, 
								Periodo, 
								Importe, 
								Gasto_Emision, 
								Saldo,
								TIM,
								TIM_Descuento,
								TIM_Aplicar,  
								Total, 
								Estado, 
								Concatenado_idc, 
								Anio,
								Id_Usuario,
								Descuento,
								Total_Aplicar) 
								VALUES 
								(:id_predio,
								'742', 
								:periodo, 
								:impuesto_trimestral,
								0, 
								:saldo,
								0,
								0,
								0, 
								:total, 
								'D', 
								:ids, 
								:anio, 
								:Id_Usuario,
								0,
								:total_aplicar)");
								$stmt->bindParam(":id_predio", $campo['id_predio']);
								$stmt->bindParam(":periodo", $periodo[$i]);
								$stmt->bindParam(":impuesto_trimestral", $monto);
								$stmt->bindParam(":saldo", $monto);
								$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
								$stmt->bindParam(":ids", $ids);
								$stmt->bindParam(":anio", $datos['anio']);
								 $stmt->bindParam(":Id_Usuario",$_SESSION['id']);
								$stmt->bindParam(":total_aplicar", $monto);
								$stmt->execute();
							}

						}
						else{

							if ($campo['categoria'] === 'A') {

								$campo['monto'] = 5;

							} elseif ($campo['categoria'] === 'B') {

								$campo['monto'] = 4;

							} else {

								$campo['monto'] = 3;
								
							}

							for ($i = 0; $i < count($periodo); $i++) {
								$monto = $campo['monto'];
								$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
								(Id_Predio,
								Tipo_Tributo, 
								Periodo, 
								Importe, 
								Gasto_Emision, 
								Saldo,
								TIM,
								TIM_Descuento,
								TIM_Aplicar,  
								Total, 
								Estado, 
								Concatenado_idc, 
								Anio,
								Id_Usuario,
								Descuento,
								Total_Aplicar) 
								VALUES 
								(:id_predio,
								'742', 
								:periodo, 
								:impuesto_trimestral,
								0, 
								:saldo,
								0,
								0,
								0, 
								:total, 
								'D', 
								:ids, 
								:anio, 
								:Id_Usuario,
								0,
								:total_aplicar)");
								$stmt->bindParam(":id_predio", $campo['id_predio']);
								$stmt->bindParam(":periodo", $periodo[$i]);
								$stmt->bindParam(":impuesto_trimestral", $monto);
								$stmt->bindParam(":saldo", $monto);
								$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
								$stmt->bindParam(":ids", $ids);
								$stmt->bindParam(":anio", $datos['anio']);
								 $stmt->bindParam(":Id_Usuario",$_SESSION['id']);
								$stmt->bindParam(":total_aplicar", $monto);
								$stmt->execute();
							}

						}
					}
					else{
						for ($i = 0; $i < count($periodo); $i++) {
							$monto = $campo['monto']*3;
							$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
							(Id_Predio,
							Tipo_Tributo, 
							Periodo, 
							Importe, 
							Gasto_Emision, 
							Saldo,
							TIM,
							TIM_Descuento,
							TIM_Aplicar,  
							Total, 
							Estado, 
							Concatenado_idc, 
							Anio,
							Id_Usuario,
							Descuento,
							Total_Aplicar) 
							VALUES 
							(:id_predio,
							'742', 
							:periodo, 
							:impuesto_trimestral,
							0, 
							:saldo,
							0,
							0,
							0, 
							:total, 
							'D', 
							:ids, 
							:anio, 
							:Id_Usuario,
							0,
							:total_aplicar)");
							$stmt->bindParam(":id_predio", $campo['id_predio']);
							$stmt->bindParam(":periodo", $periodo[$i]);
							$stmt->bindParam(":impuesto_trimestral", $monto);
							$stmt->bindParam(":saldo", $monto);
							$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
							$stmt->bindParam(":ids", $ids);
							$stmt->bindParam(":anio", $datos['anio']);
							 $stmt->bindParam(":Id_Usuario",$_SESSION['id']);
							$stmt->bindParam(":total_aplicar", $monto);
							$stmt->execute();
						}
					}
					

              
					
				  
					
				}
			} 
			
			else {
				// Cuando $valor tiene más de un valor
				$ids_array = implode(",", $valor); // Convierte el array en una cadena de IDs separados por comas
				if($datos['anio']<2017) {
					$stmt = $pdo->prepare("SELECT  ar.Categoria as categoria,
															p.Area_Construccion as area_construccion,
															ar.Monto as monto,
															p.Id_Predio as id_predio
														FROM predio p 
														INNER JOIN propietario pro on pro.Id_Predio=p.Id_Predio 
														inner join anio an on an.Id_Anio=p.Id_Anio 
														INNER JOIN arbitrios ar on p.Id_Arbitrios=ar.Id_Arbitrios  
														WHERE pro.Id_Contribuyente IN ($ids_array) and an.NomAnio=:anio and  pro.Baja='1' $where
														GROUP BY p.ID_Predio HAVING COUNT(DISTINCT pro.ID_Contribuyente) = " . count($valor));
					$stmt->bindParam(":anio", $datos['anio']);
					$stmt->execute();
				}
				else{
					$stmt = $pdo->prepare("CREATE TEMPORARY TABLE temp_arbitrios AS SELECT Id_Arbitrios,sum(Monto) as monto FROM tasa_arbitrio t 
						                    INNER JOIN anio  a  on  a.Id_Anio=t.Id_anio
											where a.NomAnio=:anio
											GROUP BY Id_Arbitrios");
					$stmt->bindParam(":anio", $datos['anio']);
				    $stmt->execute();
                    $stmt = $pdo->prepare("SELECT  ab.Categoria as categoria,
															p.Area_Construccion as area_construccion,
															ar.Monto as monto,
															p.Id_Predio as id_predio
														FROM predio p 
														INNER JOIN propietario pro on pro.Id_Predio=p.Id_Predio 
														inner join anio an on an.Id_Anio=p.Id_Anio 
														INNER JOIN temp_arbitrios ar on p.Id_Arbitrios=ar.Id_Arbitrios 
														INNER JOIN arbitrios ab ON ab.Id_Arbitrios=ar.Id_Arbitrios 
														WHERE pro.Id_Contribuyente IN ($ids_array) and an.NomAnio=:anio and pro.Baja='1'  $where
														GROUP BY p.ID_Predio HAVING COUNT(DISTINCT pro.ID_Contribuyente) = " . count($valor));
					$stmt->bindParam(":anio", $datos['anio']);
					$stmt->execute();
				}
				$campos = $stmt->fetchall();

				foreach ($campos as $campo) {

					if ($campo['area_construccion'] == 0) {
						
						if($datos['anio']>2016){
							if ($campo['categoria'] === 'A') {
								$campo['monto'] = 5;
							} elseif ($campo['categoria'] === 'B') {
								$campo['monto'] = 4;
							} else {
								$campo['monto'] = 3;
							}
							for ($i = 0; $i < count($periodo); $i++) {
								$monto = $campo['monto'] * 3;
								$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
								(Id_Predio,
								Tipo_Tributo,
								Periodo,
								Importe,
								Gasto_Emision, 
								Saldo,
								TIM,
								TIM_Descuento,
								TIM_Aplicar,   
								Total, 
								Estado, 
								Concatenado_idc,
								Anio,
								Id_Usuario,
								Descuento,
								Total_Aplicar) 
								VALUES 
								(:id_predio,
								'742', 
								:periodo, 
								:impuesto_trimestral,
								0, 
								:saldo,
								0,
								0,
								0,  
								:total, 
								'D', 
								:ids, 
								:anio,
								:Id_Usuario,
								0,
								:total_aplicar)");
								$stmt->bindParam(":id_predio", $campo['id_predio']);
								$stmt->bindParam(":periodo", $periodo[$i]);
								$stmt->bindParam(":impuesto_trimestral", $monto);
								$stmt->bindParam(":saldo", $monto);
								$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
								$stmt->bindParam(":ids", $ids);
								$stmt->bindParam(":anio", $datos['anio']);
								 $stmt->bindParam(":Id_Usuario", $_SESSION['id']);
								$stmt->bindParam(":total_aplicar", $monto);
								$stmt->execute();
							}
					    }
							else{
									if ($campo['categoria'] === 'A') {
										$campo['monto'] = 5;
									} elseif ($campo['categoria'] === 'B') {
										$campo['monto'] = 4;
									} else {
										$campo['monto'] = 3;
									}
									for ($i = 0; $i < count($periodo); $i++) {
										$monto = $campo['monto'] * 3;
										$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
										(Id_Predio,
										Tipo_Tributo,
										Periodo,
										Importe,
										Gasto_Emision, 
										Saldo,
										TIM,
										TIM_Descuento,
										TIM_Aplicar,   
										Total, 
										Estado, 
										Concatenado_idc,
										Anio,
										Id_Usuario,
										Descuento,
										Total_Aplicar) 
										VALUES 
										(:id_predio,
										'742', 
										:periodo, 
										:impuesto_trimestral,
										0, 
										:saldo,
										0,
										0,
										0,  
										:total, 
										'D', 
										:ids, 
										:anio,
										:Id_Usuario,
										0,
										:total_aplicar)");
										$stmt->bindParam(":id_predio", $campo['id_predio']);
										$stmt->bindParam(":periodo", $periodo[$i]);
										$stmt->bindParam(":impuesto_trimestral", $monto);
										$stmt->bindParam(":saldo", $monto);
										$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
										$stmt->bindParam(":ids", $ids);
										$stmt->bindParam(":anio", $datos['anio']);
										$stmt->bindParam(":Id_Usuario", $_SESSION['id']);
										$stmt->bindParam(":total_aplicar", $monto);
										$stmt->execute();
							}
					    }


					}
					else{
						for ($i = 0; $i < count($periodo); $i++) {
							$monto = $campo['monto'] * 3;
							$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
							(Id_Predio,
							Tipo_Tributo,
							Periodo,
							Importe,
							Gasto_Emision, 
							Saldo,
							TIM,
							TIM_Descuento,
							TIM_Aplicar,   
							Total, 
							Estado, 
							Concatenado_idc,
							Anio,
							Id_Usuario,
							Descuento,
							Total_Aplicar) 
							VALUES 
							(:id_predio,
							'742', 
							:periodo, 
							:impuesto_trimestral,
							0, 
							:saldo,
							0,
							0,
							0,  
							:total, 
							'D', 
							:ids, 
							:anio,
							:Id_Usuario,
							0,
							:total_aplicar)");
							$stmt->bindParam(":id_predio", $campo['id_predio']);
							$stmt->bindParam(":periodo", $periodo[$i]);
							$stmt->bindParam(":impuesto_trimestral", $monto);
							$stmt->bindParam(":saldo", $monto);
							$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
							$stmt->bindParam(":ids", $ids);
							$stmt->bindParam(":anio", $datos['anio']);
							 $stmt->bindParam(":Id_Usuario", $_SESSION['id']);
							$stmt->bindParam(":total_aplicar", $monto);
							$stmt->execute();
						}
					}
					
				}
			}




			$saldo = 5;
				$gasto_emision = 5;

				$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente
									(Tipo_Tributo,
										Periodo, 
										Importe, 
										Gasto_Emision, 
										Saldo,
										TIM,
										TIM_Descuento,
										TIM_Aplicar,    
										Total,
										Estado, 
										Concatenado_idc, 
										Anio, 
										Id_Usuario,
										Descuento,
										Total_Aplicar,
										Autovaluo) 
									VALUES 
									('006', 
										1, 
										0, 
										:gasto_emision, 
										:saldo,
										0,
										0,
										0, 
										:total,
										'D', 
										:ids, 
										:anio, 
										:Id_Usuario,
										0,
										:total_aplicar,
										:autovaluo)");

				$stmt->bindParam(":gasto_emision", $gasto_emision);
				$stmt->bindParam(":saldo", $saldo);
				$stmt->bindParam(":total", $saldo); // En este caso, total es igual a saldo
				$stmt->bindParam(":ids", $ids);
				$stmt->bindParam(":anio", $datos['anio']);
				$stmt->bindParam(":Id_Usuario", $_SESSION['id']);
				$stmt->bindParam(":total_aplicar", $saldo); 
				$stmt->bindParam(":autovaluo", $datos['base_imponible']); 

				$stmt->execute();



		
			
			
			
			return 'ok';
		} catch (Exception $excepcion) {
			// Manejo de la excepción
			echo "Se ha producido un error: " . $excepcion->getMessage();
		}
	}
	

	//Registrar impuesto calculado ///////////////////////AFECTO///////////////////////////
	public static function mdlRegistrarimpuesto($datos)
	{
	
		try {
			$pdo = Conexion::conectar();
			$valor = explode('-', $datos['contribuyente']); //CONVIERTE EN UN ARRAY
			sort($valor);
			$ids = implode("-", $valor); //CONVIERTE EN UN STRING
			$periodo = array(1, 2, 3, 4);
			

			//SELECIONAN LOS PREDIOS SELECCIONADOS
			if($datos["predio_select"]=='si'){
				$array = explode(',', $datos["predios_seleccionados"]); // ['3', '45']
                $array_numeros = array_map('intval', $array); // [3, 45]
				$cadena_numeros = implode(',', $array_numeros); // '3,45'
				$where = "AND p.Id_Predio IN (".$cadena_numeros.")";
			}
			
			else{
                $where="";
			}


			//UN SOLO CONTRIBUYENTE
			if (count($valor) === 1) {
				
				
				//AÑO QUE VIENE MENOS 2017
				if($datos['anio']<2017) {

						$stmt = $pdo->prepare("SELECT ar.Categoria as categoria,
																p.Area_Construccion as area_construccion,
																p.Id_Predio as id_predio,
																ar.Monto as monto 
																FROM predio p 
																INNER JOIN propietario pro on pro.Id_Predio=p.Id_Predio 
																inner join anio an on an.Id_Anio=p.Id_Anio 
																INNER JOIN arbitrios ar on p.Id_Arbitrios=ar.Id_Arbitrios 
																WHERE pro.Id_Contribuyente=:id and an.NomAnio=:anio 
																AND p.ID_Predio NOT IN (SELECT ID_Predio FROM Propietario 
																WHERE ID_Contribuyente <>:id AND pro.Baja='1')and pro.Baja='1' $where ;");
						$stmt->bindParam(":id", $valor[0]);
						$stmt->bindParam(":anio", $datos['anio']);
						$stmt->execute();
				}
				
				//MAYOR DE 17
				else{
						$stmt = $pdo->prepare("SELECT ar.Categoria as categoria,
											p.Area_Construccion as area_construccion,
											p.Id_Predio as id_predio,
											SUM(t.Monto) as monto 
											FROM predio p 
											INNER JOIN propietario pro on pro.Id_Predio=p.Id_Predio 
											inner join anio an on an.Id_Anio=p.Id_Anio 
											INNER JOIN arbitrios ar on p.Id_Arbitrios=ar.Id_Arbitrios
											INNER JOIN tasa_arbitrio t on t.Id_Arbitrios=ar.Id_Arbitrios AND t.Id_Anio=an.Id_Anio
											WHERE pro.Id_Contribuyente=:id and an.NomAnio=:anio 
											AND p.ID_Predio NOT IN (SELECT ID_Predio FROM Propietario 
											WHERE ID_Contribuyente <>:id AND Baja='1')
											and pro.Baja='1' $where
											GROUP BY p.Id_Predio;");
						$stmt->bindParam(":id", $valor[0]);
						$stmt->bindParam(":anio", $datos['anio']);
						$stmt->execute();
				}



				$campos = $stmt->fetchall();

				

			
				foreach ($campos as $campo) {


					//PREDIO SIN AREA CONSTRUIDA
					if ($campo['area_construccion'] == 0) {

						if($datos['anio']>2016){


							if ($campo['categoria'] === 'A') {

								$campo['monto'] = 5;

							} elseif ($campo['categoria'] === 'B') {

								$campo['monto'] = 4;

							} else {

								$campo['monto'] = 3;

							}

							for ($i = 0; $i < count($periodo); $i++) {
								
								$monto = $campo['monto']*3;
								$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
								(Id_Predio,
								Tipo_Tributo, 
								Periodo, 
								Importe, 
								Gasto_Emision, 
								Saldo,
								TIM,
								TIM_Descuento,
								TIM_Aplicar,  
								Total, 
								Estado, 
								Concatenado_idc, 
								Anio,
								Id_Usuario,
								Descuento,
								Total_Aplicar) 
								VALUES 
								(:id_predio,
								'742', 
								:periodo, 
								:impuesto_trimestral,
								0, 
								:saldo,
								0,
								0,
								0, 
								:total, 
								'D', 
								:ids, 
								:anio, 
								:Id_Usuario,
								0,
								:total_aplicar)");
								$stmt->bindParam(":id_predio", $campo['id_predio']);
								$stmt->bindParam(":periodo", $periodo[$i]);
								$stmt->bindParam(":impuesto_trimestral", $monto);
								$stmt->bindParam(":saldo", $monto);
								$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
								$stmt->bindParam(":ids", $ids);
								$stmt->bindParam(":anio", $datos['anio']);
								 $stmt->bindParam(":Id_Usuario",$_SESSION['id']);
								$stmt->bindParam(":total_aplicar", $monto);
								$stmt->execute();
							}

						}
						else{

							if ($campo['categoria'] === 'A') {

								$campo['monto'] = 5;

							} elseif ($campo['categoria'] === 'B') {

								$campo['monto'] = 4;

							} else {

								$campo['monto'] = 3;

							}

							for ($i = 0; $i < count($periodo); $i++) {
								$monto = $campo['monto']*3;
								$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
								(Id_Predio,
								Tipo_Tributo, 
								Periodo, 
								Importe, 
								Gasto_Emision, 
								Saldo,
								TIM,
								TIM_Descuento,
								TIM_Aplicar,  
								Total, 
								Estado, 
								Concatenado_idc, 
								Anio,
								Id_Usuario,
								Descuento,
								Total_Aplicar) 
								VALUES 
								(:id_predio,
								'742', 
								:periodo, 
								:impuesto_trimestral,
								0, 
								:saldo,
								0,
								0,
								0, 
								:total, 
								'D', 
								:ids, 
								:anio, 
								:Id_Usuario,
								0,
								:total_aplicar)");
								$stmt->bindParam(":id_predio", $campo['id_predio']);
								$stmt->bindParam(":periodo", $periodo[$i]);
								$stmt->bindParam(":impuesto_trimestral", $monto);
								$stmt->bindParam(":saldo", $monto);
								$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
								$stmt->bindParam(":ids", $ids);
								$stmt->bindParam(":anio", $datos['anio']);
								 $stmt->bindParam(":Id_Usuario",$_SESSION['id']);
								$stmt->bindParam(":total_aplicar", $monto);
								$stmt->execute();
							}

						}
					}

					// //PREDIO CON AREA CONSTRUIDA
					else{
						for ($i = 0; $i < count($periodo); $i++) {
							$monto = $campo['monto']*3;
							$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
							(Id_Predio,
							Tipo_Tributo, 
							Periodo, 
							Importe, 
							Gasto_Emision, 
							Saldo,
							TIM,
							TIM_Descuento,
							TIM_Aplicar,  
							Total, 
							Estado, 
							Concatenado_idc, 
							Anio,
							Id_Usuario,
							Descuento,
							Total_Aplicar) 
							VALUES 
							(:id_predio,
							'742', 
							:periodo, 
							:impuesto_trimestral,
							0, 
							:saldo,
							0,
							0,
							0, 
							:total, 
							'D', 
							:ids, 
							:anio, 
							:Id_Usuario,
							0,
							:total_aplicar)");
							$stmt->bindParam(":id_predio", $campo['id_predio']);
							$stmt->bindParam(":periodo", $periodo[$i]);
							$stmt->bindParam(":impuesto_trimestral", $monto);
							$stmt->bindParam(":saldo", $monto);
							$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
							$stmt->bindParam(":ids", $ids);
							$stmt->bindParam(":anio", $datos['anio']);
							 $stmt->bindParam(":Id_Usuario",$_SESSION['id']);
							$stmt->bindParam(":total_aplicar", $monto);
							$stmt->execute();
						}
					}
					

              
					
				  
					
				}
			} 
			
			// VARIOS CONTRIBUYENTES
			else {

				
				// Cuando $valor tiene más de un valor
				$ids_array = implode(",", $valor); // Convierte el array en una cadena de IDs separados por comas
				
				//MENOR QUE AÑO 2017
				if($datos['anio']<2017) {
					$stmt = $pdo->prepare("SELECT  ar.Categoria as categoria,
															p.Area_Construccion as area_construccion,
															ar.Monto as monto,
															p.Id_Predio as id_predio
														FROM predio p 
														INNER JOIN propietario pro on pro.Id_Predio=p.Id_Predio 
														inner join anio an on an.Id_Anio=p.Id_Anio 
														INNER JOIN arbitrios ar on p.Id_Arbitrios=ar.Id_Arbitrios  
														WHERE pro.Id_Contribuyente IN ($ids_array) and an.NomAnio=:anio and  pro.Baja='1' $where
														GROUP BY p.ID_Predio HAVING COUNT(DISTINCT pro.ID_Contribuyente) = " . count($valor));
					$stmt->bindParam(":anio", $datos['anio']);
					$stmt->execute();
				}

				//MAYOR QUE AÑO 2017
				else{
					$stmt = $pdo->prepare("CREATE TEMPORARY TABLE temp_arbitrios AS SELECT Id_Arbitrios,sum(Monto) as monto FROM tasa_arbitrio t 
						                    INNER JOIN anio  a  on  a.Id_Anio=t.Id_anio
											where a.NomAnio=:anio
											GROUP BY Id_Arbitrios");
					$stmt->bindParam(":anio", $datos['anio']);
				    $stmt->execute();
                    $stmt = $pdo->prepare("SELECT  ab.Categoria as categoria,
															p.Area_Construccion as area_construccion,
															ar.Monto as monto,
															p.Id_Predio as id_predio
														FROM predio p 
														INNER JOIN propietario pro on pro.Id_Predio=p.Id_Predio 
														inner join anio an on an.Id_Anio=p.Id_Anio 
														INNER JOIN temp_arbitrios ar on p.Id_Arbitrios=ar.Id_Arbitrios 
														INNER JOIN arbitrios ab ON ab.Id_Arbitrios=ar.Id_Arbitrios 
														WHERE pro.Id_Contribuyente IN ($ids_array) and an.NomAnio=:anio and pro.Baja='1'  $where
														GROUP BY p.ID_Predio HAVING COUNT(DISTINCT pro.ID_Contribuyente) = " . count($valor));
					$stmt->bindParam(":anio", $datos['anio']);
					$stmt->execute();
				}


				$campos = $stmt->fetchall();
				foreach ($campos as $campo) {

					if ($campo['area_construccion'] == 0) {
						
						if($datos['anio']>2016){
							if ($campo['categoria'] === 'A') {
								$campo['monto'] = 5;
							} elseif ($campo['categoria'] === 'B') {
								$campo['monto'] = 4;
							} else {
								$campo['monto'] = 3;
							}
							for ($i = 0; $i < count($periodo); $i++) {
								$monto = $campo['monto'] * 3;
								$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
								(Id_Predio,
								Tipo_Tributo,
								Periodo,
								Importe,
								Gasto_Emision, 
								Saldo,
								TIM,
								TIM_Descuento,
								TIM_Aplicar,   
								Total, 
								Estado, 
								Concatenado_idc,
								Anio,
								Id_Usuario,
								Descuento,
								Total_Aplicar) 
								VALUES 
								(:id_predio,
								'742', 
								:periodo, 
								:impuesto_trimestral,
								0, 
								:saldo,
								0,
								0,
								0,  
								:total, 
								'D', 
								:ids, 
								:anio,
								:Id_Usuario,
								0,
								:total_aplicar)");
								$stmt->bindParam(":id_predio", $campo['id_predio']);
								$stmt->bindParam(":periodo", $periodo[$i]);
								$stmt->bindParam(":impuesto_trimestral", $monto);
								$stmt->bindParam(":saldo", $monto);
								$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
								$stmt->bindParam(":ids", $ids);
								$stmt->bindParam(":anio", $datos['anio']);
								 $stmt->bindParam(":Id_Usuario", $_SESSION['id']);
								$stmt->bindParam(":total_aplicar", $monto);
								$stmt->execute();
							}
					    }
					}
					else{
						for ($i = 0; $i < count($periodo); $i++) {
							$monto = $campo['monto'] * 3;
							$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
							(Id_Predio,
							Tipo_Tributo,
							Periodo,
							Importe,
							Gasto_Emision, 
							Saldo,
							TIM,
							TIM_Descuento,
							TIM_Aplicar,   
							Total, 
							Estado, 
							Concatenado_idc,
							Anio,
							Id_Usuario,
							Descuento,
							Total_Aplicar) 
							VALUES 
							(:id_predio,
							'742', 
							:periodo, 
							:impuesto_trimestral,
							0, 
							:saldo,
							0,
							0,
							0,  
							:total, 
							'D', 
							:ids, 
							:anio,
							:Id_Usuario,
							0,
							:total_aplicar)");
							$stmt->bindParam(":id_predio", $campo['id_predio']);
							$stmt->bindParam(":periodo", $periodo[$i]);
							$stmt->bindParam(":impuesto_trimestral", $monto);
							$stmt->bindParam(":saldo", $monto);
							$stmt->bindParam(":total", $monto); // En este caso, total es igual a saldo
							$stmt->bindParam(":ids", $ids);
							$stmt->bindParam(":anio", $datos['anio']);
							 $stmt->bindParam(":Id_Usuario", $_SESSION['id']);
							$stmt->bindParam(":total_aplicar", $monto);
							$stmt->execute();
						}
					}
					
				}
			}




			if ($datos['base_imponible'] == 0) {
				$saldo = $datos['impuesto_trimestral'] + $datos['gasto_emision'];
				$gasto_emision = $datos['gasto_emision'];
				$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente
				                       (Tipo_Tributo,
									    Periodo, 
										Importe, 
										Gasto_Emision, 
										Saldo,
										TIM,
										TIM_Descuento,
						                TIM_Aplicar,    
										Total,
										Estado, 
										Concatenado_idc, 
										Anio, 
										Id_Usuario,
										Descuento,
										Total_Aplicar,
										Autovaluo,) 
										VALUES 
										('006', 
										:periodo, 
										:impuesto_trimestral, 
										:gasto_emision, 
										:saldo,
										0,
										0,
										0, 
										:total,
										'D', 
										:ids, 
										:anio, 
										:Id_Usuario,
										0,
										:total_aplicar,
										:autovaluo)");
				$stmt->bindParam(":periodo", $periodo[$i]);
				$stmt->bindParam(":impuesto_trimestral", $datos['impuesto_trimestral']);
				$stmt->bindParam(":gasto_emision", $gasto_emision);
				$stmt->bindParam(":saldo", $saldo);
				$stmt->bindParam(":total", $saldo); // En este caso, total es igual a saldo
				$stmt->bindParam(":ids", $ids);
				$stmt->bindParam(":anio", $datos['anio']);
			    $stmt->bindParam(":Id_Usuario", $_SESSION['id'] );
			    $stmt->bindParam(":total_aplicar", $saldo); 
				$stmt->bindParam(":autovaluo", $datos['base_imponible']); 
				$stmt->execute();
			} else {
				for ($i = 0; $i < count($periodo); $i++) {
					if ($i == 0) {
						$saldo = $datos['impuesto_trimestral'] + $datos['gasto_emision'];
						$gasto_emision = $datos['gasto_emision'];
					} else {
						$saldo = $datos['impuesto_trimestral'];
						$gasto_emision = 0;
					}
					$stmt = $pdo->prepare("INSERT INTO estado_cuenta_corriente 
					                       (Tipo_Tributo, 
										   Periodo, 
										   Importe, 
										   Gasto_Emision, 
										   Saldo,
										   TIM,
										   TIM_Descuento,
						                   TIM_Aplicar,   
										   Total,
										   Estado, 
										   Concatenado_idc, 
										   Anio,
										   Id_Usuario,
										   Descuento,
										   Total_Aplicar,
										   Autovaluo) 
										   VALUES 
										   ('006', 
										   :periodo, 
										   :impuesto_trimestral, 
										   :gasto_emision, 
										   :saldo,
										   0,
										   0,
										   0, 
										   :total, 
										   'D', 
										   :ids, 
										   :anio,
										   :Id_Usuario,
										   0,
										   :total_aplicar,
										   :autovaluo)");
					$stmt->bindParam(":periodo", $periodo[$i]);
					$stmt->bindParam(":impuesto_trimestral", $datos['impuesto_trimestral']);
					$stmt->bindParam(":gasto_emision", $gasto_emision);
					$stmt->bindParam(":saldo", $saldo);
					$stmt->bindParam(":total", $saldo); // En este caso, total es igual a saldo
					$stmt->bindParam(":ids", $ids);
					$stmt->bindParam(":anio", $datos['anio']);
				    $stmt->bindParam(":Id_Usuario",$_SESSION['id']);
					$stmt->bindParam(":total_aplicar", $saldo);
					$stmt->bindParam(":autovaluo", $datos['base_imponible']); 
					$stmt->execute();
				}
			}
			return 'ok';
		} catch (Exception $excepcion) {
			// Manejo de la excepción
			echo "Se ha producido un error: " . $excepcion->getMessage();
		}
	}
	


	public static function mdlMostrar_calculo_impuesto($datos, $condicion, $anio_formato,$formato)
	{
		
		
		$pdo = Conexion::conectar();
		$resultados = array();
	
		if ($condicion == "nulo") {
			$valor = explode('-', $datos['contribuyente']);
			$anio_ = $datos['anio'];
		} else {
			$valor = explode(',', $datos);
			$anio_ = $anio_formato;
		}
		if($formato=="si"){
		  $predio_s="no";
		}
		else{
		  $predio_s=$datos["predios_s"];
		}
				if($predio_s!="si"){ //condiciono si solo quiere calcular predios seleccionados

									
					if (count($valor) === 1) {

						
						// Consulta para un solo contribuyente

						$stmt = $pdo->prepare("SELECT p.Id_Predio as id_predio
												FROM 
													predio p 
													
													INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
													INNER JOIN anio an ON an.Id_Anio = p.Id_Anio
													WHERE pro.Id_Contribuyente = :id
												AND an.NomAnio = $anio_
												AND p.ID_Predio NOT IN (
													SELECT Id_Predio FROM Propietario 
													WHERE ID_Contribuyente <>:id 
													AND Baja='1'
												)and pro.Baja='1'");
												$stmt->bindParam(":id", $valor[0]);
						$stmt->execute();
						$total_predio= $stmt->rowCount();

						$stmt = $pdo->prepare("SELECT p.Id_Predio as id_predio_afecto
												FROM 
													predio p 
													INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
													INNER JOIN anio an ON an.Id_Anio = p.Id_Anio
													WHERE pro.Id_Contribuyente = :id
												AND an.NomAnio = $anio_
												AND p.ID_Predio NOT IN (
													SELECT Id_Predio FROM Propietario 
													WHERE ID_Contribuyente <>:id 
													AND Baja='1'
												)and pro.Baja='1' AND p.Id_Regimen_Afecto in (2,4)");
												$stmt->bindParam(":id", $valor[0]);
						$stmt->execute();
						$total_predio_afecto= $stmt->rowCount();

						$stmt = $pdo->prepare("SELECT p.Valor_Predio_Aplicar as base_imponible
												FROM 
													predio p 
													INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
													INNER JOIN anio an ON an.Id_Anio = p.Id_Anio
													WHERE pro.Id_Contribuyente = :id
												AND an.NomAnio = $anio_
												AND p.ID_Predio NOT IN (
													SELECT Id_Predio FROM Propietario 
													WHERE ID_Contribuyente <>:id 
													AND Baja='1'
												)and pro.Baja='1' AND p.Id_Regimen_Afecto in (2,4)");
												$stmt->bindParam(":id", $valor[0]);
						$stmt->execute();
						$base_imponible = 0;
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$base_imponible += $row['base_imponible'];
						}

					} else {
						// Consulta para varios contribuyentes
						$ids = implode(",", $valor);
						//capturando el total de predios
						$stmt = $pdo->prepare("SELECT p.Id_Predio as id_predio
												FROM 
													predio p 
													
													INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
													INNER JOIN anio an ON an.Id_Anio = p.Id_Anio
													WHERE pro.Id_Contribuyente IN ($ids) and an.NomAnio=$anio_  AND pro.Baja='1' 
													GROUP BY p.ID_Predio HAVING COUNT(DISTINCT pro.ID_Contribuyente) = " . count($valor));
						$stmt->execute();
						$total_predio= $stmt->rowCount();

						$stmt = $pdo->prepare("SELECT p.Id_Predio as id_predio_afecto
												FROM 
													predio p 
													INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
													INNER JOIN anio an ON an.Id_Anio = p.Id_Anio
													WHERE pro.Id_Contribuyente IN ($ids) and an.NomAnio=$anio_  AND pro.Baja='1' 
													AND Id_Regimen_Afecto in (2,4)
													GROUP BY p.ID_Predio HAVING COUNT(DISTINCT pro.ID_Contribuyente) = " . count($valor));
						$stmt->execute();
						$total_predio_afecto= $stmt->rowCount();

						$stmt = $pdo->prepare("SELECT p.Valor_Predio_Aplicar as base_imponible
												FROM 
													predio p 
													INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
													INNER JOIN anio an ON an.Id_Anio = p.Id_Anio
													WHERE pro.Id_Contribuyente IN ($ids) and an.NomAnio=$anio_  AND pro.Baja='1' 
													AND Id_Regimen_Afecto in (2,4)
													GROUP BY p.ID_Predio HAVING COUNT(DISTINCT pro.ID_Contribuyente) = " . count($valor));
						$stmt->execute();
						$base_imponible = 0;
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$base_imponible += $row['base_imponible'];
						}

					}
				}
	

				else{
					$id_predios_seleccionados = explode(',', $datos["predios_seleccionados"]);
				// $id_predios_seleccionados=$datos["predios_seleccionados"];
					$total_predio=count($id_predios_seleccionados);
					$total_predio_afecto=count($id_predios_seleccionados);
					$predios_seleccionados_str = implode(',', $id_predios_seleccionados);
					$stmt = $pdo->prepare("SELECT sum(p.Valor_Predio_Aplicar) as base_imponible
												FROM 
													predio p 
													INNER JOIN anio an ON an.Id_Anio = p.Id_Anio
													WHERE p.Id_Predio in ($predios_seleccionados_str)
													AND Id_Regimen_Afecto in (2,4);");
						$stmt->execute();
						$base = $stmt->fetch(PDO::FETCH_ASSOC);
						$base_imponible= $base['base_imponible'];
				}
				
				// Obtener UIT
				$stmt = $pdo->prepare("SELECT u.uit as uit 
										FROM uit u 
										INNER JOIN anio a ON u.Id_Anio=a.Id_Anio 
										WHERE a.NomAnio=$anio_");
				$stmt->execute();
				$uit = $stmt->fetch(PDO::FETCH_ASSOC);
				$resultados['uit'] = $uit['uit'];
			
				// Calcular impuesto
				$impuesto_anual = 0;
				if ($base_imponible <= ($uit['uit'] * 3)) {

					$impuesto_anual = ($uit['uit'] * 3) * 0.002;

				} elseif ($base_imponible > ($uit['uit'] * 3) AND $base_imponible <= ($uit['uit'] * 15)) {
					
					$impuesto_anual = $base_imponible * 0.002;

				} elseif ($base_imponible > ($uit['uit'] * 15) AND $base_imponible <= ($uit['uit'] * 60)) {
					
					$impuesto_anual = ($uit['uit'] * 15 * 0.002) + (($base_imponible - ($uit['uit'] * 15)) * 0.006);
				
				} else {
					$impuesto_anual = ($uit['uit'] * 15 * 0.002) + (($uit['uit'] * 60 - $uit['uit'] * 15) * 0.006) + (($base_imponible - $uit['uit'] * 60) * 0.01);
				}
				$impuesto_trimestral = $impuesto_anual / 4;
				$resultados['impuesto_anual'] = round($impuesto_anual, 2);
				$resultados['impuesto_trimestral'] = round($impuesto_trimestral, 2);
				
			
				// Obtener gasto de emisión
				$stmt = $pdo->prepare("SELECT * from gastos_emision;");
				$stmt->execute();
				$gasto = $stmt->fetch(PDO::FETCH_ASSOC);
			
				$total_gasto_emision = $gasto['Gasto_Emision'];
				$i = 1;
				while ($i < $total_predio) {
					$total_gasto_emision += $gasto['Incremento'];
					$i++;
				}
				$resultados['gasto_emision'] = $total_gasto_emision;
				$resultados['total_pagar'] = $total_gasto_emision + round($impuesto_anual, 2);
				$resultados['total_predio'] = $total_predio;
				$resultados['total_predio_afecto'] = $total_predio_afecto;
				$resultados['base_imponible'] = $base_imponible;
				return $resultados;
	}


	

	//mostrar cuotas de vencimiento de arbitrios LA
	public static function mdlMostrar_cuotas_la($datos, $formato_calculo, $anio_formato, $id_predio, $propietarios)
	{
		$pdo = Conexion::conectar();
	
		if ($formato_calculo == 'calcular') {
			$valor = explode('-', $datos['contribuyente']); // CONVIERTE EN UN ARRAY
			sort($valor);
			$anio_ = $datos['anio'];
		} else {
			$valor = explode(',', $propietarios); // CONVIERTE EN UN ARRAY
			sort($valor);
			$anio_ = $anio_formato;
		}
	
		// Combina los valores en una cadena de búsqueda
		$id_str = implode('-', $valor);

		
	
		$sql = "SELECT 
					e.Periodo as Periodo,
					Fecha_Vence,
					Importe,
					Gasto_Emision,
					Total,
					Total_Aplicar,
					descuento		 
				FROM 
					estado_cuenta_corriente e
				INNER JOIN 
					cuotas_vencimiento c ON c.Periodo = e.Periodo 
				WHERE 
					Concatenado_idc = :id_str 
					AND Anio = :anio 
					AND YEAR(Fecha_Vence) = :anio 
					AND Tipo_Tributo = '742'
					AND Id_Predio=:id_predio"


					;
	
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':id_str', $id_str);
		$stmt->bindParam(':anio', $anio_);
		$stmt->bindParam(':id_predio', $id_predio);
		$stmt->execute();
	
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}	
