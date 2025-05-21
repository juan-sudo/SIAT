<?php
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorPredio;

class AjaxPredio
{


	public function ajaxAgregarPredio()
	{
		$mensaje_error = "";
		if ($_POST["idAnioFiscal"] == 'null') {
			$mensaje_error = "Seleccione un año fiscal";
		} elseif (($_POST["tipoDocInscripcion"] == 'null') or ($_POST["tipoDocInscripcion"] == '')) {
			$mensaje_error = "Seleccione Tipo Documento de Inscripcion";
		} elseif (($_POST["areaTerreno"] == 'null') or ($_POST["areaTerreno"] == '') or ($_POST["areaTerreno"] == 0)) {
			$mensaje_error = "Debe Ingresar el area terreno";
		} elseif (($_POST["nroDocIns"] == 'null') or ($_POST["nroDocIns"] == '')) {
			$mensaje_error = "Ingrese Nro Documento Inscripcion";
		} elseif (($_POST["afectacionArb"] == 'null')) {
			$mensaje_error = "Seleccione Tipo Afectacion de arbitrios";
		} elseif (($_POST["tipoEscritura"] == 'null')) {
			$mensaje_error = "Seleccione Tipo documento escritura";
		} elseif (($_POST["idViaurbano"] == 'null') or ($_POST["idViaurbano"] == '')) {
			$mensaje_error = "Ingrese direccion del predio";
		} elseif (($_POST["IdContribuyente"] == 'null') or ($_POST["IdContribuyente"] == '')) {
			$mensaje_error = "Ingrese propietarios del predio ";
		} elseif (($_POST["tipoPredio"] == 'null') or ($_POST["tipoPredio"] == '')) {
			$mensaje_error = "Seleccione el Tipo predio";
		} elseif (($_POST["usoPredio"] == 'null') or ($_POST["usoPredio"] == '')) {
			$mensaje_error = "Seleccione uso del predio";
		} elseif (($_POST["estadoPredio"] == 'null') or ($_POST["estadoPredio"] == '')) {
			$mensaje_error = "Seleccione estado del predio";
		} elseif (($_POST["nroExpediente"] == 'null') or ($_POST["nroExpediente"] == '')) {
			$mensaje_error = "ingrese numero de expediente";
		} elseif (($_POST["regInafecto"] == 'null') or ($_POST["regInafecto"] == '')) {
			$mensaje_error = "Seleccione regimente de afectacion";
		} elseif (($_POST["fechaAdqui"] == 'null') or ($_POST["fechaAdqui"] == '')) {
			$mensaje_error = "Ingrese fecha de adquision";
		} elseif (($_POST["fechaEscritura"] == 'null') or ($_POST["fechaEscritura"] == '')) {
			$mensaje_error = "Ingrese fecha del documento de inscripcion";
		} elseif (($_POST["nroLote"] == '') and ($_POST["nroUbicacion"] == '') and ($_POST["codCofopri"] == '') and ($_POST["nroBloque"] == '')) {
			$mensaje_error = "Ingrese numero de ubicacion o numero lote o o numero departamento ";
		}
		if (!empty($mensaje_error)) {
		/*	$respuesta = array(
				'tipo' => 'error',
				'mensaje' => '<div class="alert alert-danger" role="alert">' . $mensaje_error . '</div>'
			);
			$respuesta_json = json_encode($respuesta);
		  header('Content-Type: application/json'); */
			echo $mensaje_error;
		} else {

			$datos = array(
				// 'Codigo_Catastral' => $codigoCatastral, // 1
				'Numero_Bloque' => $_POST["nroBloque"], //3
				'Numero_Ubicacion' => $_POST["nroUbicacion"], //4
				'Numero_Lote' => $_POST["nroLote"], //5									
				'Codigo_COFOPRI' => $_POST["codCofopri"], //7
				'Referencia' => $_POST["referenUbi"], //8
				'Id_Ubica_Vias_Urbano' => $_POST["idViaurbano"], //30
				'Numero_Departamento' => $_POST["nroDepa"], //33
				// Fecha registro
				'Fecha_Adquisicion' => $_POST["fechaAdqui"], //2
				'Numero_Luz' => $_POST["reciboLuz"], //3
				'Area_Terreno' => $_POST["areaTerreno"], //4          
				'Valor_Terreno' => $_POST["valorTerreno"], //5
				'Valor_Construccion' => $_POST["valorConstruc"], //6
				'Valor_Otras_Instalacions' => $_POST["valorOtrasIns"], //7
				'Valor_predio' => $_POST["valorPredioAnio"], //8
				'Expediente_Tramite' => $_POST["nroExpediente"], //9
				'Observaciones' => $_POST["observacion"], //10
				'predio_UR' => $_POST["tipoPredioUR"], //11
				'Area_Construccion' => $_POST["areaConstruc"], //12
				'Numero_Documento_Inscripcion' => $_POST["nroDocIns"], //13
				'Fecha_Escritura' => $_POST["fechaEscritura"], //14
				'Id_Documento_Inscripcion' => $_POST["tipoDocInscripcion"], //16      
				'Id_Tipo_Predio' => $_POST["tipoPredio"], //17
				'Id_Giro_Establecimiento' => $_POST["giroPredio"], //18
				'Id_Uso_Predio' => $_POST["usoPredio"], //19
				'Id_Estado_Predio' => $_POST["estadoPredio"], //20 
				'Id_Tipo_Escritura' => $_POST["tipoEscritura"], //21	
				'Estado_Transferencia' => 'R',  //21 R=registra O=otorgado    
				'Id_Regimen_Afecto' => $_POST["regInafecto"], //22
				'Id_inafecto' => $_POST["inafectoPor"], //23
				'Id_Arbitrios' => $_POST["afectacionArb"], //24
				'Id_Condicion_Predio' => $_POST["condicionDuenio"], //25
				'Valor_Inaf_Exo' => $_POST["valInafeExonerado"], //29
				// FechaRegistro  --> fecha actual del sistema
				'Id_Contribuyente' => $_POST["IdContribuyente"], //$_POST["codigoNpropietario"]27
				//'Id_Catastro' => '1',//28
				'Id_Anio' => $_POST["idAnioFiscal"], //29		 
				'id_usuario' => $_SESSION['id'] //30	  id_usuario        			        
			);
			$respuesta = ControladorPredio::ctrCrearPredio($datos);
		//	$respuesta_json = json_encode($respuesta);
	//		header('Content-Type: application/json');
			echo $respuesta;
		}
	}
	
