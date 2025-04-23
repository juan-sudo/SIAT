<?php
session_start();
require_once "../vendor/autoload.php";

use Controladores\ControladorEspecievalorada;
use Modelos\ModeloEspecievalorada;

class AjaxEspecievalorada
{
    public function ajaxAgregarEspecievalorada()
    {
        $datos = array(
            'Monto' => $_POST["monto_especie"],
            'Estado' =>1,
            'Id_Area' => $_POST["id_area"],
            'Id_Presupuesto' => $_POST["id_presupuesto"],
            'Id_Instrumento_Gestion' => $_POST["id_instrumento"],
            'Detalle' => $_POST["detalle_instrumento"],
            'Nombre_Especie' => $_POST["nombre_especie"],
            'Numero_Pagina' => $_POST["numPagina"],
            'requisito' => $_POST["requisitos"]
        );              
        $respuesta = ControladorEspecievalorada::ctrCrearEspecievalorada($datos);
        echo $respuesta;  
    }
    public $idUsuario;
    public function ajaxEditarEspecievalorada()
    {
        $item = 'Id_Especie_Valorada';
        $valor = $this->idUsuario;
        $respuesta = ControladorEspecievalorada::ctrMostrarEspecievalorada($item, $valor);
        echo json_encode($respuesta);
    }
    public $activarUsuario;
    public $activarId;
    public function ajaxActivarEspecievalorada()
    {
        $tabla = 'especie_valorada';
        $item1 = 'Estado';
        $valor1 = $this->activarUsuario;
        $item2 = 'Id_Especie_Valorada';
        $valor2 = $this->activarId;

        $respuesta = ModeloEspecievalorada::mdlActualizarEstadoEspecievalorada($tabla, $item1, $valor1, $item2, $valor2);
        echo $respuesta;
    }
    public $validarUsuario;
    public function ajaxValidarEspecie()
    {
        $item = 'usuario';
        $valor = $this->validarUsuario;
        $respuesta = ModeloEspecievalorada::mdlMostrarData($item, $valor);
        echo json_encode($respuesta);
    } 
}
// OBJETO AGREGAR USUARIO
if (isset($_POST['nombre_especie'])) {
    $nuevo = new AjaxEspecievalorada();
    $nuevo->ajaxAgregarEspecievalorada();
}
// OBJETO EDITAR USUARIO
if (isset($_POST['idEspecie'])) {
    $editar = new AjaxEspecievalorada();
    $editar->idUsuario = $_POST['idEspecie'];
    $editar->ajaxEditarEspecievalorada();
}
// OBJETO ACTIVAR USUARIO
if (isset($_POST['activarUsuario'])) {
    $activarUsuario = new AjaxEspecievalorada();
    $activarUsuario->activarId = $_POST['activarId'];
    $activarUsuario->activarUsuario = $_POST['activarUsuario'];
    $activarUsuario->ajaxActivarEspecievalorada();
}
// OBJETO VALIDAR NO REPETIR USUARIO
if (isset($_POST['validarUsuario'])) {
    $validarUsuario = new AjaxUsuarios();
    $validarUsuario->validarUsuario = $_POST['validarUsuario'];
    $validarUsuario->ajaxValidarUsuario();
}
/*/ OBJETO VALIDAR NO REPETIR USUARIO
if (isset($_POST['dni'])) {
    $objDni = new AjaxUsuarios();
    $objDni->dni = $_POST['dni'];
    $objDni->ajaxBuscarDni();
}*/