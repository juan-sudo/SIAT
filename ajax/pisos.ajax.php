<?php
require_once "../vendor/autoload.php";

use Controladores\ControladorPisos;

class AjaxPisos
{
	public $datos;
	public function ajaxMostrarValoresEdeificacio()
	{
		$valores = $this->datos;
		$tabla = 'valores_edificacion';
		$respuesta = ControladorPisos::ctrMostrarValoresEdficacion($tabla, $valores);
		echo $respuesta[0];
	}
	public function ajaxMostrarTasaDepreciacion()
	{
		$valores = $this->datos;
		$respuesta = ControladorPisos::ctrMostrarTasaDepresiacion($valores);
		echo $respuesta;
	}
	public function ajaxRegistrarPiso()
	{
		$mensaje_error = "";
		if ($_POST["estadoConservaImp"] === 'null') {
			$mensaje_error = "Seleccione un estado de conservacion";
		} elseif ($_POST["clasificaPisoImp"] === 'null') {
			$mensaje_error = "Seleccione una clasificacion del piso";
		} elseif ($_POST["materialConsImp"] === 'null') {
			$mensaje_error = "Seleccione el material predominante";
		} elseif (($_POST["murosColumnas"] === 'null') or ($_POST["techos"] == 'null') or ($_POST["puertasVentanas"] == 'null')) {
			$mensaje_error = "Complete los valores unitarios de Edificaion";
		} elseif (($_POST["depresiacionInp"] === 'null') or ($_POST["valUniDepreciadoImp"] == 'null') or ($_POST["depresiacionInp"] == 'null')) {
			$mensaje_error = "Debe <STRONG>DEPRECIAR</STRONG> el Piso";
		} elseif ($_POST["areaConstruidaImp"] === 'null') {
			$mensaje_error = "Ingresar el área de construcción";
		}
		if (!empty($mensaje_error)) {
			$respuesta = array(
				'tipo' => 'error',
				'mensaje' => '<div class="alert warning">
          <input type="checkbox" id="alert1"/> <button type="button" class="close" aria-label="Close">
          <span aria-hidden="true" class="letra">×</span>
          </button><p class="inner"><strong class="letra">Cuidado!</strong> <span class="letra">' . $mensaje_error .'</span></p></div>'
			);
			$respuesta_json = json_encode($respuesta);
			header('Content-Type: application/json');
			echo $respuesta_json;
		} else {
			$datos = array(
				'Catastro_Piso' => $_POST["idCatastroRow"], //2
				'Numero_Piso' => $_POST["numeroPiso"], //3
				'Incremento' => 0, //4 se esta investigando que valor va 
				'Fecha_Construccion' => $_POST["fechaAntiguedad"], //5
				'Cantidad_Anios' => $_POST["cantidadAños"], //6 se calccula en el js 
				'Valores_Unitarios' => $_POST["valUnitariosCal"], //7
				'Incrementos' => 0, //8 se esta investigando que valor va 
				'Porcentaje_Depreciacion' => $_POST["tasaDepreCal"], //9
				'Valor_Unitario_Depreciado' => $_POST["valUniDepreciadoImp"], //10
				'Area_Construida' => $_POST["areaConstruidaImp"], //11
				'Valor_Area_Construida' => $_POST["valorAreaConstruImp"], //12
				'Areas_Comunes' => $_POST["areaComunesImp"], //13
				'Valor_Areas_Comunes' => $_POST["valorAreComunImp"], //14
				'Valor_Construida' => $_POST["valorConstrucionCal"], //15
				//'Fecha_Registro' => $_POST["nroBloque"],// se registra la fecha del sistema
				'Id_Estado_Conservacion' => $_POST["estadoConservaImp"], //17
				'Id_Clasificacion_Piso' => $_POST["clasificaPisoImp"], //17
				'Id_Material_Piso' => $_POST["materialConsImp"], //17
				'idAnioFiscal' => $_POST["idAnioFiscal"], //17
				'murosColumnas' => $_POST["murosColumnas"], //18
				'techos' => $_POST["techos"], //19
				'puertasVentanas' => $_POST["puertasVentanas"], //20
				'Categorias_Edificacion' => $_POST["letrasValorEdica"] //2111
			);

			$respuesta = ControladorPisos::ctrCrearPiso($datos);
			$respuesta_json = json_encode($respuesta);
			header('Content-Type: application/json');
			echo $respuesta_json;
		}
	}
	public function ajaxModificarPiso()
	{
		$mensaje_error = "";
		if ($_POST["estadoConservaImp"] == 'null') {
			$mensaje_error = "Seleccione un estado de conservacion";
		} elseif ($_POST["clasificaPisoImp"] == 'null') {
			$mensaje_error = "Seleccione una clasificacion del piso";
		} elseif ($_POST["materialConsImp"] == 'null') {
			$mensaje_error = "Seleccione el material predominante";
		} elseif (($_POST["murosColumnas"] == 'null') or ($_POST["techos"] == 'null') or ($_POST["puertasVentanas"] == 'null')) {
			$mensaje_error = "Complete los valores unitarios de Edificaion";
		} elseif (($_POST["depresiacionInp"] == 'null') or ($_POST["valUniDepreciadoImp"] == 'null') or ($_POST["depresiacionInp"] == 'null')) {
			$mensaje_error = "Debe depreciar el Piso";
		} elseif ($_POST["areaConstruidaImp"] == 'null') {
			$mensaje_error = "Ingresar el área de construcción";
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
				'Id_Piso' => $_POST["idPidoEdit"], //1
				'Catastro_Piso' => $_POST["idCatastroRow"], //2
				'Numero_Piso' => $_POST["numeroPiso"], //3
				'Incremento' => 0, //4 se esta investigando que valor va 
				'Fecha_Construccion' => $_POST["fechaAntiguedad"], //5
				'Cantidad_Anios' => $_POST["cantidadAños"], //6 se calccula en el js 
				'Valores_Unitarios' => $_POST["valUnitariosCal"], //7
				'Incrementos' => 0, //8 se esta investigando que valor va 
				'Porcentaje_Depreciacion' => $_POST["tasaDepreCal"], //9
				'Valor_Unitario_Depreciado' => $_POST["valUniDepreciadoImp"], //10
				'Area_Construida' => $_POST["areaConstruidaImp"], //11
				'Valor_Area_Construida' => $_POST["valorAreaConstruImp"], //12
				'Areas_Comunes' => $_POST["areaComunesImp"], //13
				'Valor_Areas_Comunes' => $_POST["valorAreComunImp"], //14
				'Valor_Construida' => $_POST["valorConstrucionCal"], //15
				//'Fecha_Registro' => $_POST["nroBloque"],// se registra la fecha del sistema
				'Categorias_Edificacion' => $_POST["letrasValorEdica"], //17
				'Id_Estado_Conservacion' => $_POST["estadoConservaImp"], //18
				'Id_Clasificacion_Piso' => $_POST["clasificaPisoImp"], //19
				'Id_Material_Piso' => $_POST["materialConsImp"], //20
				'Id_Predio' => $_POST["IdPredio"], //21
				'idAnioFiscal' => $_POST["idAnioFiscal"], //
				'IdMurosColumnas' => $_POST["murosColumnas"], //
				'IdTechos' => $_POST["techos"], //
				'IdPuertaspuertasVentanas' => $_POST["puertasVentanas"] // 		
			);
			$respuesta = ControladorPisos::ctrModificarPiso($datos);
			$respuesta_json = json_encode($respuesta);
			header('Content-Type: application/json');
			echo $respuesta_json;
		}
	}
	public function ajaxEliminarPiso()
	{
		$datos = array(
			'Id_Piso' => $_POST["idPidoEdit"],
			'eliminar_piso' => $_POST["eliminar_piso"]
		);
		$pisoResultado = ControladorPisos::ctrEliminarPiso($datos);
		echo json_encode($pisoResultado);
	}
	public function ajaxMostrarPisosdelPredio()
	{  error_reporting(0);
		if (($_POST["p1"] === 'vacio')) {
			echo '<tr>
								<td class="text-center"></td>
								<td class="text-center"></td>
								<td class="text-center"></td>
								<td class="text-center"></td>
								<td class="text-center"></td> 
								<td class="text-center"></td>';
			echo '</tr>';
		} else {
			$datos = array(
				'Catastro_Piso' => $_POST["p1"],
				'Id_Anio' => $_POST["p2"]
			);

			$respuesta = ControladorPisos::ctrMostrarPisosDelPredio($datos);
			if ($respuesta!= 'nulo') {
				echo json_encode($respuesta);
			} else {
				echo  'pisovacio';
			}
		}
	}
	public function ajaxTraerInfoPiso()
	{
		$datos = array(
			'Id_Piso' => $_POST["idPiso"]
		);
		$pisoResultado = ControladorPisos::ctrTraerpiso($datos);
		echo json_encode($pisoResultado);
	}
}
//======================================================
//======== Trae los valores de edificación
if (isset($_POST["parametro"])) {
	$parametros = new AjaxPisos();
	$parametros->datos = array(
		'Id_Categoria' => $_POST["categoria"],
		'nomAnio' => $_POST["anio"],
		'Id_Parametro' => $_POST["parametro"]
	);
	$parametros->ajaxMostrarValoresEdeificacio();
}
//======== Trae valor tasa depreciacion
if (isset($_POST["f1"])) {
	$parametros = new AjaxPisos();
	$parametros->datos = array(
		'Id_Anio_Antiguedad' => $_POST["f1"],
		'Id_Material_Piso' => $_POST["f2"],
		'Id_Clasificacion_Piso' => $_POST["f3"],
		'Id_Estado_Conservacion' => $_POST["f4"]
	);
	$parametros->ajaxMostrarTasaDepreciacion();
}
//======== Registrar Pisos
if (isset($_POST["registrar_piso"])) {
	$nuevoPiso = new AjaxPisos();
	$nuevoPiso->ajaxRegistrarPiso();
}
//======== Mostrar Pisos del Predio
if (isset($_POST["p1"])) {
	$nuevoPiso = new AjaxPisos();
	$nuevoPiso->ajaxMostrarPisosdelPredio();
}
//======== Mostrar Un Piso 
if (isset($_POST["idPiso"])) {
	$nuevoPiso = new AjaxPisos();
	$nuevoPiso->ajaxTraerInfoPiso();
}
//======= Modificar Piso
if (isset($_POST["editar_piso"])) {
	$pisoEdit = new AjaxPisos();
	$pisoEdit->ajaxModificarPiso();
}
//======= Eliminar Piso
if (isset($_POST["eliminar_piso"])) {
	$pisoEdit = new AjaxPisos();
	$pisoEdit->ajaxEliminarPiso();
}