	//CAMBIOS PREDIO U
	public function ajaxCambiosPredio()
	{
		$datos = array(

			'Numero_Documento_Inscripcion' => $_POST["nroDocIns"], //13+
			'Fecha_Escritura' => $_POST["fechaEscritura"], //14+
			'Id_Tipo_Escritura' => $_POST["tipoEscritura"], //21+
			'Id_Documento_Inscripcion' => $_POST["tipoDocInscripcion"], //16 +  

			'Numero_Bloque' => $_POST["nroBloque"], //3
			'Numero_Ubicacion' => $_POST["nroUbicacion"], //4
			'Numero_Lote' => $_POST["nroLote"], //5									
			'Codigo_COFOPRI' => $_POST["codCofopri"], //7
			'Referencia' => $_POST["referenUbi"], //8
			'Id_Ubica_Vias_Urbano' => $_POST["idViaurbano"], //30
			'Numero_Departamento' => $_POST["nroDepa"], //33

			'Fecha_Adquisicion' => $_POST["fechaAdqui"], //2+
			'Numero_Luz' => $_POST["reciboLuz"], //3+
			'Area_Terreno' => $_POST["areaTerreno"], //4 +
			'Valor_Terreno' => $_POST["valorTerreno"], //5+
			'Valor_Construccion' => $_POST["valorConstruc"], //6+
			'Valor_Otras_Instalacions' => $_POST["valorOtrasIns"], //7+
			'Valor_predio' => $_POST["valorPredioAnio"], //8+
			'Expediente_Tramite' => $_POST["nroExpediente"], //9+
			'Observaciones' => $_POST["observacion"], //10+
			'Area_Construccion' => $_POST["areaConstruc"], //12+

			'Id_Tipo_Predio' => $_POST["tipoPredio"], //17+
			'Id_Giro_Establecimiento' => $_POST["giroPredio"], //18+
			'Id_Uso_Predio' => $_POST["usoPredio"], //19+
			'Id_Estado_Predio' => $_POST["estadoPredio"], //20 +
			'Id_Regimen_Afecto' => $_POST["regInafecto"], //22+
			'Id_inafecto' => $_POST["inafectoPor"], //23+
			'Id_Arbitrios' => $_POST["afectacionArb"], //24+
			'Id_Condicion_Predio' => $_POST["condicionDuenio"], //25	 +
			'Id_Predio' => $_POST["idPredioE"],        //+
			'id_usuario' => $_SESSION['id'] //30	    	+		        
		);
		$respuesta = ControladorPredio::crtEditarPrediou($datos);
		header('Content-Type: application/json');
		echo json_encode($respuesta);
	}

