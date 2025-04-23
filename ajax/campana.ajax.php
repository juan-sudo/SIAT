<?php
session_start();
require_once "../vendor/autoload.php";
use Controladores\ControladorCampana;
use Modelos\ModeloCampana;
class AjaxCampana
{
    public function ajaxAgregarCampana()
    {
        $datos = array(
            'Id_Anio' => $_POST["anioCampana"],
            'Id_Arbitrios' => 1,
            'Id_Uso_Predio' => $_POST["usoPredioCampana"],
            'Porcentaje' => $_POST["porcentajeDescuento"],
            'Fecha_Inicio' => $_POST["fechaIniCampana"],
            'Fecha_Fin' => $_POST["fechaFinCampana"],
            'Documento' => $_POST["numInstrumentoCampana"], 
            'estado_descuento' => 0,
            'descripcion_descuento' => $_POST["nombreCampana"],
            'tipo_descuento' => $_POST["tipoCampana"]
        );
        $respuesta = ControladorCampana::ctrCrearCampana($datos);
        echo $respuesta;
    }
    public $activarUsuario;
    public $activarId;
    public $idUsuario;
    public function ajaxActivarDescuento()
    {
        $tabla = 'descuento';
        $item1 = 'estado_descuento';
        $valor1 = $this->activarUsuario;// 0 - 1
        $item2 = 'Id_Descuento';
        $valor2 = $this->activarId; // id registro
        $respuesta = ControladorCampana::crtActualizarEstadoCampana($tabla, $item1, $valor1, $item2, $valor2);
        $respuesta_json = json_encode($respuesta);
        header('Content-Type: application/json');
        echo $respuesta_json;    
    }
    public function ajaxEditarCampana()
    {
        $item = 'Id_Descuento';
        $valor = $this->idUsuario;
        $respuesta = ControladorCampana::ctrMostrarCampana($item, $valor);
        echo json_encode($respuesta);
    }
}
// OBJETO AGREGAR 
if (isset($_POST['registrarCampana'])) {
    $nuevo = new AjaxCampana();
    $nuevo->ajaxAgregarCampana();
}
// OBJETO ACTIVAR 
if (isset($_POST['activar_descuento'])) {
    $activarUsuario = new AjaxCampana();
    $activarUsuario->activarId = $_POST['activarId'];
    $activarUsuario->activarUsuario = $_POST['activarUsuario'];
    $activarUsuario->ajaxActivarDescuento();
}
// OBJETO EDITAR 
if (isset($_POST['idDescuento'])) {
    $editar = new AjaxCampana();
    $editar->idUsuario = $_POST['idDescuento'];
    $editar->ajaxEditarCampana();
}
