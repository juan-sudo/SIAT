<?php
require_once "../vendor/autoload.php";

use Controladores\ControladorDireccion;

class AjaxDirecion
{
	public function ajaxRegistrarDireccion()
	{
		$datos = array(
			'Id_Tipo_Via' => $_POST["tipoVia"], //2
			'Id_Zona' => $_POST["zonaSel"], //3
			'Id_Nombre_Via' => $_POST["nombreVia"], //5
		);
		$respuesta = ControladorDireccion::ctrCrearDireccion($datos);
		echo $respuesta;
	}
	// EDITAR USARIO|
	public $idUsuario;
	public function ajaxEditarDireccion()
	{
		$item = 'Id_Direccion';
		$valor = $this->idUsuario;
		$respuesta = ControladorDireccion::ctrMostrarDirecciones($item, $valor);
		echo json_encode($respuesta);
	}
}
// Registrar Direccion
if (isset($_POST["nombreVia"])) {
	$nuevaDireccion = new AjaxDirecion();
	$nuevaDireccion->ajaxRegistrarDireccion();
}
//editar
if (isset($_POST['idDireccion'])) {
	$editar = new AjaxDirecion();
	$editar->idUsuario = $_POST['idDireccion'];
	$editar->ajaxEditarDireccion();
}