	//CAMBIOS PREDIO R
	public function ajaxcambios_editar_predio_R()
	{

		if (($_POST["tipo_predio"] == 'null') or ($_POST["tipo_predio"] == ''))  {
			$mensaje_error = "Seleccione tipo predio";
		}
		if (!empty($mensaje_error)) {
			$respuesta = array(
				'tipo' => 'error',
				'mensaje' => '<div class="alert alert-danger" role="alert">' . $mensaje_error . '</div>'
			);
			$respuesta_json = json_encode($respuesta);
			header('Content-Type: application/json');
			echo $respuesta_json;
		} else {
			$datos = array(
				'tipo_predio_UR' => $_POST["tipo_predio_UR"], //14+
				'anio_fiscal' => $_POST["anio_fiscal"], //21+
				'tipo_doc_inscripcion' => $_POST["tipo_doc_inscripcion"], //16 +  
				'Numero_doc_inscripcion' => $_POST["Numero_doc_inscripcion"], //3
				'tipo_escritura' => $_POST["tipo_escritura"], //4
				'fecha_escritura' => $_POST["fecha_escritura"], //5		
				'Denominacion' => $_POST["denominacion"], //7
				'Colindante_Sur_Nombre' => $_POST["col_sur_nombre"], //8
				'Colindante_Sur_Denominacion' => $_POST["col_sur_sector"], //30
				'Colindante_Norte_Nombre' => $_POST["col_norte_nombre"], //33
				'Colindante_Norte_Denominacion' => $_POST["col_norte_sector"], //2+
				'Colindante_Este_Nombre' => $_POST["col_oeste_nombre"], //3+
				'Colindante_Este_Denominacion' => $_POST["col_oeste_sector"], //4 +
				'Colindante_Oeste_Nombre' => $_POST["col_este_nombre"], //5+
				'Colindante_Oeste_Denominacion' => $_POST["col_este_sector"], //6+
				'idColindenominacion' => $_POST["idColindenominacion"], //5+
				'idDenominacionR' => $_POST["idDenominacionR"], //6+
				'area_terreno' => $_POST["area_terreno"], //7+
				'valor_terreno' => $_POST["valor_terreno"], //7+
				'valor_predio' => $_POST["valor_predio"], //7+
				'tipo_predio' => $_POST["tipo_predio"], //8+
				'uso_predio' => $_POST["uso_predio"], //9+
				'estado_predio' => $_POST["estado_predio"], //10+
				'condicion_predio' => $_POST["condicion_predio"], //12+
				'fecha_adquisicion' => $_POST["fecha_adquisicion"], //17+
				'regimen_inafecto' => $_POST["regimen_inafecto"], //18+
				'idvalcat' => $_POST["idvalcat"], //18+
				'inafecto' => $_POST["inafecto"], //19+
				'tipo_terreno' => $_POST["tipo_terreno"], //20 +
				'uso_terreno' => $_POST["uso_terreno"], //22+
				'expediente' => $_POST["expediente"], //23+
				'observacion' => $_POST["observacion"],
				'id_predio' => $_POST["id_predio"] //24+    	+		        
			);
			$respuesta = ControladorPredio::crtEditarPredioR($datos);
			header('Content-Type: application/json');
			echo json_encode($respuesta);
		}
	}

