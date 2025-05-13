<?php

namespace Controladores;

use Modelos\ModeloContribuyente;
use Modelos\ModeloPredio;
use Conect\Conexion;
use Exception;
use PDO;

class ControladorPredio
{
	public static function ctrCrearPredio($datos)
	{
		$tabla = 'catastro';
		$respuesta = ModeloPredio::mdlNuevoPredio($tabla, $datos);
		if ($respuesta == 'ok') {
			return "OK";
		} else {
			return "ERROR";
		}
	}
	public static function ctrCrearPredioR($datos)
	{
		$respuesta = ModeloPredio::ndlNuevoPredioR($datos);
		if ($respuesta == 'ok') {
			return "OK";
		} else {
			return "ERROR";
		}
	}
	public  static function ctrListarPredio($valor,$anio)
	{
		$respuesta = ModeloPredio::mdlListarPredio($valor,$anio);
		echo $respuesta;
	}

	//HITORIAL PREDIO
	public  static function ctrListarPredio_historial($valor,$anio)
	{
		$respuesta = ModeloPredio::mdlListarPredio_historial($valor,$anio);
		echo $respuesta;
	}

	public  static function ctrListarPredioAgua($valor, $year)
	{
		$respuesta = ModeloPredio::mdlListarPredioAgua($valor, $year);
		echo $respuesta;
	}
	public  static function ctrListarPredioAgua_caja($valor, $year)
	{
		$respuesta = ModeloPredio::mdlListarPredioAgua_caja($valor, $year);
		echo $respuesta;
	}
	public static function ctrMostrarData($tabla)
	{
		$respuesta = ModeloContribuyente::mdlMostrarData($tabla);
		return $respuesta;
	}
	public static function ctrMostrarDataAnio()
	{
		$respuesta = ModeloContribuyente::mdlMostrarDataAnio();
		return $respuesta;
	}
	public static function ctrMostrarDataItems($tabla)
	{
		$Item = "R";
		$respuesta = ModeloContribuyente::ctrMostrarDataItems($tabla, $Item);
		return $respuesta;
	}
	// MOSTRAR USUARIOS|
	public static function ctrMostrarContribuyente_FLATA($item, $valor)
	{
		$tabla = 'contribuyente';
		$respuesta = ModeloContribuyente::mdlMostrarContribuyente($tabla, $item, $valor);
		return $respuesta;
	}
	// EDITAR USUARIOS|
	public static function ctrEditarContribuyente_FALTA()
	{

		if (isset($_POST["e_tipoDoc"])) {

			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["e_apellPaterno"])) {

				$tabla = "contribuyente";
				if ($_POST['valor_pen'] == True) {
					$pensionista = 1;
				} else {
					$pensionista = 0;
				}
				$datos = array(
					"Id_Contribuyente" => $_POST["idc"],
					"Documento" => $_POST["e_docIdentidad"],
					"Nombres" => $_POST["e_razon_social"],
					"Apellido_Paterno" => $_POST["e_apellPaterno"],
					"Apellido_Materno" => $_POST["e_apellMaterno"],
					"Id_Ubica_Vias_Urbano" => $_POST["idViaurbano"],
					"Numero_Ubicacion" => $_POST["e_nroUbicacion"],
					"Bloque" => $_POST["e_nrobloque"],
					"Numero_Departamento" => $_POST["e_nroDepartamento"],
					"Referencia" => $_POST["e_referencia"],
					"Telefono" => $_POST["e_telefono"],
					"Correo" => $_POST["e_correo"],
					"Pensionista" => $pensionista,
					"Observaciones" => $_POST["e_observacion"],
					"Codigo_sa" => $_POST["e_codigo_sa"],
					"Id_Tipo_Contribuyente" => $_POST["e_tipoContribuyente"],
					"Id_Condicion_Predio_Fiscal" => $_POST["e_condicionpredio"],
					"Id_Clasificacion_Contribuyente" => $_POST["e_clasificacion"],
					"Estado" => "1",
					"Coactivo" => "0",
					"Numero_Luz" => $_POST["e_nroLuz"],
					"Fecha_Modificacion" => date("Y-m-d H:i:s"),
					"Lote" => $_POST["e_nroLote"],
					"Id_Tipo_Documento" => $_POST["e_tipoDoc"],
					"usuario_Id_Usuario" => 1,
				);

				$respuesta = ModeloContribuyente::mdlEditarContribuyente($tabla, $datos);

				if ($respuesta == "ok") {

					echo "<script>
                            Swal.fire({
                                position: 'top-end',
                                title: '¡Se actualizo correctamente!',
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'OK'
                              }).then((result) => {
                               
                                  window.location = 'buscarcontribuyente';
                                
                                if(window.history.replaceState){
                                    window.history.replaceState(null,null, window.location.href);
                                    }
                              })</script>";
				} else {

					echo "<script>
                    Swal.fire({
                        title: '¡El campo no puede ir vacío o llevar caracteres especiales!',
                        text: '...',
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Cerrar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                        window.location = 'usuarios';
                        }
                    })</script>";
				}
			}
		}
	}

	
	// TRANSFERIR PREDIO
	public static function ctrTransferirPredio($datos)
	{
		$pdo = Conexion::conectar();
		$array = explode(',', $datos['propietarios_antiguos']); //CONVIERTE EN UN ARRAY
		sort($array);
		$propietarios_antiguos= implode('-', $array);
		if($datos['confirmar']=='no') {

			$stmt = $pdo->prepare("SELECT Id_Estado_Cuenta_Impuesto  
								FROM  estado_cuenta_corriente 
								WHERE Concatenado_idc=:propietarios_antiguos AND Anio=:anio AND Estado='D'");
			$stmt->bindParam(":propietarios_antiguos", $propietarios_antiguos);
			$stmt->bindParam(":anio", $datos['anio']);							   
			$stmt->execute();
			$resultados = $stmt->fetchAll();
			if ($stmt->rowCount() > 0) {
				$respuesta = array(
					'tipo' => 'advertencia_deuda',
					'mensaje' =>'<div class="alert error">
					<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
					<span aria-hidden="true" class="letra_error">×</span>
					</button><p class="inner"><strong class="letra_error">Error!</strong> <span class="letra_error">El contribuyente tiene deuda en el año <b>'.$datos['anio'].'</b></span></p></div>'
				);	
			}
			else {
						$respuesta = ModeloPredio::mdlEditarTransferirPredio($datos);
				if ($respuesta == "ok") {
						$respuesta = array(
							"tipo" => 'correcto',
							"mensaje" => '<div class="alert success">
							<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
							<span aria-hidden="true" class="letra">×</span>
							</button><p class="inner"><strong class="letra">Exito!</strong> <span class="letra">Se realizo la transferencia de forma correcta</span></p></div>'
						);
						
					} else {
						$respuesta = array(
							'tipo' => 'advertencia',
							'mensaje' =>'<div class="alert error">
							<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
							<span aria-hidden="true" class="letra_error">×</span>
							</button><p class="inner"><strong class="letra_error">Error!</strong> <span class="letra_error">
							Algo salio mal Comunicarce con el Administrador</span></p></div>'
						);
						
					}
				
			}
		}
		else{
		$respuesta = ModeloPredio::mdlEditarTransferirPredio($datos);
		if ($respuesta == "ok") {
				$respuesta = array(
					"tipo" => 'correcto',
					"mensaje" => '<div class="alert success">
					<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
					<span aria-hidden="true" class="letra">×</span>
					</button><p class="inner"><strong class="letra">Exito!</strong> <span class="letra">Se realizo la transferencia de forma correcta</span></p></div>'
				);
				
			} else {
				$respuesta = array(
					'tipo' => 'advertencia',
					'mensaje' =>'<div class="alert error">
					<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
					<span aria-hidden="true" class="letra_error">×</span>
					</button><p class="inner"><strong class="letra_error">Error!</strong> <span class="letra_error">
					Algo salio mal Comunicarce con el Administrador</span></p></div>'
				);
				
			}

		}
		return $respuesta;
	}
	// ELIMINAR PREDIO
	public static function ctrEliminarPredio($datos)
	{
		$respuesta = ModeloPredio::mdlEliminarPredio($datos);
		if ($respuesta == "ok") {
			$respuesta = array(
				"tipo" => "correcto",
				"mensaje" => '<div class="alert success">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
			<span aria-hidden="true" class="letra">×</span>
		    </button><p class="inner"><strong class="letra">Exito!</strong> <span class="letra">Se elimino el Predio de forma correcta</span></p></div>'
			
			);
			return $respuesta;
		} else {
			$respuesta = array(
				"tipo" => "error",
				"mensaje" => '<div class="alert error">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
			<span aria-hidden="true" class="letra_error">×</span>
		    </button><p class="inner"><strong class="letra_error">error!</strong> <span class="letra_error">Algo salio mal, comunicate con el Administrador</span></p></div>'
		);
			return $respuesta;
		}
	}
	// CONDICION AÑO A COPIAR
	public static function ctrCondicionCopiarPredio($datos)
	{
		$pdo = Conexion::conectar();
		$anio = $datos['anio'];
		//$stmt = $pdo->prepare("SELECT * from anio where NomAnio>$anio;");
		$stmt = $pdo->prepare("SELECT * from anio ORDER BY NomAnio DESC;");
		$stmt->execute();
		$resultados = $stmt->fetchAll();
		if ($stmt->rowCount() > 0) {
			echo '<select class=""  id="selectnum_copiar" name="selectnum_copiar">';
			foreach ($resultados as $row) {
				echo '<option value="' . $row['Id_Anio'] . '">' . $row['NomAnio'] . '</option>';
			}
			echo '</select>';
		} else {
			echo '--';
		}
	}


	// COPIAR PREDIO
	public static function ctrCopiarPredio($datos)
	{ 

		


		$catastro = $datos['id_catastro'];
		$anio_copear = $datos['anio_copiar']; 

		$pdo = Conexion::conectar();
		//NO FORSAR PREDIO
		if($datos['forzar_copear']=='noforzar'){
	       if($datos["tipo"]=="U"){
					$stmt = $pdo->prepare("SELECT Id_Predio FROM predio 
										inner join anio on anio.Id_Anio=predio.Id_Anio 
										inner join catastro ca on ca.Id_Catastro=predio.Id_Catastro 
										WHERE ca.Codigo_Catastral =:catastro and anio.NomAnio=$anio_copear");
										$stmt->bindParam(":catastro", $catastro);
					$stmt->execute();
					$id_predio = $stmt->fetch();
		   }
		   else{
					$stmt = $pdo->prepare("SELECT Id_Predio FROM predio 
					inner join anio on anio.Id_Anio=predio.Id_Anio 
					inner join catastro_rural ca on ca.Id_Catastro_Rural=predio.Id_Catastro_Rural 
					WHERE ca.Codigo_Catastral =:catastro and anio.NomAnio=$anio_copear");
					$stmt->bindParam(":catastro", $catastro);
					$stmt->execute();
					$id_predio = $stmt->fetch();
		   }
			if (($stmt->rowCount() > 0)) {
				$respuesta = array(
					'tipo' => 'advertencia',
					'mensaje' => '<div class="alert error">
					<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
			        <span aria-hidden="true" class="letra_error">×</span>
			        </button><p class="inner"><strong class="letra_error">Error!</strong> 
					<span class="letra_error">El predio ya esta registrado en el año <b> '.$anio_copear.'</b></span></p></div>'
				);
				return $respuesta;

				
		
			} else {
				$respuesta = ModeloPredio::mdlCopiarPredio($datos,'null');
				if ($respuesta == "ok") {
					$respuesta = array(
						'tipo' => 'correcto',
						'mensaje' => '<div class="alert success">
						<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
						<span aria-hidden="true" class="letra">×</span>
						</button><p class="inner"><strong class="letra">Exito!</strong> 
						<span class="letra">Se copeo con exito el predio con N° catastro <b>'.$catastro.'</b>  al año <b> '.$anio_copear.'</b></span></p></div>'
					);
					return $respuesta;
				} else {
					$respuesta = array(
						'tipo' => 'error',
						'mensaje' => '<div class="alert error">
						<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
						<span aria-hidden="true" class="letra_error">×</span>
						</button><p class="inner"><strong class="letra_error">Error!</strong> 
						<span class="letra_error">Algo salio al copear el predio al año <b> '.$anio_copear.' '.$respuesta.', comunicarce con el Administrador</b></span></p></div>'
					);
					return $respuesta;
				}
			
			}
		}

		//FORSAR PREDIO
		
		else{
            
			if($datos["tipo"]=="U"){
				$stmt = $pdo->prepare("SELECT Id_Predio FROM predio 
									inner join anio on anio.Id_Anio=predio.Id_Anio 
									inner join catastro ca on ca.Id_Catastro=predio.Id_Catastro 
									WHERE ca.Codigo_Catastral =:catastro and anio.NomAnio=$anio_copear");
									$stmt->bindParam(":catastro", $catastro);

				$stmt->execute();
				$id_predio = $stmt->fetch(PDO::FETCH_ASSOC);
				$id_predio=$id_predio['Id_Predio'];
			}
			else{
						$stmt = $pdo->prepare("SELECT Id_Predio FROM predio 
						inner join anio on anio.Id_Anio=predio.Id_Anio 
						inner join catastro_rural ca on ca.Id_Catastro_Rural=predio.Id_Catastro_Rural 
						WHERE ca.Codigo_Catastral =:catastro and anio.NomAnio=$anio_copear");
						$stmt->bindParam(":catastro", $catastro);
						$stmt->execute();
						$id_predio = $stmt->fetch(PDO::FETCH_ASSOC);
						$id_predio=$id_predio['Id_Predio'];
			}
             

            if(($stmt->rowCount() > 0)){
					$stmt = $pdo->prepare("DELETE FROM propietario  
					WHERE  Id_Predio=:id_predio ");
					$stmt->bindParam(":id_predio", $id_predio);
					$stmt->execute();

					
					$respuesta = ModeloPredio::mdlCopiarPredio($datos,$id_predio);

					var_dump($respuesta);
					
					if ($respuesta == "ok") {
							$respuesta = array(
								'tipo' => 'correcto',
								'mensaje' => '<div class="alert success">
								<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
								<span aria-hidden="true" class="letra">×</span>
								</button><p class="inner"><strong class="letra">Exito!</strong> 
								<span class="letra">Se copeo con exito el predio con N° catastro <b>'.$catastro.'</b>  al año <b> '.$anio_copear.'</b></span></p></div>'
							);
							return $respuesta;
						} else {
							$respuesta = array(
								'tipo' => 'error',
								'mensaje' => '<div class="alert error">
								<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
								<span aria-hidden="true" class="letra_error">×</span>
								</button><p class="inner"><strong class="letra_error">Error!</strong> 
								<span class="letra_error">Algo salio al copear el predio al año <b> '.$anio_copear.' '.$respuesta.', comunicarce con el Administrador</b></span></p></div>'
							);
							return $respuesta;
						}
			}
		}
		
	}


	// COPIAR PREDIO
	// public static function ctrCopiarPredio($datos)
	// { 
	// 	$catastro = $datos['id_catastro'];
	// 	$anio_copear = $datos['anio_copiar']; 

	// 	$pdo = Conexion::conectar();
	// 	if($datos['forzar_copear']=='noforzar'){
	//        if($datos["tipo"]=="U"){
	// 				$stmt = $pdo->prepare("SELECT Id_Predio FROM predio 
	// 									inner join anio on anio.Id_Anio=predio.Id_Anio 
	// 									inner join catastro ca on ca.Id_Catastro=predio.Id_Catastro 
	// 									WHERE ca.Codigo_Catastral =:catastro and anio.NomAnio=$anio_copear");
	// 									$stmt->bindParam(":catastro", $catastro);
	// 				$stmt->execute();
	// 				$id_predio = $stmt->fetch();
	// 	   }
	// 	   else{
	// 				$stmt = $pdo->prepare("SELECT Id_Predio FROM predio 
	// 				inner join anio on anio.Id_Anio=predio.Id_Anio 
	// 				inner join catastro_rural ca on ca.Id_Catastro_Rural=predio.Id_Catastro_Rural 
	// 				WHERE ca.Codigo_Catastral =:catastro and anio.NomAnio=$anio_copear");
	// 				$stmt->bindParam(":catastro", $catastro);
	// 				$stmt->execute();
	// 				$id_predio = $stmt->fetch();
	// 	   }
	// 		if (($stmt->rowCount() > 0)) {
	// 			$respuesta = array(
	// 				'tipo' => 'advertencia',
	// 				'mensaje' => '<div class="alert error">
	// 				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
	// 		        <span aria-hidden="true" class="letra_error">×</span>
	// 		        </button><p class="inner"><strong class="letra_error">Error!</strong> 
	// 				<span class="letra_error">El predio ya esta registrado en el año <b> '.$anio_copear.'</b></span></p></div>'
	// 			);
	// 			return $respuesta;

				
		
	// 		} else {
	// 			$respuesta = ModeloPredio::mdlCopiarPredio($datos,'null');
	// 			if ($respuesta == "ok") {
	// 				$respuesta = array(
	// 					'tipo' => 'correcto',
	// 					'mensaje' => '<div class="alert success">
	// 					<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
	// 					<span aria-hidden="true" class="letra">×</span>
	// 					</button><p class="inner"><strong class="letra">Exito!</strong> 
	// 					<span class="letra">Se copeo con exito el predio con N° catastro <b>'.$catastro.'</b>  al año <b> '.$anio_copear.'</b></span></p></div>'
	// 				);
	// 				return $respuesta;
	// 			} else {
	// 				$respuesta = array(
	// 					'tipo' => 'error',
	// 					'mensaje' => '<div class="alert error">
	// 					<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
	// 					<span aria-hidden="true" class="letra_error">×</span>
	// 					</button><p class="inner"><strong class="letra_error">Error!</strong> 
	// 					<span class="letra_error">Algo salio al copear el predio al año <b> '.$anio_copear.' '.$respuesta.', comunicarce con el Administrador</b></span></p></div>'
	// 				);
	// 				return $respuesta;
	// 			}
			
	// 		}
	// 	}
	// 	else{
            
	// 		if($datos["tipo"]=="U"){
	// 			$stmt = $pdo->prepare("SELECT Id_Predio FROM predio 
	// 								inner join anio on anio.Id_Anio=predio.Id_Anio 
	// 								inner join catastro ca on ca.Id_Catastro=predio.Id_Catastro 
	// 								WHERE ca.Codigo_Catastral =:catastro and anio.NomAnio=$anio_copear");
	// 								$stmt->bindParam(":catastro", $catastro);

	// 			$stmt->execute();
	// 			$id_predio = $stmt->fetch(PDO::FETCH_ASSOC);
	// 			$id_predio=$id_predio['Id_Predio'];
	// 		}
	// 		else{
	// 					$stmt = $pdo->prepare("SELECT Id_Predio FROM predio 
	// 					inner join anio on anio.Id_Anio=predio.Id_Anio 
	// 					inner join catastro_rural ca on ca.Id_Catastro_Rural=predio.Id_Catastro_Rural 
	// 					WHERE ca.Codigo_Catastral =:catastro and anio.NomAnio=$anio_copear");
	// 					$stmt->bindParam(":catastro", $catastro);
	// 					$stmt->execute();
	// 					$id_predio = $stmt->fetch(PDO::FETCH_ASSOC);
	// 					$id_predio=$id_predio['Id_Predio'];
	// 		}
             

    //         if(($stmt->rowCount() > 0)){
	// 				$stmt = $pdo->prepare("DELETE FROM propietario  
	// 				WHERE  Id_Predio=:id_predio ");
	// 				$stmt->bindParam(":id_predio", $id_predio);
	// 				$stmt->execute();

					
	// 				$respuesta = ModeloPredio::mdlCopiarPredio($datos,$id_predio);
	// 					if ($respuesta == "ok") {
	// 						$respuesta = array(
	// 							'tipo' => 'correcto',
	// 							'mensaje' => '<div class="alert success">
	// 							<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
	// 							<span aria-hidden="true" class="letra">×</span>
	// 							</button><p class="inner"><strong class="letra">Exito!</strong> 
	// 							<span class="letra">Se copeo con exito el predio con N° catastro <b>'.$catastro.'</b>  al año <b> '.$anio_copear.'</b></span></p></div>'
	// 						);
	// 						return $respuesta;
	// 					} else {
	// 						$respuesta = array(
	// 							'tipo' => 'error',
	// 							'mensaje' => '<div class="alert error">
	// 							<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
	// 							<span aria-hidden="true" class="letra_error">×</span>
	// 							</button><p class="inner"><strong class="letra_error">Error!</strong> 
	// 							<span class="letra_error">Algo salio al copear el predio al año <b> '.$anio_copear.' '.$respuesta.', comunicarce con el Administrador</b></span></p></div>'
	// 						);
	// 						return $respuesta;
	// 					}
	// 		}
	// 	}
		
	// }

	public static function ctrEliminarContribuyente()
	{
		if (isset($_GET['idContribuyente'])) {
			$tabla = 'contribuyente';
			$datos = $_GET['idContribuyente'];
			$respuesta = ModeloContribuyente::mdlBorrarContribuyente($tabla, $datos);
			if ($respuesta == 'ok') {
				echo "<script>
											Swal.fire({
											position: 'top-end',
											title: '¡El contribuyente ha sido eliminado!',
											text: '...',
											icon: 'success',
											showCancelButton: false,
											confirmButtonColor: '#3085d6',
											cancelButtonColor: '#d33',
											confirmButtonText: 'Cerrar'
							}).then((result) => {
											if (result.isConfirmed) {
											window.location = 'buscarcontribuyente';
											}
							})
							</script>";
			}
		}
	}

	
	// ELIMINAR OEDEN DE PAGO
	public static function ctrEliminarOrdenPago($valor)
	{
		//$tabla = "contribuyente";
		$respuesta = ModeloPredio::mdlEliminarORdenPago($valor);
		return $respuesta;
	}




	// BUSCAR CONTRIBUYENTE PARA EL REGISTRO DE PREDIO
	public static function ctrBucarContribuyente($valor)
	{
		$tabla = "contribuyente";
		$respuesta = ModeloPredio::mdlBuscarContribuyente($tabla, $valor);
		return $respuesta;
	}
	// LISTA DE PREDIOS PARA CALCULAR IMPUESTO
	public static function ctrPredio_impuesto($datos, $anio, $predios_arbitrio)
	{
		$respuesta = ModeloPredio::mdlPredio_impuesto($datos, $anio, $predios_arbitrio);
		echo $respuesta;
	}
	public static function crtMostrarPredio($datos)
	{
		$table = 'predio';
		$item1 = 'Id_Predio';
		$respuesta = ModeloPredio::mdlMostrarPredioT($table, $item1, $datos);
		return $respuesta;
	}
	public static function crtMostrarPropietarios($datos)
	{
		$table = 'propietario';
		$item1 = 'Id_Predio';
		$respuesta = ModeloPredio::mdlMostrarPropietarios($table, $item1, $datos);
		return $respuesta;
	}
	public static function crtMostrar_foto_carrusel($id_predio)
	{
		$respuesta = ModeloPredio::mdlMostrar_foto_carrusel($id_predio);
		return $respuesta;
	}

	

	//MODAL
	public static function crtMostrar_foto_carrusel_modal($id_predio)
	{
		$respuesta = ModeloPredio::mdlMostrar_foto_carrusel_modal($id_predio);
		return $respuesta;
	}
	
	public static function crtGuardarfoto($datos,$id_predio)
	{
		$respuesta = ModeloPredio::mdlGuardarfoto($datos,$id_predio);
		if ($respuesta === "error") {
			$respuesta = array(
				'tipo' => 'advertencia',
				'mensaje' => '<div class="alert warning">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
				<span aria-hidden="true" class="letra">×</span>
				</button><p class="inner"><strong class="letra">Exito!</strong> 
				<span class="letra">Algo salio mal comunicate con el Administrador</span></p></div>'
			);
			return $respuesta;
		} else {
			
			$respuesta = array(
				'tipo' => 'correcto',
				'mensaje' => '<div class="alert success">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
				<span aria-hidden="true" class="letra">×</span>
				</button><p class="inner"><strong class="letra">Exito!</strong> 
				<span class="letra">Se Guardo de forma correcta la imagen seleccionada</span></p></div>'
			);
			return $respuesta;
		}
	}
	public static function crtEditarPrediou($datos)
	{
		$respuesta = ModeloPredio::mdlEditarPredio($datos);
		if ($respuesta == "ok") {
			$respuesta = array(
				'tipo' => 'correcto',
				'mensaje' => '<div class="alert success">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
				<span aria-hidden="true" class="letra">×</span>
				</button><p class="inner"><strong class="letra">Exito!</strong> 
				<span class="letra">Se modifico los datos de Predio de forma Correcta</span></p></div>'
			);
			return $respuesta;
		} else {
			$respuesta = array(
				'tipo' => 'advertencia',
				'mensaje' => '<div class="alert warning">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
				<span aria-hidden="true" class="letra">×</span>
				</button><p class="inner"><strong class="letra">Exito!</strong> 
				<span class="letra">Algo salio mal comunicate con el Administrador</span></p></div>'
			);
			return $respuesta;
		}
	}
	public static function crtEditarPredioR($datos)
	{
		$respuesta = ModeloPredio::mdlEditarPredioR($datos);
		if ($respuesta == "ok") {
			$respuesta = array(
				'tipo' => 'correcto',
				'mensaje' => '<div class="alert success">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
				<span aria-hidden="true" class="letra">×</span>
				</button><p class="inner"><strong class="letra">Exito!</strong> 
				<span class="letra">Se modifico los datos de Predio de forma Correcta</span></p></div>'
			);
			return $respuesta;
		} else {
			$respuesta = array(
				'tipo' => 'advertencia',
				'mensaje' => '<div class="alert warning">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
				<span aria-hidden="true" class="letra">×</span>
				</button><p class="inner"><strong class="letra">Exito!</strong> 
				<span class="letra">Algo salio mal comunicate con el Administrador</span></p></div>'
			);
			return $respuesta;
		}
	}

	public static function crtAgregar_ContribuyentePredio($contribuyentes,$predios,$id_propietario,$carpeta)
	{
		$respuesta = ModeloPredio::mdlAgregar_ContribuyentePredio($contribuyentes,$predios,$id_propietario,$carpeta);
		return $respuesta;
	}

}