	//AGREGAR PREDIO RURAL
	public function ajaxAgregarPredioRural()
	{
		$mensaje_error = "";
		if ($_POST["idAnioFiscal"] == 'null') {
			$mensaje_error = "Seleccione un año fiscal";
		
		} elseif (($_POST["tipoDocInscripcion"] == 'null') or ($_POST["tipoDocInscripcion"] == '')) {
			$mensaje_error = "Seleccione Tipo Documento de Inscripcion";
		} elseif (($_POST["areaTerreno"] == 'null') or ($_POST["areaTerreno"] == '') or ($_POST["areaTerreno"] == 0)) {
			$mensaje_error = "Debe Ingresar el area terreno";
		} elseif (($_POST["nroDocIns"] == 'null') or ($_POST["nroDocIns"] == '')) {
			$mensaje_error = "Ingrese Nro Documento Inscripcion";
	    } elseif (($_POST["idCategoriaHectarea"] == 'null') or ($_POST["idCategoriaHectarea"] == '') or ($_POST["idZonaRural"] == 'null') or ($_POST["idZonaRural"] == '')) {
			$mensaje_error = "Debe seleccionar una Calidad Agricola y Zona Rural";
		} elseif ($_POST["areaTerreno"] == 'null') {
			$mensaje_error = "Debe Ingresar el area terreno";
		} elseif (($_POST["nroDocIns"] == 'null') or ($_POST["nroDocIns"] == '')) {
			$mensaje_error = "Ingrese Nro Documento Inscripcion";
		} elseif (($_POST["tipoDocInscripcion"] == 'null') or ($_POST["tipoEscritura"] == 'null') or ($_POST["IdContribuyente"] == 'null')) {
			$mensaje_error = "Debe asignar un propietario";
		} elseif (($_POST["denoSectorR"] == 'null') or ($_POST["denoSectorR"] == '')) {
			$mensaje_error = "Falta la denominacion Rural";
		}
		if (!empty($mensaje_error)) {
			echo $mensaje_error;
		} else {
			$datos = array(
				//1
				'Fecha_Adquisicion' => $_POST["fechaAdqui"], //2//3
				'Area_Terreno' => $_POST["areaTerreno"], //4
				'Valor_Terreno' => $_POST["valorTerreno"], //5 //6 //7
				'Valor_predio' => $_POST["valorPredioAnio"], //8
				'Expediente_Tramite' => $_POST["nroExpediente"], //9
				'Observaciones' => $_POST["observacion"], //10
				'predio_UR' => $_POST["tipoPredioUR"], //11//12
				'Id_Tipo_Predio' => $_POST["tipoPredio"], //13//14
				'Id_Uso_Predio' => $_POST["usoPredio"], //15
				'Id_Estado_Predio' => $_POST["estadoPredio"], //16
				'Id_Regimen_Afecto' => $_POST["regInafecto"], //17
				'Id_inafecto' => $_POST["inafectoPor"], //18//19
				'Id_Condicion_Predio' => $_POST["condicionDuenio"], //20//21 //22
				'Id_Anio' => $_POST["idAnioFiscal"], //23	
				'id_usuario' => $_SESSION['id'], //24	  
				'Id_Uso_Terreno' => $_POST["usoTerreno"], //25
				'Id_Tipo_Terreno' => $_POST["tipoTerreno"], //26            
				//Id_Colindante_Denominacion' se forma
				'Id_Colindante_Propietario ' => $_POST["idColinPropietario"], //28
				'Valor_Inaf_Exo' => $_POST["valInafeExonerado"], //29
				//IdCatastroRural se forma   
				'Numero_Documento_Inscripcion' => $_POST["nroDocIns"], //
				'Fecha_Escritura' => $_POST["fechaEscritura"], //        
				'Id_Documento_Inscripcion' => $_POST["tipoDocInscripcion"], //    
				'Id_Tipo_Escritura' => $_POST["tipoEscritura"], //	
				'Estado_Transferencia' => 'R',  //
				'Id_Contribuyente' => $_POST["IdContribuyente"], //
				'Id_valores_categoria_x_hectarea' => $_POST["idCategoriaHectarea"], //
				'Id_Zona_Rural' => $_POST["idZonaRural"], //
				//---------- 
				'Denominacion_Rural' => $_POST["denoSectorR"], //
				'Id_Denominacion_Rural' => $_POST["idViaurbano"], //          
				'Colindante_Sur_Nombre' => $_POST["colSurNombre"], //
				'Colindante_Sur_Denominacion' => $_POST["colSurSector"], //
				'Colindante_Norte_Nombre' => $_POST["colNorteNombre"], //
				'Colindante_Norte_Denominacion' => $_POST["colNorteSector"], //
				'Colindante_Este_Nombre' => $_POST["colEsteNombre"], //
				'Colindante_Este_Denominacion' => $_POST["colEsteSector"], //
				'Colindante_Oeste_Nombre' => $_POST["colOesteNombre"], //
				'Denominacion' => $_POST["denoSectorR"], //
				'Colindante_Oeste_Denominacion' => $_POST["colOesteSector"], //
			);
			$respuesta = ControladorPredio::ctrCrearPredioR($datos);
			echo $respuesta;
		}
	}

	// BUSCAR CONTRIBUYENTE PARA REGISTRO PREDIO
	public function ajaxBuscarContribuyente($numeroDoc)
	{
		$valor = $numeroDoc;
		$respuesta = ControladorPredio::ctrBucarContribuyente($valor);
		// echo json_encode($respuesta);
		$i = 0;
		foreach ($respuesta as $k => $v) {
			$i++;
			echo '<legend style="margin:0px !important; padding:0px !important; font-size: 17px;"><a href="#" class="btnadd" idCliente="' . $v['Id_Contribuyente'] . '" > ' . $v['Id_Contribuyente'] . ' - ' . $v['Documento'] . ' - <b style="font-size: 13px; color: #444; font-weight: 600; letter-spacing: 1px;">' . $v['Nombres'] . ' ' . $v['Apellido_Paterno'] . ' ' . $v['Apellido_Materno'] . '</b></a></legend>';
		}
	}

		// BUSCAR ELIMINAR ORDEN DE PAGO
		public function ajaxEliminarOrdenPago()
		{
			
			$datos = array(
				'anio' => $_POST["anio"],
				'id_selecionado' => $_POST["numero_orden_seleccionado_e"]
			);
			
			// Para depuración: Ver el valor recibido
			//echo "<pre>llegaste aquí con el número de orden: " .$datos['id_selecionado'] . "</pre>";
    
			$respuesta = ControladorPredio::ctrEliminarOrdenPago($datos);
			echo json_encode($respuesta);
			$i = 0;
			foreach ($respuesta as $k => $v) {
				$i++;
				echo '<legend style="margin:0px !important; padding:0px !important; font-size: 17px;"><a href="#" class="btnadd" idCliente="' . $v['Id_Contribuyente'] . '" > ' . $v['Id_Contribuyente'] . ' - ' . $v['Documento'] . ' - <b style="font-size: 13px; color: #444; font-weight: 600; letter-spacing: 1px;">' . $v['Nombres'] . ' ' . $v['Apellido_Paterno'] . ' ' . $v['Apellido_Materno'] . '</b></a></legend>';
			}
		}
	

	//TRANSFERIR PREDIO A NUEVOS PROPIETARIOS
	public function ajaxTransferirPredio()
	{
		$mensaje_error = "";
		if ($_POST["tipo_documento"] === 'null') {
			$mensaje_error = "Seleccione el Documento de Inscripcion";
		} elseif (empty($_POST["n_documento"])) {
			$mensaje_error = "Ingrese el Número de  documento";
		} elseif ($_POST["tipo_escritura"] === 'null') {
			$mensaje_error = "Seleccione el Tipo de Documento";
		} elseif (empty($_POST["fecha_escritura"])) {
			$mensaje_error = "Registre la fecha del documento";
		} elseif (empty($_POST["propietarios_nuevos"])) {
			$mensaje_error = "Seleccione  al Nuevo Propietario";
		}
		if (!empty($mensaje_error)) {

			$respuesta = array(
				'tipo' => 'error',
				'mensaje' => '<div class="alert warning">
			    <input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
		        <span aria-hidden="true" class="letra">×</span>
	            </button><p class="inner"><strong class="letra">Advertencia!</strong> <span class="letra">' . $mensaje_error . '</span></p></div>'
			);

			$respuesta_json = json_encode($respuesta);
			header('Content-Type: application/json');
			echo $respuesta_json;
		} else {
			$datos = array(
				'propietarios_antiguos' => $_POST["propietarios_antiguos"],
				'catastro' => $_POST["catastro"],
				'tipo' => $_POST["tipo"],
				'anio' => $_POST["anio"],
				'propietarios' => $_POST["propietarios_nuevos"],
				'tipo_documento' => $_POST["tipo_documento"],
				'n_documento' => $_POST["n_documento"],
				'tipo_escritura' => $_POST["tipo_escritura"],
				'fecha_escritura' => $_POST["fecha_escritura"],
				'confirmar' => $_POST["confirmar"]
			);
			$respuesta = ControladorPredio::ctrTransferirPredio($datos);
			$respuesta_json = json_encode($respuesta);
			header('Content-Type: application/json');
			echo $respuesta_json;
		}
	}

	//COPIAR PREDIO A OTROS AÑOS

	public function ajaxCopiarPredio()
{
    if (empty($_POST["predios"]) || $_POST["anio_copiar"] == NULL) {
        $respuesta = array(
            'tipo' => 'error',
            'mensaje' => 'Faltan datos requeridos.'
        );
        $respuesta_json = json_encode($respuesta);
        header('Content-Type: application/json');
        echo $respuesta_json;
    } else {
        // Decodificar el JSON de 'predios'
        $predios = json_decode($_POST["predios"], true);  // 'true' para convertir a array asociativo

        // Verificar si la decodificación fue exitosa
        if (json_last_error() !== JSON_ERROR_NONE) {
            $respuesta = array(
                'tipo' => 'error',
                'mensaje' => 'Error en los datos de predios.'
            );
            $respuesta_json = json_encode($respuesta);
            header('Content-Type: application/json');
            echo $respuesta_json;
            return;
        }

        // Recoger otros datos
        // $anio_actual = $_POST["anio_actual"];
        // $anio_copiar = $_POST["anio_copiar"];
        // $propietarios = $_POST["propietarios"];
        // $tipo = $_POST["tipo"];
        // $forzar_copear = $_POST["forzar"];

        // Procesar y registrar cada predio individualmente
       foreach ($predios as $predio) {
    // Procesar cada predio
    $id_predio = $predio['id_predio'];
    $id_catastro = $predio['id_catastro'];
	 $tipo = $predio['tipo'];

    // Aquí llamas a tu método para registrar el predio
    $datos = array(
        'id_predio' => $id_predio,
        'anio_actual' => $_POST["anio_actual"],  // Asegúrate de que no sea null
        'anio_copiar' => $_POST["anio_copiar"],
        'propietarios' => $_POST["propietarios"],
			'id_catastro' => $id_catastro,
			'tipo' => $tipo,
			'forzar_copear' => $_POST["forzar"]
		);

		// Llamada al controlador para registrar el predio
		$registro = ControladorPredio::ctrCopiarPredio($datos);
		//  var_dump($registro);
		//  exit();

		if (!$registro) {
			$respuesta = array(
				'tipo' => 'error',
				'mensaje' => 'Error al registrar el predio con ID: ' . $id_predio
			);
			$respuesta_json = json_encode($respuesta);
			header('Content-Type: application/json');
			echo $respuesta_json;
			return;
		}

		
	}


        // Si todo salió bien, enviamos una respuesta de éxito
        $respuesta = array(
            'tipo' => 'success',
            'mensaje' => '<div class="alert success">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
				<span aria-hidden="true" class="letra">×</span>
				</button><p class="inner"><strong class="letra">Exito!</strong> 
				<span class="letra">Se ha copiado los predios correctamente mmm</span></p></div>'
        );

        $respuesta_json = json_encode($respuesta);
        header('Content-Type: application/json');
        echo $respuesta_json;
    }
}


	// public function ajaxCopiarPredio()
	// {
	// 	if ($_POST["id_predio"] == '' or $_POST["anio_copiar"] == NULL) {
	// 		$respuesta = array(
	// 			'tipo' => 'error',
	// 			'mensaje' => 'hola'
	// 		);
	// 		$respuesta_json = json_encode($respuesta);
	// 		header('Content-Type: application/json');
	// 		echo $respuesta_json;
	// 	} else {
	// 		$datos = array(
	// 			'id_predio' => $_POST["id_predio"],
	// 			'anio_actual' => $_POST["anio_actual"],
	// 			'anio_copiar' => $_POST["anio_copiar"],
	// 			'propietarios' => $_POST["propietarios"],
	// 			'id_catastro' => $_POST["id_catastro"],
	// 			'tipo' => $_POST["tipo"],
	// 			'forzar_copear' => $_POST["forzar"]
	// 		);
	// 		$respuesta = ControladorPredio::ctrCopiarPredio($datos);
	// 		$respuesta_json = json_encode($respuesta);
	// 		header('Content-Type: application/json');
	// 		echo $respuesta_json;
	// 	}
	// }

	//CONDICIONAR ANIO PARA COPIAR
	public function ajaxCondicionAnio()
	{
		$datos = array(
			'anio' => $_GET["anio"]
		);
		$respuesta = ControladorPredio::ctrCondicionCopiarPredio($datos);
		echo $respuesta;
	}
	//ELIMINAR PREDIO
	public function ajaxEliminarPredio()
	{
		if (empty($_POST["documento"])) {
			$respuesta = array(
				"tipo" => "error",
				"mensaje" => '<div class="alert warning">
				<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
			<span aria-hidden="true" class="letra">×</span>
		    </button><p class="inner"><strong class="letra">Cuidado!</strong> <span class="letra">Ingrese un sustento para eliminar el Predio</span></p></div>'
			);
			$respuesta_json = json_encode($respuesta);
			header('Content-Type: application/json');
			echo $respuesta_json;
		} else {
			$datos = array(
				'documento' => $_POST["documento"],
				'id_predio' => $_POST["id_predio"],
				'id_usuario' => $_SESSION['id']
			);
			$respuesta = ControladorPredio::ctrEliminarPredio($datos);
			$respuesta_json = json_encode($respuesta);
			header('Content-Type: application/json');
			echo $respuesta_json;
		}
	}
	// CONTRIBUYENTES PARA IMPUESTO
	public function ajaxPredio_impuesto()
	{
		$datos = $_POST['idContribuyente_impuesto'];
		$anio = $_POST['selectnum'];
		$predios_arbitrio = $_POST['lista_predio_arbitrios'];


		$respuesta = ControladorPredio::ctrPredio_impuesto($datos, $anio, $predios_arbitrio);
		echo $respuesta;
	}
	public function ajaxMostrarPredio()
	{
		$datos = $_POST['idPredio'];
		$respuesta = ControladorPredio::crtMostrarPredio($datos);
		$respuesta = json_encode($respuesta);
		echo $respuesta;
	}
	public function ajaxMostrarDetalleTransferencia()
	{
		$datos = $_POST['idPrediodocument'];
		$respuesta = ControladorPredio::crtMostrarPropietarios($datos);
		$respuesta = json_encode($respuesta);
		echo $respuesta;
	}
	public function ajaxmostrar_foto_carrusel()
	{
		$id_predio = $_POST['id_predio'];
		$respuesta = ControladorPredio::crtMostrar_foto_carrusel($id_predio);
		header('Content-Type: application/json');
        echo json_encode($respuesta);
	}

	//MODAL IMAGEN
	public function ajaxmostrar_foto_carrusel_modal()
	{
		$id_predio = $_POST['id_predio'];
		$respuesta = ControladorPredio::crtMostrar_foto_carrusel_modal($id_predio);
		header('Content-Type: application/json');
        echo json_encode($respuesta);
	}
	
	public function ajaxfoto_guardar()
    {
			if (!isset($_FILES['images'])) {
				$respuesta = array(
					"tipo" => "error",
					"mensaje" => '<div class="alert warning">
					<input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
				<span aria-hidden="true" class="letra">×</span>
				</button><p class="inner"><strong class="letra">Cuidado!</strong> <span class="letra">Cargue alguna imagen correspondiente al predio seleccionado</span></p></div>'
				);
			
			}
		else{
			$datos = $_FILES['images'];
			$id_predo = $_POST['id_predio'];
			$respuesta = ControladorPredio::crtGuardarfoto($datos,$id_predo);
		}
			$respuesta_json = json_encode($respuesta);
			header('Content-Type: application/json');
			echo $respuesta_json;
    }

	public function ajaxAgregar_ContribuyentePredio()
    {	
		$string1 = $_POST['contribuyentes'];
       	$stringSinComillas1 = trim($string1, '"');
       	$contribuyentes = explode(',', $stringSinComillas1);
		$string2 = $_POST['predios'];
       	$stringSinComillas2 = trim($string2, '"');
		
       	$predios = explode(',', $stringSinComillas2);
		$id_propietario = $_POST['id_propietario'];
		$carpeta = $_POST['carpeta'];
		$respuesta = ControladorPredio::crtAgregar_ContribuyentePredio($contribuyentes,$predios,$id_propietario,$carpeta);
		echo json_encode($respuesta);
    }
}
//ELIMINAR ORDEN PAGO

if (isset($_POST["eliminar_orden_pago"])) {
	$transferir_predio = new AjaxPredio();
	$transferir_predio->ajaxEliminarOrdenPago();
}
// OBJETO TRASNFERIR PREDIO
if (isset($_POST["transferir_predio"])) {
	$transferir_predio = new AjaxPredio();
	$transferir_predio->ajaxTransferirPredio();
}

// OBJETO ELIMINAR PREDIO
if (isset($_POST["eliminar_predio"])) {
	$eliminar_predio = new AjaxPredio();
	$eliminar_predio->ajaxEliminarPredio();
}
// OBJETO AGREGAR PREDIO URBANO
if (isset($_POST["predioUrbano"])) {
	$nuevo = new AjaxPredio();
	$nuevo->ajaxAgregarPredio();
}
// OBJETO AGREGAR PREDIO RUSTICO
if (isset($_POST["predioRural"])) {
	$nuevo = new AjaxPredio();
	$nuevo->ajaxAgregarPredioRural();
}
// OBJETO COPIAR PREDIO
if (isset($_POST["anio_copiar"])) {
	$copiar = new AjaxPredio();
	$copiar->ajaxCopiarPredio();
}
// OBJETO CONDICIONAR AÑO A COPIAR
if (isset($_GET["condicion_anio"])) {
	$copiar = new AjaxPredio();
	$copiar->ajaxCondicionAnio();
}
// BUSCAR CONTRIBUYENTE PARA COMPROBANTE
if (isset($_POST['numeroDoc'])) {
	$existeCliente = new AjaxPredio();
	//$existeCliente->numeroDoc = $_POST['numDocumento'];
	$existeCliente->ajaxBuscarContribuyente(trim($_POST['numeroDoc']));
}
// OBJETO CALCULAR IMPUESTO
if (isset($_POST['idContribuyente_impuesto'])) {
	$Predio = new AjaxPredio();
	$Predio->ajaxPredio_impuesto();
}
// EDITAR PREDIO
if (isset($_POST['editarPredio'])) {
	$predio = new AjaxPredio();
	$predio->ajaxMostrarPredio();
}
// DETALLE TRANFERENCIA
if (isset($_POST['IdDetTransferencia'])) {
	$predio = new AjaxPredio();
	$predio->ajaxMostrarDetalleTransferencia();
}

// Editar predio Urbano
if (isset($_POST['predioUrbanoE'])) {
	$predio = new AjaxPredio();
	$predio->ajaxCambiosPredio();
}
// Editar predio Rustico
if (isset($_POST['predio_rural_E'])) {
	$predio = new AjaxPredio();
	$predio->ajaxcambios_editar_predio_R();
}
if (isset($_POST['foto_guardar'])) {
	$predio = new AjaxPredio();
	$predio->ajaxfoto_guardar();
}
if (isset($_POST['mostrar_foto_carrusel'])) {
	$predio = new AjaxPredio();
	$predio->ajaxmostrar_foto_carrusel();
}

if (isset($_POST['mostrar_foto_carrusel_modal'])) {
	$predio = new AjaxPredio();
	$predio->ajaxmostrar_foto_carrusel_modal();
}

if (isset($_POST['agregar_ContribuyentePredio'])) {
	$predio = new AjaxPredio();
	$predio->ajaxAgregar_ContribuyentePredio();
}